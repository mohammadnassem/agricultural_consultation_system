<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Plant;

class Disease extends Model
{
    use HasFactory;

    protected $guarded = [];
   protected $hidden = ['pivot'];

    public function Plants(){
        return $this->belongsToMany(Plant::class, 'disease_plant')->withPivot(['important'])->orderBy('important', 'asc');
    }
    public function Stages(){
        return $this->belongsToMany(Stage::class, 'disease_stage');
    }
}
