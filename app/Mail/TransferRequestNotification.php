<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\Team;
use App\Models\Player;
use App\Models\PlayerTransfer;

class TransferRequestNotification extends Mailable {

    use Queueable, SerializesModels;

    public $transfer;
    public $player;
    public $fromTeam;
    public $toTeam;

    public function __construct(PlayerTransfer $transfer, Player $player, Team $fromTeam, Team $toTeam) {
        $this->transfer = $transfer;
        $this->player = $player;
        $this->fromTeam = $fromTeam;
        $this->toTeam = $toTeam;
    }


    public function build() {

        return $this->subject('New Player Transfer Request - Requires Your Attention')
            ->markdown('emails.transfer-request-notification')
            ->with([
                'playerName' => $this->player->first_name . ' ' . $this->player->last_name,
                'fromTeam' => $this->fromTeam->name,
                'toTeam' => $this->toTeam->name,
                'transferNotes' => $this->transfer->transfer_notes,
                'transferDate' => $this->transfer->created_at->format('F j, Y'),
                'transferId' => $this->transfer->id,
                'playerPosition' => $this->player->position,
                'playerJersey' => $this->player->jersey_number,
            ]);
    }

}
