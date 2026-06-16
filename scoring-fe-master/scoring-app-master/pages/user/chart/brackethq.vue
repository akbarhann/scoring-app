<template>
  <div>
    <!-- Import -->
    <h4 class="text-center">
      {{ name }}
    </h4>
    <iframe id="iframe" :src="src" width="100%" :height="height" frameborder="0"></iframe>
  </div>
</template>

<script>
export default {
  name: 'BrackethqPage',
  layout: 'bracket-scrap',
  data() {
    return {
      src: null,
      name: null,
      height: '600px',
    }
  },
  mounted() {

    setInterval(() => {
      this.height = window.innerHeight;

      let local = localStorage.getItem('liveBracket')
      if (local != null) {
        local = JSON.parse(local)
        const iframe = document.querySelector('#iframe');
        iframe.src = local.url;
        this.name = local.title
      }
    }, 120000)
  },
}
</script>

<style scoped>
@import '~/assets/styles.css';

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
  background: #efeded !important;
  border-radius: 8px;
  min-width: 200px;
  max-width: 200px;
}
</style>
