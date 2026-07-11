<x-mail::message>
# Hello {{ $contact->name }},

{!! nl2br(e($replyMessage)) !!}

<x-mail::panel>
**Your Original Inquiry:**

{{ $contact->message }}
</x-mail::panel>

Best regards,<br>
{{ config('app.name') }}
</x-mail::message>
