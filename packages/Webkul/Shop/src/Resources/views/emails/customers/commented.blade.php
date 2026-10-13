@component('shop::emails.layout')
    <div style="margin-bottom: 34px;">
        <p style="font-weight: bold;font-size: 20px;color: #133B63;line-height: 24px;margin-bottom: 24px">
            @lang('shop::app.emails.dear', ['customer_name' => $customerNote->customer->name]), 👋
        </p>
    </div>

    <p style="font-size: 16px;color: #374151;line-height: 24px;margin-bottom: 40px">
        @lang('shop::app.emails.customers.commented.description', ['note' => $customerNote->note]),
    </p>
@endcomponent