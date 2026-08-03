<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function documents()
    {
        return $this->hasMany(ApplicantDocument::class);
    }

    public function scores()
    {
        return $this->hasMany(ApplicantScore::class);
    }

    public function mooraResult()
    {
        return $this->hasOne(MooraResult::class);
    }
}
