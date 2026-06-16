<template>
  <div>
    <p class="text-center text-20 height-30 font-weight-semi mb-0">
      Check Data
    </p>
    <h4 class="text-center mb-10">{{ categoryName }}</h4>

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
          Data
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
            x-small
            min-width="38px"
            class="px-1 rounded-8 align-self-center"
            @click="getParticipant()"
          >
            <v-icon class="text-18">mdi-check</v-icon>
          </v-btn>
        </div>
      </div>
    </div>

    <div class="card-dashboard my-8">
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
          List Peserta
        </p>
        <div class="d-flex pt-6 pr-6">
          <v-progress-circular
            v-if="loadingSave || loadingPlay"
            indeterminate
            color="white"
          ></v-progress-circular>
          <v-btn
            v-else
            class="px-1 rounded-8 align-self-center"
            @click="dialogAdd = true"
          >
            <v-icon class="text-18">mdi-plus</v-icon> Add
          </v-btn>
        </div>
      </div>
      <v-data-table
        :headers="header"
        :items="participants"
        class="mx-6 mt-6"
        no-data-text="Empty"
        no-result-text="Data not found"
      >
        <template slot="item.status" slot-scope="props">
          <div class="d-flex">
            <v-chip v-show="props.item.play_now === 1" color="success" small
              >Playing</v-chip
            >
            <v-chip
              v-show="props.item.play_now === 2"
              color="grey darken-2"
              small
              >Done</v-chip
            >
            <v-chip
              v-show="props.item.play_now === 0 || props.item.play_now === null"
              color="warning"
              small
              >Waiting</v-chip
            >
          </div>
        </template>
        <template slot="item.action" slot-scope="props">
          <div class="d-flex">
            <v-btn
              v-if="props.item.play_now == 0"
              x-small
              class="px-0 rounded-sm mr-2"
              min-width="34"
              @click="setPlay(props.item.chart_id)"
            >
              <v-icon class="text-16 px-0">mdi-play</v-icon>
            </v-btn>
            <v-btn
              v-if="props.item.play_now == 1"
              x-small
              class="px-0 rounded-sm mr-2"
              min-width="34"
              @click="saveGame(props.item)"
            >
              <v-icon class="text-16 px-0">mdi-floppy</v-icon>
            </v-btn>
            <v-btn
              x-small
              class="px-0 rounded-sm mr-2"
              min-width="34"
              @click="editGame(props.item)"
            >
              <v-icon class="text-16 px-0">mdi-pencil</v-icon>
            </v-btn>
            <v-menu v-if="props.item.play_now == 1" offset-y>
              <template #activator="{ on, attrs }">
                <v-btn
                  x-small
                  class="px-0 rounded-sm mr-2"
                  min-width="34"
                  color="success"
                  v-bind="attrs"
                  v-on="on"
                >
                  <v-icon class="text-16 px-0">mdi-crown</v-icon>
                </v-btn>
              </template>
              <v-list>
                <v-list-item>
                  <v-list-item-title class="pointer" @click="autoWin(1, props.item)">Red Win</v-list-item-title>
                </v-list-item>
                <v-list-item>
                  <v-list-item-title class="pointer" @click="autoWin(2, props.item)">Blue Win</v-list-item-title>
                </v-list-item>
              </v-list>
            </v-menu>
            <v-btn
              v-if="props.item.play_now != 2"
              x-small
              class="px-0 rounded-sm"
              min-width="34"
              color="red"
              @click="
                ;(dialogConfirmDelete = true),
                  (dataDialogDelete = props.item.chart_id)
              "
            >
              <v-icon class="text-16 px-0">mdi-delete</v-icon>
            </v-btn>
          </div>
        </template>
      </v-data-table>
    </div>

    <v-snackbar v-model="notif" :color="notifColor" centered>
      {{ notifMsg }}

      <template #action="{ attrs }">
        <v-btn icon v-bind="attrs" @click="notif = false">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </template>
    </v-snackbar>

    <v-dialog v-model="dialogAdd" persistent max-width="400px">
      <v-card>
        <span class="float-right pt-2 pr-2 pointer" @click="dialogAdd = false"
          ><v-icon class="text-14 white--text">mdi-close</v-icon></span
        >
        <div class="pa-4">
          <p class="mb-0 text-18 height-28 font-weight-semi">Add Participant</p>
        </div>
        <v-divider color="white"></v-divider>
        <div class="pa-4">
          <div class="mb-3">
            <v-row>
              <v-col cols="12" class="py-0 text-14">Data Red</v-col>
              <v-col cols="12" sm="6" class="pt-2">
                <v-text-field
                  v-model="dataDialogAdd.redName"
                  hide-details
                  outlined
                  placeholder="Red Name"
                  dense
                  auto
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" class="pt-2">
                <v-text-field
                  v-model="dataDialogAdd.redClub"
                  hide-details
                  outlined
                  placeholder="Red Club"
                  dense
                  auto
                ></v-text-field>
              </v-col>
            </v-row>
          </div>
          <div class="mb-3">
            <v-row>
              <v-col cols="12" class="py-0 text-14">Data Blue</v-col>
              <v-col cols="12" sm="6" class="pt-2">
                <v-text-field
                  v-model="dataDialogAdd.blueName"
                  hide-details
                  outlined
                  placeholder="Blue Name"
                  dense
                  auto
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" class="pt-2">
                <v-text-field
                  v-model="dataDialogAdd.blueClub"
                  hide-details
                  outlined
                  placeholder="Blue Club"
                  dense
                  auto
                ></v-text-field>
              </v-col>
            </v-row>
          </div>
          <div class="mt-4 mb-6">
            <v-text-field
              v-model="dataDialogAdd.match"
              hide-details
              type="number"
              hide-spin-buttons
              outlined
              placeholder="Match Number"
              dense
              auto
            ></v-text-field>
          </div>
          <v-btn
            small
            block
            color="grey darken-1"
            class="rounded-8"
            :loading="loadingAdd"
            @click="addChart()"
            >Submit</v-btn
          >
        </div>
      </v-card>
    </v-dialog>
    <v-dialog v-model="dialogEdit" persistent max-width="400px">
      <v-card>
        <span class="float-right pt-2 pr-2 pointer" @click="dialogEdit = false"
          ><v-icon class="text-14 white--text">mdi-close</v-icon></span
        >
        <div class="pa-4">
          <p class="mb-0 text-18 height-28 font-weight-semi">
            Edit Participant
          </p>
        </div>
        <v-divider color="white"></v-divider>
        <div class="pa-4">
          <div class="mb-3">
            <v-row>
              <v-col cols="12" class="py-0 text-14">Data Red</v-col>
              <v-col cols="12" sm="6" class="pt-2">
                <v-text-field
                  v-model="dataDialogEdit.redName"
                  hide-details
                  outlined
                  placeholder="Red Name"
                  dense
                  auto
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" class="pt-2">
                <v-text-field
                  v-model="dataDialogEdit.redClub"
                  hide-details
                  outlined
                  placeholder="Red Club"
                  dense
                  auto
                ></v-text-field>
              </v-col>
            </v-row>
          </div>
          <div class="mb-3">
            <v-row>
              <v-col cols="12" class="py-0 text-14">Data Blue</v-col>
              <v-col cols="12" sm="6" class="pt-2">
                <v-text-field
                  v-model="dataDialogEdit.blueName"
                  hide-details
                  outlined
                  placeholder="Blue Name"
                  dense
                  auto
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" class="pt-2">
                <v-text-field
                  v-model="dataDialogEdit.blueClub"
                  hide-details
                  outlined
                  placeholder="Blue Club"
                  dense
                  auto
                ></v-text-field>
              </v-col>
            </v-row>
          </div>
          <div class="mt-4 mb-6">
            <v-text-field
              v-model="dataDialogEdit.match"
              hide-details
              hide-spin-buttons
              outlined
              type="number"
              placeholder="Match Number"
              dense
              auto
            ></v-text-field>
          </div>
          <v-btn
            small
            block
            color="grey darken-1"
            class="rounded-8"
            :loading="loadingEdit"
            @click="editChart()"
            >Submit</v-btn
          >
        </div>
      </v-card>
    </v-dialog>
    <v-dialog v-model="dialogConfirmDelete" persistent max-width="400px">
      <v-card>
        <span
          class="float-right pt-2 pr-2 pointer"
          @click="dialogConfirmDelete = false"
          ><v-icon class="text-14 white--text">mdi-close</v-icon></span
        >
        <div class="pa-4">
          <p class="mb-0 text-center text-18 height-28 font-weight-semi">
            Delete Participant
          </p>
        </div>
        <v-divider color="white"></v-divider>
        <div class="pa-4">
          <v-row>
            <v-col cols="6">
              <v-btn
                small
                block
                outlined
                color="white"
                class="rounded-8"
                :loading="loadingDelete"
                @click="deleteChart(dataDialogDelete)"
                >Delete</v-btn
              >
            </v-col>
            <v-col cols="6">
              <v-btn
                small
                block
                color="grey darken-1"
                class="rounded-8"
                @click="dialogConfirmDelete = false"
                >Cancel</v-btn
              >
            </v-col>
          </v-row>
        </div>
      </v-card>
    </v-dialog>

    <!-- Audio -->
    <div class="d-none">
      <audio ref="timesUpAudio" controls>
        <source src="/sound/horn.mp3" type="audio/mpeg" />
      </audio>
    </div>
    <div class="d-none">
      <audio ref="timesUpAudio2" controls>
        <source src="/sound/whistle.mp3" type="audio/mpeg" />
      </audio>
    </div>
  </div>
