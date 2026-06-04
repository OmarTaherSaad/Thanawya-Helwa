<?php

namespace App\Http\Controllers;

use App\Actions\Search\InternalSearchAction;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request, InternalSearchAction $search): View
    {
        $request->validate([
            'q' => 'nullable|string|max:120',
        ]);

        $q = (string) $request->input('q', '');
        $results = $search($q);

        SEOMeta::setTitle('بحث | ثانوية حلوة');
        SEOMeta::setDescription('ابحث عن جامعات أو كليات في دليل ثانوية حلوة.');
        SEOMeta::setCanonical(route('search.index', array_filter(['q' => $q ?: null])));
        SEOMeta::setRobots('noindex,follow');

        return view('search.index', [
            'q' => $q,
            'universities' => $results['universities'],
            'colleges' => $results['colleges'],
        ]);
    }
}
