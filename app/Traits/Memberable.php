<?php

namespace App\Traits;

/**
 * Trait for ticket buying
 */
trait Memberable
{
    public function member()
    {
        return $this->hasOne('App\Models\Team\Member');
    }

    public function posts()
    {
        return $this->hasManyThrough('App\Models\Team\Post','App\Models\Team\Member','user_id', 'written_by');
    }
}
