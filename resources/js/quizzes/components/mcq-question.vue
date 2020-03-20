<template>
    <div class="form-group p-3" v-if="question != undefined" v-bind:class="{'border': corrected, 'border-success': isCorrect(), 'border-danger': !isCorrect()}">
        <h5 v-html="question.text"></h5>
        <div class="form-check form-check-inline" v-for="answer in answers" v-bind:key="answer.id">
            <label class="form-check-label">
                <input class="form-check-input" type="radio" v-model="currentAnswer" :value="answer.id"> {{ answer.text }}
            </label>
        </div>
        <br>
        <small dir="ltr">{{ question.mark }} Mark(s)</small>
    </div>
</template>

<script>
export default {
    name:'mcq-question',
    props: ['question','answers','rightAnswer'],
    data() {
        return {
            currentAnswer: null,
            corrected: false,
        }
    },
    methods: {
        isCorrect() {
           return this.currentAnswer == this.rightAnswer
        },
        correct() {
            this.corrected = true;
        },
        mark() {
            return this.isCorrect() ? this.question.mark : 0;
        }
    }
};
</script>
