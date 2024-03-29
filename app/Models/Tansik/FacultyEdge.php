<?php

namespace App\Models\Tansik;

use Illuminate\Database\Eloquent\Model;

class FacultyEdge extends Model
{
    protected $table = 'faculty_edges';

    protected $fillable = ['section', 'TempName', 'year', 'edge', 'unifac_id', 'confirmed', 'confirmed2'];

    public function UniFac()
    {
        return $this->belongsTo(UniFac::class, 'unifac_id');
    }

    public function editor()
    {
        return $this->belongsTo('App\User', 'edit_by');
    }

    public function confirmer()
    {
        return $this->belongsTo('App\User', 'confirmed_by');
    }

    public function confirmer2()
    {
        return $this->belongsTo('App\User', 'confirmed2_by');
    }

    public function confirmed()
    {
        return $this->confirmed == true;
    }

    public function confirmed2()
    {
        return $this->confirmed2 == true;
    }

    public function is_faculty()
    {
        return !is_null($this->UniFac);
    }
}
