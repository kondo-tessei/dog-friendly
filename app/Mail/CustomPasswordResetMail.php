<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomPasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $resetUrl;

    public function __construct($email, $token)
    {
        // ここでトークンをURLに含める
        $this->resetUrl = url('/reset-password/' . $token . '/' . $email);
    }

    public function build()
    {
        return $this->subject('カスタムパスワードリセット')
                    ->view('emails.custom-password-reset');
    }
}