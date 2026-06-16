<template>
  <div class="mt-8">
    <!-- Chart -->
    <div v-if="chart.length > 0" id="bracketData" class="card-dashboard-bracket mb-6 pb-6 px-6">
      <h5 class="text-center pt-5 mb-0">{{ chartName }}</h5>
      <client-only>
        <bracket ref="bracket" :rounds="gameChart">
          <template slot="player" slot-scope="{ player }">
            <p class="bg-white mb-0 pa-0">
              {{ player.name | formatName }}
            </p>
          </template>
        </bracket>
      </client-only>
    </div>
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
  body {
    background-color: #ffffff !important;
    color: #000000 !important;
  }
  .card-dashboard,
  .icon-win,
  .v-btn {
    display: none !important;
  }
  .v-application {
    background: none !important;
  }
  .v-application--wrap {
    min-height: auto !important;
  }
  .v-main {
    padding: 0 !important;
    background: none !important;
  }
  .v-container {
    max-width: none !important;
    padding: 0 !important;
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
}
</style>
