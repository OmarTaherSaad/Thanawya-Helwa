//Vuetify Timeline component
import Vuetify, { VStepper, VStepperStep, VStepperHeader, VStepperContent, VStepperItems } from 'vuetify/lib';

Vue.use(Vuetify, {
    components: {
        VStepper, VStepperStep, VStepperHeader, VStepperContent, VStepperItems
    },
});

window.vueApp = new Vue({
    el: '#edgesApp',
    data: {
        result: {
            A: null,
            B: null,
            C: null,
            D: null
        },
        chartLabels: {
            A: "A | حقائقي",
            D: "D | منفتح",
            C: "C | مشاعري",
            B: "B | تحكمي"
        },
        questions: {
            Question1: {
                Type: "A",
                Question: "حرصي على الدقة والحقائق قد يجعلني في نظر الآخرين جاف المشاعر",
                Answer: null,
                Class: "custom-select"
            },
            Question2: {
                Type: "C",
                Question: "أعمل مع الآخرين عن طيب نفس من أجل هدف مشترك",
                Answer: null,
                Class: "custom-select"
            },
            Question3: {
                Type: "A",
                Question: "أدرك الأرقام وأتصورها وأعي دلالاتها ولديّ القدرة على حسابها وتطويعها لما أرغب",
                Answer: null,
                Class: "custom-select"
            },
            Question4: {
                Type: "C",
                Question: "لدي القدرة على توقع احتياجات الآخرين ومن ثم مراعاتها",
                Answer: null,
                Class: "custom-select"
            },
            Question5: {
                Type: "D",
                Question: "أدرك الكثير من الأشياء بالحدس والبديهة دون التفكير العميق فيها",
                Answer: null,
                Class: "custom-select"
            },
            Question6: {
                Type: "B",
                Question: "حذر وحريص واهتم بالعواقب كثيرا",
                Answer: null,
                Class: "custom-select"
            },
            Question7: {
                Type: "C",
                Question: "أجمل اللحظات هي اللحظات التي أسعد فيها الآخرين",
                Answer: null,
                Class: "custom-select"
            },
            Question8: {
                Type: "D",
                Question: "أتحمس للأهداف وأكرس لها وقتي وجهدي كله",
                Answer: null,
                Class: "custom-select"
            },
            Question9: {
                Type: "A",
                Question: "أستطيع أن أحدد سبب المشكلة عند حدوثها وأحللها ثم أجد لها الحل المناسب",
                Answer: null,
                Class: "custom-select"
            },
            Question10: {
                Type: "B",
                Question: "لا يمكن أن أصبر على الفوضى بل أرتب وأنظم كل الأمور والأشياء الخاصة والعامة",
                Answer: null,
                Class: "custom-select"
            },
            Question11: {
                Type: "C",
                Question: "لدي القدرة على تنمية العلاقات مع الآخرين والمحافظة عليها والتواصل معهم",
                Answer: null,
                Class: "custom-select"
            },
            Question12: {
                Type: "D",
                Question: "المال عندي للإنفاق ويصعب علي جمعه",
                Answer: null,
                Class: "custom-select"
            },
            Question13: {
                Type: "A",
                Question: "لست بخيلا ولكني لا أصرف شيئا من مالي إلا بعد تحليل ودراسة متأنية لمدى أهمية الأمر لي",
                Answer: null,
                Class: "custom-select"
            },
            Question14: {
                Type: "D",
                Question: "أكره الروتين وأحب التغيير دائما",
                Answer: null,
                Class: "custom-select"
            },
            Question15: {
                Type: "B",
                Question: "أحافظ على أغراضي وممتلكاتي بطريقة منظمة ومرتبة",
                Answer: null,
                Class: "custom-select"
            },
            Question16: {
                Type: "D",
                Question: "يقول بعض الناس عني ( أنت مندفع ولا يمكن توقع أفعالك)",
                Answer: null,
                Class: "custom-select"
            },
            Question17: {
                Type: "A",
                Question: "أعتبر نفسي أسير بوضوح إلى هدفي الذي قررته",
                Answer: null,
                Class: "custom-select"
            },
            Question18: {
                Type: "B",
                Question: "أنفذ الأمور دائما خطوة بخطوة وأتمتع بالدقة في عملي",
                Answer: null,
                Class: "custom-select"
            },
            Question19: {
                Type: "C",
                Question: "أعتبر أن علاقتي الطيبة مع الآخرين هي أعز ما أملك",
                Answer: null,
                Class: "custom-select"
            },
            Question20: {
                Type: "B",
                Question: "أميل للفعل أكثر من ميلي للتأمل والتفكير والتنظير",
                Answer: null,
                Class: "custom-select"
            },
            Question21: {
                Type: "C",
                Question: "مستعد للخدمة وتقديم نفسي للآخرين متى احتاجوا إلى ذلك",
                Answer: null,
                Class: "custom-select"
            },
            Question22: {
                Type: "A",
                Question: "أجد نفسي أفكر وأستنتج بعيد اً عن العاطفة والمشاعر",
                Answer: null,
                Class: "custom-select"
            },
            Question23: {
                Type: "B",
                Question: "يعتمد علي الآخرون ويثقون في إنجازي و إخلاصي",
                Answer: null,
                Class: "custom-select"
            },
            Question24: {
                Type: "C",
                Question: "أحب التحدث مع الآخرين عن مشاعري وقصصي",
                Answer: null,
                Class: "custom-select"
            },
            Question25: {
                Type: "D",
                Question: "تستهويني الأفكار غير الاعتيادية والتي يسمونها الآخرون أفكار مجنونة",
                Answer: null,
                Class: "custom-select"
            },
            Question26: {
                Type: "A",
                Question: "لدي قدرة عالية على تعليل الأحداث واستنتاج آثارها المنطقية",
                Answer: null,
                Class: "custom-select"
            },
            Question27: {
                Type: "B",
                Question: "لدي القدرة على مواصلة العمل حتى انجازه",
                Answer: null,
                Class: "custom-select"
            },
            Question28: {
                Type: "C",
                Question: "أجيد بث الحماس في همم الآخرين",
                Answer: null,
                Class: "custom-select"
            },
            Question29: {
                Type: "A",
                Question: "أمتلك معرفه مميزة بالمواضيع العلمية والتقنية",
                Answer: null,
                Class: "custom-select"
            },
            Question30: {
                Type: "C",
                Question: "أعتبر نفسي عطوفا ولطيفا وآنس بالآخرين وأساعدهم متى احتاجوا",
                Answer: null,
                Class: "custom-select"
            },
            Question31: {
                Type: "D",
                Question: "أحب العمل في أكثر من شي وفي وقت واحد",
                Answer: null,
                Class: "custom-select"
            },
            Question32: {
                Type: "C",
                Question: "أراقب وجوه الآخرين لا إراديا عندما يتحدثوا إلي",
                Answer: null,
                Class: "custom-select"
            },
            Question33: {
                Type: "D",
                Question: "كثيرا ما تراودني الأفكار الجديدة",
                Answer: null,
                Class: "custom-select"
            },
            Question34: {
                Type: "B",
                Question: "لا أحب أن يقاطع أحد نمطي الروتيني",
                Answer: null,
                Class: "custom-select"
            },
            Question35: {
                Type: "B",
                Question: "أشعر بارتياح أثناء أدائي لأعمال التصنيف والترتيب والتنظيم",
                Answer: null,
                Class: "custom-select"
            },
            Question36: {
                Type: "D",
                Question: "أهتم عادة بالصورة العامة ولا أدقق في التفاصيل",
                Answer: null,
                Class: "custom-select"
            },
            Question37: {
                Type: "A",
                Question: "أعتقد إن العمل أهم بكثير من المشاعر الإنسانية",
                Answer: null,
                Class: "custom-select"
            },
            Question38: {
                Type: "A",
                Question: "يُفضِّلُ الآخرون أن أتولى زمام القيادة لمعرفتي لدقائق الأمور",
                Answer: null,
                Class: "custom-select"
            },
            Question39: {
                Type: "B",
                Question: "أدون التزاماتي الاجتماعية في مفكرتي الخاصة وأحرص على القيام بها",
                Answer: null,
                Class: "custom-select"
            },
            Question40: {
                Type: "D",
                Question: "أتمتع بروح الدعابة التي قد توقعني في مشاكل",
                Answer: null,
                Class: "custom-select"
            },
            Question41: {
                Type: "D",
                Question: "أميل في حكمي على الأشياء على حدسي وتوقعاتي أكثر من ميلي إلى الدقة والتحليل",
                Answer: null,
                Class: "custom-select"
            },
            Question42: {
                Type: "B",
                Question: "أفضل تعليمات محددة؛ على أن يترك الأمر بلا تعليمات محددة وواضحة",
                Answer: null,
                Class: "custom-select"
            },
            Question43: {
                Type: "C",
                Question: "يصفني الناس بأني عاطفي ومجامل ولطيف",
                Answer: null,
                Class: "custom-select"
            },
            Question44: {
                Type: "B",
                Question: "يصفني الناس بأني حريص أو حذر أو منضبط",
                Answer: null,
                Class: "custom-select"
            },
            Question45: {
                Type: "D",
                Question: "يصفني الناس بأني مغامر، مبدع، خيالي",
                Answer: null,
                Class: "custom-select"
            },
            Question46: {
                Type: "A",
                Question: "يصفني الناس بأني حازم أو محلل أو عقلاني",
                Answer: null,
                Class: "custom-select"
            },
            Question47: {
                Type: "B",
                Question: "أحب معرفة التفاصيل وخطوات أي عمل سأقوم به",
                Answer: null,
                Class: "custom-select"
            },
            Question48: {
                Type: "D",
                Question: "لا أحب الأنظمة والقوانين وأشعر بأنها تقيدني",
                Answer: null,
                Class: "custom-select"
            },
            Question49: {
                Type: "C",
                Question: "أحب الشعر أو القصص أو التواصل مع الآخرين",
                Answer: null,
                Class: "custom-select"
            },
            Question50: {
                Type: "A",
                Question: "أشعر بأنه يجب أن تنفذ القوانين والعقوبات بحزم دون عاطفة أو مجاملات",
                Answer: null,
                Class: "custom-select"
            },
            Question51: {
                Type: "A",
                Question: "لا أحب الأشياء المحتملة أو التي لا يمكن توقع نتائجها (غير مضمونه ولا تستند لأدلة)",
                Answer: null,
                Class: "custom-select"
            },
            Question52: {
                Type: "C",
                Question: "أحب مساعدة الآخرين وإعطائهم من وقتي ومالي وجهدي",
                Answer: null,
                Class: "custom-select"
            },
            Question53: {
                Type: "",
                Question: "أحب التخطيط المفصل لأي عمل سأقوم به",
                Answer: null,
                Class: "custom-select"
            },
            Question54: {
                Type: "",
                Question: "عند شرائي لجهاز جديد أحاول تشغيله بنفسي دون اللجوء إلي كتيب التشغيل",
                Answer: null,
                Class: "custom-select"
            },
            Question55: {
                Type: "B,C",
                Question: "أحب الاستماع لمشاكل الآخرين ومساعدتهم",
                Answer: null,
                Class: "custom-select"
            },
            Question56: {
                Type: "A,D",
                Question: "لدي القدرة في التعامل مع الأرقام أو الحسابات",
                Answer: null,
                Class: "custom-select"
            },
            Question57: {
                Type: "A",
                Question: "أحب الشكل المثلث في الأشكال الهندسية",
                Answer: null,
                Class: "custom-select"
            },
            Question58: {
                Type: "C",
                Question: "أحب الدائرة و الأشكال التي فيها منحنيات أكثر من الاشكال الحادة",
                Answer: null,
                Class: "custom-select"
            },
            Question59: {
                Type: "B",
                Question: "أنا افضل الشكل المستطيل وأحب الأشكال التي في هيئتها كالمربع مثلا",
                Answer: null,
                Class: "custom-select"
            },
            Question60: {
                Type: "D",
                Question: "تجدني عند فراغي وبيدي القلم أرسم نجمة أو اشكال فيها تشعبات نجمية",
                Answer: null,
                Class: "custom-select"
            },
            Question61: {
                Type: "D",
                Question: "نبرة صوتي فيها ارتفاع واحب بناء العلاقات",
                Answer: null,
                Class: "custom-select"
            },
            Question62: {
                Type: "B",
                Question: "نبرة صوتي فيها ارتفاع و أحب انجاز المهام",
                Answer: null,
                Class: "custom-select"
            },
            Question63: {
                Type: "C",
                Question: "نبرة صوتي منخفضة وأحب بناء العلاقات",
                Answer: null,
                Class: "custom-select"
            },
            Question64: {
                Type: "A",
                Question: "نبرة صوتي منخفضة وأحب انجاز المهام",
                Answer: null,
                Class: "custom-select"
            },
            Question65: {
                Type: "B",
                Question: "عندما اتحدث إلى زميلي في العمل أنظر إلى عينيه طوال الوقت",
                Answer: null,
                Class: "custom-select"
            },
            Question66: {
                Type: "C",
                Question: "عندما اتحدث إلى زميلي في العمل انقل النظر بتكرار بين عينية و النظر إلى الأسفل",
                Answer: null,
                Class: "custom-select"
            },
            Question67: {
                Type: "A",
                Question: "عندما اتحدث إلى زميلي في العمل اتلفت حولي",
                Answer: null,
                Class: "custom-select"
            },
            Question68: {
                Type: "D",
                Question: "عندما اتحدث إلى زميلي في العمل احاول النظر إلى عينيه ولكني اصرف بصري بعيدا من وقت لآخر",
                Answer: null,
                Class: "custom-select"
            },
            Question69: {
                Type: "A",
                Question: "إذا كان علي اتخاذ قرار هام افكر فيه بشكل متكامل قبل اتخاذ القرار",
                Answer: null,
                Class: "custom-select"
            },
            Question70: {
                Type: "B",
                Question: "إذا كان علي اتخاذ قرار هام اتحمل مسؤولية قراري بشجاعة",
                Answer: null,
                Class: "custom-select"
            },
            Question71: {
                Type: "C",
                Question: "إذا كان علي اتخاذ قرار هام اضع اعتبار لمدى تأثيره على الأخرين قبل اتخاذه",
                Answer: null,
                Class: "custom-select"
            },
            Question72: {
                Type: "D",
                Question: "إذا كان علي اتخاذ قرار هام اتشاور مع شخص احترم وجهة نظرة",
                Answer: null,
                Class: "custom-select"
            },
            Question73: {
                Type: "B",
                Question: "عندما اتحدث على الهاتف اركز في حديثي على الهدف من الاتصال",
                Answer: null,
                Class: "custom-select"
            },
            Question74: {
                Type: "D",
                Question: "عندما اتحدث على الهاتف اتحدث في الدقائق الأولى من المحادثة عن امور عامة قبل التحول إلى العمل",
                Answer: null,
                Class: "custom-select"
            },
            Question75: {
                Type: "C",
                Question: "عندما اتحدث على الهاتف لن أكون في عجل ولا مانع من التحدث عن أشياء خاصة وعامة",
                Answer: null,
                Class: "custom-select"
            },
            Question76: {
                Type: "A",
                Question: "عندما اتحدث على الهاتف اختصر المكالمة ما أمكن",
                Answer: null,
                Class: "custom-select"
            }
        },
        activeSection: 1,
        chunkSize: 13
    },
    computed: {
        sectionCount() {
            return Math.ceil(Object.keys(this.questions).length / this.chunkSize);
        },
        points() {
            let size = 30;

            let Ax = - (Math.cos(Math.PI / 4) * this.result.A * size / 19).toFixed(2);
            let Ay = - (Math.sin(Math.PI / 4) * this.result.A * size / 19).toFixed(2);

            let Bx = - (Math.cos(Math.PI / 4) * this.result.B * size / 19).toFixed(2);
            let By = + (Math.sin(Math.PI / 4) * this.result.B * size / 19).toFixed(2);

            let Cx = + (Math.cos(Math.PI / 4) * this.result.C * size / 19).toFixed(2);
            let Cy = + (Math.sin(Math.PI / 4) * this.result.C * size / 19).toFixed(2);

            let Dx = + (Math.cos(Math.PI / 4) * this.result.D * size / 19).toFixed(2);
            let Dy = - (Math.sin(Math.PI / 4) * this.result.D * size / 19).toFixed(2);
            return Cx + ',' + Cy //Point C
                + ' ' + Dx + ',' + Dy //Point D
                + ' ' + Ax + ',' + Ay //Point A
                + ' ' + Bx + ',' + By; //Point B
        }
    },
    methods: {
         range: function (start, end) {
             return Array(end - start + 1).fill().map((_, idx) => start + idx)
        },
        indexExist(i) {
            return Object.keys(this.questions).length >= i;
        },
        getClass(index) {
            this.questions[index].Class = this.questions[index].Answer != null ? 'custom-select is-valid' : 'custom-select is-invalid';
            let keys = Object.keys(this.questions);
            let prevIndex = keys.indexOf(index) - 1;
            if (prevIndex >= 0)
            {
                for (let i = 0; i <= prevIndex; i++) {
                    if (this.questions[keys[i]].Answer == null)
                    {
                        this.questions[keys[i]].Class = 'custom-select is-invalid';
                    }
                }
            }
        },
        nextStep(n) {
            if (!this.checkNoNull(n))
            {
                alert("من فضلك أجب على كل الأسئلة");
                return;
            }
            if (n === this.sectionCount) {
                //this.activeSection = 1
            } else {
                this.activeSection = n + 1;
            }
        },
        submit() {
            if (!this.checkNoNull(0)) {
                alert("من فضلك أجب على كل الأسئلة");
                return;
            }
            var A = 0,B = A, C = A, D = A;
            Object.keys(this.questions).forEach(i => {
                //A
                if (this.questions[i].Type.includes('A'))
                {
                    A += this.questions[i].Answer;
                }
                //B
                if (this.questions[i].Type.includes('B'))
                {
                    B += this.questions[i].Answer;
                }
                //C
                if (this.questions[i].Type.includes('C'))
                {
                    C += this.questions[i].Answer;
                }
                //D
                if (this.questions[i].Type.includes('D'))
                {
                    D += this.questions[i].Answer;
                }
            });
            this.result.A = A / 4;
            this.result.B = B / 4;
            this.result.C = C / 4;
            this.result.D = D / 4;
        },
        checkNoNull(section) {
            var limit, index;
            if (section == 0)
            {
                index = 1;
                limit = 76;
            } else
            {
                index = 1 + this.chunkSize * (section - 1);
                limit = this.chunkSize * section;
            }
            this.getClass('Question' + limit);
            for (; index <= limit; index++) {
                if (this.questions['Question' + index].Answer == null)
                {
                    return false;
                }
            }
            return true;
        }
    },
});
