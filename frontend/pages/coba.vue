<template>
  <v-container fluid light>
    <!-- <iframe
      src="https://challonge.com/9vj9z3q6/module?show_live_status=0&tab=1&theme=2&show_tournament_name=1"
      width="100%"
      height="500px"
      frameborder="0"
      scrolling="auto"
      allowtransparency="true"
    ></iframe> -->
    <div>
      <div>Turnamen</div>
      <!-- <p class="py-16 black--text bg-white">Turnamen</p> -->
      <!-- <v-img :src="bracketImage" class="bracket-image"></v-img> -->
    </div>
    <!-- <v-btn @click="getTournament()">get all t</v-btn>
    <v-btn v-for="(data, i) in to" :key="i" @click="getOneTournament(data.id)"
      >get {{ data.name + ' - ' + data.id }}</v-btn
    >
    <div>
      <v-btn @click="createTournament()">create t</v-btn>
    </div> -->

    <div v-if="tournament.length > 0" class="py-16">
      <client-only>
        <bracket ref="bracket" :rounds="tournament">
          <template slot="player" slot-scope="{ player }">
            {{ player.name }}
          </template>
        </bracket>
      </client-only>
    </div>
  </v-container>
</template>

<script>
export default {
  filters: {
    snake_case_string(str) {
      return str
        .replace(/\W+/g, ' ')
        .split(/ |\B(?=[A-Z])/)
        .map((word) => word.toLowerCase())
        .join('_')
    },
  },
  components: {
    [process.client && 'Bracket']: () => import('vue-tournament-bracket'),
  },
  layout: 'bracket',
  data() {
    return {
      bracketImage: 'https://challonge.com/9vj9z3q6.svg',
      to: [],
      tournament: [],
    }
  },
  mounted() {
    this.generateBracket()
  },
  methods: {
    getTournament() {
      const url = '/api2/tournaments.json'
      const p = {
        api_key: 'BAMtLseJZv1T832RxfuQDWvxGbX2wdoPEjgeGAAC',
      }

      this.$axios.$get(url, { params: p }).then((result) => {
        result.forEach((t) => {
          const d = {
            name: t.tournament.name,
            id: t.tournament.id,
            bracket: t.tournament.live_image_url,
            status: t.tournament.state,
          }

          this.to.push(d)
          console.log('get success')
        })
      })
    },
    getOneTournament(id) {
      const url = '/api2/tournaments/' + id + '.json'
      const p = {
        api_key: 'BAMtLseJZv1T832RxfuQDWvxGbX2wdoPEjgeGAAC',
      }

      this.$axios.$get(url, { params: p }).then((result) => {
        console.log(result)
      })
    },
    createTournament() {
      const url = '/api2/tournaments.json'
      const p = {
        // api_key: 'BAMtLseJZv1T832RxfuQDWvxGbX2wdoPEjgeGAAC',
        'tournament[name]': 'KJUO XVI',
        'tournament[tournament_type]': 'singgle elimination',
        'tournament[url]': 'kjuoxvi',
        'tournament[description]': 'Kejuaraan Ju-Jitsu Unesa Open',
        'tournament[open_signup]': false,
        'tournament[hold_third_place_match]': true,
        'tournament[private]': true,
      }

      this.$axios.post(url, { params: p }).then((result) => {
        console.log(result)
      })
    },
    generateBracket() {
      const brackets = [2, 4, 8, 16, 32, 64, 128, 256]
      const rounds = [1, 2, 3, 4, 5, 6, 7, 8]
      let bracket = 0
      const player = 15
      const p1 = parseInt(player / 2)
      const p2 = player - p1

      const match = []

      for (let i = 0; i < brackets.length; i++) {
        if (player < brackets[i] && bracket === 0) {
          bracket = rounds[i]
        }
      }
      console.log(p1, p2, bracket)

      for (let x = bracket; x > 0; x--) {
        const games = []
        for (let y = 0; y < 2 ** x / 2; y++) {
          games.push({
            player1: { id: x + y, name: 'Player1 ' + x + y, winner: true },
            player2: { id: x + y, name: 'Player2 ' + x + y, winner: true },
          })
        }
        match.push({ games })
      }

      this.tournament = match
      console.log(this.tournament)

      // {
      //     games: [
      //       {
      //         player1: { id: '1', name: 'Competitor 1', winner: false },
      //         player2: { id: '4', name: 'Competitor 4', winner: true },
      //       },
      //       {
      //         player1: { id: '3', name: 'Competitor 3', winner: false },
      //         player2: { id: '10', name: 'Competitor x', winner: false },
      //       },
      //       {
      //         player1: { id: '1', name: 'Competitor 1', winner: false },
      //         player2: { id: '4', name: 'Competitor 4', winner: true },
      //       },
      //       {
      //         player1: { id: '5', name: 'Competitor 5', winner: false },
      //         player2: { id: '8', name: 'Competitor 8', winner: true },
      //       },
      //     ],
      //   },
      //   {
      //     games: [
      //       {
      //         player1: { id: 3, name: 'Competitor 3', winner: null },
      //         player2: { name: 'TDW', winner: null },
      //       },
      //       {
      //         player1: { id: 3, name: 'Competitor 3', winner: null },
      //         player2: { name: 'TDW', winner: null },
      //       },
      //     ],
      //   },
      //   {
      //     games: [
      //       {
      //         player1: { id: 3, name: 'Competitor 3', winner: null },
      //         player2: { name: 'TDW', winner: null },
      //       },
      //     ],
      //   },

      // console.log(Math.ceil(Math.sqrt(17)))
    },
  },
}
</script>

<style scoped>
@import '~/assets/styles.css';

.title {
  width: 100%;
  height: 200px;
  z-index: 1;
  color: black;
  background-color: white;
  position: absolute;
}

div >>> .vtb-player {
  color: black !important;
  background: #efeded !important;
  border-radius: 8px;
  min-width: 200px;
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
