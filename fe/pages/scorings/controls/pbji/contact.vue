<template>
  <div>
    <p class="text-center text-20 height-30 font-weight-semi mb-0">
      Control Score Contact System
    </p>
    <h4 class="text-center mb-10">{{ categoryName }}</h4>
    <div class="d-flex justify-center w-100 mt-10">
      <!-- Setting Time -->
      <div class="main-timer">
        <div class="main-timer-inner py-4">
          <p class="mb-3 w-100 text-center text-score font-weight-semi">
            {{ time | timeFormat }}
          </p>
          <div class="d-flex mb-0 justify-center mt-2">
            <v-icon class="mx-1 text-24 pointer" @click="startTime()"
              >mdi-play-circle-outline</v-icon
            >
            <v-icon class="mx-1 text-24 pointer" @click="pauseTime()"
              >mdi-pause-circle-outline</v-icon
            >
            <v-icon class="mx-1 text-24 pointer" @click="stopTime()"
              >mdi-stop-circle-outline</v-icon
            >
            <v-icon
              class="mx-2 text-28 pointer"
              @click="settingTime = !settingTime"
              >mdi-cog</v-icon
            >
          </div>
          <div class="d-flex justify-center">
            <v-expand-transition>
              <div v-show="settingTime" class="field-time pt-4">
                <v-text-field
                  v-model="inputTime"
                  solo
                  hide-details
                  placeholder="Main timer (seconds)"
                  append-icon="mdi-check"
                  @keyup.enter="
                    setTime(inputTime),
                      (time = inputTime),
                      (settingTime = false)
                  "
                  @click:append="
                    setTime(inputTime),
                      (time = inputTime),
                      (settingTime = false)
                  "
                ></v-text-field>
              </div>
            </v-expand-transition>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// import WinnerDialogVue from '~/components/WinnerDialog.vue'
export default {
  name: 'ControlsPBJIContactSystem',
  middleware: 'login',
  // components: { WinnerDialogVue },
  data() {
    return {
      categoryName: '',

      time: 0,
      timeStart: false,
      timePause: false,
      inputTime: '',
      settingTime: false,
      changeTime: false,

      snackbar: false,
      color: 'primaryred',
      message: '',
    }
  },
  computed: {},
  watch: {
    time() {
      if (this.timeStart && !this.timePause) {
        if (this.time > 0) {
          setTimeout(() => {
            this.time--
            this.setTime(this.time)
          }, 1000)
        } else {
          setTimeout(() => {
            if (this.time === 0) {
              this.playSound()
            }
          }, 50)
        }
      }
    },
  },
  mounted() {
  },
  methods: {
    setTime(t) {
      let local = localStorage.getItem('mainTime')
      if (local != null) {
        local = JSON.parse(local)
        local.time = t
      } else {
        local = {
          time: t,
        }
      }
      localStorage.setItem('mainTime', JSON.stringify(local))
    },
    startTime() {
      if (!this.timeStart) {
        this.timeStart = true
        this.timePause = false
        const t = this.time
        this.time = 0
        setTimeout(() => {
          this.time = t
        }, 1)
      }
    },
    pauseTime() {
      this.timeStart = false
      this.timePause = true
    },
    stopTime() {
      this.time = this.inputTime
      this.timeStart = false
      this.timePause = false
      this.setTime(this.time)
    },

    playSound() {
      let local = localStorage.getItem('dataAdditional')
      if (local != null) {
        local = JSON.parse(local)
        if (parseInt(local.audio) === 2) {
          this.$refs.timesUpAudio2.play()
        } else {
          this.$refs.timesUpAudio.play()
        }
      } else {
        this.$refs.timesUpAudio.play()
      }
    },
  },
}
</script>

<style scoped>
@import '~/assets/styles.css';

.corner {
  width: 545px;
}
.time-corner {
  width: 345px;
}
.red-corner {
  min-width: 100%;
  border: 3px solid #ef233c;
  border-radius: 24px;
}
.blue-corner {
  min-width: 100%;
  border: 3px solid #243c7a;
  border-radius: 24px;
}
.redblue-corner {
  min-width: 100%;
  border-radius: 24px;
  background: linear-gradient(115.41deg, #ef233c, #243c7a);
  padding: 4px;
}
.redblue-corner-inner {
  background-color: #31323b;
  border-radius: 24px;
  height: 100%;
}
.text-score {
  font-size: 80px;
  line-height: 80px;
}
.text-score-small {
  font-size: 50px;
  line-height: 50px;
}
.penalties {
  width: 100%;
  background: rgba(255, 255, 255, 0.35);
  border: 2px solid #ffffff;
  border-radius: 20px;
  padding: 16px;
}

hr {
  border-top: 0;
  border-left: 0;
  border-right: 0;
  border-radius: 100px;
  width: 130px;
}
.border-blue {
  border: 3px solid #12348d;
}
.border-red {
  border: 3px solid #ef233c;
}
.divider {
  z-index: 10 !important;
}
.main-timer {
  width: 545px;
  border-radius: 20px;
  background: linear-gradient(115.41deg, #ef233c, #243c7a);
  padding: 4px;
}
.main-timer-inner {
  background-color: #31323b;
  border-radius: 20px;
  height: 100%;
}
.text-timer-medic {
  font-size: 50px;
  line-height: 50px;
}

.sponsor {
  width: 570px;
  max-height: 140px;
  background: #ffffff;
  border-radius: 20px;
}

.border-left {
  border-left: 1px solid white;
}
.border-right {
  border-right: 1px solid white;
}

.field-time {
  max-width: 230px;
}

.card-dashboard {
  max-width: 100%;
}
</style>
