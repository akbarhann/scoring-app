<template>
  <div class="roster-root">
    <!-- Loading -->
    <div v-if="loading" class="center-screen">
      <div class="spinner"></div>
      <p class="muted-text">Memuat data peserta...</p>
    </div>

    <!-- Error -->
    <div v-else-if="error" class="center-screen">
      <p class="error-text">⚠️ {{ error }}</p>
    </div>

    <!-- Content -->
    <div v-else class="page">

      <!-- Header -->
      <header class="page-header">
        <div class="header-badge">DAFTAR PESERTA</div>
        <h1 class="header-title">{{ tournamentName }}</h1>
        <p class="header-sub">{{ deduped.length }} Peserta &nbsp;·&nbsp; {{ uniqueCategories.length }} Kategori</p>
      </header>

      <!-- Toolbar -->
      <div class="toolbar">
        <div class="search-box">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="icon-search"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
          <input v-model="search" class="search-input" placeholder="Cari atlet atau dojo..." />
        </div>
        <select v-model="filterCategory" class="filter-select">
          <option value="">Semua Kategori</option>
          <option v-for="c in uniqueCategories" :key="c" :value="c">{{ c }}</option>
        </select>
      </div>

      <!-- Table -->
      <div class="table-wrap">
        <table class="table">
          <thead>
            <tr>
              <th class="col-num">No.</th>
              <th class="col-name sortable" @click="sortBy('athlete_name')">
                Nama Atlet {{ sortIcon('athlete_name') }}
              </th>
              <th class="col-dojo sortable" @click="sortBy('dojo')">
                Dojo / Klub {{ sortIcon('dojo') }}
              </th>
              <th class="col-cat sortable" @click="sortBy('category_name')">
                Kategori {{ sortIcon('category_name') }}
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(row, i) in paginatedRows" :key="i" class="tr">
              <td class="col-num muted">{{ (page - 1) * perPage + i + 1 }}</td>
              <td class="col-name athlete-name">{{ row.athlete_name }}</td>
              <td class="col-dojo muted">{{ row.dojo || '—' }}</td>
              <td class="col-cat">
                <a
                  :href="`/user/chart/detail?id=${row.category_id}`"
                  target="_blank"
                  class="cat-link"
                  :title="`Lihat bagan ${row.category_name}`"
                >
                  {{ row.category_name }}
                  <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor" class="icon-ext"><path d="M19 19H5V5h7V3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z"/></svg>
                </a>
              </td>
            </tr>
            <tr v-if="filtered.length === 0">
              <td colspan="4" class="empty-cell">
                Tidak ada data yang cocok.
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div v-if="totalPages > 1" class="pagination">
        <button class="pg-btn" :disabled="page === 1" @click="page--">‹</button>
        <button
          v-for="p in visiblePages"
          :key="p"
          class="pg-btn"
          :class="{ active: p === page }"
          @click="page = p"
        >{{ p }}</button>
        <button class="pg-btn" :disabled="page === totalPages" @click="page++">›</button>
        <span class="pg-info">{{ rangeStart }}–{{ rangeEnd }} / {{ filtered.length }}</span>
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
      sortKey: 'category_name',
      sortAsc: true,
      page: 1,
      perPage: 50,
    }
  },
  computed: {
    // Deduplicate at JS level: unique key = category_name + normalized athlete name
    // This handles cases where categories with the same name have different IDs (e.g. pools)
    deduped() {
      const seen = new Set();
      return this.participants.filter(p => {
        const catName = (p.category_name || '').trim().toLowerCase();
        const athName = (p.athlete_name || '').toLowerCase().replace(/\s+/g, ' ').trim();
        const key = `${catName}|${athName}`;
        if (seen.has(key)) return false;
        seen.add(key);
        return true;
      });
    },
    uniqueCategories() {
      const cats = this.deduped.map(p => p.category_name);
      return [...new Set(cats)].sort((a, b) => a.localeCompare(b));
    },
    filtered() {
      let rows = this.deduped;
      if (this.filterCategory !== '') {
        rows = rows.filter(r => r.category_name === this.filterCategory);
      }
      if (this.search) {
        const q = this.search.toLowerCase();
        rows = rows.filter(r =>
          r.athlete_name.toLowerCase().includes(q) ||
          (r.dojo || '').toLowerCase().includes(q)
        );
      }
      const key = this.sortKey;
      const asc = this.sortAsc;
      return [...rows].sort((a, b) => {
        const va = (a[key] || '').toLowerCase();
        const vb = (b[key] || '').toLowerCase();
        return asc ? va.localeCompare(vb) : vb.localeCompare(va);
      });
    },
    totalPages() {
      return Math.max(1, Math.ceil(this.filtered.length / this.perPage));
    },
    paginatedRows() {
      const s = (this.page - 1) * this.perPage;
      return this.filtered.slice(s, s + this.perPage);
    },
    visiblePages() {
      const pages = [];
      const lo = Math.max(1, this.page - 2);
      const hi = Math.min(this.totalPages, this.page + 2);
      for (let i = lo; i <= hi; i++) pages.push(i);
      return pages;
    },
    rangeStart() { return (this.page - 1) * this.perPage + 1; },
    rangeEnd()   { return Math.min(this.page * this.perPage, this.filtered.length); },
  },
  watch: {
    search()         { this.page = 1; },
    filterCategory() { this.page = 1; },
  },
  mounted() {
    const tid = this.$route.query.tournament_id;
    if (!tid) {
      this.error = 'Parameter tournament_id tidak ditemukan.';
      this.loading = false;
      return;
    }
    this.load(tid);
  },
  methods: {
    async load(tid) {
      try {
        const res = await this.$axios.$get(`/api/tournament/participants?tournament_id=${tid}`);
        this.tournamentName = res.tournament?.name || `Turnamen #${tid}`;
        this.participants   = res.data || [];
      } catch {
        this.error = 'Gagal memuat data peserta dari server.';
      } finally {
        this.loading = false;
      }
    },
    sortBy(key) {
      if (this.sortKey === key) { this.sortAsc = !this.sortAsc; }
      else { this.sortKey = key; this.sortAsc = true; }
    },
    sortIcon(key) {
      if (this.sortKey !== key) return '↕';
      return this.sortAsc ? '↑' : '↓';
    },
  },
}
</script>

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
  font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
  background: #0d0d12;
  color: #c9d1d9;
  min-height: 100vh;
  -webkit-font-smoothing: antialiased;
}

