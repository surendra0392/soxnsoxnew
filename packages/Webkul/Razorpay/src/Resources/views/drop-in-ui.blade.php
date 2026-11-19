<!DOCTYPE html>
<html lang="en">
    <head>
        <title>@lang('razorpay::app.drop-in-ui.title')</title>

        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

        <!-- Add Loading Spinner Styles -->
        <style>
            .loader-container {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background-color: rgba(255, 255, 255, 0.9);
            }

            .loader {
                border: 5px solid #f3f3f3;
                border-radius: 50%;
                border-top: 5px solid #F37254;
                width: 50px;
                height: 50px;
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            
            .error-message {
                display: none;
                text-align: center;
                color: #721c24;
                background-color: #f8d7da;
                border: 1px solid #f5c6cb;
                padding: 1rem;
                margin: 1rem;
                border-radius: 4px;
            }
        </style>
    </head>

    <body>
        <!-- Add Loading Spinner -->
        <div class="loader-container">
            <div class="loader"></div>
        </div>

        <!-- Add Error Message Container -->
        <div
            id="error-message"
            class="error-message"
            role="alert"
        >
            <p id="error-text">@lang('razorpay::app.response.something-went-wrong')</p>

            <div style="margin-top: 12px; display: flex; gap: 10px; justify-content: center;">
                <button
                    type="button"
                    id="retry-payment-btn"
                    style="padding: 8px 16px; border: 0; border-radius: 6px; background: #133b63; color: #fff; cursor: pointer;"
                >
                    Retry Payment
                </button>

                <a
                    href="{{ route('razorpay.payment.cancel') }}"
                    style="padding: 8px 16px; border: 1px solid #721c24; border-radius: 6px; color: #721c24; text-decoration: none;"
                >
                    Return to Cart
                </a>
            </div>
        </div>

        <form
            id="razorpay-success-form"
            method="POST"
            action="{{ route('razorpay.payment.success') }}"
            style="display: none;"
        >
            <input type="hidden" name="razorpay_payment_id" id="rp_payment_id" />
            <input type="hidden" name="razorpay_order_id" id="rp_order_id" />
            <input type="hidden" name="razorpay_signature" id="rp_signature" />
        </form>

        <script>
            const payment = @json($payment);
            const loaderContainer = document.querySelector('.loader-container');
            const errorBox = document.getElementById('error-message');
            const errorText = document.getElementById('error-text');

            function showPaymentError(message) {
                if (loaderContainer) {
                    loaderContainer.style.display = 'none';
                }

                if (errorText) {
                    errorText.textContent = message || "@lang('razorpay::app.response.something-went-wrong')";
                }

                if (errorBox) {
                    errorBox.style.display = 'block';
                }
            }

            if (typeof Razorpay === 'undefined') {
                showPaymentError('Unable to load Razorpay Checkout. Please check your connection and try again.');
            } else {
                const razorpay = new Razorpay({
                    key: payment.key,
                    amount: payment.amount,
                    currency: payment.currency,
                    name: payment.name,
                    description: payment.description,
                    image: payment.image,
                    order_id: payment.order_id,
                    prefill: payment.prefill,

                    theme: {
                        color: payment.theme_color || '#0041FF'
                    },

                    modal: {
                        ondismiss: function () {
                            if (loaderContainer) {
                                loaderContainer.style.display = 'flex';
                            }

                            window.location.href = "{{ route('razorpay.payment.cancel') }}";
                        },

                        escape: true,
                        animation: true
                    },

                    handler: function (response) {
                        if (loaderContainer) {
                            loaderContainer.style.display = 'flex';
                        }

                        document.getElementById('rp_payment_id').value = response.razorpay_payment_id || '';
                        document.getElementById('rp_order_id').value = response.razorpay_order_id || '';
                        document.getElementById('rp_signature').value = response.razorpay_signature || '';

                        document.getElementById('razorpay-success-form').submit();
                    }
                });

                razorpay.on('payment.failed', function (response) {
                    const description = response?.error?.description
                        || response?.error?.reason
                        || "@lang('razorpay::app.response.something-went-wrong')";

                    showPaymentError(description);
                });

                const retryBtn = document.getElementById('retry-payment-btn');
                if (retryBtn) {
                    retryBtn.addEventListener('click', function () {
                        if (errorBox) {
                            errorBox.style.display = 'none';
                        }

                        razorpay.open();
                    });
                }

                window.addEventListener('load', function () {
                    if (loaderContainer) {
                        loaderContainer.style.display = 'none';
                    }

                    razorpay.open();
                });
            }
        </script>
    </body>
</html>