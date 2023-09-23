<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory;
    use SoftDeletes;
    
   

    // protected $fillable = [
    //     'country_name',
    //     'phone_code',
    //     'phone_length'
    // ];
    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }
}
