<?php

namespace App\Models\Tansik;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class University extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'logo', 'slug', 'meta_description', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::created(function (self $model): void {
            if (blank($model->slug)) {
                $model->slug = 'university-'.$model->id;
                $model->saveQuietly();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Public routes only resolve active directory rows.
     */
    public function resolveRouteBinding($value, $field = null)
    {
        $field = $field ?: $this->getRouteKeyName();

        return static::query()
            ->where($field, $value)
            ->where('is_active', true)
            ->firstOrFail();
    }

    public function administrations()
    {
        return $this->belongsToMany(Administration::class, 'geoDist');
    }

    public function faculties()
    {
        return $this->belongsToMany(Faculty::class, 'unifac')->using(UniFac::class)->withPivot(['name', 'address']);
    }

    /**
     * College / institute rows (unifac) belonging to this university.
     */
    public function uniFacs(): HasMany
    {
        return $this->hasMany(UniFac::class);
    }

    public static function CorrectName(University $uni)
    {
        if (\Str::endsWith($uni->name, 'ه')) {
            //ه --> ة
            $uni->name = mb_substr($uni->name, 0, -1).'ة';
        }
        if (\Str::startsWith($uni->name, 'ا') && ! \Str::startsWith($uni->name, 'ال')) {
            //ا --> أ
            $uni->name = 'أ'.mb_substr($uni->name, 1);
        }
        if (\Str::contains($uni->name, 'ه ')) {
            //ه --> ة
            $uni->name = str_replace('ه ', 'ة ', $uni->name);
        }
        $uni->save();
    }
}
