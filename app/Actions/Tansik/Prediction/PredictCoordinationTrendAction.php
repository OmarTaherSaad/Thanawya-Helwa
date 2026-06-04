<?php

namespace App\Actions\Tansik\Prediction;

use App\Models\Tansik\FacultyEdge;
use App\Models\Tansik\UniFac;
use Illuminate\Support\Collection;

/**
 * Fits a simple least-squares line on (year, edge) then extrapolates one year ahead.
 * Falls back to the mean of the last three observations when the fit is unstable.
 */
final class PredictCoordinationTrendAction
{
    private const DISCLAIMER = 'تقدير إحصائي تجريبي وليس تنبؤًا رسميًا ولا يغني عن موقع التنسيق أو إرشاد المدرسة.';

    /**
     * @return array{
     *   estimate: ?float,
     *   method: string,
     *   disclaimer: string,
     *   payload: array<string, mixed>
     * }
     */
    public function __invoke(UniFac $college, string $section = 'E'): array
    {
        $section = strtoupper($section) === 'A' ? 'A' : 'E';

        $points = FacultyEdge::query()
            ->where('unifac_id', $college->id)
            ->where('section', $section)
            ->orderBy('year')
            ->get(['year', 'edge']);

        $pairs = $points->map(fn ($row) => [
            'year' => (int) $row->year,
            'edge' => (float) $row->edge,
        ])->values();

        if ($pairs->isEmpty()) {
            return [
                'estimate' => null,
                'method' => 'none',
                'disclaimer' => self::DISCLAIMER,
                'payload' => ['reason' => 'no_rows'],
            ];
        }

        $fallbackAvg = $this->averageLastN($pairs, 3);
        if ($pairs->count() === 1) {
            return [
                'estimate' => round($fallbackAvg, 2),
                'method' => 'single_year',
                'disclaimer' => self::DISCLAIMER,
                'payload' => [
                    'points' => $pairs->all(),
                ],
            ];
        }

        $regression = $this->linearRegression($pairs);
        if ($regression === null) {
            return [
                'estimate' => $fallbackAvg !== null ? round($fallbackAvg, 2) : null,
                'method' => 'avg_last_n_fallback',
                'disclaimer' => self::DISCLAIMER,
                'payload' => [
                    'points' => $pairs->all(),
                    'reason' => 'degenerate_regression',
                ],
            ];
        }

        $nextYear = $pairs->max('year') + 1;
        $projected = $regression['slope'] * $nextYear + $regression['intercept'];
        if ($projected < 0 || $projected > 1000) {
            $projected = $fallbackAvg ?? $projected;
        }

        return [
            'estimate' => round((float) $projected, 2),
            'method' => 'linear_regression_next_year',
            'disclaimer' => self::DISCLAIMER,
            'payload' => [
                'points' => $pairs->all(),
                'slope' => $regression['slope'],
                'intercept' => $regression['intercept'],
                'next_year' => $nextYear,
                'fallback_avg' => $fallbackAvg,
            ],
        ];
    }

    /**
     * @param  Collection<int, array{year: int, edge: float}>  $pairs
     */
    private function averageLastN(Collection $pairs, int $n): ?float
    {
        $slice = $pairs->slice(-$n)->pluck('edge');
        if ($slice->isEmpty()) {
            return null;
        }

        return (float) $slice->avg();
    }

    /**
     * @param  Collection<int, array{year: int, edge: float}>  $pairs
     * @return array{slope: float, intercept: float}|null
     */
    private function linearRegression(Collection $pairs): ?array
    {
        $n = $pairs->count();
        if ($n < 2) {
            return null;
        }

        $sumX = 0.0;
        $sumY = 0.0;
        $sumXX = 0.0;
        $sumXY = 0.0;
        foreach ($pairs as $p) {
            $x = (float) $p['year'];
            $y = (float) $p['edge'];
            $sumX += $x;
            $sumY += $y;
            $sumXX += $x * $x;
            $sumXY += $x * $y;
        }

        $denom = $n * $sumXX - $sumX * $sumX;
        if (abs($denom) < 1e-6) {
            return null;
        }

        $slope = ($n * $sumXY - $sumX * $sumY) / $denom;
        $xMean = $sumX / $n;
        $yMean = $sumY / $n;
        $intercept = $yMean - $slope * $xMean;

        return ['slope' => $slope, 'intercept' => $intercept];
    }
}
