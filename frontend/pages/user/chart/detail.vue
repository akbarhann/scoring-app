<template>
  <div class="mt-8">
    <div class="card-dashboard mb-6 pa-6">
      <div class="">
        <p
          class="
            mb-0
            blackgrey--text
            font-weight-semi
            text-14
            height-28
            align-seld-center
            pointer
          "
          @click="$router.push('/user/chart')"
        >
          <v-icon class="text-16 blackgrey--text">mdi-arrow-left</v-icon> Back
        </p>
        <div class="d-flex justify-space-between">
          <p
            class="
              pl-6
              pt-6
              mb-0
              blackgrey--text
              font-weight-semi
              text-18
              height-28
              align-seld-center
            "
          >
            Tournament Bracket
          </p>
          <div class="d-flex align-self-end">
            <v-btn
              v-if="chart.length"
              small
              color="grey darken-1"
              class="text-right text-14 height-20 text-right rounded-8 align-self-end mr-2"
              @click="hideBye()"
            >
              Hide Bye
            </v-btn>
            <v-btn
              v-if="chart.length"
              small
              color="grey darken-1"
              class="text-right text-14 height-20 text-right rounded-8 align-self-end mr-2"
              @click="hideData()"
            >
              Hide Match {{ chartHidden.length + 1 }}
            </v-btn>
            <v-btn
              v-if="chartHidden.length"
              small
              color="grey darken-1"
              class="text-right text-14 height-20 text-right rounded-8 align-self-end mr-2"
              @click="showData()"
            >
              Show Match {{ chartHidden.length }}
            </v-btn>
            <v-btn
              v-if="chart.length"
              small
              color="grey darken-1"
              class="text-right text-14 height-20 text-right rounded-8 align-self-end mr-2"
              @click="printBracket()"
              >Print</v-btn
            >
            <v-btn
              v-if="chart.length"
              small
              color="grey darken-1"
              class="text-right text-14 height-20 text-right rounded-8 align-self-end"
              :loading="loadingSave"
              @click="submitBracket()"
              >Save Chart</v-btn
            >

          </div>
        </div>
      </div>
    </div>
    <!-- Chart -->
    <div v-if="chart.length > 0" id="bracketData" class="card-dashboard-bracket mb-6 pb-6 px-6">
      <h5 class="text-center pt-5 mb-0">{{ chartName }}</h5>
      <client-only>
        <bracket ref="bracket" :rounds="gameChart">
          <template slot="player" slot-scope="{ player }">
            <p class="bg-white mb-0 pa-0" :class="{ 'player-hidden': player.hidden, 'player-get-bye': player.isGetBye }">
              {{ player.name }}
              <v-icon
                v-if="tempPlayer && player.setting"
                color="black"
                size="20"
                class="icon-win"
                @click="setWinData(player)"
              >
                mdi-tray-arrow-down
              </v-icon>
              <v-icon
                v-else-if="player.setting"
                color="secondary"
                size="20"
                class="icon-win"
                @click="winData(player)"
              >
                mdi-content-copy
              </v-icon>
            </p>
          </template>
        </bracket>
      </client-only>
    </div>

    <v-snackbar v-model="notif" :color="notifColor">
      {{ notifMsg }}

      <template #action="{ attrs }">
        <v-btn icon v-bind="attrs" @click="notif = false">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </template>
    </v-snackbar>
  </div>
</template>

