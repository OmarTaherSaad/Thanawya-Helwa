@extends('layouts.app')
@section('title','تنسيق السنوات السابقة')
@section('content')
{{-- {{ dd($Edges) }} --}}
<div id="edgesApp">
    <div class="row text-center">
        <div class="col m-2 p-2">
            <div class="jumbotron jumbotron-fluid">
                <h1>الحد الأدنى لكل كليات ومعاهد مصر</h1>
                <p class="lead">جمعنالك تنسيق الكليات من سنة 2014 ! يعني من بداية ما الثانوية العامة بقت سنة واحدة لأن قبلها
                    كانت سنتين والمجموع كان مختلف.</p>
            </div>
        </div>
    </div>

    <div class="row text-right justify-content-center">
        <div class="col-6 col-md-3">
            <div class="form-group text-right focused">
                <label>الشعبة</label>
                <select id="Section" class="form-control filled" v-model="section" v-on:change="getEdges()">
                    <option value="E" selected>علمي</option>
                    <option value="A">أدبي</option>
                </select>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group text-right focused">
                <label>تحب تشوف المجموع الكلي ولا النسب المئوية؟</label>
                <select v-model="percent" v-on:change="GradeOrPercent()" class="form-control filled">
                    <option value="0" selected>المجموع الكلي</option>
                    <option value="1">النسبة المئوية</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row text-right justify-content-center">
        <div class="col-12 text-center">
            <h4>تقدر ترتب الجدول لما تدوس على اسم أي عامود فيه :)</h4>
            <h4 class="d-block d-sm-none">اتحرك يمين وشمال جوا الجدول عشان تشوف باقي السنوات</h4>
        </div>
        <div class="col-12 text-right">
            <!-- User Interface controls -->
            <div class="row">
                <div class="col-12 col-md-6 my-1">
                    <b-form-group label-cols-sm="3" label="اكتب اسم أي كلية عايز تشوف درجاتها" class="mb-0">
                            <div class="form-inline mx-0 px-0" id="searchBox">
                                <b-form-input class="mx-1" v-on:input="isTyping = true" v-model="filter" placeholder="اكتب لتقوم بالبحث"></b-form-input>
                                <b-button class="mx-1" v-if="filter" :disabled="!filter" v-on:click="filter = ''">مسح المكتوب</b-button>
                            </div>
                    </b-form-group>
                </div>
                <div class="col-12 col-md-6 my-1">
                    <b-form-group label-cols-sm="3" label="عدد الكليات في كل صفحة" class="mb-0">
                        <b-form-select v-model="perPage" :options="pageOptions"></b-form-select>
                    </b-form-group>
                </div>
            </div>
            <div class="row">
                <div class="col-12 my-1">
                    <b-pagination v-model="currentPage" align="center" :total-rows="items.length" :per-page="perPage" class="my-0">
                    </b-pagination>
                </div>
            </div>
            {{--Table--}}
            <div class="row">
                <div class="col-12">
                    <b-table dir="rtl" class="mx-0"
                    ref="table"
                    striped hover bordered small responsive foot-clone
                    :sort-compare-options="{ numeric: true }"
                    head-variant="dark"
                    :items="items"
                    :fields="fields"
                    :current-page="currentPage"
                    :per-page="perPage"
                    :tbody-transition-props="trans"
                    :filter="filter"
                    :filter-function="Filter"
                    :sort-by.sync="sortBy"
                    v-on:sort-changed="sortChanged"
                    v-on:filtered="onFiltered">
                    <template slot="table-caption">جميع البيانات في هذه الجداول مأخوذة من موقع التنسيق، ووجود أخطاء إملائية في أسامي الكليات غير راجع لفريق ثانوية حلوة.</template>
                    </b-table>
                </div>
            </div>
            <div class="row">
                <div class="col-12 my-1">
                    <b-pagination v-model="currentPage" align="center" :total-rows="items.length" :per-page="perPage" class="my-0"></b-pagination>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script defer src="{{ asset('js/edges.js') }}"></script>
<script defer>
    const offsetSearchBox = $("#searchBox").offset().top;
    window.document.body.onscroll = function() {
        if ($(window).scrollTop() >= offsetSearchBox) {
            //Move it
            $("#searchBox").addClass('fixIt');
            $("#searchBox").css('top',$("nav").height() + 20);
        } else {
            $("#searchBox").removeClass('fixIt');
            $("#searchBox").css('top',0);
        }
    }
</script>
@endsection