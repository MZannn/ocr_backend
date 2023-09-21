<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DataTables;

class SecurityController extends Controller
{
    public function index()
    {
        return view('security.index');
    }

    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(),[
            'nama' => 'required',
            'email' => 'required|email'
        ]);

        if($validasi->fails()){
            return response()->json(['status' => 400,'msg' => $validasi->errors()->first()]);
        }

        if($request->id){
            $user = User::where('id',$request->id)->first();
            User::where('id',$request->id)->update([
                'name' => $request->nama ?? $user->name,
                'email' => $request->email ?? $user->email,
                'password' => $request->password ? Hash::make($request->password) : $user->password
            ]);


            return response()->json(['status' => 200,'msg' => 'Data Berhasil Di Edit']);
        }


        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'roles' => 'Security'
        ]);

        return response()->json(['status' => 200,'msg' => 'Data Berhasil Di Simpan']);
    }

    public function ajaxData()
    {
        $data = User::where('roles','!=','Admin')->get();
        return DataTables::of($data)->addIndexColumn()->toJson();
    }
}
