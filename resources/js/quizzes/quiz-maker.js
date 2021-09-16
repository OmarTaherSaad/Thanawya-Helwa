import Vue from 'vue';

import MCQquestion from './components/mcq-question'
Vue.component("mcq-question", MCQquestion);

window.quizApp = new Vue({
    el: "#quiz-maker-container",
    data: {
        question: {
            id: null,
            text: ""
        },
        answers: [],
        tempAnswer: {
            id: null,
            text: ""
        },
        tempRightAnswer: null,
        type: null,
        MCQ: [],
        desc: "",
        subject: null,
        maker: 0,
        revisor: 0,
        saveURL: null,
        alerts: null,
        alertsList: null
    },
    computed: {
        totalMarks() {
            let marks = 0;
            this.MCQ.forEach(q => {
                marks += parseInt(q.question.mark);
            });
            return marks;
        },
        nextQuestionID() {
            return (
                this.MCQ.length +
                // this.TrueOrFalse.length +
                // this.Written.length +
                1
            );
        },
        nextAnswerID() {
            return this.answers.length + 1;
        }
    },
    watch: {
        tempRightAnswer(value) {
            if (
                (isNaN(value) || value < 1 || value > this.answers.length) &&
                value != null
            ) {
                this.tempRightAnswer = null;
            }
        }
    },
    methods: {
        addQclicked() {
            if (
                this.tempRightAnswer == null ||
                isNaN(this.tempRightAnswer) ||
                this.tempRightAnswer < 1 ||
                this.tempRightAnswer > this.answers.length
            ) {
                alert("Right answer is not valid");
                return;
            }
            if (this.question.text < 2) {
                alert("Question is too short!");
                return;
            }
            if (
                this.question.mark == null ||
                isNaN(this.question.mark) ||
                this.question.mark < 0
            ) {
                alert("Mark must be a valid number");
                return;
            }
            this.question.id = this.nextQuestionID;
            switch (this.type) {
                case "MCQ":
                    this.MCQ.push({
                        question: JSON.parse(JSON.stringify(this.question)),
                        answers: JSON.parse(JSON.stringify(this.answers)),
                        rightAnswer: JSON.parse(
                            JSON.stringify(this.tempRightAnswer)
                        )
                    });
                    break;
            }
            this.question = {
                id: null,
                text: "",
                mark: 0
            };
            this.answers = [];
            this.tempAnswer = {
                id: null,
                text: ""
            };
            this.tempRightAnswer = null;
        },
        addAnswer() {
            if (this.tempAnswer.text < 2) {
                alert("Answer is too short!");
                return;
            }
            this.tempAnswer.id = this.nextAnswerID;
            this.answers.push(JSON.parse(JSON.stringify(this.tempAnswer)));
            this.tempAnswer.text = "";
        },
        saveQuiz() {
            if (
                this.saveURL == null ||
                this.MCQ.length == 0 ||
                this.subject == null ||
                this.desc == "" ||
                this.totalMarks < 1 ||
                this.maker == 0 ||
                this.revisor == 0
            ) {
                alert("Data not completed!");
                return;
            }
            let alerts = "";
            let alertsList = null;
            axios
                .post(this.saveURL, {
                    questions: this.MCQ,
                    subject: this.subject,
                    description: this.desc,
                    total_mark: this.totalMarks,
                    maker: this.maker,
                    revisor: this.revisor
                })
                .then(response => {
                    if (response.data.success == undefined) {
                        alerts = false;
                        alertsList = Object.values(response.data);
                    } else {
                        alerts = true;
                        alertsList = { Done: response.data.message };
                        this.MCQ = [];
                        this.subject = null;
                        this.desc = "";
                    }
                })
                .catch(error => {
                    alertsList = error.errors;
                    alerts = false;
                })
                .finally(function() {
                    window.quizApp.$data.alertsList = alertsList;
                    window.quizApp.$data.alerts = alerts;
                    window.scrollTo(0, 0);
                });
        },
        updateQuiz() {
            if (
                this.saveURL == null ||
                this.MCQ.length == 0 ||
                this.subject == null ||
                this.desc == "" ||
                this.totalMarks < 1 ||
                this.maker == 0 ||
                this.revisor == 0
            ) {
                alert("Data not completed!");
                return;
            }
            let alerts = "";
            let alertsList = null;
            axios
                .patch(this.saveURL, {
                    questions: this.MCQ,
                    subject: this.subject,
                    description: this.desc,
                    total_mark: this.totalMarks,
                    maker: this.maker,
                    revisor: this.revisor
                })
                .then(response => {
                    if (response.data.success == undefined) {
                        alerts = false;
                        alertsList = Object.values(response.data);
                    } else {
                        alerts = true;
                        alertsList = { Done: response.data.message };
                    }
                })
                .catch(error => {
                    alertsList = error.errors;
                    alerts = false;
                })
                .finally(function() {
                    window.quizApp.$data.alertsList = alertsList;
                    window.quizApp.$data.alerts = alerts;
                    window.scrollTo(0, 0);
                });
        },
        deleteQuestion(index) {
            this.MCQ.splice(index, 1);
        },
        deleteAnswer() {
            this.answers.pop();
        }
    }
});
