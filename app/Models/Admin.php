<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * Developed By : Maaz Ansari
     * Created On : 08-aug-2022
     * uses : to to get data of role model in staff table 
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    /**
     * Developed By : Maaz Ansari
     * Created On : 08-aug-2022
     * uses : to to get data of country model in staff table 
     */
    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }
}
