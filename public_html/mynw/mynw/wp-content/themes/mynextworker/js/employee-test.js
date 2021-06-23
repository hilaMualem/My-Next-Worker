
Vue.component('test-component', {
    props: ['content', 'answer1', 'answer2', 'answer3', 'answer4',
        'tempquestion', 'totalquestions', 'delay2', 'numzindex'],

    data: function () {
        return {
            num: this.numzindex,
            isVisible: 'block',

            currentTime: 100,
            timer: null,
        };
    },

    template: `<div class="test" dir="ltr" v-bind:style="{ zIndex: num, display: isVisible }">
        <div class="test__body">

            <div class="test__time-strip time-strip" style="width: 100%;">
                <div class="time-strip__internal" v-bind:style="{ width: currentTime + '%'}" ></div>
                <span class="time-strip__label">זמן שנותר לשאלה</span>		
            </div>

            <div class="test__amount-qestion amount-qestion">	
                <span class="amount-qestion__curent-question">{{tempquestion}} / </span>
                <span class="amount-qestion__total-questions"> {{totalquestions}} שאלה</span>	
            </div>

            <div class="test__question question">

                <div class="question__label">
                    <span>שאלה</span> 
                    <span>{{tempquestion}}></span> 
                </div>

                <p class="question__content">{{content}}?</p>

                <div class="question__answer-options">
                    <div class="question__answer" @click="sendAnswer" >{{answer1}}</div>
                    <div class="question__answer" @click="sendAnswer" >{{answer2}}</div>
                    <div class="question__answer" @click="sendAnswer" >{{answer3}}</div>
                    <div class="question__answer" @click="sendAnswer" >{{answer4}}</div>
                </div>

            </div>					

        </div>					
    </div>`,

    mounted: function () {
        window.setTimeout(() => { this.num = '0'; this.isVisible = 'none'; }, this.delay2);
        this.startTimer();
    },

    destroyed() {
        this.stopTimer()
    },

    methods: {
        sendAnswer(e) {
            this.num = 0;
            this.isVisible = 'none';
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


var test = new Vue({
    el: "#emptest",
    data: {
        testStartIsVisible: 'block',
        zIndexForTestStart: 1100,
        resultArr: [],
    },

    methods: {
        startTest() {
            this.testStartIsVisible = 'none';
            this.zIndexForTestStart = '0';
        },
        addAnswer(e) {
            if (e.target.className == 'question__answer') {
                this.resultArr.push(e.target.textContent);
                console.log(this.resultArr)
            };
        },
        finishTest() {
            console.log(this.resultArr);
        },
    },

});