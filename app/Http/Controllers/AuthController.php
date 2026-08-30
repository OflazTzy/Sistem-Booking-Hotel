<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;
use Exception;

/**
 * [SOAL 2 IMPLEMENTASI LARAVEL]: Controller Autentikasi & Verifikasi OTP
 * - Admin Login: Email + Password + Verifikasi Kode OTP 2FA via Email.
 * - User/Tamu Login: Email + Password (Autentikasi Langsung).
 * - User/Tamu Register: Form Identitas + Verifikasi Email OTP 6-Digit.
 */
class AuthController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Memproses login.
     * Jika Admin -> Meminta Kode OTP via Email (2FA).
     * Jika Tamu/User -> Langsung Login tanpa OTP.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // 1. Validasi kredensial email & password
        if (!Auth::validate($credentials)) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->onlyInput('email');
        }

        $user = User::where('email', $credentials['email'])->first();

        // 2. JIKA AKUN ADMINISTRATOR -> WAJIB OTP 2FA VIA EMAIL
        if ($user->isAdmin()) {
            $otpCode = rand(100000, 999999);

            $request->session()->put('otp_user_id', $user->id);
            $request->session()->put('otp_email', $user->email);
            $request->session()->put('otp_code', (string) $otpCode);
            $request->session()->put('otp_expires_at', now()->addMinutes(5));

            try {
                Mail::to($user->email)->send(new SendOtpMail($otpCode));
            } catch (Exception $e) {
                // Abaikan kesalahan SMTP lokal
            }

            return redirect()->route('login')
                ->with('show_otp_modal', true)
                ->with('success', 'Password benar! Kode OTP 2FA Administrator telah dikirimkan ke email ' . $user->email);
        }

        // 3. JIKA AKUN TAMU / USER -> LANGSUNG LOGIN HANYA DENGAN PASSWORD
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')
            ->with('success', 'Login berhasil! Selamat datang kembali, ' . $user->name . '!');
    }

    /**
     * [SOAL 2 IMPLEMENTASI LARAVEL]: Memproses Verifikasi Kode OTP 2FA Email Khusus Admin
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|string|size:6',
        ], [
            'otp_code.required' => 'Kode OTP 6-digit wajib diisi.',
            'otp_code.size'     => 'Kode OTP harus berjumlah 6 digit.',
        ]);

        $userId      = $request->session()->get('otp_user_id');
        $sessionCode = $request->session()->get('otp_code');
        $expiresAt   = $request->session()->get('otp_expires_at');

        if (!$userId || !$sessionCode) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Sesi OTP tidak ditemukan. Silakan login kembali.']);
        }

        if (now()->greaterThan($expiresAt)) {
            $request->session()->forget(['otp_user_id', 'otp_email', 'otp_code', 'otp_expires_at']);
            return redirect()->route('login')
                ->withErrors(['email' => 'Kode OTP telah kadaluarsa. Silakan login ulang.']);
        }

        if ((string)$request->otp_code !== (string)$sessionCode) {
            return redirect()->route('login')
                ->with('show_otp_modal', true)
                ->withErrors(['otp_code' => 'Kode OTP Admin yang Anda masukkan salah. Coba lagi!']);
        }

        // Login Admin
        Auth::loginUsingId($userId);
        $request->session()->regenerate();
        $request->session()->forget(['otp_user_id', 'otp_email', 'otp_code', 'otp_expires_at']);

        return redirect()->route('dashboard')
            ->with('success', 'Verifikasi OTP Admin Berhasil! Selamat datang, ' . Auth::user()->name . '!');
    }

    /**
     * Menampilkan halaman register.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Memproses registrasi Tamu Baru: Menyiapkan data & Mengirim OTP Verifikasi Email.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email',
            'identity_number' => 'required|string|max:50',
            'phone'           => 'required|string|max:20',
            'password'        => 'required|string|min:6|confirmed',
        ], [
            'name.required'            => 'Nama lengkap wajib diisi.',
            'email.required'           => 'Email wajib diisi.',
            'email.email'              => 'Format email tidak valid.',
            'email.unique'             => 'Email sudah terdaftar.',
            'identity_number.required' => 'Nomor identitas (KTP/SIM) wajib diisi.',
            'phone.required'           => 'Nomor HP wajib diisi.',
            'password.required'        => 'Password wajib diisi.',
            'password.min'             => 'Password minimal 6 karakter.',
            'password.confirmed'       => 'Konfirmasi password tidak cocok.',
        ]);

        // Generate OTP Verifikasi Email Registrasi
        $otpCode = rand(100000, 999999);

        // Simpan draf data pendaftaran di Session
        $request->session()->put('reg_name', $validated['name']);
        $request->session()->put('reg_email', $validated['email']);
        $request->session()->put('reg_identity', $validated['identity_number']);
        $request->session()->put('reg_phone', $validated['phone']);
        $request->session()->put('reg_password', Hash::make($validated['password']));
        $request->session()->put('reg_otp_code', (string) $otpCode);
        $request->session()->put('reg_otp_expires_at', now()->addMinutes(10));

        // Kirim Email OTP
        try {
            Mail::to($validated['email'])->send(new SendOtpMail($otpCode));
        } catch (Exception $e) {
            // Abaikan kesalahan SMTP
        }

        return redirect()->route('register')
            ->with('show_reg_otp_modal', true)
            ->with('success', 'Kode OTP Verifikasi Email telah dikirimkan ke ' . $validated['email'] . '. Silakan masukkan kode OTP untuk menyelesaikan pendaftaran.');
    }

    /**
     * Memproses verifikasi OTP Registrasi Tamu Baru & Membuat Akun User.
     */
    public function verifyRegisterOtp(Request $request)
    {
        $request->validate([
            'reg_otp_code' => 'required|string|size:6',
        ], [
            'reg_otp_code.required' => 'Kode OTP 6-digit verifikasi email wajib diisi.',
            'reg_otp_code.size'     => 'Kode OTP harus berjumlah 6 digit.',
        ]);

        $regEmail   = $request->session()->get('reg_email');
        $otpCode    = $request->session()->get('reg_otp_code');
        $expiresAt  = $request->session()->get('reg_otp_expires_at');

        if (!$regEmail || !$otpCode) {
            return redirect()->route('register')
                ->withErrors(['email' => 'Sesi pendaftaran tidak ditemukan. Silakan isi kembali form pendaftaran.']);
        }

        if (now()->greaterThan($expiresAt)) {
            $request->session()->forget(['reg_name', 'reg_email', 'reg_identity', 'reg_phone', 'reg_password', 'reg_otp_code', 'reg_otp_expires_at']);
            return redirect()->route('register')
                ->withErrors(['email' => 'Kode OTP verifikasi email kadaluarsa. Silakan mendaftar ulang.']);
        }

        if ((string)$request->reg_otp_code !== (string)$otpCode) {
            return redirect()->route('register')
                ->with('show_reg_otp_modal', true)
                ->withErrors(['reg_otp_code' => 'Kode OTP verifikasi email salah. Silakan periksa email Anda dan coba lagi!']);
        }

        // Buat akun Tamu baru di database
        $user = User::create([
            'name'            => $request->session()->get('reg_name'),
            'email'           => $request->session()->get('reg_email'),
            'identity_number' => $request->session()->get('reg_identity'),
            'phone'           => $request->session()->get('reg_phone'),
            'password'        => $request->session()->get('reg_password'),
            'role'            => 'user',
        ]);

        // Bersihkan sesi registrasi & login user
        $request->session()->forget(['reg_name', 'reg_email', 'reg_identity', 'reg_phone', 'reg_password', 'reg_otp_code', 'reg_otp_expires_at']);
        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Registrasi & Verifikasi Email Berhasil! Selamat datang, ' . $user->name . '!');
    }

    /**
     * Memproses logout pengguna.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda berhasil logout.');
    }
}
