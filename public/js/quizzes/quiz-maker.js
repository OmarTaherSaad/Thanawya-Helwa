!function(t){var e={};function s(n){if(e[n])return e[n].exports;var r=e[n]={i:n,l:!1,exports:{}};return t[n].call(r.exports,r,r.exports,s),r.l=!0,r.exports}s.m=t,s.c=e,s.d=function(t,e,n){s.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:n})},s.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},s.t=function(t,e){if(1&e&&(t=s(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var n=Object.create(null);if(s.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var r in t)s.d(n,r,function(e){return t[e]}.bind(null,r));return n},s.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return s.d(e,"a",e),e},s.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},s.p="",s(s.s=75)}({1:function(t,e,s){"use strict";function n(t,e,s,n,r,i,o,a){var u,l="function"==typeof t?t.options:t;if(e&&(l.render=e,l.staticRenderFns=s,l._compiled=!0),n&&(l.functional=!0),i&&(l._scopeId="data-v-"+i),o?(u=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),r&&r.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(o)},l._ssrRegister=u):r&&(u=a?function(){r.call(this,this.$root.$options.shadowRoot)}:r),u)if(l.functional){l._injectStyles=u;var c=l.render;l.render=function(t,e){return u.call(e),c(t,e)}}else{var h=l.beforeCreate;l.beforeCreate=h?[].concat(h,u):[u]}return{exports:t,options:l}}s.d(e,"a",(function(){return n}))},15:function(t,e,s){"use strict";var n={name:"mcq-question",props:["question","answers","rightAnswer"],data:function(){return{currentAnswer:null,corrected:!1}},methods:{isCorrect:function(){return this.currentAnswer==this.rightAnswer},correct:function(){this.corrected=!0},mark:function(){return this.isCorrect()?this.question.mark:0}}},r=s(1),i=Object(r.a)(n,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return null!=t.question?s("div",{staticClass:"form-group p-3",class:{border:t.corrected,"border-success":t.isCorrect(),"border-danger":!t.isCorrect()}},[s("h5",{domProps:{innerHTML:t._s(t.question.text)}}),t._v(" "),t._l(t.answers,(function(e){return s("div",{key:e.id,staticClass:"form-check form-check-inline"},[s("label",{staticClass:"form-check-label"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.currentAnswer,expression:"currentAnswer"}],staticClass:"form-check-input",attrs:{type:"radio"},domProps:{value:e.id,checked:t._q(t.currentAnswer,e.id)},on:{change:function(s){t.currentAnswer=e.id}}}),t._v(" "+t._s(e.text)+"\n        ")])])})),t._v(" "),s("br"),t._v(" "),s("small",{attrs:{dir:"ltr"}},[t._v(t._s(t.question.mark)+" Mark(s)")])],2):t._e()}),[],!1,null,null,null);e.a=i.exports},75:function(t,e,s){t.exports=s(76)},76:function(t,e,s){"use strict";s.r(e);var n=s(15);Vue.component("mcq-question",n.a),window.quizApp=new Vue({el:"#quiz-maker-container",data:{question:{id:null,text:""},answers:[],tempAnswer:{id:null,text:""},tempRightAnswer:null,type:null,MCQ:[],desc:"",subject:null,maker:0,revisor:0,saveURL:null,alerts:null,alertsList:null},computed:{totalMarks:function(){var t=0;return this.MCQ.forEach((function(e){t+=parseInt(e.question.mark)})),t},nextQuestionID:function(){return this.MCQ.length+1},nextAnswerID:function(){return this.answers.length+1}},watch:{tempRightAnswer:function(t){(isNaN(t)||t<1||t>this.answers.length)&&null!=t&&(this.tempRightAnswer=null)}},methods:{addQclicked:function(){if(null==this.tempRightAnswer||isNaN(this.tempRightAnswer)||this.tempRightAnswer<1||this.tempRightAnswer>this.answers.length)alert("Right answer is not valid");else if(this.question.text<2)alert("Question is too short!");else if(null==this.question.mark||isNaN(this.question.mark)||this.question.mark<0)alert("Mark must be a valid number");else{switch(this.question.id=this.nextQuestionID,this.type){case"MCQ":this.MCQ.push({question:JSON.parse(JSON.stringify(this.question)),answers:JSON.parse(JSON.stringify(this.answers)),rightAnswer:JSON.parse(JSON.stringify(this.tempRightAnswer))})}this.question={id:null,text:"",mark:0},this.answers=[],this.tempAnswer={id:null,text:""},this.tempRightAnswer=null}},addAnswer:function(){this.tempAnswer.text<2?alert("Answer is too short!"):(this.tempAnswer.id=this.nextAnswerID,this.answers.push(JSON.parse(JSON.stringify(this.tempAnswer))),this.tempAnswer.text="")},saveQuiz:function(){var t=this;if(null==this.saveURL||0==this.MCQ.length||null==this.subject||""==this.desc||this.totalMarks<1||0==this.maker||0==this.revisor)alert("Data not completed!");else{var e="",s=null;axios.post(this.saveURL,{questions:this.MCQ,subject:this.subject,description:this.desc,total_mark:this.totalMarks,maker:this.maker,revisor:this.revisor}).then((function(n){null==n.data.success?(e=!1,s=Object.values(n.data)):(e=!0,s={Done:n.data.message},t.MCQ=[],t.subject=null,t.desc="")})).catch((function(t){s=t.errors,e=!1})).finally((function(){window.quizApp.$data.alertsList=s,window.quizApp.$data.alerts=e,window.scrollTo(0,0)}))}},updateQuiz:function(){if(null==this.saveURL||0==this.MCQ.length||null==this.subject||""==this.desc||this.totalMarks<1||0==this.maker||0==this.revisor)alert("Data not completed!");else{var t="",e=null;axios.patch(this.saveURL,{questions:this.MCQ,subject:this.subject,description:this.desc,total_mark:this.totalMarks,maker:this.maker,revisor:this.revisor}).then((function(s){null==s.data.success?(t=!1,e=Object.values(s.data)):(t=!0,e={Done:s.data.message})})).catch((function(s){e=s.errors,t=!1})).finally((function(){window.quizApp.$data.alertsList=e,window.quizApp.$data.alerts=t,window.scrollTo(0,0)}))}},deleteQuestion:function(t){this.MCQ.splice(t,1)},deleteAnswer:function(){this.answers.pop()}}})}});