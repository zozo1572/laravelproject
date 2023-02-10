<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $events = [];



        $appointments = Appointment::with(['client', 'expert'])->get();



        foreach ($appointments as $appointment) {

            $events[] = [

                'title' => $appointment->client->name . ' ('.$appointment->expert->name.')',

                'start' => $appointment->start_time,

                'end' => $appointment->finish_time,

            ];

        }



        return response()->json([
            $events
        ]);


    }
}
