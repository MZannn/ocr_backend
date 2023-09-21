<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required|min:8'
        ],[
            'email.required' => 'Email harus di isi !',
            'email.email' => 'Email tidak valid !',
            'password.required' => 'Password harus di isi !',
            'password.min' => 'Password harus 8 karakter !'
        ]);

        if($validasi->fails()){
            return back()->with('errors',$validasi->errors()->first());
        }

        $user = User::where('email', $request->email)->where('roles','Admin')->first();
        if($user){
            if(Hash::check($request->password,$user->password)){
                if(Auth::attempt(['email' => $request->email,'password' => $request->password])){
                    return redirect()->intended('/');
                }else{
                    return back()->with('errors','Login Gagal !');
                }
            }else{
                return back()->with('errors','Password tidak sama !');
            }
        }

        return back()->with('errors','User tidak terdaftar');

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->to(route('login'))->with('success','Anda Berhasil Logout !');
    }
}
