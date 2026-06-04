<?php

namespace App\Support\Tansik;

/**
 * Builds the list of limit-file URLs linked from the Thanawya coordination portal.
 */
final class DigitalGovCoordinationLimitCatalog
{
    public const PORTAL_URL = 'https://tansik.digital.gov.eg/application/Certificates/Thanwy/defaultThanwy.aspx';

    public const LIMITS_BASE_PATH = 'https://tansik.digital.gov.eg/application/Certificates/Thanwy/Limits/';

    /**
     * @return list<array{path: string, section: string, year: int, is_older_candidates: bool}>
     */
    public function discoverFromPortalHtml(string $html): array
    {
        $out = [];
        $pattern = '~(?:href|HREF)=["\']?([^"\']*Limits[/\\\\]+Limit([AE])(O)?(\d{4})\.htm)["\']?~';
        if (! preg_match_all($pattern, $html, $matches, PREG_SET_ORDER)) {
            return [];
        }

        foreach ($matches as $m) {
            $rel = str_replace('\\', '/', $m[1]);
            if (! str_contains(strtolower($rel), 'limit')) {
                continue;
            }
            $section = strtoupper($m[2]);
            $isOlder = $m[3] !== '';
            $year = (int) $m[4];
            $out[] = [
                'path' => $this->toAbsoluteUrl($rel),
                'section' => $section,
                'year' => $year,
                'is_older_candidates' => $isOlder,
            ];
        }

        return $this->dedupe($out);
    }

    /**
     * @param  list<array{path: string, section: string, year: int, is_older_candidates: bool}>  $items
     * @return list<array{path: string, section: string, year: int, is_older_candidates: bool}>
     */
    private function dedupe(array $items): array
    {
        $seen = [];
        $deduped = [];
        foreach ($items as $item) {
            $k = $item['section'].'|'.$item['year'].'|'.($item['is_older_candidates'] ? '1' : '0');
            if (isset($seen[$k])) {
                continue;
            }
            $seen[$k] = true;
            $deduped[] = $item;
        }

        return $deduped;
    }

    private function toAbsoluteUrl(string $href): string
    {
        if (str_starts_with($href, 'http://') || str_starts_with($href, 'https://')) {
            return str_replace('\\', '/', $href);
        }

        $href = str_replace('\\', '/', ltrim($href, '/'));

        return rtrim(self::LIMITS_BASE_PATH, '/').'/'.basename($href);
    }
}
