<?php

namespace App\Http\Controllers;

use App\Actions\Tansik\Comparison\CompareCollegesBySlugsAction;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CollegeComparisonController extends Controller
{
    /**
     * Compare up to five colleges on recorded coordination years (one section).
     */
    public function show(Request $request, CompareCollegesBySlugsAction $compare): View
    {
        $request->validate([
            'slugs' => 'nullable|string|max:500',
            'section' => 'nullable|string|in:E,A,e,a',
        ]);

        $section = strtoupper((string) $request->input('section', 'E')) === 'A' ? 'A' : 'E';
        $slugs = array_values(array_filter(array_map('trim', explode(',', (string) $request->input('slugs', '')))));
        $slugs = array_slice(array_unique($slugs), 0, 5);

        SEOMeta::setTitle('مقارنة كليات | تنسيق الثانوية العامة');
        SEOMeta::setDescription('قارن الحد الأدنى المسجل لعدة كليات أو معاهد في شعبة واحدة عبر السنوات المتاحة في بيانات الموقع.');
        SEOMeta::setCanonical(route('colleges.compare', array_filter([
            'section' => $section !== 'E' ? $section : null,
            'slugs' => $request->filled('slugs') ? $request->input('slugs') : null,
        ])));
        SEOMeta::setRobots('index,follow');

        $data = $compare($slugs, $section);

        return view('colleges.compare', [
            'comparison' => $data,
            'slugsInput' => $request->input('slugs', ''),
            'section' => $section,
        ]);
    }
}
