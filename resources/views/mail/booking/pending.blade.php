<x-mail::message>
# Introduction

Dear {{ $data['name'] }},

This is automatic confirmation of your booking on {{ date('d-m-Y', strtotime($data['date'])) }} at {{ $data['time'] }}. Below are the detail of your booking :

- Restaurant : Yummy Restaurant
- Type : {{ $data['type']}}
- Number of guest : {{ $data['people']}}
- Total price : Rp.{{ number_format($data['amount'], 0, ',', '.') }}

Please wait for our staff to verify your booking. we will send you a verification email once your booking is confirmed.

Best regards,
Yummy Restaurant
</x-mail::message>
