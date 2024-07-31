<x-mail::message>
Hello {{ $data->name }},

Your OTP is: **{{ $data->otp }}**

Please OTP expire at **{{$data->otp_expires_at}}**.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
