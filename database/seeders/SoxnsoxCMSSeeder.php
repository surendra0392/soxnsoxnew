<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SoxnsoxCMSSeeder extends Seeder
{
    /**
     * Seed SOX N SOX custom CMS editorial & policy pages.
     */
    public function run(): void
    {
        $this->command->info('=== SOX N SOX CMS Pages Seeder ===');

        $now = Carbon::now();

        // 1. Copy CMS Media Assets from package seeders
        $cmsPackageDir = base_path('packages/Webkul/Installer/src/Resources/assets/images/seeders/cms');
        $storageCmsDir = storage_path('app/public/theme/cms');
        $publicCmsDir = public_path('storage/theme/cms');

        if (! file_exists($storageCmsDir)) {
            mkdir($storageCmsDir, 0777, true);
        }
        if (! file_exists($publicCmsDir)) {
            mkdir($publicCmsDir, 0777, true);
        }

        $cmsFiles = [
            'soxnsox-about-story.jpg',
            'soxnsox-about-story.webp',
            'soxnsox-quality-lab.jpg',
            'soxnsox-quality-lab.webp',
        ];

        foreach ($cmsFiles as $file) {
            $pkgFile = $cmsPackageDir.'/'.$file;
            if (file_exists($pkgFile)) {
                copy($pkgFile, $storageCmsDir.'/'.$file);
                copy($pkgFile, $publicCmsDir.'/'.$file);
            }
        }

        // 2. Define clean SOX N SOX CMS Pages
        $pages = [
            [
                'id' => 1,
                'url_key' => 'about-us',
                'page_title' => 'Our Story & Bamboo Craftsmanship',
                'meta_title' => 'About SOX N SOX | India\'s Premier Bamboo & Diabetic Socks',
                'meta_description' => 'Discover SOX N SOX: India\'s pioneer in bamboo socks. 200-needle knit precision, doctor-approved diabetic comfort, zero binding pressure, and seamless toe defense.',
                'meta_keywords' => 'about soxnsox, bamboo socks india, diabetic socks, seamless socks, blister free socks',
                'html_content' => '<section class="space-y-6">
<h2>Crafted for Unmatched Foot Comfort</h2>
<p>SOX N SOX was founded with a singular purpose: to craft the most comfortable, breathable, and supportive socks in India using 100% sustainably cultivated bamboo yarn.</p>
<p>Traditional cotton and synthetic socks trap perspiration, irritate sensitive skin, and use restrictive elastic cuffs that leave painful red indentations on your calves. By pairing 200-needle medical-grade knitting technology with natural Bamboo Kun antibacterial properties, SOX N SOX delivers cloud-like comfort that stays 3x drier and completely odor-free all day long.</p>
<h2>The 4 Pillars of SOX N SOX</h2>
<ul>
    <li><strong>100% Pure Bamboo:</strong> Naturally hypoallergenic, silk-smooth, and thermo-regulating.</li>
    <li><strong>Zero-Pressure Diabetic Cuffs:</strong> Non-binding honeycomb bands engineered to protect healthy blood flow.</li>
    <li><strong>0mm Seamless Hand-Linked Toes:</strong> Eliminates painful toe-box friction, corn formation, and blisters.</li>
    <li><strong>Reinforced Cushioning:</strong> High-density terry sole pads that absorb daily impact on hard floors.</li>
</ul>
</section>',
            ],
            [
                'id' => 2,
                'url_key' => 'return-policy',
                'page_title' => 'Return & Replacement Policy',
                'meta_title' => 'Return & Exchange Policy | 7-Day Easy Footwear Guarantee | SOX N SOX',
                'meta_description' => 'Enjoy 7-day hassle-free replacements and exchanges for unworn SOX N SOX socks in original packaging. 100% satisfaction guarantee.',
                'meta_keywords' => 'return policy, sock exchange, 7 day replacement, damaged delivery, soxnsox returns',
                'html_content' => '<h2>1. 100% Satisfaction & Comfort Guarantee</h2>
<p>At SOX N SOX, we believe your feet deserve nothing less than cloud-like comfort. If you receive a damaged, defective, or incorrect pair of socks, we will gladly arrange a prompt replacement or exchange at zero additional cost to you.</p>

<h2>2. 7-Day Exchange & Replacement Window</h2>
<p>You may request an exchange or replacement within <strong>7 days of delivery</strong> under the following conditions:</p>
<ul>
    <li><strong>Manufacturing Defects:</strong> Any knitting defect, seam unraveling, or sizing mismatch.</li>
    <li><strong>Transit Damage:</strong> If the packaging arrived damaged, torn, or compromised.</li>
    <li><strong>Incorrect SKU Received:</strong> If the style, size, or color does not match your order confirmation.</li>
</ul>

<h2>3. Footwear Hygiene & Return Guidelines</h2>
<p>For health and hygiene reasons standard to intimate footwear apparel, socks that have been worn, washed, or tried on without inner tags and original packaging cannot be accepted for return or restocking. All returned pairs must be in unwashed, unworn condition with original brand tags attached.</p>

<h2>4. How to Initiate an Exchange</h2>
<p>Simply contact our customer care team via WhatsApp at <a href="https://wa.me/918106155111">+91 81061 55111</a> or email us at <a href="mailto:support@soxnsox.in">support@soxnsox.in</a> with your Order ID and photo proof. Our logistics team will schedule a reverse pickup within 24–48 hours.</p>',
            ],
            [
                'id' => 3,
                'url_key' => 'refund-policy',
                'page_title' => 'Refund Policy',
                'meta_title' => 'Refund Policy | Transparent 5-7 Day Banking Reversals | SOX N SOX',
                'meta_description' => 'Clear refund processing timelines and reimbursement methods for cancelled orders or approved footwear returns on SOX N SOX.',
                'meta_keywords' => 'refund policy, payment reversal, sock returns refund, soxnsox refund',
                'html_content' => '<h2>1. Refund Eligibility</h2>
<p>Refunds are initiated in cases of order cancellations requested prior to dispatch, verified product unavailability, or where an approved replacement is unavailable.</p>

<h2>2. Processing Timeframes</h2>
<ul>
    <li><strong>UPI & Net Banking:</strong> 2–4 business days directly to the originating bank account.</li>
    <li><strong>Credit & Debit Cards:</strong> 5–7 business days depending on your bank\'s billing cycle.</li>
    <li><strong>Cash on Delivery (COD) Orders:</strong> Direct bank transfer (NEFT/IMPS) once you provide your verified account details, credited within 3 business days of pickup verification.</li>
</ul>

<h2>3. Cancellation Policy</h2>
<p>Orders can be cancelled free of charge at any time prior to shipment dispatch. Once a courier tracking number is assigned and handed to our logistics partner, the order cannot be intercepted; however, our 7-day exchange guarantee applies upon delivery.</p>',
            ],
            [
                'id' => 4,
                'url_key' => 'terms-conditions',
                'page_title' => 'Terms & Conditions of Sale',
                'meta_title' => 'Terms & Conditions of Sale | Order & Medical Guidelines | SOX N SOX',
                'meta_description' => 'Official terms and conditions governing purchases, pricing, pan-India delivery, diabetic sock wellness notices, and customer rights on SOX N SOX.',
                'meta_keywords' => 'terms of sale, purchase agreement, legal terms, diabetic socks disclaimer, soxnsox terms',
                'html_content' => '<h2>1. Agreement to Terms & Eligibility</h2>
<p>These Terms and Conditions of Sale ("Terms") constitute a legally binding agreement between you ("Customer") and SOX N SOX (operated by Involute Institute of Industrial Training, Hyderabad, India). By accessing soxnsox.in or placing an order, you confirm that you are at least 18 years of age and legally competent to enter into binding contracts under the Indian Contract Act, 1872.</p>

<h2>2. Product Specifications & Diabetic Footwear Medical Disclaimer</h2>
<p>SOX N SOX manufactures high-density 200-needle bamboo socks engineered for daily living, active sports, and sensitive foot comfort. Our Diabetic & Circulatory Comfort Socks feature non-binding wide-stretch top bands, hand-linked seamless toes, and cushioned terry soles that promote healthy leg circulation and prevent friction-induced blisters.</p>
<p><strong>Medical Notice:</strong> SOX N SOX socks are classified as supportive wellness apparel and daily comfort footwear. They are not medical devices, prescription orthotics, or pharmaceutical treatments. They do not diagnose, treat, cure, or prevent metabolic diseases or acute diabetic complications. Customers with active diabetic foot ulcers, severe peripheral arterial disease, neuropathy, or open wounds should always consult their physician or podiatrist.</p>

<h2>3. Pricing, GST Taxes & Payment Security</h2>
<ul>
    <li><strong>All-Inclusive Pricing:</strong> All prices listed on soxnsox.in are in Indian Rupees (INR) and are inclusive of Goods and Services Tax (GST) under HSN Code 6115.</li>
    <li><strong>Payment Modes:</strong> We accept UPI (Google Pay, PhonePe, Paytm, Cred, BHIM), RuPay, Visa, MasterCard, Net Banking across 50+ banks, and Cash on Delivery (COD).</li>
    <li><strong>Bank-Grade Encryption:</strong> All transactions are processed through RBI-compliant, PCI-DSS Level 1 certified gateways with mandatory 2-Factor Authentication (OTP). We never store raw card numbers or CVV.</li>
</ul>

<h2>4. Order Placement, Acceptance & Cancellation</h2>
<p>Orders can be cancelled free of charge at any time prior to shipment dispatch by contacting our support team with your Order ID. Once a consignment is handed to our courier partner and an Air Waybill (AWB) number is generated, it cannot be intercepted in transit; however, our 7-Day Easy Exchange Policy applies upon delivery.</p>

<h2>5. Shipping, Delivery & Title Transfer</h2>
<p>We provide Free Express Delivery across India on orders valued at ₹499 or above. Orders below ₹499 incur a flat ₹50 shipping charge. Title and risk of loss transfer to the customer upon delivery confirmation by the courier carrier. Please refuse packages that show external signs of tampering or damage.</p>

<h2>6. 7-Day Easy Exchange & Intimate Footwear Hygiene Standards</h2>
<p>You may request a replacement or exchange within 7 days of delivery for manufacturing defects, seam damage, or incorrect size received. For health and sanitary hygiene reasons standard to intimate footwear apparel, socks that have been worn, washed, or tried on without original packaging tags cannot be accepted.</p>

<h2>7. Intellectual Property & Prohibited Use</h2>
<p>All brand graphics, product photography, trademarks, sock knitting designs, and written content on soxnsox.in are the exclusive intellectual property of Involute Institute of Industrial Training and SOX N SOX. Unauthorized reproduction, automated scraping, or commercial resale is strictly prohibited.</p>

<h2>8. Governing Law & Dispute Resolution</h2>
<p>These terms and all order transactions are governed by the laws of the Republic of India. Any legal dispute that cannot be resolved amicably within 30 days shall be subject to the exclusive jurisdiction of the competent courts in Hyderabad / Medchal-Malkajgiri, Telangana, India.</p>',
            ],
            [
                'id' => 5,
                'url_key' => 'terms-of-use',
                'page_title' => 'Website Terms of Use',
                'meta_title' => 'Website Terms of Use | Digital Access & Security | SOX N SOX',
                'meta_description' => 'Terms governing website browsing, digital accounts, and security on SOX N SOX.',
                'meta_keywords' => 'terms of use, website rules, account security, soxnsox',
                'html_content' => '<h2>1. Acceptance of Terms</h2>
<p>By accessing and browsing soxnsox.in, you agree to adhere to these Terms of Use and all applicable laws and regulations of India.</p>

<h2>2. Account Security</h2>
<p>If you create a customer account on SOX N SOX, you are responsible for maintaining the confidentiality of your login details and password. Please notify us immediately if you suspect any unauthorized access.</p>

<h2>3. Permitted Use</h2>
<p>You agree to use this site only for lawful consumer purposes. Automated scraping, malicious intrusion attempts, or unauthorized access to our database systems is strictly prohibited.</p>',
            ],
            [
                'id' => 6,
                'url_key' => 'customer-service',
                'page_title' => 'Customer Care & Support',
                'meta_title' => 'Customer Care & Footwear Support | SOX N SOX',
                'meta_description' => 'Need sizing advice, order tracking, or wholesale socks assistance? Connect with the SOX N SOX support team.',
                'meta_keywords' => 'customer care, contact soxnsox, sock sizing help, wholesale socks',
                'html_content' => '<h2>How Can We Help Your Feet Today?</h2>
<p>Our dedicated customer care team is available to help you with sock sizing guidance, diabetic foot comfort recommendations, multi-pack customization, and order tracking.</p>

<h2>Direct Support Channels</h2>
<ul>
    <li><strong>Email Support:</strong> <a href="mailto:support@soxnsox.in">support@soxnsox.in</a> (Replies within 24 business hours)</li>
    <li><strong>Wholesale & Corporate Inquiries:</strong> <a href="mailto:sales@soxnsox.in">sales@soxnsox.in</a></li>
    <li><strong>Phone & WhatsApp Support:</strong> <a href="tel:+918106155111">+91 81061 55111</a></li>
    <li><strong>Operating Hours:</strong> Monday to Saturday, 9:30 AM – 6:30 PM IST</li>
</ul>

<h2>Fulfillment & Logistics Center</h2>
<p>SOX N SOX Fulfillment Center<br>
Involute Institute of Industrial Training, Shed No 1,Survy No342, ALEAP Industrial Estate, Gajularamaram, Road Number 10, Pragathi Nagar, Hyderabad, Medchal Malkajgiri, Telangana - 500090.</p>',
            ],
            [
                'id' => 7,
                'url_key' => 'whats-new',
                'page_title' => 'What\'s New in Bamboo Footwear',
                'meta_title' => 'New Arrivals & Innovations | SOX N SOX',
                'meta_description' => 'Explore the latest bamboo sock arrivals, high-cushion diabetic designs, and fresh seasonal color packs.',
                'meta_keywords' => 'new sock arrivals, bamboo sock pack, diabetic socks new',
                'html_content' => '<h2>Latest Bamboo Sock Collections & Innovations</h2>
<p>Discover our newly released 200-needle bamboo crew socks, extra-wide calf diabetic pairs, and breathable low-cut athletic ankle multi-packs. Engineered with natural Bamboo Kun odor defense and ultra-soft comfort.</p>',
            ],
            [
                'id' => 8,
                'url_key' => 'payment-policy',
                'page_title' => 'Payment Security & Methods',
                'meta_title' => 'Payment Security & Options | RBI 256-Bit SSL Encryption | SOX N SOX',
                'meta_description' => 'Safe & secure payment options: UPI, Google Pay, PhonePe, Paytm, credit/debit cards, net banking, and Cash on Delivery.',
                'meta_keywords' => 'payment methods, upi payments, cash on delivery, secure checkout, soxnsox payments',
                'html_content' => '<h2>1. Accepted Payment Methods</h2>
<p>SOX N SOX offers seamless, encrypted payment options for customers across India:</p>
<ul>
    <li><strong>UPI:</strong> Google Pay, PhonePe, Paytm, BHIM, Cred, and all bank UPI apps.</li>
    <li><strong>Credit & Debit Cards:</strong> Visa, MasterCard, RuPay, and American Express.</li>
    <li><strong>Net Banking:</strong> Over 50+ supported Indian banking institutions.</li>
    <li><strong>Cash on Delivery (COD):</strong> Available across serviceable pin codes in India.</li>
</ul>

<h2>2. 256-Bit SSL Bank-Grade Security</h2>
<p>Every transaction on SOX N SOX is processed through RBI-compliant, PCI-DSS Level 1 certified gateways with mandatory 2-Factor Authentication (OTP verification). We never store your card numbers or CVV on our servers.</p>',
            ],
            [
                'id' => 9,
                'url_key' => 'shipping-policy',
                'page_title' => 'Shipping & Delivery Policy',
                'meta_title' => 'Shipping & Delivery Policy | Express Pan-India Delivery | SOX N SOX',
                'meta_description' => 'Fast nationwide dispatch within 24 hours. Free delivery on sock orders above ₹499 with express door-to-door courier tracking across 19,000+ PIN codes.',
                'meta_keywords' => 'shipping policy, fast delivery, pan india delivery, free shipping over 499, soxnsox delivery',
                'html_content' => '<h2>1. Order Processing & 24-Hour Dispatch</h2>
<p>All footwear orders placed before 2:00 PM IST on business days (Monday through Saturday) are packed and prepared for dispatch on the same day. Orders placed on Sundays or gazetted public holidays are dispatched on the next business morning from our central warehouse in Hyderabad.</p>

<h2>2. Free Shipping & Delivery Rates</h2>
<ul>
    <li><strong>Orders ₹499 and Above:</strong> 100% Free Express Delivery across all 19,000+ serviceable PIN codes in India.</li>
    <li><strong>Orders Below ₹499:</strong> Flat ₹50 delivery charge applied at checkout. No hidden packaging or surcharge fees.</li>
</ul>

<h2>3. Estimated Pan-India Transit Timelines</h2>
<ul>
    <li><strong>Hyderabad & Telangana (Local Hub):</strong> 1–2 business days.</li>
    <li><strong>Major Metros (Bengaluru, Chennai, Mumbai, Delhi-NCR, Kolkata, Pune):</strong> 2–4 business days via air express.</li>
    <li><strong>Tier II & Tier III Cities:</strong> 3–6 business days.</li>
    <li><strong>Northeast States, J&K, Remote Regions:</strong> 5–8 business days.</li>
</ul>

<h2>4. Courier Networks & Live Tracking</h2>
<p>We partner with tier-1 carriers including Blue Dart Express, Delhivery, Xpressbees, and DTDC. As soon as your order is dispatched, you will receive an SMS and email with your Air Waybill (AWB) number and direct live tracking link.</p>

<h2>5. Cash on Delivery (COD) Guidelines</h2>
<p>Cash on Delivery is available across most postal codes in India. Please ensure exact cash or UPI QR payment readiness upon the courier agent\'s arrival. In compliance with national carrier regulations, packages cannot be opened prior to payment handover; our 7-Day Easy Replacement Policy fully protects you upon unboxing.</p>

<h2>6. Tamper-Proof Packaging & Damaged Delivery Protocol</h2>
<p>Every order is dispatched in sealed, water-resistant tamper-evident packaging. If the outer courier bag appears torn, open, or taped with non-brand tape, please refuse delivery from the agent. If you accept and discover damaged contents, photograph the parcel and notify support@soxnsox.in within 24 hours for an immediate free replacement.</p>',
            ],
            [
                'id' => 10,
                'url_key' => 'privacy-policy',
                'page_title' => 'Privacy Policy & Data Protection',
                'meta_title' => 'Privacy Policy & Data Protection | DPDP Act 2023 | SOX N SOX',
                'meta_description' => 'Your privacy is protected with 256-bit SSL encryption. Compliant with Digital Personal Data Protection Act 2023. We never sell or share your personal data with third-party marketers.',
                'meta_keywords' => 'privacy policy, customer data protection, ssl encryption, dpdp act 2023, soxnsox privacy',
                'html_content' => '<h2>1. Introduction & Regulatory Scope</h2>
<p>This Privacy Policy explains how SOX N SOX (operated by Involute Institute of Industrial Training, Hyderabad, Telangana) collects, uses, protects, and handles personal data in strict compliance with India\'s Digital Personal Data Protection Act, 2023 (DPDP Act), the Information Technology Act, 2000, and Reserve Bank of India (RBI) payment security directives.</p>

<h2>2. Information We Collect</h2>
<ul>
    <li><strong>Identity & Delivery Details:</strong> Full name, delivery address, postal PIN code, active mobile phone number, and email address.</li>
    <li><strong>Transaction Records:</strong> Sock styles, sizes, invoice totals, payment methods, and AWB tracking numbers.</li>
    <li><strong>Technical & Session Data:</strong> IP address, device specifications, browser type, and essential session cookies for cart management and CSRF security.</li>
    <li><strong>Tokenized Financial Credentials:</strong> Handled entirely by RBI-licensed PCI-DSS Level 1 payment gateways; we never store card numbers or CVV.</li>
</ul>

<h2>3. Strict Commitment: We Never Sell Your Data</h2>
<p>SOX N SOX maintains a strict policy: We do not sell, rent, monetize, broker, or trade your contact details with any third-party telemarketers, data brokers, or advertisement exchanges. Your information is used strictly to fulfill orders, provide doorstep delivery, and offer customer assistance.</p>

<h2>4. Authorized Operational Service Providers</h2>
<p>We share necessary data solely with essential service providers bound by strict confidentiality:</p>
<ul>
    <li><strong>Logistics Partners (Blue Dart, Delhivery, Xpressbees):</strong> Name, address, and mobile number to execute doorstep package delivery.</li>
    <li><strong>Payment Gateways (Razorpay, Cashfree, Bank networks):</strong> Encrypted transaction processing and 2FA authentication.</li>
    <li><strong>Telecom Gateways:</strong> Transactional order confirmation OTPs and dispatch tracking notifications.</li>
</ul>

<h2>5. Data Security & Retention</h2>
<p>All website traffic is secured with 256-bit SSL/TLS encryption. Customer order invoices are retained for 7 years in compliance with statutory Indian Goods and Services Tax (GST) accounting requirements.</p>

<h2>6. Your Rights Under DPDP Act 2023</h2>
<p>You have the right to access a summary of your personal data, request correction of inaccurate addresses, request deletion of your account profile, and opt out of promotional newsletters at any time.</p>

<h2>7. Statutory Grievance Redressal Officer</h2>
<p>In compliance with the Information Technology Act, 2000 and the DPDP Act 2023, you may contact our designated Grievance Officer at:</p>
<p><strong>Grievance Officer:</strong> Data Protection Desk, Involute Institute of Industrial Training<br>
<strong>Email:</strong> privacy@soxnsox.in | <strong>Phone:</strong> +91 81061 55111<br>
<strong>Address:</strong> Shed No 1, Survey No 342, ALEAP Industrial Estate, Gajularamaram, Hyderabad - 500090, Telangana, India.</p>',
            ],
            [
                'id' => 11,
                'url_key' => 'quality',
                'page_title' => 'Quality Standard & Craftsmanship',
                'meta_title' => 'Quality Standard & Testing | 200-Needle Bamboo Precision | SOX N SOX',
                'meta_description' => 'Explore the SOX N SOX quality standard: OEKO-TEX Standard 100 certified bamboo yarn, 200-needle density, 0mm hand-linked seamless toes, and 50+ wash durability.',
                'meta_keywords' => 'socks quality, bamboo yarn testing, oeko tex socks, diabetic footwear certification, 200 needle knit',
                'html_content' => '<h2>The SOX N SOX Footwear Precision Standard</h2>
<p>Every pair of SOX N SOX socks is crafted using advanced 200-needle high-density circular knitting machines. This produces a finer, denser weave that feels silk-soft against skin while maintaining structural resilience across 50+ machine washes.</p>
<h2>Key Quality Assurances</h2>
<ul>
    <li><strong>OEKO-TEX Standard 100:</strong> Certified free from harmful chemicals, heavy metal dyes, and formaldehyde.</li>
    <li><strong>0mm Flat Hand-Linked Toe Seam:</strong> Smooth finish to prevent blistering and pressure points.</li>
    <li><strong>Thermo-Regulating Bamboo Yarn:</strong> Keeps feet 2°C cooler in heat and comfortably insulated in winter.</li>
    <li><strong>Non-Binding Honeycomb Cuffs:</strong> Eliminates circulation constriction, ideal for diabetes and swollen feet.</li>
</ul>',
            ],
            [
                'id' => 12,
                'url_key' => 'why-choose-us',
                'page_title' => 'Why Choose Us | Designed To Deliver Comfort, Support & Better Everyday Movement',
                'meta_title' => 'Why Choose SOX N SOX | Everyday Bamboo & Diabetic Foot Comfort',
                'meta_description' => 'Explore why thousands choose SOX N SOX: Supportive fit, flexible movement, breathable comfort, and durable 200-needle knit construction for all-day wear.',
                'meta_keywords' => 'why choose soxnsox, comfortable socks, bamboo socks benefits, diabetic socks india, breathable socks',
                'html_content' => '<section class="space-y-6">
<h2>Simple Comfort. Designed For Everyday Life.</h2>
<p>Every pair of SOX N SOX is precision-engineered to support your daily movement, relieve foot stress, and keep you feeling light and energized from morning to night.</p>
<h2>The Comfort System</h2>
<ul>
    <li><strong>Supportive Fit:</strong> Comfort-focused construction designed to provide a secure and supportive feel throughout the day without tight pressure points.</li>
    <li><strong>Flexible Movement:</strong> Soft stretch materials move naturally with your feet for unrestricted everyday comfort and active mobility.</li>
    <li><strong>Breathable Comfort:</strong> Lightweight breathable fabrics help maintain airflow, regulate temperature, and preserve freshness all day long.</li>
</ul>
<h2>Our Promise: Comfort That Works With Your Lifestyle</h2>
<ul>
    <li><strong>Everyday Support:</strong> Designed to keep your feet feeling comfortable during work, travel, walking, and demanding daily routines.</li>
    <li><strong>Breathable Materials:</strong> Premium pure bamboo yarns help reduce heat accumulation and maintain lasting dryness and comfort.</li>
    <li><strong>Durable Quality:</strong> Built using reliable 200-needle medical-grade materials for long-lasting shape retention and performance.</li>
</ul>
<h2>Made For Every Part Of Your Day</h2>
<p>Whether at work through long standing hours, while travelling across long flights, during fitness and sports routines, or relaxing at home &mdash; SOX N SOX delivers cloud-like comfort in every single step.</p>
</section>',
            ],
            [
                'id' => 13,
                'url_key' => 'how-it-works',
                'page_title' => 'How It Works | The Science of Everyday Foot Comfort',
                'meta_title' => 'How SOX N SOX Works | 4-Step Bamboo Footwear Engineering',
                'meta_description' => 'Discover how SOX N SOX works: Precision 200-needle circular knitting, active thermo-regulation with Bamboo Kun, non-binding cuffs, and 0mm seamless hand-linked toes.',
                'meta_keywords' => 'how it works soxnsox, sock engineering, bamboo sock science, non binding socks, seamless toe socks',
                'html_content' => '<section class="space-y-6">
<h2>Designed To Deliver Comfort, Support &amp; Better Everyday Movement</h2>
<p>Discover the thoughtful engineering, material science, and craftsmanship behind every pair of SOX N SOX socks.</p>
<h2>The 4-Step Comfort Engineering Process</h2>
<ol>
    <li><strong>Step 1: Pure Bamboo Yarn Selection:</strong> Micro-porous fibers derived from cultivated bamboo grass. Inherently silky, moisture-wicking, hypoallergenic, and antibacterial.</li>
    <li><strong>Step 2: 200-Needle High-Density Weave:</strong> Medical-grade circular knitting creates an ultra-fine mesh that resists abrasion and cradles the foot without bulk.</li>
    <li><strong>Step 3: Non-Binding Circulation Grip:</strong> Engineered honeycomb cuffs eliminate constricting bands, ensuring healthy circulation for diabetics, seniors, and active workers.</li>
    <li><strong>Step 4: 0mm Seamless Hand-Linked Toes:</strong> Hand-linked flat toe closure completely removes irritating ridges, preventing blisters and friction across 10,000+ daily steps.</li>
</ol>
<h2>Tested For Durability &amp; Reliability</h2>
<p>All SOX N SOX socks are tested across 50+ wash cycles to ensure zero loss of elasticity, shrinkage resistance, and OEKO-TEX Standard 100 skin safety.</p>
</section>',
            ],
        ];

        // 3. Delete any leftover legacy recipes page
        DB::table('cms_page_translations')->where('url_key', 'recipes')->delete();

        $richBladeMap = [
            'about-us' => base_path('packages/Webkul/Shop/src/Resources/views/cms/about-us.blade.php'),
            'why-choose-us' => base_path('packages/Webkul/Shop/src/Resources/views/cms/why-choose-us.blade.php'),
            'how-it-works' => base_path('packages/Webkul/Shop/src/Resources/views/cms/how-it-works.blade.php'),
            'quality' => base_path('packages/Webkul/Shop/src/Resources/views/cms/quality.blade.php'),
            'shipping-policy' => base_path('packages/Webkul/Shop/src/Resources/views/cms/shipping-policy.blade.php'),
            'privacy-policy' => base_path('packages/Webkul/Shop/src/Resources/views/cms/privacy-policy.blade.php'),
            'terms-conditions' => base_path('packages/Webkul/Shop/src/Resources/views/cms/terms-conditions.blade.php'),
        ];

        $locales = DB::table('locales')->pluck('code')->toArray() ?: ['en'];

        foreach ($pages as $item) {
            $pageId = $item['id'];
            $urlKey = $item['url_key'];
            $pageTitle = $item['page_title'];
            $metaTitle = $item['meta_title'];
            $metaDesc = $item['meta_description'];
            $metaKeywords = $item['meta_keywords'];
            $htmlContent = $item['html_content'];

            if (isset($richBladeMap[$urlKey]) && file_exists($richBladeMap[$urlKey])) {
                $htmlContent = $this->compileBladeToHtml($richBladeMap[$urlKey]);
            }

            DB::table('cms_pages')->updateOrInsert(
                ['id' => $pageId],
                [
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );

            foreach ($locales as $locale) {
                DB::table('cms_page_translations')->updateOrInsert(
                    [
                        'cms_page_id' => $pageId,
                        'locale' => $locale,
                    ],
                    [
                        'url_key' => $urlKey,
                        'page_title' => $pageTitle,
                        'meta_title' => $metaTitle,
                        'meta_description' => $metaDesc,
                        'meta_keywords' => $metaKeywords,
                        'html_content' => $htmlContent,
                    ]
                );
            }

            // Ensure mapped to channel 1
            DB::table('cms_page_channels')->updateOrInsert([
                'cms_page_id' => $pageId,
                'channel_id' => 1,
            ]);
        }

        $this->command->info('SOX N SOX CMS Pages seeded successfully.');
    }

    /**
     * Compile blade template into clean, editable HTML.
     */
    protected function compileBladeToHtml(string $filepath): string
    {
        $content = file_get_contents($filepath);
        $content = preg_replace('/^<div[^>]*>/', '', trim($content));
        $content = preg_replace('/<\/div>$/', '', trim($content));
        $content = preg_replace('/@if\s*\(core\(\)->getConfigData\(\'general\.general\.breadcrumbs\.shop\'\)\).*?@endif/s', '', $content);
        $content = preg_replace_callback('/\{\{\s*asset\(([\'"])(.*?)\1\)\s*\}\}/', fn ($m) => '/'.ltrim($m[2], '/'), $content);
        $content = str_replace("{{ route('shop.products.index') }}", '/shop', $content);
        $content = str_replace("{{ route('shop.home.contact_us') }}", '/contact-us', $content);
        $content = str_replace("{{ route('shop.home.index') }}", '/', $content);
        $content = preg_replace_callback('/\{\{\s*route\(\s*[\'"]shop\.product_or_category\.index[\'"]\s*,\s*[\'"]([^\'"]+)[\'"]\s*\)\s*\}\}/', fn ($m) => '/'.$m[1], $content);

        return clean_content(trim($content));
    }
}