/* ── Layout ── */
.roster-root { min-height: 100vh; }
.page { max-width: 1100px; margin: 0 auto; padding: 32px 20px 80px; }

/* ── Center screen (loading/error) ── */
.center-screen {
  display: flex; flex-direction: column;
  align-items: center; justify-content: center;
  min-height: 100vh; gap: 14px;
}
.spinner {
  width: 40px; height: 40px;
  border: 3px solid rgba(255,255,255,0.08);
  border-top-color: #e53935;
  border-radius: 50%;
  animation: spin .75s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }
.muted-text { color: #6e7681; font-size: 14px; }
.error-text { color: #f87171; }

/* ── Header ── */
.page-header { margin-bottom: 28px; }
.header-badge {
  display: inline-block;
  font-size: 11px; font-weight: 700; letter-spacing: 1.5px;
  color: #e53935; border: 1px solid rgba(229,57,53,0.35);
  background: rgba(229,57,53,0.08);
  padding: 3px 12px; border-radius: 20px; margin-bottom: 10px;
}
.header-title {
  font-size: clamp(20px, 4vw, 30px);
  font-weight: 800; color: #f0f6fc; line-height: 1.2;
  margin-bottom: 8px;
}
.header-sub { font-size: 13px; color: #6e7681; }

/* ── Toolbar ── */
.toolbar { display: flex; gap: 10px; margin-bottom: 16px; flex-wrap: wrap; }
.search-box { flex: 1; min-width: 220px; position: relative; }
.icon-search {
  position: absolute; left: 11px; top: 50%;
  transform: translateY(-50%); fill: #6e7681; flex-shrink: 0;
}
.search-input {
  width: 100%; padding: 9px 12px 9px 36px;
  background: rgba(255,255,255,0.04);
  border: 1px solid rgba(255,255,255,0.09);
  border-radius: 8px; color: #c9d1d9; font-size: 14px; outline: none;
  transition: border-color .18s;
}
.search-input:focus { border-color: rgba(229,57,53,0.45); }
.search-input::placeholder { color: #3d444d; }
.filter-select {
  padding: 9px 14px;
  background: rgba(255,255,255,0.04);
  border: 1px solid rgba(255,255,255,0.09);
  border-radius: 8px; color: #c9d1d9; font-size: 14px;
  cursor: pointer; outline: none; transition: border-color .18s;
  min-width: 180px;
}
.filter-select:focus { border-color: rgba(229,57,53,0.45); }
.filter-select option { background: #161b22; }

/* ── Table ── */
.table-wrap {
  border-radius: 12px; overflow: hidden;
  border: 1px solid rgba(255,255,255,0.07);
  overflow-x: auto;
}
.table { width: 100%; border-collapse: collapse; min-width: 560px; }
.table thead tr { background: rgba(255,255,255,0.04); }
.table th {
  padding: 11px 16px; text-align: left;
  font-size: 11px; font-weight: 600; letter-spacing: .7px;
  text-transform: uppercase; color: #6e7681; white-space: nowrap;
}
.sortable { cursor: pointer; user-select: none; transition: color .15s; }
.sortable:hover { color: #c9d1d9; }
.tr { border-top: 1px solid rgba(255,255,255,0.05); transition: background .12s; }
.tr:hover { background: rgba(255,255,255,0.025); }
.table td { padding: 11px 16px; font-size: 14px; vertical-align: middle; }
.col-num { width: 52px; }
.muted { color: #6e7681; }
.athlete-name { font-weight: 600; color: #e6edf3; }

/* ── Category link ── */
.cat-link {
  display: inline-flex; align-items: center; gap: 5px;
  color: #58a6ff; text-decoration: none; font-size: 13px;
  padding: 3px 9px; border-radius: 6px;
  border: 1px solid rgba(88,166,255,0.2);
  background: rgba(88,166,255,0.06);
  transition: all .18s; white-space: nowrap;
}
.cat-link:hover {
  background: rgba(88,166,255,0.14);
  border-color: rgba(88,166,255,0.5);
  color: #79b8ff;
}
.icon-ext { flex-shrink: 0; opacity: .65; }

/* ── Empty ── */
.empty-cell { text-align: center; padding: 48px 0 !important; color: #3d444d; }

/* ── Pagination ── */
.pagination {
  display: flex; align-items: center; justify-content: center;
  gap: 5px; margin-top: 24px; flex-wrap: wrap;
}
.pg-btn {
  min-width: 34px; height: 34px; padding: 0 10px;
  border: 1px solid rgba(255,255,255,0.09);
  background: rgba(255,255,255,0.03);
  color: #8b949e; border-radius: 7px;
  cursor: pointer; font-size: 14px; transition: all .15s;
}
.pg-btn:hover:not(:disabled) {
  background: rgba(229,57,53,0.12);
  border-color: rgba(229,57,53,0.35); color: #e53935;
}
.pg-btn.active { background: #e53935; border-color: #e53935; color: #fff; font-weight: 700; }
.pg-btn:disabled { opacity: .3; cursor: not-allowed; }
.pg-info { color: #3d444d; font-size: 13px; margin-left: 4px; }

@media (max-width: 520px) {
  .toolbar { flex-direction: column; }
  .filter-select { width: 100%; }
}
</style>
