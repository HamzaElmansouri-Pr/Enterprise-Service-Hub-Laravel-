<x-mail::message>
# New Contact Form Submission

You have received a new contact form submission.

**Name:** {{ $contact->name }}  
**Email:** [{{ $contact->email }}](mailto:{{ $contact->email }})  
**Phone:** {{ $contact->phone ?? 'N/A' }}  
**Subject:** {{ $contact->subject }}

**Message:**
<x-mail::panel>
{{ $contact->message }}
</x-mail::panel>

<x-mail::button :url="config('app.url') . '/admin'">
View in Dashboard
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
