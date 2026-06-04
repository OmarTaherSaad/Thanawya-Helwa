<?php

namespace App\Console\Commands;

use App\Support\Tansik\DigitalGovCoordinationLimitCatalog;
use App\Support\Tansik\DigitalGovCoordinationLimitImporter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Throwable;

/**
 * Downloads the Thanawya coordination portal and Limit*.htm for offline import.
 * Run on any machine that can reach tansik.digital.gov.eg; upload the directory
 * to a restricted host and run {@see ImportTansikDigitalGovernmentCoordinationLimitsCommand}
 * with --portal-file and --limits-dir.
 */
class PullTansikDigitalGovernmentCoordinationLimitsCommand extends Command
{
    protected $signature = 'tansik:pull-government-coordination-limits
                            {output_dir : Directory to create and fill with portal.html and Limit*.htm}
                            {--from-year=2011 : First admission year to download}
                            {--to-year= : Last admission year (default: current calendar year)}
                            {--no-older-candidates : Skip «أقدم» tables (Limit*O*.htm)}
                            {--portal-url= : Override portal HTML URL}';

    protected $description = 'Download coordination portal + Limit*.htm from tansik.digital.gov.eg into a folder for offline import on hosts without egress.';

    public function handle(): int
    {
        $outputDir = (string) $this->argument('output_dir');
        $outputDir = rtrim($outputDir, '/\\');
        $portalUrl = $this->option('portal-url') ?: DigitalGovCoordinationLimitCatalog::PORTAL_URL;
        $fromYear = max(1990, (int) $this->option('from-year'));
        $toYear = $this->option('to-year') !== null && $this->option('to-year') !== ''
            ? (int) $this->option('to-year')
            : (int) date('Y');
        $toYear = max($fromYear, $toYear);
        $includeOlder = ! $this->option('no-older-candidates');

        try {
            if (! File::exists($outputDir)) {
                File::makeDirectory($outputDir, 0755, true);
            }
        } catch (Throwable $e) {
            $this->error('Could not create output directory: '.$e->getMessage());

            return self::FAILURE;
        }

        $resolved = realpath($outputDir);
        if ($resolved === false || ! is_dir($resolved) || ! is_writable($resolved)) {
            $this->error('Output directory is not a writable directory: '.$outputDir);

            return self::FAILURE;
        }
        $outputDir = $resolved;

        $this->info('Output: '.$outputDir);
        $this->info('Portal: '.$portalUrl);

        try {
            $portalHtml = DigitalGovCoordinationLimitImporter::http()
                ->get($portalUrl)
                ->throw()
                ->body();
        } catch (Throwable $e) {
            $this->error('Failed to download portal: '.$e->getMessage());

            return self::FAILURE;
        }

        $portalPath = $outputDir.DIRECTORY_SEPARATOR.DigitalGovCoordinationLimitCatalog::PULLED_PORTAL_FILENAME;
        File::put($portalPath, $portalHtml);

        $catalog = new DigitalGovCoordinationLimitCatalog;
        $items = $catalog->discoverFromPortalHtml($portalHtml);
        if ($items === []) {
            $this->warn('No Limit*.htm links found in portal HTML — only saved portal file.');

            return self::SUCCESS;
        }

        $filtered = array_values(array_filter($items, function (array $item) use ($fromYear, $toYear, $includeOlder): bool {
            if ($item['year'] < $fromYear || $item['year'] > $toYear) {
                return false;
            }
            if (! $includeOlder && $item['is_older_candidates']) {
                return false;
            }

            return true;
        }));

        usort($filtered, function (array $a, array $b): int {
            return [$a['year'], $a['section'], $a['is_older_candidates'] ? 1 : 0]
                <=> [$b['year'], $b['section'], $b['is_older_candidates'] ? 1 : 0];
        });

        $this->info('Downloading '.count($filtered).' limit file(s).');

        foreach ($filtered as $item) {
            $basename = basename(parse_url($item['path'], PHP_URL_PATH) ?? '');
            $target = $outputDir.DIRECTORY_SEPARATOR.$basename;
            try {
                $body = DigitalGovCoordinationLimitImporter::http()
                    ->get($item['path'])
                    ->throw()
                    ->body();
            } catch (Throwable $e) {
                $this->error($basename.' — '.$e->getMessage());

                return self::FAILURE;
            }
            File::put($target, $body);
            $this->line('  '.$basename);
        }

        $this->newLine();
        $this->info('Saved portal: '.DigitalGovCoordinationLimitCatalog::PULLED_PORTAL_FILENAME);
        $this->line('On the app host (no ministry egress), run e.g.:');
        $this->line('  php artisan tansik:import-government-coordination-limits \\');
        $this->line('    --portal-file='.escapeshellarg($portalPath).' \\');
        $this->line('    --limits-dir='.escapeshellarg($outputDir));

        return self::SUCCESS;
    }
}
