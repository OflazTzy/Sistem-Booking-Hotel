<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Mailable Class untuk Pengiriman Kode OTP Verifikasi Login & Registrasi Nginap.
 */
class SendOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otpCode;

    /**
     * Create a new message instance.
     */
    public function __construct($otpCode)
    {
        $this->otpCode = $otpCode;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Kode Verifikasi OTP Anda - Nginap Platform')
                    ->html("
                        <div style='font-family: Arial, sans-serif; max-width: 500px; margin: 0 auto; padding: 24px; border: 1px solid #e7d8ca; border-radius: 20px; background-color: #ffffff;'>
                            <div style='text-align: center; margin-bottom: 20px;'>
                                <h2 style='color: #c85a32; margin-bottom: 4px; font-weight: 800; font-size: 24px;'>Nginap<span style='color: #7a331c;'>.</span></h2>
                                <p style='color: #714331; font-size: 13px; margin-top: 0; font-weight: 600;'>Verifikasi Keamanan OTP 2FA</p>
                            </div>
                            <hr style='border: none; border-top: 1px solid #f4ede6; margin: 20px 0;'>
                            <p style='color: #321c16; font-size: 14px;'>Halo,</p>
                            <p style='color: #5c382b; font-size: 14px; line-height: 1.5;'>Kode OTP 6-digit verifikasi keamanan untuk akun Nginap Anda adalah:</p>
                            <div style='text-align: center; margin: 25px 0;'>
                                <span style='font-family: monospace; font-size: 32px; font-weight: 900; color: #c85a32; letter-spacing: 6px; background-color: #faf6f3; padding: 12px 28px; border-radius: 14px; border: 2px dashed #c85a32; display: inline-block;'>{$this->otpCode}</span>
                            </div>
                            <p style='color: #8a5137; font-size: 12px; text-align: center;'>Kode ini berlaku selama <strong>5-10 menit</strong>. Jangan berikan kode ini kepada siapapun.</p>
                        </div>
                    ");
    }
}
