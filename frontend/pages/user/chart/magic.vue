<template>
  <div class="mt-8 sandbox-container">

    <!-- Back link — matches chart/index.vue style exactly -->
    <div id="minimal-header-container" class="card-dashboard mb-6 pb-6">
      <p
        class="pl-6 pt-6 mb-0 back-link font-weight-semi text-14 height-28 pointer d-inline-flex align-center"
        @click="handleHeaderBack()"
      >
        <v-icon class="text-16 mr-1">mdi-arrow-left</v-icon> Kembali ke Dashboard
      </p>
      <p
        class="pl-6 pt-2 mb-0 white--text font-weight-semi text-18"
      >
        Magic Bracket (Automated Generator)
      </p>
    </div>

    <!-- ═══════════════════════════════════════
         INFORMASI TURNAMEN
    ═══════════════════════════════════════ -->
    <div class="print-hide mb-6">
      <div class="card-dashboard pa-6">
        <p class="white--text font-weight-semi text-16 mb-4">
          <v-icon color="primaryred" class="mr-2">mdi-trophy-outline</v-icon>
          Informasi Turnamen &amp; Cabor
        </p>
        <v-row>
          <v-col cols="12" md="6">
            <v-select
              v-model="selectedMartialId"
              :items="martialItems"
              item-text="name"
              item-value="id"
              outlined
              dense
              hide-details
              label="Cabang Olahraga (Cabor)"
              placeholder="Pilih Cabor"
              dark
              class="rounded-8"
              append-icon="mdi-chevron-down"
            ></v-select>
          </v-col>
          <v-col cols="12" md="6">
            <v-text-field
              v-model="tournamentName"
              outlined
              dense
              hide-details
              label="Nama Turnamen"
              placeholder="Contoh: Kejuaraan Ju-Jitsu Surabaya 2026"
              dark
              class="rounded-8"
            ></v-text-field>
          </v-col>
        </v-row>
      </div>
    </div>

    <!-- ═══════════════════════════════════════
         STEP 1: KONFIGURASI KATEGORI (high-fidelity card panels)
    ═══════════════════════════════════════ -->
    <div class="print-hide mb-6">
      <div class="card-dashboard pb-6">
        
        <!-- Beautiful 3-column Card Panel Grid -->
        <v-row class="px-6 pt-6">
          
          <!-- Column 1: Nomor Tanding -->
          <v-col cols="12" md="4" class="d-flex flex-column">
            <div class="rules-card-panel">
              <div class="rules-card-header">
                <v-icon small color="primaryred" class="mr-2">mdi-sword-cross</v-icon>
                <span class="rules-card-title">Nomor Tanding</span>
              </div>
              <div class="rules-card-body">
                <div v-if="rules.matchTypes.length === 0" class="text-center py-8 grey--text text-13">
                  Belum ada nomor pertandingan.
                </div>
                <div v-else>
                  <div v-for="(rule, idx) in rules.matchTypes" :key="'mt-' + idx" class="rules-card-row">
                    <v-text-field
                      v-model="rules.matchTypes[idx]"
                      dense outlined hide-details
                      placeholder="Nama nomor tanding"
                      dark
                    ></v-text-field>
                    <v-btn
                      icon x-small
                      color="rgba(255,255,255,0.3)"
                      :disabled="rules.matchTypes.length <= 1"
                      @click="removeMatchTypeRule(idx)"
                    >
                      <v-icon size="14">mdi-close</v-icon>
                    </v-btn>
                  </div>
                </div>
              </div>
              <div class="rules-card-footer">
                <button class="rules-add-btn" @click="addMatchTypeRule()">
                  <v-icon x-small color="primaryred">mdi-plus</v-icon>
                  Tambah Kategori
                </button>
              </div>
            </div>
          </v-col>

          <!-- Column 2: Kelompok Usia -->
          <v-col cols="12" md="4" class="d-flex flex-column">
            <div class="rules-card-panel">
              <div class="rules-card-header">
                <v-icon small color="primaryred" class="mr-2">mdi-account-group-outline</v-icon>
                <span class="rules-card-title">Kelompok Usia</span>
              </div>
              <div class="rules-card-body">
                <div v-if="rules.ageGroups.length === 0" class="text-center py-8 grey--text text-13">
                  Belum ada kelompok usia.
                </div>
                <div v-else>
                  <div v-for="(rule, idx) in rules.ageGroups" :key="'ag-' + idx" class="rules-card-row">
                    <v-text-field
                      v-model="rule.name"
                      dense outlined hide-details
                      placeholder="Nama (cth: U18)"
                      dark
                    ></v-text-field>
                    
                    <div class="rules-range-box">
                      <v-text-field
                        v-model.number="rule.min"
                        type="number" dense outlined hide-details
                        placeholder="Min"
                        dark
                        class="rules-input-num"
                      ></v-text-field>
                      <span class="rules-range-sep">-</span>
                      <v-text-field
                        v-model.number="rule.max"
                        type="number" dense outlined hide-details
                        placeholder="Max"
                        dark
                        class="rules-input-num"
                      ></v-text-field>
                    </div>

                    <v-btn
                      icon x-small
                      color="rgba(255,255,255,0.3)"
                      :disabled="rules.ageGroups.length <= 1"
                      @click="removeAgeRule(idx)"
                    >
                      <v-icon size="14">mdi-close</v-icon>
                    </v-btn>
                  </div>
                </div>
              </div>
              <div class="rules-card-footer">
                <button class="rules-add-btn" @click="addAgeRule()">
                  <v-icon x-small color="primaryred">mdi-plus</v-icon>
                  Tambah Usia
                </button>
              </div>
            </div>
          </v-col>

          <!-- Column 3: Kelas Berat -->
          <v-col cols="12" md="4" class="d-flex flex-column">
            <div class="rules-card-panel">
              <div class="rules-card-header">
                <v-icon small color="primaryred" class="mr-2">mdi-weight-kilogram</v-icon>
                <span class="rules-card-title">Kelas Berat Badan</span>
              </div>
              <div class="rules-card-body">
                <div v-if="rules.weightClasses.length === 0" class="text-center py-8 grey--text text-13">
                  Belum ada kelas berat badan.
                </div>
                <div v-else>
                  <div v-for="(rule, idx) in rules.weightClasses" :key="'wc-' + idx" class="rules-card-row">
                    <v-text-field
                      v-model="rule.name"
                      dense outlined hide-details
                      placeholder="Nama (cth: Kelas A)"
                      dark
                    ></v-text-field>
                    
                    <div class="rules-range-box">
                      <v-text-field
                        v-model.number="rule.min"
                        type="number" dense outlined hide-details
                        placeholder="Min"
                        dark
                        class="rules-input-num"
                      ></v-text-field>
                      <span class="rules-range-sep">-</span>
                      <v-text-field
                        v-model.number="rule.max"
                        type="number" dense outlined hide-details
                        placeholder="Max"
                        dark
                        class="rules-input-num"
                      ></v-text-field>
                    </div>

                    <v-btn
                      icon x-small
                      color="rgba(255,255,255,0.3)"
                      :disabled="rules.weightClasses.length <= 1"
                      @click="removeWeightRule(idx)"
                    >
                      <v-icon size="14">mdi-close</v-icon>
                    </v-btn>
                  </div>
                </div>
              </div>
              <div class="rules-card-footer">
                <button class="rules-add-btn" @click="addWeightRule()">
                  <v-icon x-small color="primaryred">mdi-plus</v-icon>
                  Tambah Berat
                </button>
              </div>
            </div>
          </v-col>

        </v-row>

        <!-- Solid divider line & Compact Action Bar -->
        <div class="px-6 pt-5 d-flex align-center" style="gap: 12px; border-top: 1px solid rgba(255,255,255,0.06); margin-top: 20px;">
          <v-btn
            color="primaryred"
            class="rounded-8 text-capitalize font-weight-semi white--text"
            small
            @click="applyAndGenerateTemplate()"
          >
            <v-icon left small>mdi-file-check-outline</v-icon>
            Apply &amp; Generate Template
          </v-btn>

          <!-- Smart Import Button -->
          <v-btn
            color="teal darken-1"
            class="rounded-8 text-capitalize font-weight-semi white--text"
            small
            :loading="loadingSmartImport"
            @click="$refs.smartImportInput.$refs.input.click()"
          >
            <v-icon left small>mdi-lightning-bolt</v-icon>
            Smart Import
          </v-btn>
          <v-file-input
            ref="smartImportInput"
            v-model="smartImportFile"
            accept=".xlsx"
            class="d-none"
            @change="smartImport"
          ></v-file-input>

          <v-btn
            v-if="rawAthletes.length > 0"
            outlined small
            color="primaryred"
            class="rounded-8 text-capitalize font-weight-semi"
            @click="applyNewRulesAndResimulate"
          >
            <v-icon left small>mdi-refresh</v-icon>
            Re-Simulasi
          </v-btn>
        </div>
      </div>
    </div>
    
    <!-- ═══════════════════════════════════════
         STEP 2: UNGGAH DATA EXCEL
    ═══════════════════════════════════════ -->
    <div class="print-hide mb-6">

      <div class="card-dashboard pb-6">
        <div class="section-body">
          <!-- Dropzone -->
          <div
            class="dropzone-area pa-8 mb-4"
            :class="{ 'is-dragging': isDragging, 'has-file': fileImport }"
            @dragover.prevent="isDragging = true"
            @dragenter.prevent="isDragging = true"
            @dragleave.prevent="isDragging = false"
            @drop.prevent="isDragging = false; handleFileDrop($event)"
            @click="$refs.fileInputRef.$refs.input.click()"
          >
            <v-icon size="36" :color="fileImport ? 'success' : 'primaryred'" class="mb-3">
              {{ fileImport ? 'mdi-file-document-check' : 'mdi-cloud-upload-outline' }}
            </v-icon>
            <p class="white--text font-weight-semi text-14 mb-1">
              {{ fileImport ? fileImport.name : 'Tarik &amp; Letakkan Berkas Excel di sini' }}
            </p>
            <p class="grey--text text-12 mb-0">
              {{ fileImport ? `${(fileImport.size / 1024).toFixed(1)} KB — klik untuk mengganti` : 'atau klik untuk menjelajah (.xlsx)' }}
            </p>
          </div>

          <v-file-input
            ref="fileInputRef"
            v-model="fileImport"
            accept=".xlsx"
            outlined
            dense
            hide-details
            class="d-none"
            @change="getDataFromExcel"
          ></v-file-input>

          <v-btn
            v-if="fileImport"
            outlined
            small
            color="grey darken-1"
            class="rounded-8 text-capitalize"
            @click.stop="clearFile"
          >
            Hapus File
          </v-btn>
        </div>

        <!-- Athlete Import Preview Table -->
        <div v-if="rawAthletes.length > 0" class="px-6 pb-2">
          <hr class="divider-dark mb-4" />
          
          <div class="d-flex align-center justify-space-between mb-3 flex-wrap" style="gap: 12px">
            <div>
              <p class="section-label mb-0">Preview Data Hasil Konversi ({{ rawAthletes.length }} Atlet)</p>
              <span class="grey--text text-12">Verifikasi hasil pemetaan kolom Excel sebelum membuat bagan.</span>
            </div>
            
            <div style="max-width: 250px; width: 100%">
              <v-text-field
                v-model="searchQueryAthletes"
                label="Cari Atlet..."
                dense
                outlined
                hide-details
                dark
                append-icon="mdi-magnify"
                class="rounded-8"
              ></v-text-field>
            </div>
          </div>

          <v-simple-table dense dark class="mb-4 elevation-2 rounded-8" style="border: 1px solid rgba(255,255,255,0.06); max-height: 400px; overflow-y: auto;">
            <thead>
              <tr style="background-color: rgba(255,255,255,0.02)">
                <th class="text-center font-weight-bold py-3" style="width: 60px">No</th>
                <th class="text-left font-weight-bold py-3">Nama Atlet</th>
                <th class="text-left font-weight-bold py-3">Klub / Dojo / Kontingen</th>
                <th class="text-center font-weight-bold py-3" style="width: 100px">Gender</th>
                <th class="text-center font-weight-bold py-3" style="width: 80px">Usia</th>
                <th class="text-center font-weight-bold py-3" style="width: 100px">Berat (kg)</th>
                <th class="text-left font-weight-bold py-3">Nomor Pertandingan</th>
                <th class="text-center font-weight-bold py-3" style="width: 80px">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(athlete, i) in filteredAthletes" :key="i" style="border-bottom: 1px solid rgba(255,255,255,0.04)">
                <td class="text-center grey--text text-13 py-2">{{ i + 1 }}</td>
                <td class="white--text font-weight-medium py-2 text-13">{{ athlete.name }}</td>
                <td class="grey--text text--lighten-1 py-2 text-13">{{ athlete.club }}</td>
                <td class="text-center py-2">
                  <v-chip x-small class="font-weight-semi" :color="athlete.gender.toLowerCase().includes('putri') ? 'pink darken-3' : 'blue darken-3'" dark>
                    {{ athlete.gender }}
                  </v-chip>
                </td>
                <td class="text-center white--text font-weight-bold py-2 text-13">{{ athlete.age }}</td>
                <td class="text-center white--text font-weight-bold py-2 text-13">{{ athlete.weight }} kg</td>
                <td class="grey--text text-13 py-2">{{ athlete.matchType }}</td>
                <td class="text-center py-2">
                  <v-btn icon x-small color="error" @click="deleteAthlete(i)">
                    <v-icon size="16">mdi-trash-can-outline</v-icon>
                  </v-btn>
                </td>
              </tr>
            </tbody>
          </v-simple-table>
        </div>

        <!-- Category Mapping Table (shown after parse) -->
        <div v-if="mappedCategories.length > 0" class="px-6 pb-2">
          <hr class="divider-dark mb-4" />
          <p class="section-label">Pemetaan Kategori — {{ rawAthletes.length }} Atlet</p>
          <v-simple-table dense dark class="mb-4">
            <thead>
              <tr>
                <th class="text-left">Nama Kategori</th>
                <th class="text-center">Jumlah</th>
                <th class="text-center">Status</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(cat, idx) in mappedCategories" :key="idx">
                <td class="white--text py-2 text-14">
                  <div class="d-flex align-center" style="gap: 8px;">
                    <span>{{ cat.categoryName }}</span>
                    <v-btn icon x-small dark @click="openRenameCategory(idx, cat.categoryName)">
                      <v-icon size="14" color="grey lighten-1">mdi-pencil-outline</v-icon>
                    </v-btn>
                  </div>
                </td>
                <td class="text-center py-2 text-14">{{ cat.athletes.length }}</td>
                <td class="text-center py-2">
                  <v-chip v-if="cat.athletes.length >= 2" color="success" x-small class="font-weight-semi">Ready</v-chip>
                  <v-chip v-else color="error" x-small class="font-weight-semi">Kurang</v-chip>
                </td>
                <td class="text-center py-2">
                  <v-btn x-small color="primary" class="rounded-8" @click="openAthletesList(cat)">Detail</v-btn>
                </td>
              </tr>
            </tbody>
          </v-simple-table>

          <!-- Action block for generation -->
          <div class="d-flex justify-end pt-2">
            <v-btn
              color="primaryred"
              class="rounded-8 text-capitalize font-weight-semi white--text px-6"
              @click="generateBracketsAndScroll()"
            >
              <v-icon left>mdi-tournament</v-icon>
              Buat Bagan Pertandingan
            </v-btn>
          </div>
        </div>
      </div>
    </div>

    <!-- ═══════════════════════════════════════
         STEP 3: BAGAN & CETAK
    ═══════════════════════════════════════ -->
    <div id="bracket-section-container">
      <!-- Empty state -->
      <div v-if="!generatedBrackets.length" class="card-dashboard">
        <div class="empty-state">
          <v-icon size="48" color="rgba(255,255,255,0.07)" class="mb-4">mdi-tournament</v-icon>
          <p class="grey--text text-14 mb-0">Belum ada bagan yang disimulasikan. Unggah berkas Excel di atas terlebih dahulu, kemudian klik "Buat Bagan Pertandingan".</p>
        </div>
      </div>

      <!-- Bracket viewer -->
      <div v-else class="card-dashboard pb-6">
        <!-- Category selector + action toolbar -->
        <div id="bracket-select-header" class="d-flex align-center justify-space-between px-6 pt-6 pb-4 flex-wrap" style="gap: 16px; border-bottom: 1px solid rgba(255,255,255,0.06)">
          <!-- Left side: Dropdown, Search, Pagination -->
          <div class="d-flex align-center flex-wrap" style="gap: 12px; flex: 1; min-width: 280px;">
            <!-- Dropdown Pilih Kategori -->
            <div style="max-width: 240px; width: 100%">
              <v-select
                v-model="selectedCategoryIdx"
                :items="filteredGeneratedBrackets"
                item-text="categoryName"
                item-value="idx"
                label="Pilih Kategori"
                dense
                outlined
                hide-details
                dark
                class="rounded-8"
              ></v-select>
            </div>

            <!-- Cari Nomor Tanding -->
            <div style="max-width: 220px; width: 100%">
              <v-text-field
                v-model="bracketSearchQuery"
                label="Cari Nomor Tanding..."
                dense
                outlined
                hide-details
                dark
                clearable
                prepend-inner-icon="mdi-magnify"
                class="rounded-8"
              ></v-text-field>
            </div>

            <!-- Pagination Bagan -->
            <div class="d-flex align-center" style="gap: 4px; border: 1px solid rgba(255,255,255,0.12); padding: 3px 8px; border-radius: 8px; background: rgba(255,255,255,0.02); height: 40px;">
              <v-btn
                icon
                small
                dark
                :disabled="currentCategoryFilteredIndex <= 0"
                @click="prevCategory()"
              >
                <v-icon small>mdi-chevron-left</v-icon>
              </v-btn>
              <span class="white--text text-12 mx-1 font-weight-medium" style="white-space: nowrap; min-width: 45px; text-align: center;">
                {{ filteredGeneratedBrackets.length > 0 ? (currentCategoryFilteredIndex + 1) : 0 }} / {{ filteredGeneratedBrackets.length }}
              </span>
              <v-btn
                icon
                small
                dark
                :disabled="currentCategoryFilteredIndex >= filteredGeneratedBrackets.length - 1"
                @click="nextCategory()"
              >
                <v-icon small>mdi-chevron-right</v-icon>
              </v-btn>
            </div>
          </div>

          <!-- Right side: Actions -->
          <div class="d-flex align-center flex-wrap" style="gap: 8px">
            <v-btn small outlined color="grey darken-1" class="rounded-8 text-capitalize font-weight-semi" @click="hideBye()">
              Hide Bye
            </v-btn>
            <v-btn small outlined color="grey darken-1" class="rounded-8 text-capitalize font-weight-semi" @click="shuffleCurrentCategory()">
              Shuffle
            </v-btn>
            <v-btn small outlined color="grey darken-1" class="rounded-8 text-capitalize font-weight-semi" @click="printBracket()">
              Print
            </v-btn>
            <v-btn v-if="generatedBrackets.length > 1" small outlined color="grey darken-1" class="rounded-8 text-capitalize font-weight-semi" @click="printAllBrackets()">
              Print All
            </v-btn>
            <v-btn small color="primaryred" class="rounded-8 text-capitalize font-weight-semi white--text mr-2" :loading="loadingSave" @click="submitBracket()">
              Save Chart
            </v-btn>
            <v-btn
              v-if="generatedBrackets.length > 1"
              small
              outlined
              color="primaryred"
              class="rounded-8 text-capitalize font-weight-semi"
              :loading="loadingSaveAll"
              @click="submitAllBrackets()"
            >
              <v-icon left small>mdi-content-save-all-outline</v-icon>
              Save All Charts
            </v-btn>
          </div>
        </div>

        <!-- Bracket render -->
        <div v-if="selectedCategory" class="px-6 pt-4">
          <div id="bracketData" class="bracket-render-container print-single-only">
            <!-- Bracket Category Title (rendered on screen and printed) -->
            <div class="bracket-print-title d-flex align-center justify-center" style="gap: 8px;">
              <span>{{ selectedCategory.categoryName }}</span>
              <v-btn icon x-small dark class="print-hide" @click="openRenameCategory(selectedCategory.idx, selectedCategory.categoryName)">
                <v-icon size="16">mdi-pencil-outline</v-icon>
              </v-btn>
            </div>

            <client-only>
              <bracket :rounds="selectedCategory.bracket">
                <template slot="player" slot-scope="{ player }">
                  <p class="bg-white mb-0 pa-0" :class="{ 'player-hidden': player.hidden, 'player-get-bye': player.isGetBye }">
                    {{ player.name }}
                    <v-icon
                      v-if="tempPlayer && player.setting"
                      color="black"
                      size="20"
                      class="icon-win"
                      @click.stop="setWinData(player)"
                    >mdi-tray-arrow-down</v-icon>
                    <v-icon
                      v-else-if="player.setting && player.name !== 'BYE' && player.name !== 'Waiting'"
                      color="secondary"
                      size="20"
                      class="icon-win"
                      @click.stop="winData(player)"
                    >mdi-content-copy</v-icon>
                  </p>
                </template>
              </bracket>
            </client-only>
          </div>

          <!-- Print all brackets container -->
          <div id="allBracketsPrintData" class="print-all-only">
            <div v-for="(category, cIdx) in generatedBrackets" :key="'print-all-' + cIdx" class="bracket-page-break">
              <div class="bracket-print-title d-flex align-center justify-center mb-6">
                <span>{{ category.categoryName }}</span>
              </div>
              <client-only>
                <bracket :rounds="category.bracket">
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
      </div>
    </div>

    <!-- ═══════════════════════════════════════
         DIALOG: Daftar Atlet
    ═══════════════════════════════════════ -->
    <v-dialog v-model="dialogAthletes" max-width="600" dark>
      <v-card v-if="activeCategoryRule" class="card-dialog pa-6">
        <v-card-title class="headline white--text px-0 pt-0 justify-space-between">
          <div class="d-flex flex-column">
            <span class="font-weight-semi text-18">Anggota Kategori</span>
            <span class="grey--text text-12">{{ activeCategoryRule.categoryName }}</span>
          </div>
          <v-btn icon @click="dialogAthletes = false"><v-icon>mdi-close</v-icon></v-btn>
        </v-card-title>
        <v-card-text class="px-0">
          <v-simple-table dense>
            <thead>
              <tr>
                <th class="text-left">Nama Atlet</th>
                <th class="text-left">Klub</th>
                <th class="text-center">Gender</th>
                <th class="text-center">Berat</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(athlete, i) in activeCategoryRule.athletes" :key="i">
                <td class="white--text py-2 text-14">{{ athlete.name }}</td>
                <td class="grey--text py-2 text-14">{{ athlete.club }}</td>
                <td class="text-center py-2">
                  <v-chip x-small class="font-weight-semi">{{ athlete.gender }}</v-chip>
                </td>
                <td class="text-center py-2 white--text font-weight-semi text-14">{{ athlete.weight }} kg</td>
              </tr>
            </tbody>
          </v-simple-table>
        </v-card-text>
      </v-card>
    </v-dialog>

    <!-- ═══════════════════════════════════════
         DIALOG: Pengaturan Cetak
    ═══════════════════════════════════════ -->
    <v-dialog v-model="printDialog" max-width="950px">
      <v-card class="card-dialog pa-6">
        <v-card-title class="headline font-weight-semi pb-4 white--text px-0 pt-0">
          Pengaturan &amp; Pratinjau Cetak
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
              <span class="grey--text text-12 position-absolute" style="top: 10px; left: 12px">Pratinjau {{ isPrintingAll ? '(Semua Kategori)' : '' }}</span>
              <div class="print-preview-sheet elevation-4" :style="previewSheetStyle">
                <!-- eslint-disable-next-line vue/no-v-html -->
                <div class="print-preview-content" :style="previewContentStyle" v-html="bracketHtml"></div>
              </div>
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-actions class="justify-end pt-4 px-0">
          <v-btn text color="grey" class="text-capitalize mr-2" @click="printDialog = false; isPrintingAll = false;">Batal</v-btn>
          <v-btn color="primaryred" class="rounded-8 text-capitalize font-weight-semi white--text px-6" @click="confirmPrint">Cetak</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- ═══════════════════════════════════════
         DIALOG: Smart Import Preview
    ═══════════════════════════════════════ -->
    <v-dialog v-model="dialogSmartImport" max-width="620px" persistent dark>
      <v-card class="card-dashboard" style="border: 1px solid rgba(0,200,180,0.25)">
        <v-card-title class="headline d-flex align-center pb-2" style="border-bottom: 1px solid rgba(255,255,255,0.08)">
          <v-icon color="teal lighten-1" class="mr-2">mdi-lightning-bolt</v-icon>
          <span class="white--text font-weight-bold">Smart Import — Hasil Deteksi Otomatis</span>
          <v-spacer></v-spacer>
          <v-btn icon small @click="dialogSmartImport = false"><v-icon small>mdi-close</v-icon></v-btn>
        </v-card-title>

        <v-card-text v-if="smartImportPreview" class="pt-4 pb-2">
          <div class="text-13 grey--text mb-4">
            Sistem membaca berkas Excel Anda dan mendeteksi konfigurasi berikut secara otomatis. Tinjau dan konfirmasi.
          </div>

          <!-- Kelompok Usia -->
          <div class="mb-4">
            <div class="d-flex align-center mb-2">
              <v-icon small color="teal lighten-1" class="mr-1">mdi-account-group-outline</v-icon>
              <span class="text-13 font-weight-bold white--text">Kelompok Usia Terdeteksi ({{ smartImportPreview.ageGroups.length }})</span>
            </div>
            <div class="d-flex flex-wrap" style="gap:6px">
              <v-chip
                v-for="(ag, i) in smartImportPreview.ageGroups" :key="'ag'+i"
                small dark outlined color="teal"
              >{{ ag.name }} ({{ ag.min }}–{{ ag.max }} thn)</v-chip>
            </div>
          </div>

          <!-- Kelas Berat Putra -->
          <div class="mb-4">
            <div class="d-flex align-center mb-2">
              <v-icon small color="blue lighten-2" class="mr-1">mdi-gender-male</v-icon>
              <span class="text-13 font-weight-bold white--text">Kelas Berat Putra Terdeteksi ({{ smartImportPreview.weightClassesPutra.length }})</span>
            </div>
            <div class="d-flex flex-wrap" style="gap:6px">
              <v-chip
                v-for="(wc, i) in smartImportPreview.weightClassesPutra" :key="'wc-putra-'+i"
                small dark outlined color="blue lighten-1"
              >{{ wc.name }} ({{ wc.min }}–{{ wc.max }} kg)</v-chip>
            </div>
          </div>

          <!-- Kelas Berat Putri -->
          <div class="mb-4">
            <div class="d-flex align-center mb-2">
              <v-icon small color="pink lighten-2" class="mr-1">mdi-gender-female</v-icon>
              <span class="text-13 font-weight-bold white--text">Kelas Berat Putri Terdeteksi ({{ smartImportPreview.weightClassesPutri.length }})</span>
            </div>
            <div class="d-flex flex-wrap" style="gap:6px">
              <v-chip
                v-for="(wc, i) in smartImportPreview.weightClassesPutri" :key="'wc-putri-'+i"
                small dark outlined color="pink lighten-1"
              >{{ wc.name }} ({{ wc.min }}–{{ wc.max }} kg)</v-chip>
            </div>
          </div>

          <!-- Nomor Pertandingan -->
          <div class="mb-4">
            <div class="d-flex align-center mb-2">
              <v-icon small color="teal lighten-1" class="mr-1">mdi-sword-cross</v-icon>
              <span class="text-13 font-weight-bold white--text">Nomor Pertandingan Terdeteksi</span>
            </div>
            <div class="d-flex flex-wrap" style="gap:6px">
              <v-chip
                v-for="(mt, i) in smartImportPreview.matchTypes" :key="'mt'+i"
                small dark outlined color="orange darken-2"
              >{{ mt }}</v-chip>
            </div>
          </div>

          <!-- Total Athletes -->
          <div style="background: rgba(0,200,180,0.06); border: 1px solid rgba(0,200,180,0.15); border-radius: 8px; padding: 10px 14px;" class="d-flex align-center">
            <v-icon color="teal lighten-1" class="mr-2">mdi-account-multiple-check</v-icon>
            <span class="white--text font-weight-semi">Total Atlet Terdeteksi: <strong class="teal--text text--lighten-1">{{ smartImportPreview.athletes.length }} Atlet</strong></span>
          </div>
        </v-card-text>

        <v-card-actions class="px-4 pb-4 pt-2">
          <v-btn outlined small color="grey" class="rounded-8 text-capitalize" @click="dialogSmartImport = false">Batal</v-btn>
          <v-spacer></v-spacer>
          <v-btn
            color="teal darken-1"
            class="rounded-8 text-capitalize font-weight-bold white--text px-6"
            small
            @click="confirmSmartImport"
          >
            <v-icon left small>mdi-check-circle-outline</v-icon>
            Konfirmasi &amp; Generate Bagan
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Dialog: Pemetaan Kolom Excel -->
    <v-dialog v-model="dialogMapping" max-width="500px" persistent dark>
      <v-card class="card-dashboard" style="border: 1px solid rgba(255,255,255,0.08)">
        <v-card-title class="headline d-flex align-center pb-2">
          <v-icon color="primaryred" class="mr-2">mdi-table-edit</v-icon>
          Pemetaan Kolom Excel
        </v-card-title>
        
        <v-card-text>
          <div class="text-13 grey--text mb-4">
            Sesuaikan kolom dari berkas Excel Anda dengan data atlet yang dibutuhkan sistem:
          </div>

          <v-row dense>
            <v-col cols="12">
              <v-select
                v-model="mapping.name"
                :items="excelHeaders"
                label="Nama Atlet"
                dense outlined dark
                hide-details
                class="mb-3 rounded-8"
              ></v-select>
            </v-col>
            <v-col cols="12">
              <v-select
                v-model="mapping.club"
                :items="excelHeaders"
                label="Klub / Kontingen / Dojo"
                dense outlined dark
                hide-details
                class="mb-3 rounded-8"
              ></v-select>
            </v-col>
            <v-col cols="12">
              <v-select
                v-model="mapping.gender"
                :items="excelHeaders"
                label="Jenis Kelamin"
                dense outlined dark
                hide-details
                class="mb-3 rounded-8"
              ></v-select>
            </v-col>
            <v-col cols="12">
              <v-select
                v-model="mapping.age"
                :items="excelHeaders"
                label="Tanggal Lahir / Tahun / Usia"
                dense outlined dark
                hide-details
                class="mb-3 rounded-8"
              ></v-select>
            </v-col>
            <v-col cols="12">
              <v-select
                v-model="mapping.weight"
                :items="excelHeaders"
                label="Berat Badan (kg)"
                dense outlined dark
                hide-details
                class="mb-3 rounded-8"
              ></v-select>
            </v-col>
            <v-col cols="12">
              <v-select
                v-model="mapping.matchType"
                :items="excelHeaders"
                label="Nomor Pertandingan (Cabang)"
                dense outlined dark
                hide-details
                class="mb-1 rounded-8"
              ></v-select>
            </v-col>
          </v-row>
        </v-card-text>

        <v-card-actions class="justify-end px-6 pb-6">
          <v-btn text color="grey" class="text-capitalize rounded-8" @click="cancelMapping">
            Batal
          </v-btn>
          <v-btn color="primaryred" class="rounded-8 text-capitalize font-weight-semi white--text px-6" @click="applyMapping">
            Terapkan Pemetaan
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Dialog Rename Kategori -->
    <v-dialog v-model="dialogRename" max-width="420px" dark>
      <v-card class="card-dashboard" style="background-color: #1a1a1f; border: 1px solid rgba(255,255,255,0.08);">
        <v-card-title class="headline white--text font-weight-bold pt-6 px-6">
          Rename Nomor Tanding
        </v-card-title>
        <v-card-text class="pt-2 px-6">
          <p class="grey--text text-13 mb-4">Ubah nama kategori / nomor pertandingan ini. Perubahan akan langsung memengaruhi judul pada bagan.</p>
          <v-text-field
            v-model="renameCategoryValue"
            label="Nama Nomor Tanding Baru"
            outlined
            dense
            dark
            hide-details
            class="rounded-8"
            @keyup.enter="saveRenameCategory()"
          ></v-text-field>
        </v-card-text>
        <v-card-actions class="px-6 pb-6 pt-2">
          <v-spacer></v-spacer>
          <v-btn small outlined color="grey" class="rounded-8 text-capitalize" @click="dialogRename = false">
            Batal
          </v-btn>
          <v-btn small color="primaryred" class="rounded-8 text-capitalize white--text px-4" @click="saveRenameCategory()">
            Simpan
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Hidden xlsx parser -->
    <div class="d-none">
      <xlsx-read :file="fileImport">
        <xlsx-json>
          <template #default="{ collection }">
            <div ref="dataJson">{{ collection }}</div>
          </template>
        </xlsx-json>
      </xlsx-read>
    </div>

    <!-- Snackbar -->
    <v-snackbar v-model="notif" :color="notifColor">
      {{ notifMsg }}
      <template #action="{ attrs }">
        <v-btn icon v-bind="attrs" @click="notif = false"><v-icon>mdi-close</v-icon></v-btn>
      </template>
    </v-snackbar>
  </div>
