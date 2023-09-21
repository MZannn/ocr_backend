<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\resident;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;

class ResidentController extends Controller
{
    public function getAllResidents()
    {
        $residents = resident::all();
        return ResponseFormatter::success(
            $residents,
            'Data Resident Berhasil Diambil'
        );
    }

    public function index()
    {
        return view('resident.index');
    }

    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(),[
            'nama' => 'required|string',
            'nomor' => 'required|max:13',
            'alamat' => 'required'
        ]);

        if($validasi->fails()){
            return response()->json(['status' => 400,'msg' => $validasi->errors()->first()]);
        }

        if($request->id){
            $data = resident::where('id',$request->id)->first();
            resident::where('id',$request->id)->update([
                'name' => $request->nama ?? $data->name,
                'address' => $request->alamat ?? $data->address,
                'phone_number' => $request->nomor ?? $data->phone_number
            ]);

            return response()->json(['status' => 200, 'msg' => 'Data Berhasil Di Edit !']);
        }

        resident::create([
            'name' => $request->nama,
            'address' => $request->alamat,
            'phone_number' => $request->nomor
        ]);

        return response()->json(['status' => 200, 'msg' => 'Data Berhasil Di Simpan !']);
    }

    public function edit($id){
        $data = resident::where('id',$id)->first();
        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function ajaxData()
    {
        $data = resident::all();
        return DataTables::of($data)->addIndexColumn()->toJson();
    }

    public function delete(Request $request)
    {
        resident::where('id',$request->id)->delete();
        return response()->json(['status' => 200 ,'msg' => 'Data Berhasil Di Delete !']);
    }




}
