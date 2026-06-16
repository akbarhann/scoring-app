<template>
  <div class="my-4">
    <p class="text-center text-20 height-28 font-weight-bold mb-0">
      {{ title }}
    </p>
    <h3 class="text-center mb-8">{{ category }}</h3>

    <div class="d-flex justify-space-between">
      <!-- Blue Corner -->
      <div class="corner">
        <div class="blue-corner pa-7">
          <p class="text-center text-score font-weight-semi">{{ blueScore }}</p>
          <div class="d-flex penalties justify-space-between">
            <div class="w-50 border-right">
              <h4 class="text-center">{{ blueAdvantages }}</h4>
              <p class="mb-0 text-center text-16 height-22 font-weight-medium">
                Advantages
              </p>
            </div>
            <div class="w-50 border-left">
              <h4 class="text-center">{{ blueFoul }}</h4>
              <p class="mb-0 text-center text-16 height-22 font-weight-medium">
                Foul
              </p>
            </div>
          </div>
        </div>
        <div class="blue-corner d-flex justify-space-between px-5 py-3 mt-5">
          <!-- <v-avatar size="70" class="align-self-center">
            <img src="https://cdn.vuetifyjs.com/images/john.jpg" alt="John" />
          </v-avatar> -->
          <div class="align-self-center">
            <p class="mb-1 font-weight-semi text-20 height-30">
              {{ blueName }}
            </p>
            <hr class="border-red" />
            <p class="mt-1 mb-0 font-weight-semi text-20 height-30">
              {{ blueOrigin }}
            </p>
          </div>
        </div>
      </div>

      <!-- Red Corner -->
      <div class="corner">
        <div class="red-corner pa-7">
          <p class="text-center text-score font-weight-semi">
            {{ redScore }}
          </p>
          <div class="d-flex penalties justify-space-between">
            <div class="w-50 border-right">
              <h4 class="text-center">{{ redAdvantages }}</h4>
              <p class="mb-0 text-center text-16 height-22 font-weight-medium">
                Advantages
              </p>
            </div>
            <div class="w-50 border-left">
              <h4 class="text-center">{{ redFoul }}</h4>
              <p class="mb-0 text-center text-16 height-22 font-weight-medium">
                Foul
              </p>
            </div>
          </div>
        </div>
        <div class="red-corner d-flex justify-space-between px-5 py-3 mt-5">
          <div class="align-self-center">
            <p class="mb-1 font-weight-semi text-20 height-30">
              {{ redName }}
            </p>
            <hr class="border-blue" />
            <p class="mt-1 mb-0 font-weight-semi text-20 height-30">
              {{ redOrigin }}
            </p>
          </div>
          <!-- <v-avatar size="70" class="align-self-center">
            <img src="https://cdn.vuetifyjs.com/images/john.jpg" alt="John" />
          </v-avatar> -->
        </div>
      </div>
    </div>
    <div class="d-flex justify-space-between mt-10">
      <div class="main-timer">
        <div class="main-timer-inner py-4">
          <p class="mb-0 text-center text-score font-weight-semi">
            {{ time | timeFormat }}
          </p>
        </div>
      </div>
      <div class="sponsor">
        <v-carousel :show-arrows="false" hide-delimiters cycle height="140px">
          <v-carousel-item v-for="(item, i) in sponsors" :key="i">
            <v-img
              :src="require('~/assets/images/logos/' + item)"
              max-height="130px"
              contain
              class="my-1"
            ></v-img
          ></v-carousel-item>
        </v-carousel>
      </div>
    </div>

    <winner-dialog-vue v-if="winner"></winner-dialog-vue>
    <dis-dialog v-if="disqualification"></dis-dialog>
  </div>
</template>

