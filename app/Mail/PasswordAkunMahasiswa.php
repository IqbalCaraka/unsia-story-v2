<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordAkunMahasiswa extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Password dikirim sebagai nilai biasa, bukan diambil ulang dari database:
     * yang tersimpan di sana sudah berupa hash dan tidak bisa dibaca kembali.
     */
    public function __construct(
        public User $user,
        public string $password,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Password Akun UNSIA Story Anda',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.password-akun-mahasiswa',
        );
    }
}
