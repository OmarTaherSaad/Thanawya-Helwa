<?php

namespace App\Models\Tansik;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UniFac extends Pivot
{
    protected $table = "unifac";

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

    public function hasFaculty()
    {
        return !is_null($this->faculty);
    }
}
