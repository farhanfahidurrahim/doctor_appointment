<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Doctor;
use App\Models\Department;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class IndexController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }

    public function doctorList()
    {
        $data = Doctor::all();
        return view('frontend.doctor', compact('data'));
    }

    public function appointment()
    {
        $departments = Department::all();
        return view('frontend.appointment', compact('departments'));
    }

    public function appointmentStore(Request $request)
    {
        //return $request->all();
        $request->validate([
            'appointment_date' => 'required',
            'doctor_id' => 'required',
        ]);

        $doctor = DB::table('doctors')->where('id', $request->doctor_id)->first();
        //return $doctor_name;
        $appoint = [];
        $total_fee = 0;
        if (Session::has('appointment_details')) {
            $appoint = Session::get('appointment_details');
            if (Session::has('total_appointment_fee')) {
                $total_fee = Session::get('total_appointment_fee') + $doctor->fee;
            }
        } else {
            $total_fee = $doctor->fee;
        }
        array_push($appoint, [
            'appointment_date' => $request->appointment_date,
            'doctor_name' => $doctor->name,
            'doctor_id' => $doctor->id,
            'fee' => $doctor->fee,
        ]);

        Session::put('total_appointment_fee', $total_fee);
        Session::put('appointment_details', $appoint);

        //$session_data=Session::get('appointment_detials');
        //return $session_data;
        return redirect()->back();
    }

    //Ajax Doctor Fee
    public function getDoctorFee($id)
    {
        $data = DB::table('doctors')->where('id', $id)->get();
        return response()->json($data);
    }

    public function appointmentSubmit(Request $request)
    {
        //return $request->all();
        $request->validate([
            'patient_name' => 'required',
            'patient_phone' => 'required',
            'paid_amount' => 'required',
            // 'doctor_name' => 'required',
        ]);

        $doc_ids = [];
        if (Session::has('appointment_details')) {
            $appointment_details = Session::get('appointment_details');
        }

        //return $appointment_details;

        $created = false;
        for ($i = 0; $i < count($appointment_details); $i++) {
            $data = $request->all();
            $doctorId = DB::table('doctors')->where('id', $appointment_details[$i]['doctor_id'])->first();
            $data['doctor_id'] = $doctorId->id;
            $data['appointment_date'] = $appointment_details[$i]['appointment_date'];
            $totalFee = 0;
            if (Session::has('total_appointment_fee')) {
                $totalFee = Session::get('total_appointment_fee');
            }
            $data['total_fee'] = $totalFee;
            // $data['appointment_no'] = (string) Str::uuid();
            $data['appointment_no']=Str::upper('SlNo-'.Str::random(6));

            $paidAmount = $request->input('paid_amount');

            if ($totalFee == $paidAmount) {
                Appointment::create($data);
                $created = true;
            }
        }
        if ($created) {
            Session::forget('appointment_details');
            Session::forget('total_appointment_fee');
            return redirect()->back()->with('success', "Appointment created successfully");
        } else {
            return redirect()->back()->with('error', 'Total amount and paid amount are not equal');
        }
    }
}
