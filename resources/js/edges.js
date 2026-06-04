import "./coordination-axios-setup";
import Vue from "vue";
import Vuetable from "vuetable-2";
import VuetablePaginationBootstrap from "./components/VuetablePaginationBootstrap";
import VuetablePaginationInfo from "vuetable-2/src/components/VuetablePaginationInfo";

window.vueApp = new Vue({
    el: "#edgesApp",
    components: {
        Vuetable,
        VuetablePaginationInfo,
        VuetablePaginationBootstrap,
    },
    data() {
        return {
            edges: null,
            fields: ["avg", "name"],
            section: "E",
            thanawyaSystem: "",
            pageOptions: [10, 20, 30, 50, 100, 300],
            perPage: 50,
            percent: "0",
            isTyping: false,
            filterInput: "",
            sort: [],
            _filterTimer: null,
            _fieldsReloadTimer: null,
            /** Vuetable mounts only after coordination_table_fields succeeds (avoids load/race with wrong columns). */
            coordinationFieldsReady: false,
            coordinationFieldsError: null,
            _coordinationFieldsAbort: null,
            tableCss: {
                table: {
                    tableWrapper: "",
                    tableHeaderClass: "table-dark mb-0",
                    tableBodyClass: "mb-0",
                    tableClass:
                        "table table-sm table-bordered table-hover table-striped align-middle coordination-edges-table mb-0",
                    loadingClass: "loading",
                    ascendingIcon: "fas fa-chevron-up",
                    descendingIcon: "fas fa-chevron-down",
                    ascendingClass: "sorted-asc",
                    descendingClass: "sorted-desc",
                    sortableIcon: "fas fa-sort",
                    detailRowClass: "vuetable-detail-row",
                    handleIcon: "fas fa-bars text-secondary",
                    renderIcon(classes) {
                        return `<i class="${classes.join(" ")}"></i>`;
                    },
                },
            },
        };
    },
    computed: {
        systemHintText() {
            const hints = window.coordinationStudentHints || {};
            return this.thanawyaSystem ? hints[this.thanawyaSystem] || "" : "";
        },
        percentMaxTotal() {
            const map = window.coordinationPercentMaxBySystem || {};
            const v = this.thanawyaSystem ? map[this.thanawyaSystem] : null;
            return typeof v === "number" && v > 0 ? v : 410;
        },
        percentModeNote() {
            const max = this.percentMaxTotal;
            return (
                "النسبة تُحسب كـ (درجة الحد الأدنى ÷ " +
                max +
                ") × 100 — للمقارنة السريعة فقط وليست نسبة رسمية من التنسيق. أعمدة السنوات تعرض فقط سنوات التنسيق المسجّلة ضمن النظام الذي اخترته."
            );
        },
        sortText() {
            if (this.sort.length === 0) {
                return "";
            }
            const sort = this.sort[0];
            let text =
                "الترتيب الحالي: <strong>" +
                (sort.field === "avg"
                    ? "المتوسط"
                    : sort.field === "name"
                    ? "اسم الكلية / المعهد"
                    : sort.field) +
                "</strong> — ";
            if (sort.field === "name") {
                text +=
                    sort.direction === "desc"
                        ? "أبجديًا من ياء إلى ألف"
                        : "أبجديًا من ألف إلى ياء";
            } else {
                text +=
                    sort.direction === "desc"
                        ? "من الأعلى إلى الأقل"
                        : "من الأقل إلى الأعلى";
            }
            return text;
        },
    },
    created() {
        this.fields = window.fields;
        window.fields = null;
    },
    beforeDestroy() {
        clearTimeout(this._filterTimer);
        clearTimeout(this._fieldsReloadTimer);
        if (this._coordinationFieldsAbort) {
            try {
                this._coordinationFieldsAbort.abort();
            } catch (_) {
                /* ignore */
            }
        }
    },
    watch: {
        isTyping(value) {
            if (!value) {
                this.searchValue = this.search;
            }
        },
        filterInput() {
            clearTimeout(this._filterTimer);
            this._filterTimer = setTimeout(() => {
                this.applyNormalizedSearchRefresh();
            }, 480);
        },
        percent() {
            this.$nextTick(() => {
                if (
                    this.thanawyaSystem &&
                    this.coordinationFieldsReady &&
                    this.$refs.vuetable
                ) {
                    this.$refs.vuetable.refresh();
                }
            });
        },
        section() {
            this.scheduleReloadCoordinationFields();
        },
        thanawyaSystem() {
            this.scheduleReloadCoordinationFields();
        },
        perPage() {
            this.$nextTick(() => {
                if (
                    this.thanawyaSystem &&
                    this.coordinationFieldsReady &&
                    this.$refs.vuetable
                ) {
                    this.$refs.vuetable.refresh();
                }
            });
        },
    },
    methods: {
        /**
         * Debounce: section + thanawyaSystem can both update in one interaction; also avoids
         * overlapping in-flight loads that used to trip stale guards and leave the spinner forever.
         */
        scheduleReloadCoordinationFields() {
            clearTimeout(this._fieldsReloadTimer);
            this._fieldsReloadTimer = setTimeout(() => {
                this._fieldsReloadTimer = null;
                this.reloadCoordinationFieldsFromNetwork();
            }, 120);
        },

        reloadCoordinationFieldsImmediate() {
            clearTimeout(this._fieldsReloadTimer);
            this._fieldsReloadTimer = null;
            return this.reloadCoordinationFieldsFromNetwork();
        },

        async reloadFieldsAndTable() {
            return this.reloadCoordinationFieldsImmediate();
        },

        async reloadCoordinationFieldsFromNetwork() {
            if (!this.thanawyaSystem) {
                clearTimeout(this._fieldsReloadTimer);
                this._fieldsReloadTimer = null;
                if (this._coordinationFieldsAbort) {
                    try {
                        this._coordinationFieldsAbort.abort();
                    } catch (_) {
                        /* ignore */
                    }
                    this._coordinationFieldsAbort = null;
                }
                this.coordinationFieldsReady = false;
                this.coordinationFieldsError = null;
                this.fields = [
                    {
                        title: "اسم الكلية",
                        name: "name",
                        sortField: "name",
                    },
                    {
                        title: "المتوسط",
                        name: "avg",
                        sortField: "avg",
                        callback: "edgeView",
                    },
                ];
                return;
            }

            this.coordinationFieldsReady = false;
            this.coordinationFieldsError = null;

            if (this._coordinationFieldsAbort) {
                try {
                    this._coordinationFieldsAbort.abort();
                } catch (_) {
                    /* ignore */
                }
            }
            const abortController = new AbortController();
            this._coordinationFieldsAbort = abortController;

            const url = window.coordinationTableFieldsUrl;
            const token = document.querySelector('meta[name="csrf-token"]');
            if (!url) {
                this.coordinationFieldsError =
                    "تعذر تحديد عنوان تحميل أعمدة الجدول.";
                return;
            }

            try {
                const res = await fetch(url, {
                    signal: abortController.signal,
                    credentials: "same-origin",
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                        ...(token && token.getAttribute("content")
                            ? { "X-CSRF-TOKEN": token.getAttribute("content") }
                            : {}),
                    },
                    body: JSON.stringify({
                        params: {
                            section: this.section,
                            thanawya_system: this.thanawyaSystem,
                            page: 1,
                            per_page: Number(this.perPage) || 50,
                            filter: "",
                            sort: null,
                        },
                    }),
                });

                const rawText = await res.text();

                if (!res.ok) {
                    let detail = "";
                    try {
                        const errBody = JSON.parse(rawText);
                        if (errBody && errBody.message) {
                            detail = String(errBody.message);
                        }
                    } catch (_) {
                        /* ignore */
                    }
                    this.coordinationFieldsError =
                        detail ||
                        "تعذر تحميل أعمدة الجدول (" +
                            res.status +
                            "). جرّب تحديث الصفحة.";
                    return;
                }

                let json;
                try {
                    json = JSON.parse(rawText);
                } catch (parseErr) {
                    console.error(parseErr);
                    this.coordinationFieldsError =
                        "تعذر قراءة استجابة أعمدة الجدول (JSON غير صالح). افتح أدوات المطوّر → Network → coordination-table-fields وتأكد أن الاستجابة JSON وليست صفحة HTML.";
                    return;
                }

                const fieldList = this.extractCoordinationFieldsPayload(json);
                if (!Array.isArray(fieldList) || fieldList.length === 0) {
                    this.coordinationFieldsError =
                        "استجابة غير متوقعة من الخادم لأعمدة الجدول (لا يوجد مصفوفة fields).";
                    return;
                }

                if (!this.thanawyaSystem) {
                    return;
                }

                this.fields = fieldList;
                this.coordinationFieldsReady = true;
            } catch (e) {
                if (e && e.name === "AbortError") {
                    return;
                }
                console.error(e);
                this.coordinationFieldsError =
                    "حصل خطأ أثناء الاتصال بالخادم. تحقق من الشبكة ثم أعد المحاولة.";
            }
        },
        extractCoordinationFieldsPayload(json) {
            if (!json || typeof json !== "object") {
                return null;
            }
            if (Array.isArray(json.fields)) {
                return json.fields;
            }
            if (
                json.data &&
                typeof json.data === "object" &&
                Array.isArray(json.data.fields)
            ) {
                return json.data.fields;
            }
            if (Array.isArray(json.data)) {
                return json.data;
            }
            return null;
        },
        loading() {
            document.body.classList.add("loading");
        },
        loaded() {
            document.body.classList.remove("loading");
        },
        onPaginationData(paginationData) {
            if (!this.thanawyaSystem || !this.coordinationFieldsReady) {
                return;
            }
            if (this.$refs.pagination) {
                this.$refs.pagination.setPaginationData(paginationData);
            }
            if (this.$refs.paginationInfo) {
                this.$refs.paginationInfo.setPaginationData(paginationData);
            }
            if (this.$refs.paginationTop) {
                this.$refs.paginationTop.setPaginationData(paginationData);
            }
            if (this.$refs.paginationInfoTop) {
                this.$refs.paginationInfoTop.setPaginationData(paginationData);
            }
        },
        onChangePage(page) {
            if (
                this.coordinationFieldsReady &&
                this.$refs.vuetable
            ) {
                this.$refs.vuetable.changePage(page);
            }
        },
        normalizeFilterInput(raw) {
            return raw
                .replace(/[أإآ]/g, "ا")
                .replace("ى", "ي")
                .replace("ة", "ه")
                .replace("كليه", "");
        },
        applyNormalizedSearchRefresh() {
            const before = this.filterInput;
            const normalized = this.normalizeFilterInput(before);
            if (normalized !== before) {
                this.filterInput = normalized;
            }
            this.$nextTick(() => {
                if (
                    this.thanawyaSystem &&
                    this.coordinationFieldsReady &&
                    this.$refs.vuetable
                ) {
                    this.$refs.vuetable.refresh();
                }
            });
        },
        refreshTableNow() {
            if (!this.thanawyaSystem) {
                return;
            }
            clearTimeout(this._filterTimer);
            this.applyNormalizedSearchRefresh();
        },
        clearSearch() {
            clearTimeout(this._filterTimer);
            this.filterInput = "";
            this.$nextTick(() => {
                if (
                    this.thanawyaSystem &&
                    this.coordinationFieldsReady &&
                    this.$refs.vuetable
                ) {
                    this.$refs.vuetable.refresh();
                }
            });
        },
        edgeView(value) {
            const n = Number(value);
            if (!Number.isFinite(n)) {
                return "غير موجود";
            }
            if (String(this.percent) !== "1") {
                return value;
            }
            const max = this.percentMaxTotal;
            if (!max || max <= 0) {
                return value;
            }
            return ((n / max) * 100).toFixed(2) + "%";
        },
    },
});
