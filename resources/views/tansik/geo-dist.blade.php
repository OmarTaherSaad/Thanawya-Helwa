@extends('layouts.app')
@section('title','جدول التوزيع الجغرافي الخاص بيك')
@section('head')
    <link href="{{ mix('css/jquery-ui.min.css') }}" rel="stylesheet">
    <style>
        #DistTable {
            display: none;
        }
        select {
            width: 100%;
            display: inline;
        }
    </style>
@endsection
@section('content')
<div class="row text-center">
    <div class="col m-2 p-2">
        <div class="jumbotron jumbotron-fluid">
            <h2>توزيع القبول الجغرافي لجميع محافظات مصر</h2>
            <p class="lead">هنا تقدر تشوف الجامعات كلها هتكون في أنهي مجموعة بالنسبالك .. لمعلومات أكتر عن المجموعات
                وتأثيرها في التنسيق <a href="{{ route('Tansik-Geo-Dist-Info') }}">دوس هنا</a>.</p>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-md-6">
        <div class="form-group text-right">
            <label for="gov">اختار محافظتك</label>
            <select id="gov" class="custom-select" onchange="getAdmin(this.value)">
                <option disabled selected>اضغط هنا لتقوم بالاختيار</option>
                @foreach ($govs as $val => $gov)
                    <option value="{{ $val }}">{{ $gov }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-md-8">
        <div id="adminDiv" style="display:none;" class="form-group text-right">
            <label>اختار الإدارة التابع ليها</label>
            <select id="admins" onchange="getDist(this.value);" class="custom-select w-100">

            </select>

        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-md-6 table-responsive text-right" id="result" dir="rtl">
        <table id="DistTable" class="table table-striped table-bordered table-responsive">
            <thead>
                <tr>
                    <th>المجموعة</th>
                    <th>الجامعة</th>
                </tr>
            </thead>
            <tbody>{{--Filled with JS--}}</tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
function getAdmin(val) {
    $("#gov").attr('disabled',true);
    $("#adminDiv , #DistTable").hide();
    axios.post('/Tansik/gov', {
        gov: val
    })
    .then(function (r) {
        if (r.data.admins === 0) {
            //No Admins
            makeDistTable(r.data.dist);

        } else {
            //Admins exist
            JSONresponse = JSON.parse(r.data);
            $("#admins").empty();
            $("#admins").append('<option selected disabled>اختر الإدارة</option');
            JSONresponse.forEach(admin => {
                $("#admins").append('<option value="'+admin['id']+'">'+admin['name']+'</option');
            });
            $("#adminDiv").show(1000);
        }
    });
    $("#gov").attr('disabled',false);
}

function getDist(val) {
    $("#admins").attr('disabled',true);

    axios.post('/Tansik/admin', {
        admin: val
    })
    .then(function (r) {
        makeDistTable(r.data[0]);
    });

    $("#admins").attr('disabled',false);
}

function makeDistTable(DistArr) {
    //Fill Data in table
    let tableBody = $("#DistTable > tbody:first");
    tableBody.empty();
    for (let row of DistArr) {
        tableBody.append(`
        <tr>
            <td>`+row[0]+`</td>
            <td>`+row[1]+`</td>
        </tr>`);
    }
    //Show it
    $("#DistTable").show(1000);
    //Instantiate Tabular for grouping
    
    // code for grouping rows
    var $rows = $("#DistTable > tbody").find('tr');
    var items = [],
        itemtext = [],
        currGroupStartIdx = 0;
    $rows.each(function (i) {
        var $this = $(this);
        var itemCell = $(this).find('td:eq(0)');
        var item = itemCell.text();
        itemCell.remove();
        if ($.inArray(item, itemtext) === -1) {
            itemtext.push(item);
            items.push([i, item]);
            groupRowSpan = 1;
            currGroupStartIdx = i;
            $this.data('rowspan', 1);
        } else {
            var rowspan = $rows.eq(currGroupStartIdx).data('rowspan') + 1;
            $rows.eq(currGroupStartIdx).data('rowspan', rowspan);
        }

    });



    $.each(items, function (i) {
        var $row = $rows.eq(this[0]);
        var rowspan = $row.data('rowspan');
        $row.append('<td rowspan="' + rowspan + '">' + this[1] + '</td>');
    });
    //END
    jQuery.each($("table tr"), function () {
        $(this).children(":eq(1)").after($(this).children(":eq(0)"));
    });
    $('html, body').animate({
        scrollTop: $("#DistTable").offset().top - 100
    }, 1000);
}
</script>
@endsection