<template>
  <div class="mt-8">
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
          @click="$router.push('/user/schedule')"
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
          Create Schedule
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
            <v-autocomplete
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
              @change="getCategory()"
            ></v-autocomplete>
          </div>
          <div class="select-order mr-3">
            <v-text-field
              v-model="waitingListName"
              hide-details
              outlined
              placeholder="Waiting List Name"
              dense
              auto
            ></v-text-field>
          </div>
          <v-btn
            x-small
            class="rounded-8 align-self-center"
            color="green lighten-1"
            @click="sort()"
          >
            Save
          </v-btn>
        </div>
      </div>
    </div>
    <div v-if="categoryItem.length > 0" class="card-dashboard mb-6 pa-6">
      <div class="d-flex mb-4">
        <v-btn
          x-small
          class="rounded-8 mr-3"
          @click="sort()"
        >
          Reset to default
        </v-btn>
        <p class="text-14 mb-0 align-self-center">
          <i>Drag and drop to change order of schedule</i>
        </p>
      </div>
      <draggable
        v-model="categoryItem"
        class="list-group"
        tag="ul"
        v-bind="dragOptions"
        @start="drag = true"
        @end="drag = false"
      >
        <transition-group type="transition" :name="!drag ? 'flip-list' : null">
          <li
            v-for="element in categoryItem"
            :key="element.id"
            class="list-group-item"
          >
            <div class="d-flex justify-space-between">
              <p class="mb-0 align-self-center">
                {{ element.name }}
              </p>
              <div class="d-flex">
                <v-btn
                  x-small
                  min-width="38px"
                  class="px-1 rounded-8 align-self-center ml-auto"
                  color="red lighten-1"
                  @click="deleteCategory(element.id)"
                >
                  <v-icon class="text-18">mdi-trash-can-outline</v-icon>
                </v-btn>
              </div>
            </div>
          </li>
        </transition-group>
      </draggable>
    </div>
  </div>
</template>

<script>
import draggable from 'vuedraggable'

export default {
  name: 'SettingSchedulePage',
  components: {
    draggable
  },
  layout: 'dashboard',
  middleware: 'login',
  data() {
    return {
      waitingListName: '',
      martial: '',
      martialItem: [],
      tournament: '',
      tournamentItem: [],
      category: '',
      categoryItem: [],
      categoryItemDefault: [],
      drag: false
    }
  },
  computed: {
    dragOptions() {
      return {
        animation: 200,
        group: "description",
        disabled: false,
        ghostClass: "ghost"
      };
    }
  },
  mounted() {
    this.getMartial();
  },
  methods: {
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
    async getCategory() {
      const url = '/api/category'
      const data = {
        tournament_id: this.tournament,
      }
      this.categoryItem = []
      await this.$axios
        .$get(url, { params: data })
        .then((result) => {
          this.categoryItem = result?.data?.map((item, key) => {
            return {
              id: item.id,
              name: item.category_name,
              order: key,
            }
          })
        })
        .catch(() => {
          this.notif = true
          this.notifColor = 'error'
          this.notifMsg = 'Error get category'
        })
    },
    sort() {
      this.categoryItem = this.categoryItemDefault.sort((a, b) => a.id - b.id);
    },
    deleteCategory(id) {
      this.categoryItem = this.categoryItem.filter((item) => item.id!== id);
    },
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

ul {
  list-style: none !important;
  padding: 0;
  border-radius: 16px;
  overflow: hidden;
}

li {
  padding: 12px 20px;
  background-color: #272727;
  border-bottom: 1px solid grey;
}

.button {
  margin-top: 35px;
}

.flip-list-move {
  transition: transform 0.5s;
}

.no-move {
  transition: transform 0s;
}

.ghost {
  opacity: 0.5;
  background: #c8ebfb;
}

.list-group {
  min-height: 20px;
}

.list-group-item {
  cursor: move;
}

.list-group-item i {
  cursor: pointer;
}
</style>
