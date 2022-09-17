<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Disease;

class Plant extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function Diseases(){
        return $this->belongsToMany(Disease::class, 'disease_plant')->withPivot(['important'])->orderBy('important', 'asc');
    }

    public  function  plantSchedules(){
        return $this->hasMany(PlantSchedule::class);
    }

    public  function stages(){
        return $this->hasMany(Stage::class);
    }
    public function Users(){
        return $this->belongsToMany(User::class)->withPivot(['id','is_finished','is_protected','is_clean','watering_date','soil_type','long','lat','area','city','created_at','updated_at']);
    }
}
