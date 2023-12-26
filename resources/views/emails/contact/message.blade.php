<x-mail::message>
    # Contact Information

    Here is the contact information received:

    - **Full Name:** {{ $contact->FullName }}
    - **Phone:** {{ $contact->Phone }}
    - **Email:** {{ $contact->Email }}
    - **Subject:** {{ $contact->Subject }}

    **Message:**
    {{ $contact->Message }}


    Thanks,
    {{ config('app.name') }}
</x-mail::message>
