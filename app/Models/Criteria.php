<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    protected $guarded = [];

    public function subCriterias()
    {
        return $this->hasMany(SubCriteria::class);
    }
}
