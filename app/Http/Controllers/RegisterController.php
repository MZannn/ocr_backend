<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'passwrod' => 'required|min:8'
        ]);

        if($validasi->fails()){
            return back()->with('error',$validasi->errors()->first());
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->to(route('login.index'))->with('success','Akun Berhasil Di Daftarkan');

    }
}
