<?php

namespace App\Http\Controllers;

use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\View\View;

/**
 * Static career guidance hub (links into existing tools; no duplicate CMS).
 */
class CareerController extends Controller
{
    public function index(): View
    {
        SEOMeta::setTitle('مسارات بعد الثانوية العامة | ثانوية حلوة');
        SEOMeta::setDescription('تعرف على أدوات ثانوية حلوة بعد الثانوية العامة: التنسيق، الامتحانات، الاختبارات، والجامعات.');
        SEOMeta::setCanonical(route('careers.index'));
        SEOMeta::setRobots('index,follow');

        return view('careers.index');
    }
}
