<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{
    protected $fillable = ['name'];

    public function administrations() {
        return $this->hasMany(Administration::class);
    }

    public function hasAdmins() {
        if ($this->administrations->count() > 1)
        {
            return true;
        }
        if (\Str::contains($this->administrations->first()->name,'جميع') && !\Str::contains($this->administrations->first()->name,'ماعدا'))
        {
            return false;
        }
        return true;
    }
}
