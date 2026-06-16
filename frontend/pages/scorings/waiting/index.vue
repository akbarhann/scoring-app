<template>
  <v-container style="overflow: clip; height: 94vh;">
    <div class="">
      <p class="text-center text-20 height-28 font-weight-bold mb-0">
        {{ title }}
      </p>
      <h3 class="text-center mb-6">{{ category }}</h3>
    </div>
    <!-- Fight Now -->
    <div class="redblue-corner">
      <div class="redblue-corner-inner pa-4">
        <div class="pos-relative">
          <div class="d-flex w-100 h-100 justify-space-between">
            <!-- Player Red -->
            <div class="align-self-center" style="width: 25%;">
              <p class="mb-1 font-weight-semi text-24 height-30">
                {{ ongoing.playerRed | wrapText(25) }}
              </p>
              <hr class="border-red" />
              <p class="mt-1 mb-0 font-weight-semi text-20 height-30">
                {{ ongoing.clubRed }}
              </p>
            </div>
            <!-- Time -->
            <div class="align-self-center">
              <p class="text-time mb-4 font-weight-semi">
                {{ time | timeFormat }}
              </p>
            </div>
            <!-- Player Blue -->
            <div class="align-self-center" style="width: 25%;">
              <p class="mb-1 font-weight-semi text-24 height-30 text-right">
                {{ ongoing.playerBlue | wrapText(25) }}
              </p>
              <hr class="border-blue float-right" />
              <p
                class="mt-3 mb-0 font-weight-semi text-20 height-30 text-right"
              >
                {{ ongoing.clubBlue }}
              </p>
            </div>
          </div>
          <p class="text-24 px-5 font-weight-semi text-title">Fight Now</p>
        </div>
      </div>
    </div>
    <!-- Prepare -->
    <div class="redblue-corner mt-6">
      <div class="redblue-corner-inner pa-4">
        <div class="pos-relative">
          <div class="d-flex w-100 h-100 justify-space-between">
            <!-- Player Red -->
            <div class="align-self-center" style="width: 25%">
              <p class="mb-1 font-weight-semi text-24 height-30">
                {{ prepare.playerRed | wrapText(25) }}
              </p>
              <hr class="border-red" />
              <p class="mt-1 mb-0 font-weight-semi text-20 height-30">
                {{ prepare.clubRed }}
              </p>
            </div>
            <div class="align-self-center" style="width: 25%">
              <v-img
                :src="require('assets/images/icons/vs.svg')"
                max-height="66px"
                class="mb-4"
                contain
              ></v-img>
            </div>
            <!-- Player Blue -->
            <div class="align-self-center" style="width: 25%">
              <p class="mb-1 font-weight-semi text-24 height-30 text-right">
                {{ prepare.playerBlue | wrapText(25) }}
              </p>
              <hr class="border-blue float-right" />
              <p
                class="mt-3 mb-0 font-weight-semi text-20 height-30 text-right"
              >
                {{ prepare.clubBlue }}
              </p>
            </div>
          </div>
          <p class="text-24 px-5 font-weight-semi text-title">Preparation</p>
        </div>
      </div>
    </div>
    <!-- Waiting List -->
    <div class="mt-6">
      <p class="text-24 font-weight-semi">Waiting List</p>
      <div class="d-flex flex-wrap">
        <div v-for="(data, i) in waitingList" :key="i" class="d-flex mb-4 mr-3">
          <div class="align-self-center mr-3">
            <div class="d-flex justify-center number">
              <div class="align-self-center">
                <p class="mb-0 text-24 font-weight-semi">{{ i + 1 }}</p>
              </div>
            </div>
          </div>
          <div class="redblue-corner rounded-pill">
            <div class="redblue-corner-inner rounded-pill py-2 px-8">
              <div class="d-flex w-100 h-100 justify-space-between wait-match">
                <!-- Player Red -->
                <div class="align-self-center">
                  <p class="mb-1 font-weight-semi text-20 height-30">
                    {{ data.playerRed | wrapText(12) }}
                  </p>
                  <p class="mt-1 mb-0 font-weight-semi text-20 height-30">
                    {{ data.clubRed | wrapText(12) }}
                  </p>
                </div>
                <div class="align-self-center">
                  <v-img
                    :src="require('assets/images/icons/sword.svg')"
                    max-height="47px"
                  ></v-img>
                </div>
                <!-- Player Blue -->
                <div class="align-self-center">
                  <p class="mb-1 font-weight-semi text-20 height-30 text-right">
                    {{ data.playerBlue | wrapText(12) }}
                  </p>
                  <p class="mb-0 font-weight-semi text-20 height-30 text-right">
                    {{ data.clubBlue | wrapText(12) }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Next Category -->
    <div class="mt-6">
      <!-- <p class="text-24 font-weight-semi">Next List - {{ nextCategoryTitle }}</p> -->
      <div class="d-flex flex-wrap">
        <div v-for="(data, i) in nextCategory" :key="i" class="d-flex mb-4 mr-3">
          <div class="align-self-center mr-3">
            <div class="d-flex justify-center number">
              <div class="align-self-center">
                <p class="mb-0 text-24 font-weight-semi">{{ i + 1 }}</p>
              </div>
            </div>
          </div>
          <div class="redblue-corner rounded-pill">
            <div class="redblue-corner-inner rounded-pill py-2 px-8">
              <div class="d-flex w-100 h-100 justify-space-between wait-match">
                <!-- Player Red -->
                <div class="align-self-center">
                  <p class="mb-1 font-weight-semi text-20 height-30">
                    {{ data.playerRed | wrapText(12) }}
                  </p>
                  <p class="mt-1 mb-0 font-weight-semi text-20 height-30">
                    {{ data.clubRed | wrapText(12) }}
                  </p>
                </div>
                <div class="align-self-center">
                  <v-img
                    :src="require('assets/images/icons/sword.svg')"
                    max-height="47px"
                  ></v-img>
                </div>
                <!-- Player Blue -->
                <div class="align-self-center">
                  <p class="mb-1 font-weight-semi text-20 height-30 text-right">
                    {{ data.playerBlue | wrapText(12) }}
                  </p>
                  <p class="mb-0 font-weight-semi text-20 height-30 text-right">
                    {{ data.clubBlue | wrapText(12) }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </v-container>
</template>

<script>
export default {
  name: 'WaitingListPage',
  data() {
    return {
      title: 'Tournament',
      category: 'Category',
      nextCategoryTitle: 'Next Category',
      ongoing: {
        playerRed: 'Player Red',
        clubRed: 'Red Club',
        playerBlue: 'Player Blue',
        clubBlue: 'Blue Club',
      },
      prepare: {
        playerRed: 'Player Red',
        clubRed: 'Red Club',
        playerBlue: 'Player Blue',
        clubBlue: 'Blue Club',
      },
      waitingList: [],
      nextCategory: [],
      nextCurrentMatch: 1,
      time: 0,
      timeStart: false,
      timePause: false,
    }
  },
  mounted() {
    setInterval(() => {
      this.getTime()
      this.getAdditional()
      this.getPlayer()
    }, 1000)
    // setInterval(() => {
    //   this.getNextCategory();
    // }, 10000)
  },
  methods: {
    getTime() {
      let local = localStorage.getItem('mainTime')

      if (local != null) {
        local = JSON.parse(local)

        this.time = local.time
      } else {
        this.time = 0
      }
    },
    getPlayer() {
      let local = localStorage.getItem('waitingList')
      if (local != null) {
        local = JSON.parse(local)
        // this.title = local.place != null ? local.place : local.tournament
        this.category = local.category

        this.ongoing.playerRed = local.play.redName
        this.ongoing.clubRed = local.play.redClub
        this.ongoing.playerBlue = local.play.blueName
        this.ongoing.clubBlue = local.play.blueClub

        this.prepare.playerRed = local.prepare.redName
        this.prepare.clubRed = local.prepare.redClub
        this.prepare.playerBlue = local.prepare.blueName
        this.prepare.clubBlue = local.prepare.blueClub

        const max = local.waiting.length
        let maxList = 0;
        this.waitingList = []
        for (let i = 0; i < max; i++) {
          if (local.waiting[i].red_name !== 'BYE' && local.waiting[i].blue_name !== 'BYE' && maxList < 6 && local.waiting[i].red_name !== null) {
            this.waitingList.push({
              playerRed: local.waiting[i].red_name,
              clubRed: local.waiting[i].red_club,
              playerBlue: local.waiting[i].blue_name,
              clubBlue: local.waiting[i].blue_club,
            });
            maxList++;
          }
        }
      }
    },
    getAdditional() {
      let local = localStorage.getItem('dataAdditional')

      if (local != null) {
        local = JSON.parse(local)

        this.title = local.place
      } else {
        this.title = 'Tournament'
      }
    },
    async getNextCategory() {
      let local = localStorage.getItem('waiting_list_id')
      if (!local) return;
      local = JSON.parse(local);

      const url = '/api/game/list'
      const q = {
        category_id: local,
      }
      await this.$axios
        .get(url, { params: q })
        .then((result) => {
          this.nextCategoryTitle = result.data.category.category_name;
          if (result.data.data.length > 0) {
            let setCurrent = false
            result.data.data.forEach((item) => {
              if (!setCurrent) {
                if (
                  parseInt(item.play_now) === 0 ||
                  parseInt(item.play_now) === 1
                ) {
                  if (item.match_number != null) {
                    this.nextCurrentMatch = item.match_number
                    setCurrent = true
                  }
                }
              }
            });

            this.nextCategory = [];
            result.data.data.forEach((item) => {
              if (item.red_name === 'BYE' || item.blue_name === 'BYE') {
                return;
              }
              if (this.nextCurrentMatch === item.match_number) {
                this.nextCategory.push({
                  playerRed: item.red_name,
                  clubRed: item.red_club,
                  playerBlue: item.blue_name,
                  clubBlue: item.blue_club,
                });
              }
            })
          }
        })
        .catch(() => {
          this.notif = true
          this.notifColor = 'error'
          this.notifMsg = 'Error get participant'
        })
    },
  },
}
</script>

<style scoped>
@import '~/assets/styles.css';
.redblue-corner {
  width: 100%;
  border-radius: 24px;
  background: linear-gradient(90deg, #ef233c 33.94%, #12348d 75.82%);
  padding: 4px;
}
.redblue-corner-inner {
  background-color: #121212;
  border-radius: 24px;
  height: 100%;
}
.border-blue {
  max-width: 100px;
  min-width: 100px;
  border: 2px solid #12348d;
  background: #12348d;
}
.border-red {
  max-width: 100px;
  min-width: 100px;
  border: 2px solid #ef233c;
  background: #ef233c;
}
.text-time {
  font-size: 50px;
  line-height: 50px;
}
.text-title {
  position: absolute;
  background-color: #121212;
  left: 50%;
  transform: translate(-50%, 10%);
}
.number {
  height: 60px;
  width: 60px;
  border: 5px solid #ef233c;
  border-radius: 50px;
}

.wait-match {
  min-width: 410px;
}
</style>

<style>
html {
  overflow: hidden;
}
</style>
