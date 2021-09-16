import Vue from 'vue';

//Vuetify Timeline component
import Vuetify, { VTimeline, VTimelineItem } from 'vuetify/lib';

Vue.use(Vuetify, {
    components: {
        VTimeline, VTimelineItem
    },
});

window.vueApp = new Vue({
    el: '#app',
    data: {
        display: $('#users-device-size').find('> div:visible').first().attr('id') == 'smallScreen' ? true : false,
        items: [
            {
                time: '9:30 AM',
                title: 'بداية الدخول',
                desc: 'تقدر تيجي وتسجل دخولك، كل اللي هنحتاجه منك هو تذكرتك سواء ورقية في إيدك أو صورة على موبايلك (في حالة إنك دفعت أونلاين فقط)',
            },
            {
                time: '10:00 - 10:30 AM',
                title: 'بداية الـMain Stage والـParents Room',
                desc: 'هنبدأ القمة؛ هيكون الطلبة كلهم عند الـMain Stage، أما أولياء الأمور هيكونوا في مكان خاص بيهم لأن المحتوى بتاعهم مُختلف.',
            },
            {
                time: '12:00 PM',
                title: 'إستراحة للصلاة والفطار',
                desc: 'هناخد استراحة عشان اللي هيروح يصلي الجمعة، واللي يحب يفطر بردو، كل الناس تقدر تطلع برا المكان عادي لأن هيكون تم تسجيلهم بالفعل ويقدروا يرجعوا تاني من غير ما يحتاجوا التذكرة عشان يدخلوا.',
            },
            {
                time: '1:00 PM',
                title: 'استكمال القمة',
                desc: 'هنرجع تاني نكمل في الـMain Stage والـParents Room. الدخول هنا هيكون أسهل وأسرع من أول اليوم؛ لأن مش هنحتاج التذكرة لتأكيد هوية كل شخص.',
            },
            {
                time: '2:30 PM',
                title: 'استراحة',
                desc: 'هيكون انتهى جزء الـMain Stage للطلبة، وهناخد كلنا استراحة قصيرة لكن مش هيكون متاح فيها الخروج برا المكان.',
            },
            {
                time: '3:00 PM',
                title: 'بداية الـWorkshops و الـCoaching',
                desc: 'هنبدأ بجزء الـWorkshops والـCoaching، وكل شخص هيكون عارف اللي هيحضره وإحنا هنساعده يروح المكان اللي هيحضر فيه. بالنسبة لأولياء الأمور فـهيكملوا في مكانهم زي ما هم.',
            },
            {
                time: '6:00 PM',
                title: 'إنتهاء القمة',
                desc: 'هتكون كل شخص حضر المحتوى اللي اختار يحضره، وتنتهي قمة الثانوية العامة لسنة 2019.',
            },
            // {
            //     time: '',
            //     title: '',
            //     desc: '',
            // },
        ],
    },
    methods: {
        onResize() {
            this.display = $('#users-device-size').find('> div:visible').first().attr('id') == 'smallScreen' ? true : false;
        },
    },
    created: function() {
        window.addEventListener('resize', this.onResize);
    },

    beforeDestroy: function() {
        window.removeEventListener('resize', this.onResize);
    },
});
