<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * 🔐 Login Web (Session)
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|max:50',
            'password' => 'required|max:50',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->withErrors(['login' => 'Email atau password salah']);
        }

        $user = Auth::user();

        return redirect('/home');
    }

    /**
     * 🧾 Register Web (Session)
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|max:50',
            'email'    => 'required|email|max:50|unique:users',
            'password' => 'required|max:50|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'status'   => 'active',
            'role'     => 'customer',
        ]);

        Auth::login($user);

        return redirect('/home');
    }

    

       /**
 * 🔐 Google Login untuk Flutter (API)
 * Dipanggil dari route: POST /auth/google
 */
/**
 * 🔐 Google Login untuk Flutter (Android)
 * Dipanggil dari route: POST /auth/google
 */
public function google(Request $request)
{
    $request->validate([
        'id_token' => 'required|string',
    ]);

    try {
        // Verifikasi token Google
        $googleUser = Socialite::driver('google')
            ->stateless()
            ->userFromToken($request->id_token);

        // Cari atau buat user baru
        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name'      => $googleUser->getName() ?? 'Google User',
                'google_id' => $googleUser->getId(),
                'password'  => bcrypt(Str::random(24)),
                'status'    => 'active',
                'role'      => 'customer',   // default untuk user Flutter/Android
            ]
        );

        // Jika user sudah ada tapi belum punya google_id, update
        if (!$user->google_id) {
            $user->update(['google_id' => $googleUser->getId()]);
        }

        // Buat Sanctum Token
        $token = $user->createToken('google-login-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login Google berhasil',
            'user'    => $user,
            'token'   => $token,
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Token Google tidak valid atau expired',
            'error'   => $e->getMessage()
        ], 401);
    }
}
   

    /**
     * 🌐 Login Google Web
     */
    public function google_redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function google_callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::firstOrCreate(
                ['email' => $googleUser->email],
                [
                    'name'     => $googleUser->name,
                    'password' => bcrypt(Str::random(16)),
                    'status'   => 'active',
                    'role'     => 'customer',
                ]
            );

            Auth::login($user);

            return redirect('/');
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['google' => 'Google login gagal']);
        }
    }
    

    /**
     * 🚪 Logout Web
     */
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }

    /**
     * 🔐 Login API (Sanctum)
     */
    public function loginApi(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|max:50',
            'password' => 'required|max:50',
        ]);
        

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Email atau password salah'], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'user'    => $user,
            'token'   => $token,
        ]);
    }

    /**
     * 🧾 Register API (Sanctum)
     */
    public function registerApi(Request $request)
    {
        $request->validate([
            'name'     => 'required|max:50',
            'email'    => 'required|email|max:50|unique:users',
            'password' => 'required|max:50|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'status'   => 'active',
            'role'     => 'customer',
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Register berhasil',
            'user'    => $user,
            'token'   => $token,
        ]);
    }

    /**
     * 🚪 Logout API (Sanctum)
     */
    public function logoutApi(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout berhasil']);
    }
}