</template>

<script>
// import WinnerDialogVue from '~/components/WinnerDialog.vue'
export default {
  name: 'ControlsPBJINewaza',
  middleware: 'login',
  // components: { WinnerDialogVue },
  data() {
    return {
      dataMain: {
        martial_id: null,
        tournament_id: null,
        category_id: null,
        chart_id: null,
        game_id: null,
      },
      scoringType: 1,

      header: [
        {
          text: 'No',
          align: 'start',
          value: 'number',
          sortable: false,
          class: 'grey--text font-weight-regular',
        },
        {
          text: 'Red Name',
          align: 'start',
          value: 'red_name',
          sortable: false,
          class: 'grey--text font-weight-regular',
        },
        {
          text: 'Red Club',
          align: 'start',
          value: 'red_club',
          sortable: false,
          class: 'grey--text font-weight-regular',
        },
        {
          text: 'Blue Name',
          align: 'start',
          value: 'blue_name',
          sortable: false,
          class: 'grey--text font-weight-regular',
        },
        {
          text: 'Blue Club',
          align: 'start',
          value: 'blue_club',
          sortable: false,
          class: 'grey--text font-weight-regular',
        },
        {
          text: 'Match',
          align: 'start',
          value: 'match',
          sortable: false,
          class: 'grey--text font-weight-regular',
        },
        {
          text: 'Status',
          align: 'start',
          value: 'status',
          sortable: false,
          class: 'grey--text font-weight-regular',
        },
        {
          text: 'Action',
          align: 'start',
          value: 'action',
          sortable: false,
          class: 'grey--text font-weight-regular',
        },
      ],

      martial: null,
      martialItem: [],

      tournament: null,
      tournamentItem: [],

      category: null,
      categoryItem: [],

      participants: [],
      categoryName: '',
      currentMatch: 1,

      winner: null,
      disqualified: null,

      gameSaved: true,
      playing: false,

      dialogAdd: false,
      dialogEdit: false,
      dialogConfirmDelete: false,

      dataDialogEdit: {
        redName: '',
        redClub: '',
        blueName: '',
        blueClub: '',
        match: '',
      },
      dataDialogAdd: {
        redName: '',
        redClub: '',
        blueName: '',
        blueClub: '',
        match: '',
      },
      dataDialogDelete: null,

      loadingAdd: false,
      loadingEdit: false,
      loadingSave: false,
      loadingPlay: false,
      loadingDelete: false,

      notif: false,
      notifColor: 'dark',
      notifMsg: '',
    }
  },
  mounted() {
    this.getMartial();
  },
  methods: {

    setWinner(winner) {
      this.winner = winner
    },
    hideWinner() {
      let local = localStorage.getItem('dataWinner')
      if (local != null) {
        local = JSON.parse(local)
        local.show = false
      } else {
        local = {
          show: false,
        }
      }
      this.dialogWinner = false
      this.dialogWinnerTap = false

      localStorage.setItem('dataWinner', JSON.stringify(local))
      this.notif = false
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


    async getParticipant() {
      const url = '/api/game/list'
      const q = {
        category_id: this.category,
      }
      this.participants = []
      await this.$axios
        .get(url, { params: q })
        .then((result) => {
          if (result.data.data.length > 0) {
            let num = 1
            // this.tournamentName = result.data.tournament.tournament_name
            this.categoryName = result.data.category.category_name
            let setCurrent = false
            result.data.data.forEach((item) => {
              if (!setCurrent) {
                if (
                  parseInt(item.play_now) === 0 ||
                  parseInt(item.play_now) === 1
                ) {
                  if (item.match_number != null) {
                    this.currentMatch = item.match_number
                    setCurrent = true
                  }
                }
              }
            })
            result.data.data.forEach((item) => {
              // if (this.currentMatch === item.match_number) {
              // }
                this.participants.push({
                  chart_id: item.id,
                  red_name: item.red_name,
                  red_club: item.red_club,
                  blue_name: item.blue_name,
                  blue_club: item.blue_club,
                  play_now: item.play_now != null ? parseInt(item.play_now) : 0,
                  match: item.match_number,
                  number: num,
                  game: item.game,
                  martial_id: item.martial_id,
                  category_id: item.category_id,
                  tournament_id: item.tournament_id,
                })
                num++
            })
            this.getPlaying()
          }
        })
        .catch(() => {
          this.notif = true
          this.notifColor = 'error'
          this.notifMsg = 'Error get participant'
        })
    },
    getPlaying() {
      let play = 0
      this.participants.forEach((p) => {
        if (play === 0) {
          if (p.play_now === 1) {
            play = 1
            this.playing = true
            this.gameSaved = false
            this.setPlayer(p)
          }
        }
      })
    },
    setPlayer(data) {
      this.participants.forEach((p) => {
        if (p.chart_id === data.id) {
          p.play_now = 1
        }
      })
      this.redName = data.red_name
      this.redClub = data.red_club
      this.blueName = data.blue_name
      this.blueClub = data.blue_club
    },
    async setPlay(id) {
      const url = '/api/game/play'
      const q = {
        chart_id: id,
        scoring_type: this.scoringType,
      }
      if (this.gameSaved) {
        this.loadingPlay = true
        await this.$axios
          .post(url, q)
          .then((result) => {
            // this.tournament = result.data.tournament.tournament_name
            this.categoryName = result.data.category.category_name
            this.setPlayer(result.data.participant)
            this.participants.forEach((p) => {
              if (p.chart_id === id) {
                p.game = result.data.game
              }
            })

            this.playing = true
            this.gameSaved = false
            this.loadingPlay = false
          })
          .catch(() => {
            this.notif = true
            this.notifColor = 'error'
            this.notifMsg = 'Error get player'
            this.loadingPlay = false
          })
      } else {
        this.notif = true
        this.notifColor = 'error'
        this.notifMsg = 'Data not save'
      }
    },
    async saveGame(data) {
      const url = '/api/game/save'
      const q = {
        chart_id: data.chart_id,
        game_id: data.game.id,
        winner: this.winner,
        disqualified: this.disqualified,
        red_point: this.winner === 1 ? 1 : 0,
        red_foul: 0,
        blue_point: this.winner === 2 ? 1 : 0,
        blue_foul: 0,
      }

      if (this.winner !== null || this.disqualified !== null) {
        this.loadingSave = true
        await this.$axios
          .post(url, q)
          .then((result) => {
            this.getParticipant()
            this.gameSaved = true
            this.winner = null
            this.disqualified = null
            this.loadingSave = false
          })
          .catch(() => {
            this.notif = true
            this.notifColor = 'error'
            this.notifMsg = 'Error save game'
            this.loadingSave = false
          })
      } else {
        this.notif = true
        this.notifColor = 'error'
        this.notifMsg = 'Error Winner Not Set'
      }
    },
    async autoWin(win, data) {
      const url = '/api/game/save'
      const q = {
        chart_id: data.chart_id,
        game_id: data.game.id,
        winner: win,
        disqualified: null,
        red_point: win === 1 ? 1 : 0,
        red_foul: 0,
        blue_point: win === 2 ? 1 : 0,
        blue_foul: 0,
      }

      this.loadingSave = true
      await this.$axios
        .post(url, q)
        .then((result) => {
          this.getParticipant()
          this.gameSaved = true
          this.winner = null
          this.disqualified = null
          this.loadingSave = false
        })
        .catch(() => {
          this.snackbar = true
          this.color = 'error'
          this.message = 'Error save game'
          this.loadingSave = false
        })
    },

    async addChart() {
      const q = {
        martial_id: this.dataMain.martial_id,
        category_id: this.dataMain.category_id,
        tournament_id: this.dataMain.tournament_id,
        red_name: this.dataDialogAdd.redName,
        red_club: this.dataDialogAdd.redClub,
        blue_name: this.dataDialogAdd.blueName,
        blue_club: this.dataDialogAdd.blueClub,
        match_number: this.dataDialogAdd.match,
      }
      const url = '/api/game/create'
      this.loadingAdd = true
      await this.$axios
        .post(url, q)
        .then((result) => {
          this.getParticipant()
          this.loadingAdd = false
          this.dialogAdd = false

          this.notif = true
          this.notifColor = 'success'
          this.notifMsg = 'Success Add Participant'
        })
        .catch(() => {
          this.notif = true
          this.notifColor = 'error'
          this.notifMsg = 'Error Add Participant'
          this.loadingAdd = false
        })
    },

    editGame(data) {
      this.dialogEdit = true
      this.dataDialogEdit.redName = data.red_name
      this.dataDialogEdit.redClub = data.red_club
      this.dataDialogEdit.blueName = data.blue_name
      this.dataDialogEdit.blueClub = data.blue_club
      this.dataDialogEdit.match = data.match
      this.dataDialogEdit.id = data.chart_id
    },
    async editChart() {
      const q = {
        id: this.dataDialogEdit.id,
        red_name: this.dataDialogEdit.redName,
        red_club: this.dataDialogEdit.redClub,
        blue_name: this.dataDialogEdit.blueName,
        blue_club: this.dataDialogEdit.blueClub,
        match_number: this.dataDialogEdit.match,
      }
      const url = '/api/game/edit'
      this.loadingEdit = true
      await this.$axios
        .post(url, q)
        .then((result) => {
          this.participants.forEach((p) => {
            if (p.chart_id === this.dataDialogEdit.id) {
              p.red_name = this.dataDialogEdit.redName
              p.red_club = this.dataDialogEdit.redClub
              p.blue_name = this.dataDialogEdit.blueName
              p.blue_club = this.dataDialogEdit.blueClub
              p.match = this.dataDialogEdit.match
            }
          })
          this.loadingEdit = false
          this.dialogEdit = false

          this.notif = true
          this.notifColor = 'success'
          this.notifMsg = 'Success Edit Participant'
        })
        .catch(() => {
          this.notif = true
          this.notifColor = 'error'
          this.notifMsg = 'Error Edit Participant'
          this.loadingEdit = false
        })
    },

    async deleteChart() {
      const q = {
        id: this.dataDialogDelete,
      }
      const url = '/api/game/delete'
      this.loadingDelete = true
      await this.$axios
        .get(url, { params: q })
        .then((result) => {
          this.getParticipant()
          this.loadingDelete = false
          this.dialogConfirmDelete = false
          this.notif = true
          this.notifColor = 'success'
          this.notifMsg = 'Success Delete Participant'
        })
        .catch(() => {
          this.notif = true
          this.notifColor = 'error'
          this.notifMsg = 'Error Delete Participant'
          this.loadingDelete = false
        })
    },

  },
}
</script>

<style scoped>
@import '~/assets/styles.css';

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

.corner {
  width: 545px;
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
.text-score {
  font-size: 80px;
  line-height: 80px;
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
