@component('mail::message')
# Pembayaran terverifikasi, kami akan segera memproses pesanan Anda

Halo, **{{ $mailInfo['customer_name'] }}**  
Terima kasih, ya! Berikut detail pembayaranmu:

@component('mail::table')
|                          |                                       |
| ------------------------ | ------------------------------------- |
| Total Bayar              | **Rp{{ $mailInfo['gross_amount'] }}** |
| Waktu Pembayaran         | **{{ $mailInfo['settlement_time'] }}**|
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
