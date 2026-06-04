<?php

namespace App\Http\Controllers;

use App\Actions\Tansik\College\ListCollegesAction;
use App\Actions\Tansik\College\PrepareCollegeShowPageAction;
use App\Models\Tansik\UniFac;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\View\View;

class CollegeController extends Controller
{
    /**
     * Public directory of colleges / institutes (UniFac).
     */
    public function index(ListCollegesAction $listColleges): View
    {
        SEOMeta::setTitle('كليات ومعاهد مصر | دليل ثانوية حلوة');
        SEOMeta::setDescription('قائمة بكليات ومعاهد مصر المرتبطة بتنسيق الثانوية العامة مع روابط لصفحات التفاصيل والحد الأدنى عبر السنوات.');
        SEOMeta::setCanonical(route('colleges.index'));
        SEOMeta::setRobots('index,follow');

        $colleges = $listColleges();

        return view('colleges.index', compact('colleges'));
    }

    /**
     * Public profile for one college (stable slug URL).
     */
    public function show(UniFac $college, PrepareCollegeShowPageAction $prepareCollegeShowPage): View
    {
        $page = $prepareCollegeShowPage($college);

        $title = $page->college->name.' | تنسيق الثانوية العامة';
        SEOMeta::setTitle($title);
        $description = $page->college->meta_description
            ?: 'حد أدنى وتنسيق '.$page->college->name.' عبر السنوات (علمي وأدبي) على ثانوية حلوة.';
        SEOMeta::setDescription($description);
        SEOMeta::setCanonical(route('colleges.show', ['college' => $page->college->slug]));
        SEOMeta::setRobots('index,follow');

        return view('colleges.show', compact('page'));
    }
}
