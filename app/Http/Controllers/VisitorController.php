<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class VisitorController extends Controller
{
    public function sendVisitorData(Request $request)
    {
        $request->validate([
            'identity_number' => 'required',
            'name' => 'required|string',
            'address' => 'required|string',
            'phone_number' => 'required',
            'person_to_visit' => 'required|string',
            'person_address' => 'required|string',
            'person_phone_number' => 'required',
            'date' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $visitor = Visitor::create([
            'identity_number' => $request->identity_number,
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'person_to_visit' => $request->person_to_visit,
            'person_address' => $request->person_address,
            'person_phone_number' => $request->person_phone_number,
            'date' => $request->date,
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
                ->whereBetween('date', [$start_date, $end_date]);
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
    public function getVisitorByDateRange(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        $visitors = Visitor::whereBetween('date', [$request->start_date, $request->end_date])
            ->where('status', 'INACTIVE')
            ->get();
        return ResponseFormatter::success(
            $visitors,
            'Data Visitor Berhasil Diambil'
        );
    }
}