</template>

<script>
import { XlsxRead, XlsxJson } from 'vue-xlsx'
import XLSX from 'xlsx'

export default {
  name: 'BracketSandboxPage',
  components: {
    XlsxRead,
    XlsxJson,
    [process.client && 'Bracket']: () => import('vue-tournament-bracket'),
  },
  layout: 'bracket',
  middleware: 'login',
  data() {
    return {
      activeStep: 1,
      ruleTab: 0,
      fileImport: null,
      isDragging: false,
      searchQuery: '',
      searchQueryAthletes: '',
      categoryCurrentPage: 1,
      categoryItemsPerPage: 10,
      notif: false,
      notifColor: 'dark',
      notifMsg: '',
      tempPlayer: null,
      chartHidden: [],
      loadingSave: false,
      loadingSaveAll: false,
      dialogMapping: false,
      dialogSmartImport: false,
      smartImportPreview: null,
      loadingSmartImport: false,
      smartImportFile: null,
      excelRawRows: [],
      excelHeaders: [],
      mapping: {
        name: '',
        club: '',
        gender: '',
        weight: '',
        matchType: '',
        ageType: 'age',
        ageColumn: '',
        tournamentYear: new Date().getFullYear(),
        cutoffDate: new Date().toISOString().substring(0, 10),
      },
      printDialog: false,
      isPrintingAll: false,
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

      tournamentName: '',
      selectedMartialId: null,
      martialItems: [],

      rules: {
        matchTypes: [
          'Ju-Jitsu - Fighting System',
          'Ju-Jitsu - Fighting System (IJI)',
          'Ju-Jitsu - Newaza',
          'Ju-Jitsu - Show System',
          'Ju-Jitsu - Contact System',
        ],
        ageGroups: [
          { name: 'U18', min: 15, max: 17 },
          { name: 'U21', min: 18, max: 20 },
          { name: 'Senior', min: 21, max: 99 },
        ],
        weightClasses: [
          { name: 'Kelas A', min: 50, max: 55 },
          { name: 'Kelas -62', min: 56, max: 62 },
          { name: 'Kelas -69', min: 63, max: 69 },
          { name: 'Featherweight', min: 70, max: 77 },
        ],
      },

      rawAthletes: [],
      mappedCategories: [],

      generatedBrackets: [],
      selectedCategoryIdx: null,
      bracketSearchQuery: '',

      dialogAthletes: false,
      activeCategoryRule: null,

      dialogRename: false,
      renameCategoryIdx: null,
      renameCategoryValue: '',
    }
  },
  computed: {
    filteredAthletes() {
      if (!this.searchQueryAthletes) return this.rawAthletes
      const q = this.searchQueryAthletes.toLowerCase()
      return this.rawAthletes.filter((a) => {
        return (
          (a.name && a.name.toLowerCase().includes(q)) ||
          (a.club && a.club.toLowerCase().includes(q)) ||
          (a.matchType && a.matchType.toLowerCase().includes(q))
        )
      })
    },
    hasValidCategories() {
      return this.mappedCategories.some((cat) => cat.athletes.length >= 2)
    },
    filteredCategories() {
      if (!this.searchQuery) return this.mappedCategories
      const query = this.searchQuery.toLowerCase()
      return this.mappedCategories.filter((cat) =>
        cat.categoryName.toLowerCase().includes(query)
      )
    },
    selectedCategory() {
      if (this.selectedCategoryIdx === null) return null
      return this.generatedBrackets.find((b) => b.idx === this.selectedCategoryIdx) || null
    },
    filteredGeneratedBrackets() {
      if (!this.bracketSearchQuery) return this.generatedBrackets
      const q = this.bracketSearchQuery.toLowerCase()
      return this.generatedBrackets.filter((b) =>
        b.categoryName.toLowerCase().includes(q)
      )
    },
    currentCategoryFilteredIndex() {
      if (this.selectedCategoryIdx === null) return -1
      return this.filteredGeneratedBrackets.findIndex(
        (b) => b.idx === this.selectedCategoryIdx
      )
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
  watch: {
    bracketSearchQuery() {
      const filtered = this.filteredGeneratedBrackets
      if (filtered.length > 0) {
        const exists = filtered.some((b) => b.idx === this.selectedCategoryIdx)
        if (!exists) {
          this.selectedCategoryIdx = filtered[0].idx
        }
      } else {
        this.selectedCategoryIdx = null
      }
    },
  },
  mounted() {
    this.getMartialItems()
  },
  methods: {
    openRenameCategory(categoryIdx, currentName) {
      this.renameCategoryIdx = categoryIdx
      this.renameCategoryValue = currentName
      this.dialogRename = true
    },
    saveRenameCategory() {
      if (!this.renameCategoryValue.trim()) return
      const newName = this.renameCategoryValue.trim()
      
      // 1. Update in mappedCategories
      if (this.mappedCategories[this.renameCategoryIdx]) {
        this.mappedCategories[this.renameCategoryIdx].categoryName = newName
      }
      
      // 2. Update in generatedBrackets if generated
      const genBracket = this.generatedBrackets.find((b) => b.idx === this.renameCategoryIdx)
      if (genBracket) {
        genBracket.categoryName = newName
      }

      this.dialogRename = false
      this.notif = true
      this.notifColor = 'success'
      this.notifMsg = 'Nama nomor tanding berhasil diubah!'
    },
    prevCategory() {
      const idx = this.currentCategoryFilteredIndex
      if (idx > 0) {
        this.selectedCategoryIdx = this.filteredGeneratedBrackets[idx - 1].idx
      }
    },
    nextCategory() {
      const idx = this.currentCategoryFilteredIndex
      if (idx >= 0 && idx < this.filteredGeneratedBrackets.length - 1) {
        this.selectedCategoryIdx = this.filteredGeneratedBrackets[idx + 1].idx
      }
    },
    async getMartialItems() {
      const url = '/api/martial'
      await this.$axios
        .get(url)
        .then((result) => {
          if (result.data && result.data.data) {
            this.martialItems = result.data.data.map((item) => ({
              id: item.id,
              name: item.martial_name,
            }))
            // Auto-select first cabor if available
            if (this.martialItems.length > 0) {
              this.selectedMartialId = this.martialItems[0].id
            }
          }
        })
        .catch(() => {
          this.notif = true
          this.notifColor = 'error'
          this.notifMsg = 'Gagal memuat daftar Cabang Olahraga.'
        })
    },

    applyAndGenerateTemplate() {
      // Download dynamic template
      this.downloadMasterTemplate()
      // Advise user & transition
      this.notif = true
      this.notifColor = 'success'
      this.notifMsg = 'Aturan kategori berhasil diterapkan & Template Master diunduh!'
    },

    applyNewRulesAndResimulate() {
      this.processAutoGrouping()
      this.generateAllBrackets()
    },

    deleteAthlete(index) {
      this.rawAthletes.splice(index, 1)
      this.processAutoGrouping()
      this.generateAllBrackets()
    },

    smartImport(file) {
      const activeFile = file || null
      if (!activeFile) {
        this.loadingSmartImport = false
        return
      }

      this.loadingSmartImport = true

      const reader = new FileReader()
      reader.onerror = () => {
        this.loadingSmartImport = false
        this.smartImportFile = null
        this.notif = true
        this.notifColor = 'error'
        this.notifMsg = 'Gagal membaca berkas untuk Smart Import.'
      }
      reader.onload = (e) => {
        setTimeout(() => {
          try {
            const data = e.target.result
            const workbook = XLSX.read(data, { type: 'array' })

            const detectedAgeGroups = []
            const detectedWeightMapPutra = new Map()
            const detectedWeightMapPutri = new Map()
            const detectedMatchTypes = new Set()
            const allAthletes = []

            const processSheetAsync = async (index) => {
              if (index >= workbook.SheetNames.length) {
                const sortedWeightsPutra = Array.from(detectedWeightMapPutra.entries()).sort((a, b) => a[0] - b[0])
                const finalWeightClassesPutra = sortedWeightsPutra.map(([num, { isPlus }], i) => ({
                  name: isPlus ? `+${num}` : `-${num}`,
                  min: i === 0 ? 0 : sortedWeightsPutra[i - 1][0],
                  max: num,
                }))

                const sortedWeightsPutri = Array.from(detectedWeightMapPutri.entries()).sort((a, b) => a[0] - b[0])
                const finalWeightClassesPutri = sortedWeightsPutri.map(([num, { isPlus }], i) => ({
                  name: isPlus ? `+${num}` : `-${num}`,
                  min: i === 0 ? 0 : sortedWeightsPutri[i - 1][0],
                  max: num,
                }))

                detectedAgeGroups.sort((a, b) => a.maxAge - b.maxAge)
                const finalAgeGroups = detectedAgeGroups.map((g, i) => ({
                  name: g.name,
                  min: i === 0 ? 0 : detectedAgeGroups[i - 1].maxAge + 1,
                  max: g.maxAge,
                }))

                const finalMatchTypes = Array.from(detectedMatchTypes).filter(Boolean)

                if (allAthletes.length === 0) {
                  this.loadingSmartImport = false
                  this.smartImportFile = null
                  this.notif = true
                  this.notifColor = 'error'
                  this.notifMsg = 'Tidak ada atlet yang terdeteksi dalam berkas Excel ini.'
                  return
                }

                this.smartImportPreview = {
                  ageGroups: finalAgeGroups,
                  weightClassesPutra: finalWeightClassesPutra,
                  weightClassesPutri: finalWeightClassesPutri,
                  matchTypes: finalMatchTypes,
                  athletes: allAthletes,
                }
                this.loadingSmartImport = false
                this.smartImportFile = null
                this.dialogSmartImport = true
                return
              }

              const sheetName = workbook.SheetNames[index]
              const worksheet = workbook.Sheets[sheetName]
              const rawRows = XLSX.utils.sheet_to_json(worksheet, { header: 1, defval: '' })

              const cropped = this.cropEmptyMarginsJS(rawRows)
              if (cropped.length === 0) {
                setTimeout(() => {
                  processSheetAsync(index + 1)
                }, 10)
                return
              }

              const preview = cropped.slice(0, 15)
              try {
                const response = await this.$axios.$post('/api/parse-recipe', { preview })
                if (response.status === 'success') {
                  const recipe = response.recipe
                  this.parseSheetWithRecipe(cropped, sheetName, recipe, detectedAgeGroups, detectedWeightMapPutra, detectedWeightMapPutri, detectedMatchTypes, allAthletes)
                }
              } catch (err) {
                // eslint-disable-next-line no-console
                console.error('Gagal analisis AI untuk sheet ' + sheetName, err)
              }

              setTimeout(() => {
                processSheetAsync(index + 1)
              }, 10)
            }

            processSheetAsync(0)

          } catch (err) {
            this.loadingSmartImport = false
            this.smartImportFile = null
            // eslint-disable-next-line no-console
            console.error('Smart Import error:', err)
            this.notif = true
            this.notifColor = 'error'
            this.notifMsg = 'Gagal memproses berkas Excel untuk Smart Import.'
          }
        }, 50)
      }
      reader.readAsArrayBuffer(activeFile)
    },

    cropEmptyMarginsJS(rows) {
      if (!rows || rows.length === 0) return []
      
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
      
      const croppedCols = rows.map(row => row.slice(firstValidCol))
      
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

    parseSheetWithRecipe(rows, sheetName, recipe, detectedAgeGroups, detectedWeightMapPutra, detectedWeightMapPutri, detectedMatchTypes, allAthletes) {
      const headerIdx = recipe.header_row_index
      const nameColIdx = recipe.column_mapping.name_column_index
      const clubColIdx = recipe.column_mapping.club_column_index
      const genderColIdx = recipe.column_mapping.gender_column_index
      const ageColIdx = recipe.column_mapping.age_column_index
      const weightColIdx = recipe.column_mapping.weight_column_index
      const matchTypeColIdx = recipe.column_mapping.match_type_column_index
      const hasStacked = recipe.segmentation && recipe.segmentation.has_stacked_tables
      
      let currentCategoryName = sheetName
      
      const ageMatch = sheetName.match(/^[Uu][-\s]?(\d+)$/)
      const sheetMaxAge = ageMatch ? parseInt(ageMatch[1]) : null
      
      if (sheetMaxAge) {
        const name = `U${sheetMaxAge}`
        if (!detectedAgeGroups.find(g => g.name === name)) {
          detectedAgeGroups.push({ name, maxAge: sheetMaxAge })
        }
      }

      for (let i = headerIdx + 1; i < rows.length; i++) {
        const row = rows[i]
        const isEmpty = !row || row.every(cell => cell === undefined || cell === null || String(cell).trim() === "")
        
        if (isEmpty) {
          continue
        }
        
        if (hasStacked) {
          const nonEntries = row.filter(cell => cell !== undefined && cell !== null && String(cell).trim() !== "")
          if (nonEntries.length === 1 && isNaN(String(nonEntries[0]).trim())) {
            currentCategoryName = `${sheetName} - ${String(nonEntries[0]).trim()}`
            continue
          }
        }
        
        const name = nameColIdx !== -1 && row[nameColIdx] ? String(row[nameColIdx]).trim() : ""
        if (!name || name.toLowerCase() === "nama" || name.toLowerCase().includes("atlet kategori")) {
          continue
        }
        
        const club = clubColIdx !== -1 && row[clubColIdx] ? String(row[clubColIdx]).trim() : "Tanpa Club"
        
        let genderVal = "Putra"
        if (genderColIdx !== -1 && row[genderColIdx]) {
          const gStr = String(row[genderColIdx]).toLowerCase()
          if (gStr.includes("putri") || gStr === "p" || gStr === "female" || gStr.includes("perempuan")) {
            genderVal = "Putri"
          }
        }
        
        let ageVal = 20
        if (sheetMaxAge !== null) {
          ageVal = sheetMaxAge
        } else if (ageColIdx !== -1 && row[ageColIdx]) {
          const ageNum = parseInt(String(row[ageColIdx]).replace(/[^0-9]/g, ''))
          if (!isNaN(ageNum) && ageNum > 0) ageVal = ageNum
        }
        
        let weightVal = 60
        let wcRaw = ""
        if (weightColIdx !== -1 && row[weightColIdx]) {
          wcRaw = String(row[weightColIdx]).trim()
          const wStr = wcRaw.replace(',', '.')
          const wMatch = wStr.match(/[0-9.]+/)
          if (wMatch) {
            weightVal = parseFloat(wMatch[0]) || 60
          }
        }
        
        if (wcRaw) {
          const isPlus = wcRaw.includes('+')
          if (genderVal === 'Putra') {
            if (!detectedWeightMapPutra.has(weightVal)) {
              detectedWeightMapPutra.set(weightVal, { label: wcRaw, isPlus })
            }
          } else if (!detectedWeightMapPutri.has(weightVal)) {
            detectedWeightMapPutri.set(weightVal, { label: wcRaw, isPlus })
          }
        }
        
        let matchTypeVal = currentCategoryName
        if (matchTypeColIdx !== -1 && row[matchTypeColIdx]) {
          const mtRaw = String(row[matchTypeColIdx]).trim()
          if (mtRaw) {
            matchTypeVal = mtRaw.toUpperCase()
          }
        }
        
        detectedMatchTypes.add(matchTypeVal.toUpperCase())
        
        allAthletes.push({
          name,
          club,
          gender: genderVal,
          age: ageVal,
          weight: weightVal,
          matchType: matchTypeVal.toUpperCase()
        })
      }
    },

    confirmSmartImport() {
      if (!this.smartImportPreview) return

      const p = this.smartImportPreview

      // Apply detected configuration
      if (p.ageGroups.length > 0) this.rules.ageGroups = p.ageGroups.map(g => ({ ...g }))
      
      // Merge weight classes from Putra and Putri
      const mergedWeightClasses = []
      const seenNames = new Set()
      const addClasses = (classes) => {
        classes.forEach(w => {
          if (!seenNames.has(w.name)) {
            seenNames.add(w.name)
            mergedWeightClasses.push({ ...w })
          }
        })
      }
      addClasses(p.weightClassesPutra)
      addClasses(p.weightClassesPutri)
      if (mergedWeightClasses.length > 0) this.rules.weightClasses = mergedWeightClasses

      if (p.matchTypes.length > 0) this.rules.matchTypes = [...p.matchTypes]

      // Import athletes
      this.rawAthletes = p.athletes.map(a => {
        // Match matchType to configured matchTypes
        const rawMT = a.matchType || ''
        const matchedType = this.rules.matchTypes.find(
          (t) => t.toLowerCase().includes(rawMT.toLowerCase()) || rawMT.toLowerCase().includes(t.toLowerCase())
        )
        return { ...a, matchType: matchedType || rawMT || this.rules.matchTypes[0] || 'Fighting' }
      })

      this.dialogSmartImport = false
      this.smartImportPreview = null

      // Generate brackets immediately
      this.processAutoGrouping()
      this.generateAllBrackets()

      this.notif = true
      this.notifColor = 'success'
      this.notifMsg = `Smart Import selesai! ${this.rawAthletes.length} atlet dari ${p.ageGroups.length} kelompok usia berhasil diproses.`
    },

    generateBracketsAndScroll() {
      // 1. Process groupings & generate bracket lists
      this.processAutoGrouping()
      this.generateAllBrackets()

      // 2. Auto-select first bracket category if nothing is selected
      if (this.selectedCategoryIdx === null && this.generatedBrackets.length > 0) {
        this.selectedCategoryIdx = this.generatedBrackets[0].idx
      }

      // 3. Trigger alert notification
      this.notif = true
      this.notifColor = 'success'
      this.notifMsg = 'Bagan pertandingan berhasil dibuat! Silakan lihat di bawah.'

      // 4. Smooth scroll to bracket view segment
      setTimeout(() => {
        const el = document.getElementById('bracket-section-container')
        if (el) {
          el.scrollIntoView({ behavior: 'smooth', block: 'start' })
        }
      }, 100)
    },

    clearFile() {
      this.fileImport = null
      this.rawAthletes = []
      this.mappedCategories = []
      this.generatedBrackets = []
      this.selectedCategoryIdx = null
    },

    handleHeaderBack() {
      this.$router.push('/user/chart')
    },

    handleFileDrop(e) {
      const files = e.dataTransfer.files
      if (files && files.length > 0) {
        const file = files[0]
        if (file.name.endsWith('.xlsx') || file.name.endsWith('.xls') || file.type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
          this.fileImport = file
          this.getDataFromExcel()
        } else {
          this.notif = true
          this.notifColor = 'error'
          this.notifMsg = 'Format file tidak didukung. Silakan gunakan file Excel (.xlsx).'
        }
      }
    },

    downloadMasterTemplate() {
      // 1. Prefill data based on active config rules
      const defaultMatch = this.rules.matchTypes[0] || 'Ju-Jitsu - Fighting System'
      
      const headers = ['Nama', 'Club', 'Gender', 'Usia', 'Berat', 'NomorPertandingan']
      const rows = [
        ['Rian Junaedi', 'Dojo Rajawali', 'Putra', '19', '61.5', defaultMatch],
        ['Galang Pratama', 'Dojo Rajawali', 'Putra', '19', '60.8', defaultMatch],
        ['Arif Budiman', 'Dojo Garuda', 'Putra', '20', '61.2', defaultMatch],
        ['Bagus Pamungkas', 'Dojo Garuda', 'Putra', '18', '57.5', defaultMatch],
        ['Rizky Hidayat', 'Dojo Macan', 'Putra', '19', '61.9', defaultMatch],
        ['Wahyu Hidayat', 'Dojo Singa', 'Putra', '20', '59.8', defaultMatch],
        ['Faris Fauzan', 'Dojo Singa', 'Putra', '18', '61.1', defaultMatch],
        ['Danang Kusuma', 'Dojo Rajawali', 'Putra', '19', '73.2', defaultMatch],
        ['Bayu Seno', 'Dojo Garuda', 'Putra', '21', '74.8', defaultMatch],
        ['Devi Lestari', 'Dojo Rajawali', 'Putri', '19', '54.2', defaultMatch],
        ['Siti Aminah', 'Dojo Garuda', 'Putri', '18', '51.9', defaultMatch],
        ['Fitri Rahmawati', 'Dojo Macan', 'Putri', '20', '53.8', defaultMatch],
      ]

      // 2. Create workbook & worksheet for Athletes
      const wb = XLSX.utils.book_new()
      const wsAthletes = XLSX.utils.aoa_to_sheet([headers, ...rows])
      XLSX.utils.book_append_sheet(wb, wsAthletes, 'Pendaftaran Atlet')

      // 3. Create helper sheet: Panduan Aturan
      const ruleHeaders = ['Kategori', 'Detail Aturan / Nilai Yang Diizinkan']
      const ruleRows = [
        ['Genders', 'Putra, Putri'],
        ['Nomor Tanding', this.rules.matchTypes.filter((t) => t.trim() !== '').join(', ')],
        ['Kelompok Usia', this.rules.ageGroups.map((g) => `${g.name} (${g.min}-${g.max} tahun)`).join(', ')],
        ['Kelas Berat (kg)', this.rules.weightClasses.map((w) => `${w.name} (${w.min}-${w.max} kg)`).join(', ')],
      ]
      const wsRules = XLSX.utils.aoa_to_sheet([ruleHeaders, ...ruleRows])
      XLSX.utils.book_append_sheet(wb, wsRules, 'Panduan Aturan')

      // 4. Export to binary and trigger download
      const wbout = XLSX.write(wb, { bookType: 'xlsx', type: 'binary' })
      
      const s2ab = (s) => {
        const buf = new ArrayBuffer(s.length)
        const view = new Uint8Array(buf)
        for (let i = 0; i < s.length; i++) {
          view[i] = s.charCodeAt(i) & 0xFF
        }
        return buf
      }

      const blob = new Blob([s2ab(wbout)], { type: 'application/octet-stream' })
      const url = URL.createObjectURL(blob)
      const link = document.createElement('a')
      link.href = url
      link.setAttribute('download', 'Template-Master-Peserta-Konfigurasi.xlsx')
      document.body.appendChild(link)
      link.click()
      document.body.removeChild(link)
    },

    addMatchTypeRule() {
      this.rules.matchTypes.push('')
    },
    removeMatchTypeRule(idx) {
      this.rules.matchTypes.splice(idx, 1)
    },
    addAgeRule() {
      this.rules.ageGroups.push({ name: '', min: 0, max: 99 })
    },
    removeAgeRule(idx) {
      this.rules.ageGroups.splice(idx, 1)
    },
    addWeightRule() {
      this.rules.weightClasses.push({ name: '', min: 0, max: 200 })
    },
    removeWeightRule(idx) {
      this.rules.weightClasses.splice(idx, 1)
    },

    getDataFromExcel(file) {
      const activeFile = file || this.fileImport || (this.$refs.fileInputRef && this.$refs.fileInputRef.lazyValue)
      
      // eslint-disable-next-line no-console
      console.log('getDataFromExcel triggered. activeFile:', activeFile)
      
      if (!activeFile) {
        // eslint-disable-next-line no-console
        console.warn('No active file resolved in getDataFromExcel')
        return
      }

      // Ensure fileImport is updated for UI display
      this.fileImport = activeFile
      
      const reader = new FileReader()
      reader.onerror = (err) => {
        // eslint-disable-next-line no-console
        console.error('FileReader error:', err)
        this.notif = true
        this.notifColor = 'error'
        this.notifMsg = 'Gagal membaca berkas Excel dari sistem Anda.'
      }
      reader.onload = (e) => {
        try {
          const data = e.target.result
          const workbook = XLSX.read(data, { type: 'binary' })
          
          const allRawRows = []
          
          // Loop through all sheets in the workbook
          workbook.SheetNames.forEach((sheetName) => {
            const worksheet = workbook.Sheets[sheetName]
            // Read sheet as 2D array
            const rows = XLSX.utils.sheet_to_json(worksheet, { header: 1, defval: '' })
            
            const colIndices = {
              no: -1,
              name: -1,
              gender: -1,
              age: -1,
              weight: -1,
              matchType: -1,
              club: -1
            }
            
            rows.forEach((row) => {
              if (!row || row.length === 0) return
              
              // 1. Detect if this row is a header row
              const rowStr = row.map(cell => String(cell).toLowerCase().trim())
              const isHeader = rowStr.includes('no') && (rowStr.includes('nama') || rowStr.includes('nama '))
              
              if (isHeader) {
                // Map the column indexes based on this header row
                rowStr.forEach((cell, idx) => {
                  if (cell.includes('no')) colIndices.no = idx
                  else if (cell.includes('nama')) colIndices.name = idx
                  else if (cell.includes('jenis kelamin') || cell.includes('gender') || cell.includes('jk')) colIndices.gender = idx
                  else if (cell.includes('usia') || cell.includes('umur') || cell.includes('lahir') || cell.includes('dob')) colIndices.age = idx
                  else if (cell.includes('berat') || cell.includes('bb') || cell.includes('weight') || cell.includes('kg')) colIndices.weight = idx
                  else if (cell.includes('kategori') || cell.includes('nomor') || cell.includes('match') || cell.includes('kelas')) colIndices.matchType = idx
                  else if (cell.includes('dojo') || cell.includes('klub') || cell.includes('club') || cell.includes('kontingen') || cell.includes('instansi')) colIndices.club = idx
                })
                return // skip header row itself
              }
              
              // 2. Process athlete data if we have mapped a Name column
              if (colIndices.name !== -1) {
                const rawName = row[colIndices.name] ? String(row[colIndices.name]).trim() : ''
                
                // Skip if name is empty, is section title, or matches 'NAMA' or is 'NO' placeholder
                if (!rawName || rawName.toUpperCase().startsWith('ATLET KATEGORI') || rawName.toUpperCase() === 'NAMA' || rawName.toUpperCase() === 'NAMA ') {
                  return
                }
                
                const rawGender = colIndices.gender !== -1 ? String(row[colIndices.gender] || '') : ''
                const rawAge = colIndices.age !== -1 ? String(row[colIndices.age] || '') : ''
                const rawWeight = colIndices.weight !== -1 ? String(row[colIndices.weight] || '') : ''
                const rawMatchType = colIndices.matchType !== -1 ? String(row[colIndices.matchType] || '') : ''
                const rawClub = colIndices.club !== -1 ? String(row[colIndices.club] || '') : ''
                
                allRawRows.push({
                  Nama: rawName,
                  Club: rawClub,
                  Gender: rawGender,
                  Usia: rawAge,
                  Berat: rawWeight,
                  Kategori: rawMatchType
                })
              }
            })
          })
          
          if (allRawRows.length === 0) {
            this.notif = true
            this.notifColor = 'error'
            this.notifMsg = 'Tidak ditemukan data atlet yang valid dalam berkas Excel.'
            return
          }
          
          this.excelRawRows = allRawRows
          this.excelHeaders = ['Nama', 'Club', 'Gender', 'Usia', 'Berat', 'Kategori']
          
          // Setup default mapping directly because we already parsed them
          this.mapping.name = 'Nama'
          this.mapping.club = 'Club'
          this.mapping.gender = 'Gender'
          this.mapping.age = 'Usia'
          this.mapping.weight = 'Berat'
          this.mapping.matchType = 'Kategori'
          
          this.dialogMapping = true
        } catch (err) {
          // eslint-disable-next-line no-console
          console.error(err)
          this.notif = true
          this.notifColor = 'error'
          this.notifMsg = 'Gagal membaca berkas Excel. Pastikan format benar.'
        }
      }
      reader.readAsBinaryString(this.fileImport)
    },

    cancelMapping() {
      this.dialogMapping = false
      this.fileImport = null
    },

    applyMapping() {
      try {
        const mappings = this.mapping
        
        this.rawAthletes = this.excelRawRows.map((row, index) => {
          const nameVal = row[mappings.name] ? String(row[mappings.name]).trim() : `Atlet ${index + 1}`
          const clubVal = row[mappings.club] ? String(row[mappings.club]).trim() : 'Klub Lain'
          
          // Clean gender
          let genderVal = 'Putra'
          const rawGenderStr = row[mappings.gender] ? String(row[mappings.gender]).toLowerCase() : ''
          if (rawGenderStr.includes('putri') || rawGenderStr === 'p' || rawGenderStr.includes('female') || rawGenderStr.includes('wanita')) {
            genderVal = 'Putri'
          }
          
          // Clean weight (replace comma with dot, extract float number)
          let weightVal = 60
          const rawWeightStr = row[mappings.weight] ? String(row[mappings.weight]).trim() : ''
          if (rawWeightStr) {
            const normalizedWeight = rawWeightStr.replace(',', '.')
            const matchFloat = normalizedWeight.match(/[0-9.]+(\.[0-9]+)?/)
            if (matchFloat) {
              weightVal = parseFloat(matchFloat[0]) || 60
            }
          }
          
          // Match and map category (Nomor Pertandingan) against the configured matchTypes rules
          const rawMatchType = row[mappings.matchType] ? String(row[mappings.matchType]).trim() : ''
          let matchTypeVal = this.rules.matchTypes[0] || 'Fighting System'
          if (rawMatchType) {
            const matchedType = this.rules.matchTypes.find(
              (t) => t.toLowerCase().includes(rawMatchType.toLowerCase()) || rawMatchType.toLowerCase().includes(t.toLowerCase())
            )
            if (matchedType) {
              matchTypeVal = matchedType
            } else {
              matchTypeVal = rawMatchType
            }
          }
          
          // Parse Age
          let ageVal = 20
          const rawAge = row[mappings.age]
          if (rawAge !== undefined && rawAge !== null) {
            const strAge = String(rawAge).trim()
            const num = parseInt(strAge.replace(/[^0-9]/g, ''))
            if (!isNaN(num)) {
              ageVal = num
            }
          }
          
          return {
            name: nameVal,
            club: clubVal,
            gender: genderVal,
            age: ageVal,
            weight: weightVal,
            matchType: matchTypeVal,
          }
        })
        
        this.dialogMapping = false
        this.processAutoGrouping()
        this.generateAllBrackets()
        
        this.notif = true
        this.notifColor = 'success'
        this.notifMsg = `Berhasil mengimpor dan memetakan ${this.rawAthletes.length} atlet!`
      } catch (err) {
        // eslint-disable-next-line no-console
        console.error(err)
        this.notif = true
        this.notifColor = 'error'
        this.notifMsg = 'Gagal memproses pemetaan kolom.'
      }
    },

    processAutoGrouping() {
      const categoriesMap = {}

      this.rawAthletes.forEach((athlete) => {
        const matchedType = this.rules.matchTypes.find(
          (t) => t.toLowerCase() === athlete.matchType.toLowerCase()
        ) || athlete.matchType

        const genderClean = athlete.gender.toLowerCase().includes('putri') ? 'Putri' : 'Putra'

        const matchedAge = this.rules.ageGroups.find(
          (g) => athlete.age >= g.min && athlete.age <= g.max
        )
        const ageGroupName = matchedAge ? matchedAge.name : 'Usia Bebas'

        const matchedWeight = this.rules.weightClasses.find(
          (w) => athlete.weight >= w.min && athlete.weight <= w.max
        )
        const weightClassName = matchedWeight ? matchedWeight.name : `${athlete.weight} kg`

        const finalCategoryName = `${matchedType} ${genderClean} ${ageGroupName} ${weightClassName}`

        if (!categoriesMap[finalCategoryName]) {
          categoriesMap[finalCategoryName] = []
        }
        categoriesMap[finalCategoryName].push(athlete)
      })

      this.mappedCategories = Object.keys(categoriesMap).map((key) => ({
        categoryName: key,
        athletes: categoriesMap[key],
      }))
    },

    getNextPowerOf2(n) {
      if (n <= 2) return 2
      let p = 2
      while (p < n) {
        p *= 2
      }
      return p
    },

    openAthletesList(cat) {
      this.activeCategoryRule = cat
      this.dialogAthletes = true
    },

    hideBye() {
      document.querySelectorAll('.player-hidden').forEach(child => {
          const parent1 = child.closest('.vtb-item-child');
          if (parent1) {
            const parent2 = parent1.closest('.vtb-item');
            if (parent2) {
              const parentVtbItemChild = parent2.closest('.vtb-item-child');
              if (parentVtbItemChild) {
                  parentVtbItemChild.remove();
              }
            }
          }
      });
      document.querySelectorAll('.player-get-bye').forEach(child => {
          const parent1 = child.closest('.vtb-item-child');
          if (parent1) {
            const parent2 = parent1.closest('.vtb-item');
            if (parent2) {
              const parentVtbItemChild = parent2.closest('.vtb-item-child');
              if (parentVtbItemChild) {
                  parentVtbItemChild.remove();
              }
            }
          }
      });
    },

    shuffleCurrentCategory() {
      if (this.selectedCategoryIdx === null) return;
      const cat = this.mappedCategories.find((c, i) => i === this.selectedCategoryIdx);
      if (!cat || !cat.athletes) return;

      // Fisher-Yates shuffle
      const arr = cat.athletes;
      for (let i = arr.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        const temp = arr[i];
        arr[i] = arr[j];
        arr[j] = temp;
      }

      // Regenerate brackets (preserving selections)
      this.generateAllBrackets();

      this.notif = true;
      this.notifColor = 'success';
      this.notifMsg = 'Data bagan berhasil di-shuffle!';
    },

    printBracket() {
      this.isPrintingAll = false;
      const bracketEl = document.getElementById('bracketData');
      if (bracketEl) {
        this.bracketHtml = bracketEl.innerHTML;
        this.actualWidth = bracketEl.scrollWidth || 1000;
        this.actualHeight = bracketEl.scrollHeight || 600;
      }
      this.printDialog = true;
    },

    printAllBrackets() {
      this.isPrintingAll = true;
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
        if (this.isPrintingAll) {
          scaleCss = `
            #allBracketsPrintData {
              transform: scale(${scaleVal}) !important;
              transform-origin: top center !important;
              width: ${100 / scaleVal}% !important;
            }
          `;
        } else {
          scaleCss = `
            #bracketData {
              transform: scale(${scaleVal}) !important;
              transform-origin: top left !important;
              width: ${100 / scaleVal}% !important;
            }
          `;
        }
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

      if (this.isPrintingAll) {
        document.body.classList.add('printing-all-active');
      } else {
        document.body.classList.remove('printing-all-active');
      }

      this.printDialog = false;
      setTimeout(() => {
        window.print();
        // Clean up
        document.body.classList.remove('printing-all-active');
        this.isPrintingAll = false;
      }, 500);
    },

    submitBracket() {
      if (!this.selectedCategory) {
        this.notif = true;
        this.notifColor = 'error';
        this.notifMsg = 'Belum ada bagan kategori yang aktif!';
        return;
      }
      if (!this.selectedMartialId) {
        this.notif = true;
        this.notifColor = 'error';
        this.notifMsg = 'Silakan pilih Cabang Olahraga terlebih dahulu di atas!';
        return;
      }
      if (!this.tournamentName || !this.tournamentName.trim()) {
        this.notif = true;
        this.notifColor = 'error';
        this.notifMsg = 'Silakan isi Nama Turnamen terlebih dahulu di atas!';
        return;
      }

      this.loadingSave = true;

      // 1. Build the flat array of matches 'games'
      const games = [];
      let matchIdx = 1;
      this.selectedCategory.bracket.forEach((round) => {
        const roundData = [];
        round.games.forEach((game) => {
          roundData.push({
            id: game.player1.id,
            name: game.player1.name,
            club: game.player2.name,
            winner: false,
            match_number: matchIdx,
          });
        });
        games.push(roundData);
        matchIdx++;
      });

      // 2. Map games to charts array (red vs blue corners)
      const charts = [];
      games.forEach((roundGames) => {
        for (let i = 0; i < roundGames.length; i += 2) {
          if (roundGames.length > 1) {
            charts.push({
              red_name: roundGames[i].name === 'Waiting' ? null : roundGames[i].name,
              red_club: roundGames[i].club === 'Club' ? null : roundGames[i].club,
              blue_name: roundGames[i + 1].name === 'Waiting' ? null : roundGames[i + 1].name,
              blue_club: roundGames[i + 1].club === 'Club' ? null : roundGames[i + 1].club,
              match_number: roundGames[i].match_number,
            });
          } else {
            charts.push({
              red_name: roundGames[i].name === 'Waiting' ? null : roundGames[i].name,
              red_club: roundGames[i].club === 'Club' ? null : roundGames[i].club,
              blue_name: null,
              blue_club: null,
              match_number: roundGames[i].match_number,
            });
          }
        }
      });

      // 3. Prepare parameters for /api/save-bracket
      const url = '/api/save-bracket';
      const params = {
        martial_id: this.selectedMartialId,
        tournament_name: this.tournamentName.trim(),
        tournament_id: null,
        category_name: this.selectedCategory.categoryName,
        bracket: JSON.stringify(this.selectedCategory.bracket),
        games: charts,
      };

      // 4. Send API POST request
      this.$axios.post(url, params)
        .then((result) => {
          this.loadingSave = false;
          this.notif = true;
          this.notifColor = 'success';
          this.notifMsg = 'Bagan turnamen berhasil disimpan ke database!';
        })
        .catch((err) => {
          this.loadingSave = false;
          this.notif = true;
          this.notifColor = 'error';
          this.notifMsg = 'Gagal menyimpan bagan: ' + (err.response?.data?.message || err.message);
        });
    },

    async submitAllBrackets() {
      if (!this.selectedMartialId) {
        this.notif = true;
        this.notifColor = 'error';
        this.notifMsg = 'Silakan pilih Cabang Olahraga terlebih dahulu di atas!';
        return;
      }
      if (!this.tournamentName || !this.tournamentName.trim()) {
        this.notif = true;
        this.notifColor = 'error';
        this.notifMsg = 'Silakan isi Nama Turnamen terlebih dahulu di atas!';
        return;
      }
      if (this.generatedBrackets.length === 0) {
        this.notif = true;
        this.notifColor = 'error';
        this.notifMsg = 'Belum ada bagan yang dibuat!';
        return;
      }

      this.loadingSaveAll = true;
      let successCount = 0;
      let failCount = 0;
      let tournamentId = null;
      const failedCategoryNames = [];

      for (let idx = 0; idx < this.generatedBrackets.length; idx++) {
        const category = this.generatedBrackets[idx];
        
        // Show status message in notification
        this.notif = true;
        this.notifColor = 'info';
        this.notifMsg = `Menyimpan kategori (${idx + 1}/${this.generatedBrackets.length}): ${category.categoryName}...`;

        // 1. Build games
        const games = [];
        let matchIdx = 1;
        category.bracket.forEach((round) => {
          const roundData = [];
          round.games.forEach((game) => {
            roundData.push({
              id: game.player1.id,
              name: game.player1.name,
              club: game.player2.name,
              winner: false,
              match_number: matchIdx,
            });
          });
          games.push(roundData);
          matchIdx++;
        });

        // 2. Map charts
        const charts = [];
        games.forEach((roundGames) => {
          for (let i = 0; i < roundGames.length; i += 2) {
            if (roundGames.length > 1) {
              charts.push({
                red_name: roundGames[i].name === 'Waiting' ? null : roundGames[i].name,
                red_club: roundGames[i].club === 'Club' ? null : roundGames[i].club,
                blue_name: roundGames[i + 1].name === 'Waiting' ? null : roundGames[i + 1].name,
                blue_club: roundGames[i + 1].club === 'Club' ? null : roundGames[i + 1].club,
                match_number: roundGames[i].match_number,
              });
            } else {
              charts.push({
                red_name: roundGames[i].name === 'Waiting' ? null : roundGames[i].name,
                red_club: roundGames[i].club === 'Club' ? null : roundGames[i].club,
                blue_name: null,
                blue_club: null,
                match_number: roundGames[i].match_number,
              });
            }
          }
        });

        // 3. Save via API
        const url = '/api/save-bracket';
        const params = {
          martial_id: this.selectedMartialId,
          tournament_name: this.tournamentName.trim(),
          tournament_id: tournamentId,
          category_name: category.categoryName,
          bracket: JSON.stringify(category.bracket),
          games: charts,
        };

        try {
          const result = await this.$axios.post(url, params);
          if (result.data && result.data.tournament_id) {
            tournamentId = result.data.tournament_id;
          }
          successCount++;
        } catch (err) {
          failCount++;
          failedCategoryNames.push(category.categoryName);
          // eslint-disable-next-line no-console
          console.error(`Gagal menyimpan ${category.categoryName}:`, err);
        }
      }

      this.loadingSaveAll = false;
      this.notif = true;

      if (failCount === 0) {
        this.notifColor = 'success';
        this.notifMsg = `Berhasil menyimpan semua (${successCount}) bagan kategori ke database!`;
      } else {
        if (successCount > 0) {
          this.notifColor = 'warning';
          this.notifMsg = `Berhasil menyimpan ${successCount} bagan, tetapi ${failCount} bagan gagal disimpan.`;
        } else {
          this.notifColor = 'error';
          this.notifMsg = 'Gagal menyimpan semua bagan kategori ke database.';
        }
        
        // Show detailed pop-up alert listing the failures
        alert(`Perhatian! Gagal menyimpan ${failCount} bagan kategori berikut:\n\n` + failedCategoryNames.map(name => `• ${name}`).join('\n'));
      }
    },

    winData(player) {
      if (!this.selectedCategory) return;
      const bracket = this.selectedCategory.bracket;
      this.tempPlayer = bracket[player.match]?.games[player.index];
      this.notif = true;
      this.notifColor = 'info';
      this.notifMsg = `Pemenang disalin: ${player.name}. Klik ikon arah panah di slot tujuan untuk menempel.`;
    },

    setWinData(player) {
      if (!this.tempPlayer || !this.selectedCategory) return;
      const bracket = this.selectedCategory.bracket;
      const game = bracket[player.match]?.games[player.index];
      if (game) {
        // Copy athlete name and club to the destination game
        game.player1.name = this.tempPlayer.player1.name;
        game.player2.name = this.tempPlayer.player2.name;
        
        // Trigger Vue reactivity update
        this.selectedCategory.bracket = [...bracket];
        
        this.tempPlayer = null;
        this.notif = true;
        this.notifColor = 'success';
        this.notifMsg = 'Pemenang berhasil ditempel!';
      }
    },

    generateAllBrackets() {
      const generated = []

      this.mappedCategories.forEach((cat, catIdx) => {
        if (cat.athletes.length < 2) return

        const athletes = [...cat.athletes]
        const n = athletes.length
        const size = this.getNextPowerOf2(n)
        const roundsCount = Math.log2(size)

        const seededList = this.seedAthletes(athletes, size)
        const matches = []

        // Round 0 (First Column): each player box is a game object representing a single athlete
        // player1 is athlete's Name, player2 is athlete's Club
        const r0Games = []
        let matchIndex = 1
        for (let i = 0; i < size; i++) {
          const athlete = seededList[i] || { name: 'BYE', club: 'BYE' }
          const oppIndex = (i % 2 === 0) ? (i + 1) : (i - 1)
          const opp = seededList[oppIndex]
          const isGetBye = opp && opp.name === 'BYE'

          r0Games.push({
            player1: {
              id: i + '-' + athlete.club,
              name: athlete.name,
              club: athlete.club,
              match: 0,
              index: i,
              setting: true,
              hidden: athlete.name === 'BYE',
              isGetBye,
              winner: athlete.name === 'BYE' ? null : true,
            },
            player2: {
              id: i + '-' + athlete.club,
              name: athlete.club,
              club: athlete.club,
              match: 0,
              index: i,
              setting: false,
              hidden: athlete.name === 'BYE',
              winner: athlete.name === 'BYE' ? null : true,
            },
            matchNumber: matchIndex++,
          })
        }
        matches.push({ games: r0Games })

        // Subsequent rounds
        for (let r = 1; r <= roundsCount; r++) {
          const prevGamesCount = matches[r - 1].games.length
          const currentGamesCount = prevGamesCount / 2
          const rGames = []

          for (let g = 0; g < currentGamesCount; g++) {
            rGames.push({
              player1: {
                id: null,
                name: 'Waiting',
                club: 'Club',
                match: r,
                index: g,
                setting: true,
                winner: null,
              },
              player2: {
                id: null,
                name: 'Club',
                club: 'Club',
                match: r,
                index: g,
                setting: false,
                winner: null,
              },
              matchNumber: matchIndex++,
            })
          }
          matches.push({ games: rGames })
        }

        generated.push({
          idx: catIdx,
          categoryName: cat.categoryName,
          bracket: matches,
        })
      })

      this.generatedBrackets = generated
      this.chartHidden = []
      if (generated.length > 0) {
        if (this.selectedCategoryIdx === null || !generated.some(g => g.idx === this.selectedCategoryIdx)) {
          this.selectedCategoryIdx = generated[0].idx
        }
        this.activeStep = 3
        this.notif = true
        this.notifColor = 'success'
        this.notifMsg = 'Bagan tanding berhasil digambar!'
      }
    },

    seedAthletes(athletes, size) {
      const clubGroups = {}
      athletes.forEach((a) => {
        if (!clubGroups[a.club]) clubGroups[a.club] = []
        clubGroups[a.club].push(a)
      })

      const sortedClubs = Object.keys(clubGroups).sort(
        (a, b) => clubGroups[b].length - clubGroups[a].length
      )

      const spreadList = []
      let hasMore = true
      let pass = 0
      while (hasMore) {
        hasMore = false
        // eslint-disable-next-line no-loop-func
        sortedClubs.forEach((clubName) => {
          if (clubGroups[clubName][pass]) {
            spreadList.push(clubGroups[clubName][pass])
            hasMore = true
          }
        })
        pass++
      }

      const seeded = new Array(size).fill(null)
      const numByes = size - athletes.length

      // Tentukan posisi BYE di indeks ganjil dari matches awal untuk menghindari BYE vs BYE
      const byePositions = []
      for (let i = 0; i < numByes; i++) {
        byePositions.push(i * 2 + 1)
      }

      let athleteIdx = 0
      for (let i = 0; i < size; i++) {
        if (byePositions.includes(i)) {
          seeded[i] = { name: 'BYE', club: 'BYE' }
        } else {
          seeded[i] = spreadList[athleteIdx] || { name: 'BYE', club: 'BYE' }
          athleteIdx++
        }
      }

      return seeded
    },
  },
}
</script>

<style scoped>
@import '~/assets/styles.css';

/* ============================================
   SANDBOX PAGE — Design System
   Matches main dashboard (chart/index.vue)
   ============================================
   Colors:
     Surface:      #121212 (+ rgba(0,0,0,0.2) gradient)
     Surface-2:    #1a1a1f (inner card / dialog)
     Border:       rgba(255,255,255,0.07)
     Text-primary: rgba(255,255,255,0.87)   → white--text
     Text-muted:   rgba(255,255,255,0.45)   → blackgrey--text
     Accent:       #EF233C (primaryred)
     Accent-hover: #C8102E
     Success:      #00C853
     Error:        #FF3D00

   Typography (Poppins, from styles.css):
     text-18 → section labels
     text-14 → body / inputs
     text-12 → meta / captions
     font-weight-semi → 600

   Spacing (8pt grid):
     pa-6 = 24px, mb-6 = 24px, px-6 = 24px
     pa-4 = 16px, mb-4 = 16px
     gap: 8px / 16px

   Border-radius:
     card:   20px  (.card-dashboard)
     button: 8px   (.rounded-8)
     chip:   4px
     input:  8px

   Elevation / Shadows:
     card:   box-shadow: 11px 11px 62px 7px #000000, -11px -11px 51px 1px rgba(48,48,48,0.54)
     dialog: box-shadow: 0 4px 24px rgba(0,0,0,0.7)

   Transitions: 200ms ease (interactive), 300ms ease (layout)
============================================ */

/* ── Container ─────────────────────────────── */
.sandbox-container {
  font-family: 'Poppins', sans-serif;
  max-width: 1000px;
  margin: 0 auto;
  padding: 0;
}

/* ── Back Link ──────────────────────────────── */
.back-link {
  font-size: 14px;
  font-weight: 600;
  color: rgba(255, 255, 255, 0.55);
  transition: color 200ms ease;
  cursor: pointer;
}
.back-link:hover {
  color: rgba(255, 255, 255, 0.87);
}

/* ── Card — identical to dashboard card-dashboard ── */
.card-sandbox {
  max-width: 1000px;
  margin: 0 auto;
  background: linear-gradient(0deg, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), #121212;
  box-shadow: 11px 11px 62px 7px #000000, -11px -11px 51px 1px rgba(48, 48, 48, 0.54);
  border-radius: 20px;
}

/* Re-use the global card-dashboard for inner cards */
.card-dialog {
  background: #1a1a1f !important;
  box-shadow: 0 4px 24px rgba(0, 0, 0, 0.7) !important;
  border-radius: 16px !important;
}

/* ── Modern Rules Panels (Step 1) ────────── */
.rules-card-panel {
  background: rgba(255, 255, 255, 0.01);
  border: 1px solid rgba(255, 255, 255, 0.06);
  border-radius: 12px;
  overflow: hidden;
  height: 100%;
  display: flex;
  flex-direction: column;
  transition: border-color 0.25s ease, box-shadow 0.25s ease;
}

.rules-card-panel:hover {
  border-color: rgba(239, 35, 60, 0.15);
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
}

.rules-card-header {
  padding: 14px 16px;
  background: rgba(255, 255, 255, 0.02);
  border-bottom: 1px solid rgba(255, 255, 255, 0.06);
  display: flex;
  align-items: center;
}

.rules-card-title {
  font-size: 13px;
  font-weight: 600;
  color: rgba(255, 255, 255, 0.8);
  letter-spacing: 0.3px;
}

.rules-card-body {
  padding: 16px;
  flex: 1;
  max-height: 320px;
  overflow-y: auto;
}

/* Custom scrollbar for card body */
.rules-card-body::-webkit-scrollbar {
  width: 5px;
}
.rules-card-body::-webkit-scrollbar-track {
  background: transparent;
}
.rules-card-body::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.08);
  border-radius: 4px;
}
.rules-card-body::-webkit-scrollbar-thumb:hover {
  background: rgba(255, 255, 255, 0.15);
}

.rules-card-row {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 10px;
}

.rules-card-row:last-child {
  margin-bottom: 0;
}

/* Range input group wrapper */
.rules-range-box {
  display: flex;
  align-items: center;
  gap: 4px;
  background: rgba(255, 255, 255, 0.01);
  border: 1px solid rgba(255, 255, 255, 0.06);
  border-radius: 6px;
  padding: 2px;
}

.rules-range-sep {
  font-size: 11px;
  color: rgba(255, 255, 255, 0.25);
  font-weight: 600;
  user-select: none;
}

/* Inputs styling override */
.rules-card-body >>> .v-input--outlined > .v-input__control > .v-input__slot {
  background: rgba(255, 255, 255, 0.02) !important;
  border: 1px solid rgba(255, 255, 255, 0.08) !important;
  border-radius: 6px !important;
  min-height: 32px !important;
}

.rules-card-body >>> .v-input--outlined.v-input--is-focused > .v-input__control > .v-input__slot {
  border-color: #EF233C !important;
}

.rules-card-body >>> .v-input--outlined fieldset {
  display: none !important; /* Hide native fieldset border to use slot border */
}

.rules-card-body >>> input {
  font-size: 12px !important;
  padding: 6px 8px !important;
  height: 32px !important;
}

.rules-input-num {
  max-width: 72px !important;
}

.rules-card-row >>> .v-btn--icon.v-size--x-small {
  width: 24px !important;
  height: 24px !important;
  min-width: 24px !important;
  margin-left: 2px !important;
}

.rules-input-num >>> .v-input__slot {
  padding: 0 4px !important;
}

.rules-input-num >>> input {
  text-align: center !important;
  padding: 6px 0 !important;
}

/* Hide spin-buttons for range inputs */
.rules-input-num >>> input::-webkit-outer-spin-button,
.rules-input-num >>> input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

.rules-input-num >>> input[type=number] {
  -moz-appearance: textfield;
}

.rules-card-footer {
  padding: 10px 16px;
  background: rgba(255, 255, 255, 0.01);
  border-top: 1px solid rgba(255, 255, 255, 0.04);
}

.rules-add-btn {
  font-size: 11px;
  font-weight: 600;
  font-family: 'Poppins', sans-serif;
  color: #EF233C;
  display: inline-flex;
  align-items: center;
  gap: 4px;
  cursor: pointer;
  background: none;
  border: none;
  padding: 4px 6px;
  border-radius: 4px;
  transition: background 0.2s ease, opacity 0.2s ease;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.rules-add-btn:hover {
  background: rgba(239, 35, 60, 0.08);
}


/* ── Step Toggle Navigation ─────────────────── */
.step-nav {
  display: flex;
  align-items: center;
  border-bottom: 1px solid rgba(255, 255, 255, 0.07);
}

.step-nav-btn {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 14px 24px;
  font-size: 13px;
  font-weight: 600;
  font-family: 'Poppins', sans-serif;
  color: rgba(255, 255, 255, 0.4);
  cursor: pointer;
  border-bottom: 2px solid transparent;
  transition: color 200ms ease, border-color 200ms ease, background 200ms ease;
  user-select: none;
  letter-spacing: 0.2px;
}

.step-nav-btn:hover {
  color: rgba(255, 255, 255, 0.75);
  background: rgba(255, 255, 255, 0.03);
}

.step-nav-btn.active {
  color: #EF233C;
  border-bottom-color: #EF233C;
}

.step-nav-btn .step-num {
  width: 22px;
  height: 22px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.06);
  font-size: 11px;
  font-weight: 700;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  transition: background 200ms ease;
}

.step-nav-btn.active .step-num {
  background: #EF233C;
  color: #fff;
}

/* ── Section wrapper ────────────────────────── */
.section-body {
  padding: 24px;
}

/* ── Inner section title (replaces h3) ───────── */
.section-label {
  font-size: 12px;
  font-weight: 600;
  letter-spacing: 1px;
  text-transform: uppercase;
  color: rgba(255, 255, 255, 0.35);
  margin-bottom: 16px;
}

/* ── Divider ────────────────────────────────── */
.divider-dark {
  border: none;
  border-top: 1px solid rgba(255, 255, 255, 0.07);
}

/* ── Custom Tabs (Nomor/Usia/Berat) ─────────── */
.custom-tabs >>> .v-tab {
  letter-spacing: 0;
  font-size: 13px;
  font-weight: 600;
  font-family: 'Poppins', sans-serif;
  text-transform: none;
  color: rgba(255, 255, 255, 0.4) !important;
  transition: color 200ms ease;
}

.custom-tabs >>> .v-tab--active {
  color: #EF233C !important;
}

.custom-tabs >>> .v-tabs-slider {
  background: #EF233C !important;
}

/* ── Input overrides ────────────────────────── */
div >>> .v-input input,
div >>> .v-input textarea {
  color: rgba(255, 255, 255, 0.87) !important;
  font-family: 'Poppins', sans-serif !important;
  font-size: 13px !important;
}
div >>> .v-label {
  color: rgba(255, 255, 255, 0.45) !important;
  font-size: 13px !important;
}
div >>> .v-text-field--outlined fieldset {
  border-color: rgba(255, 255, 255, 0.1) !important;
}
div >>> .v-input__icon--append .v-icon {
  color: rgba(255, 255, 255, 0.3) !important;
}
div >>> .v-text-field.v-text-field--solo .v-input__control {
  background: rgba(255, 255, 255, 0.04) !important;
  border: 1px solid rgba(255, 255, 255, 0.08) !important;
}

/* ── Row item (rule input row) ──────────────── */
.rule-row {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 8px;
}

/* ── Dropzone ───────────────────────────────── */
.dropzone-area {
  border: 1px dashed rgba(255, 255, 255, 0.15);
  border-radius: 12px;
  background: rgba(255, 255, 255, 0.02);
  cursor: pointer;
  transition: background 200ms ease, border-color 200ms ease;
  min-height: 120px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.dropzone-area:hover {
  background: rgba(255, 255, 255, 0.04);
  border-color: rgba(239, 35, 60, 0.5);
}

.dropzone-area.has-file {
  background: rgba(0, 200, 83, 0.04);
  border-color: rgba(0, 200, 83, 0.4);
}

.dropzone-area.is-dragging {
  border-color: #EF233C;
  background: rgba(239, 35, 60, 0.05);
}

/* ── Table ──────────────────────────────────── */
div >>> .v-data-table,
div >>> .v-simple-table {
  background: transparent !important;
}

div >>> .v-simple-table td,
div >>> .v-simple-table th {
  border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
  font-family: 'Poppins', sans-serif !important;
  font-size: 13px !important;
}

div >>> .v-simple-table th {
  color: rgba(255, 255, 255, 0.35) !important;
  font-weight: 600 !important;
  font-size: 11px !important;
  letter-spacing: 0.8px !important;
  text-transform: uppercase !important;
}

/* ── Bracket viewer area ────────────────────── */
.bracket-viewer-workspace {
  background: rgba(0, 0, 0, 0.3);
  border-radius: 12px;
  border: 1px solid rgba(255, 255, 255, 0.07);
}

.bracket-toolbar {
  border-bottom: 1px solid rgba(255, 255, 255, 0.07);
  padding-bottom: 16px;
  margin-bottom: 16px;
  display: flex;
  align-items: center;
  justify-content: flex-end;
  flex-wrap: wrap;
  gap: 8px;
}

.bracket-render-container {
  overflow-x: auto;
  padding: 16px 0;
}

/* ── Bracket nodes ──────────────────────────── */
div >>> .vtb-player {
  color: #000 !important;
  background: #fff !important;
  border-radius: 8px;
  min-width: 200px;
  max-width: 200px;
  border: 1px solid #000;
}

div >>> .vtb-player1 { border-radius: 8px 8px 0 0; }
div >>> .vtb-player2 { border-radius: 0 0 8px 8px; }

div >>> .vtb-item-players {
  background: transparent !important;
}

.icon-win {
  float: right;
}

/* ── Empty state ────────────────────────────── */
.empty-state {
  padding: 48px 24px;
  text-align: center;
}

/* ── Helper widths ──────────────────────────── */
.max-w-300 { max-width: 300px; }
.max-w-500 { max-width: 500px; }
.max-w-600 { max-width: 600px; }
.max-h-300 { max-height: 300px; overflow-y: auto; }

.bracket-print-title {
  text-align: center;
  font-size: 20px;
  font-weight: 700;
  color: #ffffff;
  margin-bottom: 24px;
  font-family: 'Poppins', sans-serif;
  letter-spacing: 0.5px;
}

/* ── Print Preview ──────────────────────────── */
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
  color: #000000 !important;
  border: 1px solid #000000 !important;
  border-radius: 8px;
  min-width: 200px !important;
  max-width: 200px !important;
  padding: 8px 12px !important;
  height: 52px !important;
  display: flex !important;
  flex-direction: column !important;
  justify-content: center !important;
}

.print-preview-sheet .player-hidden {
  visibility: hidden !important;
}

/* ── @media print ───────────────────────────── */
@media print {
  * {
    -webkit-print-color-adjust: exact !important;
    print-color-adjust: exact !important;
  }

  body, html, #__nuxt, #__layout,
  .v-application, .v-application--wrap,
  .v-main, .v-main__wrap, .v-container,
  .v-card, .bracket-viewer-workspace,
  .card-dashboard, .sandbox-container {
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
    backdrop-filter: none !important;
  }

  #minimal-header-container,
  .step-nav,
  .print-hide,
  #bracket-select-header,
  .bracket-toolbar,
  .v-navigation-drawer,
  .v-app-bar,
  .v-footer,
  .icon-win,
  .v-btn {
    display: none !important;
  }

  #bracketData.bracket-render-container {
    background: #ffffff !important;
    display: block !important;
    position: static !important;
    width: max-content !important;
    max-width: none !important;
    overflow: visible !important;
    margin: 0 !important;
    padding: 0 !important;
  }

  .player-hidden { visibility: hidden !important; }

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

  .bracket-print-title {
    color: #000000 !important;
    font-size: 24px !important;
    margin-bottom: 30px !important;
    display: block !important;
  }
}

/* ── Print-all utility classes ── */
div >>> .print-all-only {
  display: none !important;
}

div >>> .print-single-only {
  display: block;
}

@media print {
  body:not(.printing-all-active) div >>> .print-all-only {
    display: none !important;
  }
  body:not(.printing-all-active) div >>> .print-single-only {
    display: block !important;
  }

  body.printing-all-active div >>> .print-single-only {
    display: none !important;
  }
  body.printing-all-active div >>> .print-all-only {
    display: block !important;
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
}
</style>
