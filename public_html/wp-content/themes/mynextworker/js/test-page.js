if(document.getElementById('testpage')){
  
  Vue.component('modal-send-test', {
    props: ['show', 'exam-id'],

    data: function () {
        return {
            sendEmail: [{mail: "", finished: false, loader: false, disabled: false}],
            copyLinkImg: window.location.origin + '/wp-content/themes/mynextworker/assets/img/add-icon.png',
            linkToExam: window.examLink,
            // copyResult: 
        };
    },

    template: `
          <div v-if="show">
            <div class="shadow-popup" style="width: 100%; height: 100%; background-color: #fff; opacity: 0.8; position: fixed; top: 0; right: 0; z-index: 10;">
            
          </div>
          <div id="send-test-pop-up" class="send-test-pop-up">
            <div class="send-test-pop-up__close-icon" id="send-test-pop-up__close-icon" v-on:click="$emit('close-modal', true)"> X </div>
            
            <img :src="window.location.origin + '/wp-content/themes/mynextworker/assets/img/msg-icon.png'" alt="icon" class="send-test-pop-up__icon">
            <h3 class="send-test-pop-up__title">שליחת מבחן למועמד</h3>
            <p class="send-test-pop-up__info">באפשרותכם לשלוח לכמה מועמדים במקבלים</p>
            <p class="send-test-pop-up__info">רק נשאר למלא את מייל המועמד וללחוץ שליחה</p>


            <form action="" class="send-test-pop-up__form">
                <div class="row-wrapper" v-for="(mail, index) in sendEmail">
                    <input type="text" v-model:value="mail.mail" class="send-test-pop-up__input" placeholder="מייל מועמד">
                    <div v-if="mail.loader"><div class='myworker-loader-small'></div></div>
                    <button v-bind:disabled="mail.finished" v-if="!mail.loader" @click="sendExam(mail, index)" class="send-test-pop-up__btn" v-bind:class="{ 'send-test-pop-up__btn--sending': !mail.finished }" type="button">
                      {{ mail.finished ? 'נשלח' : 'שליחה' }}
                    </button>
                </div>
                
                <div class="send-test-pop__add-candidate add-candidate">
                    <span class="add-candidate__label">הוספת מועמד</span>
                    <img @click="addMail" :src="copyLinkImg" class="add-candidate__icon" alt="icon">
                </div>
                
                <div class="test-builder-finish-info__link-box test-link" dir="ltr">
                  <div class="test-link__label">או העתיקו את הקישור</div>
                  <div style="width: 100%; display: flex; align-items: center; justify-content: center;">
                    <div class="test-link__body">
                      {{linkToExam}}
                    </div> 
                    <div class="test-link__copy-link-btn" @click="copyLink">
                      <img src="https://mynetworker.tzlilhosting.com/wp-content/themes/mynextworker/assets/img/copy-icn.png" alt="i">
                    </div>
                  </div>
                </div>
                
                

                <button type="button" v-on:click="$emit('close-modal', true)" class="send-test-pop-up__submit-btn">סיום</button>
            </form>

         </div>
          </div>
          
            `,

    mounted: function () {
        // this.sourceArr.sort(() => Math.random() - 0.5);
    },

    methods: {
      copyLink() {
        this.copyTextToClipboard(this.linkToExam);
      },
      copyTextToClipboard(text) {
        if (!navigator.clipboard) {
          fallbackCopyTextToClipboard(text);
          return;
        }
        navigator.clipboard.writeText(text).then(function() {
          console.log('Async: Copying to clipboard was successful!');
          this.copyResult = true;
        }, function(err) {
          this.copyResult = false;        
          console.error('Async: Could not copy text: ', err);
        });
      },
      addMail() {
        this.sendEmail.push({mail: "", finished: false, loader: false});
      },
      sendExam(obj, i) {
        // console.log(obj);
        // console.log(i);
        // console.log(this.examId);
        obj.loader = true;
        obj.disabled = true;
        var self = this;
        var formData = new FormData();
            formData.append('email', obj.mail);
            formData.append('examId', this.examId);
            
        const requestOptions = {
                                  method: "POST",
                                  body: formData
                                };
        fetch(window.wp_data.ajax_url + '?action=mynw_send_test', requestOptions)
  	                .then(function (response) {
                                   console.log(response);
                                   obj.loader = false;
                                   obj.finished = true;
                                   return;
                       if(response.ok === true) {
                         window.location = '/dashboard';
                       }
                    });
      }
    }

  });
  
  var test = new Vue({
    el: "#testpage",
    components: {
          apexchart: VueApexCharts,
        },
    data: {
      showSendTestModal: window.showSendTestModal?window.showSendTestModal:false,
      loadingExams: false,
          series: window.series,
          chartPieOptions: {
            chart: {
              width: 380,
              type: 'pie',
            },
            // colors: window.colors,
            dataLabels: {
              enabled: true,
            },
            labels: window.labels,
            legend: {
              show: true,
              position: "bottom",
            },
            responsive: [{
              breakpoint: 480,
              options: {
                chart: {
                  width: 200
                },
              }
            }]
          },
    },
    methods: {
      openModal() {
        this.showSendTestModal = true;
      },
      closeModal(val) {
        console.log(val);
        this.showSendTestModal = false;
      }
    }
  });
  
}