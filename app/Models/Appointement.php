<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
use App\Enums\AppointmentStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Appointement extends Model
{
    use HasFactory;

    protected $fillable = ['title','client_id','start_date','end_date','status','description'];
    
    protected $casts=[
        'start_date'=>'datetime',
        'end_date'=>'datetime',
        'status'=>AppointmentStatus::class,

    ];


    protected $appends=[
        'formatted_start_date',
        'formatted_end_date',
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }


    public function formattedStartDate():Attribute{
        return Attribute::make(
            get: function () {
                return $this->start_date ? $this->start_date->format('d-m-Y h:i A') : null;
            }
        );
    }


    
    public function formattedEndDate():Attribute{
        return Attribute::make(
            get: function () {
                return $this->end_date ? $this->end_date->format('d-m-Y h:i A') : null;
            }
        );
    }
}
