<?php

namespace App\Http\Controllers;

use App\Actions\Tansik\University\ListUniversitiesAction;
use App\Actions\Tansik\University\PrepareUniversityShowPageAction;
use App\Models\Tansik\University;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\View\View;

class UniversityController extends Controller
{
    /**
     * Public directory of Egyptian universities in the dataset.
     */
    public function index(ListUniversitiesAction $listUniversities): View
    {
        SEOMeta::setTitle('الجامعات | دليل ثانوية حلوة');
        SEOMeta::setDescription('قائمة بالجامعات المرتبطة ببيانات التنسيق على ثانوية حلوة مع روابط لكلياتها ومعاهدها.');
        SEOMeta::setCanonical(route('universities.index'));
        SEOMeta::setRobots('index,follow');

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
        SEOMeta::setTitle($title);
        $description = $page->university->meta_description
            ?: 'كليات ومعاهد '.$page->university->name.' في دليل التنسيق على ثانوية حلوة.';
        SEOMeta::setDescription($description);
        SEOMeta::setCanonical(route('universities.show', ['university' => $page->university->slug]));
        SEOMeta::setRobots('index,follow');

        return view('universities.show', compact('page'));
    }
}
