<?php

namespace App\Models\Tansik;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Laravel\Scout\Searchable;

class UniFac extends Pivot
{
    use HasFactory, Searchable;

    /**
     * Pivot rows carry their own primary key (used by faculty_edges.unifac_id).
     */
    public $incrementing = true;

    protected $table = 'unifac';

    protected $fillable = ['name', 'university_id', 'faculty_id', 'address', 'slug', 'meta_description', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::created(function (self $model): void {
            if (blank($model->slug)) {
                $model->slug = 'college-'.$model->id;
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

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function edges()
    {
        return $this->hasMany(FacultyEdge::class, 'unifac_id');
    }

    public function hasFaculty()
    {
        return ! is_null($this->faculty);
    }

    public function shouldBeSearchable(): bool
    {
        return (bool) $this->is_active && filled($this->slug);
    }

    /**
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => (string) $this->name,
            'slug' => (string) $this->slug,
            'address' => (string) ($this->address ?? ''),
            'university_id' => $this->university_id,
            'is_active' => (bool) $this->is_active,
        ];
    }
}
