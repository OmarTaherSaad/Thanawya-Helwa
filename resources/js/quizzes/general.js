import Vue from 'vue';

import MCQquestion from "./components/mcq-question";
Vue.component("mcq-question", MCQquestion);

window.quizApp = new Vue({
    el: "#quiz-maker-container",
    data: {
        questions: [],
        description: "",
        subject: null,
        total_mark: null,
        submitURL: null,
        alerts: null,
        alertsList: null
    },
    methods: {
        submit() {
            let marks = 0;
            let filled = Object.keys(this.$refs).every(key => {
                console.log(window.quizApp.$refs[key][0].currentAnswer == null);
                return window.quizApp.$refs[key][0].currentAnswer != null;
            });
            if (!filled)
            {
                alert("Please, answer all questions!");
                return;
            }
            Object.keys(this.$refs).forEach(key => {
                window.quizApp.$refs[key][0].correct();
                marks += parseInt(window.quizApp.$refs[key][0].mark());
            });
            this.total_mark = marks;
        }
    }
});
