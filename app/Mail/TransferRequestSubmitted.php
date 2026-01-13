<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\Player;
use App\Models\PlayerTransfer;

class TransferRequestSubmitted extends Mailable {

    use Queueable, SerializesModels;

    public $transfer;
    public $player;

    public function __construct(PlayerTransfer $transfer, Player $player) {
        $this->transfer = $transfer;
        $this->player = $player;
    }


    public function build() {

        return $this->subject('Your Team Transfer Request Has Been Submitted')
            ->markdown('emails.transfer-request-submitted')
            ->with([
                'playerName' => $this->player->first_name . ' ' . $this->player->last_name,
                'fromTeam' => $this->transfer->fromTeam->name,
                'toTeam' => $this->transfer->toTeam->name,
                'transferNotes' => $this->transfer->transfer_notes,
                'transferDate' => $this->transfer->created_at->format('F j, Y'),
            ]);

    }
}
