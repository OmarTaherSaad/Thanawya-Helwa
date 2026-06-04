<?php

namespace App\Http\Controllers;

use App\Actions\Tansik\College\ListCollegesAction;
use App\Actions\Tansik\College\PrepareCollegeShowPageAction;
use App\Models\Tansik\UniFac;
use App\Support\PageSeo;
use Illuminate\View\View;

class CollegeController extends Controller
{
    /**
     * Public directory of colleges / institutes (UniFac).
     */
    public function index(ListCollegesAction $listColleges): View
    {
        PageSeo::apply(
            'كليات ومعاهد مصر | دليل ثانوية حلوة',
            'قائمة بكليات ومعاهد مصر المرتبطة بتنسيق الثانوية العامة مع روابط لصفحات التفاصيل والحد الأدنى عبر السنوات.',
            route('colleges.index')
        );

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
        $description = $page->college->meta_description
            ?: 'حد أدنى وتنسيق '.$page->college->name.' عبر السنوات (علمي وأدبي) على ثانوية حلوة.';
        PageSeo::apply($title, $description, route('colleges.show', ['college' => $page->college->slug]));

        return view('colleges.show', compact('page'));
    }
}
