@php
    $adsenseClient = (string) config('ads.adsense_client');
@endphp
@if ($adsenseClient === '')
    {{-- ADS_ENABLED but ADSENSE_CLIENT missing — no AdSense markup (avoid broken requests). --}}
@else
    @php
        $units = [
            'sidebar_top' => ['class' => 'th-ad-slot th-ad-slot--sidebar-top mb-3', 'min' => '120px'],
            'in_content' => ['class' => 'th-ad-slot th-ad-slot--in-content my-3', 'min' => '90px'],
            'footer_banner' => ['class' => 'th-ad-slot th-ad-slot--footer-banner mt-3', 'min' => '90px'],
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
                document.querySelectorAll('.th-ad-slot ins.adsbygoogle').forEach(function () {
                    try {
                        (window.adsbygoogle = window.adsbygoogle || []).push({});
                    } catch (e) {}
                });
            </script>
        @endpush
    @endonce
@endif
