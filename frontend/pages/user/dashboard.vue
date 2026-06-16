<template>
  <div class="mt-8">
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
          Tournament Setting
        </p>
        <div class="d-flex pt-6 pr-6">
          <v-btn
            x-small
            class="mr-3 rounded-8 align-self-center text-14 height-20"
            @click="$router.push('/user/chart')"
          >
            <v-icon class="text-18 mr-2">mdi-family-tree</v-icon>
            Tournament Chart
          </v-btn>
          <v-btn
            x-small
            class="mr-3 rounded-8 align-self-center text-14 height-20"
            @click="dialogImport = true"
          >
            <v-icon class="text-18 mr-2">mdi-tray-arrow-down</v-icon>
            Import Chart
          </v-btn>
          <v-btn
            x-small
            class="rounded-8 align-self-center text-14 height-20 mr-3"
            @click="$router.push('/user/chart/import')"
          >
            <v-icon class="text-18 mr-2">mdi-tray-arrow-up</v-icon>
            Import Category
          </v-btn>
          <!-- <v-btn
            x-small
            class="rounded-8 align-self-center text-14 height-20"
            @click="$router.push('/user/schedule')"
          >
            <v-icon class="text-18 mr-2">mdi-clock-outline</v-icon>
            Schedule
          </v-btn> -->
        </div>
      </div>
    </div>
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
          Scoring System Apps
        </p>
        <div class="d-flex pt-6 pr-6">
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
              placeholder="Select Tournament"
              dense
              auto
              append-icon="mdi-chevron-down"
              @change="getCategory()"
            ></v-autocomplete>
          </div>
          <div class="select-order mr-3">
            <v-select
              v-model="category"
              :items="categoryItem"
              item-text="name"
              item-value="id"
              hide-details
              outlined
              placeholder="Select Category"
              dense
              auto
              append-icon="mdi-chevron-down"
            ></v-select>
          </div>
          <v-btn
            v-if="category"
            x-small
            min-width="38px"
            class="px-1 rounded-8 align-self-center mr-2"
            color="green lighten-1"
            :loading="loadingExport"
            @click="exportDataChart()"
          >
            <v-icon class="text-18">mdi-tray-arrow-down</v-icon>
          </v-btn>
          <v-btn
            v-if="martial"
            x-small
            min-width="38px"
            class="px-1 rounded-8 align-self-center mr-2"
            color="red lighten-1"
            @click="removeDataChart()"
          >
            <v-icon class="text-18">mdi-close</v-icon>
          </v-btn>
          <v-btn
            x-small
            min-width="38px"
            class="px-1 rounded-8 align-self-center"
            @click="saveDataChartLocal()"
          >
            <v-icon class="text-18">mdi-check</v-icon>
          </v-btn>
        </div>
      </div>
      <v-data-table
        :headers="header"
        :items="items"
        hide-default-footer
        class="mx-6 mt-6"
        no-data-text="Empty"
        no-result-text="Data not found"
      >
        <template slot="item.app" slot-scope="props">
          <div class="d-flex">
            <v-btn
              x-small
              color="grey darken-2"
              min-width="34px"
              class="rounded-8 px-0 mr-2"
              @click="openPage(props.item.control)"
            >
              <v-icon class="text-18">mdi-cog-outline</v-icon>
            </v-btn>
            <v-btn
              x-small
              color="primary"
              min-width="34px"
              class="rounded-8 px-0 mr-2"
              @click="openPage(props.item.score)"
            >
              <v-icon class="text-18">mdi-eye-outline</v-icon>
            </v-btn>
            <!-- <v-btn
              x-small
              color="secondary"
              min-width="34px"
              class="rounded-8 px-0"
              @click="openPage(props.item.waiting)"
            >
              <v-icon class="text-18">mdi-clock-outline</v-icon>
            </v-btn> -->
          </div>
        </template>
      </v-data-table>
    </div>

    <!-- Set Place -->
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
          Additional Setting
        </p>
        <div class="d-flex pt-6 pr-6">
          <div class="select-order mr-3">
            <v-select
              v-model="audio"
              :items="audioItem"
              item-text="name"
              item-value="id"
              hide-details
              outlined
              placeholder="Audio"
              dense
              auto
              append-icon="mdi-chevron-down"
            ></v-select>
          </div>
          <div class="select-order mr-3">
            <v-text-field
              v-model="place"
              hide-details
              outlined
              placeholder="Place"
              dense
              auto
            ></v-text-field>
          </div>
          <v-btn
            x-small
            min-width="38px"
            class="px-1 rounded-8 align-self-center mr-2"
            color="red lighten-1"
            @click="removeAdditionalSetting()"
          >
            <v-icon class="text-18">mdi-close</v-icon>
          </v-btn>
          <v-btn
            x-small
            min-width="38px"
            class="px-1 rounded-8 align-self-center"
            @click="saveAdditionalSetting()"
          >
            <v-icon class="text-18">mdi-check</v-icon>
          </v-btn>
        </div>
      </div>
    </div>

    <!-- Set Waiting Prepare area -->
    <div class="card-dashboard pb-6">
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
          Waiting List Prepare Area
        </p>
        <div class="d-flex pt-6 pr-6">
          <div class="select-order mr-3">
            <v-select
              v-model="waitingList"
              :items="categoryItem.filter((data) => data.id != category)"
              item-text="name"
              item-value="id"
              hide-details
              outlined
              placeholder="Next Wait Category"
              dense
              auto
              append-icon="mdi-chevron-down"
            ></v-select>
          </div>
          <v-btn
            x-small
            min-width="38px"
            class="px-1 rounded-8 align-self-center mr-2"
            @click="fullWaitingList()"
          >
            <v-icon class="text-18">mdi-update</v-icon>
          </v-btn>
          <v-btn
            x-small
            min-width="38px"
            class="px-1 rounded-8 align-self-center mr-2"
            @click="saveWaitingList()"
          >
            <v-icon class="text-18">mdi-check</v-icon>
          </v-btn>
          <v-btn
            x-small
            min-width="38px"
            class="px-1 rounded-8 align-self-center mr-2"
            @click="resetWaitingList()"
          >
            <v-icon class="text-18">mdi-close</v-icon>
          </v-btn>
          <v-btn
            x-small
            color="secondary"
            min-width="38px"
            class="px-1 rounded-8 align-self-center"
            @click="openPage('/scorings/waiting')"
          >
            <v-icon class="text-18">mdi-clock-outline</v-icon>
          </v-btn>
        </div>
      </div>
    </div>

    <!-- Dialog Import Chart -->
    <v-dialog v-model="dialogImport" persistent max-width="400px">
      <v-card>
        <span
          class="float-right pt-2 pr-2 pointer"
          @click=";(dialogImport = false), resetFormImport()"
          ><v-icon class="text-14 white--text">mdi-close</v-icon></span
        >
        <div class="pa-4">
          <p class="mb-0 text-18 height-28 font-weight-semi">
            Import Tournament Chart
          </p>
        </div>
        <v-divider color="white"></v-divider>
        <div class="pa-4">
          <div class="mb-3">
            <v-select
              v-model="martialImport"
              :items="martialItem"
              item-text="name"
              item-value="id"
              hide-details
              outlined
              placeholder="Select Martial"
              dense
              auto
              append-icon="mdi-chevron-down"
              @change="getTournamentImport()"
            ></v-select>
          </div>
          <div class="mb-3">
            <v-autocomplete
              v-model="tournamentImportId"
              :items="tournamentImportItem"
              item-text="name"
              item-value="id"
              hide-details
              outlined
              placeholder="Select Tournament (Optional)"
              dense
              auto
              append-icon="mdi-chevron-down"
              no-data-text="Select martial first"
              @change="setTournamentImport()"
            >
            </v-autocomplete>
          </div>
          <div class="mb-3">
            <v-text-field
              v-model="tournamentImport"
              hide-details
              outlined
              placeholder="Tournament Name"
              dense
              auto
            ></v-text-field>
          </div>
          <div class="mb-3">
            <v-text-field
              v-model="categoryImport"
              hide-details
              outlined
              placeholder="Category Name"
              dense
              auto
            ></v-text-field>
          </div>
          <div class="mb-3">
            <v-file-input
              v-model="fileImport"
              placeholder="Select File (.xlsx)"
              outlined
              dense
              hide-details=""
              prepend-icon=""
              append-icon="mdi-file-table-outline"
            ></v-file-input>
          </div>
          <a
            ref="dowloadTemplate"
            class="d-none"
            href="/template/Template-Import-Chart.xlsx"
            download
          ></a>
          <p
            class="text-14 mb-5 text-right pointer"
            @click="$refs.dowloadTemplate.click()"
          >
            <v-icon class="text-16">mdi-tray-arrow-down</v-icon> Download
            template
          </p>
          <v-btn
            small
            block
            color="grey darken-1"
            class="rounded-8"
            :loading="loadingImport"
            @click="importChart()"
            >Submit</v-btn
          >
        </div>
      </v-card>
    </v-dialog>

    <v-snackbar v-model="notif" :color="notifColor">
      {{ notifMsg }}

      <template #action="{ attrs }">
        <v-btn icon v-bind="attrs" @click="notif = false">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </template>
    </v-snackbar>

    <section>
      <xlsx-workbook >
        <xlsx-sheet
          :collection="dataGame"
          sheet-name="Result"
        />
        <xlsx-download filename="Export Game.xlsx">
          <button ref="downloadPdf" class="d-none">Download</button>
        </xlsx-download>
      </xlsx-workbook>
    </section>
  </div>
