<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thumbnail extends Model
{
    protected $fillable = ['program_camp_id', 'image'];

    public function programCamp()
    {
        return $this->belongsTo(ProgramCamp::class, 'program_camp_id');
    }
}
