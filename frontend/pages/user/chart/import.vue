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
          Import Data Category
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
            <v-combobox
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
            ></v-combobox>
          </div>
          <div class="select-order mr-3">
            <v-text-field
              v-model="category"
              hide-details
              outlined
              placeholder="Category Name"
              dense
              auto
            ></v-text-field>
          </div>
          <div class="select-file mr-3">
            <v-file-input
              v-model="fileImport"
              placeholder="Select File (.xlsx)"
              outlined
              dense
              hide-details=""
              prepend-icon=""
              append-icon="mdi-file-table-outline"
              accept=".xlsx"
              @change="getDataFromExcel()"
            ></v-file-input>
          </div>
          <a
            ref="downloadTemplate"
            href="/template/Template-Import-Category.xlsx"
            download
            class="d-none"
          ></a>
          <v-btn
            x-small
            min-width="38px"
            class="px-1 rounded-8 align-self-center mr-3"
            @click="$refs.downloadTemplate.click()"
          >
            <v-icon class="text-18">mdi-tray-arrow-down</v-icon>
          </v-btn>
        </div>
        <!-- Pilihan Sheet dan Kategori Hasil Analisis AI -->
        <div v-if="availableSheets.length > 0" class="d-flex px-6 pb-4 align-center flex-wrap">
          <div class="mr-3 mb-2" style="width: 220px;">
            <v-select
              v-model="selectedSheet"
              :items="availableSheets"
              label="Select Sheet"
              hide-details
              outlined
              dense
              @change="analyzeSheetStructure()"
            ></v-select>
          </div>

          <div v-if="parsedCategories.length > 0" class="mr-3 mb-2" style="width: 320px;">
            <v-select
              v-model="selectedCategoryIndex"
              :items="parsedCategories.map((c, i) => ({ text: `${c.categoryName} (${c.players.length} Atlet)`, value: i }))"
              item-text="text"
              item-value="value"
              label="Pilih Kategori Hasil AI"
              hide-details
              outlined
              dense
              @change="selectCategory(selectedCategoryIndex)"
            ></v-select>
          </div>

          <v-btn
            v-if="fileImport"
            small
            outlined
            color="primaryred"
            class="rounded-8 mb-2 align-self-center"
            :loading="analyzing"
            @click="analyzeSheetStructure()"
          >
            <v-icon class="mr-2">mdi-auto-fix</v-icon> Re-Analyze with AI
          </v-btn>
        </div>
      </div>
    </div>
    <!-- Shuffle Data -->
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
          Shuffle Data
        </p>
      </div>
      <div class="mt-6 px-6">
        <div class="justify-space-between">
          <!-- Chart Left -->
          <div class="chart-shuffle">
            <div class="d-flex w-100 justify-space-between">
              <span
                class="text-16 height-24 font-weight-medium align-self-center"
                >Shuffle</span
              >
              <div class="d-flex">
                <v-btn
                  x-small
                  min-width="38px"
                  class="px-1 rounded-8 align-self-center mr-3"
                  :loading="shufflelingLeft"
                  @click="shuffleAll()"
                >
                  <v-icon class="text-18">mdi-repeat</v-icon>
                </v-btn>
              </div>
            </div>
            <v-simple-table ref="leftTable" class="mt-3">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Club</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(data, i) in tableLeft" :key="i">
                  <td>{{ data.Nama }}</td>
                  <td>{{ data.Club }}</td>
                  <td class="w-15">
                    <div class="d-flex">
                      <v-icon class="text-20 pointer" @click="deleteLeftData(i)"
                        >mdi-delete-outline</v-icon
                      >
                      <v-icon class="text-20 pointer ml-2" @click="moveRight(i)"
                        >mdi-swap-horizontal</v-icon
                      >
                    </div>
                  </td>
                </tr>
              </tbody>
            </v-simple-table>
          </div>
          <!-- Chart Right -->
          <div class="chart-shuffle">
            <!-- <div class="d-flex w-100 justify-space-between">
              <span
                class="text-16 height-24 font-weight-medium align-self-center"
                >Right/Down</span
              >
              <div class="d-flex">
                <v-btn
                  x-small
                  min-width="38px"
                  class="px-1 rounded-8 align-self-center mr-3"
                  :loading="shufflelingRight"
                  @click="shuffleRight()"
                >
                  <v-icon class="text-18">mdi-repeat</v-icon>
                </v-btn>
              </div>
            </div> -->
            <v-simple-table ref="rightTable">
              <!-- <thead>
                <tr>
                  <th>Name</th>
                  <th>Club</th>
                  <th class="w-10"></th>
                </tr>
              </thead> -->
              <tbody>
                <tr v-for="(data, i) in tableRight" :key="i">
                  <td>{{ data.Nama }}</td>
                  <td>{{ data.Club }}</td>
                  <td class="w-15">
                    <div class="d-flex">
                      <v-icon
                        class="text-20 pointer"
                        @click="deleteRightData(i)"
                        >mdi-delete-outline</v-icon
                      >
                      <v-icon class="text-20 pointer ml-2" @click="moveLeft(i)"
                        >mdi-swap-horizontal</v-icon
                      >
                    </div>
                  </td>
                </tr>
              </tbody>
            </v-simple-table>
          </div>
        </div>
        <div class="d-flex justify-end mt-6">
          <div class="d-flex">
            <!-- <v-btn
              small
              color="red darken-1"
              class="text-right mr-3 text-14 height-20 text-right rounded-8"
              >Cancel</v-btn
            > -->
            <v-btn
              small
              color="grey darken-1"
              class="text-right text-14 height-20 text-right rounded-8"
              @click="generateBracket()"
              >Make Tournament Chart</v-btn
            >
          </div>
        </div>
      </div>
    </div>
    <!-- Chart -->
    <div v-if="chart.length > 0" class="card-dashboard mb-6 pb-6 px-6">
      <client-only>
        <bracket ref="bracket" :rounds="chart">
          <template slot="player" slot-scope="{ player }">
            {{ player.name }}
          </template>
        </bracket>
      </client-only>
      <div class="d-flex justify-end">
        <v-btn
          small
          color="grey darken-1"
          class="text-right text-14 height-20 text-right rounded-8"
          :loading="loadingSave"
          @click="submitBracket()"
          >Save Chart</v-btn
        >
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
import * as XLSX from 'xlsx'
export default {
  name: 'CategoryImportPage',
  components: {
    [process.client && 'Bracket']: () => import('vue-tournament-bracket'),
  },
  layout: 'dashboard',
  middleware: 'login',
  data() {
    return {
      tableLeft: [],
      tableRight: [],

      staticDataLeft: [],
      staticDataRight: [],

      martial: null,
      martialItem: [],

      tournament: null,
      tournamentItem: [],

      category: null,
      categoryItem: [],

      fileImport: null,

      exelJson: null,

      notif: false,
      notifColor: 'dark',
      notifMsg: '',

      chart: [],

      bracket: null,
      games: null,

      loadingSave: false,
      shufflelingLeft: false,
      shufflelingRight: false,

      // New properties for AI Smart Import
      availableSheets: [],
      selectedSheet: null,
      parsedCategories: [],
      selectedCategoryIndex: 0,
      workbook: null,
      analyzing: false,
    }
  },
  mounted() {
    this.getMartial()
  },

  methods: {
    openPage(route) {
      route = 'http://localhost:3000' + route
      window.open(route, '_blank')
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
    getDataFromExcel() {
      if (!this.fileImport) return

      const reader = new FileReader()
      reader.onload = async (e) => {
        try {
          const data = new Uint8Array(e.target.result)
          const workbook = XLSX.read(data, { type: 'array' })
          
          this.workbook = workbook
          this.availableSheets = workbook.SheetNames
          this.selectedSheet = workbook.SheetNames[0]
          
          await this.analyzeSheetStructure()
        } catch (err) {
          this.notif = true
          this.notifColor = 'error'
          this.notifMsg = 'Error reading excel: ' + err.message
        }
      }
      reader.readAsArrayBuffer(this.fileImport)
    },
    async analyzeSheetStructure() {
      if (!this.workbook || !this.selectedSheet) return
      this.analyzing = true

      try {
        const sheet = this.workbook.Sheets[this.selectedSheet]
        const rawRows = XLSX.utils.sheet_to_json(sheet, { header: 1, defval: "" })
        
        // 1. Crop empty margins (padding)
        const cropped = this.cropEmptyMarginsJS(rawRows)
        
        // 2. Take preview (first 15 rows)
        const preview = cropped.slice(0, 15)
        
        // 3. Request parsing recipe from Groq AI
        const response = await this.$axios.$post('/api/parse-recipe', { preview })
        if (response.status === 'success') {
          const recipe = response.recipe
          
          // 4. Parse the sheet locally using the recipe
          const categories = this.executeRecipeJS(cropped, this.selectedSheet, recipe)
          this.parsedCategories = categories
          
          if (categories.length > 0) {
            this.selectedCategoryIndex = 0
            this.selectCategory(0)
          }
          
          this.notif = true
          this.notifColor = 'success'
          this.notifMsg = `Berhasil mendeteksi ${categories.length} kategori!`
        } else {
          throw new Error(response.message)
        }
      } catch (err) {
        this.notif = true
        this.notifColor = 'error'
        this.notifMsg = 'Gagal menganalisis struktur: ' + err.message
      } finally {
        this.analyzing = false
      }
    },
    cropEmptyMarginsJS(rows) {
      if (!rows || rows.length === 0) return []
      
      // Find first valid column
      let firstValidCol = rows[0].length
      rows.forEach((row) => {
        for (let c = 0; c < row.length; c++) {
          if (row[c] !== undefined && row[c] !== null && String(row[c]).trim() !== "") {
            if (c < firstValidCol) {
              firstValidCol = c
            }
          }
        }
      })
      
      if (firstValidCol === rows[0].length) return []
      
      // Slice left columns
      const croppedCols = rows.map(row => row.slice(firstValidCol))
      
      // Find first valid row
      let firstValidRow = -1
      for (let r = 0; r < croppedCols.length; r++) {
        const hasData = croppedCols[r].some(cell => cell !== undefined && cell !== null && String(cell).trim() !== "")
        if (hasData) {
          firstValidRow = r
          break
        }
      }
      
      if (firstValidRow === -1) return []
      
      return croppedCols.slice(firstValidRow)
    },
    executeRecipeJS(rows, sheetName, recipe) {
      const headerIdx = recipe.header_row_index
      const nameColIdx = recipe.column_mapping.name_column_index
      const clubColIdx = recipe.column_mapping.club_column_index
      const hasStacked = recipe.segmentation && recipe.segmentation.has_stacked_tables
      
      const categories = []
      let currentCategoryName = sheetName
      let currentPlayers = []
      
      const nameKeywords = ['nama', 'name', 'atlet', 'peserta']

      for (let i = headerIdx + 1; i < rows.length; i++) {
        const row = rows[i]
        const isEmpty = !row || row.every(cell => cell === undefined || cell === null || String(cell).trim() === "")
        
        if (isEmpty) {
          if (hasStacked && currentPlayers.length > 0) {
            categories.push({
              categoryName: currentCategoryName,
              players: [...currentPlayers]
            })
            currentPlayers = []
          }
          continue
        }
        
        if (hasStacked) {
          const nonEntries = row.filter(cell => cell !== undefined && cell !== null && String(cell).trim() !== "")
          if (nonEntries.length === 1 && isNaN(String(nonEntries[0]).trim())) {
            if (currentPlayers.length > 0) {
              categories.push({
                categoryName: currentCategoryName,
                players: [...currentPlayers]
              })
              currentPlayers = []
            }
            currentCategoryName = `${sheetName} - ${String(nonEntries[0]).trim()}`
            continue
          }
        }
        
        const nama = row[nameColIdx] ? String(row[nameColIdx]).trim() : ''
        const club = row[clubColIdx] ? String(row[clubColIdx]).trim() : ''
        
        if (nama && !nameKeywords.some(kw => nama.toLowerCase().includes(kw))) {
          currentPlayers.push({
            Nama: nama,
            Club: club || 'Tanpa Club'
          })
        }
      }
      
      if (currentPlayers.length > 0) {
        categories.push({
          categoryName: currentCategoryName,
          players: currentPlayers
        })
      }
      
      return categories
    },
    selectCategory(index) {
      this.selectedCategoryIndex = index
      const cat = this.parsedCategories[index]
      if (cat) {
        this.category = cat.categoryName
        this.distributePlayersToTables(cat.players)
      }
    },
    distributePlayersToTables(players) {
      const e1 = []
      const e2 = []
      const maxData = Math.ceil(players.length / 2)
      
      players.forEach((e) => {
        if (e.Club) {
          const same = this.findDuplicates(e.Club, e1)
          const same2 = this.findDuplicates(e.Club, e2)
          if (same) {
            e2.push(e)
          } else if (e1.length >= maxData) {
            if (same2) {
              e1.push(e)
            } else {
              e2.push(e)
            }
          } else {
            e1.push(e)
          }
          
          if (same && same2) {
            this.notif = true
            this.notifColor = 'error'
            this.notifMsg = e.Club + ' More than 2'
          }
        }
      })
      
      const diff = e1.length - maxData
      for (let i = 0; i < diff; i++) {
        e1.every((e, index) => {
          const same2 = this.findDuplicates(e.Club, e2)
          if (!same2) {
            e2.push(e1[index])
            e1.splice(index, 1)
            return false
          }
          return true
        })
      }
      
      this.tableLeft = e1
      this.tableRight = e2
      this.staticDataLeft = e1
      this.staticDataRight = e2
    },
    findDuplicates(data, arr) {
      if (data !== '') {
        return arr.find((item) => {
          const filterDate = item.Club.toLowerCase() === data.toLowerCase()
          return filterDate
        })
      } else {
        return []
      }
    },
    shuffle(arr) {
      const array = arr
      let currentIndex = array.length
      let randomIndex = 0

      // While there remain elements to shuffle.
      while (currentIndex !== 0) {
        // Pick a remaining element.
        randomIndex = Math.floor(Math.random() * currentIndex)
        currentIndex--

        // And swap it with the current element.
        ;[array[currentIndex], array[randomIndex]] = [
          array[randomIndex],
          array[currentIndex],
        ]
      }

      return array
    },

    moveRight(id) {
      this.tableRight.push(this.tableLeft[id])
      this.deleteLeftData(id)
    },
    moveLeft(id) {
      this.tableLeft.push(this.tableRight[id])
      this.deleteRightData(id)
    },
    deleteRightData(id) {
      this.tableRight.splice(id, 1)
    },
    deleteLeftData(id) {
      this.tableLeft.splice(id, 1)
    },

    shuffleAll() {
      this.shuffleLeft();
      this.shuffleRight();
    },
    shuffleLeft() {
      this.shufflelingLeft = true;
      const interval = setInterval(() => {
        const randomize = this.shuffle(this.tableLeft)
        this.tableLeft = []
        this.tableLeft = randomize
      }, 300);

      setTimeout(() => {
        clearInterval(interval);
        this.shufflelingLeft = false;
      }, 3000);
    },
    shuffleRight() {
      this.shufflelingRight = true;
      const interval = setInterval(() => {
        const randomize = this.shuffle(this.tableRight)
        this.tableRight = []
        this.tableRight = randomize
      }, 300);

      setTimeout(() => {
        clearInterval(interval);
        this.shufflelingRight = false;
      }, 3000);
    },

    generateBracket() {
      const brackets = [2, 4, 8, 16, 32, 64, 128, 256]
      const rounds = [1, 2, 3, 4, 5, 6, 7, 8]
      let bracket = 0
      const player =
        parseInt(this.tableRight.length) + parseInt(this.tableLeft.length)
      const p1 = []
      const p2 = []
      const match = []

      for (let i = 0; i < brackets.length; i++) {
        if (player <= brackets[i] && bracket === 0) {
          bracket = rounds[i]
        }
      }

      let b1 = 2 ** bracket / 2 - this.tableLeft.length
      let b2 = 2 ** bracket / 2 - this.tableRight.length

      let c1 = 0
      let c2 = 0

      const byePosLeft = parseInt(this.tableLeft.length / b1) + 1;
      const byePosRight = parseInt(this.tableRight.length / b2) + 1;

      const bye = {
        Nama: 'BYE',
        Club: 'BYE',
      }

      for (let i = 1; i <= 2 ** bracket / 2; i++) {
        if (b1 > 0 && i % byePosLeft === 0) {
          p1.push(bye)
          b1--
        } else if (c1 < this.tableLeft.length) {
          p1.push(this.tableLeft[c1])
          c1++
        }
      }
      for (let i = 1; i <= 2 ** bracket / 2; i++) {
        if (b2 > 0 && i % byePosRight === 0) {
          p2.push(bye)
          b2--
        } else if (c2 < this.tableRight.length) {
          p2.push(this.tableRight[c2])
          c2++
        }
      }

      this.tableLeft = p1
      this.tableRight = p2

      const allPlayer = []
      this.tableLeft.forEach((t) => {
        allPlayer.push(t)
      })
      this.tableRight.forEach((t) => {
        allPlayer.push(t)
      })

      let idx = 0

      for (let x = bracket + 1; x > 0; x--) {
        const games = []
        for (let y = 0; y < 2 ** x / 2; y++) {
          if (x === bracket + 1) {
            games.push({
              player1: {
                id: y + allPlayer[idx]?.Club,
                name: allPlayer[idx]?.Nama,
                winner: allPlayer[idx]?.Nama === 'BYE' ? null : true,
              },
              player2: {
                id: y + allPlayer[idx]?.Club,
                name: allPlayer[idx]?.Club,
                winner: allPlayer[idx]?.Nama === 'BYE' ? null : true,
              },
            })
            idx += 1
          } else {
            games.push({
              player1: {
                id: null,
                name: 'Waiting',
                club: 'Club',
                winner: null,
              },
              player2: {
                id: null,
                name: 'Club',
                club: 'Club',
                winner: null,
              },
            })
          }
        }
        match.push({ games })
      }

      this.chart = match

      this.saveChart()
    },

    saveChart() {
      const games = []
      let match = 1
      this.chart.forEach((c) => {
        const data = []
        c.games.forEach((g) => {
          data.push({
            id: g.player1.id,
            name: g.player1.name,
            club: g.player2.name,
            winner: false,
            match_number: match,
          })
        })
        games.push(data)
        match += 1
      })

      const charts = []
      games.forEach((g) => {
        for (let i = 0; i < g.length; i += 2) {
          if (g.length > 1) {
            charts.push({
              red_name: g[i].name === 'Waiting' ? null : g[i].name,
              red_club: g[i].club === 'Club' ? null : g[i].club,
              blue_name: g[i+1].name === 'Waiting' ? null : g[i+1].name,
              blue_club: g[i+1].club === 'Club' ? null : g[i+1].club,
              match_number: g[i].match_number,
            })
          } else {
            charts.push({
              red_name: g[i].name === 'Waiting' ? null : g[i].name,
              red_club: g[i].club === 'Club' ? null : g[i].club,
              blue_name: null,
              blue_club: null,
              match_number: g[i].match_number,
            })
            return;
          }
        }
      })

      this.games = games
      this.brackets = charts
    },

    submitBracket(isDonwload = false) {
      this.loadingSave = true;
      const url = '/api/save-bracket'
      const params = {
        martial_id: this.martial,
        tournament_name:
          typeof this.tournament === 'string' ? this.tournament : null,
        tournament_id:
          typeof this.tournament !== 'string' ? this.tournament.id : null,
        category_name: this.category,
        bracket: JSON.stringify(this.chart),
        games: this.brackets,
      }

      this.$axios.post(url, params).then((result) => {
        if (isDonwload) {
          this.$router.push(`/user/chart/detail?id=${result.id}`);
        }
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
  },
}
</script>

<style scoped>
@import '~/assets/styles.css';

.card-dashboard {
  max-width: 1000px;
  overflow: hidden;
  margin: 0px auto;
  background: linear-gradient(0deg, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)),
    #121212;
  box-shadow: 11px 11px 62px 7px #000000,
    -11px -11px 51px 1px rgba(48, 48, 48, 0.54);
  backdrop-filter: blur(14px);
  border-radius: 20px;
}

tbody {
  transition: 0.15s all ease;
}

/* .chart-shuffle {
  width: 450px;
} */

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

div >>> .vtb-player1 {
  border-radius: 8px 8px 0 0;
}
div >>> .vtb-player2 {
  border-radius: 0 0 8px 8px;
}

div >>> .vtb-item-players {
  background: transparent !important;
}
</style>