</template>

<script>
import { XlsxWorkbook, XlsxSheet, XlsxDownload } from "vue-xlsx"
export default {
  name: 'DashboardPage',
  components: {
    XlsxWorkbook,
    XlsxSheet,
    XlsxDownload
  },
  layout: 'dashboard',
  middleware: 'login',
  data() {
    return {
      header: [
        {
          text: 'No',
          align: 'start',
          value: 'number',
          sortable: false,
          class: 'grey--text font-weight-regular',
        },
        {
          text: 'Name',
          align: 'start',
          value: 'name',
          sortable: false,
          class: 'grey--text font-weight-regular',
        },
        {
          text: 'Apps',
          align: 'start',
          value: 'app',
          sortable: false,
          class: 'grey--text font-weight-regular',
        },
      ],
      items: [
        {
          id: 1,
          number: 1,
          name: 'Ju-Jitsu - Fighting System',
          control: '/scorings/controls/pbji/fighting',
          score: '/scorings/score/pbji/fighting',
          waiting: '/scorings/waiting',
        },
        {
          id: 2,
          number: 2,
          name: 'Ju-Jitsu - Fighting System (IJI)',
          control: '/scorings/controls/iji/fighting',
          score: '/scorings/score/iji/fighting',
          waiting: '/scorings/waiting',
        },
        {
          id: 3,
          number: 3,
          name: 'Ju-Jitsu - Newaza',
          control: '/scorings/controls/pbji/newaza',
          score: '/scorings/score/pbji/newaza',
          waiting: '/scorings/waiting',
        },
        {
          id: 4,
          number: 4,
          name: 'Ju-Jitsu - Show System',
          control: '/scorings/controls/pbji/show',
          score: '/scorings/score/pbji/show',
          waiting: '/scorings/waiting',
        },
        {
          id: 5,
          number: 5,
          name: 'Ju-Jitsu - Contact System',
          control: '/scorings/controls/pbji/contact',
          score: '/scorings/score/pbji/contact',
          waiting: '/scorings/waiting',
        },
      ],

      martial: null,
      martialItem: [],

      tournament: null,
      tournamentItem: [],

      category: null,
      categoryItem: [],

      place: '',
      audio: null,
      audioItem: [
        {
          id: 1,
          name: 'Audio 1',
        },
        {
          id: 2,
          name: 'Audio 2',
        },
      ],

      dialogImport: false,
      martialImport: null,
      tournamentImport: '',
      tournamentImportId: null,
      tournamentImportItem: [],
      categoryImport: '',
      fileImport: null,
      loadingImport: false,

      notif: false,
      notifColor: 'dark',
      notifMsg: '',

      loadingExport: false,

      waitingList: null,
      waitingListItem: [],

      dataGame: [{ c: 2 }],
    }
  },
  mounted() {
    this.getMartial();
    const d = this.$cookies.get('data_chart')

    if (d) {
      this.martial = d.martial
      this.getTournament().then(() => {
        this.tournament = d.tournament
        this.getCategory().then(() => {
          this.category = d.category
        })
      })
    }

    let p = localStorage.getItem('dataAdditional')
    if (p != null) {
      p = JSON.parse(p)
      this.place = p.place
      this.audio = p.audio
    }
  },
  methods: {
    openPage(route) {
      if (this.martial && this.tournament && this.category) {
        // route = this.$store.state.const.url + route
        window.open(route, '_blank')
      } else {
        this.notif = true
        this.notifColor = 'error'
        this.notifMsg = 'Error Data Not Selected'
      }
    },
    importChart() {
      const url = '/api/import-chart'
      const tId =
        this.tournamentImportId !== null ? this.tournamentImportId : ''
      const formData = new FormData()
      formData.append('martial_id', this.martialImport)
      formData.append('tournament_id', tId)
      formData.append('tournament_name', this.tournamentImport)
      formData.append('category_name', this.categoryImport)
      formData.append('file_import', this.fileImport)
      this.loadingImport = true
      this.$axios
        .$post(url, formData, {
          headers: { 'Content-Type': 'multipart/form-data' },
        })
        .then((result) => {
          this.loadingImport = false
          this.notif = true
          this.notifColor = 'success'
          this.notifMsg = 'Import Success'
          this.dialogImport = false

          this.resetFormImport()
        })
        .catch((err) => {
          this.loadingImport = false
          this.notif = true
          this.notifColor = 'error'
          this.notifMsg = 'Error Import' + err
        })
    },
    resetFormImport() {
      this.martialImport = null
      this.tournamentImport = ''
      this.tournamentImportId = null
      this.tournamentImportItem = []
      this.categoryImport = ''
      this.fileImport = null
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
          this.removeDataChart()
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
          this.removeDataChart()
        })
    },
    async getCategory() {
      // this.getWaitingList()
      const url = '/api/category'
      const data = {
        tournament_id: this.tournament,
      }
      this.categoryItem = []
      await this.$axios
        .$get(url, { params: data })
        .then((result) => {
          result.data.forEach((item) => {
            this.categoryItem.push({
              id: item.id,
              name: item.category_name,
            })
          })
        })
        .catch(() => {
          this.notif = true
          this.notifColor = 'error'
          this.notifMsg = 'Error get category'
          this.removeDataChart()
        })
    },
    async getWaitingList() {
      const url = '/api/waiting-list'
      const data = {
        tournament_id: this.tournament,
      }
      this.waitingListItem = []
      await this.$axios
        .$get(url, { params: data })
        .then((result) => {
          result.data.forEach((item) => {
            this.waitingListItem.push({
              id: item.id,
              name: item.name,
            })
          })
        })
        .catch(() => {
          this.notif = true
          this.notifColor = 'error'
          this.notifMsg = 'Error get waiting list'
        })
    },
    saveDataChartLocal() {
      if (this.martial && this.tournament && this.category) {
        let data = {
          martial: this.martial,
          tournament: this.tournament,
          category: this.category,
        }

        data = JSON.stringify(data)
        this.$cookies.set('data_chart', data, {
          path: '/',
          maxAge: 60 * 60 * 24 * 7,
        })

        this.notif = true
        this.notifColor = 'success'
        this.notifMsg = 'Data Saved'
      } else {
        this.notif = true
        this.notifColor = 'error'
        this.notifMsg = 'Category cannot empty'
      }
    },
    removeDataChart() {
      this.martial = null
      this.tournament = null
      this.tournamentItem = []

      this.category = null
      this.categoryItem = []
      this.$cookies.remove('data_chart')
    },
    saveAdditionalSetting() {
      if (this.place !== '') {
        let local = localStorage.getItem('dataAdditional')
        if (local != null) {
          local = JSON.parse(local)
          local.place = this.place
          local.audio = this.audio
        } else {
          local = {
            audio: this.audio,
            place: this.place,
          }
        }
        localStorage.setItem('dataAdditional', JSON.stringify(local))

        this.notif = true
        this.notifColor = 'success'
        this.notifMsg = 'Data Saved'
      } else {
        this.notif = true
        this.notifColor = 'error'
        this.notifMsg = 'Place cannot empty'
      }
    },
    removeAdditionalSetting() {
      const local = {
        audio: null,
        place: null,
      }

      localStorage.setItem('dataAdditional', JSON.stringify(local))
    },

    async getTournamentImport() {
      const url = '/api/tournament'
      const data = {
        martial_id: this.martialImport,
      }
      this.tournamentImportItem = []
      await this.$axios
        .$get(url, { params: data })
        .then((result) => {
          result.data.forEach((item) => {
            this.tournamentImportItem.push({
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
    setTournamentImport() {
      this.tournamentImportItem.forEach((t) => {
        if (t.id === this.tournamentImportId) {
          this.tournamentImport = t.name
        }
      })
    },

    async exportDataChart() {
      this.loadingExport = true;
      const url = '/api/game/list'
      const q = {
        category_id: this.category,
      }
      await this.$axios
        .get(url, { params: q })
        .then((result) => {
          const datas = [];

          result?.data?.data?.forEach((player, key) => {
            if (player?.red_name && player?.blue_name) {
              const redPoint = player?.game?.red_points ? JSON.parse(player?.game?.red_points) : null;
              const redFoul = player?.game?.red_foul ? JSON.parse(player?.game?.red_foul) : null;
              const bluePoint = player?.game?.blue_points ? JSON.parse(player?.game?.blue_points) : null;
              const blueFoul = player?.game?.blue_foul ? JSON.parse(player?.game?.blue_foul) : null;

              datas.push({
                'No': key + 1,
                'Red Name': player?.red_name,
                'Red Club': player?.red_club,
                'Blue Name': player?.blue_name,
                'Blue Club': player?.blue_club,
                'Match Number': player?.match_number,
                'Red Point': `Point: ${redPoint?.point || 0} ${redPoint?.advantage ? ', Advantage: ' : ''} ${redPoint?.advantage || ''}`,
                'Red Foul': typeof redFoul === 'object' && player?.red_name ? `Shido: ${redFoul?.shido || 0}, Chui: ${redFoul?.chui || 0}` : redFoul,
                'Blue Point': `Point: ${bluePoint?.point || 0} ${bluePoint?.advantage ? ', Advantage: ' : ''} ${bluePoint?.advantage || ''}`,
                'Blue Foul': typeof blueFoul === 'object' && player?.blue_name ? `Shido: ${blueFoul?.shido || 0}, Chui: ${blueFoul?.chui || 0}` : blueFoul,
                'Winner': player?.winner ? (player?.winner === '1' ? player?.red_name : player?.blue_name) : '',
                'Disqualified': player?.disqualified ? (player?.disqualified === '1' ? player?.red_name : player?.blue_name) : '',
                'Status': player?.play_now === '2' ? 'Complete' : 'Ongoing',
              })
            }
          });

          this.dataGame = datas;
          setTimeout(() => {
            this.$refs.downloadPdf.click()
            this.loadingExport = false;
          }, 1000);
          // let csv = '';
          // // Extract headers
          // const headers = Object.keys(datas[0]);
          // csv += headers.join(',') + '\n';
          // // Extract values
          // datas.forEach(obj => {
          //     const values = headers.map(header => obj[header]);
          //     csv += values.join(',') + '\n';
          // });

          // const encodedUri = encodeURI(csv);
          // const link = document.createElement("a");
          // link.setAttribute("href", encodedUri);
          // link.setAttribute("download", "Export Score.csv");
          // document.body.appendChild(link); // Required for FF
          // link.click();
          // document.body.removeChild(link)
        })
        .catch(() => {
          this.snackbar = true
          this.color = 'error'
          this.message = 'Error export'
          this.loadingExport = false;
        })
    },

    saveWaitingList() {
      localStorage.removeItem('full_waiting_list');
      localStorage.setItem('waiting_list_id', this.waitingList);

      this.notif = true
      this.notifColor = 'success'
      this.notifMsg = 'Next Waiting Category Save'
    },
    resetWaitingList() {
      localStorage.removeItem('waiting_list_id');
      localStorage.removeItem('full_waiting_list');
      this.waitingList = null;
      this.notif = true
      this.notifColor = 'success'
      this.notifMsg = 'Next Waiting Category Deleted'
    },
    fullWaitingList() {
      localStorage.removeItem('waiting_list_id');
      localStorage.setItem('full_waiting_list', true);
      this.waitingList = null;
      this.notif = true
      this.notifColor = 'success'
      this.notifMsg = 'Full Match'
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

.select-order {
  width: 200px;
  max-width: 230px;
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
</style>
