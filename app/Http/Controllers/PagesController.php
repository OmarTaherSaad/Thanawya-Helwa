<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Mail\ContactForAdminMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Team\Member;
use App\Models\Tansik\Governorate;
use App\Models\Tansik\Administration;
use App\Models\Tansik\FacultyEdge;
use App\Traits\ApiResultsTools;

class PagesController extends Controller
{
    use ApiResultsTools;


    private $founder_members, $current_members, $old_members, $pageSize;

    public function __construct()
    {
        $this->pageSize = 5;
        $this->founder_members = Member::hasStatus('founder');
        $this->current_members = Member::hasStatus('current')->sortBy('name');
        $this->old_members = Member::hasStatus('old')->sortBy('name');
    }

    public function index2()
    {
        return redirect()->route('home');
    }

    public function index()
    {
        return view('index');
    }

    public function about()
    {
        return view('about-us')
            ->with('members_founder', $this->founder_members)
            ->with('members_current', $this->current_members->take($this->pageSize))
            ->with('members_old', $this->old_members->take($this->pageSize));
    }

    public function get_members(Request $request)
    {
        $varName = $request->role . '_members';
        $members = $this->paginateCollection($this->$varName, $this->pageSize, $request->page);
        if ($request->ajax()) {
            $view = view('containers.members-list', compact('members'))->render();
            return response()->json(['html' => $view]);
        }
        return view('containers.members-list', compact('members'));
    }

    public function join()
    {
        return view('join-us');
    }

    public function offline()
    {
        return view('offline');
    }

    public function contact()
    {
        return view('contact');
    }

