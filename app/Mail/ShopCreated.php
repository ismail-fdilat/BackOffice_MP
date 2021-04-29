<?php

namespace App\Mail;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ShopCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $shop;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Shop $shop, User $user)
    {
        $this->shop =$shop;
        $this->user =$user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.Shop.created');
    }
}
