import Vuetable from "vuetable-2";
import VuetablePaginationBootstrap from "./components/VuetablePaginationBootstrap";
import VuetablePaginationInfo from "vuetable-2/src/components/VuetablePaginationInfo";

window.vueApp = new Vue({
    el: "#edgesApp",
    components: {
        Vuetable,
        VuetablePaginationInfo,
        VuetablePaginationBootstrap
    },
    data: {
        edges: null,
        fields: ["avg", "name"],
        section: "E",
        sectionForTable: "E",
        pageOptions: [10, 20, 30, 50, 100, 300],
        perPage: 50,
        percent: 0,
        isTyping: false,
        filterInput: "",
        sort: [],
        tableCss: {
            table: {
                tableWrapper: "",
                tableHeaderClass: "thead-dark mb-0",
                tableBodyClass: "mb-0",
                tableClass: "table table-bordered table-hover table-striped",
                loadingClass: "loading",
                ascendingIcon: "fas fa-chevron-up",
                descendingIcon: "fas fa-chevron-down",
                ascendingClass: "sorted-asc",
                descendingClass: "sorted-desc",
                sortableIcon: "fas fa-sort",
                detailRowClass: "vuetable-detail-row",
                handleIcon: "fas fa-bars text-secondary",
                renderIcon(classes, options) {
                    return `<i class="${classes.join(" ")}"></span>`;
                }
            }
        }
    },
    created() {
        this.fields = window.fields;
        window.fields = null;
    },
    mounted() {
        //this.getData();
    },
    computed: {
        sortText() {
            if (this.sort.length == 0) return "";
            let sort = this.sort[0];
            let text =
                "الجدول مُرتب طبقًا لـ <b>" +
                (sort.field == "avg"
                    ? "المتوسط"
                    : sort.field == "name"
                    ? "اسم الكلية"
                    : sort.field) +
                " ";
            if (sort.field == "name") {
                text +=
                    sort.direction == "desc" ? "أبجديًا بشكل عكسي" : "أبجديًا";
            } else {
                text +=
                    sort.direction == "desc"
                        ? "من الأعلى للأقل"
                        : "من الأقل للأعلى";
            }
            text += "</b>";
            return text;
        }
    },
    watch: {
        isTyping: function(value) {
            if (!value) {
                this.searchValue = this.search;
            }
        },
        section() {
            this.$nextTick(function() {
                window.vueApp.$refs.vuetable.refresh();
            });
        },
        perPage() {
            this.$nextTick(function() {
                window.vueApp.$refs.vuetable.refresh();
            });
        }
    },
    methods: {
        loading() {
            document.body.classList.add("loading");
        },
        loaded() {
            document.body.classList.remove("loading");
        },
        onPaginationData(paginationData) {
            this.$refs.pagination.setPaginationData(paginationData);
            this.$refs.paginationInfo.setPaginationData(paginationData);
            this.$refs.paginationTop.setPaginationData(paginationData);
            this.$refs.paginationInfoTop.setPaginationData(paginationData);
        },
        onChangePage(page) {
            this.$refs.vuetable.changePage(page);
        },
        edgeView(value) {
            return isNaN(value)
                ? "غير موجود"
                : this.percent == "1"
                ? ((value * 10) / 41).toFixed(2) + "%"
                : value;
        },
        filter() {
            let filter = this.filterInput
                .replace(/[أإآ]/g, "ا")
                .replace("ى", "ي")
                .replace("ة", "ه")
                .replace("كليه", "");
            this.filterInput = filter;

            this.$nextTick(function() {
                window.vueApp.$refs.vuetable.refresh();
            });
        }
    }
});
