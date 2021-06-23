<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {

        $this->middleware(['auth']);

    }

    public function schedule()
    {
        
        $user_id = Auth::id();

        $appointments = Appointment::where('doctor_id', $user_id)->first();

        $date = "2021-06-18";

        $appointment_today = Appointment::where('doctor_id', $user_id)->where('date', $date)->orderBy('time', 'asc')->get();
         
        // $appointment_today = Appointment::where('doctor_id', $user_id)->where('date', date('Y-m-d'))->orderBy('time', 'asc')->get();

        if(isset($_GET['search'])) {

            $appointment_upcoming = Appointment::join(config('app.user_database').'.users', 'appointments.user_id', '=', 'users.id')
                     ->select('appointments.*', 'appointments.user_id', 'users.name', 'users.phone_no')->where('doctor_id', $user_id)
                     ->where('date','>', date('Y-m-d'))
                     ->where(function ($query) {
                        $query->where('appointments.type', 'LIKE', '%' . $_GET['search'] . '%')
                            ->orWhere('date', 'LIKE', '%' . $_GET['search'] . '%')
                            ->orWhere('title', 'LIKE', '%' . $_GET['search'] . '%')
                            ->orWhere('category', 'LIKE', '%' . $_GET['search'] . '%')
                            ->orWhere('name', 'LIKE', '%' . $_GET['search'] . '%')
                            ->orWhere('phone_no', 'LIKE', '%' . $_GET['search'] . '%');
                    })->orderBy('date', 'asc')->orderBy('time', 'asc')->paginate(10);

        }
        else{

            $appointment_upcoming = Appointment::where('doctor_id', $user_id)->where('date', '>', date('Y-m-d'))->orderBy('date', 'asc')->orderBy('time', 'asc')->paginate(10);

        }

        $appointment_next_date = Appointment::where('doctor_id', $user_id)->where('date', '>', date('Y-m-d'))->first();
        

        if(isset($appointment_next_date)){
            
            $appointment_next = Appointment::where('doctor_id', $user_id)->where('date',  $appointment_next_date->date)->orderBy('time', 'asc')->get();  

        }

        else{

            $appointment_next = null;

        }

        return view('appointment.schedule', compact('appointments', 'appointment_today', 'appointment_next', 'appointment_next_date', 'appointment_upcoming'));
        // return view('appointment.schedule');
    }

    public function history()
    {
        $user_id = Auth::id();

        if(isset($_GET['search'])) {

            // ->where('doctor_id', $user_id)
            
            $appointment_history = Appointment::join(config('app.user_database').'.users', 'appointments.user_id', '=', 'users.id')
                     ->select('appointments.*', 'users.name', 'users.phone_no')->where('date','<', date('Y-m-d'))
                     ->where('doctor_id', $user_id)
                     ->where(function ($query) {
                        $query->where('type', 'LIKE', '%' . $_GET['search'] . '%')
                            ->orWhere('date', 'LIKE', '%' . $_GET['search'] . '%')
                            ->orWhere('title', 'LIKE', '%' . $_GET['search'] . '%')
                            ->orWhere('category', 'LIKE', '%' . $_GET['search'] . '%')
                            ->orWhere('name', 'LIKE', '%' . $_GET['search'] . '%')
                            ->orWhere('phone_no', 'LIKE', '%' . $_GET['search'] . '%');
                    })->orderBy('date', 'asc')->orderBy('time', 'asc')->paginate(10);

        }
        else{

            $appointment_history = Appointment::where('doctor_id', $user_id)->where('date', '<', date('Y-m-d'))->orderBy('date', 'asc')->orderBy('time', 'asc')->paginate(10);

        }

        return view('appointment.history', compact('appointment_history'));
    }

    public function show($id, $title)
    {
        $appointment = Appointment::where('id', $id)->first();

        return view('appointment.show', compact('appointment'));
    }

    public function edit($id, $title)
    {
        $appointment = Appointment::where('id', $id)->first();

        return view('appointment.edit', compact('appointment'));
    }

    public function update(Request $request, $id)
    {
        $validator = $request->validate([
            'outcome' => 'nullable',
        ]);
        
        $appointment = Appointment::where('id', $id)->first();

        $appointment->outcome = $request->outcome;

        $appointment->save();

        return back()->with('success', 'Appointment '.$appointment->title.' outcome has been updated successfully!');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
