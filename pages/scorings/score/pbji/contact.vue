<template>
  <div class="my-4">
    <p class="text-center text-20 height-28 font-weight-bold mb-0">
      {{ title }}
    </p>
    <h3 class="text-center mb-8">{{ category }}</h3>
    <!-- Timer -->
    <div class="main-timer">
      <div class="main-timer-inner py-4">
        <div class="d-flex flex-column justify-center h-100">
          <p class="mb-0 text-center text-timer font-weight-semi">
            {{ time | timeFormat }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ScorePBJIContctSystem',
  filters: {},
  middleware: 'login',
  data() {
    return {
      title: 'KEJUARAAN',
      category: 'Contact Sytem',

      time: 0,

      sponsors: [
        'logo_koni.png',
        'logo_pbji.png',
        'logo_kajati.png',
      ],
    }
  },

  mounted() {
    setInterval(() => {
      this.getTime()
    }, 100)
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
  },
}
</script>

<style scoped>
@import '~/assets/styles.css';

.corner {
  width: 555px;
}
.time-corner {
  width: 440px;
}
.time-corner-mid {
  width: 225px;
}
.red-corner {
  min-width: 100%;
  background-color: #ff001e;
  border-radius: 24px;
}
.blue-corner {
  min-width: 100%;
  background-color: #0048ff;
  border-radius: 24px;
}
.redblue-corner {
  min-width: 100%;
  border-radius: 24px;
  background: linear-gradient(115.41deg, #ff001e, #0048ff);
  padding: 4px;
}
.redblue-corner-inner {
  background-color: #31323b;
  border-radius: 24px;
  height: 100%;
}
.text-score {
  font-size: 60px;
  line-height: 60px;
}
.text-score-main {
  font-size: 80px;
  line-height: 80px;
}
.text-timer {
  font-size: 250px;
  line-height: 250px;
}
.text-timer-medic {
  font-size: 50px;
  line-height: 50px;
}
.penalties {
  width: 100%;
  background: rgba(255, 255, 255, 0.35);
  border: 2px solid #ffffff;
  border-radius: 20px;
  padding: 16px;
}
.point {
  width: 30%;
  background: rgba(255, 255, 255, 0.35);
  border: 2px solid #ffffff;
  border-radius: 20px;
  padding: 16px;
}

hr {
  border-top: 0;
  border-left: 0;
  border-right: 0;
  border-radius: 100px;
  width: 130px;
}
.border-blue {
  border-bottom: 3px solid #0048ff;
}
.border-red {
  border-bottom: 3px solid #ff001e;
}
.divider {
  z-index: 10 !important;
}
.main-timer {
  height: 400px;
  border-radius: 20px;
  background: linear-gradient(115.41deg, #ff001e, #0048ff);
  padding: 4px;
}
.main-timer-inner {
  height: 390px;
  background-color: #31323b;
  border-radius: 20px;
}

.sponsor {
  width: 570px;
  max-height: 140px;
  background: #ffffff;
  border-radius: 20px;
}

.border-left {
  border-left: 1px solid white;
}
.border-right {
  border-right: 1px solid white;
}
</style>

<style>
html {
  overflow: hidden;
}
</style>
