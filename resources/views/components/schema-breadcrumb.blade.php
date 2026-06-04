@props(['items' => []])
@php
    /** @var array<int, array{name: string, url: string}> $items */
    if (count($items) === 0) {
        return;
    }
    $elements = [];
    foreach ($items as $i => $item) {
        $elements[] = [
            '@type' => 'ListItem',
            'position' => $i + 1,
            'name' => $item['name'],
            'item' => $item['url'],
        ];
    }
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $elements,
    ];
@endphp
@push('jsonld')
<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush
