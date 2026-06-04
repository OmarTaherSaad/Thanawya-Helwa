<?php

namespace App\Models\Tansik;

use App\Support\SeoSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Http\Exceptions\HttpResponseException;
use Laravel\Scout\Searchable;
use Symfony\Component\HttpFoundation\Response;

class UniFac extends Pivot
{
    use HasFactory, Searchable;

    protected static function newFactory(): \Database\Factories\UniFacFactory
    {
        return \Database\Factories\UniFacFactory::new();
    }

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
            if (filled($model->slug)) {
                return;
            }

            $model->slug = static::makeUniqueSlugForNewModel($model);
            $model->saveQuietly();
        });
    }

    protected static function makeUniqueSlugForNewModel(self $model): string
    {
        $model->loadMissing('university');
        $title = implode(' ', array_filter([(string) $model->name, $model->university?->name]));
        $base = SeoSlug::fromTitle($title, 'college');

        return SeoSlug::unique(
            $base,
            fn (string $candidate): bool => static::query()
                ->where('slug', $candidate)
                ->whereKeyNot($model->getKey())
                ->exists()
        );
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
        $value = (string) $value;

        if ($field === 'slug' && preg_match('/^college-(\d+)$/i', $value, $matches)) {
            $legacy = static::query()
                ->whereKey((int) $matches[1])
                ->where('is_active', true)
                ->first();

            if ($legacy !== null) {
                if ($legacy->slug !== $value) {
                    throw new HttpResponseException(
                        redirect()->route('colleges.show', ['college' => $legacy->slug], Response::HTTP_MOVED_PERMANENTLY)
                    );
                }

                return $legacy;
            }
        }

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
