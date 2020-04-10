<?php

namespace App\Models\Tansik;

use Illuminate\Database\Eloquent\Model;

class FacultyEdge extends Model
{
    protected $table = 'faculty_edges';

    protected $fillable = ['section','TempName','year','edge','unifac_id'];

    public function UniFac() {
        return $this->belongsTo(UniFac::class,'unifac_id');
    }

    public function editor() {
        return $this->belongsTo('App\User','edit_by');
    }

}
