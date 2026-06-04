<?php

namespace App\Console\Commands;

use App\Support\Tansik\DigitalGovCoordinationLimitCatalog;
use App\Support\Tansik\DigitalGovCoordinationLimitImporter;
use Illuminate\Console\Command;
use Throwable;

/**
 * Imports official coordination limits published under the Thanawya section of tansik.digital.gov.eg.
 *
 * Source page (portal with links to static tables):
 * {@see DigitalGovCoordinationLimitCatalog::PORTAL_URL}
 *
 * If the server cannot open TCP to tansik.digital.gov.eg, pull assets elsewhere using
 * {@see PullTansikDigitalGovernmentCoordinationLimitsCommand}, upload the folder, then pass
 * --portal-file and --limits-dir (or set TANSIK_DIGITAL_GOV_IMPORT_LIMITS_DIR).
 */
class ImportTansikDigitalGovernmentCoordinationLimitsCommand extends Command
{
    protected $signature = 'tansik:import-government-coordination-limits
                            {--from-year=2011 : First admission year to import}
                            {--to-year= : Last admission year (default: current calendar year)}
                            {--no-older-candidates : Skip «أقدم» tables (Limit*O*.htm)}
                            {--portal-url= : Override portal HTML URL}
                            {--portal-file= : Local path to saved portal HTML (skips portal HTTP; limit files still fetched)}
                            {--limits-dir= : Directory of pre-downloaded Limit*.htm (basename must match remote; skips limit HTTP)}
                            {--dry-run : Fetch and parse only; do not write to the database}';

    protected $description = 'Fetch coordination limit tables from tansik.digital.gov.eg and import them into faculty_edges (with thanawya_system metadata).';

    public function handle(DigitalGovCoordinationLimitImporter $importer): int
    {
        $portalFile = $this->option('portal-file');
        $portalUrl = $this->option('portal-url') ?: DigitalGovCoordinationLimitCatalog::PORTAL_URL;
        $fromYear = max(1990, (int) $this->option('from-year'));
        $toYear = $this->option('to-year') !== null && $this->option('to-year') !== ''
            ? (int) $this->option('to-year')
            : (int) date('Y');
        $toYear = max($fromYear, $toYear);
        $includeOlder = ! $this->option('no-older-candidates');
        $dryRun = (bool) $this->option('dry-run');

        $limitsDirOption = $this->option('limits-dir');
        $limitsDir = is_string($limitsDirOption) && $limitsDirOption !== ''
            ? $limitsDirOption
            : config('services.tansik_digital_gov_import.limits_dir');
        $limitsDir = is_string($limitsDir) && $limitsDir !== '' ? $limitsDir : null;
        if (is_string($portalFile) && $portalFile !== '') {
            $this->info('Portal file: '.$portalFile);
        } else {
            $this->info('Portal: '.$portalUrl);
        }
        if ($limitsDir !== null) {
            $this->info('Limits dir (local files): '.$limitsDir);
        }
        $this->info(sprintf('Years: %d–%d%s', $fromYear, $toYear, $dryRun ? ' (dry run)' : ''));

        if (is_string($portalFile) && $portalFile !== '') {
            if (! is_readable($portalFile)) {
                $this->error('Portal file is not readable: '.$portalFile);

                return self::FAILURE;
            }
            $raw = file_get_contents($portalFile);
            if ($raw === false) {
                $this->error('Could not read portal file: '.$portalFile);

                return self::FAILURE;
            }
            $portalHtml = $raw;
            if ($portalHtml === '') {
                $this->error('Portal file is empty: '.$portalFile);

                return self::FAILURE;
            }
        } else {
            try {
                $portalHtml = DigitalGovCoordinationLimitImporter::http()
                    ->get($portalUrl)
                    ->throw()
                    ->body();
            } catch (Throwable $e) {
                $this->error('Failed to download portal: '.$e->getMessage());
                $this->comment('Your host may block TCP to tansik.digital.gov.eg. On a machine with access, run: php artisan tansik:pull-government-coordination-limits /path/to/dir — upload that dir, then import with --portal-file and --limits-dir. Optional: TANSIK_DIGITAL_GOV_IMPORT_HTTP_PROXY.');

                return self::FAILURE;
            }
        }

        $catalog = new DigitalGovCoordinationLimitCatalog;
        $items = $catalog->discoverFromPortalHtml($portalHtml);
        if ($items === []) {
            $this->warn('No Limit*.htm links found in portal HTML — nothing to import.');

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

        $this->info('Matched '.count($filtered).' limit file(s) after filters.');

        $totalCreated = 0;
        $totalUpdated = 0;
        $totalParsed = 0;

        foreach ($filtered as $item) {
            $label = sprintf(
                '%d %s%s',
                $item['year'],
                $item['section'] === 'E' ? 'علمي' : 'أدبي',
                $item['is_older_candidates'] ? ' (أقدم)' : ''
            );

            try {
                $stats = $importer->importFromUrl(
                    $item['path'],
                    $item['section'],
                    $item['year'],
                    $item['is_older_candidates'],
                    $dryRun,
                    $limitsDir,
                );
            } catch (Throwable $e) {
                $this->warn($label.' — skipped: '.$e->getMessage());

                continue;
            }

            $totalCreated += $stats['created'];
            $totalUpdated += $stats['updated'];
            $totalParsed += $stats['parsed_rows'];

            $this->line(sprintf(
                '  %s — %s (%d row(s) in table)%s',
                $label,
                basename(parse_url($item['path'], PHP_URL_PATH) ?? ''),
                $stats['parsed_rows'],
                $dryRun ? '' : sprintf(' → +%d new, ~%d updated', $stats['created'], $stats['updated'])
            ));
        }

        if ($dryRun) {
            $this->info('Dry run finished (no database writes). Parsed row total: '.$totalParsed);
        } else {
            $this->info(sprintf('Done. New rows: %d, updated rows: %d.', $totalCreated, $totalUpdated));
        }

        return self::SUCCESS;
    }
}
