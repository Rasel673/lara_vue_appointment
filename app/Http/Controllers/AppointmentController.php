<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointement;
use App\Enums\AppointmentStatus;

class AppointmentController extends Controller
{
    //
 public function index(){

    return Appointement::query()
           
            ->with('client:id,full_name,mobile')
            ->when(request('status'),function($query){
               return $query->where('status',AppointmentStatus::from(request('status')));
            })
            ->latest()
            ->paginate()
            ->through(fn($appointment)=>[
                'id'=>$appointment->id,
                'start_date'=>$appointment->start_date->format('d-m-Y h:i A'),
                'end_date'=>$appointment->end_date?$appointment->end_date->format('d-m-Y h:i A'):null,
                'status'=>[
                    'name'=>$appointment->status->name,
                    'color'=>$appointment->status->color(),
                ],
                'client'=>$appointment->client,
            ]);
                           
    }


    public function appointmentStatus(){

        $cases=AppointmentStatus::cases();

       return collect($cases)->map(function($status){
        return  [
             'name'=>$status->name,
            'value'=>$status->value,
            'count'=>Appointement::where('status',$status->value)->count(),
            'color'=>AppointmentStatus::from($status->value)->color()
        ];
        });

    }


    public function addAppointment(Request $request){
     $validated=request()->validate([
            'title'=>'required',
            'client_id'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'description'=>'required',
        ],[
            'client_id.required'=>'Client required'

        ]);


        

        Appointement::create([
            'title'=> $validated['title'],
            'client_id'=>$validated['client_id'],
            'start_date'=>$validated['start_date'],
            'end_date'=>$validated['end_date'],
            'description'=>$validated['description'],
        ]);

      return 'save succesfully';  
    }



    public function edit(Appointement $appointment)
    {
        return $appointment;
    }


    public function update(Appointement $appointment){

        $validated=request()->validate([
            'title'=>'required',
            'client_id'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'description'=>'required',
        ],[
            'client_id.required'=>'Client required'

        ]);

        $appointment->update($validated);
        return 'update succesfully'; 

    }




    public function destroy(Appointement $appointment){

        $appointment->delete();
        return 'Deleted Successfully';


    }


    public function appointments_stat(){

    
        

       $totalAppointmentCount= Appointement::query()
        ->when( request('status')==='scheduled',function($query){
            $query->where('status',AppointmentStatus::SCHEDULED);
        })

        ->when( request('status')==='confirmed',function($query){
            $query->where('status',AppointmentStatus::CONFIRMED);
        })

        ->when( request('status')==='cencelled',function($query){
            $query->where('status',AppointmentStatus::CANCELLED);
        })

        ->count();

      
       return  $totalAppointmentCount;
    }

}
