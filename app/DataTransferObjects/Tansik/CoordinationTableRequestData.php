<?php

namespace App\DataTransferObjects\Tansik;

use Illuminate\Http\Request;

/**
 * Normalized payload for the historical coordination (Vuetable) POST endpoint.
 *
 * Preserves backward compatibility with clients that send a nested {@see $params} array
 * or omit optional keys (defaults match legacy {@see PagesController::getEdges} behaviour).
 */
final class CoordinationTableRequestData
{
    public function __construct(
        public readonly string $section,
        public readonly string $filter,
        public readonly ?string $sort,
        public readonly int $page,
        public readonly int $perPage,
    ) {
    }

    /**
     * Build from an incoming HTTP request (JSON body or form data).
     */
    public static function fromRequest(Request $request): self
    {
        $params = $request->input('params', $request->get('params'));
        if (! is_array($params)) {
            $params = [];
        }

        $section = strtoupper((string) ($params['section'] ?? 'E'));
        if (! in_array($section, ['E', 'A'], true)) {
            $section = 'E';
        }

        $filter = (string) ($params['filter'] ?? '');
        $sort = isset($params['sort']) && $params['sort'] !== '' ? (string) $params['sort'] : null;

        $page = max(1, (int) ($params['page'] ?? $request->input('page', 1)));
        $perPage = (int) ($params['per_page'] ?? 100);
        $perPage = max(1, min(500, $perPage));

        return new self($section, $filter, $sort, $page, $perPage);
    }

    /**
     * @return array<string, mixed> Legacy shape expected by aggregation logic.
     */
    public function toLegacyParamsArray(): array
    {
        return [
            'section' => $this->section,
            'filter' => $this->filter,
            'sort' => $this->sort,
            'page' => $this->page,
            'per_page' => $this->perPage,
        ];
    }
}
