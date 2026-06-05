@php
    $adsenseClient = (string) config('ads.adsense_client');
    $idleMs = max(0, (int) config('ads.push_idle_ms', 0));

    $slotId = trim((string) config('ads.slot', ''));
    if ($slotId === '' || ! ctype_digit($slotId)) {
        foreach (['sidebar_top', 'in_content', 'footer_banner'] as $placement) {
            $try = trim((string) config('ads.slots.'.$placement));
            if ($try !== '' && ctype_digit($try)) {
                $slotId = $try;
                break;
            }
        }
    }
    $slotOk = $slotId !== '' && ctype_digit($slotId);
    $minH = (string) config('ads.min_height', '120px');
@endphp
@if ($adsenseClient === '')
    {{-- ADS_ENABLED but ADSENSE_CLIENT missing — no AdSense markup (avoid broken requests). --}}
@elseif (! $slotOk)
    {{-- Client set but no numeric ADSENSE_SLOT (or legacy slot) — skip <ins> until you create one Display unit in AdSense. --}}
@else
    <div class="th-ad-slot th-ad-slot--primary mb-3" style="min-height: {{ $minH }}">
        <ins class="adsbygoogle"
            style="display:block"
            data-ad-client="{{ e($adsenseClient) }}"
            data-ad-slot="{{ e($slotId) }}"
            data-ad-format="auto"
            data-full-width-responsive="true"></ins>
    </div>
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
