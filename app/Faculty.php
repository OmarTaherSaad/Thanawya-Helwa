<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $fillable = ['name','common_name','sections_allowed'];

    public function universities() {
        return $this->belongsToMany(University::class,'unifac')->using(UniFac::class)->withPivot(['name','address']);

    }
}