<script>
import WinnerDialogVue from '~/components/WinnerDialog.vue'
import DisDialog from '~/components/DisDialog.vue'
export default {
  name: 'ScorePBJINewaza',
  components: { WinnerDialogVue, DisDialog },
  middleware: 'login',
  data() {
    return {
      title: 'Tournament Name',
      category: 'Category',

      // Red Corner
      redName: 'Player Red',
      redOrigin: 'Red Club',

      // Blue Corner
      blueName: 'Player Blue',
      blueOrigin: 'Blue Club',

      timeStart: false,
      timePause: false,
      time: 0,

      sponsors: [
        // 'logo_jatim.png',
        'logo_koni.png',
        'logo_pbji.png',
        // 'logo_kajati.png',
        // 'logo_porprov_2023.png',
        // 'logo_iji_vector.png',
        // 'logo_rs_hadi.jpg',
        // 'logo_jju_unesa.png',
      ],

      // Reactive Data
      redScore: 0,
      redAdvantages: 0,
      redFoul: 0,

      blueScore: 0,
      blueAdvantages: 0,
      blueFoul: 0,

      count: 0,
      count2: 0,

      winner: false,
      disqualification: false,
    }
  },
  watch: {
    time() {
      if (this.timeStart && !this.timePause) {
        if (this.time > 0) {
          setTimeout(() => {
            this.time--
          }, 1000)

          if (this.time === 1) {
            setTimeout(() => {
              this.$refs.timesUpAudio.play()
            }, 1000)
          }
        }
      }
    },
  },
  mounted() {
    setInterval(() => {
      this.getRed()
      this.getBlue()
      this.getTime()
      this.getWinner()
      this.getDisqualified()
      this.getPlayer()
    }, 1000)
  },
  methods: {
    getRed() {
      let local = localStorage.getItem('newazaRed')
      if (local != null) {
        local = JSON.parse(local)
        this.redScore = local.score
        this.redAdvantages = local.advantage
        this.redFoul = local.foul
      } else {
        this.redScore = 0
        this.redAdvantages = 0
        this.redFoul = 0
      }
    },
    getBlue() {
      let local = localStorage.getItem('newazaBlue')
      if (local != null) {
        local = JSON.parse(local)
        this.blueScore = local.score
        this.blueAdvantages = local.advantage
        this.blueFoul = local.foul
      } else {
        this.blueScore = 0
        this.blueAdvantages = 0
        this.blueFoul = 0
      }
    },
    getTime() {
      let local = localStorage.getItem('mainTime')

      if (local != null) {
        local = JSON.parse(local)

        this.time = local.time
      } else {
        this.time = 0
      }
    },
    getWinner() {
      let win = localStorage.getItem('dataWinner')
      if (win != null) {
        win = JSON.parse(win)
        this.winner = win.show
      } else {
        this.winner = false
      }
    },
    getDisqualified() {
      let dis = localStorage.getItem('dataDisqualified')
      if (dis != null) {
        dis = JSON.parse(dis)
        this.disqualification = dis.show
      } else {
        this.disqualification = false
      }
    },
    getPlayer() {
      let local = localStorage.getItem('newazaPlayer')
      if (local != null) {
        local = JSON.parse(local)
        this.redName = local.redName
        this.redOrigin = local.redClub
        this.blueName = local.blueName
        this.blueOrigin = local.blueClub
        this.title = local.tournament
        this.category = local.category
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
.red-corner {
  min-width: 100%;
  background-color: #ff001e;
  border-radius: 24px;
}
.blue-corner {
  min-width: 100%;
  background-color: #0048ff;
  border-radius: 24px;
}
.text-score {
  font-size: 100px;
  line-height: 100px;
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
  border-bottom: 3px solid #0048ff;
}
.border-red {
  border-bottom: 3px solid #ff001e;
}
.divider {
  z-index: 10 !important;
}
.main-timer {
  width: 545px;
  border-radius: 20px;
  background: linear-gradient(115.41deg, #ff001e, #0048ff);
  padding: 4px;
}
.main-timer-inner {
  background-color: #31323b;
  border-radius: 20px;
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
</style>

<style>
html {
  overflow: hidden;
}
</style>
