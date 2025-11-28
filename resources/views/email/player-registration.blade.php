<!DOCTYPE html>
<html>
<head>
    <title>Player Registration Confirmation</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #28a745; color: white; padding: 20px; text-align: center; }
        .content { background: #f9f9f9; padding: 20px; border-radius: 5px; }
        .footer { text-align: center; margin-top: 20px; font-size: 12px; color: #666; }
        .info-table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        .info-table td { padding: 8px; border-bottom: 1px solid #ddd; }
        .info-table tr:last-child td { border-bottom: none; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Player Registration Confirmation</h1>
    </div>

    <div class="content">
        <h2>Hello {{ $player->first_name }} {{ $player->last_name }},</h2>

        <p>Thank you for registering as a player with us! Your registration has been successfully processed.</p>

        <h3>Your Registration Details:</h3>
        <table class="info-table">
            <tr>
                <td><strong>Name:</strong></td>
                <td>{{ $player->first_name }} {{ $player->last_name }}</td>
            </tr>
            <tr>
                <td><strong>Position:</strong></td>
                <td>{{ $player->position }}</td>
            </tr>
            @if($player->jersey_number)
                <tr>
                    <td><strong>Jersey Number:</strong></td>
                    <td>#{{ $player->jersey_number }}</td>
                </tr>
            @endif
            <tr>
                <td><strong>Nationality:</strong></td>
                <td>{{ $player->nationality }}</td>
            </tr>
            <tr>
                <td><strong>Date of Birth:</strong></td>
                <td>{{ \Carbon\Carbon::parse($player->date_of_birth)->format('F j, Y') }}</td>
            </tr>
            @if($player->team)
                <tr>
                    <td><strong>Team:</strong></td>
                    <td>{{ $player->team->name }}</td>
                </tr>
            @endif
            @if($player->phone_no)
                <tr>
                    <td><strong>Phone:</strong></td>
                    <td>{{ $player->phone_no }}</td>
                </tr>
            @endif
            <tr>
                <td><strong>Email:</strong></td>
                <td>{{ $player->email }}</td>
            </tr>
        </table>

        <p><strong>Status:</strong> Your player registration is <span style="color: #28a745; font-weight: bold;">active</span>.</p>

        <p>You can now participate in team activities and matches. Please keep this email for your records.</p>

        <p>If you have any questions or need to update your information, please contact your team manager or our support team.</p>

        <p>Best regards,<br>
            The Management Team<br>
            {{ config('app.name') }}</p>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</div>
</body>
</html>