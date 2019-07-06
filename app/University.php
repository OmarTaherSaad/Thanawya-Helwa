<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    protected $fillable = ['name','type','logo'];

    public function administrations() {
        return $this->belongsToMany(Administration::class,'geoDist');
    }

    public function faculties() {
        return $this->belongsToMany(Faculty::class,'unifac')->using(UniFac::class)->withPivot(['name','address']);

    }

    public static function CorrectName(University $uni) {
        if (\Str::endsWith($uni->name,'ه')) {
            //ه --> ة
            $uni->name = mb_substr($uni->name,0,-1) . 'ة';
        }
        if (\Str::startsWith($uni->name,'ا') && !\Str::startsWith($uni->name,'ال')) {
            //ا --> أ
            $uni->name = "أ" . mb_substr($uni->name,1);
        }
        if (\Str::contains($uni->name,'ه ')) {
            //ه --> ة
            $uni->name = str_replace('ه ','ة ',$uni->name);
        }
        $uni->save();
    }
}
