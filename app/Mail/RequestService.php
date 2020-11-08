<?php

namespace App\Mail;

use App\Models\Rent;
use App\Models\Service;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequestService extends Mailable
{
    use Queueable, SerializesModels;
    protected $user, $owner, $service, $rent;

    /**
     * RequestService constructor.
     * @param $user
     * @param $owner
     * @param $service
     * @param Rent $rent
     */
    public function __construct($user, $owner, $service, Rent $rent)
    {
        $this->user = $user;
        $this->owner = $owner;
        $this->service = $service;
        $this->rent = $rent;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.services.new_request')
            ->with([
                'user' => $this->user,
                'owner' => $this->owner,
                'service' => $this->service,
                'rent' => $this->rent,
            ]);
    }
}
