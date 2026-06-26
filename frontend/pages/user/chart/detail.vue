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

    <!-- Custom Print Settings & Preview Dialog -->
    <v-dialog v-model="printDialog" max-width="950px">
      <v-card class="pa-4" style="background-color: #1e1e1e; color: white; border-radius: 12px;">
        <v-card-title class="headline font-weight-bold pb-2 white--text">
          Pengaturan & Pratinjau Cetak
        </v-card-title>
        <v-card-text class="pt-2">
          <v-row>
            <!-- Left: Settings Controls -->
            <v-col cols="12" md="5" class="pr-md-4">
              <v-container class="px-0 py-2">
                <!-- Orientation -->
                <v-row class="mb-4" no-gutters>
                  <v-col cols="12" class="pb-2">
                    <span class="grey--text text--lighten-1 text-subtitle-2 font-weight-medium">Orientasi Halaman</span>
                  </v-col>
                  <v-col cols="12">
                    <v-btn-toggle
                      v-model="printSettings.orientation"
                      mandatory
                      background-color="grey darken-3"
                      dark
                      dense
                      class="rounded-lg"
                    >
                      <v-btn value="landscape" color="primary" class="white--text">
                        Landscape
                      </v-btn>
                      <v-btn value="portrait" color="primary" class="white--text">
                        Portrait
                      </v-btn>
                    </v-btn-toggle>
                  </v-col>
                </v-row>

                <!-- Paper Size -->
                <v-row class="mb-4" no-gutters>
                  <v-col cols="12" class="pb-2">
                    <span class="grey--text text--lighten-1 text-subtitle-2 font-weight-medium">Ukuran Kertas</span>
                  </v-col>
                  <v-col cols="12">
                    <v-select
                      v-model="printSettings.paperSize"
                      :items="paperSizes"
                      item-text="text"
                      item-value="value"
                      dense
                      outlined
                      dark
                      hide-details
                      class="rounded-lg"
                    ></v-select>
                  </v-col>
                </v-row>

                <!-- Margin -->
                <v-row class="mb-4" no-gutters>
                  <v-col cols="12" class="pb-2">
                    <span class="grey--text text--lighten-1 text-subtitle-2 font-weight-medium">Margin</span>
                  </v-col>
                  <v-col cols="12">
                    <v-select
                      v-model="printSettings.margin"
                      :items="margins"
                      item-text="text"
                      item-value="value"
                      dense
                      outlined
                      dark
                      hide-details
                      class="rounded-lg"
                    ></v-select>
                  </v-col>
                </v-row>

                <!-- Scale -->
                <v-row class="mb-2" no-gutters>
                  <v-col cols="12" class="pb-2 d-flex justify-space-between">
                    <span class="grey--text text--lighten-1 text-subtitle-2 font-weight-medium">Skala (Scale / Zoom)</span>
                    <span class="primary--text font-weight-bold">{{ printSettings.scale }}%</span>
                  </v-col>
                  <v-col cols="12">
                    <v-slider
                      v-model="printSettings.scale"
                      min="50"
                      max="150"
                      step="5"
                      thumb-label
                      hide-details
                      dark
                    ></v-slider>
                  </v-col>
                </v-row>
              </v-container>
            </v-col>

            <!-- Right: Preview Area -->
            <v-col cols="12" md="7" class="d-flex flex-column align-center justify-center grey darken-4 pa-4 rounded-lg position-relative" style="min-height: 450px; overflow: hidden;">
              <span class="grey--text text-caption mb-2 position-absolute" style="top: 10px; left: 15px;">Pratinjau (Preview)</span>
              <div 
                class="print-preview-sheet elevation-4" 
                :style="previewSheetStyle"
              >
                <div 
                  class="print-preview-content" 
                  :style="previewContentStyle"
                  v-html="bracketHtml"
                ></div>
              </div>
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-actions class="justify-end pt-2">
          <v-btn text color="grey lighten-1" @click="printDialog = false">Batal</v-btn>
          <v-btn color="primary" class="px-6 rounded-lg font-weight-bold white--text" @click="confirmPrint">
            Cetak
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
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

      printDialog: false,
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
      bracketHtml: '',
      actualWidth: 1000,
      actualHeight: 600,
    }
  },
  computed: {
    gameChart() {
      return this.chart;
    },
    previewSheetStyle() {
      const isLandscape = this.printSettings.orientation === 'landscape';
      let ratio = 1.414; // Default A4
      if (this.printSettings.paperSize === 'letter') ratio = 1.294;
      if (this.printSettings.paperSize === 'legal') ratio = 1.647;
      if (this.printSettings.paperSize === 'A3') ratio = 1.414;

      let width = 450;
      let height = 450 / ratio;

      if (!isLandscape) {
        height = 450;
        width = 450 / ratio;
      }

      return {
        width: `${width}px`,
        height: `${height}px`,
        backgroundColor: '#ffffff',
        color: '#000000',
        position: 'relative',
        overflow: 'hidden',
        border: '1px solid #ccc',
        transition: 'all 0.3s ease',
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
      const bracketEl = document.getElementById('bracketData');
      if (bracketEl) {
        this.bracketHtml = bracketEl.innerHTML;
        this.actualWidth = bracketEl.scrollWidth || 1000;
        this.actualHeight = bracketEl.scrollHeight || 600;
      }
      this.printDialog = true;
    },
    confirmPrint() {
      const existingStyle = document.getElementById('print-dynamic-style');
      if (existingStyle) {
        existingStyle.remove();
      }

      const style = document.createElement('style');
      style.id = 'print-dynamic-style';

      let scaleCss = '';
      if (this.printSettings.scale !== 100) {
        const scaleVal = this.printSettings.scale / 100;
        scaleCss = `
          #bracketData {
            transform: scale(${scaleVal}) !important;
            transform-origin: top left !important;
            width: ${100 / scaleVal}% !important;
          }
        `;
      }

      style.innerHTML = `
        @media print {
          @page {
            size: ${this.printSettings.paperSize} ${this.printSettings.orientation} !important;
            margin: ${this.printSettings.margin} !important;
          }
          ${scaleCss}
        }
      `;
      document.head.appendChild(style);

      this.printDialog = false;
      setTimeout(() => {
        window.print();
      }, 500);
    },
    winData(data) {
      this.tempPlayer = this.chart[data.match]?.games[data.index];
      this.notif = true;
      this.notifColor = 'info';
      this.notifMsg = `Pemenang disalin: ${data.name}. Klik ikon arah panah di slot tujuan untuk menempel.`;
    },
    setWinData(data) {
      const tempChart = this.chart;
      const game = tempChart[data.match].games[data.index];
      game.player1.name = this.tempPlayer.player1.name;
      game.player2.name = this.tempPlayer.player2.name;
      if (game.player1) {
        game.player1.hidden = game.player1.name === 'BYE';
      }
      if (game.player2) {
        game.player2.hidden = game.player1.name === 'BYE';
      }
      this.tempPlayer = null;

      this.chart = []
      setTimeout(() => {
        this.chart = tempChart
      }, 100);

      this.notif = true;
      this.notifColor = 'success';
      this.notifMsg = 'Pemenang berhasil ditempel!';
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
  * {
    -webkit-print-color-adjust: exact !important;
    print-color-adjust: exact !important;
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
  .v-btn,
  .v-dialog__content,
  .v-dialog,
  .v-overlay,
  .v-overlay-container,
  .v-dialog__holder {
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

  /* Force connecting lines borders to be visible (black) in print */
  .vtb-item-child,
  .vtb-item-child::after,
  .vtb-item-child::before,
  .vtb-item-parent,
  .vtb-item-parent::after,
  .vtb-item-parent::before,
  .vtb-item,
  .vtb-item-players {
    border-color: #000000 !important;
  }
}

/* Print Preview Styles */
.print-preview-sheet {
  background-color: #ffffff !important;
  color: #000000 !important;
}

.print-preview-sheet * {
  color: #000000 !important;
  background-color: transparent !important;
  border-color: #000000 !important;
}

.print-preview-sheet .vtb-player {
  background-color: #ffffff !important;
  border: 1px solid #000000 !important;
}

.print-preview-sheet .player-hidden {
  visibility: hidden !important;
}

.print-preview-sheet h5 {
  color: #000000 !important;
  margin-top: 10px;
}
</style>
