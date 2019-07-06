<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UniFac extends Pivot
{
    protected $table = "UniFac";

    protected $fillable = ['name','address'];

    public function faculty() {
        return $this->belongsTo(Faculty::class);
    }

    public function university() {
        return $this->belongsTo(University::class);
    }

    public function edges() {
        return $this->hasMany(FacultyEdge::class);
    }
}
