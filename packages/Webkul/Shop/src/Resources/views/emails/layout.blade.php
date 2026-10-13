<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
        <style>
            body { margin: 0; padding: 0; background-color: #F5F7FA; font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; -webkit-font-smoothing: antialiased; }
            .container { max-width: 600px; margin: 40px auto; background-color: #FFFFFF; border: 1px solid #E5E7EB; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
            .header { background-color: #133B63; padding: 30px 40px; text-align: center; border-bottom: 4px solid #F29A38; }
            .content { padding: 40px; color: #1F2937; }
            .footer { background-color: #F8FAFC; padding: 30px 40px; text-align: center; color: #64748B; font-size: 13px; border-top: 1px solid #E5E7EB; }
            .footer a { color: #1D5B8F; text-decoration: none; font-weight: 500; }
            .btn { display: inline-block; background-color: #F29A38; color: #FFFFFF !important; padding: 12px 24px; text-decoration: none; border-radius: 9999px; font-weight: 600; margin-top: 15px; text-transform: uppercase; font-size: 13px; letter-spacing: 0.5px; }
            h1, h2, h3 { color: #133B63; font-weight: 700; margin-top: 0; }
            p { line-height: 1.6; margin-bottom: 20px; }
            a { color: #1D5B8F; text-decoration: none; }
            .table-container { width: 100%; border-collapse: collapse; margin-top: 20px; margin-bottom: 20px; }
            .table-container th { border-bottom: 2px solid #E5E7EB; padding: 12px 8px; text-align: left; color: #133B63; font-weight: 600; font-size: 14px; }
            .table-container td { border-bottom: 1px solid #F1F5F9; padding: 12px 8px; color: #374151; font-size: 14px; }
            .summary-box { background-color: #F8FAFC; padding: 20px; border-radius: 8px; border: 1px solid #E5E7EB; margin-top: 20px; }
        </style>
    </head>
    <body>
        <div class="container">
            <!-- Email Header -->
            <div class="header">
                <a href="{{ route('shop.home.index') }}">
                    @if ($logo = core()->getCurrentChannel()->logo_url)
                        <img src="{{ $logo }}" alt="{{ config('app.name') }}" style="max-height: 50px; max-width: 200px;" />
                    @else
                        <!-- SOXNSOX Text Logo Fallback -->
                        <span style="font-size: 28px; font-weight: 800; color: #FFFFFF; letter-spacing: 2px;">SOX<span style="color: #F29A38;">N</span>SOX</span>
                    @endif
                </a>
            </div>

            <!-- Email Content -->
            <div class="content">
                {{ $slot }}
            </div>

            <!-- Email Footer -->
            <div class="footer">
                <p style="margin-bottom: 10px;">
                    @lang('shop::app.emails.thanks', [
                        'link' => 'mailto:' . core()->getContactEmailDetails()['email'],
                        'email' => core()->getContactEmailDetails()['email'],
                        'style' => 'color: #1D5B8F; font-weight: 600;'
                    ])
                </p>
                <p style="margin-bottom: 0; font-size: 12px; color: #64748B;">
                    &copy; {{ date('Y') }} SOX N SOX. All rights reserved. India's Premier Bamboo & Diabetic Socks.
                </p>
            </div>
        </div>
    </body>
</html>
