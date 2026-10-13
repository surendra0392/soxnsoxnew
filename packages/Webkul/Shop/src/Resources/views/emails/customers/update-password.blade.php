@component('shop::emails.layout')
    <div style="margin-bottom: 34px;">
        <p style="font-weight: bold;font-size: 20px;color: #133B63;line-height: 24px;margin-bottom: 24px">
            @lang('shop::app.emails.dear', ['customer_name' => $customer->name]), 👋
        </p>

        <p style="font-size: 16px;color: #374151;line-height: 24px;">
            @lang('shop::app.emails.customers.update-password.greeting')
        </p>
    </div>

    <p style="font-size: 16px;color: #374151;line-height: 24px;margin-bottom: 40px">
        @lang('shop::app.emails.customers.update-password.description')
    </p>
@endcomponent