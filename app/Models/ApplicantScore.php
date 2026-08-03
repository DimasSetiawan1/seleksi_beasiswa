<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantScore extends Model
{
    protected $guarded = [];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }
}
