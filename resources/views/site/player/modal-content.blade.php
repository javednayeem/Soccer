<div class="player-modal-header">
    @if(isset($player->jersey_number))
        <div class="player-number-badge">
            {{ $player->jersey_number }}
        </div>
    @endif
    <h1 class="player-name mb-0">{{ $player->first_name }} {{ $player->last_name }}</h1>
</div>

<div class="player-content">

    <div class="player-image-section">
        <img src="/{{ $player->photo }}" alt="{{ $player->first_name }} {{ $player->last_name }}"
             class="player-image"
             onerror="this.src='/site/images/players/default_player.jpg'">
    </div>

    <div class="player-info">
        <div class="info-row">
            <span class="info-label">Nationality</span>
            <span class="info-value">{{ isset($player->nationality) ? $player->nationality : 'Not specified' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Position</span>
            <span class="info-value">{{ isset($player->position) ? ucfirst($player->position) : 'Player' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Height</span>
            <span class="info-value">{{ $player->height ? $player->height . ' m' : 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Weight</span>
            <span class="info-value">{{ $player->weight ? $player->weight . ' kg' : 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Current Team</span>
            <span class="info-value">{{ isset($player->team->name) ? $player->team->name : 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Age</span>
            <span class="info-value">
                {{ $age }}
            </span>
        </div>
    </div>

    @if(isset($player->statistics) && $player->statistics->count() > 0)
        <div class="stats-section">
            <div class="stats-header">
                <h2>PLAYER STATISTICS</h2>
            </div>
            <div class="stats-table">
                <div class="table-header">
                    <div class="table-cell">Season</div>
                    <div class="table-cell">Team</div>
                    <div class="table-cell">Goals</div>
                    <div class="table-cell">Assists</div>
                    <div class="table-cell">Yellow Cards</div>
                    <div class="table-cell">Red Cards</div>
                </div>
                @foreach($player->statistics as $stat)
                    <div class="table-row">
                        <div class="table-cell">{{ $stat->season ?? 'N/A' }}</div>
                        <div class="table-cell">{{ $stat->team_name ?? 'N/A' }}</div>
                        <div class="table-cell">{{ $stat->goals ?? 0 }}</div>
                        <div class="table-cell">{{ $stat->assists ?? 0 }}</div>
                        <div class="table-cell">{{ $stat->yellow_cards ?? 0 }}</div>
                        <div class="table-cell">{{ $stat->red_cards ?? 0 }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="stats-section">
            <div class="stats-header">
                <h2>PLAYER STATISTICS</h2>
            </div>
            <p class="text-center text-muted py-3">No statistics available for this player.</p>
        </div>
    @endif
</div>
