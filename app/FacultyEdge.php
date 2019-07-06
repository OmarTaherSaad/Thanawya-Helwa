<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacultyEdge extends Model
{
    protected $table = 'faculty_edges';

    protected $fillable = ['section','TempName','year','edge','unifac_id'];

    public function UniFac() {
        return $this->belongsTo(UniFac::class);
    }
}
