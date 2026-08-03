<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MooraResult extends Model
{
    protected $guarded = [];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }
}
