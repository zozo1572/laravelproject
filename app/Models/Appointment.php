<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;


    protected $fillable = [

        'start_time',

        'finish_time',

        'comments',

        'client_id',

        'expert_id',

    ];



    public function client()

    {

        return $this->belongsTo(Client::class);

    }



    public function expert()

    {

        return $this->belongsTo(Expert::class);

    }
}