<script>
export default {
  name: 'CategoryImportPage',
  components: {
    [process.client && 'Bracket']: () => import('vue-tournament-bracket'),
  },
  filters: {
    formatName(value) {
      if (!value) return '';
      if (value?.length > 15) {
        return `${value.substring(0, 15)}...`;
      }
      return value;
    },
  },
  layout: 'bracket',
  data() {
    return {
      notif: false,
      notifColor: 'dark',
      notifMsg: '',

      chart: [],
      chartHidden: [],
      tempPlayer: null,
      chartId: null,
      chartName: null,

      loadingSave: false,
    }
  },
  computed: {
    gameChart() {
      return this.chart;
    },
  },
  mounted() {
    this.getChart()

    if (!this.$cookies.get('user_auth')) {
      this.$router.push(`/user/chart/detail-public/?id=${this.$route?.query?.id}`);
    }
  },

  methods: {
    async getChart() {
      const category = this.$route.query?.id
      if (!category) {
        this.notif = true
        this.notifColor = 'error'
        this.notifMsg = 'Chart not found'
        return;
      }

      const url = `/api/bracket/detail?id=${category}`
      this.categoryItem = []
      await this.$axios
        .$get(url)
        .then((result) => {
          this.chartId = result.data.id;
          this.chartName = result.data.category_name;
          const data = JSON.parse(result.data.brackets);
          data.forEach((dat, i) => {
            dat.games.forEach((g, index) => {
              g.player1.match = i;
              g.player1.index = index;
              g.player1.setting = true;
              g.player1.hidden = g.player1.name === 'BYE';

              const opp = data[i].games[index + 1];
              g.player1.isGetBye = opp?.player1?.name === 'BYE';
            })
          });
          this.chart = data;
        })
        .catch(() => {
          this.notif = true
          this.notifColor = 'error'
          this.notifMsg = 'Error get chart'
        })
    },
    printBracket() {
      window.print();
    },
    winData(data) {
      this.tempPlayer = this.chart[data.match]?.games[data.index];
    },
    setWinData(data) {
      const tempChart = this.chart;
      tempChart[data.match].games[data.index].player1.name = this.tempPlayer.player1.name;
      tempChart[data.match].games[data.index].player2.name = this.tempPlayer.player2.name;
      this.tempPlayer = null;

      this.chart = []
      setTimeout(() => {
        this.chart = tempChart
      }, 100);
    },
    hideData() {
      this.chartHidden.push(this.chart[0]);
      this.chart.splice(0, 1);
    },
    showData() {
      this.chart = [this.chartHidden[this.chartHidden.length - 1], ...this.chart];
      this.chartHidden.splice(this.chartHidden.length - 1, 1);
    },

    submitBracket() {
      this.loadingSave = true;
      const url = '/api/edit-bracket'
      const chart = [...this.chartHidden, ...this.chart];
      const params = {
        id: this.chartId,
        bracket: JSON.stringify(chart),
      }

      this.$axios.post(url, params).then((result) => {
        this.loadingSave = false;
        this.notif = true
        this.notifColor = 'success'
        this.notifMsg = 'Data successfully saved'
      }).catch(() => {
        this.loadingSave = false;
        this.notif = true
        this.notifColor = 'error'
        this.notifMsg = 'Error Save Chart'
      })
    },

    hideBye() {
      document.querySelectorAll('.player-hidden').forEach(child => {
          const parent1 = child.closest('.vtb-item-child');
          const parent2 = parent1.closest('.vtb-item');
          const parentVtbItemChild = parent2.closest('.vtb-item-child');
          if (parentVtbItemChild) {
              parentVtbItemChild.remove();
          }
      });
      document.querySelectorAll('.player-get-bye').forEach(child => {
          const parent1 = child.closest('.vtb-item-child');
          const parent2 = parent1.closest('.vtb-item');
          const parentVtbItemChild = parent2.closest('.vtb-item-child');
          if (parentVtbItemChild) {
              parentVtbItemChild.remove();
          }
      });
    }
  },
}
</script>

<style scoped>
@import '~/assets/styles.css';

.chart-shuffle {
  width: 450px;
}

.select-order {
  width: 200px;
  max-width: 230px;
  font-size: 12px !important;
  font-weight: 500 !important;
}
.select-file {
  width: 300px;
  max-width: 300px;
  font-size: 12px !important;
  font-weight: 500 !important;
}
.select-role {
  width: 130px;
  max-width: 230px;
  font-size: 12px !important;
  font-weight: 500 !important;
}
.v-input {
  font-size: 14px !important;
}

div >>> .vtb-player {
  color: black !important;
  background: white !important;
  border-radius: 8px;
  min-width: 200px;
  max-width: 200px;
  border: 1px solid black;
}

div >>> .vtb-player1 {
  border-radius: 8px 8px 0 0;
}
div >>> .vtb-player2 {
  border-radius: 0 0 8px 8px;
}

div >>> .vtb-item-players {
  background: transparent !important;
}

.icon-win {
  float: right;
}
</style>

<style>
.card-dashboard {
  max-width: 1000px;
  margin: 0px auto;
  background: linear-gradient(0deg, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)),
    #121212;
  box-shadow: 11px 11px 62px 7px #000000,
    -11px -11px 51px 1px rgba(48, 48, 48, 0.54);
  backdrop-filter: blur(14px);
  border-radius: 20px;
}

.card-dashboard-bracket {
  max-width: 1000px;
  overflow-x: scroll;
  margin: 0px auto;
  background: linear-gradient(0deg, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)),
    #121212;
  box-shadow: 11px 11px 62px 7px #000000,
    -11px -11px 51px 1px rgba(48, 48, 48, 0.54);
  backdrop-filter: blur(14px);
  border-radius: 20px;
}
@media print {
  @page {
    size: landscape;
    margin: 10mm;
  }
  body, html, #__nuxt, #__layout, .v-application, .v-application--wrap, .v-main, .v-main__wrap, .v-container {
    background-color: #ffffff !important;
    color: #000000 !important;
    display: block !important;
    position: static !important;
    height: auto !important;
    min-height: auto !important;
    width: auto !important;
    overflow: visible !important;
    margin: 0 !important;
    padding: 0 !important;
  }
  .card-dashboard,
  .icon-win,
  .v-btn {
    display: none !important;
  }
  .card-dashboard-bracket {
    display: block !important;
    position: static !important;
    width: max-content !important;
    max-width: none !important;
    overflow: visible !important;
    margin: 0 !important;
    padding: 0 !important;
    background: #ffffff !important;
    box-shadow: none !important;
    border: none !important;
  }
  h5 {
    color: #000000 !important;
  }
  .player-hidden {
    visibility: hidden !important;
  }
}
</style>
