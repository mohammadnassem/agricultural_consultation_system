<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantUser extends Model
{
    use HasFactory;
    protected $table = "plant_user";
    protected $guarded = [];

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
}
