<?php

namespace App\Support\Tansik;

use App\Models\Tansik\FacultyEdge;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

/**
 * Downloads limit HTML from tansik.digital.gov.eg and upserts {@see FacultyEdge} rows.
 */
final class DigitalGovCoordinationLimitImporter
{
    /**
     * Shared HTTP client: raises connect_timeout above Laravel's default 10s
     * (slow TLS to the ministry host otherwise yields cURL 28 before transfer).
     */
    public static function http(): PendingRequest
    {
        $cfg = config('services.tansik_digital_gov_import', []);

        $request = Http::timeout((int) ($cfg['http_timeout'] ?? 120))
            ->connectTimeout((int) ($cfg['http_connect_timeout'] ?? 60))
            ->withHeaders([
                'User-Agent' => 'ThanawyaHelwaCoordinationImporter/1.0 (+https://thanawyahelwa.org)',
                'Accept' => 'text/html,*/*',
                'Accept-Language' => 'ar-EG,ar;q=0.9',
            ]);

        $guzzle = [];
        $proxy = $cfg['http_proxy'] ?? null;
        if (is_string($proxy) && $proxy !== '') {
            $guzzle['proxy'] = $proxy;
        }
        if (! empty($cfg['force_ipv4']) && defined('CURL_IPRESOLVE_V4')) {
            $guzzle['curl'] = [
                CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
            ];
        }
        if ($guzzle !== []) {
            $request = $request->withOptions($guzzle);
        }

        return $request;
    }

    public function __construct(
        private DigitalGovCoordinationLimitParser $parser,
    ) {
    }

    /**
     * @return array{created: int, updated: int, parsed_rows: int}
     */
    /**
     * @param  string|null  $localLimitsDirectory  If set, reads basename(url) from this directory instead of HTTP.
     */
    public function importFromUrl(
        string $url,
        string $section,
        int $admissionYear,
        bool $isOlderCandidatesFile,
        bool $dryRun,
        ?string $localLimitsDirectory = null,
    ): array {
        $section = strtoupper($section) === 'A' ? 'A' : 'E';

        $html = $this->download($url, $localLimitsDirectory);
        $rows = $this->parser->parseLimitTableHtml($html);
        $system = ThanawyaCoordinationSystem::resolve($isOlderCandidatesFile, $admissionYear);

        $created = 0;
        $updated = 0;
        $parsedCount = count($rows);

        if ($dryRun) {
            return [
                'created' => 0,
                'updated' => 0,
                'parsed_rows' => $parsedCount,
            ];
        }

        foreach ($rows as $rawName => $edge) {
            $name = DigitalGovCoordinationLimitParser::normalizeProgramNameForStorage(trim((string) $rawName));
            if ($name === '') {
                continue;
            }

            $query = FacultyEdge::query()
                ->where('section', $section)
                ->where('TempName', $name)
                ->where('year', $admissionYear);

            // «أقدم» tables are a parallel stream: match only other أقدم rows.
            // Mainstream files must merge with legacy rows that have null thanawya_system or any non‑أقدم value
            // (so re‑imports update instead of duplicating after migrations / classification tweaks).
            if ($system === ThanawyaCoordinationSystem::OLDER_CANDIDATES) {
                $query->where('thanawya_system', ThanawyaCoordinationSystem::OLDER_CANDIDATES);
            } else {
                $query->where(function ($q): void {
                    $q->whereNull('thanawya_system')
                        ->orWhere('thanawya_system', '<>', ThanawyaCoordinationSystem::OLDER_CANDIDATES);
                });
            }

            $existing = $query->orderBy('id')->get();

            if ($existing->isEmpty()) {
                FacultyEdge::query()->create([
                    'section' => $section,
                    'TempName' => $name,
                    'year' => $admissionYear,
                    'thanawya_system' => $system,
                    'edge' => $edge,
                ]);
                $created++;
            } else {
                foreach ($existing as $model) {
                    $model->update([
                        'edge' => $edge,
                        'thanawya_system' => $system,
                    ]);
                    $updated++;
                }
            }
        }

        return [
            'created' => $created,
            'updated' => $updated,
            'parsed_rows' => $parsedCount,
        ];
    }

    private function download(string $url, ?string $localLimitsDirectory): string
    {
        $localRoot = is_string($localLimitsDirectory) && $localLimitsDirectory !== ''
            ? rtrim($localLimitsDirectory, '/\\')
            : null;

        if ($localRoot !== null) {
            $basename = basename(parse_url($url, PHP_URL_PATH) ?? '');
            if ($basename === '') {
                throw new \RuntimeException('Could not derive filename for '.$url);
            }
            $path = $localRoot.DIRECTORY_SEPARATOR.$basename;
            if (! is_readable($path)) {
                throw new \RuntimeException('Local limit file not readable: '.$path);
            }
            $raw = file_get_contents($path);
            if ($raw === false) {
                throw new \RuntimeException('Could not read local limit file: '.$path);
            }
            if ($raw === '') {
                throw new \RuntimeException('Empty local limit file: '.$path);
            }

            return $raw;
        }

        $response = self::http()->get($url);

        if (! $response->successful()) {
            throw new \RuntimeException('HTTP '.$response->status().' when fetching '.$url);
        }

        $body = $response->body();
        if ($body === '') {
            throw new \RuntimeException('Empty response body for '.$url);
        }

        return $body;
    }
}
