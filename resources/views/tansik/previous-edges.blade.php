@extends('layouts.app')
@section('title','تنسيق السنوات السابقة')
@section('head')
<script>
    if (!navigator.onLine) {
        window.location.href = '/offline';
    }
</script>
<link rel="stylesheet" href="{{ mix('css/coordination-previous-edges.css') }}">
@endsection
@section('content')
<div id="edgesApp" class="coordination-page w-100 px-0 px-sm-1">
    <header class="coordination-hero text-center px-3 py-4 px-md-4 py-md-5 mb-4">
        <h1 class="coordination-hero__title h4 h-md-3 mb-3">الحد الأدنى للقبول — كليات ومعاهد مصر عبر السنوات</h1>
        <p class="coordination-hero__lead mb-2">
            جدول واحد يجمع أدنى درجات التنسيق الرسمية من موقع التنسيق الإلكتروني. اختر <strong>شعبتك</strong> ثم
            <strong>نظام الثانوية</strong> اللي ينطبق عليك أو على ابنك، عشان الأرقام تبقى للسنوات والحدود المقارنة لنفس النظام.
        </p>
        <p class="small text-muted mb-0">
            البيانات تُحدَّث عبر الاستيراد من الجداول الرسمية؛ أسماء بعض البرامج قد تختلف إملائيًا عن الموقع.
        </p>
    </header>

    <section class="coordination-filters card border-0 shadow-sm mb-3" aria-label="خيارات العرض والتصفية">
        <div class="card-body p-3 p-md-4">
            <div class="row g-3 g-lg-4 align-items-end">
                <div class="col-12 col-lg-5">
                    <label for="coord-thanawya-system" class="form-label fw-semibold mb-1">
                        نظام الثانوية العامة <span class="text-primary">(مهم للمقارنة)</span>
                    </label>
                    <select id="coord-thanawya-system" class="form-select" v-model="thanawyaSystem">
                        <option value="" disabled>— اختر نظام الثانوية أولًا —</option>
                        @foreach ($coordinationSystemFilters as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <p class="coordination-hint small" v-if="systemHintText" v-text="systemHintText"></p>
                </div>
                <div class="col-6 col-md-6 col-lg-2">
                    <label for="coord-section" class="form-label fw-semibold mb-1">الشعبة</label>
                    <select id="coord-section" class="form-select" v-model="section">
                        <option value="E">علمي</option>
                        <option value="A">أدبي</option>
                    </select>
                </div>
                <div class="col-6 col-md-6 col-lg-2">
                    <label for="coord-per-page" class="form-label fw-semibold mb-1">عدد الصفوف</label>
                    <select id="coord-per-page" class="form-select" v-model="perPage">
                        <option v-for="option in pageOptions" :key="option" :value="option" v-text="option"></option>
                    </select>
                </div>
                <div class="col-12 col-lg-3">
                    <label for="coord-percent" class="form-label fw-semibold mb-1">عرض الأرقام</label>
                    <select id="coord-percent" class="form-select" v-model="percent">
                        <option value="0">المجموع الكلي (الأدق للمقارنة)</option>
                        <option value="1">نسبة مئوية تقريبية</option>
                    </select>
                    <p class="coordination-hint small mb-0" v-if="percent === '1'" v-text="percentModeNote"></p>
                </div>
            </div>
        </div>
    </section>

    <section class="coordination-search-card card border-0 shadow-sm mb-3" aria-label="بحث عن كلية أو معهد">
        <div class="card-body p-3 p-md-4">
            <label for="coord-search" class="form-label fw-semibold mb-2 d-block">بحث سريع</label>
            <div class="input-group input-group-lg">
                <span class="input-group-text" aria-hidden="true"><i class="fas fa-search text-secondary"></i></span>
                <input id="coord-search" type="search" class="form-control" v-model.trim="filterInput"
                    autocomplete="off" enterkeyhint="search"
                    placeholder="اكتب جزء من اسم الكلية أو المعهد — التحديث تلقائي بعد التوقف عن الكتابة"
                    @keydown.enter.prevent="refreshTableNow">
                <button v-if="filterInput" type="button" class="btn btn-outline-secondary" @click="clearSearch"
                    title="مسح البحث" aria-label="مسح البحث">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <p class="coordination-footnote mt-2 mb-0">
                <i class="fas fa-mobile-alt ms-1" aria-hidden="true"></i>
                على الموبايل: مرّر الجدول أفقيًا لرؤية باقي السنوات؛ عمود اسم البرنامج يبقى ثابتًا أثناء التمرير.
            </p>
        </div>
    </section>

    <div class="coordination-sort-banner text-center mb-3" v-if="thanawyaSystem && sortText" v-html="sortText"></div>

    <section class="coordination-table-card card border-0 shadow-sm mb-4" aria-label="جدول الحدود">
        <div v-if="!thanawyaSystem" class="card-body text-center text-muted py-5 px-3">
            <p class="mb-2">
                <i class="fas fa-hand-pointer ms-2 text-primary" aria-hidden="true"></i>
                اختر <strong>نظام الثانوية</strong> من الأعلى لعرض أعمدة السنوات والحدود لكل برنامج ضمن نفس النظام.
            </p>
            <p class="small mb-0">بدون اختيار نظام لن تُحمَّل بيانات التنسيق من الخادم.</p>
        </div>
        <template v-else>
            <div class="card-header py-3 px-3 px-md-4 d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-2">
                <div class="fw-semibold text-body">
                    <i class="fas fa-table ms-2 text-primary" aria-hidden="true"></i>
                    جدول الحدود الأدنى
                </div>
                <div v-if="coordinationFieldsReady" class="coordination-pagination coordination-pagination--top d-none d-md-flex flex-column align-items-stretch w-100 w-md-auto gap-2">
                    <vuetable-pagination-info ref="paginationInfoTop" class="text-center text-md-end small text-muted"></vuetable-pagination-info>
                    <vuetable-pagination-bootstrap ref="paginationTop"
                        @vuetable-pagination:change-page="onChangePage"></vuetable-pagination-bootstrap>
                </div>
            </div>
            <div v-if="!coordinationFieldsReady && !coordinationFieldsError" class="card-body text-center py-5 px-3">
                <div class="spinner-border text-primary mb-3" role="status" aria-label="جاري التحميل"></div>
                <p class="mb-0 text-muted">جاري تحميل أعمدة السنوات والحدود…</p>
            </div>
            <div v-else-if="coordinationFieldsError" class="card-body text-center py-5 px-3">
                <p class="text-danger mb-3" v-text="coordinationFieldsError"></p>
                <button type="button" class="btn btn-outline-primary btn-sm" @click="reloadFieldsAndTable">
                    إعادة المحاولة
                </button>
            </div>
            <template v-else>
                <div class="card-body p-0">
                    <div class="coordination-table-scroll">
                        <vuetable ref="vuetable" api-url="{{ route('tansik.get_edges') }}" http-method="post"
                            :fields="fields" :css="tableCss.table" pagination-path="" :per-page="perPage"
                            :append-params="{ section: section, filter: filterInput, thanawya_system: thanawyaSystem }"
                            :show-sort-icons="true" @vuetable:pagination-data="onPaginationData" track-by="rowKey"
                            @vuetable:loading="loading()" @vuetable:loaded="loaded()" :sort-order="sort"></vuetable>
                    </div>
                </div>
                <div class="card-footer bg-light py-3 coordination-pagination">
                    <vuetable-pagination-info ref="paginationInfo" class="text-center small text-muted mb-2"></vuetable-pagination-info>
                    <vuetable-pagination-bootstrap ref="pagination" @vuetable-pagination:change-page="onChangePage">
                    </vuetable-pagination-bootstrap>
                </div>
            </template>
        </template>
    </section>

    <footer class="coordination-footnote text-center px-2 pb-4">
        <i class="fas fa-info-circle text-primary ms-1" aria-hidden="true"></i>
        للاستفسار الرسمي عن القبول والتنسيق، راجع موقع التنسيق وإرشاد المدرسة. أرقام الموقع للاطلاع والمقارنة فقط.
    </footer>
</div>
@endsection

@section('scripts')
<script>
    window.fields = {!! $fields !!};
    window.coordinationStudentHints = @json($coordinationStudentHints);
    window.coordinationPercentMaxBySystem = @json($coordinationPercentMaxBySystem);
    window.coordinationTableFieldsUrl = @json(route('tansik.coordination_table_fields'));
</script>
<script defer src="{{ mix('js/edges.js') }}"></script>
@endsection
