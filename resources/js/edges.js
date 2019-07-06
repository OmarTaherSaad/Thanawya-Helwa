//Vue
import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue);
import 'bootstrap-vue/dist/bootstrap-vue.css';
import Fuse from 'fuse.js';

window.vueApp = new Vue({
    el: '#edgesApp',
    data: {
        items: [],
        fields: [],
        section: 'A',
        currentPage: 1,
        perPage: 20,
        pageOptions: [10, 20, 30, 50, 100, 300],
        trans: {
            name: 'flip-list'
        },
        percent: 0,
        isPercentNow: 0,
        search: "",
        searchValue: "",
        sortBy: 'avg',
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
        getEdges() {
            axios.post('/Tansik/edges', {
                section: this.section
            })
                .then(function (response) {
                    window.vueApp.items = JSON.parse(response.data.edges);
                    window.vueApp.fields = JSON.parse(response.data.fields);
                    window.vueApp.isPercentNow = 0;
                    window.vueApp.GradeOrPercent();
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
        },
        GradeOrPercent() {
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
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
            this.currentPage = 1;
        },
        Filter(item, filterValue) {
            let arr = [item];
            var fuse = new Fuse(arr, this.options);
            let filter = filterValue.replace(/[أإآ]/g, "ا").replace("ى", "ي").replace("ة", "ه").replace('كليه', '');
            if (filter == '')
                return true;
            return fuse.search(filter).length > 0;
        },
        sortChanged() {
            this.sortBy = 'avg';
        }
    },
});
var options = {
    threshold: 0.6,
    location: 0,
    distance: 100,
    maxPatternLength: 32,
    minMatchCharLength: 1,
    keys: ["name"]
};