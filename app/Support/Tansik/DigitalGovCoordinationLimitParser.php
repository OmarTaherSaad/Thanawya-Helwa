<?php

namespace App\Support\Tansik;

use DOMDocument;
use DOMXPath;

/**
 * Parses official limit tables (حد أدنى) from tansik.digital.gov.eg static HTML.
 */
final class DigitalGovCoordinationLimitParser
{
    /**
     * @return array<string, float> college display name => minimum coordination total
     */
    public function parseLimitTableHtml(string $html): array
    {
        $rows = $this->parseWithDom($html);
        if ($rows !== []) {
            return $rows;
        }

        return $this->parseWithRegex($html);
    }

    /**
     * @return array<string, float>
     */
    private function parseWithDom(string $html): array
    {
        $internal = '<?xml encoding="utf-8" ?>';
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $loaded = $doc->loadHTML($internal.$html, LIBXML_NOWARNING | LIBXML_NOERROR);
        libxml_clear_errors();
        if (! $loaded) {
            return [];
        }

        $xpath = new DOMXPath($doc);
        $table = $xpath->query("//table[@id='table14']")->item(0);
        if (! $table) {
            return [];
        }

        $out = [];
        foreach ($table->getElementsByTagName('tr') as $tr) {
            $cells = $tr->getElementsByTagName('td');
            if ($cells->length < 2) {
                continue;
            }
            $name = $this->normalizeCellText($cells->item(0)->textContent);
            $edgeRaw = $this->normalizeCellText($cells->item(1)->textContent);
            if ($name === '' || $edgeRaw === '') {
                continue;
            }
            if ($this->looksLikeHeaderRow($name, $edgeRaw)) {
                continue;
            }
            if (! is_numeric(str_replace(',', '.', $edgeRaw))) {
                continue;
            }
            $out[$name] = (float) str_replace(',', '.', $edgeRaw);
        }

        return $out;
    }

    /**
     * Fallback when markup is too broken for DOMDocument.
     *
     * @return array<string, float>
     */
    private function parseWithRegex(string $html): array
    {
        $out = [];
        $pattern = '~<tr>\s*<td[^>]*>\s*([^<]+?)\s*</td>\s*<td[^>]*>\s*([\d.,]+)\s*</td>\s*</tr>~ui';
        if (preg_match_all($pattern, $html, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $m) {
                $name = $this->normalizeCellText(html_entity_decode($m[1], ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                $edgeRaw = $this->normalizeCellText(html_entity_decode($m[2], ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                if ($name === '' || $this->looksLikeHeaderRow($name, $edgeRaw)) {
                    continue;
                }
                if (! is_numeric(str_replace(',', '.', $edgeRaw))) {
                    continue;
                }
                $out[$name] = (float) str_replace(',', '.', $edgeRaw);
            }
        }

        return $out;
    }

    private function normalizeCellText(string $s): string
    {
        $s = html_entity_decode(trim($s), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $s = preg_replace('/\s+/u', ' ', $s) ?? '';

        return trim($s);
    }

    private function looksLikeHeaderRow(string $name, string $edge): bool
    {
        if (mb_stripos($name, 'كلية') !== false && (mb_stripos($name, 'الحد') !== false || mb_stripos($name, 'الأدنى') !== false)) {
            return true;
        }

        return $edge === 'الأدنى' || $edge === 'الحد';
    }

    /**
     * Same normalisation used when editors imported tables manually (see {@see \App\MyCodes}).
     */
    public static function normalizeProgramNameForStorage(string $name): string
    {
        $name = str_replace('ة', 'ه', $name);
        $name = str_replace('ى', 'ي', $name);
        $name = str_replace(['آ', 'إ', 'أ'], 'ا', $name);

        return trim($name);
    }
}
