@component('mail::message')
# Menunggu pembayaran

Halo, **{{ $mailInfo['customer_name'] }}**  
Silakan lakukan pembayaran pesananmu sebelum **{{ $mailInfo['payment_expired_at'] }}** dengan detail sebagai berikut:

@component('mail::table')
|                          |                                       |
| ------------------------ | ------------------------------------- |
| Total Bayar              | **Rp{{ $mailInfo['gross_amount'] }}** |
| Metode Pembayaran        | **{{ $mailInfo['payment_method'] }}** |
| Kode Virtual Account     | **{{ $mailInfo['va_number'] }}**      |
@endcomponent

**Alamat Pengiriman**  
{{ $mailInfo['customer_name'] }}  
{{ $mailInfo['address'] }}, {{ $mailInfo['city'] }}, {{ $mailInfo['state'] }}, {{ $mailInfo['postcode'] }}  
{{ $mailInfo['phone'] }}

<!-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent -->

Thanks,<br>
{{ config('app.name') }}
@endcomponent
