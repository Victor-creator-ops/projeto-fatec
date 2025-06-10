<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate(['email' => ['required', 'email'], 'password' => ['required']]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // --- LÓGICA DE REDIRECIONAMENTO ---
            $user = Auth::user();
            if ($user->role === 'cliente') {
                return redirect()->route('acompanhamento');
            }

            return redirect()->intended('tasks');
            // --- FIM DA LÓGICA ---
        }
        return back()->withErrors(['email' => 'As credenciais não conferem.'])->onlyInput('email');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}