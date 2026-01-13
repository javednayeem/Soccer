@component('mail::message')
# Transfer Request Submitted Successfully

Hello {{ $playerName }},

Your request to transfer from **{{ $fromTeam }}** to **{{ $toTeam }}** has been successfully submitted.

**Request Details:**
- **Date Submitted:** {{ $transferDate }}
- **Current Team:** {{ $fromTeam }}
- **Destination Team:** {{ $toTeam }}
- **Status:** Pending Approval

@if($transferNotes)
    **Your Notes:**
    {{ $transferNotes }}
@endif

The team managers have been notified and will review your request. You will receive another email once a decision has been made.

You cannot submit another transfer request until this one has been processed.

Thank you for using our transfer system.

@component('mail::button', ['url' => url('/'), 'color' => 'primary'])
Visit Our Website
@endcomponent

Regards,<br>
{{ config('app.name') }}
@endcomponent