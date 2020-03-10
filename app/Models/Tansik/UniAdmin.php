<?php

namespace App\Models\Tansik;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UniAdmin extends Pivot
{
    protected $table = "GeoDist";

    protected $fillable = ['group','university_id','administration_id'];

    public function administration() {
        return $this->belongsTo(Administration::class);
    }

    public function university() {
        return $this->belongsTo(University::class);
    }
}
