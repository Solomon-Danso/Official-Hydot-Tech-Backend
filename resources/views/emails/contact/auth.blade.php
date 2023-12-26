<x-mail::message>
    # Authentication

    *Your Verification Code is*
    {{ $token }}

    *The Code Will Expire In 10 Minutes*
    
    Thanks,
    {{ config('app.name') }}
</x-mail::message>
