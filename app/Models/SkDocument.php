<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkDocument extends Model
{
    protected $guarded = [];

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'ditandatangani_oleh');
    }
}
