<?php

namespace App\Http\Controllers;

use App\Support\PageSeo;
use Illuminate\View\View;

/**
 * Static career guidance hub (links into existing tools; no duplicate CMS).
 */
class CareerController extends Controller
{
    public function index(): View
    {
        PageSeo::apply(
            'مسارات بعد الثانوية العامة | ثانوية حلوة',
            'تعرف على أدوات ثانوية حلوة بعد الثانوية العامة: التنسيق، الامتحانات، الاختبارات، والجامعات.',
            route('careers.index')
        );

        return view('careers.index');
    }
}
