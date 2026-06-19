<template>
  <div class="roster-root">
    <!-- Loading state -->
    <div v-if="loading" class="loading-screen">
      <div class="spinner"></div>
      <p class="loading-text">Memuat data peserta...</p>
    </div>

    <!-- Error state -->
    <div v-else-if="error" class="error-screen">
      <div class="error-icon">⚠️</div>
      <h2>Gagal memuat data</h2>
      <p>{{ error }}</p>
    </div>

    <!-- Main content -->
    <div v-else class="roster-container">
      <!-- Header -->
      <header class="roster-header">
        <div class="header-inner">
          <div class="tournament-badge">TURNAMEN</div>
          <h1 class="tournament-title">{{ tournamentName }}</h1>
          <p class="tournament-meta">
            <span class="meta-item">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
              Total {{ participants.length }} Peserta
            </span>
            <span class="meta-divider">·</span>
            <span class="meta-item">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/></svg>
              {{ uniqueCategories }} Kategori
            </span>
          </p>
        </div>
      </header>

      <!-- Search & Filter bar -->
      <div class="toolbar">
        <div class="search-wrap">
          <svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
          <input
            v-model="search"
            class="search-input"
            placeholder="Cari nama atlet, dojo, atau kategori..."
          />
        </div>
        <div class="filter-group">
          <select v-model="filterCategory" class="filter-select">
            <option value="">Semua Kategori</option>
            <option v-for="cat in categoryList" :key="cat" :value="cat">{{ cat }}</option>
          </select>
          <select v-model="filterStatus" class="filter-select">
            <option value="">Semua Status</option>
            <option value="Menunggu">Menunggu</option>
            <option value="Sedang Bertanding">Sedang Bertanding</option>
            <option value="Selesai">Selesai</option>
          </select>
        </div>
      </div>

      <!-- Stats row -->
      <div class="stats-row">
        <div class="stat-card stat-waiting">
          <span class="stat-num">{{ countByStatus('Menunggu') }}</span>
          <span class="stat-label">Menunggu</span>
        </div>
        <div class="stat-card stat-playing">
          <span class="stat-num">{{ countByStatus('Sedang Bertanding') }}</span>
          <span class="stat-label">Bertanding</span>
        </div>
        <div class="stat-card stat-done">
          <span class="stat-num">{{ countByStatus('Selesai') }}</span>
          <span class="stat-label">Selesai</span>
        </div>
      </div>

      <!-- Table -->
      <div class="table-wrap">
        <table class="roster-table">
          <thead>
            <tr>
              <th class="th-no">No.</th>
              <th class="th-match" @click="sortBy('match_number')">
                Nomor Pertandingan
                <span class="sort-icon">{{ sortKey === 'match_number' ? (sortAsc ? '↑' : '↓') : '↕' }}</span>
              </th>
              <th class="th-athlete" @click="sortBy('athlete_name')">
                Nama Atlet
                <span class="sort-icon">{{ sortKey === 'athlete_name' ? (sortAsc ? '↑' : '↓') : '↕' }}</span>
              </th>
              <th class="th-dojo" @click="sortBy('dojo')">
                Dojo / Klub
                <span class="sort-icon">{{ sortKey === 'dojo' ? (sortAsc ? '↑' : '↓') : '↕' }}</span>
              </th>
              <th class="th-cat" @click="sortBy('category_name')">
                Kategori
                <span class="sort-icon">{{ sortKey === 'category_name' ? (sortAsc ? '↑' : '↓') : '↕' }}</span>
              </th>
              <th class="th-corner">Sudut</th>
              <th class="th-status">Status</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(row, index) in paginatedRows"
              :key="index"
              class="table-row"
            >
              <td class="td-no">{{ (currentPage - 1) * perPage + index + 1 }}</td>
              <td class="td-match">
                <a
                  class="match-link"
                  :href="`/user/chart/detail?id=${row.category_id}`"
                  target="_blank"
                  :title="`Lihat bagan kategori ${row.category_name}`"
                >
                  #{{ row.match_number }}
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" style="opacity:0.6"><path d="M19 19H5V5h7V3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z"/></svg>
                </a>
              </td>
              <td class="td-athlete">
                <div class="athlete-cell">
                  <span class="athlete-name">{{ row.athlete_name }}</span>
                  <span v-if="row.winner" class="winner-badge">🏆 Menang</span>
                </div>
              </td>
              <td class="td-dojo">{{ row.dojo || '—' }}</td>
              <td class="td-cat">
                <span class="category-chip">{{ row.category_name }}</span>
              </td>
              <td class="td-corner">
                <span :class="['corner-dot', row.corner === 'Merah' ? 'red-corner' : 'blue-corner']">
                  {{ row.corner }}
                </span>
              </td>
              <td class="td-status">
                <span :class="['status-badge', statusClass(row.status)]">{{ row.status }}</span>
              </td>
            </tr>
            <tr v-if="filteredRows.length === 0">
              <td colspan="7" class="empty-row">
                <div class="empty-state">
                  <span class="empty-icon">🔍</span>
                  <p>Tidak ada data yang cocok dengan pencarian.</p>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div v-if="totalPages > 1" class="pagination">
        <button class="page-btn" :disabled="currentPage === 1" @click="currentPage--">‹</button>
        <button
          v-for="p in visiblePages"
          :key="p"
          class="page-btn"
          :class="{ active: p === currentPage }"
          @click="currentPage = p"
        >{{ p }}</button>
        <button class="page-btn" :disabled="currentPage === totalPages" @click="currentPage++">›</button>
        <span class="page-info">{{ (currentPage - 1) * perPage + 1 }}–{{ Math.min(currentPage * perPage, filteredRows.length) }} dari {{ filteredRows.length }}</span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'BracketRoster',
  layout: false,
  data() {
    return {
      loading: true,
      error: null,
      tournamentName: '',
      participants: [],
      search: '',
      filterCategory: '',
      filterStatus: '',
      sortKey: 'match_number',
      sortAsc: true,
      currentPage: 1,
      perPage: 25,
    }
  },
  computed: {
    categoryList() {
      const cats = [...new Set(this.participants.map(p => p.category_name))];
      return cats.sort();
    },
    uniqueCategories() {
      return this.categoryList.length;
    },
    filteredRows() {
      let rows = this.participants;
      if (this.search) {
        const q = this.search.toLowerCase();
        rows = rows.filter(r =>
          (r.athlete_name || '').toLowerCase().includes(q) ||
          (r.dojo || '').toLowerCase().includes(q) ||
          (r.category_name || '').toLowerCase().includes(q) ||
          String(r.match_number).includes(q)
        );
      }
      if (this.filterCategory) {
        rows = rows.filter(r => r.category_name === this.filterCategory);
      }
      if (this.filterStatus) {
        rows = rows.filter(r => r.status === this.filterStatus);
      }
      // Sort
      rows = [...rows].sort((a, b) => {
        let va = a[this.sortKey];
        let vb = b[this.sortKey];
        if (typeof va === 'string') va = va.toLowerCase();
        if (typeof vb === 'string') vb = vb.toLowerCase();
        if (va < vb) return this.sortAsc ? -1 : 1;
        if (va > vb) return this.sortAsc ? 1 : -1;
        return 0;
      });
      return rows;
    },
    totalPages() {
      return Math.ceil(this.filteredRows.length / this.perPage);
    },
    paginatedRows() {
      const start = (this.currentPage - 1) * this.perPage;
      return this.filteredRows.slice(start, start + this.perPage);
    },
    visiblePages() {
      const pages = [];
      const delta = 2;
      for (let i = Math.max(1, this.currentPage - delta); i <= Math.min(this.totalPages, this.currentPage + delta); i++) {
        pages.push(i);
      }
      return pages;
    },
  },
  watch: {
    search() { this.currentPage = 1; },
    filterCategory() { this.currentPage = 1; },
    filterStatus() { this.currentPage = 1; },
  },
  mounted() {
    const tid = this.$route.query.tournament_id;
    if (!tid) {
      this.error = 'Parameter tournament_id tidak ditemukan di URL.';
      this.loading = false;
      return;
    }
    this.loadData(tid);
  },
  methods: {
    async loadData(tid) {
      this.loading = true;
      this.error = null;
      try {
        const res = await this.$axios.$get(`/api/tournament/participants?tournament_id=${tid}`);
        this.tournamentName = res.tournament ? res.tournament.name : `Turnamen #${tid}`;
        this.participants = res.data || [];
      } catch (err) {
        this.error = 'Gagal memuat data peserta dari server.';
      } finally {
        this.loading = false;
      }
    },
    sortBy(key) {
      if (this.sortKey === key) {
        this.sortAsc = !this.sortAsc;
      } else {
        this.sortKey = key;
        this.sortAsc = true;
      }
    },
    countByStatus(status) {
      return this.participants.filter(p => p.status === status).length;
    },
    statusClass(status) {
      if (status === 'Selesai') return 'status-done';
      if (status === 'Sedang Bertanding') return 'status-playing';
      return 'status-waiting';
    },
  },
}
</script>

