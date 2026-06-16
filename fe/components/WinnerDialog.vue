<template>
  <div>
    <!-- Red Win -->
    <v-dialog v-model="dialogRed" max-width="700" persistent>
      <v-card class="border-primaryred rounded-lg">
        <v-card-text class="pa-8">
          <p class="mb-0 text-center">
            <v-icon class="primaryred--text text-100">mdi-crown</v-icon>
          </p>
          <h2 class="text-center white--text">
            <span class="primaryred--text h2 font-weight-bold">RED</span>
            {{ isSubmision ? 'Submission' : 'Winner'}}
          </h2>

          <div class="d-flex w-100 justify-center mt-8">
            <div class="mx-4">
              <h3 class="primaryred--text text-center mb-0">{{ redPoints }}</h3>
              <p class="mb-0 white--text text-center font-weight-semi text-20">
                Points
              </p>
            </div>
            <div class="mx-4">
              <h3 class="primaryred--text text-center mb-0">
                {{ redAdvantages }}
              </h3>
              <p class="mb-0 white--text text-center font-weight-semi text-20">
                Advantages
              </p>
            </div>
            <div class="mx-4">
              <h3 class="primaryred--text text-center mb-0">{{ redFouls }}</h3>
              <p class="mb-0 white--text text-center font-weight-semi text-20">
                Fouls
              </p>
            </div>
          </div>

          <div class="mt-8">
            <h5 class="text-center white--text">
              {{ redName }} | {{ redClub }}
            </h5>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>

    <!-- Blue Win -->
    <v-dialog v-model="dialogBlue" max-width="700" persistent>
      <v-card class="border-primaryblue rounded-lg">
        <v-card-text class="pa-8">
          <p class="mb-0 text-center">
            <v-icon class="primaryblue--text text-100">mdi-crown</v-icon>
          </p>
          <h2 class="text-center white--text">
            <span class="primaryblue--text h2 font-weight-bold">Blue</span>
            {{ isSubmision ? 'Submission' : 'Winner'}}
          </h2>

          <div class="d-flex w-100 justify-center mt-8">
            <div class="mx-4">
              <h3 class="primaryblue--text text-center mb-0">
                {{ bluePoints }}
              </h3>
              <p class="mb-0 white--text text-center font-weight-semi text-20">
                Points
              </p>
            </div>
            <div class="mx-4">
              <h3 class="primaryblue--text text-center mb-0">
                {{ blueAdvantages }}
              </h3>
              <p class="mb-0 white--text text-center font-weight-semi text-20">
                Advantages
              </p>
            </div>
            <div class="mx-4">
              <h3 class="primaryblue--text text-center mb-0">
                {{ blueFouls }}
              </h3>
              <p class="mb-0 white--text text-center font-weight-semi text-20">
                Fouls
              </p>
            </div>
          </div>

          <div class="mt-8">
            <h5 class="text-center white--text">
              {{ blueName }} | {{ blueClub }}
            </h5>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  name: 'WinnerDialog',
  data() {
    return {
      dialogRed: false,
      dialogBlue: false,

      redPoints: 0,
      redAdvantages: 0,
      redFouls: 0,

      bluePoints: 0,
      blueAdvantages: 0,
      blueFouls: 0,

      redName: 'Player Red',
      redClub: 'Red Club',

      blueName: 'Player Blue',
      blueClub: 'Blue Club',
    }
  },
  computed: {
    isSubmision() {
      console.log(this.redPoins, this.bluePoints, this.redPoints === 50 || this.bluePoints === 50);
      return this.redPoints === 50 || this.bluePoints === 50;
    }
  },

  mounted() {
    let win = localStorage.getItem('dataWinner')
    let dataRed = localStorage.getItem('newazaRed')
    let dataBlue = localStorage.getItem('newazaBlue')
    if (win != null && dataRed != null && !dataBlue != null) {
      win = JSON.parse(win)
      dataRed = JSON.parse(dataRed)
      dataBlue = JSON.parse(dataBlue)

      this.redPoints = dataRed.score
      this.redAdvantages = dataRed.advantage
      this.redFouls = dataRed.foul

      this.bluePoints = dataBlue.score
      this.blueAdvantages = dataBlue.advantage
      this.blueFouls = dataBlue.foul

      this.redName = win.name
      this.redClub = win.club

      this.blueName = win.name
      this.blueClub = win.club

      win.win === 1 ? (this.dialogRed = true) : (this.dialogBlue = true)
    }
  },
}
</script>

<style scoped>
@import '~/assets/styles.css';

.border-primaryred {
  border: 5px solid #ef233c !important;
}

.border-primaryblue {
  border: 5px solid #243c7a !important;
}

.text-100 {
  font-size: 100px;
}
</style>
