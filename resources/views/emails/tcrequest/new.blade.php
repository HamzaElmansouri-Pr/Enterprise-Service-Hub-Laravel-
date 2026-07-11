<x-mail::message>
# New Technical Consultation Request

You have received a new TC Request from a potential client.

**Email:** [{{ $tcRequest->email }}](mailto:{{ $tcRequest->email }})  
**Requested Service:** {{ $tcRequest->service ? $tcRequest->service->title : 'N/A' }}  
**File Attached:** {{ $tcRequest->attached_file ? 'Yes' : 'No' }}

**Description:**
<x-mail::panel>
{{ $tcRequest->description }}
</x-mail::panel>

<x-mail::button :url="config('app.url') . '/admin'">
View in Dashboard
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