<style>
* { box-sizing: border-box; margin: 0; padding: 0; }

body {
  font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
  background: #0a0a0f;
  color: #e2e8f0;
  min-height: 100vh;
}

/* ── Loading / Error ── */
.loading-screen, .error-screen {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  gap: 16px;
}
.spinner {
  width: 48px; height: 48px;
  border: 4px solid rgba(255,255,255,0.1);
  border-top-color: #e53935;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }
.loading-text { color: #94a3b8; font-size: 14px; }
.error-icon { font-size: 48px; }
.error-screen h2 { font-size: 20px; color: #f87171; }
.error-screen p { color: #94a3b8; }

/* ── Root ── */
.roster-root { min-height: 100vh; background: #0a0a0f; }
.roster-container { max-width: 1280px; margin: 0 auto; padding: 24px 16px 60px; }

/* ── Header ── */
.roster-header {
  background: linear-gradient(135deg, #1a0a0a 0%, #1e1e2e 100%);
  border: 1px solid rgba(229, 57, 53, 0.3);
  border-radius: 16px;
  padding: 32px 28px;
  margin-bottom: 20px;
  position: relative;
  overflow: hidden;
}
.roster-header::before {
  content: '';
  position: absolute;
  top: -60px; right: -60px;
  width: 200px; height: 200px;
  background: radial-gradient(circle, rgba(229,57,53,0.15) 0%, transparent 70%);
}
.tournament-badge {
  display: inline-block;
  background: rgba(229,57,53,0.2);
  color: #ef5350;
  border: 1px solid rgba(229,57,53,0.4);
  border-radius: 20px;
  padding: 3px 14px;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 1.5px;
  margin-bottom: 10px;
}
.tournament-title {
  font-size: clamp(22px, 4vw, 32px);
  font-weight: 800;
  color: #f1f5f9;
  line-height: 1.2;
  margin-bottom: 10px;
}
.tournament-meta {
  display: flex;
  align-items: center;
  gap: 8px;
  color: #94a3b8;
  font-size: 13px;
}
.meta-item { display: flex; align-items: center; gap: 5px; }
.meta-divider { opacity: 0.4; }

/* ── Toolbar ── */
.toolbar {
  display: flex;
  gap: 12px;
  margin-bottom: 16px;
  flex-wrap: wrap;
}
.search-wrap {
  flex: 1;
  min-width: 240px;
  position: relative;
}
.search-icon {
  position: absolute;
  left: 12px; top: 50%;
  transform: translateY(-50%);
  fill: #64748b;
}
.search-input {
  width: 100%;
  padding: 10px 12px 10px 40px;
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: 10px;
  color: #e2e8f0;
  font-size: 14px;
  outline: none;
  transition: border-color 0.2s;
}
.search-input:focus { border-color: rgba(229,57,53,0.5); }
.search-input::placeholder { color: #4b5563; }
.filter-group { display: flex; gap: 10px; flex-wrap: wrap; }
.filter-select {
  padding: 10px 14px;
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: 10px;
  color: #e2e8f0;
  font-size: 14px;
  cursor: pointer;
  outline: none;
  transition: border-color 0.2s;
}
.filter-select:focus { border-color: rgba(229,57,53,0.5); }
.filter-select option { background: #1e1e2e; color: #e2e8f0; }

/* ── Stats row ── */
.stats-row {
  display: flex;
  gap: 12px;
  margin-bottom: 20px;
}
.stat-card {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 16px 12px;
  border-radius: 12px;
  border: 1px solid;
}
.stat-waiting  { background: rgba(100,116,139,0.1); border-color: rgba(100,116,139,0.3); }
.stat-playing  { background: rgba(245,158,11,0.1);  border-color: rgba(245,158,11,0.3); }
.stat-done     { background: rgba(34,197,94,0.1);   border-color: rgba(34,197,94,0.3); }
.stat-num { font-size: 28px; font-weight: 800; line-height: 1; }
.stat-waiting .stat-num  { color: #94a3b8; }
.stat-playing .stat-num  { color: #f59e0b; }
.stat-done .stat-num     { color: #22c55e; }
.stat-label { font-size: 11px; color: #64748b; margin-top: 4px; text-transform: uppercase; letter-spacing: 0.8px; }

/* ── Table ── */
.table-wrap {
  border-radius: 14px;
  overflow: hidden;
  border: 1px solid rgba(255,255,255,0.08);
  overflow-x: auto;
}
.roster-table {
  width: 100%;
  border-collapse: collapse;
  min-width: 700px;
}
.roster-table thead tr {
  background: rgba(255,255,255,0.05);
}
.roster-table th {
  padding: 13px 16px;
  text-align: left;
  font-size: 12px;
  font-weight: 600;
  color: #64748b;
  letter-spacing: 0.6px;
  text-transform: uppercase;
  white-space: nowrap;
  cursor: pointer;
  user-select: none;
  transition: color 0.2s;
}
.roster-table th:hover { color: #e2e8f0; }
.sort-icon { margin-left: 4px; opacity: 0.5; }
.table-row { border-top: 1px solid rgba(255,255,255,0.05); transition: background 0.15s; }
.table-row:hover { background: rgba(255,255,255,0.03); }
.roster-table td {
  padding: 13px 16px;
  font-size: 14px;
  color: #cbd5e1;
  vertical-align: middle;
}
.td-no { color: #4b5563; font-size: 12px; width: 50px; }

/* Match link */
.match-link {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  color: #ef5350;
  font-weight: 700;
  font-size: 14px;
  text-decoration: none;
  padding: 4px 10px;
  border: 1px solid rgba(229,57,53,0.3);
  border-radius: 8px;
  transition: all 0.2s;
}
.match-link:hover {
  background: rgba(229,57,53,0.15);
  border-color: rgba(229,57,53,0.7);
  color: #ff6b6b;
}

/* Athlete cell */
.athlete-cell { display: flex; align-items: center; gap: 8px; }
.athlete-name { font-weight: 600; color: #f1f5f9; }
.winner-badge {
  font-size: 11px;
  background: rgba(234,179,8,0.15);
  color: #fbbf24;
  border: 1px solid rgba(234,179,8,0.3);
  border-radius: 6px;
  padding: 2px 7px;
  white-space: nowrap;
}

/* Category chip */
.category-chip {
  display: inline-block;
  background: rgba(99,102,241,0.12);
  color: #818cf8;
  border: 1px solid rgba(99,102,241,0.25);
  border-radius: 6px;
  padding: 3px 9px;
  font-size: 12px;
  font-weight: 500;
}

/* Corner dot */
.corner-dot {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-size: 12px;
  font-weight: 600;
  padding: 3px 10px;
  border-radius: 20px;
}
.corner-dot::before {
  content: '';
  width: 8px; height: 8px;
  border-radius: 50%;
}
.red-corner { color: #ef5350; background: rgba(239,83,80,0.12); }
.red-corner::before { background: #ef5350; }
.blue-corner { color: #42a5f5; background: rgba(66,165,245,0.12); }
.blue-corner::before { background: #42a5f5; }

/* Status badge */
.status-badge {
  display: inline-block;
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 600;
}
.status-waiting  { background: rgba(100,116,139,0.15); color: #94a3b8; }
.status-playing  { background: rgba(245,158,11,0.15);  color: #f59e0b; }
.status-done     { background: rgba(34,197,94,0.15);   color: #22c55e; }

/* Empty state */
.empty-row { padding: 48px 0 !important; text-align: center; }
.empty-state { display: flex; flex-direction: column; align-items: center; gap: 8px; }
.empty-icon { font-size: 36px; }
.empty-state p { color: #4b5563; }

/* Pagination */
.pagination {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  margin-top: 24px;
  flex-wrap: wrap;
}
.page-btn {
  min-width: 36px; height: 36px;
  padding: 0 10px;
  border: 1px solid rgba(255,255,255,0.1);
  background: rgba(255,255,255,0.03);
  color: #94a3b8;
  border-radius: 8px;
  cursor: pointer;
  font-size: 14px;
  transition: all 0.2s;
}
.page-btn:hover:not(:disabled) { background: rgba(229,57,53,0.15); border-color: rgba(229,57,53,0.4); color: #ef5350; }
.page-btn.active { background: #e53935; border-color: #e53935; color: #fff; font-weight: 700; }
.page-btn:disabled { opacity: 0.3; cursor: not-allowed; }
.page-info { color: #4b5563; font-size: 13px; margin-left: 6px; }

@media (max-width: 600px) {
  .stats-row { flex-wrap: wrap; }
  .stat-card { min-width: calc(50% - 6px); }
  .filter-group { width: 100%; }
  .filter-select { flex: 1; }
}
</style>
