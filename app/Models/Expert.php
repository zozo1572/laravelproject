<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class Expert extends Model
{
    use HasFactory;

    use HasApiTokens;
    protected $fillable=[
        'name','experience','info','image_path','available_time','email','password'
    ];

    public $timestamps=false;

    public  function user(){
        return $this->belongsTo(User::class);
    }



    public function account()
    {
        return $this->hasOne('App\Models\UserWallet', 'user_id');
    }
        public function transactions()
    {
        return $this->hasMany(UserWallet::class);
    }
        public function validTransactions()
    {
        return $this->transactions()->where('status', 1);
    }
        public function credit()
    {
        return $this->validTransactions()
                    ->where('type', 'credit')
                    ->sum('amount');
    }
       public function debit()
    {
        return $this->validTransactions()
                    ->where('type', 'debit')
                    ->sum('amount');
    }
        public function balance()
    {
        return $this->credit() - $this->debit();
    }
        public function allowWithdraw($amount) : bool
    {
        return $this->balance() >= $amount;
    }

}
