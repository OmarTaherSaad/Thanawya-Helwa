<?php

namespace App\Http\Controllers;

use App\Actions\Search\ScoutDirectorySearchAction;
use App\Support\PageSeo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request, ScoutDirectorySearchAction $search): View
    {
        $request->validate([
            'q' => 'nullable|string|max:120',
        ]);

        $q = (string) $request->input('q', '');
        $results = $search($q);
        $queryReady = Str::length(trim($q)) >= 2;

        PageSeo::applyNoindexFollow(
            'بحث في الدليل | ثانوية حلوة',
            'ابحث بسرعة عن جامعة أو كلية أو معهد في دليل ثانوية حلوة قبل ما تتفرج على التنسيق.',
            route('search.index', array_filter(['q' => $q ?: null]))
        );

        return view('search.index', [
            'q' => $q,
            'queryReady' => $queryReady,
            'universities' => $results['universities'],
            'colleges' => $results['colleges'],
        ]);
    }
}
