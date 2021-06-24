if (document.getElementById('emptest')) {

    Vue.component('test-component', {
        props: ['content', 'answer1', 'answer2', 'answer3', 'answer4',
            'tempquestion', 'totalquestions', 'numzindex', 'categories', 'tempcategory', 'percentage', 'token'],

        data: function () {
            return {
                num: this.numzindex,
                isVisible: 'block',

                currentTime: 100,
                timer: null,
                answersArr: [this.answer1, this.answer2, this.answer3, this.answer4],

                categoriesArr: this.categories.split(' '),
                percentageArr: this.percentage.split(' '),
                tokenStr: this.token,
            };
        },

        created() {
            this.$root.categories = this.categoriesArr;
            this.$root.percentage = this.percentageArr;
            this.$root.token = this.tokenStr;
        },

        template: `<div class="test" v-bind:style="{ zIndex: num, display: isVisible }">
        <div class="test__body">

            <div class="test__time-strip time-strip" style="width: 100%;">
                <div class="time-strip__internal" v-bind:style="{ width: currentTime + '%'}" ></div>
                <span class="time-strip__label">זמן שנותר לשאלה</span>      
            </div>

            <div class="test__amount-qestion amount-qestion">   
                <span class="amount-qestion__curent-question">{{tempquestion}} / </span>
                <span class="amount-qestion__total-questions"> {{totalquestions}} </span>   
            </div>

            <div class="test__question question">

                <div class="question__label">
                    <span>שאלה  </span> 
                    <span>{{tempquestion}}></span> 
                </div>

                <p class="question__content">{{content}}?</p>

                <div class="question__answer-options" @click="sendAnswer">
                    <answers-component
                        v-bind:answers="answersArr"
                        v-bind:corectanswer="answer1"
                        v-bind:tempcategory="tempcategory"
                        @click="sendAnswer"
                    ></answers-component>
                </div>

            </div>                  

        </div>                  
    </div>`,

        mounted: function () {
            this.startTimer();
            this.categoriesArr.pop();
            this.percentageArr.pop();
        },

        destroyed() {
            this.stopTimer()
        },

        methods: {
            sendAnswer(e) {
                if (e.target.className == 'question__answer') {
                    this.$emit('onzindexchanged', this.num);
                    this.num = 0;
                    this.isVisible = 'none';
                    if(e.target.closest(".test-item").nextElementSibling.className=="test-finish")
                            test.saveTest();
                }
            },
            startTimer() {
                this.timer = setInterval(() => {
                    this.currentTime--
                }, 10000)
            },
            stopTimer() {
                clearTimeout(this.timer)
            },
        },
        watch: {
            currentTime(time) {
                if (time === 0) {
                    this.stopTimer()
                }
            }
        },

    })

    Vue.component('answers-component', {
        props: ['answers', 'corectanswer', 'tempcategory'],

        data: function () {
            return {
                sourceArr: [0, 1, 2, 3],
            };
        },

        template: `
            <div>
                <div class="question__answer" :id="sourceArr[0]" :data-category="tempcategory">{{answers[sourceArr[0]]}}</div>
                <div class="question__answer" :id="sourceArr[1]" :data-category="tempcategory">{{answers[sourceArr[1]]}}</div>
                <div class="question__answer" :id="sourceArr[2]" :data-category="tempcategory">{{answers[sourceArr[2]]}}</div>
                <div class="question__answer" :id="sourceArr[3]" :data-category="tempcategory">{{answers[sourceArr[3]]}}</div>
            </div>
            `,

        mounted: function () {
            console.log(this.answers);
            this.sourceArr.sort(() => Math.random() - 0.5);
        },

        methods: {}

    })

    var test = new Vue({
        el: "#emptest",
        data: {
            working: false,
            showMenuPanel: false,
            testStartIsVisible: 'block',
            zIndexForTestStart: 1100,
            percentObj: window.percentObj,
            categories: [],
            percentage: [],
            questionTaxonomies: window.questionTaxonomies ? window.questionTaxonomies : [],
            token: '',
            show: true,
            userData: {
                name: '',
                age: '',
                city: '',
                address: '',
                phone: '',
                freeText: '',
                resume: '',
                experience: '',
                expectedSalary: '',
                language:'',
            },
            results: [],


            // test builder
            countSteps: 0,
            testBuilderName: '',

            testBuilderCity: '',
            testBuilderAdress: '',
            testBuilderSalary: '',
            testBuilderDateBegin: '',
            testBuilderExperienceRequired: '',
            testBuilderTypeJob: '',
            testBuilderJobRequirements: '',
            testBuilderJobDescription: '',
            showEmail: window.showEmail?window.showEmail : false,

            testBuilderQuestionFields: window.testBuilderQuestionFields ? window.testBuilderQuestionFields : {
                name: false,
                email: false,
                city: false,
                age: false,
                experience: false,
                address: false,
                expectedSalary: false,
                language:false,
                freeText: false,
                resumeUploading: false,
                phone:false,
                questions: []
            },
            testRunnerZIndex: 1080,
            candidateFullName: '',
            candidateHometown: '',
            candidateAge: null,
            candidateExperience: '',
            candidateAddress: '',
            candidateWageRequirements: '',
            candidateFreeText: '',
            candidateDownloadCV: '',

            qualitiesArr: [],
            buildPostId: window.postid,
            testLink: null,
            postID: null,
            enabled: false,
            enabled1: false
        },
        methods: {
            onZindexChanged(e) {
                console.log(e);
                this.testRunnerZIndex = e - 15;
            },
            addAmericanQuestion(e) {
                this.testBuilderQuestionFields.questions.push({
                    questionType: 'aq',
                    enabled: false,
                    question: '',
                    answer1: '',
                    answer2: '',
                    answer3: '',
                    answer4: '',
                    answer: ''
                });
                this.showMenuPanel = false;
            },
            addShortQuestion() {
                this.testBuilderQuestionFields.questions.push({
                    questionType: 'sq',
                    enabled: false,
                    question: '',
                    answer: ''
                });
                this.showMenuPanel = false;
            },
            addLongQuestion() {
                this.testBuilderQuestionFields.questions.push({
                    questionType: 'lq',
                    enabled: false,
                    question: '',
                    answer: ''
                });
                this.showMenuPanel = false;
            },
            startTest() {
                this.testStartIsVisible = 'none';
                this.zIndexForTestStart = '0';
                this.testRunnerZIndex = 995;
            },
            addAnswer(e) {
                // debugger;
                if (e.target.className == 'question__answer') {
                    if (e.target.id == 0) {
                        this.results.push({category: e.target.dataset.category, answer: 1});
                    } else {
                        this.results.push({category: e.target.dataset.category, answer: 0});
                    }
                }
                ;
            },
            onFileChange(e) {
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.userData.resume = files[0];
            },
            finishTest() {
                // console.log('this.results = ', this.results);
                // var formData = new FormData();
                // formData.append('test_result', JSON.stringify(this.results));
                // formData.append('percentageObject', JSON.stringify(this.percentObj));
                // formData.append('percentage', JSON.stringify(this.percentage));
                // formData.append('resume', this.userData.resume);
                // formData.append('postid', this.buildPostId);
                // delete this.userData.resume;
                // this.userData.customQuestions = this.testBuilderQuestionFields;
                // formData.append('userData', JSON.stringify(this.userData));
                // formData.append('token', this.token);

                // const requestOptions = {
                //     method: "POST",
                //     body: formData
                // };

                // fetch(window.wp_data.ajax_url + '?action=mynw_test_complete', requestOptions)
                //     .then(response => window.location.href = '/');
                window.location.href = '/';
            },
            saveTest() {
                console.log('this.results = ', this.results);
                var formData = new FormData();
                formData.append('test_result', JSON.stringify(this.results));
                formData.append('percentageObject', JSON.stringify(this.percentObj));
                formData.append('percentage', JSON.stringify(this.percentage));
                formData.append('resume', this.userData.resume);
                formData.append('postid', this.buildPostId);
                delete this.userData.resume;
                this.userData.customQuestions = this.testBuilderQuestionFields;
                formData.append('userData', JSON.stringify(this.userData));
                formData.append('token', this.token);

                const requestOptions = {
                    method: "POST",
                    body: formData
                };

                fetch(window.wp_data.ajax_url + '?action=mynw_test_complete', requestOptions);
                // .then(response => window.location.href = '/');
            },

            // test builder
            nextStep() {
                switch (this.countSteps) {
                    case 0:
                        this.testBuilderName.length > 3 ? this.countSteps += 1 : alert("test name should not be less than 3 characters")
                        break;
                    case 1:
                        /*if (this.testBuilderCity.length > 3 && this.testBuilderAdress.length > 3
                            && this.testBuilderSalary.length > 3 && this.testBuilderDateBegin.length > 3
                            && this.testBuilderExperienceRequired.length > 3 && this.testBuilderTypeJob.length > 3
                            && this.testBuilderJobRequirements.length > 3 && this.testBuilderJobDescription.length > 3) {
                            console.log(this.testBuilderCity + " " + this.testBuilderAdress
                                + " " + this.testBuilderSalary + " " + this.testBuilderDateBegin
                                + " " + this.testBuilderExperienceRequired + " " + this.testBuilderTypeJob
                                + " " + this.testBuilderJobRequirements + " " + this.testBuilderJobDescription)*/
                        this.countSteps += 1;
                        /* }
                         else {
                             alert("Fill in all the fields | All fields must have at least 3 characters! ")
                         }*/
                        break;
                    case 2:
                        this.countSteps += 1;
                        break;
                    case 3:
                        if (this.qualitiesArr.length < 3) {
                            alert("choose at least three qualities");
                        } else {

                            this.testBuilderFinish().then(function (response) {
                                if (response.status != 200) {
                                    //this.loadingExams = false;
                                } else {
                                    response.json().then(function (data) {
                                        this.testLink = data.data;
                                        this.postID = data.post_id;
                                        this.countSteps += 1;
                                    }.bind(this))
                                }
                            }.bind(this));
                        }
                        break;
                }
                console.log(this.countSteps)
            },
            prevStep() {
                this.countSteps -= 1;
            },

            addQualities(e) {
                let indexQalities = this.qualitiesArr.indexOf(e.target.innerText);
                (indexQalities === -1) ? this.qualitiesArr.push(e.target.innerText) : this.qualitiesArr.splice(indexQalities, 1);
                e.target.classList.toggle('select-qualities__item--selected');
            },

            copyLink() {
                //this.$refs.testLinkText.innerText.select();
                //document.execCommand("copy");
                navigator.clipboard.writeText(this.testLink);
            },
            redirectToDashboard() {
                window.location.href = '/dashboard';
            },
            redirectToTestPage() {
                window.location.href = '/test-page/?id=' + this.postID + "&modal=true";
            },
            testBuilderFinish() {
                if (!this.working) {
                    this.working = true;
                    var testData = {};
                    testData = {
                        testBuilderName: this.testBuilderName,
                        testBuilderCity: this.testBuilderCity,
                        testBuilderAdress: this.testBuilderAdress,
                        testBuilderSalary: this.testBuilderSalary,
                        testBuilderDateBegin: this.testBuilderDateBegin,
                        testBuilderExperienceRequired: this.testBuilderExperienceRequired,
                        testBuilderTypeJob: this.testBuilderTypeJob,
                        testBuilderJobRequirements: this.testBuilderJobRequirements,
                        testBuilderJobDescription: this.testBuilderJobDescription,
                    }

                    var formData = new FormData();
                    formData.append('testData', JSON.stringify(testData));
                    formData.append('testBuilderQuestionFields', JSON.stringify(this.testBuilderQuestionFields));
                    formData.append('questionsCategories', JSON.stringify(this.qualitiesArr));

                    console.log('testData = ', testData);
                    console.log('testBuilderQuestionFields = ', this.testBuilderQuestionFields);
                    console.log('questionsCategories = ', this.qualitiesArr);

                    const requestOptions = {
                        method: "POST",
                        body: formData
                    };

                    return fetch(window.wp_data.ajax_url + '?action=mynw_test_builder', requestOptions);
                }
            },
        }
    });
}