@if (core()->getConfigData('catalog.products.social_share.enabled'))
    @php
        $message = core()->getConfigData('catalog.products.social_share.share_message');
    @endphp

    <div class="pt-2 flex items-center gap-3">
        {!! view_render_event('bagisto.shop.products.view.share.before', ['product' => $product]) !!}

        <!-- Share Label -->
        <div class="flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-[0.14em] text-soxnsox-muted select-none">
            <i class="fa-solid fa-share-nodes text-xs text-[#1d5b8f]"></i>
            <span>@lang('admin::app.configuration.index.catalog.products.social-share.share')</span>
        </div>

        <!-- Social Share Icons List -->
        <div>
            <ul class="flex items-center gap-2">
                @foreach(['facebook', 'twitter', 'pinterest', 'linkedin', 'whatsapp', 'email'] as $social)
                    @if (! core()->getConfigData('catalog.products.social_share.' . $social))
                        @continue
                    @endif

                    @include('social_share::links.' . $social , compact('product', 'message'))
                @endforeach
            </ul>
        </div>

        {!! view_render_event('bagisto.shop.products.view.share.after', ['product' => $product]) !!}
    </div>

    @push('scripts')
        <script>
            function shareProduct() {
                let productName = "{{ $product->name }}";
                let productUrl = "{{ route('shop.products.view', [$product->url_key]) }}";

                if (navigator.share) {
                    navigator.share({
                        title: productName,
                        text: productName + ' ' + productUrl,
                        url: productUrl
                    })
                    .catch((error) => console.error('Error sharing:', error));
                } else {
                    alert('Your browser does not support sharing.');
                }
            }
        </script>    
    @endpush
@endif
