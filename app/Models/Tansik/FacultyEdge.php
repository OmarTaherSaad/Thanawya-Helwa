<?php

namespace App\Models\Tansik;

use App\Actions\Tansik\Coordination\GetCoordinationDistinctYearsAction;
use App\Models\Team\Member;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacultyEdge extends Model
{
    use HasFactory;

    protected static function newFactory(): \Database\Factories\FacultyEdgeFactory
    {
        return \Database\Factories\FacultyEdgeFactory::new();
    }

    protected $table = 'faculty_edges';

    protected $fillable = ['section', 'TempName', 'year', 'thanawya_system', 'edge', 'unifac_id', 'confirmed', 'confirmed2'];

    protected static function booted(): void
    {
        static::saved(static function (): void {
            GetCoordinationDistinctYearsAction::forgetCache();
        });

        static::deleted(static function (): void {
            GetCoordinationDistinctYearsAction::forgetCache();
        });
    }

    public function UniFac()
    {
        return $this->belongsTo(UniFac::class, 'unifac_id');
    }

    public function editor()
    {
        return $this->belongsTo(Member::class, 'edit_by');
    }

    public function confirmer()
    {
        return $this->belongsTo(Member::class, 'confirmed_by');
    }

    public function confirmer2()
    {
        return $this->belongsTo(Member::class, 'confirmed2_by');
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