    public function SubmitContact(Request $request)
    {
        $request->validate([
            "action" => "required",
            "g-recaptcha-response" => "required",
            "name" => "required|string|between:2,100",
            "phone" => "required|numeric|digits_between:5,15",
            "email" => "required|email",
            "subject" => "required|min:5",
            "message" => "required|min:10,1000"
        ]);

        // check if reCaptcha has been validated by Google
        $secret = config('app.GOOGLE_RECAPTCHA_SECRET');
        $captchaId = $request->input('g-recaptcha-response');

        //sends post request to the URL and tranforms response to JSON
        $responseCaptcha = json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $captchaId));

        if ($responseCaptcha->success == true && $request->input('action') == 'contact_form') {
            //Valid
            //Send Mail to Admin
            Mail::to("thanawyahelwa@gmail.com")->queue(new ContactForAdminMail($request->input('name'), $request->input('email'), $request->input('phone'), $request->input('subject'), $request->input('message')));
            //Send Mail to the user himself/herself
            Mail::to($request->input('email'))->queue(new ContactMail($request->input('name'), $request->input('message')));
            //Flash a message to user
            $request->session()->flash('success', "تم إرسال رسالتك بنجاح");
        } else {
            //Robot!
            $request->session()->flash('error', 'للأسف واضح إنك روبوت مش إنسان! لو دي جملة غريبة بالنسبالك، حاول مرة تانية يمكن العيب من عندنا.');
        }
        return back();
    }

    public function Newspaper()
    {
        return $this->media('Newspaper');
    }

    public function TV()
    {
        return $this->media('TV');
    }

    public function media(string $type)
    {
        if ($type == 'TV') {
            $MediaType[0] = 'المصورة والمسموعة';
            $MediaType[1] = 'TV';
            $Items = [
                //Poster image is named after the index here (0,1,2...etc)
                'MBC Masr 2 | برنامج صباحك مصري' => 'https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2FThanawya.Helwa%2Fvideos%2F2436876689719750%2F&show_text=0&mute=0',
                'القناة التعليمية الأولى | برنامج السفير الصغير' => 'https://www.youtube-nocookie.com/embed/fIGlQIav_g0',
                'القناة الثانية (الفضائية) | برنامج مصر الجميلة' => 'https://www.youtube-nocookie.com/embed/4S1Uvj-WAt8',
                'شفاف (فيديو)' => 'https://www.youtube-nocookie.com/embed/4tQxvWrDrXY',
                'الدستور (فيديو)' => 'https://www.youtube-nocookie.com/embed/cQiQf4cI_3U',
                'راديو DRN 93.7FM | برنامج مصر من البلكونة' => 'https://www.youtube-nocookie.com/embed/-t7pP5qMb84',
            ];
        } else {
            $MediaType[0] = 'المكتوبة';
            $MediaType[1] = 'Newspaper';
            $Items = [
                //Name => Link
                'صدى البلد' => 'https://www.elbalad.news/3329554',
                'مصر العربية' => 'http://masralarabia.com/%D8%A7%D9%84%D8%AD%D9%8A%D8%A7%D8%A9-%D8%A7%D9%84%D8%B3%D9%8A%D8%A7%D8%B3%D9%8A%D8%A9/1478055-%D8%AF-%D8%B1%D9%88%D8%B3-%D8%A7%D9%84%D8%AB%D8%A7%D9%86%D9%88%D9%8A%D8%A9--%D8%A8%D9%80--%D8%A7%D9%84%D9%85%D8%AC%D8%A7%D9%86----%D9%88%D9%84%D8%A7-%D8%B9%D8%B2%D8%A7%D8%A1-%D9%84%D9%84%D9%80--%D9%85%D8%B3%D8%AA%D8%BA%D9%84%D9%8A%D9%86',
                'شفاف' => 'http://shafaff.com/article/76148',
                'الوطن' => 'https://elwatannews.com/news/details/3412243',
                'الدستور' => 'https://dostor.org/2200772',
                'عربي بوست' => 'https://arabicpost.net/variety/2018/06/04/%D8%AB%D8%A7%D9%86%D9%88%D9%8A%D8%A9-%D8%AD%D9%84%D9%88%D8%A9-%D9%88%D8%AF%D8%A7%D8%B9%D8%A7%D9%8B-%D9%84%D9%85%D8%B5%D8%A7%D8%B1%D9%8A%D9%81-%D8%A7%D9%84%D8%AF%D8%B1%D9%88%D8%B3-%D8%A7%D9%84/',
                'مصراوي' => 'https://masrawy.com/howa_w_hya/relationship/details/2018/6/4/1369848/بعد-وصول-ثمنها-لـ400-جنيه-ا-شاب-مصري-يعطي-مراجعات-مجانية-لطلاب-الثانوية',
                'شبابيك' => 'https://shbabbek.com/show/125076',
                'مصراوي (خبر آخر)' => 'https://www.masrawy.com/news/news_various/details/2019/6/18/1586588/',
                //'' => '',

            ];
        }
        return view('media')->with(compact('Items'))->with('type', $MediaType);
    }

    public function feedback()
    {
        return redirect('https://www.facebook.com/Thanawya.Helwa/reviews/');
    }

    public function TansikPrevEdges()
    {
        //Fields
        $fields = collect();
        $fields->push([
            'title' => 'اسم الكلية',
            'name' => 'name',
            'sortField' => 'name'
        ]);
        $fields->push([
            'title' => 'المتوسط',
            'name' => 'avg',
            'sortField' => 'avg',
            'callback' => 'edgeView'
        ]);
        foreach (FacultyEdge::pluck('Year')->unique()->sort() as $year) {
            $fields->push([
                'name' => (string) $year,
                'sortField' => (string) $year,
                'callback' => 'edgeView'

            ]);
        }
        return view('tansik.previous-edges')->with(compact('fields'));
    }

    public function TansikReduceAlienation()
    {
        return redirect()->to("https://blog.thanawyahelwa.org/2020/08/12/66/%d8%aa%d9%82%d9%84%d9%8a%d9%84-%d8%a7%d9%84%d8%a7%d8%ba%d8%aa%d8%b1%d8%a7%d8%a8-%d9%88%d8%aa%d9%81%d8%a7%d8%b5%d9%8a%d9%84%d9%87-%d9%83%d9%84%d9%87%d8%a7/");
    }
    public function TansikGeoDist()
    {
        return view('tansik.geo-dist')->with('govs', Governorate::orderBy('name')->pluck('name', 'id'));
    }

    public function getAdmin(Request $request)
    {
        $gov = Governorate::find($request->input('gov'));
        if ($gov->hasAdmins()) {
            return response()->json($gov->administrations->toJson());
        }
        return response()->json([
            'admins' => 0,
            'dist' => $gov->administrations->first()->getDist()
        ]);
    }

    public function getDist(Request $request)
    {
        $admin = Administration::find($request->input('admin'));
        return response()->json([
            $admin->getDist()
        ]);
    }

    public function TansikGeoDistInfo()
    {
        return redirect()->to("https://blog.thanawyahelwa.org/2020/08/12/17/%d9%83%d9%84-%d9%85%d8%a7-%d9%8a%d8%ae%d8%b5-%d8%a7%d9%84%d9%82%d8%a8%d9%88%d9%84-%d8%a7%d9%84%d8%ac%d8%ba%d8%b1%d8%a7%d9%81%d9%8a-%d9%84%d8%b7%d9%84%d8%a8%d8%a9-%d8%ab%d8%a7%d9%86%d9%88%d9%8a%d8%a9/");
    }

    public function TansikTzalom()
    {
        return redirect()->to("https://blog.thanawyahelwa.org/2020/08/12/54/%d9%83%d9%84-%d8%ad%d8%a7%d8%ac%d8%a9-%d8%b9%d9%86-%d8%a7%d9%84%d8%aa%d8%b8%d9%84%d9%85-%d9%81%d9%8a-%d8%ab%d8%a7%d9%86%d9%88%d9%8a%d8%a9-%d8%b9%d8%a7%d9%85%d8%a9/");
    }

    public function TansikStagesInfo()
    {
        return redirect()->to("https://blog.thanawyahelwa.org/2020/08/12/59/%d8%a5%d9%8a%d9%87-%d9%87%d9%8a-%d9%85%d8%b1%d8%a7%d8%ad%d9%84-%d8%a7%d9%84%d8%aa%d9%86%d8%b3%d9%8a%d9%82-%d9%88%d9%85%d8%b9%d9%86%d8%a7%d9%87%d8%a7-%d8%a5%d9%8a%d9%87%d8%9f/");
    }

    public function getEdges(Request $request)
    {
        $data = $request->params;
        $Years = FacultyEdge::pluck('Year')->unique()->sort();

        //Edges
        $AllEdges = collect();
        $edgesQuery = FacultyEdge::query();
        if ($data['filter']) {
            $edgesQuery = $this->searchQuery($edgesQuery, FacultyEdge::class, $data['filter']);
        }
        $edgesQuery = $edgesQuery->where('section', $request->params['section'])->orderBy('edge', 'desc')->get()->groupBy('TempName');
        foreach ($edgesQuery as $name => $edgesOfName) {
            $Edges = collect();
            foreach ($edgesOfName as $edge) {
                $Edges->put($edge->year, number_format($edge->edge, 2) + 0); //To remove .00
            }
            $Edges->put('avg', number_format($Edges->sum() / $Edges->count(), 2) + 0);
            $Edges->put('name', $name);
            $Edges->put('section', $edgesOfName[0]->section);
            $AllEdges->push($Edges);
        }
        //Filter
        if ($data['filter'] && false) {
            $AllEdges = $AllEdges->filter(function ($edge) use ($data) {
                similar_text($edge['name'], $data['filter'], $percent);
                return $percent > 50;
                return \Str::contains($edge['name'], $data['filter']);
            });
        }
        //Add Missing Years
        foreach ($AllEdges as $edge) {
            foreach ($Years as $year) {
                if (!\Arr::has($edge, $year)) {
                    $edge->put($year, 'غير موجود');
                }
            }
        }
        //Sort if existing
        if ($data['sort']) {
            $sort = explode('|', $data['sort']);
            if ($sort[1] == 'asc') {
                if (is_numeric($sort[0])) {
                    $field = $sort[0];
                    $AllEdges = $AllEdges->sortBy(function ($edge) use ($field) {
                        return is_numeric($edge[$field]) ? $edge[$field] : 500;
                    });
                } else {
                    $AllEdges = $AllEdges->sortBy($sort[0]);
                }
            } else {
                if (is_numeric($sort[0])) {
                    $field = $sort[0];
                    $AllEdges = $AllEdges->sortByDesc(function ($edge) use ($field) {
                        return is_numeric($edge[$field]) ? $edge[$field] : -1;
                    });
                } else {
                    $AllEdges = $AllEdges->sortByDesc($sort[0]);
                }
            }
        }
        return response()->json($this->paginateCollection($AllEdges, $request->params['per_page'] ?? 100, $request->params['page'] ?? 1));
    }

    public function privacyPolicy()
    {
        return view('privacy-policy');
    }

    public static function CorrectName(String $s)
    {
        if (\Str::endsWith($s, 'ه')) {
            //ه --> ة at end
            $s = mb_substr($s, 0, -1) . 'ة';
        }
        if (\Str::contains($s, 'ه ')) {
            //ه --> ة at middle
            $s = str_replace('ه ', 'ة ', $s);
        }
        if (\Str::contains($s, 'ه/')) {
            //ه --> ة at middle
            $s = str_replace('ه/', 'ة/', $s);
        }
        if (\Str::startsWith($s, 'ا') && !\Str::startsWith($s, 'ال')) {
            //ا --> أ at start
            $s = "أ" . mb_substr($s, 1);
        }
        if (\Str::contains($s, 'الإ')) {
            $s = str_replace('الإ', 'الا', $s);
        }
        if (\Str::contains($s, 'الأ')) {
            $s = str_replace('الأ', 'الا', $s);
        }
        // if (\Str::contains($s,' ا')) {
        //     //ا --> أ In middle

        //     //TODO - Ensure it's not ال
        // }
        return $s;
    }
    public static function UnifyName(String $s)
    {
        $s = str_replace('ة', 'ه', $s);
        $s = str_replace('ال', '', $s);
        if (\Str::startsWith($s, 'ال')) {
            $s = mb_substr($s, 2);
        }
        $s = str_replace('ى', 'ي', $s);
        $s = str_replace('أ', 'ا', $s);
        $s = str_replace('إ', 'ا', $s);
        $s = str_replace('آ', 'ا', $s);
        $s = trim($s);
        return $s;
    }
}
