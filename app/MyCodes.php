<?php

//START: Get Universities logos and save them and update database
 $rawGovUnis = json_decode('
 {
     "link" => "university name"
 }
 ', true);

foreach ($rawGovUnis as $link => $name) {
    //Get this uni
    $uni = University::where('name', trim($name))->where('type', null)->first();
    if ($uni == null) {
        continue;
    }

    $uni->type = config("enums.university_types.ACD");

    //Save Image
    $headers = get_headers($link);
    if (substr($headers[0], 9, 3) == "200") {
        $contents = file_get_contents($link);
        $FileName = 'uni_' . $uni->id . substr($link, strrpos($link, '.'));
        Storage::put('universities/logos/' . $FileName, $contents);

        $uni->logo = 'universities/logos/' . $FileName;
    }
    $uni->save();
}

dd("DONE");
//END : Get Universities logos and save them and update database

//START: Convert my 2017 database to NEW Object-Oriented database
$DB_VARIABLE_servername = "localhost";
$DB_VARIABLE_username = "root";
$DB_VARIABLE_password = "";
$DB_VARIABLE_name = "th-v1";
// Create connection
$conn = mysqli_connect($DB_VARIABLE_servername, $DB_VARIABLE_username, $DB_VARIABLE_password, $DB_VARIABLE_name);
mysqli_set_charset($conn, "utf8");

$find = mysqli_query($conn, "SELECT * FROM facultyedge ");
$ar = [];
while ($row = mysqli_fetch_assoc($find)) {
    array_push($ar, $row);
}
$raw = $ar;
foreach ($raw as $v) {
    for ($i = 0; $i < 4; $i++) {
        $year = 2014 + $i;
        $edgeName = 'Edge201' . (4 + $i);
        if ($v[$edgeName] == 0) {
            continue;
        }
        $NewModel = FacultyEdge::firstOrCreate([
            'section' => $v['Section'],
            'TempName' => $v['Faculty'],
            'year' => $year,
            'edge' => $v[$edgeName],
        ]);
    }
}
dd("DONE");
//END: Convert my 2017 database to NEW Object-Oriented database


//START: Insert Data from Tansik website table to my database
function getTableFromTansikTable($html) {
    echo 'Getting data .. ';
    if (!headers_sent()) {
        header('Content-Type: text/html; charset=utf-8');
    }
    $doc = new DOMDocument();
    libxml_use_internal_errors(true);
    $doc->loadHTML($html);
    $xpath = new DOMXpath($doc);
    $elements = $xpath->query("//*/tbody/tr");

    $FacultyNames = [];
    $first = true;
    foreach ($elements as $element) {
        if ($first) {
            $first = false;
            continue;
        }
        $newXpath = $element->getNodePath();
        $Name = utf8_decode(trim($xpath->query($newXpath . '/td')[0]->textContent));
        $FacultyNames[$Name] = utf8_decode(trim($xpath->query($newXpath . '/td')[1]->textContent));
    }
    echo 'Data extracted<br>';
    return $FacultyNames;
}
function SaveEdges() {
    $html = '<table dir="ltr" border="1" width="60%" id="table14" cellspacing="0" bordercolor="#555555" bordercolordark="#FFFFFF" bordercolorlight="#555555">
                        <tbody>....</tbody></table>';
    $raw = getTableFromTansikTable($html);
    //Loop Through them
    $year = 2018;
    $section = 'E';
    foreach ($raw as $name => $edge) {
        $name = str_replace('ة', 'ه', $name);
        $name = str_replace('ى', 'ي', $name);
        $name = str_replace(['آ','إ','أ'], 'ا', $name);
        FacultyEdge::firstOrCreate([
            'section' => $section,
            'TempName' => $name,
            'year' => $year,
            'edge' => $edge
        ]);
    }
    echo "DONE";
}
//END: Insert Data from Tansik website table to my database


//START: Figure out what university is this edge
function GetUniversityFromEdge() {
    //Let's try to figure out what university it is
    foreach ($collection as $edge) {
        $EdgeName = PagesController::CorrectName($edge->TempName);
        $UniId = 0;
        //Check not Institute
        if (((\Str::contains($EdgeName, 'صناعي') || \Str::contains($EdgeName, 'فني')) && !\Str::contains($EdgeName, 'جامعة')) ||
            \Str::contains($EdgeName, 'معهد') || \Str::contains($EdgeName, 'عالي') || \Str::contains($EdgeName, 'اكاديمي')) {
            //Do Nothing but prevent checking the rest
        } elseif (\Str::contains($EdgeName, 'بور سعيد')) {
            $UniId = University::where('name', 'بورسعيد')->first()->id;
        } elseif (\Str::contains($EdgeName, 'سادات')) {
            $UniId = University::where('name', 'مدينة السادات')->first()->id;
        } elseif (\Str::contains($EdgeName, 'كفرالشيخ')) {
            $UniId = University::where('name', 'كفر الشيخ')->first()->id;
        } elseif (\Str::contains($EdgeName, 'قنا') || \Str::contains($EdgeName, 'الاقصر') || \Str::contains($EdgeName, 'غردقة')) {
            $UniId = University::where('name', 'جنوب الوادي')->first()->id;
        } elseif (\Str::contains($EdgeName, 'منيه النصر')) {
            $UniId = University::where('name', 'المنصورة')->first()->id;
        } elseif (\Str::contains($EdgeName, 'عباسية')) {
            $UniId = University::where('name', 'عين شمس')->first()->id;
        } elseif (\Str::contains($EdgeName, 'جيزة')) {
            $UniId = University::where('name', 'القاهرة')->first()->id;
        } elseif (\Str::contains($EdgeName, 'اشمون')) {
            $UniId = University::where('name', 'المنوفية')->first()->id;
        } elseif (\Str::contains($EdgeName, 'مشتهر')) {
            $UniId = University::where('name', 'بنها')->first()->id;
        } elseif (\Str::contains($EdgeName, 'الاسماعيلية')) {
            $UniId = University::where('name', 'قناة السويس')->first()->id;
        } elseif (\Str::contains($EdgeName, 'وادي') && \Str::contains($EdgeName, 'جديد')) {
            $UniId = University::where('name', 'أسيوط')->first()->id;
        } elseif (\Str::contains($EdgeName, 'مطروح')) {
            $UniId = University::where('name', 'الاسكندرية')->first()->id;
        } elseif (\Str::contains($EdgeName, 'شبين الكوم')) {
            $UniId = University::where('name', 'المنوفية')->first()->id;
        } else {
            foreach (University::pluck('name', 'id') as $id => $name) {
                $name = str_replace('أ', 'ا', $name); //Additional (for Assyout and Aswan)
                if (\Str::contains($EdgeName, $name) || \Str::contains($EdgeName, str_replace('ال', '', $name))) {
                    $UniId = $id;
                    break;
                }
            }
        }
        if ($UniId != 0) {
            //$edge->faculty_id = $UniId;
            $edge->save();
        }
    }
    //Testing code
    //dd($collection->sortByDesc('edge')->unique()->pluck('TempName', 'faculty_id'));
    dd($collection->sortByDesc('edge')->pluck('TempName')->unique()->filter(function ($value, $key) {
        if (((\Str::contains($value, 'صناعي') || \Str::contains($value, 'فني')) && !\Str::contains($value, 'جامعة')) ||
            \Str::contains($value, 'معهد') || \Str::contains($value, 'عالي') || \Str::contains($value, 'اكاديمي')) {
            return false;
        }
        return !\Str::contains($value, 'جامعة');
    }));
}
//END: Figure out what university is this edge

//START: Extract High Institutes from Array (and update old big title if existed)
//Big title: title that describes all the collection of these institutes
$rawInst[0] = [
    //Names
];
$field[0] = "Previous big title in Database";
for ($i = 0; $i < count($rawInst); $i++) {
    foreach ($rawInst[$i] as $name) {
        //Get this uni
        if (University::where('name', $field[$i])->first() != null) {
            University::where('name', $field[$i])->update([
                'name' => $name,
                'type' => config("enums.university_types.HI"),
            ]);
        } else {
            University::create([
                'name' => $name,
                'type' => config("enums.university_types.HI"),
            ]);
        }
    }
}
//END: Extract High Institutes from Array (and update old big title if existed)

//START: Extract faculties data from https://www.dbse.co/ using just the link
function createUniFac() {
    $ExtractedLinks = $this->GetFacUnisLinks();
    //foreach ($rawFac as  $field => $facs) {
    foreach ($ExtractedLinks as $field => $link) {
        echo 'looping through ' . $field . '&nbsp ----> &nbsp';
        $facs = $this->GetFacUnis($link);
        $field = str_replace(' و ',' و',$field);
        $Faculty = Faculty::where('name',$field)->first();
        if ($Faculty == null) {
            dd("NULL at " . $field);
        }
        if ($Faculty->universities()->count() < 1) {
            foreach ($facs as  $fac) {
                if (\Str::contains($fac,'أكاديمية وادى العلوم - معاهد الوادى') ||
                    \Str::contains($fac,'الجامعة العربية المفتوحة - فرع مصر') ||
                    \Str::contains($fac,'جامعة الأزهر - كليات البنين') ||
                    \Str::contains($fac,'جامعة الأزهر - كليات البنات') ||
                    \Str::contains($fac,'المعهد التكنولوجي العالي - السادس من أكتوبر') ||
                    \Str::contains($fac,'المعهد التكنولوجي العالي - مطروح')) {
                    $substrPosition = mb_strpos($fac, '-', mb_strpos($fac, '-') + 1);
                } else {
                    $substrPosition = mb_strpos($fac, '-');
                }
                $uniName = trim(mb_substr($fac, 0, $substrPosition));
                $UniFacName = trim(mb_substr($fac, $substrPosition + 1));
                if ($uniName == 'معاهد متنوعة') {
                    $University = University::where('name',$UniFacName)->first();
                } else {
                    $University = University::where('name',$uniName)->first();
                }
                //Create UniFac
                $Faculty->universities()->attach($University->id,[
                    'name' => $UniFacName
                ]);
            }
        }
        echo 'Finished ' . $field . ' data<br><hr>';
    }
    echo 'Finished all';
}

function GetFacUnisLinks() {
    echo 'Getting links for all types of faculties .. ';
    if (!headers_sent()) {
        header('Content-Type: text/html; charset=utf-8');
    }
    $doc = new DOMDocument();
    libxml_use_internal_errors(true);
    $doc->loadHTMLFile("https://www.dbse.co/universities");
    $xpath = new DOMXpath($doc);
    //XPath of links -> Inspect Elements -> right click the element -> copy -> copy XPath
    $elements = $xpath->query('//*[@id="wrapper"]/div[4]/div[1]/div[3]/div/div/div/div/a');
    $FacultyLinks = [];
    foreach($elements as $node) {
        $link = 'https://www.dbse.co' . $node->attributes->getNamedItem('href')->value;
        $name = trim(str_replace('كليات','',$node->textContent));
        $FacultyLinks[$name] = $link;
    }
    echo 'Links Saved<br>';
    return $FacultyLinks;
}

function GetFacUnis($link) {
    echo 'Getting data .. ';
    if (!headers_sent()) {
        header('Content-Type: text/html; charset=utf-8');
    }
    $doc = new DOMDocument();
    libxml_use_internal_errors(true);
    $doc->loadHTMLFile($link);
    $xpath = new DOMXpath($doc);
    $elements = $xpath->query("//*/div[@id='yw0']/*/article");

    $FacultyNames = [];
    foreach ($elements as $element) {
        $newXpath = $element->getNodePath();
        $FacultyNames[] = trim($xpath->query($newXpath . '/div[@class="post-content"]/div/h5/a')[0]->textContent);
    }
    echo 'Data extracted<br>';
    return $FacultyNames;
}
//END: Extract faculties data from https://www.dbse.co/ using just the link


?>
<!--JS CODE-->
<script>
    //START: Extract universities' names and logos from https://www.dbse.co/
    let result = {};
    $("#yw0 > div > article").each(function(i) {
        let key = $(this).find('img:first').attr('src');
        let uni = $(this).find('h5 > a:first').html();
        result[key] = uni;
    });
    console.log(JSON.stringify(result));
    //END: Extract universities' names and logos from https://www.dbse.co/

    //START: Extract high institutions from https://www.dbse.co/
    let result = [];
    $("#subEntityType_4").find("article").each(function(i) {
        //let key = $(this).find('img:first').attr('src');
        let uni = $(this).find('h5 > a:first').html();
        result.push(uni.trim().substr(2));
    });
    console.log(JSON.stringify(result));
    //END: Extract high institutions from https://www.dbse.co/
</script>