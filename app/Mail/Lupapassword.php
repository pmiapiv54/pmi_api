<?php namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Lupapassword extends Mailable
{
    use Queueable, SerializesModels;

    /** @var string the address to send the email */
    protected $to_address;

    /** @var float the winnings they won */
    protected $winnings;
    protected $kode;
    protected $nama;

    /**
     * Create a new message instance.
     *
     * @param string $to_address the address to send the email
     * @param float $winnings   the winnings they won
     * 
     * @return void
     */
    public function __construct($to_address, $winnings, $kode, $nama)
    {
        $this->to_address = $to_address;
        $this->winnings = $winnings;
        $this->kode = $kode;
        $this->nama = $nama;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->to($this->to_address)
            ->subject('Konfirmasi Lupa Sandi')
            ->view('email.lupas')
            ->with(
                [
                    'nama' => $this->nama,
                    'kode'  => $this->kode,
                    'winnings' => $this->winnings
                ]
            );
    }
}