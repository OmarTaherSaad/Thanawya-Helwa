<?php

namespace App\Models\Tansik;

use App\Support\SeoSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Exceptions\HttpResponseException;
use Laravel\Scout\Searchable;
use Symfony\Component\HttpFoundation\Response;

class University extends Model
{
    use HasFactory, Searchable;

    protected static function newFactory(): \Database\Factories\UniversityFactory
    {
        return \Database\Factories\UniversityFactory::new();
    }

    protected $fillable = ['name', 'type', 'logo', 'slug', 'meta_description', 'is_active'];

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
        $base = SeoSlug::fromTitle((string) $model->name, 'university');

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

        if ($field === 'slug' && preg_match('/^university-(\d+)$/i', $value, $matches)) {
            $legacy = static::query()
                ->whereKey((int) $matches[1])
                ->where('is_active', true)
                ->first();

            if ($legacy !== null) {
                if ($legacy->slug !== $value) {
                    throw new HttpResponseException(
                        redirect()->route('universities.show', ['university' => $legacy->slug], Response::HTTP_MOVED_PERMANENTLY)
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
            'type' => (string) ($this->type ?? ''),
            'is_active' => (bool) $this->is_active,
        ];
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
