<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\PlayerTransfer;

class TransferStatusUpdated extends Mailable {

    use Queueable, SerializesModels;

    public $transfer;
    public $status;
    public $player;
    public $fromTeam;
    public $toTeam;
    public $reason;


    public function __construct(PlayerTransfer $transfer, $status, $reason = null) {

        $this->transfer = $transfer;
        $this->status = $status;
        $this->player = $transfer->player;
        $this->fromTeam = $transfer->fromTeam;
        $this->toTeam = $transfer->toTeam;
        $this->reason = $reason;

    }

    public function build() {

        $subject = $this->status === 'approved' ? 'Your Team Transfer Request Has Been Approved' : 'Your Team Transfer Request Has Been Rejected';

        return $this->subject($subject)->markdown('email.transfer-status-updated');

    }
}
