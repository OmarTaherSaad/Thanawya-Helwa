@extends('layouts.app')
@section('title','تنسيق السنوات السابقة')
@section('head')
    <script>
        if (!navigator.onLine) {
            window.location.href = '/offline';
        }
    </script>
    <style>
        th:first-of-type {
            width: 50%;
        }
        th:not(:first-of-type) {
            width: 35px;
        }
    </style>
@endsection
@section('content')
<div id="edgesApp" class="container-fluid">
    <div class="row text-center">
        <div class="col m-2 p-2">
            <div class="jumbotron jumbotron-fluid">
                <h1>الحد الأدنى لكل كليات ومعاهد مصر</h1>
                <p class="lead">جمعنالك تنسيق الكليات من سنة 2014 ! يعني من بداية ما الثانوية العامة بقت سنة واحدة لأن قبلها
                    كانت سنتين والمجموع كان مختلف.</p>
            </div>
        </div>
    </div>

    <div class="row text-right justify-content-center align-items-end">
        <div class="col-6 col-md-3">
            <div class="form-group text-right focused">
                <label>الشعبة</label>
                <select id="Section" class="form-control filled" v-model="section">
                    <option value="E" selected>علمي</option>
                    <option value="A">أدبي</option>
                </select>
            </div>
        </div>
        <div class="col-12 order-last order-md-12 col-md-5">
            <div class="form-group text-right focused">
                <label>تحب تشوف المجموع الكلي ولا النسب المئوية؟</label>
                <select v-model="percent" class="form-control filled">
                    <option value="0" selected>المجموع الكلي</option>
                    <option value="1">النسبة المئوية</option>
                </select>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="form-group">
                <label for="perPage">عدد الكليات في كل صفحة</label>
                <select class="form-control" id="perPage" v-model="perPage">
                    <option v-for="option in pageOptions" v-bind:value="option" v-html="option"></option>
                </select>
            </div>
        </div>
    </div>
    <div class="row text-right justify-content-center">
        <div class="col-12 text-center">
            <h4>تقدر ترتب الجدول لما تدوس على اسم أي عامود فيه &#128516</h4>
        </div>
        <div class="col-12 text-right">
            <!-- User Interface controls -->
            <div class="row">
                <div class="col-12 my-1">
                    <div class="form-group form-inline">
                        <input type="text" v-model="filterInput" class="form-control mx-1" placeholder="ابحث عن اسم الكلية/المعهد">
                        <button class="btn btn-success mx-1" v-if="filter" @click="filter">
                            ابحث
                        </button>
                        <button class="btn btn-secondary mx-1" v-if="filter" v-on:click="filterInput = ''">
                            مسح المكتوب
                        </button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 my-1">

                    <div v-html="sortText"></div>
                </div>
            </div>
            {{--Table--}}
            <div class="row mb-5">
                <div class="col-12 text-right">
                    <small class="font-wieght-bold d-block d-sm-none">اتحرك يمين وشمال جوا الجدول عشان تشوف باقي السنوات</small>
                    <div class="mb-2 text-center">
                        <vuetable-pagination-info ref="paginationInfoTop"></vuetable-pagination-info>
                        <vuetable-pagination-bootstrap ref="paginationTop"
                            @vuetable-pagination:change-page="onChangePage"></vuetable-pagination-bootstrap>
                    </div>
                    <div class="table-responsive">
                        <vuetable ref="vuetable"
                        api-url="{{ route('tansik.get_edges') }}"
                        http-method="post"
                        :fields="fields"
                        :css="tableCss.table"
                        pagination-path=""
                        :per-page="perPage"
                        :append-params="{section: section, filter: filterInput}"
                        :show-sort-icons="true"
                        @vuetable:pagination-data="onPaginationData"
                        track-by="name"
                        @vuetable:loading="loading()"
                        @vuetable:loaded="loaded()"
                        :sort-order="sort"
                    ></vuetable>
                    </div>
                    <div class="mt-2 text-center">
                        <vuetable-pagination-info ref="paginationInfo"></vuetable-pagination-info>
                        <vuetable-pagination-bootstrap ref="pagination"
                            @vuetable-pagination:change-page="onChangePage"></vuetable-pagination-bootstrap>
                    </div>
                </div>
                <div class="col-12 text-center">
                    <small>جميع البيانات في هذه الجداول مأخوذة من موقع التنسيق، ووجود أخطاء إملائية في أسامي الكليات غير راجع لفريق ثانوية
                        حلوة.</small>
                </div>
            </div>
            <div class="row">
                <div class="col-12 my-1">
                    {{-- Pagination --}}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script async src="{{ asset('js/edges.js') }}"></script>
<script defer>
    window.fields = {!! $fields !!};
</script>
@endsection
