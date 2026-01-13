@component('mail::message')
@if($status === 'approved')
    # 🎉 Transfer Request Approved!

    Hello **{{ $player->first_name }} {{ $player->last_name }}**,

    We're pleased to inform you that your transfer request has been **approved** by the team management.

    ## Transfer Details:
    - **From Team:** {{ $fromTeam->name }}
    - **To Team:** {{ $toTeam->name }}
    - **Approval Date:** {{ \Carbon\Carbon::parse($transfer->approved_at)->format('F j, Y') }}
    - **New Team Status:** Active Member

    ## What happens next:
    1. Your player profile has been updated with the new team
    2. You are now officially a member of **{{ $toTeam->name }}**
    3. You can start participating in team activities immediately

    If you have any questions about your transfer or need further assistance, please contact your new team manager.

@else
    # ❌ Transfer Request Rejected

    Hello **{{ $player->first_name }} {{ $player->last_name }}**,

    Your transfer request has been reviewed by the team management and unfortunately, it has been **rejected**.

    ## Transfer Details:
    - **From Team:** {{ $fromTeam->name }}
    - **To Team:** {{ $toTeam->name }}
    - **Review Date:** {{ \Carbon\Carbon::now()->format('F j, Y') }}
    - **Current Status:** You remain with **{{ $fromTeam->name }}**

    @if($reason)
        ## Rejection Reason:
        {{ $reason }}
    @else
        ## Additional Information:
        The decision was made based on team requirements and management considerations.
    @endif

    ## What this means:
    1. You will continue playing for **{{ $fromTeam->name }}**
    2. You may submit a new transfer request after 30 days
    3. If you have questions about this decision, please contact your current team manager

@endif

Thank you for your understanding and cooperation.

@component('mail::button', ['url' => url('/'), 'color' => $status === 'approved' ? 'success' : 'primary'])
Visit Our Website
@endcomponent

Best regards,<br>
**{{ config('app.name') }} Team Management**
@endcomponent