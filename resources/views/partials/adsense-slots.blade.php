@php
    $adsenseClient = (string) config('ads.adsense_client');
    $idleMs = max(0, (int) config('ads.push_idle_ms', 0));
@endphp
@if ($adsenseClient === '')
    {{-- ADS_ENABLED but ADSENSE_CLIENT missing — no AdSense markup (avoid broken requests). --}}
@else
    @php
        $minHeights = config('ads.min_heights', []);
        $units = [
            'sidebar_top' => ['class' => 'th-ad-slot th-ad-slot--sidebar-top mb-3', 'min' => $minHeights['sidebar_top'] ?? '120px'],
            'in_content' => ['class' => 'th-ad-slot th-ad-slot--in-content my-3', 'min' => $minHeights['in_content'] ?? '120px'],
            'footer_banner' => ['class' => 'th-ad-slot th-ad-slot--footer-banner mt-3', 'min' => $minHeights['footer_banner'] ?? '90px'],
        ];
    @endphp
    @foreach ($units as $key => $wrap)
        @php
            $slotId = trim((string) config('ads.slots.'.$key));
            $slotOk = $slotId !== '' && ctype_digit($slotId);
        @endphp
        @if ($slotOk)
            <div class="{{ $wrap['class'] }}" style="min-height: {{ $wrap['min'] }}">
                <ins class="adsbygoogle"
                    style="display:block"
                    data-ad-client="{{ e($adsenseClient) }}"
                    data-ad-slot="{{ e($slotId) }}"
                    data-ad-format="auto"
                    data-full-width-responsive="true"></ins>
            </div>
        @endif
    @endforeach
    @once
        @push('adsense-push')
            <script>
                (function () {
                    var idleMs = {{ $idleMs }};
                    function pushAds() {
                        document.querySelectorAll('.th-ad-slot ins.adsbygoogle').forEach(function (el) {
                            try {
                                (window.adsbygoogle = window.adsbygoogle || []).push({});
                            } catch (e) {}
                        });
                    }
                    if (idleMs <= 0) {
                        pushAds();
                        return;
                    }
                    if ('requestIdleCallback' in window) {
                        requestIdleCallback(function () { pushAds(); }, { timeout: idleMs + 2000 });
                    } else {
                        window.setTimeout(pushAds, idleMs);
                    }
                })();
            </script>
        @endpush
    @endonce
@endif
