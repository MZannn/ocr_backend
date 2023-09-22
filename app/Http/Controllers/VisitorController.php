<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use DataTables;

class VisitorController extends Controller
{
    public function sendVisitorData(Request $request)
    {
        $request->validate([
            'identity_number' => 'required',
            'name' => 'required|string',
            'address' => 'required|string',
            'phone_number' => 'required',
            'residents_id' => 'required|integer',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $visitor = Visitor::create([
            'identity_number' => $request->identity_number,
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'residents_id' => $request->residents_id,
            'status' => 'ACTIVE',
            'photo' => $request->file('photo')->store('assets/visitor', 'public'),
        ]);
        return ResponseFormatter::success(
            $visitor,
            'Data Visitor Berhasil Ditambahkan'
        );
    }

    public function getAllVisitor(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $visitors = Visitor::query();
        if ($start_date && $end_date) {
            $visitors->where('status', 'INACTIVE')
                ->whereBetween('created_at', [$start_date, $end_date]);
        } else {
            ($visitors->where('status', 'ACTIVE'));
        }
        return ResponseFormatter::success(
            $visitors->with('resident')->get(),
            'Data Visitor Berhasil Diambil'
        );

    }

    public function changeVisitorStatus($id)
    {
        $visitor = Visitor::find($id);
        if ($visitor) {
            $visitor->update([
                'status' => "INACTIVE",
            ]);
            return ResponseFormatter::success(
                $visitor,
                'Status Visitor Berhasil Diubah'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data Visitor Tidak Ada',
                404
            );
        }
    }
    public function getVisitorById($id)
    {
        $visitor = Visitor::find($id);
        if ($visitor) {
            return ResponseFormatter::success(
                $visitor,
                'Data Visitor Berhasil Diambil'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data Visitor Tidak Ada',
                404
            );
        }
    }
    // public function getVisitorByDateRange(Request $request)
    // {
    //     $request->validate([
    //         'start_date' => 'required',
    //         'end_date' => 'required',
    //     ]);
    //     $visitors = Visitor::whereBetween('created_at', [$request->start_date, $request->end_date])
    //         ->where('status', 'INACTIVE')
    //         ->get();
    //     return ResponseFormatter::success(
    //         $visitors,
    //         'Data Visitor Berhasil Diambil'
    //     );
    // }

    public function index()
    {
        return view('visitor.index');
    }

    public function ajaxData(Request $request)
    {
        $data = Visitor::where('Status','ACTIVE')->with(['resident']);

        if ($request->has('date') && !empty($request->date)) {
            $dates = explode(' - ', $request->date);
            $start = $dates[0];
            $end = $dates[1];
            $data->whereDate('created_at', '>=', $start);
            $data->whereDate('created_at', '<=', $end);
        }

        $data = $data->get();
        return DataTables::of($data)->addIndexColumn()->toJson();
    }
}
