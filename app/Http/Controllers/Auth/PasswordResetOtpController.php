<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetOtpMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class PasswordResetOtpController extends Controller
{
    public function showRequestForm(): View
    {
        return view('auth.resetpw');
    }

    public function sendOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.'])->withInput();
        }

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expiresAt = now()->addMinutes(10);

        // Invalidate any previous OTPs for this email and insert a fresh one
        DB::table('password_reset_tokens')->where('reset_email', $user->email)->delete();

        DB::table('password_reset_tokens')->insert([
            'reset_email' => $user->email,
            'reset_otp' => $otp,
            'expires_at' => $expiresAt,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Mail::to($user->email)->send(new PasswordResetOtpMail($user, $otp));

        return redirect()->route('otpReset', ['email' => $user->email])
            ->with('status', 'Kode OTP telah dikirim ke email Anda. Silakan cek inbox Gmail Anda.');
    }

    public function showOtpForm(Request $request): View
    {
        $email = $request->query('email');

        if (! $email) {
            return redirect()->route('resetPW')->with('status', 'Silakan masukkan email terlebih dahulu untuk menerima kode OTP.');
        }

        return view('auth.otpReset', [
            'email' => $email,
        ]);
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'otp' => ['required', 'digits:6'],
            'password' => ['required', 'confirmed'],
        ]);

        $token = DB::table('password_reset_tokens')
            ->where('reset_email', $request->email)
            ->first();

        if (! $token) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid.'])->withInput();
        }

        // Check OTP value first
        if ($token->reset_otp !== $request->otp) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid.'])->withInput();
        }

        // Check expiration using Carbon parse to avoid type issues
        try {
            $expiresAt = \Illuminate\Support\Carbon::parse($token->expires_at);
        } catch (\Exception $e) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid atau format tanggal salah.'])->withInput();
        }

        if ($expiresAt->isPast()) {
            return back()->withErrors(['otp' => 'Kode OTP sudah kedaluwarsa. Silakan minta kode baru.'])->withInput();
        }

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.'])->withInput();
        }

        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')->where('reset_email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password berhasil direset. Silakan masuk dengan password baru Anda.');
    }
}
