<template>
  <div>
    <v-dialog v-model="dialogDis" max-width="780" persistent>
      <v-card class="border-white rounded-lg">
        <v-card-text class="pa-8">
          <h1 class="text-center primaryred--text mb-3">DISQUALIFICATION</h1>
          <h5 class="text-center white--text">{{ name }} | {{ club }}</h5>

          <div class="d-flex w-100 justify-center mt-10">
            <div class="mx-4 text-point align-self-end">
              <h4 class="white--text text-center mb-0">{{ points }}</h4>
              <p class="mb-0 white--text text-center font-weight-semi text-18">
                Points
              </p>
            </div>
            <div class="mx-4 text-point">
              <h1 class="primaryred--text text-center mb-0 height-36">
                {{ fouls }}
              </h1>
              <p
                class="mb-0 white--text text-center font-weight-semi text-20 mt-6"
              >
                Fouls
              </p>
            </div>
            <div class="mx-4 text-point align-self-end">
              <h4 class="white--text text-center mb-0">
                {{ advantages }}
              </h4>
              <p class="mb-0 white--text text-center font-weight-semi text-18">
                Advantages
              </p>
            </div>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  name: 'DisDialog',
  data() {
    return {
      dialogDis: true,

      points: 0,
      advantages: 0,
      fouls: 0,

      bluePoints: 0,
      blueAdvantages: 0,
      blueFouls: 0,

      name: 'Player Red',
      club: 'Red Club',
    }
  },
  computed: {},

  mounted() {
    let dis = localStorage.getItem('dataDisqualified')
    if (dis != null) {
      dis = JSON.parse(dis)

      this.points = dis.score
      this.advantages = dis.advantage
      this.fouls = dis.foul

      this.name = dis.name
      this.club = dis.club
      this.dialogDis = true
    }
  },
}
</script>

<style scoped>
@import '~/assets/styles.css';

.border-white {
  border: 5px solid white !important;
}

.text-100 {
  font-size: 100px;
}

.text-point {
  min-width: 130px;
  max-width: 130px;
}
</style>
