<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWallet extends Model
{
    use HasFactory;
    public function account(){
        return $this->hasOne(Expert::class);
    }

    public function useraccount(){
        return $this->hasOne(User::class);
    }


}
