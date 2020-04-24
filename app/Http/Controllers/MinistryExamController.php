<?php

namespace App\Http\Controllers;

use App\MinistryExam;
use App\Traits\GetSubjects;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


class MinistryExamController extends Controller
{
    use GetSubjects;

    public function __construct()
    {
        $this->middleware(['auth', 'role:THteam'])->except([
            'index', 'show','download'
        ]);
        $this->authorizeResource(MinistryExam::class, 'ministryExam');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $exams = MinistryExam::orderBy('updated_at', 'desc');
        if ($request->has('year')) {
            $exams = $exams->where('year', $request->year);
        }
        if ($request->has('educational_year')) {
            $exams = $exams->where('educational_year', $request->educational_year);
        }
        if ($request->has('subject')) {
            $exams = $exams->where('subject', $request->subject);
        }
        if ($request->has('major')) {
            $exams = $exams->whereIn('subject', $this->getForMajor($request->major));
        }
        $subjects = $this->getSubjects();
        $existingSubjects = MinistryExam::all()->unique('subject')->pluck('subject')->toArray();
        $subjects = $subjects->filter(function($value,$key) use ($existingSubjects) {
            return in_array($key,$existingSubjects);
        });
        $years = MinistryExam::all()->unique('year')->pluck('year');
        $educational_years = MinistryExam::all()->unique('educational_year')->pluck('educational_year');

        $exams = $exams->paginate(config('app.pagination_max'));
        $exams = $exams->appends([
            'educational_year' => $request->educational_year,
            'subject' => $request->subject,
            'major' => $request->major
        ]);
        return view('ministry-exams.index')
        ->with(compact('subjects'))
        ->with(compact('years'))
        ->with(compact('educational_years'))
        ->with('ministryExams',$exams);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = $this->getSubjects();
        return view('ministry-exams.create')->with(compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subjects = ($this->getSubjects())->keys();
        $request->validate([
            'title' => 'nullable|required_without:table|string|max:191',
            'year' => 'required|integer',
            'educational_year' => 'required|integer|min:1|max:3',
            'file' => 'required_without_all:url,table|file|mimetypes:application/pdf|max:10240',
            'url' => 'nullable|required_without_all:file,table|url',
            'subject' => ['required_without:table', 'string', Rule::in($subjects)],
            'table' => 'required_without_all:url,file',
        ]);
        if ($request->has('table')) {
            $table = file_get_contents($request->file('table'));
            $dom = new DOMDocument();
            $dom->loadHTML($table);
            $table = $dom->getElementsByTagName('tr');
            $data = collect();
            foreach ($table as $tr) {
                $tds = $tr->getElementsByTagName('td');
                if ($tds->count() < 2 || is_null($tds[1]->getElementsByTagName('a')[0])) {
                    continue;
                }
                $title = utf8_decode($tds[0]->nodeValue);
                $url = "http://elearning1.moe.gov.eg/" . utf8_decode($tds[1]->getElementsByTagName('a')[0]->getAttribute('href'));
                foreach (config('ministryExams') as $key => $value) {
                    if (strpos($title,$key) !== false) {
                        $data->push([
                            's' => strpos($title, $key),
                            'title' => $title,
                            'url' => $url,
                            'subject' => $value,
                        ]);
                        break;
                    }
                }
            }
            foreach ($data as  $exam) {
                $exam = $this->addExam($exam,$request->educational_year, $request->year);
                $exam->adder()->associate(auth()->user()->member);
                $exam->save();
            }
        } else {
            $path = 'exams/' . $request->educational_year . '/' . $request->year . '/' . $request->subject . '/';
            $name = \Str::random(40) . '.pdf';
            if ($request->has('url')) {
                $file = tempnam(sys_get_temp_dir(), $name);
                copy($request->url, $file);
                $path = Storage::putFileAs($path, $file, $name);
            } else {
                $path = $request->file('file')->storeAs($path, $name);
            }
            $exam = MinistryExam::create([
                'title' => $request->title,
                'educational_year' => $request->educational_year,
                'year' => $request->year,
                'subject' => $request->subject,
                'link' => $path
            ]);
            $exam->adder()->associate(auth()->user()->member);
            $exam->save();
        }
        session()->flash('success','Exam Stored Successfully');
        return redirect()->route('ministryExam.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MinistryExam  $ministryExam
     * @return \Illuminate\Http\Response
     */
    public function show(MinistryExam $ministryExam)
    {
        return view('ministry-exams.show',['MinistryExam' => $ministryExam]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MinistryExam  $ministryExam
     * @return \Illuminate\Http\Response
     */
    public function edit(MinistryExam $ministryExam)
    {
        $subjects = $this->getSubjects();
        return view('ministry-exams.edit')->with(compact('subjects'))->with(compact('ministryExam'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MinistryExam  $ministryExam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MinistryExam $ministryExam)
    {
        $subjects = ($this->getSubjects())->keys();
        $request->validate([
            'title' => 'required|string|max:191',
            'year' => 'required|integer',
            'educational_year' => 'required|integer|min:1|max:3',
            'file' => 'sometimes|file|mimetypes:application/pdf|max:10240',
            'subject' => ['required', 'string', Rule::in($subjects)],
        ]);
        if ($request->hasFile('file')) {
            if (Storage::exists($ministryExam->link)) {
                Storage::delete($ministryExam->link);
            }
            $path = 'exams/' . $request->educational_year . '/' . $request->year . '/' . $request->subject . '/';
            $name = \Str::random(40) . '.pdf';
            $path = $request->file('file')->storeAs($path, $name);
            $ministryExam->update([
                'link' => $path
            ]);
        }
        $ministryExam->update($request->all());
        session()->flash('success', 'Exam Updated Successfully');
        return redirect()->route('ministryExam.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MinistryExam  $ministryExam
     * @return \Illuminate\Http\Response
     */
    public function destroy(MinistryExam $ministryExam)
    {
        $ministryExam->delete();
        session()->flash('success', 'Exam Deleted Successfully');
        return redirect()->route('ministryExam.index');
    }

    public function download(MinistryExam $ministryExam) {
        return Storage::download($ministryExam->link, 'ثانوية حلوة - ' . $ministryExam->subject_name . '-' . $ministryExam->title . ' .pdf');
    }

    public function addExam(array $request, $educational_year, $year)
    {
        $path = 'exams/' . $educational_year . '/' . $year . '/' . $request['subject'] . '/';
        $name = \Str::random(40) . '.pdf';
        $file = tempnam(sys_get_temp_dir(), $name);
        copy($request['url'], $file);
        $path = Storage::putFileAs($path, $file, $name);
        $exam = MinistryExam::create([
            'title' => $request['title'],
            'educational_year' => $educational_year,
            'year' => $year,
            'subject' => $request['subject'],
            'link' => $path
        ]);
        return $exam;
    }

    public function getForMajor(string $major)
    {
        switch (strtolower($major)) {
            case 'adby':
                $subjects = [
                    "ARB_AR",
                    "ENG",
                    "GRM",
                    "FRN",
                    "ITL",
                    "SPN",
                    "CHN",
                    "GEO_AR",
                    "HIST_AR",
                    "PHILO_AR",
                    "LOG_AR",
                    "PSH_AR",
                    "SOC_AR",
                    "PSH_SOC_AR",
                    "PHILO_LOG_AR",
                    "DISL",
                    "DMIS",
                    "ECON",
                    "EHSA",
                    "EHSA_AR",
                    "WTN"
                ];
                break;
            case 'oloom':
                $subjects = [
                    "ARB_AR",
                    "ENG",
                    "GRM",
                    "FRN",
                    "ITL",
                    "SPN",
                    "CHN",
                    "PHY",
                    "PHY_AR",
                    "CHEM",
                    "CHEM_AR",
                    "BIO",
                    "BIO_AR",
                    "GLG",
                    "DISL",
                    "DMIS",
                    "ECON",
                    "EHSA",
                    "EHSA_AR",
                    "WTN"
                ];
                break;
            case 'ryada':
                $subjects = [
                    "ARB_AR",
                    "ENG",
                    "GRM",
                    "FRN",
                    "ITL",
                    "SPN",
                    "CHN",
                    "PHY",
                    "PHY_AR",
                    "CHEM",
                    "CHEM_AR",
                    "MTH_ST",
                    "MTH_DY",
                    "MTH_ALG",
                    "MTH_SG",
                    "MTH_ALG_SG",
                    "MTH_DIFF",
                    "MTH_ST_AR",
                    "MTH_DY_AR",
                    "MTH_ALG_AR",
                    "MTH_SG_AR",
                    "MTH_ALG_SG_AR",
                    "MTH_DIFF_AR",
                    "DISL",
                    "DMIS",
                    "ECON",
                    "EHSA",
                    "EHSA_AR",
                    "WTN"
                ];
                break;
            default:
                $subjects = [];
        }
        return $subjects;
    }
}
