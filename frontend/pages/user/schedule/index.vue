<template>
  <div class="mt-8">
    <!-- Import -->
    <div class="card-dashboard mb-6 pb-6">
      <div class="">
        <p
          class="
            pl-6
            pt-6
            mb-0
            blackgrey--text
            font-weight-semi
            text-14
            height-28
            align-seld-center
            pointer
          "
          @click="$router.push('/user/dashboard')"
        >
          <v-icon class="text-16">mdi-arrow-left</v-icon> Back
        </p>
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
          Schedule
        </p>
        <div class="d-flex pt-6 px-6 pb-3">
          <div class="select-role mr-3">
            <v-select
              v-model="martial"
              :items="martialItem"
              item-text="name"
              item-value="id"
              hide-details
              outlined
              placeholder="Martial"
              dense
              auto
              append-icon="mdi-chevron-down"
              @change="getTournament()"
            ></v-select>
          </div>
          <div class="select-order mr-3">
            <v-autocomplete
              v-model="tournament"
              :items="tournamentItem"
              item-text="name"
              item-value="id"
              hide-details
              outlined
              placeholder="Tournament Name"
              append-icon="mdi-chevron-down"
              dense
              auto
            ></v-autocomplete>
          </div>
          <v-btn
            x-small
            min-width="38px"
            class="px-1 rounded-8 align-self-center mr-3"
            :loading="loadingGetData"
            @click="getChart()"
          >
            <v-icon class="text-18">mdi-magnify</v-icon>
          </v-btn>
          <v-btn
            x-small
            min-width="38px"
            class="px-1 rounded-8 align-self-center ml-auto"
            color="green lighten-1"
            @click="$router.push('/user/schedule/setting')"
          >
            <v-icon class="text-18">mdi-plus</v-icon>
          </v-btn>
        </div>
      </div>
    </div>

    <!-- List Tournament Chart -->
    <div class="card-dashboard mb-6 pb-6">
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
          List Schedule
        </p>
      </div>
      <div class="mt-6 px-6">
        <v-simple-table class="mt-3 w-100">
          <thead>
            <tr>
              <th>Schedule</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="charts.length < 1">
              <td colspan="2">No data available</td>
            </tr>
            <tr v-for="(data, i) in charts" :key="i">
              <td>{{ data.category_name }}</td>
              <td class="w-15">
                <div class="d-flex">
                  <v-icon class="text-20 pointer" @click="openPage(data.id)"
                    >mdi-open-in-new</v-icon
                  >
                  <!-- <v-icon class="text-20 pointer ml-2" @click="donwloadChart(data.id)"
                    >mdi-tray-arrow-down</v-icon
                  > -->
                </div>
              </td>
            </tr>
          </tbody>
        </v-simple-table>
      </div>
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
  name: 'SchedulePage',
  layout: 'dashboard',
  middleware: 'login',
  data() {
    return {
      martial: null,
      martialItem: [],

      tournament: null,
      tournamentItem: [],

      charts: [],
      loadingGetData: false,

      embedUrl: null,
      embedTitle: null,

      notif: false,
      notifColor: 'dark',
      notifMsg: '',
    }
  },
  mounted() {
    this.getMartial()
  },

  methods: {
    openPage(id) {
      const routeData = this.$router.resolve({path: '/user/chart/detail'});
      window.open(`${routeData.href}?id=${id}`, '_blank');
    },
    async getMartial() {
      const url = '/api/martial'
      await this.$axios
        .get(url)
        .then((result) => {
          if (result.data.data.length > 0) {
            result.data.data.forEach((item) => {
              this.martialItem.push({
                id: item.id,
                name: item.martial_name,
              })
            })
          }
        })
        .catch(() => {
          this.notif = true
          this.notifColor = 'error'
          this.notifMsg = 'Error get martial'
        })
    },
    async getTournament() {
      const url = '/api/tournament'
      const data = {
        martial_id: this.martial,
      }
      this.tournamentItem = []
      await this.$axios
        .$get(url, { params: data })
        .then((result) => {
          result.data.forEach((item) => {
            this.tournamentItem.push({
              id: item.id,
              name: item.tournament_name,
            })
          })
        })
        .catch(() => {
          this.notif = true
          this.notifColor = 'error'
          this.notifMsg = 'Error get tournament'
        })
    },
    async getChart() {
      if (!this.tournament) {
        this.notif = true
        this.notifColor = 'error'
        this.notifMsg = 'Tournament is empty'
        return;
      }
      this.loadingGetData = true

      const url = '/api/bracket'
      const data = {
        tournament_id: this.tournament,
      }
      this.categoryItem = []
      await this.$axios
        .$get(url, { params: data })
        .then((result) => {
          this.charts = result.data
          this.loadingGetData = false
        })
        .catch(() => {
          this.loadingGetData = false
          this.notif = true
          this.notifColor = 'error'
          this.notifMsg = 'Error get chart'
        })
    },

    saveBracket() {
      let local = localStorage.getItem('liveBracket')
      if (local != null) {
        local = JSON.parse(local)
        local.url = this.embedUrl
        local.title = this.embedTitle
      } else {
        local = {
          url: this.embedUrl,
          title: this.embedTitle,
        }
      }
      localStorage.setItem('liveBracket', JSON.stringify(local))
    },
  },
}
</script>

<style scoped>
@import '~/assets/styles.css';

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
  background: #efeded !important;
  border-radius: 8px;
  min-width: 200px;
  max-width: 200px;
}
</style>
