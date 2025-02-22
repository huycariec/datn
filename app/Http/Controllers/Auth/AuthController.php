<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);
        return redirect('/')->with('message', 'Đăng kí toàn khoản thành công!');
        //return response()->json(['message' => 'Đăng ký thành công'], 200);
    }


    public function showRegisterForm()
    {
        return view('auth.register');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect('/')->with('message', 'Đăng nhập thành công!');
        }

        return redirect()->back()->with('error', 'Tài khoản hoặc mật khẩu không đúng!');
    }
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function logout(Request $request)
    {
        Auth::logout(); // Đăng xuất người dùng

        // Chuyển hướng về trang chủ hoặc trang bạn muốn
        return redirect('/')->with('message', 'Đăng xuất thành công!');
    }
}
