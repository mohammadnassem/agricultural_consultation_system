<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function steps()
    {
        return $this->hasMany(Step::class);
    }
    public  function  plant()
    {
        return $this->belongsTo(Plant::class);
    }

    public function Diseases()
    {
        return $this->belongsToMany(Disease::class, 'disease_stage');
    }
    public function plantUsers()
    {
        return $this->hasMany(PlantUser::class);
    }
}
