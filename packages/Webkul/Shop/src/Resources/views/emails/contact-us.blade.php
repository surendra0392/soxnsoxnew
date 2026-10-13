@component('shop::emails.layout')
    @if (! empty($contactUs['looking_for']))
        <div style="margin-bottom: 24px; padding: 14px 18px; background-color: #F3F4F6; border-left: 4px solid #2CA7A3; border-radius: 6px;">
            <p style="margin: 0; font-size: 12px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.1em; color: #2CA7A3;">
                What They Are Looking For:
            </p>
            <p style="margin: 4px 0 0 0; font-size: 16px; font-weight: 600; color: #133B63;">
                {{ $contactUs['looking_for'] }}
            </p>
        </div>
    @endif

    <div style="margin-bottom: 34px;">
        <p style="font-size: 16px;color: #1F2937;line-height: 24px;">
            {{ $contactUs['message'] }}
        </p>
    </div>

    <p style="font-size: 16px;color: #4B5563;line-height: 24px;margin-bottom: 40px">
        @lang('shop::app.emails.contact-us.to')
        
        <a href="mailto:{{ $contactUs['email'] }}" style="color: #1D5B8F; font-weight: 600;">{{ $contactUs['email'] }}</a>,

        @lang('shop::app.emails.contact-us.reply-to-mail')

        @if($contactUs['contact'])
            @lang('shop::app.emails.contact-us.reach-via-phone')

            <a href="tel:{{ $contactUs['contact'] }}" style="color: #1D5B8F; font-weight: 600;">{{ $contactUs['contact'] }}</a>.
        @endif
    </p>
@endcomponent