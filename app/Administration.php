<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Administration extends Model
{
    protected $fillable = ['name','governorate_id'];

    public function governorate() {
        return $this->belongsTo(Governorate::class);
    }

    public function universities() {
        return $this->belongsToMany(University::class,'geoDist')->withPivot('group');
    }

    public function getDist() {
        foreach ($this->universities->sortBy('pivot.group') as $uni) {
            switch ($uni->pivot->group) {
                case 'a':
                    $class = "المجموعة الأولى (أ)";
                    break;
                case 'b':
                    $class = "المجموعة الثانية (ب)";
                    break;
                case 'c':
                    $class = "المجموعة الثالثة (ج)";
                    break;
                default:
                    $class = 'لا توجد بيانات';
                    break;
            }
            $result[] = [$class,$uni->name];
        }
        return $result;
    }
}
