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
            let filled = true;
            Object.keys(this.$refs).every(key => {
                if (window.quizApp.$refs[key][0].currentAnswer == null) {
                    alert("Please, answer all questions!");
                    filled = false;
                    return false;
                }
            });
            if (!filled)
                return;
            Object.keys(this.$refs).forEach(key => {
                window.quizApp.$refs[key][0].correct();
                marks += parseInt(window.quizApp.$refs[key][0].mark());
            });
            this.total_mark = marks;
        }
    }
});
