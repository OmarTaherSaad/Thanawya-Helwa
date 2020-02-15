//Vue
import Vue from 'vue';
import { TablePlugin, PaginationPlugin, FormGroupPlugin, FormSelectPlugin, FormInputPlugin, ButtonPlugin } from 'bootstrap-vue';

Vue.use(TablePlugin);
Vue.use(PaginationPlugin);
Vue.use(FormGroupPlugin);
Vue.use(FormSelectPlugin);
Vue.use(FormInputPlugin);
Vue.use(ButtonPlugin);

import Fuse from 'fuse.js';

window.vueApp = new Vue({
    el: '#edgesApp',
    data: {
        items: [],
        fields: [],
        section: 'A',
        currentPage: 1,
        perPage: 50,
        pageOptions: [10, 20, 30, 50, 100, 300],
        trans: {
            name: 'flip-list'
        },
        percent: 0,
        isPercentNow: 0,
        search: "",
        searchValue: "",
        sortBy: 'avg',
        sortDesc: true,
        isTyping: false,
        filter: null,
        options: {
            shouldSort: true,
            threshold: 0.4,
            location: 0,
            distance: 100,
            maxPatternLength: 32,
            minMatchCharLength: 1,
            keys: ["name"]
        },
        sortOption: {
            numeric: true
        }
    },
    mounted() {
         window.addEventListener("load", function (event) {
             window.vueApp.getEdges();
         });
    },
    watch: {
        search: _.debounce(function () {
            this.isTyping = false;
        }, 800),
        isTyping: function (value) {
            if (!value)
            {
                this.searchValue = this.search;
            }
        }
    },
    methods: {
        getEdges: function () {
            axios.post('/tansik/edges', {
                section: this.section
            })
                .then(function (response) {
                    window.vueApp.items = JSON.parse(response.data.edges);
                    window.vueApp.fields = JSON.parse(response.data.fields);
                    window.vueApp.isPercentNow = 0;
                    this.sortBy = this.sortBy;
                    window.vueApp.GradeOrPercent();
                })
                .catch(function (error) {
                    // handle error
                    //console.log(error);
                });
        },
        GradeOrPercent: function () {
            this.percent = parseInt(this.percent);
            if (!this.isPercentNow != !this.percent)
            {
                //Different Value!
                //If need to return to grades-> retrieve them again (because of percision)
                if (!this.percent)
                {
                    this.getEdges();
                    return;
                }
                this.items.forEach(edge => {
                    Object.keys(edge).forEach(key => {
                        if (!isNaN(edge[key]))
                        {
                            //This needs to be modified
                            edge[key] = (edge[key] * 10 / 41).toFixed(2) + '%';
                        }
                    });
                });
                this.isPercentNow = this.percent;
            }
        },
        onFiltered: function (filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
            this.currentPage = 1;
        },
        Filter: function (item, filterValue) {
            let arr = [item];
            var fuse = new Fuse(arr, this.options);
            let filter = filterValue.replace(/[أإآ]/g, "ا").replace("ى", "ي").replace("ة", "ه").replace('كليه', '');
            if (filter == '')
                return true;
            return fuse.search(filter).length > 0;
        },
        compareFunc: function(row1, row2, key) {
            switch (key) {
                case 'name':
                    return row1[key].localeCompare(row2[key]);
                default:
                    if (row1[key] == row2[key])
                    { return 0; }
                    else {
                        return (row1[key] == "غير موجود") ? -1 : (row2[key] == "غير موجود") ? 1 : row1[key] < row2[key] ? -1 : 1;
                    }
            }
        }
    },
});