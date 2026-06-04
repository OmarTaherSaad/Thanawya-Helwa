<?php

namespace App\Models\Tansik;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'common_name', 'sections_allowed'];

    public function universities() {
        return $this->belongsToMany(University::class,'unifac')->using(UniFac::class)->withPivot(['name','address']);

    }
}
