<template>
  <div class="mt-8">
    <div class="print-hide">
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
          Tournament Chart
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
          <!-- Delete Tournament Button -->
          <v-btn
            v-if="tournament"
            x-small
            min-width="38px"
            class="px-1 rounded-8 align-self-center mr-3"
            color="red darken-4"
            title="Hapus Turnamen"
            @click="dialogDeleteTournament = true"
          >
            <v-icon class="text-18">mdi-delete</v-icon>
          </v-btn>
          <v-btn
            x-small
            min-width="38px"
            class="px-1 rounded-8 align-self-center mr-3"
            :loading="loadingGetData"
            @click="getChart()"
          >
            <v-icon class="text-18">mdi-magnify</v-icon>
          </v-btn>
          <!-- Print All Button -->
          <v-btn
            v-if="charts.length > 0"
            x-small
            color="primaryred"
            class="px-4 rounded-8 align-self-center white--text font-weight-semi text-capitalize"
            style="height: 38px;"
            :loading="loadingPrintAll"
            @click="printAll()"
          >
            <v-icon left size="18" class="mr-1">mdi-printer</v-icon>
            Print All
          </v-btn>
          <!-- Generate Link Button -->
          <v-btn
            v-if="tournament"
            x-small
            color="teal darken-1"
            class="px-4 rounded-8 align-self-center white--text font-weight-semi text-capitalize"
            style="height: 38px;"
            @click="generateRosterLink()"
          >
            <v-icon left size="18" class="mr-1">mdi-link-variant</v-icon>
            Generate Link
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
          List Chart
        </p>
      </div>
      <div class="mt-6 px-6">
        <v-simple-table class="mt-3 w-100">
          <thead>
            <tr>
              <th>Category</th>
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
                <div class="d-flex align-center">
                  <v-icon class="text-20 pointer" @click="openPage(data.id)"
                    >mdi-open-in-new</v-icon
                  >
                  <v-icon
                    class="text-20 pointer ml-3"
                    color="blue-grey lighten-2"
                    @click="editCategoryName(data)"
                    >mdi-pencil</v-icon
                  >
                  <v-icon
                    class="text-20 pointer ml-3"
                    color="red darken-1"
                    @click="deleteCategory(data)"
                    >mdi-delete</v-icon
                  >
                </div>
              </td>
            </tr>
          </tbody>
        </v-simple-table>
      </div>
    </div>

    <!-- Setting Bracket Hq -->
    <div v-if="loggedIn" class="card-dashboard mb-6 pb-6">
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
          Bracket HQ Live
        </p>
      </div>
      <div class="mt-6 px-6">
        <v-row>
          <v-col cols="12" md="4">
            <v-text-field
              v-model="embedUrl"
              hide-details
              outlined
              placeholder="Embed URL Bracket HQ"
              dense
              auto
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="4">
            <v-text-field
              v-model="embedTitle"
              hide-details
              outlined
              placeholder="Title"
              dense
              auto
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="4">
            <v-btn
              class="px-1 rounded-8 align-self-center mr-3"
              @click="saveBracket()"
            >Save</v-btn>
          </v-col>
        </v-row>
      </div>
    </div>
    </div>

    <!-- Dialog Delete Tournament Confirmation -->
    <v-dialog v-model="dialogDeleteTournament" max-width="450px">
      <v-card class="pa-4" style="background-color: #1e1e1e; color: white; border-radius: 12px;">
        <v-card-title class="headline font-weight-bold pb-2 white--text">
          Hapus Turnamen?
        </v-card-title>
        <v-card-text class="pt-2 white--text">
          Apakah Anda yakin ingin menghapus turnamen ini? Tindakan ini akan menghapus semua kategori, bagan (bracket), dan data pertandingan yang terkait secara permanen.
        </v-card-text>
        <v-card-actions class="justify-end pt-2">
          <v-btn text color="grey lighten-1" @click="dialogDeleteTournament = false">Batal</v-btn>
          <v-btn color="red darken-4" class="px-6 rounded-lg font-weight-bold white--text" :loading="loadingDeleteTournament" @click="deleteTournamentConfirm">
            Hapus
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Rename Category Dialog -->
    <v-dialog v-model="renameCategoryDialog" max-width="500px">
      <v-card class="pa-5" style="background: #1e1e1e; border-radius: 14px;">
        <v-card-title class="white--text font-weight-semi text-16 pb-2 px-0">
          <v-icon color="primaryred" class="mr-2">mdi-pencil</v-icon>
          Ubah Nama Bagan / Kategori
        </v-card-title>
        <v-card-text class="px-0 pt-2 pb-3">
          <v-text-field
            v-model="editCategoryNameInput"
            label="Nama Kategori"
            outlined
            dense
            dark
            hide-details
            class="mt-2"
          ></v-text-field>
        </v-card-text>
        <v-card-actions class="justify-end px-0 pb-0">
          <v-btn text color="grey lighten-1" @click="renameCategoryDialog = false">Batal</v-btn>
          <v-btn
            color="primaryred"
            class="white--text rounded-8 px-4 font-weight-bold"
            :loading="loadingRenameCategory"
            @click="submitRenameCategory"
          >
            Simpan
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Delete Category Dialog -->
    <v-dialog v-model="dialogDeleteCategory" max-width="500px">
      <v-card class="pa-5" style="background: #1e1e1e; border-radius: 14px;">
        <v-card-title class="white--text font-weight-bold text-16 pb-2 px-0">
          <v-icon color="red" class="mr-2">mdi-alert-circle</v-icon>
          Hapus Bagan / Kategori?
        </v-card-title>
        <v-card-text class="px-0 pt-2 pb-3 white--text">
          Apakah Anda yakin ingin menghapus bagan/kategori <strong>{{ activeDeleteCategory ? activeDeleteCategory.category_name : '' }}</strong>? Tindakan ini akan menghapus semua data pertandingan dan struktur bagan yang terkait secara permanen.
        </v-card-text>
        <v-card-actions class="justify-end px-0 pb-0">
          <v-btn text color="grey lighten-1" @click="dialogDeleteCategory = false">Batal</v-btn>
          <v-btn
            color="red darken-4"
            class="white--text rounded-8 px-6 font-weight-bold"
            :loading="loadingDeleteCategory"
            @click="deleteCategoryConfirm"
          >
            Hapus
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Roster Link Dialog -->
    <v-dialog v-model="rosterLinkDialog" max-width="560px">
      <v-card class="pa-5" style="background: #1e1e1e; border-radius: 14px;">
        <v-card-title class="white--text font-weight-semi text-16 pb-2 px-0">
          <v-icon color="teal" class="mr-2">mdi-link-variant</v-icon>
          Link Daftar Peserta
        </v-card-title>
        <v-card-text class="px-0 pt-2 pb-3">
          <p class="grey--text text-14 mb-3">Salin link di bawah ini dan bagikan. Halaman ini terbuka secara publik dan menampilkan seluruh peserta dalam turnamen beserta status pertandingannya.</p>
          <div class="d-flex align-center" style="gap: 8px;">
            <v-text-field
              v-model="rosterLink"
              readonly
              outlined
              dense
              hide-details
              dark
              class="roster-link-field"
              style="font-size: 13px;"
            ></v-text-field>
            <v-btn color="teal darken-1" class="white--text rounded-8 px-4" @click="copyRosterLink">
              <v-icon size="18" class="mr-1">mdi-content-copy</v-icon>
              Salin
            </v-btn>
          </div>
        </v-card-text>
        <v-card-actions class="justify-end px-0 pb-0">
          <v-btn text color="grey" @click="rosterLinkDialog = false">Tutup</v-btn>
          <v-btn color="teal darken-1" class="white--text rounded-8 px-4" :href="rosterLink" target="_blank">
            <v-icon size="16" class="mr-1">mdi-open-in-new</v-icon>
            Buka
          </v-btn>
        </v-card-actions>
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

    <!-- ═══════════════════════════════════════
         DIALOG: Pengaturan Cetak
    ═══════════════════════════════════════ -->
    <v-dialog v-model="printDialog" max-width="950px">
      <v-card class="card-dialog pa-6" dark style="background: #1e1e1e;">
        <v-card-title class="headline font-weight-semi pb-4 white--text px-0 pt-0">
          Pengaturan Cetak Semua Bagan
        </v-card-title>
        <v-card-text class="px-0">
          <v-row>
            <v-col cols="12" md="5" class="pr-md-6">
              <v-container class="px-0 py-0">
                <v-row class="mb-4" no-gutters>
                  <v-col cols="12" class="pb-2">
                    <span class="grey--text text-12 font-weight-semi" style="text-transform: uppercase; letter-spacing: 0.8px">Orientasi</span>
                  </v-col>
                  <v-col cols="12">
                    <v-btn-toggle v-model="printSettings.orientation" mandatory background-color="grey darken-3" dark dense class="rounded-8">
                      <v-btn value="landscape" class="text-capitalize font-weight-semi">Landscape</v-btn>
                      <v-btn value="portrait" class="text-capitalize font-weight-semi">Portrait</v-btn>
                    </v-btn-toggle>
                  </v-col>
                </v-row>
                <v-row class="mb-4" no-gutters>
                  <v-col cols="12" class="pb-2">
                    <span class="grey--text text-12 font-weight-semi" style="text-transform: uppercase; letter-spacing: 0.8px">Ukuran Kertas</span>
                  </v-col>
                  <v-col cols="12">
                    <v-select v-model="printSettings.paperSize" :items="paperSizes" item-text="text" item-value="value" dense outlined dark hide-details class="rounded-8"></v-select>
                  </v-col>
                </v-row>
                <v-row class="mb-4" no-gutters>
                  <v-col cols="12" class="pb-2">
                    <span class="grey--text text-12 font-weight-semi" style="text-transform: uppercase; letter-spacing: 0.8px">Margin</span>
                  </v-col>
                  <v-col cols="12">
                    <v-select v-model="printSettings.margin" :items="margins" item-text="text" item-value="value" dense outlined dark hide-details class="rounded-8"></v-select>
                  </v-col>
                </v-row>
                <v-row class="mb-2" no-gutters>
                  <v-col cols="12" class="pb-2 d-flex justify-space-between align-center">
                    <span class="grey--text text-12 font-weight-semi" style="text-transform: uppercase; letter-spacing: 0.8px">Skala</span>
                    <span class="primaryred--text font-weight-semi text-14">{{ printSettings.scale }}%</span>
                  </v-col>
                  <v-col cols="12">
                    <v-slider v-model="printSettings.scale" min="50" max="150" step="5" thumb-label hide-details dark color="primaryred"></v-slider>
                  </v-col>
                </v-row>
              </v-container>
            </v-col>
            <v-col cols="12" md="7" class="d-flex flex-column align-center justify-center pa-4 rounded-8 position-relative" style="min-height: 420px; overflow: hidden; background: rgba(0,0,0,0.4)">
              <div class="print-preview-sheet elevation-4" :style="previewSheetStyle">
                <!-- eslint-disable-next-line vue/no-v-html -->
                <div class="print-preview-content" v-html="previewFirstBracketHtml"></div>
              </div>
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-actions class="justify-end pt-4 px-0">
          <v-btn text color="grey" class="text-capitalize mr-2" @click="printDialog = false">Batal</v-btn>
          <v-btn color="primaryred" class="rounded-8 text-capitalize font-weight-semi white--text px-6" @click="confirmPrint">Cetak Semua</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Hidden Print Container for Single/Sequential Printing -->
    <div id="singleBracketPrintData" class="print-all-only">
      <div v-if="activePrintCategory" class="bracket-page-break">
        <div class="bracket-print-title">
          {{ activePrintCategory.categoryName }}
        </div>
        <client-only>
          <bracket :rounds="activePrintCategory.bracket">
            <template slot="player" slot-scope="{ player }">
              <p class="bg-white mb-0 pa-0" :class="{ 'player-hidden': player.hidden, 'player-get-bye': player.isGetBye }">
                {{ player.name }}
              </p>
            </template>
          </bracket>
        </client-only>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ChartPage',
  components: {
    [process.client && 'Bracket']: () => import('vue-tournament-bracket'),
  },
  layout: 'dashboard',
  middleware: 'login',
  data() {
    return {
      martial: null,
      martialItem: [],

      tournament: null,
      tournamentItem: [],

      dialogDeleteTournament: false,
      loadingDeleteTournament: false,

      charts: [],
      loadingGetData: false,

      embedUrl: null,
      embedTitle: null,

      notif: false,
      notifColor: 'dark',
      notifMsg: '',

      // Roster link
      rosterLinkDialog: false,
      rosterLink: '',

      // Rename category
      renameCategoryDialog: false,
      loadingRenameCategory: false,
      editCategoryNameInput: '',
      activeEditCategory: null,

      // Delete category
      dialogDeleteCategory: false,
      loadingDeleteCategory: false,
      activeDeleteCategory: null,

      // Print settings variables
      loadingPrintAll: false,
      printDialog: false,
      printBracketsList: [],
      activePrintCategory: null,
      printSettings: {
        orientation: 'landscape',
        paperSize: 'A4',
        margin: '10mm',
        scale: 100,
      },
      paperSizes: [
        { text: 'A4 (210 x 297 mm)', value: 'A4' },
        { text: 'Letter (8.5 x 11 in)', value: 'letter' },
        { text: 'Legal (8.5 x 14 in)', value: 'legal' },
        { text: 'A3 (297 x 420 mm)', value: 'A3' },
      ],
      margins: [
        { text: 'Default (10mm)', value: '10mm' },
        { text: 'Tanpa Margin (0mm)', value: '0mm' },
        { text: 'Minimum (5mm)', value: '5mm' },
        { text: 'Lebar (20mm)', value: '20mm' },
      ],
      actualWidth: 1000,
      actualHeight: 600,
    }
  },
  computed: {
    loggedIn() {
      return this.$cookies.get('user_auth');
    },
    previewSheetStyle() {
      const isLandscape = this.printSettings.orientation === 'landscape';
      let ratio = 1.414; // Default A4
      if (this.printSettings.paperSize === 'letter') ratio = 1.294;
      if (this.printSettings.paperSize === 'legal') ratio = 1.647;
      if (this.printSettings.paperSize === 'A3') ratio = 1.414;

      let sheetWidth = 450;
      let sheetHeight = 450 * ratio;
      if (isLandscape) {
        sheetWidth = 450 * ratio;
        sheetHeight = 450;
      }

      return {
        width: `${sheetWidth}px`,
        height: `${sheetHeight}px`,
        position: 'relative',
        overflow: 'hidden',
        border: '1px solid #d3d3d3',
        backgroundColor: '#ffffff',
        transform: 'scale(0.8)',
        transformOrigin: 'center center',
      };
    },
    previewContentStyle() {
      if (!this.actualWidth) return {};

      const isLandscape = this.printSettings.orientation === 'landscape';
      let ratio = 1.414;
      if (this.printSettings.paperSize === 'letter') ratio = 1.294;
      if (this.printSettings.paperSize === 'legal') ratio = 1.647;

      let sheetWidth = 450;
      if (!isLandscape) {
        sheetWidth = 450 / ratio;
      }

      let marginVal = 10; // default 10mm
      if (this.printSettings.margin === '0mm') marginVal = 0;
      if (this.printSettings.margin === '5mm') marginVal = 5;
      if (this.printSettings.margin === '20mm') marginVal = 20;

      const realPageWidthMm = isLandscape ? (this.printSettings.paperSize === 'legal' ? 355.6 : 297) : 210;
      const marginPx = (marginVal / realPageWidthMm) * sheetWidth;

      const availableWidth = sheetWidth - (marginPx * 2);

      const baseScale = availableWidth / this.actualWidth;
      const userScale = this.printSettings.scale / 100;
      const finalScale = baseScale * userScale;

      return {
        transform: `scale(${finalScale})`,
        transformOrigin: 'top left',
        position: 'absolute',
        top: `${marginPx}px`,
        left: `${marginPx}px`,
        width: `${this.actualWidth}px`,
        height: `${this.actualHeight}px`,
        pointerEvents: 'none',
      };
    },
    previewFirstBracketHtml() {
      if (this.printBracketsList.length === 0) return '';
      return `
        <div style="padding: 24px; text-align: center; color: black; font-family: 'Poppins', sans-serif;">
          <h3 style="margin-bottom: 8px; font-weight: 700; font-size: 16px;">Pratinjau Cetak Semua</h3>
          <p style="color: #666; font-size: 13px;">Total: <strong>${this.printBracketsList.length} Kategori</strong> akan dicetak masing-masing pada satu halaman.</p>
          <div style="margin-top: 15px; border: 1px dashed #ccc; padding: 12px; border-radius: 8px; display: inline-block; font-size: 12px; line-height: 1.6;">
            Orientasi: <strong>${this.printSettings.orientation.toUpperCase()}</strong><br/>
            Ukuran: <strong>${this.printSettings.paperSize.toUpperCase()}</strong><br/>
            Margin: <strong>${this.printSettings.margin}</strong>
          </div>
        </div>
      `;
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

    deleteTournamentConfirm() {
      if (!this.tournament) return;
      this.loadingDeleteTournament = true
      const url = '/api/tournament/delete'
      const params = {
        id: this.tournament
      }
      this.$axios.post(url, params)
        .then((result) => {
          this.loadingDeleteTournament = false
          this.dialogDeleteTournament = false
          this.notif = true
          this.notifColor = 'success'
          this.notifMsg = 'Tournament successfully deleted'
          
          // Clear tournament selection & charts list
          this.tournament = null
          this.charts = []

          // Refresh tournament list
          this.getTournament()
        })
        .catch((err) => {
          if (err.response && err.response.status === 404) {
            this.loadingDeleteTournament = false
            this.dialogDeleteTournament = false
            this.notif = true
            this.notifColor = 'warning'
            this.notifMsg = 'Turnamen disembunyikan secara permanen di browser ini (Backend 404)'
            
            let hidden = localStorage.getItem('hidden_tournaments')
            hidden = hidden ? JSON.parse(hidden) : []
            if (!hidden.includes(this.tournament)) {
              hidden.push(this.tournament)
            }
            localStorage.setItem('hidden_tournaments', JSON.stringify(hidden))

            this.tournamentItem = this.tournamentItem.filter((t) => t.id !== this.tournament)
            this.tournament = null
            this.charts = []
            return
          }
          this.loadingDeleteTournament = false
          this.dialogDeleteTournament = false
          this.notif = true
          this.notifColor = 'error'
          this.notifMsg = 'Error Deleting Tournament: ' + err
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

    editCategoryName(category) {
      this.activeEditCategory = category;
      this.editCategoryNameInput = category.category_name;
      this.renameCategoryDialog = true;
    },

    async submitRenameCategory() {
      if (!this.editCategoryNameInput || !this.editCategoryNameInput.trim()) {
        this.notif = true;
        this.notifColor = 'error';
        this.notifMsg = 'Nama kategori tidak boleh kosong!';
        return;
      }

      this.loadingRenameCategory = true;
      try {
        const payload = {
          id: this.activeEditCategory.id,
          category_name: this.editCategoryNameInput.trim()
        };
        const res = await this.$axios.$post('/api/category/rename', payload);
        
        // Update local chart list state
        const index = this.charts.findIndex(c => c.id === this.activeEditCategory.id);
        if (index !== -1) {
          this.charts[index].category_name = res.data.category_name;
        }

        this.renameCategoryDialog = false;
        this.notif = true;
        this.notifColor = 'success';
        this.notifMsg = 'Nama bagan berhasil diubah!';
      } catch (err) {
        this.notif = true;
        this.notifColor = 'error';
        this.notifMsg = err.response?.data?.message || 'Gagal mengubah nama bagan.';
      } finally {
        this.loadingRenameCategory = false;
      }
    },

    deleteCategory(category) {
      this.activeDeleteCategory = category;
      this.dialogDeleteCategory = true;
    },

    async deleteCategoryConfirm() {
      if (!this.activeDeleteCategory) return;

      this.loadingDeleteCategory = true;
      try {
        await this.$axios.$post('/api/category/delete', {
          id: this.activeDeleteCategory.id
        });

        // Remove from local chart list state
        this.charts = this.charts.filter(c => c.id !== this.activeDeleteCategory.id);

        this.dialogDeleteCategory = false;
        this.notif = true;
        this.notifColor = 'success';
        this.notifMsg = 'Bagan / Kategori berhasil dihapus!';
      } catch (err) {
        this.notif = true;
        this.notifColor = 'error';
        this.notifMsg = err.response?.data?.message || 'Gagal menghapus bagan / kategori.';
      } finally {
        this.loadingDeleteCategory = false;
      }
    },

    generateRosterLink() {
      const base = window.location.origin;
      this.rosterLink = `${base}/bracket-roster?tournament_id=${this.tournament}`;
      this.rosterLinkDialog = true;
    },

    async copyRosterLink() {
      try {
        await navigator.clipboard.writeText(this.rosterLink);
        this.notif = true;
        this.notifColor = 'success';
        this.notifMsg = 'Link berhasil disalin!';
      } catch (e) {
        this.notif = true;
        this.notifColor = 'error';
        this.notifMsg = 'Gagal menyalin link.';
      }
    },

    loadHtml2Pdf() {
      return new Promise((resolve, reject) => {
        if (window.html2pdf) {
          resolve(window.html2pdf);
          return;
        }
        const script = document.createElement('script');
        script.src = 'https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js';
        script.onload = () => resolve(window.html2pdf);
        script.onerror = (err) => reject(err);
        document.head.appendChild(script);
      });
    },

    async printAll() {
      if (this.charts.length === 0) return;
      this.loadingPrintAll = true;
      this.printBracketsList = [];
      try {
        const fetchedBrackets = [];
        for (const cat of this.charts) {
          try {
            const detailUrl = `/api/bracket/detail?id=${cat.id}`;
            const res = await this.$axios.get(detailUrl);
            
            // Safe unwrap of Axios response or direct payload
            const payload = res && res.data ? res.data : res;
            if (payload && payload.data && payload.data.brackets) {
              const bracketData = JSON.parse(payload.data.brackets);
              
              if (Array.isArray(bracketData)) {
                // Preprocess players hidden / getBye status
                bracketData.forEach((dat, i) => {
                  if (dat && Array.isArray(dat.games)) {
                    dat.games.forEach((g, index) => {
                      if (g && g.player1) {
                        g.player1.match = i;
                        g.player1.index = index;
                        g.player1.setting = true;
                        g.player1.hidden = g.player1.name === 'BYE';

                        const opp = dat.games[index + 1];
                        g.player1.isGetBye = opp?.player1?.name === 'BYE';
                      }
                    });
                  }
                });

                fetchedBrackets.push({
                  categoryName: cat.category_name,
                  bracket: bracketData
                });
              }
            }
          } catch (itemErr) {
            // eslint-disable-next-line no-console
            console.error(`Gagal memuat kategori ${cat.category_name}:`, itemErr);
          }
        }
        
        if (fetchedBrackets.length === 0) {
          this.notif = true;
          this.notifColor = 'warning';
          this.notifMsg = 'Belum ada bagan yang disimpan untuk turnamen ini.';
          return;
        }

        this.printBracketsList = fetchedBrackets;
        this.printDialog = true;
      } catch (err) {
        // eslint-disable-next-line no-console
        console.error('Error print all:', err);
        this.notif = true;
        this.notifColor = 'error';
        this.notifMsg = 'Gagal memuat detail bagan untuk pencetakan.';
      } finally {
        this.loadingPrintAll = false;
      }
    },

    async confirmPrint() {
      this.printDialog = false;
      this.loadingPrintAll = true;

      try {
        const html2pdf = await this.loadHtml2Pdf();
        document.body.classList.add('printing-all-active');

        for (let i = 0; i < this.printBracketsList.length; i++) {
          const category = this.printBracketsList[i];
          this.activePrintCategory = category;

          // Wait for Vue to update the DOM with the active category
          await this.$nextTick();

          // Wait a short moment to ensure everything is mounted and calculated
          await new Promise((resolve) => setTimeout(resolve, 400));

          const element = document.getElementById('singleBracketPrintData');
          if (!element) continue;

          // Convert margin to numeric
          const marginNum = parseInt(this.printSettings.margin) || 0;

          // Calculate scale (multiply by 2 for high definition/crisp output)
          const scaleVal = (this.printSettings.scale / 100) * 2;

          const opt = {
            margin: marginNum,
            filename: `${category.categoryName}.pdf`,
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: {
              scale: scaleVal,
              useCORS: true,
              backgroundColor: '#ffffff'
            },
            jsPDF: {
              unit: 'mm',
              format: this.printSettings.paperSize.toLowerCase(),
              orientation: this.printSettings.orientation
            }
          };

          // Save the PDF directly
          await html2pdf().set(opt).from(element).save();

          // Short pause before starting the next one to avoid bottlenecking the browser
          await new Promise((resolve) => setTimeout(resolve, 300));
        }

        this.notif = true;
        this.notifColor = 'success';
        this.notifMsg = 'Semua file PDF berhasil diunduh!';
      } catch (err) {
        // eslint-disable-next-line no-console
        console.error('Error generating PDF:', err);
        this.notif = true;
        this.notifColor = 'error';
        this.notifMsg = 'Gagal mengunduh file PDF.';
      } finally {
        document.body.classList.remove('printing-all-active');
        this.activePrintCategory = null;
        this.loadingPrintAll = false;
      }
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

/* ── Print settings preview sheet ── */
.print-preview-sheet {
  background-color: #ffffff !important;
  color: #000000 !important;
}

.print-preview-sheet * {
  color: #000000 !important;
  background-color: transparent !important;
  border-color: #000000 !important;
}

/* ── Print-all utility classes ── */
div >>> .print-all-only {
  display: none !important;
}

body.printing-all-active div >>> .print-all-only {
  display: block !important;
  position: absolute !important;
  left: -9999px !important;
  top: -9999px !important;
  width: max-content !important;
  background-color: #ffffff !important;
  color: #000000 !important;
  z-index: -9999 !important;
}

body.printing-all-active .print-hide {
  display: none !important;
}

@media print {
  body:not(.printing-all-active) div >>> .print-all-only {
    display: none !important;
  }
  
  body.printing-all-active .print-hide {
    display: none !important;
  }
  
  body.printing-all-active #minimal-header-container,
  body.printing-all-active .step-nav,
  body.printing-all-active .v-navigation-drawer,
  body.printing-all-active .v-app-bar,
  body.printing-all-active .v-footer,
  body.printing-all-active .icon-win,
  body.printing-all-active .v-btn,
  body.printing-all-active .card-dashboard {
    display: none !important;
  }

  body.printing-all-active div >>> .print-all-only {
    display: block !important;
    position: static !important;
    left: auto !important;
    top: auto !important;
    width: max-content !important;
    max-width: none !important;
    overflow: visible !important;
  }
  body.printing-all-active div >>> .bracket-page-break {
    page-break-after: always !important;
    page-break-inside: avoid !important;
    break-after: page !important;
    position: relative !important;
    width: max-content !important;
    background-color: #ffffff !important;
    color: #000000 !important;
    margin-bottom: 0 !important;
    padding: 20px 0 !important;
    display: block !important;
  }
  body.printing-all-active .bracket-print-title {
    color: #000000 !important;
    font-size: 24px !important;
    margin-bottom: 30px !important;
    display: block !important;
    text-align: center !important;
    font-family: 'Poppins', sans-serif !important;
    font-weight: 700 !important;
  }
  
  /* Reset layout wrappers for print */
  body.printing-all-active, 
  body.printing-all-active html, 
  body.printing-all-active #__nuxt, 
  body.printing-all-active #__layout,
  body.printing-all-active .v-application, 
  body.printing-all-active .v-application--wrap,
  body.printing-all-active .v-main, 
  body.printing-all-active .v-main__wrap, 
  body.printing-all-active .v-container {
    background-color: #ffffff !important;
    background: #ffffff !important;
    color: #000000 !important;
    box-shadow: none !important;
    border: none !important;
    margin: 0 !important;
    padding: 0 !important;
    height: auto !important;
    min-height: auto !important;
    width: auto !important;
    max-width: none !important;
    overflow: visible !important;
    display: block !important;
    position: static !important;
  }
  
  /* Reset player card style in print */
  body.printing-all-active div >>> .vtb-player {
    color: #000000 !important;
    background-color: #ffffff !important;
    border: 1px solid #000000 !important;
    border-radius: 8px !important;
    padding: 8px 12px !important;
    height: 52px !important;
    display: flex !important;
    flex-direction: column !important;
    justify-content: center !important;
  }
  
  body.printing-all-active div >>> .vtb-item-players {
    background: transparent !important;
  }
  
  body.printing-all-active div >>> .vtb-item-child,
  body.printing-all-active div >>> .vtb-item-child::after,
  body.printing-all-active div >>> .vtb-item-child::before,
  body.printing-all-active div >>> .vtb-item-parent,
  body.printing-all-active div >>> .vtb-item-parent::after,
  body.printing-all-active div >>> .vtb-item-parent::before,
  body.printing-all-active div >>> .vtb-item {
    border-color: #000000 !important;
  }
}
</style>
