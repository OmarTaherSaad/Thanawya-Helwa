<?php

namespace App\Support\Tansik;

use App\Models\Tansik\FacultyEdge;
use Illuminate\Support\Facades\Http;

/**
 * Downloads limit HTML from tansik.digital.gov.eg and upserts {@see FacultyEdge} rows.
 */
final class DigitalGovCoordinationLimitImporter
{
    public function __construct(
        private DigitalGovCoordinationLimitParser $parser,
    ) {
    }

    /**
     * @return array{created: int, updated: int, parsed_rows: int}
     */
    public function importFromUrl(
        string $url,
        string $section,
        int $admissionYear,
        bool $isOlderCandidatesFile,
        bool $dryRun,
    ): array {
        $section = strtoupper($section) === 'A' ? 'A' : 'E';

        $html = $this->download($url);
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

    private function download(string $url): string
    {
        $response = Http::timeout(90)
            ->withHeaders([
                'User-Agent' => 'ThanawyaHelwaCoordinationImporter/1.0 (+https://thanawyahelwa.org)',
                'Accept' => 'text/html,*/*',
                'Accept-Language' => 'ar-EG,ar;q=0.9',
            ])
            ->get($url);

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
