<?php

namespace App\Http\Controllers;

use App\Actions\Tansik\University\ListUniversitiesAction;
use App\Actions\Tansik\University\PrepareUniversityShowPageAction;
use App\Models\Tansik\University;
use App\Support\PageSeo;
use Illuminate\View\View;

class UniversityController extends Controller
{
    /**
     * Public directory of Egyptian universities in the dataset.
     */
    public function index(ListUniversitiesAction $listUniversities): View
    {
        PageSeo::apply(
            'الجامعات | دليل ثانوية حلوة',
            'قائمة بالجامعات المرتبطة ببيانات التنسيق على ثانوية حلوة مع روابط لكلياتها ومعاهدها.',
            route('universities.index')
        );

        $universities = $listUniversities();

        return view('universities.index', compact('universities'));
    }

    /**
     * Public profile for one university and its faculties (UniFac).
     */
    public function show(University $university, PrepareUniversityShowPageAction $prepareUniversityShowPage): View
    {
        $page = $prepareUniversityShowPage($university);

        $title = $page->university->name.' | جامعات مصر';
        $description = $page->university->meta_description
            ?: 'كليات ومعاهد '.$page->university->name.' في دليل التنسيق على ثانوية حلوة.';
        PageSeo::apply($title, $description, route('universities.show', ['university' => $page->university->slug]));

        return view('universities.show', compact('page'));
    }
}
