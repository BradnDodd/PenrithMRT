<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Recipient extends Model
{
    use Notifiable;
    protected $recipient;
    protected $email;

    public function __construct()
    {
        $this->recipient = config('contact-us.name');
        $this->email = config('contact-us.email');
    }
}
