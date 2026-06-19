<template>
  <div class="my-4">
    <div class="pos-relative">
      <p class="text-center text-20 height-28 font-weight-bold mb-0">
        {{ title }}
      </p>
      <v-btn
        icon
        dark
        class="fullscreen-toggle"
        @click="toggleFullscreen"
      >
        <v-icon>{{ isFullscreen ? 'mdi-fullscreen-exit' : 'mdi-fullscreen' }}</v-icon>
      </v-btn>
    </div>
    <h3 class="text-center mb-8">{{ category }}</h3>

    <div class="d-flex justify-space-between">
      <!-- Blue Corner -->
      <div class="corner">
        <div class="blue-corner pa-7">
          <div class="d-flex justify-space-around">
            <div class="w-100 mr-4 d-flex justify-space-around penalties">
              <div class="mb-0 align-self-center w-100 border-right">
                <v-icon v-if="blueIppong1" class="success--text text-center mx-2">mdi-circle</v-icon>
                <p class="text-center mb-0 text-score font-weight-semi">
                  {{ blueIppong1 }}
                </p>
              </div>
              <div
                class="mb-0 align-self-center w-100 border-left border-right"
              >
                <v-icon v-if="blueIppong2" class="success--text text-center mx-2">mdi-circle</v-icon>
                <p class="text-center mb-0 text-score font-weight-semi">
                  {{ blueIppong2 }}
                </p>
              </div>
              <div class="mb-0 align-self-center w-100 border-left">
                <v-icon v-if="blueIppong3" class="success--text text-center mx-2">mdi-circle</v-icon>
                <p class="text-center mb-0 text-score font-weight-semi">
                  {{ blueIppong3 }}
                </p>
              </div>
            </div>
            <div class="point">
              <p class="text-center mb-0 text-score-main font-weight-semi">
                {{ bluePoints }}
              </p>
              <!-- <p class="mb-0 text-center text-16 height-22 font-weight-medium">
                Total
              </p> -->
            </div>
          </div>
          <div class="d-flex penalties justify-space-around mt-4">
            <div class="w-100 border-right">
              <h4 class="text-center">{{ blueWashari }}</h4>
              <p class="mb-0 text-center text-16 height-22 font-weight-medium">
                Washari
              </p>
            </div>
            <div class="w-100 border-right border-left">
              <h4 class="text-center">{{ blueShido }}</h4>
              <p class="mb-0 text-center text-16 height-22 font-weight-medium">
                Shido
              </p>
            </div>
            <div class="w-100 border-left">
              <div class="d-flex w-100 justify-space-around my-2">
                <v-radio-group
                  v-model="blueChui"
                  hide-details
                  multiple
                  row
                  readonly
                  class="mt-0 pb-1"
                >
                  <v-radio color="primarydark" class="mr-0" value="1"></v-radio>
                  <v-radio color="primarydark" class="mr-0" value="2"></v-radio>
                </v-radio-group>
              </div>
              <p class="mb-0 text-center text-16 height-22 font-weight-medium">
                Chui
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Red Corner -->
      <div class="corner">
        <!-- Point -->
        <div class="red-corner pa-7">
          <div class="d-flex justify-space-around">
            <div class="w-100 mr-4 d-flex justify-space-around penalties">
              <div class="mb-0 align-self-center w-100 border-right">
                <v-icon v-if="redIppong1" class="success--text text-center mx-2">mdi-circle</v-icon>
                <p class="text-center mb-0 text-score font-weight-semi">
                  {{ redIppong1 }}
                </p>
              </div>
              <div
                class="mb-0 align-self-center w-100 border-left border-right"
              >
                <v-icon v-if="redIppong2" class="success--text text-center mx-2">mdi-circle</v-icon>
                <p class="text-center mb-0 text-score font-weight-semi">
                  {{ redIppong2 }}
                </p>
              </div>
              <div class="mb-0 align-self-center w-100 border-left">
                <v-icon v-if="redIppong3" class="success--text text-center mx-2">mdi-circle</v-icon>
                <p class="text-center mb-0 text-score font-weight-semi">
                  {{ redIppong3 }}
                </p>
              </div>
            </div>
            <div class="point">
              <p class="text-center mb-0 text-score-main font-weight-semi">
                {{ redPoints }}
              </p>
              <!-- <p class="mb-0 text-center text-16 height-22 font-weight-medium">
                Total
              </p> -->
            </div>
          </div>
          <div class="d-flex penalties justify-space-around mt-4">
            <div class="w-100 border-right">
              <h4 class="text-center">{{ redWashari }}</h4>
              <p class="mb-0 text-center text-16 height-22 font-weight-medium">
                Washari
              </p>
            </div>
            <div class="w-100 border-right border-left">
              <h4 class="text-center">{{ redShido }}</h4>
              <p class="mb-0 text-center text-16 height-22 font-weight-medium">
                Shido
              </p>
            </div>
            <div class="w-100 border-left">
              <div class="d-flex w-100 justify-space-around my-2">
                <v-radio-group
                  v-model="redChui"
                  hide-details
                  multiple
                  row
                  readonly
                  class="mt-0 pb-1"
                >
                  <v-radio color="primarydark" class="mr-0" value="1"></v-radio>
                  <v-radio color="primarydark" class="mr-0" value="2"></v-radio>
                </v-radio-group>
              </div>
              <p class="mb-0 text-center text-16 height-22 font-weight-medium">
                Chui
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Name and medic -->
    <div class="d-flex justify-space-between">
      <!-- Blue -->
      <div class="time-corner">
        <div class="blue-corner px-5 py-3 mt-5">
          <div class="d-flex justify-space-between">
            <div class="w-100">
              <p class="mb-0 text-timer-medic font-weight-semi">
                {{ blueTime | timeFormat }}
              </p>
              <p class="mb-0 ml-1">Medis</p>
            </div>
            <div class="w-100">
              <p class="mb-1 font-weight-semi text-20 height-30 text-right">
                {{ blueName | wrapText(15) }}
              </p>
              <hr class="border-red float-right" />
              <p
                class="mt-3 mb-0 font-weight-semi text-20 height-30 text-right"
              >
                {{ blueOrigin | wrapText(15) }}
              </p>
            </div>
          </div>
        </div>
      </div>
      <!-- Osaikomi -->
      <div class="time-corner-mid">
        <div class="redblue-corner mt-5">
          <div class="redblue-corner-inner px-5 py-2">
            <div class="d-flex justify-space-between">
              <div class="w-100">
                <p class="mb-0 text-timer-medic font-weight-semi text-center">
                  {{ osaikomiTime | timeFormat }}
                </p>
                <p class="mb-0 ml-1 text-center">Osaikomi</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Red -->
      <div class="time-corner">
        <div class="red-corner px-5 py-3 mt-5">
          <div class="d-flex justify-space-between">
            <div class="w-100">
              <p class="mb-1 font-weight-semi text-20 height-30">
                {{ redName | wrapText(15) }}
              </p>
              <hr class="border-blue" />
              <p class="mt-1 mb-0 font-weight-semi text-20 height-30">
                {{ redOrigin | wrapText(15) }}
              </p>
            </div>
            <div class="w-100 text-right">
              <p class="mb-0 text-timer-medic font-weight-semi">
                {{ redTime | timeFormat }}
              </p>
              <p class="mb-0 mr-1">Medis</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Timer & Sponsor -->
    <div class="d-flex justify-space-between mt-10">
      <div class="main-timer">
        <div class="main-timer-inner py-4">
          <p class="mb-0 text-center text-timer font-weight-semi">
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
import WinnerDialogVue from '~/components/pbji/FightingWinner.vue'
import DisDialog from '~/components/pbji/FightingDisqualification.vue'
export default {
  name: 'ScorePBJIFighting',
  components: { WinnerDialogVue, DisDialog },
  filters: {},
  middleware: 'login',
  data() {
    return {
      isFullscreen: false,
      title: 'Tournament',
      category: 'Category',

      // Red Corner
      redName: 'Player Red',
      redOrigin: 'Red Club',

      // Blue Corner
      blueName: 'Player Blue',
      blueOrigin: 'Blue Club',

      time: 0,
      redTime: 120,
      blueTime: 120,
      osaikomiTime: 0,

      redPoints: 0,
      redIppong1: 0,
      redIppong2: 0,
      redIppong3: 0,
      redWashari: 0,
      redShido: 0,
      redChui: [],

      bluePoints: 0,
      blueIppong1: 0,
      blueIppong2: 0,
      blueIppong3: 0,
      blueWashari: 0,
      blueShido: 0,
      blueChui: [],

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

      winner: false,
      disqualification: false,
    }
  },

  mounted() {
    setInterval(() => {
      this.getRed()
      this.getBlue()
      this.getOsaikomiTime()
      this.getWinner()
      this.getDisqualified()
      this.getPlayer()
    }, 1000);

    setInterval(() => {
      this.getTime()
      this.getRedTime()
      this.getBlueTime()
      this.getOsaikomiTime()
    }, 100)

    document.addEventListener('fullscreenchange', this.onFullscreenChange);
  },
  beforeDestroy() {
    document.removeEventListener('fullscreenchange', this.onFullscreenChange);
  },
  methods: {
    onFullscreenChange() {
      this.isFullscreen = !!document.fullscreenElement;
    },
    toggleFullscreen() {
      if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen().catch(err => {
          // eslint-disable-next-line no-console
          console.error(`Error attempting to enable full-screen mode: ${err.message}`);
        });
      } else {
        document.exitFullscreen();
      }
    },
    getRed() {
      let local = localStorage.getItem('fightingRed')
      if (local != null) {
        local = JSON.parse(local)
        this.redPoints = local.score
        this.redIppong1 = local.ippong1
        this.redIppong2 = local.ippong2
        this.redIppong3 = local.ippong3
        this.redWashari = local.washari
        this.redShido = local.shido
        this.redChui = []
        for (let r = 1; r <= local.chui; r++) {
          this.redChui.push(r.toString())
        }
      }
    },
    getBlue() {
      let local = localStorage.getItem('fightingBlue')
      if (local != null) {
        local = JSON.parse(local)
        this.bluePoints = local.score
        this.blueIppong1 = local.ippong1
        this.blueIppong2 = local.ippong2
        this.blueIppong3 = local.ippong3
        this.blueWashari = local.washari
        this.blueShido = local.shido
        this.blueChui = []
        for (let b = 1; b <= local.chui; b++) {
          this.blueChui.push(b.toString())
        }
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
    getRedTime() {
      let local = localStorage.getItem('fightingRedTime')

      if (local != null) {
        local = JSON.parse(local)
        this.redTime = local.time
      } else {
        this.redTime = 120
      }
    },
    getBlueTime() {
      let local = localStorage.getItem('fightingBlueTime')

      if (local != null) {
        local = JSON.parse(local)
        this.blueTime = local.time
      } else {
        this.blueTime = 120
      }
    },
    getOsaikomiTime() {
      let local = localStorage.getItem('fightingOsaikomiTime')
      local = local ? JSON.parse(local) : {}
      this.osaikomiTime = local?.time || 0;
    },
    getWinner() {
      let win = localStorage.getItem('dataFightingWinner')
      if (!win) {
        this.winner = false;
        return;
      }
      win = JSON.parse(win)
      this.winner = win.show
    },
    getDisqualified() {
      let dis = localStorage.getItem('dataFightingDisqualified')
      if (dis != null) {
        dis = JSON.parse(dis)
        this.disqualification = dis.show
      } else {
        this.disqualification = false
      }
    },
    getPlayer() {
      let local = localStorage.getItem('fightingPlayer')
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
  width: 555px;
}
.time-corner {
  width: 440px;
}
.time-corner-mid {
  width: 225px;
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
.redblue-corner {
  min-width: 100%;
  border-radius: 24px;
  background: linear-gradient(115.41deg, #ff001e, #0048ff);
  padding: 4px;
}
.redblue-corner-inner {
  background-color: #31323b;
  border-radius: 24px;
  height: 100%;
}
.text-score {
  font-size: 60px;
  line-height: 60px;
}
.text-score-main {
  font-size: 80px;
  line-height: 80px;
}
.text-timer {
  font-size: 100px;
  line-height: 100px;
}
.text-timer-medic {
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
.point {
  width: 30%;
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

.fullscreen-toggle {
  position: absolute !important;
  top: 10px;
  right: 16px;
  z-index: 100 !important;
}
</style>

<style>
html {
  overflow: hidden;
}
</style>
