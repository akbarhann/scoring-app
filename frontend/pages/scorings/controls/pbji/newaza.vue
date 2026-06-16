<template>
  <div>
    <p class="text-center text-20 height-30 font-weight-semi mb-0">
      Control Score Newaza
    </p>
    <h4 class="text-center mb-10">{{ category }}</h4>
    <div class="d-flex justify-space-between">
      <!-- Red Corner -->
      <div class="corner">
        <div class="red-corner pt-4 px-4">
          <p class="font-weight-semi text-18 text-center">
            {{ redName }} <span class="mx-3 primaryred--text">|</span>
            {{ redClub }}
          </p>
          <div class="d-block">
            <!-- Points -->
            <div class="d-block mb-6">
              <div class="d-flex justify-center">
                <div>
                  <v-btn
                    block
                    elevation="0"
                    color="primaryred"
                    class="rounded-8 my-1 px-3"
                    @click="changeRedScore(2)"
                  >
                    +2
                  </v-btn>

                  <v-btn
                    block
                    elevation="0"
                    color="primaryred"
                    class="rounded-8 my-1 px-3"
                    @click="changeRedScore(3)"
                  >
                    +3
                  </v-btn>

                  <v-btn
                    block
                    elevation="0"
                    color="primaryred"
                    class="rounded-8 my-1 px-3"
                    @click="changeRedScore(4)"
                  >
                    +4
                  </v-btn>
                </div>
                <p
                  class="
                    mb-0
                    align-self-center
                    text-score
                    font-weight-semi
                    mx-10
                  "
                >
                  {{ redScore }}
                </p>
                <div>
                  <v-btn
                    block
                    elevation="0"
                    color="primaryred"
                    class="rounded-8 my-1 px-3"
                    @click="changeRedScore(redScore >= 2 ? -2 : 0)"
                  >
                    -2
                  </v-btn>

                  <v-btn
                    block
                    elevation="0"
                    color="primaryred"
                    class="rounded-8 my-1 px-3"
                    @click="changeRedScore(redScore >= 3 ? -3 : 0)"
                  >
                    -3
                  </v-btn>

                  <v-btn
                    block
                    elevation="0"
                    color="primaryred"
                    class="rounded-8 my-1 px-3"
                    @click="changeRedScore(redScore >= 4 ? -4 : 0)"
                  >
                    -4
                  </v-btn>
                </div>
              </div>
              <p class="w-100 text-center font-weight-medium mb-0">Points</p>
            </div>

            <div class="d-flex justify-lg-space-around">
              <!-- Advantages -->
              <div class="d-block">
                <div class="d-flex justify-space-around">
                  <div>
                    <v-btn
                      block
                      elevation="0"
                      color="primaryred"
                      class="rounded-8 my-1 px-3"
                      @click="changeRedAdvantages(1)"
                    >
                      +1
                    </v-btn>
                  </div>
                  <p
                    class="
                      mb-0
                      align-self-center
                      text-30
                      height-30
                      font-weight-semi
                      mx-3
                    "
                  >
                    {{ redAdvantages }}
                  </p>
                  <div>
                    <v-btn
                      block
                      elevation="0"
                      color="primaryred"
                      class="rounded-8 my-1 px-3"
                      @click="changeRedAdvantages(redAdvantages > 0 ? -1 : 0)"
                    >
                      -1
                    </v-btn>
                  </div>
                </div>
                <p class="w-100 text-center font-weight-medium mt-3">
                  Advantages
                </p>
              </div>

              <v-btn
                color="primaryred"
                class="rounded-8 px-0 my-3"
                elevation="0"
                min-width="45"
                @click="redReset()"
              >
                <v-icon class="white--text">mdi-restart</v-icon>
              </v-btn>

              <!-- Foul -->
              <div class="d-block">
                <div class="d-flex justify-space-around">
                  <div>
                    <v-btn
                      block
                      elevation="0"
                      color="primaryred"
                      class="rounded-8 my-1 px-3"
                      @click="changeRedFoul(1)"
                    >
                      +1
                    </v-btn>
                  </div>
                  <p
                    class="
                      mb-0
                      align-self-center
                      text-30
                      height-30
                      font-weight-semi
                      mx-3
                    "
                  >
                    {{ redFoul }}
                  </p>
                  <div>
                    <v-btn
                      block
                      elevation="0"
                      color="primaryred"
                      class="rounded-8 my-1 px-3"
                      @click="changeRedFoul(redFoul > 0 ? -1 : 0)"
                    >
                      -1
                    </v-btn>
                  </div>
                </div>
                <p class="w-100 text-center font-weight-medium mt-3">Fouls</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Blue Corner -->
      <div class="corner">
        <div class="blue-corner pt-4 px-4">
          <p class="font-weight-semi text-18 text-center">
            {{ blueName }} <span class="mx-3 primary--text">|</span>
            {{ blueClub }}
          </p>
          <div class="d-block">
            <!-- Points -->
            <div class="d-block mb-6">
              <div class="d-flex justify-center">
                <div>
                  <v-btn
                    block
                    elevation="0"
                    color="primaryblue"
                    class="rounded-8 my-1 px-3"
                    @click="changeBlueScore(2)"
                  >
                    +2
                  </v-btn>

                  <v-btn
                    block
                    elevation="0"
                    color="primaryblue"
                    class="rounded-8 my-1 px-3"
                    @click="changeBlueScore(3)"
                  >
                    +3
                  </v-btn>

                  <v-btn
                    block
                    elevation="0"
                    color="primaryblue"
                    class="rounded-8 my-1 px-3"
                    @click="changeBlueScore(4)"
                  >
                    +4
                  </v-btn>
                </div>
                <p
                  class="
                    mb-0
                    align-self-center
                    text-score
                    font-weight-semi
                    mx-10
                  "
                >
                  {{ blueScore }}
                </p>
                <div>
                  <v-btn
                    block
                    elevation="0"
                    color="primaryblue"
                    class="rounded-8 my-1 px-3"
                    @click="changeBlueScore(blueScore >= 2 ? -2 : 0)"
                  >
                    -2
                  </v-btn>

                  <v-btn
                    block
                    elevation="0"
                    color="primaryblue"
                    class="rounded-8 my-1 px-3"
                    @click="changeBlueScore(blueScore >= 3 ? -3 : 0)"
                  >
                    -3
                  </v-btn>

                  <v-btn
                    block
                    elevation="0"
                    color="primaryblue"
                    class="rounded-8 my-1 px-3"
                    @click="changeBlueScore(blueScore >= 4 ? -4 : 0)"
                  >
                    -4
                  </v-btn>
                </div>
              </div>
              <p class="w-100 text-center font-weight-medium mb-0">Points</p>
            </div>

            <div class="d-flex justify-lg-space-around">
              <!-- Advantages -->
              <div class="d-block">
                <div class="d-flex justify-space-around">
                  <div>
                    <v-btn
                      block
                      elevation="0"
                      color="primaryblue"
                      class="rounded-8 my-1 px-3"
                      @click="changeBlueAdvantages(1)"
                    >
                      +1
                    </v-btn>
                  </div>
                  <p
                    class="
                      mb-0
                      align-self-center
                      text-30
                      height-30
                      font-weight-semi
                      mx-3
                    "
                  >
                    {{ blueAdvantages }}
                  </p>
                  <div>
                    <v-btn
                      block
                      elevation="0"
                      color="primaryblue"
                      class="rounded-8 my-1 px-3"
                      @click="changeBlueAdvantages(blueAdvantages > 0 ? -1 : 0)"
                    >
                      -1
                    </v-btn>
                  </div>
                </div>
                <p class="w-100 text-center font-weight-medium mt-3">
                  Advantages
                </p>
              </div>

              <v-btn
                color="primaryblue"
                class="rounded-8 px-0 my-3"
                elevation="0"
                min-width="45"
                @click="blueReset()"
              >
                <v-icon class="white--text">mdi-restart</v-icon>
              </v-btn>

              <!-- Foul -->
              <div class="d-block">
                <div class="d-flex justify-space-around">
                  <div>
                    <v-btn
                      block
                      elevation="0"
                      color="primaryblue"
                      class="rounded-8 my-1 px-3"
                      @click="changeBlueFoul(1)"
                    >
                      +1
                    </v-btn>
                  </div>
                  <p
                    class="
                      mb-0
                      align-self-center
                      text-30
                      height-30
                      font-weight-semi
                      mx-3
                    "
                  >
                    {{ blueFoul }}
                  </p>
                  <div>
                    <v-btn
                      block
                      elevation="0"
                      color="primaryblue"
                      class="rounded-8 my-1 px-3"
                      @click="changeBlueFoul(blueFoul > 0 ? -1 : 0)"
                    >
                      -1
                    </v-btn>
                  </div>
                </div>
                <p class="w-100 text-center font-weight-medium mt-3">Fouls</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="d-flex justify-space-between mt-10">
      <!-- Setting Time -->
      <div class="main-timer">
        <div class="main-timer-inner py-4">
          <p class="mb-3 w-100 text-center text-score font-weight-semi">
            {{ time | timeFormat }}
          </p>
          <div class="d-flex mb-0 justify-center">
            <v-icon class="mx-2 text-28 pointer" @click="timeStart ? '' : startTime()"
              >mdi-play-circle-outline</v-icon
            >
            <v-icon class="mx-2 text-28 pointer" @click="pauseTime()"
              >mdi-pause-circle-outline</v-icon
            >
            <v-icon class="mx-2 text-28 pointer" @click="stopTime()"
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
                  placeholder="Satuan detik"
                  append-icon="mdi-check"
                  @click:append="
                  setTime(inputTime),
                      (time = inputTime),
                      (settingTime = false)
                  "
                  @keyup.enter="setTime(inputTime),
                      (time = inputTime),
                      (settingTime = false)"
                ></v-text-field>
              </div>
            </v-expand-transition>
          </div>
        </div>
      </div>
      <!-- End Control -->
      <div class="main-timer">
        <div class="main-timer-inner py-4">
          <div class="d-flex mb-0 justify-center h-100">
            <div class="mx-1 align-self-center">
              <div v-if="!dialogWinner" class="d-flex flex-nowrap">
                <v-btn
                  color="primaryred"
                  small
                  class="rounded-8 mx-2"
                  @click="setWinner(1)"
                  >Red</v-btn
                >
                <v-btn
                  color="primaryblue"
                  small
                  class="rounded-8 mx-2"
                  @click="setWinner(2)"
                  >Blue</v-btn
                >
              </div>
              <div v-else>
                <v-btn
                  color="primaryred"
                  small
                  class="rounded-8 mx-2"
                  @click="hideWinner()"
                  >Close</v-btn
                >
              </div>
              <p class="mb-0 font-weight-semi text-center pt-2">Winner</p>
            </div>
            <div class="mx-1 align-self-center">
              <div v-if="!dialogWinnerTap" class="d-flex flex-nowrap">
                <v-btn
                  color="primaryred"
                  small
                  class="rounded-8 mx-2"
                  @click="setTapWinner(1)"
                  >Red</v-btn
                >
                <v-btn
                  color="primaryblue"
                  small
                  class="rounded-8 mx-2"
                  @click="setTapWinner(2)"
                  >Blue</v-btn
                >
              </div>
              <div v-else class="d-flex flex-nowrap">
                <v-btn
                  color="primaryblue"
                  small
                  class="rounded-8 mx-2"
                  @click="hideWinner()"
                  >Close</v-btn
                >
                <v-btn
                  color="primaryred"
                  small
                  class="rounded-8 mx-2"
                  @click="cancelTapWinner()"
                  >Cancel</v-btn
                >
              </div>
              <p class="mb-0 font-weight-semi text-center pt-2">Tap Winner</p>
            </div>
            <div class="mx-1 align-self-center">
              <div v-if="!dialogDis" class="d-flex flex-nowrap">
                <v-btn
                  color="primaryred"
                  small
                  class="rounded-8 mx-2"
                  @click="setDis(1)"
                  >Red</v-btn
                >
                <v-btn
                  color="primaryblue"
                  small
                  class="rounded-8 mx-2"
                  @click="setDis(2)"
                  >Blue</v-btn
                >
              </div>
              <div v-else class="d-flex flex-nowrap">
                <v-btn
                  color="primaryred"
                  small
                  class="rounded-8 mx-2"
                  @click="hideDis()"
                  >Close</v-btn
                >
                <v-btn
                  color="primaryblue"
                  small
                  class="rounded-8 mx-2"
                  @click="cancelDis()"
                  >Cancel</v-btn
                >
              </div>
              <p class="mb-0 font-weight-semi text-center pt-2">Disqualified</p>
            </div>
          </div>
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
          Waiting List
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
              v-if="props.item.play_now != 2"
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

      participants: [],
      allParticipants: [],
      tournament: null,
      category: null,
      currentMatch: 1,

      time: 0,
      timeStart: false,
      timePause: false,
      inputTime: null,
      settingTime: false,
      changeTime: false,

      redName: 'Player Red',
      redClub: 'Red Club',

      blueName: 'Player Blue',
      blueClub: 'Blue Club',

      dialogWinner: false,
      dialogWinnerTap: false,
      dialogDis: false,
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

      tempPointBlue: 0,
      tempAdvantageBlue: 0,
      tempFoulBlue: 0,

      tempPointRed: 0,
      tempAdvantageRed: 0,
      tempFoulRed: 0,
    }
  },
  computed: {
    redScore() {
      return this.$store.state.pbjiNewaza.redPoints
    },
    redAdvantages() {
      return this.$store.state.pbjiNewaza.redAdvantages
    },
    redFoul() {
      return this.$store.state.pbjiNewaza.redFouls
    },
    blueScore() {
      return this.$store.state.pbjiNewaza.bluePoints
    },
    blueAdvantages() {
      return this.$store.state.pbjiNewaza.blueAdvantages
    },
    blueFoul() {
      return this.$store.state.pbjiNewaza.blueFouls
    },
    mainTime() {
      return this.$store.state.pbjiNewaza.mainTime
    },
  },
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
    this.time = this.mainTime

    const data = this.$cookies.get('data_chart')
    if (data) {
      this.dataMain.martial_id = data.martial
      this.dataMain.tournament_id = data.tournament
      this.dataMain.category_id = data.category
    }

    this.getParticipant()
  },
  methods: {
    setTime(t) {
      const local = {
        time: t,
      }
      localStorage.setItem('mainTime', JSON.stringify(local))
    },
    startTime() {
      if (!this.timeStart) {
        this.timeStart = true
        this.timePause = false
        setTimeout(() => {
          const t = this.time - 1;
          this.time = t
          this.setTime(t)
        }, 1000)
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

    changeRedScore(value) {
      this.$store.commit('pbjiNewaza/setRedPoint', value)
      let local = localStorage.getItem('newazaRed')
      if (local != null) {
        local = JSON.parse(local)
        local.score = this.redScore
      } else {
        local = {
          score: this.redScore,
          advantage: 0,
          foul: 0,
        }
      }
      localStorage.setItem('newazaRed', JSON.stringify(local))
    },
    changeRedAdvantages(value) {
      this.$store.commit('pbjiNewaza/setRedAdvantages', value)
      let local = localStorage.getItem('newazaRed')
      if (local != null) {
        local = JSON.parse(local)
        local.advantage = this.redAdvantages
      } else {
        local = {
          score: 0,
          advantage: this.redAdvantages,
          foul: 0,
        }
      }
      localStorage.setItem('newazaRed', JSON.stringify(local))
    },
    changeRedFoul(value, type = null) {
      this.$store.commit('pbjiNewaza/setRedFoul', value)
      let local = localStorage.getItem('newazaRed')
      if (local != null) {
        local = JSON.parse(local)
        local.foul = this.redFoul
      } else {
        local = {
          score: 0,
          advantage: 0,
          foul: this.redFoul,
        }
      }
      localStorage.setItem('newazaRed', JSON.stringify(local))

      if (!type) {
        // Add Advantage
        if (value < 0) {
          if (this.redFoul === 1) {
            this.$store.commit('pbjiNewaza/setBlueAdvantages', -1)
            let local = localStorage.getItem('newazaBlue')
            if (local != null) {
              local = JSON.parse(local)
              local.advantage = this.blueAdvantages
            } else {
              local = {
                score: 0,
                advantage: this.blueAdvantages,
                foul: 0,
              }
            }
            localStorage.setItem('newazaBlue', JSON.stringify(local))
          } else if (this.redFoul === 2) {
            this.$store.commit('pbjiNewaza/setBluePoint', -2)
            let local = localStorage.getItem('newazaBlue')
            if (local != null) {
              local = JSON.parse(local)
              local.score = this.blueScore
            } else {
              local = {
                score: this.blueScore,
                advantage: 0,
                foul: 0,
              }
            }
            localStorage.setItem('newazaBlue', JSON.stringify(local))
          } else if (this.redFoul === 3) {
            this.cancelDis();
          }
        }

        if (value > 0) {
          if (this.redFoul === 2) {
            this.$store.commit('pbjiNewaza/setBlueAdvantages', 1)
            let local = localStorage.getItem('newazaBlue')
            if (local != null) {
              local = JSON.parse(local)
              local.advantage = this.blueAdvantages
            } else {
              local = {
                score: 0,
                advantage: this.blueAdvantages,
                foul: 0,
              }
            }
            localStorage.setItem('newazaBlue', JSON.stringify(local))
          } else if (this.redFoul === 3) {
            this.$store.commit('pbjiNewaza/setBluePoint', 2)
            let local = localStorage.getItem('newazaBlue')
            if (local != null) {
              local = JSON.parse(local)
              local.score = this.blueScore
            } else {
              local = {
                score: this.blueScore,
                advantage: 0,
                foul: 0,
              }
            }
            localStorage.setItem('newazaBlue', JSON.stringify(local))
          } else if (this.redFoul === 4) {
            this.setDis(1)
          }
        }
      }
    },

    changeBlueScore(value) {
      this.$store.commit('pbjiNewaza/setBluePoint', value)
      let local = localStorage.getItem('newazaBlue')
      if (local != null) {
        local = JSON.parse(local)
        local.score = this.blueScore
      } else {
        local = {
          score: this.blueScore,
          advantage: 0,
          foul: 0,
        }
      }
      localStorage.setItem('newazaBlue', JSON.stringify(local))
    },
    changeBlueAdvantages(value) {
      this.$store.commit('pbjiNewaza/setBlueAdvantages', value)
      let local = localStorage.getItem('newazaBlue')
      if (local != null) {
        local = JSON.parse(local)
        local.advantage = this.blueAdvantages
      } else {
        local = {
          score: 0,
          advantage: this.blueAdvantages,
          foul: 0,
        }
      }
      localStorage.setItem('newazaBlue', JSON.stringify(local))
    },
    changeBlueFoul(value, type = null) {
      this.$store.commit('pbjiNewaza/setBlueFoul', value)
      let local = localStorage.getItem('newazaBlue')
      if (local != null) {
        local = JSON.parse(local)
        local.foul = this.blueFoul
      } else {
        local = {
          score: 0,
          advantage: 0,
          foul: this.blueFoul,
        }
      }
      localStorage.setItem('newazaBlue', JSON.stringify(local))

      if (!type) {
        if (value < 0) {
          if (this.blueFoul === 1) {
            this.$store.commit('pbjiNewaza/setRedAdvantages', -1)
            let local = localStorage.getItem('newazaRed')
            if (local != null) {
              local = JSON.parse(local)
              local.advantage = this.redAdvantages
            } else {
              local = {
                score: 0,
                advantage: this.redAdvantages,
                foul: 0,
              }
            }
            localStorage.setItem('newazaRed', JSON.stringify(local))
          }
          if (this.blueFoul === 2) {
            this.$store.commit('pbjiNewaza/setRedPoint', -2)
            let local = localStorage.getItem('newazaRed')
            if (local != null) {
              local = JSON.parse(local)
              local.score = this.redScore
            } else {
              local = {
                score: this.redScore,
                advantage: 0,
                foul: 0,
              }
            }
            localStorage.setItem('newazaRed', JSON.stringify(local))
          }
          if (this.blueFoul === 3) {
            this.cancelDis()
          }
        }

        if (value > 0) {
          if (this.blueFoul === 2) {
            this.$store.commit('pbjiNewaza/setRedAdvantages', 1)
            let local = localStorage.getItem('newazaRed')
            if (local != null) {
              local = JSON.parse(local)
              local.advantage = this.redAdvantages
            } else {
              local = {
                score: 0,
                advantage: this.redAdvantages,
                foul: 0,
              }
            }
            localStorage.setItem('newazaRed', JSON.stringify(local))
          }
          if (this.blueFoul === 3) {
            this.$store.commit('pbjiNewaza/setRedPoint', 2)
            let local = localStorage.getItem('newazaRed')
            if (local != null) {
              local = JSON.parse(local)
              local.score = this.redScore
            } else {
              local = {
                score: this.redScore,
                advantage: 0,
                foul: 0,
              }
            }
            localStorage.setItem('newazaRed', JSON.stringify(local))
          }
          if (this.blueFoul === 4) {
            this.setDis(2)
          }
        }
      }

    },

    setWinner(winner) {
      let local = localStorage.getItem('dataWinner')
      this.winner = winner
      if (local != null) {
        local = JSON.parse(local)
        local.win = winner
        local.name = winner === 1 ? this.redName : this.blueName
        local.club = winner === 1 ? this.redClub : this.blueClub
        local.score = winner === 1 ? this.redScore : this.blueScore
        local.advantage =
          winner === 1 ? this.redAdvantages : this.blueAdvantages
        local.foul = winner === 1 ? this.redFoul : this.blueFoul
        local.show = true
        this.dialogWinner = true
      } else {
        local = {
          win: winner,
          name: winner === 1 ? this.redName : this.blueName,
          club: winner === 1 ? this.redClub : this.blueClub,
          score: winner === 1 ? this.redScore : this.blueScore,
          advantage: winner === 1 ? this.redAdvantages : this.blueAdvantages,
          foul: winner === 1 ? this.redFoul : this.blueFoul,
          show: true,
        }
        this.dialogWinner = true
      }

      localStorage.setItem('dataWinner', JSON.stringify(local))
      this.notifMsg = winner === 1 ? 'Red Win' : 'Blue Win'
      this.notifColor = winner === 1 ? 'primaryred' : 'primaryblue'
      this.notif = true

      this.pauseTime();
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

    setTapWinner(winner) {
      let point = null
      if (winner === 1) {
        this.tempPointRed = this.redScore;
        point = this.redScore
        point = 50 - point
        this.changeRedScore(point)

        this.blueReset()
      } else {
        this.tempPointBlue = this.blueScore;
        point = this.blueScore
        point = 50 - point
        this.changeBlueScore(point)

        this.redReset();
      }
      this.setWinner(winner)
      this.dialogWinner = false
      this.dialogWinnerTap = true

      this.pauseTime();
    },
    cancelTapWinner() {
      if (this.winner === 1) {
        this.cancelBlueReset();
        const point = this.tempPointRed - 50;
        this.changeRedScore(point)
      } else {
        this.cancelRedReset();
        const point = this.tempPointBlue - 50;
        this.changeBlueScore(point)
      }
      this.hideWinner();
    },

    redReset() {
      localStorage.removeItem('newazaRed')
      this.tempPointRed = this.redScore;
      this.tempAdvantageRed = this.redAdvantages;
      this.tempFoulRed = this.redFoul;
      this.changeRedScore(this.redScore * -1)
      this.changeRedAdvantages(this.redAdvantages * -1)
      this.changeRedFoul(this.redFoul * -1)
    },
    cancelRedReset() {
      this.changeRedScore(this.tempPointRed)
      this.changeRedAdvantages(this.tempAdvantageRed)
      this.changeRedFoul(this.tempFoulRed, 1)
    },
    blueReset() {
      localStorage.removeItem('newazaBlue')
      this.tempPointBlue = this.blueScore;
      this.tempAdvantageBlue = this.blueAdvantages;
      this.tempFoulBlue = this.blueFoul;
      this.changeBlueScore(this.blueScore * -1)
      this.changeBlueAdvantages(this.blueAdvantages * -1)
      this.changeBlueFoul(this.blueFoul * -1)
    },
    cancelBlueReset() {
      this.changeBlueScore(this.tempPointBlue)
      this.changeBlueAdvantages(this.tempAdvantageBlue)
      this.changeBlueFoul(this.tempFoulBlue, 1)
    },

    setDis(winner) {
      let point = null
      if (winner === 2) {
        this.tempPointRed = this.redScore;
        point = this.redScore
        point = 50 - point
        this.changeRedScore(point)

        this.tempPointBlue = this.blueScore;
        this.tempAdvantageBlue = this.blueAdvantages;
        this.changeBlueScore(this.blueScore * -1)
        this.changeBlueAdvantages(this.blueAdvantages * -1)
      } else {
        this.tempPointBlue = this.blueScore;
        point = this.blueScore
        point = 50 - point
        this.changeBlueScore(point)

        this.tempPointRed = this.redScore;
        this.tempAdvantageRed = this.redAdvantages;
        this.changeRedScore(this.redScore * -1)
        this.changeRedAdvantages(this.redAdvantages * -1)
      }

      let local = localStorage.getItem('dataDisqualified')
      this.disqualified = winner
      this.winner = winner === 1 ? 2 : 1
      if (local != null) {
        local = JSON.parse(local)
        local.name = winner === 1 ? this.redName : this.blueName
        local.club = winner === 1 ? this.redClub : this.blueClub
        local.score = winner === 1 ? this.redScore : this.blueScore
        local.advantage =
          winner === 1 ? this.redAdvantages : this.blueAdvantages
        local.foul = winner === 1 ? this.redFoul : this.blueFoul
        local.show = true
        this.dialogDis = true
      } else {
        local = {
          name: winner === 1 ? this.redName : this.blueName,
          club: winner === 1 ? this.redClub : this.blueClub,
          score: winner === 1 ? this.redScore : this.blueScore,
          advantage: winner === 1 ? this.redAdvantages : this.blueAdvantages,
          foul: winner === 1 ? this.redFoul : this.blueFoul,
          show: true,
        }
        this.dialogDis = true
      }

      localStorage.setItem('dataDisqualified', JSON.stringify(local))
      this.notifMsg = winner === 1 ? 'Red Disqualified' : 'Blue Disqualified'
      this.notifColor = winner === 1 ? 'primaryred' : 'primaryblue'
      this.notif = true

      this.pauseTime();
    },
    hideDis() {
      let local = localStorage.getItem('dataDisqualified')
      if (local != null) {
        local = JSON.parse(local)
        local.show = false
      } else {
        local = {
          show: false,
        }
      }
      this.dialogDis = false

      localStorage.setItem('dataDisqualified', JSON.stringify(local))
      this.notif = false
    },
    cancelDis() {
      if (this.disqualified === 1) {
        const point = this.tempPointBlue - 50;
        this.changeBlueScore(point)

        this.changeRedScore(this.tempPointRed)
        this.changeRedAdvantages(this.tempAdvantageRed)
        if (this.redFoul === 4) {
          this.changeRedFoul(-1, 1);
        }
      } else {
        const point = this.tempPointRed - 50;
        this.changeRedScore(point)

        this.changeBlueScore(this.tempPointBlue)
        this.changeBlueAdvantages(this.tempAdvantageBlue)
        if (this.blueFoul === 4) {
          this.changeBlueFoul(-1, 1);
        }
      }
      this.hideDis();
    },

    async getParticipant() {
      const localIsFullWaiting = localStorage.getItem('full_waiting_list');
      const url = '/api/game/list'
      const q = {
        category_id: this.dataMain.category_id,
      }
      this.participants = []
      this.allParticipants = []
      await this.$axios
        .get(url, { params: q })
        .then((result) => {
          if (result.data.data.length > 0) {
            let num = 1
            this.tournament = result.data.tournament.tournament_name
            this.category = result.data.category.category_name
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
              if (this.currentMatch === item.match_number) {
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
              }
              if (localIsFullWaiting && this.currentMatch < item.match_number) {
                  this.allParticipants.push({
                    chart_id: item.id,
                    red_name: item.red_name,
                    red_club: item.red_club,
                    blue_name: item.blue_name,
                    blue_club: item.blue_club,
                    play_now: item.play_now != null ? parseInt(item.play_now) : 0,
                    match: item.match_number,
                    game: item.game,
                    martial_id: item.martial_id,
                    category_id: item.category_id,
                    tournament_id: item.tournament_id,
                  });
                }
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
      const last = this.participants[this.participants.length - 1].chart_id
      this.participants.forEach((p) => {
        if (play === 0) {
          if (p.play_now === 1) {
            play = 1
            this.playing = true
            this.gameSaved = false
            this.setPlayer(p)
          } else if (last === p.chart_id) {
            const data = {
              id: null,
              red_name: '',
              red_club: '',
              blue_name: '',
              blue_club: '',
            }
            this.setWaitingList(data)
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

      const local = {
        redName: this.redName,
        redClub: this.redClub,
        blueName: this.blueName,
        blueClub: this.blueClub,
        tournament: this.tournament,
        category: this.category,
      }

      localStorage.setItem('newazaPlayer', JSON.stringify(local))
      this.setWaitingList(data)
    },
    setWaitingList(data) {
      let pre = null
      const wait = []
      this.participants.forEach((p) => {
        if (p.chart_id === data.id) {
          p.play_now = 1
        }
      })
      let prepareId = null
      for (let i = 0; i < this.participants.length; i++) {
        if (data.id != null) {
          if (this.participants[i].chart_id === data.id) {
            if (this.participants[i + 1]) {
              pre = {
                redName: this.participants[i + 1]?.red_name,
                redClub: this.participants[i + 1]?.red_club,
                blueName: this.participants[i + 1]?.blue_name,
                blueClub: this.participants[i + 1]?.blue_club,
              }
              prepareId = i + 1
            }
          }
        } else if (prepareId == null && this.participants[i].play_now === 0 && this.participants[i].red_name !== 'BYE' && this.participants[i].blue_name !== 'BYE') {
          pre = {
            redName: this.participants[i].red_name,
            redClub: this.participants[i].red_club,
            blueName: this.participants[i].blue_name,
            blueClub: this.participants[i].blue_club,
          }
          prepareId = i
        }
        if (i !== prepareId && this.participants[i].play_now === 0) {
          wait.push(this.participants[i])
        }
      }
      for (let i = 0; i < this.allParticipants.length; i++) {
        if (this.allParticipants[i]) {
          if (this.allParticipants[i].play_now === 0) {
            wait.push(this.allParticipants[i])
          }
        }
      }
      const local = {
        category: this.category,
        tournament: this.tournament,
        play: {
          redName: data.red_name,
          redClub: data.red_club,
          blueName: data.blue_name,
          blueClub: data.blue_club,
        },
        prepare: pre,
        waiting: wait,
      }
      localStorage.setItem('waitingList', JSON.stringify(local))
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
            this.tournament = result.data.tournament.tournament_name
            this.category = result.data.category.category_name
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
      this.hideWinner();
      this.hideDis();
      const url = '/api/game/save'
      const redPoint = {
        point: this.redScore,
        advantage: this.redAdvantages,
      }
      const redFoul = this.redFoul
      const bluePoint = {
        point: this.blueScore,
        advantage: this.blueAdvantages,
      }
      const blueFoul = this.blueFoul
      const q = {
        chart_id: data.chart_id,
        game_id: data.game.id,
        winner: this.winner,
        disqualified: this.disqualified,
        red_point: JSON.stringify(redPoint),
        red_foul: JSON.stringify(redFoul),
        blue_point: JSON.stringify(bluePoint),
        blue_foul: JSON.stringify(blueFoul),
      }

      if (this.winner !== null || this.disqualified !== null) {
        this.loadingSave = true
        await this.$axios
          .post(url, q)
          .then((result) => {
            this.getParticipant()
            this.redReset()
            this.blueReset()
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
      const redPoint = {
        point: this.redPoints,
        ippong1: this.redIppong1,
        ippong2: this.redIppong2,
        ippong3: this.redIppong3,
        washari: this.redWashari,
      }
      const redFoul = {
        shido: this.redShido,
        chui: this.redChui.length,
      }
      const bluePoint = {
        point: this.bluePoints,
        ippong1: this.blueIppong1,
        ippong2: this.blueIppong2,
        ippong3: this.blueIppong3,
        washari: this.blueWashari,
      }
      const blueFoul = {
        shido: this.blueShido,
        chui: this.blueChui.length,
      }
      const q = {
        chart_id: data.chart_id,
        game_id: data.game.id,
        winner: win,
        disqualified: null,
        red_point: JSON.stringify(redPoint),
        red_foul: JSON.stringify(redFoul),
        blue_point: JSON.stringify(bluePoint),
        blue_foul: JSON.stringify(blueFoul),
      }

      this.loadingSave = true
      await this.$axios
        .post(url, q)
        .then((result) => {
          this.getParticipant()
          this.redReset()
          this.blueReset()
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
