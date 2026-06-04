<?php

namespace App\Models\Tansik;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CoordinationPredictionRun extends Model
{
    protected $table = 'coordination_prediction_runs';

    protected $fillable = [
        'unifac_id',
        'college_slug',
        'section',
        'method',
        'estimate',
        'payload',
        'disclaimer',
        'ip_address',
        'user_id',
    ];

    protected $casts = [
        'payload' => 'array',
        'estimate' => 'float',
    ];

    public function college(): BelongsTo
    {
        return $this->belongsTo(UniFac::class, 'unifac_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
