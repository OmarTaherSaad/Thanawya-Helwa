<?php

namespace App\Http\Controllers;

use App\Actions\Tansik\Prediction\PredictCoordinationTrendAction;
use App\Models\Tansik\CoordinationPredictionRun;
use App\Models\Tansik\UniFac;
use App\Support\PageSeo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class CoordinationEstimateController extends Controller
{
    public function show(): View
    {
        PageSeo::applyNoindexFollow(
            'تقدير تنسيقي تجريبي | ثانوية حلوة',
            'أداة تقدير غير رسمية تعتمد على متوسط آخر سنوات مسجلة لكلية محددة — للتوعية فقط.',
            route('tansik.coordination_estimate')
        );

        return view('tansik.coordination-estimate', ['section' => 'E']);
    }

    public function estimate(Request $request, PredictCoordinationTrendAction $predict): View
    {
        $validated = $request->validate([
            'college_slug' => 'required|string|max:191',
            'section' => 'required|string|in:E,A,e,a',
        ]);

        $section = strtoupper($validated['section']) === 'A' ? 'A' : 'E';

        $college = UniFac::query()
            ->where('slug', $validated['college_slug'])
            ->where('is_active', true)
            ->firstOrFail();

        $result = $predict($college, $section);

        CoordinationPredictionRun::query()->create([
            'unifac_id' => $college->id,
            'college_slug' => $college->slug,
            'section' => $section,
            'method' => $result['method'],
            'estimate' => $result['estimate'],
            'payload' => $result['payload'],
            'disclaimer' => $result['disclaimer'],
            'ip_address' => $request->ip(),
            'user_id' => $request->user()?->id,
        ]);

        PageSeo::applyNoindexFollow(
            'تقدير تنسيقي: '.$college->name.' | ثانوية حلوة',
            'نتيجة أداة تقدير غير رسمية بناءً على السنوات المسجلة في الموقع — للتوعية فقط وليست تنبؤًا رسميًا.',
            URL::current()
        );

        return view('tansik.coordination-estimate', [
            'college' => $college,
            'result' => $result,
            'section' => $section,
        ]);
    }
}
