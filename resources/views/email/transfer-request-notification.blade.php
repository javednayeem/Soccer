@component('mail::message')
# New Player Transfer Request

A player has submitted a transfer request that requires your attention.

**Player Details:**
- **Name:** {{ $playerName }}
- **Current Team:** {{ $fromTeam }}
- **Position:** {{ $playerPosition }}
- **Jersey Number:** {{ $playerJersey ? '#' . $playerJersey : 'N/A' }}

**Transfer Request:**
- **Destination Team:** {{ $toTeam }}
- **Date Submitted:** {{ $transferDate }}
- **Request ID:** #{{ $transferId }}

@if($transferNotes)
    **Player's Notes:**
    {{ $transferNotes }}
@endif

Please log in to the admin panel to review and process this transfer request.

@component('mail::button', ['url' => url('/transfer-requests' . $transferId), 'color' => 'primary'])
Review Transfer Request
@endcomponent

**Action Required:** Please process this request within 3-5 business days.

Regards,<br>
{{ config('app.name') }} Team Management System
@endcomponent