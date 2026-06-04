<?php

namespace App\Http\Controllers;

use App\Actions\Tansik\Prediction\EstimateNextYearEdgeAction;
use App\Models\Tansik\UniFac;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CoordinationEstimateController extends Controller
{
    public function show(): View
    {
        SEOMeta::setTitle('تقدير تنسيقي تجريبي | ثانوية حلوة');
        SEOMeta::setDescription('أداة تقدير غير رسمية تعتمد على متوسط آخر سنوات مسجلة لكلية محددة — للتوعية فقط.');
        SEOMeta::setCanonical(route('tansik.coordination_estimate'));
        SEOMeta::setRobots('noindex,follow');

        return view('tansik.coordination-estimate', ['section' => 'E']);
    }

    public function estimate(Request $request, EstimateNextYearEdgeAction $estimate): View
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

        $result = $estimate($college, $section);

        return view('tansik.coordination-estimate', [
            'college' => $college,
            'result' => $result,
            'section' => $section,
        ]);
    }
}
