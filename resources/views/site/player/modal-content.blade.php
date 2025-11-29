<div class="player-profile">

    <div class="header">
        @if(isset($player->jersey_number))
            <span class="number">#{{ $player->jersey_number }}</span>
        @endif
        <span class="name">{{ $player->first_name }} {{ $player->last_name }}</span>
    </div>

    <div class="main-content">
        <!-- Player Image -->
        <div class="player-image">
            <img src="/{{ $player->photo }}"
                 alt="{{ $player->first_name }} {{ $player->last_name }}"
                 onerror="this.src='/site/images/players/default_player.jpg'">
        </div>

        <!-- Player Details -->
        <div class="player-details">
            <div class="detail-row">
                <span class="label">Nationality</span>
                <span class="value">
                    {{ isset($player->nationality) ? $player->nationality : 'Not specified' }}
                </span>
            </div>
            <div class="detail-row">
                <span class="label">Position</span>
                <span class="value">{{ isset($player->position) ? ucfirst($player->position) : 'Player' }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Height</span>
                <span class="value">{{ $player->height ? $player->height . ' m' : 'N/A' }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Weight</span>
                <span class="value">{{ $player->weight ? $player->weight . ' kg' : 'N/A' }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Current Team</span>
                <span class="value">{{ isset($player->team->name) ? $player->team->name : 'N/A' }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Age</span>
                <span class="value">{{ $age ?? 'N/A' }}</span>
            </div>
        </div>
    </div>

    <!-- Statistics Section -->
    @if(isset($player->statistics) && $player->statistics->count() > 0)
        <div class="primary-league-section">
            <div class="section-title">PRIMARY LEAGUE</div>
            <table>
                <thead>
                <tr>
                    <th>Season</th>
                    <th>Team</th>
                    <th>Goals</th>
                    <th>Assists</th>
                    <th>Yellow Cards</th>
                    <th>Red Cards</th>
                </tr>
                </thead>
                <tbody>
                @foreach($player->statistics as $stat)
                    <tr>
                        <td>{{ $stat->season ?? 'N/A' }}</td>
                        <td>{{ $stat->team_name ?? 'N/A' }}</td>
                        <td>{{ $stat->goals ?? 0 }}</td>
                        <td>{{ $stat->assists ?? 0 }}</td>
                        <td>{{ $stat->yellow_cards ?? 0 }}</td>
                        <td>{{ $stat->red_cards ?? 0 }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="primary-league-section">
            <div class="section-title">PRIMARY LEAGUE</div>
            <div style="text-align: center; padding: 20px; color: #ccc;">
                No statistics available for this player.
            </div>
        </div>
    @endif
</div>

<style>
    .player-profile {
        font-family: Arial, sans-serif;
        max-width: 100%;
        margin: 0;
        border: 1px solid #e3e6f0;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        background-color: #fff;
        border-radius: 8px;
        overflow: hidden;
    }

    .header {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: white;
        padding: 15px 25px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .header .number {
        font-size: 2.2em;
        font-weight: bold;
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid white;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .header .name {
        font-size: 1.8em;
        font-weight: bold;
    }

    .main-content {
        display: flex;
        padding: 25px;
        gap: 30px;
        align-items: flex-start;
    }

    .player-image {
        flex-shrink: 0;
    }

    .player-image {
        width: 320px;
        height: 320px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid #f8f9fa;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .player-image img {
        width: 300px;
        height: 300px;
        border-radius: 8px;
        object-fit: cover;
        border: 3px solid #f8f9fa;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .player-details {
        flex-grow: 1;
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #e9ecef;
        align-items: center;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-row .label {
        font-weight: 600;
        color: #495057;
        font-size: 0.95rem;
    }

    .detail-row .value {
        color: #2d3748;
        font-weight: 500;
        font-size: 0.95rem;
    }

    .detail-row .value img {
        vertical-align: middle;
        margin-right: 8px;
        height: 16px;
        border-radius: 2px;
    }

    .primary-league-section {
        background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);
        color: white;
        padding: 20px 25px;
    }

    .section-title {
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        background-color: #4a5568;
        border-radius: 6px;
        overflow: hidden;
    }

    table th, table td {
        text-align: left;
        padding: 12px 15px;
        border-bottom: 1px solid #718096;
    }

    table th {
        background-color: #2d3748;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    table tr:last-child td {
        border-bottom: none;
    }

    table tr:hover {
        background-color: #5a6778;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .main-content {
            flex-direction: column;
            text-align: center;
            padding: 20px;
        }

        .player-image img {
            width: 150px;
            height: 150px;
        }

        .header {
            padding: 12px 20px;
        }

        .header .number {
            width: 50px;
            height: 50px;
            font-size: 1.8em;
        }

        .header .name {
            font-size: 1.5em;
        }

        .detail-row {
            flex-direction: column;
            gap: 5px;
            text-align: center;
        }

        table {
            font-size: 0.85rem;
        }

        table th, table td {
            padding: 8px 10px;
        }
    }
</style>
