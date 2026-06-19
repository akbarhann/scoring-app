<template>
  <div ref="controlFighting" @click="controlOsaikomi">
    <p class="text-center text-20 height-30 font-weight-semi mb-0">
      Control Score Fighting
    </p>
    <h4 class="text-center mb-10">{{ categoryName }}</h4>
    <div class="d-flex justify-space-between">
      <!-- Red Corner -->
      <div class="corner">
        <div class="red-corner pt-4 px-4">
          <p class="font-weight-semi text-18 text-center">
            {{ redName }} <span class="mx-3 primaryred--text">|</span>
            {{ redClub }}
          </p>
          <div class="d-block">
            <!-- Points -->
            <div class="d-block mb-6">
              <div class="d-flex justify-center">
                <div class="d-flex justify-space-around">
                  <div>
                    <p class="w-100 text-center font-weight-medium mb-0">
                      Ippong 1
                    </p>
                    <p
                        class="
                          mb-0
                          align-self-center
                          font-weight-semi
                          text-score-small
                          mx-3 text-center
                        "
                      >
                        {{ redIppong1 }}
                      </p>
                    <div class="d-flex">
                      <v-btn
                        min-width="30px"
                        elevation="0"
                        x-small
                        color="primaryred"
                        class="rounded-8 my-1 px-2 mx-2"
                        @click="changeRedIppong1(3)"
                      >
                        +3
                      </v-btn>


                      <v-btn
                        min-width="30px"
                        elevation="0"
                        x-small
                        color="primaryred"
                        class="rounded-8 my-1 px-2 mx-2"
                        @click="redIppong1 >= 3 ? changeRedIppong1(-3) : ''"
                      >
                        -3
                      </v-btn>
                    </div>
                    <div class="d-flex justify-center">
                      <v-btn
                        min-width="30px"
                        elevation="0"
                        x-small
                        color="primaryred"
                        class="rounded-8 my-1 px-2 mx-2"
                        @click="changeRedIppong1(2)"
                      >
                        +2
                      </v-btn>
                      <v-btn
                        min-width="30px"
                        elevation="0"
                        x-small
                        color="primaryred"
                        class="rounded-8 my-1 px-2 mx-2"
                        @click="redIppong1 > 1 ? changeRedIppong1(-2) : ''"
                      >
                        -2
                      </v-btn>
                    </div>
                  </div>
                  <div>
                    <p class="w-100 text-center font-weight-medium mb-0">
                      Ippong 2
                    </p>
                    <p
                        class="
                          mb-0
                          align-self-center
                          font-weight-semi
                          text-score-small
                          mx-3 text-center
                        "
                      >
                        {{ redIppong2 }}
                      </p>
                    <div class="d-flex">
                      <v-btn
                        min-width="30px"
                        elevation="0"
                        x-small
                        color="primaryred"
                        class="rounded-8 my-1 px-2 mx-2"
                        @click="changeRedIppong2(3)"
                      >
                        +3
                      </v-btn>


                      <v-btn
                        min-width="30px"
                        elevation="0"
                        x-small
                        color="primaryred"
                        class="rounded-8 my-1 px-2 mx-2"
                        @click="redIppong2 >= 3 ? changeRedIppong2(-3) : ''"
                      >
                        -3
                      </v-btn>
                    </div>
                    <div class="d-flex justify-center">
                      <v-btn
                        min-width="30px"
                        elevation="0"
                        x-small
                        color="primaryred"
                        class="rounded-8 my-1 px-2 mx-2"
                        @click="changeRedIppong2(2)"
                      >
                        +2
                      </v-btn>
                      <v-btn
                        min-width="30px"
                        elevation="0"
                        x-small
                        color="primaryred"
                        class="rounded-8 my-1 px-2 mx-2"
                        @click="redIppong2 > 1 ? changeRedIppong2(-2) : ''"
                      >
                        -2
                      </v-btn>
                    </div>
                  </div>
                  <div>
                    <p class="w-100 text-center font-weight-medium mb-0">
                      Ippong 3
                    </p>
                    <p
                        class="
                          mb-0
                          align-self-center
                          font-weight-semi
                          text-score-small
                          mx-3 text-center
                        "
                      >
                        {{ redIppong3 }}
                      </p>
                    <div class="d-flex">
                      <v-btn
                        min-width="30px"
                        elevation="0"
                        x-small
                        color="primaryred"
                        class="rounded-8 my-1 px-2 mx-2"
                        @click="changeRedIppong3(3)"
                      >
                        +3
                      </v-btn>


                      <v-btn
                        min-width="30px"
                        elevation="0"
                        x-small
                        color="primaryred"
                        class="rounded-8 my-1 px-2 mx-2"
                        @click="redIppong3 >= 3 ? changeRedIppong3(-3) : ''"
                      >
                        -3
                      </v-btn>
                    </div>
                    <div class="d-flex justify-center">
                      <v-btn
                        min-width="30px"
                        elevation="0"
                        x-small
                        color="primaryred"
                        class="rounded-8 my-1 px-2 mx-2"
                        @click="changeRedIppong3(2)"
                      >
                        +2
                      </v-btn>
                      <v-btn
                        min-width="30px"
                        elevation="0"
                        x-small
                        color="primaryred"
                        class="rounded-8 my-1 px-2 mx-2"
                        @click="redIppong3 > 1 ? changeRedIppong3(-2) : ''"
                      >
                        -2
                      </v-btn>
                    </div>
                  </div>
                </div>
                <div class="align-self-center">
                  <p
                    class="
                      mb-0
                      align-self-center
                      font-weight-semi
                      text-score
                      mx-10
                    "
                  >
                    {{ redPoints }}
                  </p>
                  <p class="w-100 text-center font-weight-medium mb-0">
                    Points
                  </p>
                </div>
              </div>
            </div>

            <div class="d-flex justify-space-around">
              <!-- Washari -->
              <div class="d-block">
                <div class="d-flex justify-space-around">
                  <div>
                    <v-btn
                      block
                      elevation="0"
                      color="primaryred"
                      class="rounded-8 my-1 px-3"
                      @click="changeRedWashari(1)"
                    >
                      +1
                    </v-btn>
                  </div>
                  <p
                    class="
                      mb-0
                      align-self-center
                      text-30
                      height-30
                      font-weight-semi
                      mx-3
                    "
                  >
                    {{ redWashari }}
                  </p>
                  <div>
                    <v-btn
                      block
                      elevation="0"
                      color="primaryred"
                      class="rounded-8 my-1 px-3"
                      @click="changeRedWashari(redWashari > 0 ? -1 : 0)"
                    >
                      -1
                    </v-btn>
                  </div>
                </div>
                <p class="w-100 text-center font-weight-medium mt-3">Washari</p>
              </div>

              <v-btn
                color="primaryred"
                class="rounded-8 px-0 my-3"
                elevation="0"
                min-width="45"
                @click="redReset()"
              >
                <v-icon class="white--text">mdi-restart</v-icon>
              </v-btn>

              <!-- Shido -->
              <div class="d-block">
                <div class="d-flex justify-space-around">
                  <div>
                    <v-btn
                      block
                      elevation="0"
                      color="primaryred"
                      class="rounded-8 my-1 px-3"
                      @click="changeRedShido(1)"
                    >
                      +1
                    </v-btn>
                  </div>
                  <p
                    class="
                      mb-0
                      align-self-center
                      text-30
                      height-30
                      font-weight-semi
                      mx-3
                    "
                  >
                    {{ redShido }}
                  </p>
                  <div>
                    <v-btn
                      block
                      elevation="0"
                      color="primaryred"
                      class="rounded-8 my-1 px-3"
                      @click="changeRedShido(redShido > 0 ? -1 : 0)"
                    >
                      -1
                    </v-btn>
                  </div>
                </div>
                <p class="w-100 text-center font-weight-medium mt-3">Shido</p>
              </div>
            </div>

            <hr class="w-100" />

            <div class="d-flex justify-space-between pb-4 pt-3 px-10">
              <p class="font-weight-medium mb-0 align-self-center">Chui</p>
              <div class="d-flex">
                <v-radio-group
                  v-model="redChui"
                  hide-details
                  multiple
                  row
                  class="mt-0 pb-1"
                >
                  <v-radio
                    color="primaryred"
                    class="mr-0"
                    value="1"
                    @click="addPointRedChui()"
                  ></v-radio>
                  <v-radio
                    color="primaryred"
                    class="mr-0"
                    value="2"
                    @click="addPointRedChui()"
                  ></v-radio>
                  <!-- <v-radio
                    color="primaryred"
                    class="mr-0"
                    value="3"
                    @click="addPointRedChui()"
                  ></v-radio> -->
                </v-radio-group>
                <v-icon class="align-self-center pointer" @click="subRedChui()"
                  >mdi-step-backward</v-icon
                >
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Blue Corner -->
      <div class="corner">
        <div class="blue-corner pt-4 px-4">
          <p class="font-weight-semi text-18 text-center">
            {{ blueName }} <span class="mx-3 primary--text">|</span>
            {{ blueClub }}
          </p>
          <div class="d-block">
            <!-- Points -->
            <div class="d-block mb-6">
              <div class="d-flex justify-center">
                <div class="d-flex justify-space-around">
                  <div>
                    <p class="w-100 text-center font-weight-medium mb-0">
                      Ippong 1
                    </p>
                    <p
                        class="
                          mb-0
                          align-self-center
                          font-weight-semi
                          text-score-small
                          mx-10 text-center
                        "
                      >
                        {{ blueIppong1 }}
                      </p>
                    <div class="d-flex">
                      <v-btn
                        min-width="30px"
                        elevation="0"
                        x-small
                        color="primaryblue"
                        class="rounded-8 my-1 px-2 mx-2"
                        @click="changeBlueIppong1(3)"
                      >
                        +3
                      </v-btn>

                      <v-btn
                        min-width="30px"
                        elevation="0"
                        x-small
                        color="primaryblue"
                        class="rounded-8 my-1 px-2 mx-2"
                        @click="blueIppong1 >= 3 ? changeBlueIppong1(-3) : ''"
                      >
                        -3
                      </v-btn>
                    </div>
                    <div class="d-flex justify-center">
                      <v-btn
                        min-width="30px"
                        elevation="0"
                        x-small
                        color="primaryblue"
                        class="rounded-8 my-1 px-2 mx-2"
                        @click="changeBlueIppong1(2)"
                      >
                        +2
                      </v-btn>
                      <v-btn
                        min-width="30px"
                        elevation="0"
                        x-small
                        color="primaryblue"
                        class="rounded-8 my-1 px-2 mx-2"
                        @click="changeBlueIppong1(blueIppong1 > 1 ? -2 : 0)"
                      >
                        -2
                      </v-btn>
                    </div>
                  </div>
                  <div>
                    <p class="w-100 text-center font-weight-medium mb-0">
                      Ippong 2
                    </p>
                    <p
                        class="
                          mb-0
                          align-self-center
                          font-weight-semi
                          text-score-small
                          mx-10 text-center
                        "
                      >
                        {{ blueIppong2 }}
                      </p>
                    <div class="d-flex">
                      <v-btn
                        min-width="30px"
                        elevation="0"
                        x-small
                        color="primaryblue"
                        class="rounded-8 my-1 px-2 mx-2"
                        @click="changeBlueIppong2(3)"
                      >
                        +3
                      </v-btn>


                      <v-btn
                        min-width="30px"
                        elevation="0"
                        x-small
                        color="primaryblue"
                        class="rounded-8 my-1 px-2 mx-2"
                        @click="blueIppong2 >= 3 ? changeBlueIppong2(-3) : ''"
                      >
                        -3
                      </v-btn>
                    </div>

                    <div class="d-flex justify-center">
                      <v-btn
                        min-width="30px"
                        elevation="0"
                        x-small
                        color="primaryblue"
                        class="rounded-8 my-1 px-2 mx-2"
                        @click="changeBlueIppong2(2)"
                      >
                        +2
                      </v-btn>
                      <v-btn
                        min-width="30px"
                        elevation="0"
                        x-small
                        color="primaryblue"
                        class="rounded-8 my-1 px-2 mx-2"
                        @click="changeBlueIppong2(blueIppong2 > 1 ? -2 : 0)"
                      >
                        -2
                      </v-btn>
                    </div>
                  </div>
                  <div>
                    <p class="w-100 text-center font-weight-medium mb-0">
                      Ippong 3
                    </p>
                    <p
                        class="
                          mb-0
                          align-self-center
                          font-weight-semi
                          text-score-small
                          mx-3 text-center
                        "
                      >
                        {{ blueIppong3 }}
                      </p>
                    <div class="d-flex">
                      <v-btn
                        min-width="30px"
                        elevation="0"
                        x-small
                        color="primaryblue"
                        class="rounded-8 my-1 px-2 mx-2"
                        @click="changeBlueIppong3(3)"
                      >
                        +3
                      </v-btn>


                      <v-btn
                        min-width="30px"
                        elevation="0"
                        x-small
                        color="primaryblue"
                        class="rounded-8 my-1 px-2 mx-2"
                        @click="blueIppong3 >= 3 ? changeBlueIppong3(-3) : ''"
                      >
                        -3
                      </v-btn>
                    </div>
                    <div class="d-flex justify-center">
                      <v-btn
                        min-width="30px"
                        elevation="0"
                        x-small
                        color="primaryblue"
                        class="rounded-8 my-1 px-2 mx-2"
                        @click="changeBlueIppong3(2)"
                      >
                        +2
                      </v-btn>
                      <v-btn
                        min-width="30px"
                        elevation="0"
                        x-small
                        color="primaryblue"
                        class="rounded-8 my-1 px-2 mx-2"
                        @click="blueIppong3 > 1 ? changeBlueIppong3(-2) : ''"
                      >
                        -2
                      </v-btn>
                    </div>
                  </div>
                </div>
                <div class="align-self-center">
                  <p
                    class="
                      mb-0
                      align-self-center
                      font-weight-semi
                      text-score
                      mx-10
                    "
                  >
                    {{ bluePoints }}
                  </p>
                  <p class="w-100 text-center font-weight-medium mb-0">
                    Points
                  </p>
                </div>
              </div>
            </div>

            <div class="d-flex justify-space-around">
              <!-- Washari -->
              <div class="d-block">
                <div class="d-flex justify-space-around">
                  <div>
                    <v-btn
                      block
                      elevation="0"
                      color="primaryblue"
                      class="rounded-8 my-1 px-3"
                      @click="changeBlueWashari(1)"
                    >
                      +1
                    </v-btn>
                  </div>
                  <p
                    class="
                      mb-0
                      align-self-center
                      text-30
                      height-30
                      font-weight-semi
                      mx-3
                    "
                  >
                    {{ blueWashari }}
                  </p>
                  <div>
                    <v-btn
                      block
                      elevation="0"
                      color="primaryblue"
                      class="rounded-8 my-1 px-3"
                      @click="changeBlueWashari(blueWashari > 0 ? -1 : 0)"
                    >
                      -1
                    </v-btn>
                  </div>
                </div>
                <p class="w-100 text-center font-weight-medium mt-3">Washari</p>
              </div>

              <v-btn
                color="primaryblue"
                class="rounded-8 px-0 my-3"
                elevation="0"
                min-width="45"
                @click="blueReset()"
              >
                <v-icon class="white--text">mdi-restart</v-icon>
              </v-btn>

              <!-- Shido -->
              <div class="d-block">
                <div class="d-flex justify-space-around">
                  <div>
                    <v-btn
                      block
                      elevation="0"
                      color="primaryblue"
                      class="rounded-8 my-1 px-3"
                      @click="changeBlueShido(1)"
                    >
                      +1
                    </v-btn>
                  </div>
                  <p
                    class="
                      mb-0
                      align-self-center
                      text-30
                      height-30
                      font-weight-semi
                      mx-3
                    "
                  >
                    {{ blueShido }}
                  </p>
                  <div>
                    <v-btn
                      block
                      elevation="0"
                      color="primaryblue"
                      class="rounded-8 my-1 px-3"
                      @click="changeBlueShido(blueShido > 0 ? -1 : 0)"
                    >
                      -1
                    </v-btn>
                  </div>
                </div>
                <p class="w-100 text-center font-weight-medium mt-3">Shido</p>
              </div>
            </div>

            <hr class="w-100" />

            <div class="d-flex justify-space-between pb-4 pt-3 px-10">
              <p class="font-weight-medium mb-0 align-self-center">Chui</p>
              <div class="d-flex">
                <v-radio-group
                  v-model="blueChui"
                  hide-details
                  multiple
                  row
                  class="mt-0 pb-1"
                >
                  <v-radio
                    color="primaryblue"
                    class="mr-0"
                    value="1"
                    @click="addPointBlueChui()"
                  ></v-radio>
                  <v-radio
                    color="primaryblue"
                    class="mr-0"
                    value="2"
                    @click="addPointBlueChui()"
                  ></v-radio>
                  <!-- <v-radio
                    color="primaryblue"
                    class="mr-0"
                    value="3"
                    @click="addPointBlueChui()"
                  ></v-radio> -->
                </v-radio-group>
                <v-icon class="align-self-center pointer" @click="subBlueChui()"
                  >mdi-step-backward</v-icon
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="d-flex justify-space-between mt-5">
      <div class="time-corner">
        <div class="red-corner pa-4">
          <p class="mb-0 mr-1 text-center">Medis</p>
          <p class="mb-0 text-timer-medic font-weight-semi text-center">
            {{ redTime | timeFormat }}
          </p>
          <div class="d-flex mb-0 justify-center mt-2">
            <v-icon class="mx-1 text-24 pointer" @click="startRedTime()"
              >mdi-play-circle-outline</v-icon
            >
            <v-icon class="mx-1 text-24 pointer" @click="pauseRedTime()"
              >mdi-pause-circle-outline</v-icon
            >
            <v-icon class="mx-1 text-24 pointer" @click="stopRedTime()"
              >mdi-stop-circle-outline</v-icon
            >
          </div>
        </div>
      </div>
      <div class="time-corner">
        <div class="redblue-corner">
          <div class="redblue-corner-inner pa-4">
            <p class="mb-0 mr-1 text-center">Osaikomi</p>
            <p class="mb-0 text-timer-medic font-weight-semi text-center">
              {{ osaikomiTime | timeFormat }}
            </p>
            <div class="d-flex mb-0 justify-center mt-2">
              <v-icon class="mx-1 text-24 pointer" @click="startOsaikomiTime()"
                >mdi-play-circle-outline</v-icon
              >
              <v-icon class="mx-1 text-24 pointer" @click="pauseOsaikomiTime()"
                >mdi-pause-circle-outline</v-icon
              >
              <v-icon class="mx-1 text-24 pointer" @click="stopOsaikomiTime()"
                >mdi-stop-circle-outline</v-icon
              >
            </div>
          </div>
        </div>
      </div>
      <div class="time-corner">
        <div class="blue-corner pa-4">
          <p class="mb-0 mr-1 text-center">Medis</p>
          <p class="mb-0 text-timer-medic font-weight-semi text-center">
            {{ blueTime | timeFormat }}
          </p>
          <div class="d-flex mb-0 justify-center mt-2">
            <v-icon class="mx-1 text-24 pointer" @click="startBlueTime()"
              >mdi-play-circle-outline</v-icon
            >
            <v-icon class="mx-1 text-24 pointer" @click="pauseBlueTime()"
              >mdi-pause-circle-outline</v-icon
            >
            <v-icon class="mx-1 text-24 pointer" @click="stopBlueTime()"
              >mdi-stop-circle-outline</v-icon
            >
          </div>
        </div>
      </div>
    </div>
    <div class="d-flex justify-space-between mt-10">
      <!-- Setting Time -->
      <div class="main-timer">
        <div class="main-timer-inner py-4">
          <p class="mb-3 w-100 text-center text-score font-weight-semi">
            {{ time | timeFormat }}
          </p>
          <div class="d-flex mb-0 justify-center">
            <v-icon class="mx-2 text-28 pointer" @click="timeStart ? '' : startTime()"
              >mdi-play-circle-outline</v-icon
            >
            <v-icon class="mx-2 text-28 pointer" @click="pauseTime()"
              >mdi-pause-circle-outline</v-icon
            >
            <v-icon class="mx-2 text-28 pointer" @click="stopTime()"
              >mdi-stop-circle-outline</v-icon
            >
            <v-icon
              class="mx-2 text-28 pointer"
              @click="settingTime = !settingTime"
              >mdi-cog</v-icon
            >
          </div>
          <div class="d-flex justify-center">
            <v-expand-transition>
              <div v-show="settingTime" class="field-time pt-4">
                <v-text-field
                  v-model="inputTime"
                  solo
                  hide-details
                  placeholder="Main timer (seconds)"
                  append-icon="mdi-check"
                  @keyup.enter="
                    setTime(inputTime),
                      (time = inputTime),
                      (settingTime = false)
                  "
                  @click:append="
                    setTime(inputTime),
                      (time = inputTime),
                      (settingTime = false)
                  "
                ></v-text-field>
              </div>
            </v-expand-transition>
          </div>
        </div>
      </div>
      <!-- End Control -->
      <div class="main-timer">
        <div class="main-timer-inner py-4">
          <div class="d-flex mb-0 justify-center h-100">
            <div class="mx-1 align-self-center">
              <div v-if="!dialogWinner" class="d-flex flex-nowrap">
                <v-btn
                  color="primaryred"
                  small
                  class="rounded-8 mx-2"
                  @click="setWinner(1)"
                  >Red</v-btn
                >
                <v-btn
                  color="primaryblue"
                  small
                  class="rounded-8 mx-2"
                  @click="setWinner(2)"
                  >Blue</v-btn
                >
              </div>
              <div v-else>
                <v-btn
                  color="primaryred"
                  small
                  class="rounded-8 mx-2"
                  @click="hideWinner()"
                  >Close</v-btn
                >
              </div>
              <p class="mb-0 font-weight-semi text-center pt-2">Winner</p>
            </div>
            <div class="mx-1 align-self-center">
              <div v-if="!dialogDis" class="d-flex flex-nowrap">
                <v-btn
                  color="primaryred"
                  small
                  class="rounded-8 mx-2"
                  @click="setDis(1)"
                  >Red</v-btn
                >
                <v-btn
                  color="primaryblue"
                  small
                  class="rounded-8 mx-2"
                  @click="setDis(2)"
                  >Blue</v-btn
                >
              </div>
              <div v-else>
                <v-btn
                  color="primaryred"
                  small
                  class="rounded-8 mx-2"
                  @click="hideDis()"
                  >Close</v-btn
                >
              </div>
              <p class="mb-0 font-weight-semi text-center pt-2">Hansokumake</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card-dashboard my-8">
      <div class="d-flex justify-space-between">
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
          Waiting List
        </p>
        <div class="d-flex pt-6 pr-6">
          <v-progress-circular
            v-if="loadingSave || loadingPlay"
            indeterminate
            color="white"
          ></v-progress-circular>
          <v-btn
            v-else
            class="px-1 rounded-8 align-self-center"
            @click="dialogAdd = true"
          >
            <v-icon class="text-18">mdi-plus</v-icon> Add
          </v-btn>
        </div>
      </div>
      <v-data-table
        :headers="header"
        :items="participants"
        class="mx-6 mt-6"
        no-data-text="Empty"
        no-result-text="Data not found"
      >
        <template slot="item.status" slot-scope="props">
          <div class="d-flex">
            <v-chip v-show="props.item.play_now === 1" color="success" small
              >Playing</v-chip
            >
            <v-chip
              v-show="props.item.play_now === 2"
              color="grey darken-2"
              small
              >Done</v-chip
            >
            <v-chip
              v-show="props.item.play_now === 0 || props.item.play_now === null"
              color="warning"
              small
              >Waiting</v-chip
            >
          </div>
        </template>
        <template slot="item.action" slot-scope="props">
          <div class="d-flex">
            <v-btn
              v-if="props.item.play_now == 0"
              x-small
              class="px-0 rounded-sm mr-2"
              min-width="34"
              @click="setPlay(props.item.chart_id)"
            >
              <v-icon class="text-16 px-0">mdi-play</v-icon>
            </v-btn>
            <v-btn
              v-if="props.item.play_now == 1"
              x-small
              class="px-0 rounded-sm mr-2"
              min-width="34"
              @click="saveGame(props.item)"
            >
              <v-icon class="text-16 px-0">mdi-floppy</v-icon>
            </v-btn>
            <v-btn
              v-if="props.item.play_now != 2"
              x-small
              class="px-0 rounded-sm mr-2"
              min-width="34"
              @click="editGame(props.item)"
            >
              <v-icon class="text-16 px-0">mdi-pencil</v-icon>
            </v-btn>
            <v-menu v-if="props.item.play_now == 1" offset-y>
              <template #activator="{ on, attrs }">
                <v-btn
                  x-small
                  class="px-0 rounded-sm mr-2"
                  min-width="34"
                  color="success"
                  v-bind="attrs"
                  v-on="on"
                >
                  <v-icon class="text-16 px-0">mdi-crown</v-icon>
                </v-btn>
              </template>
              <v-list>
                <v-list-item>
                  <v-list-item-title class="pointer" @click="autoWin(1, props.item)">Red Win</v-list-item-title>
                </v-list-item>
                <v-list-item>
                  <v-list-item-title class="pointer" @click="autoWin(2, props.item)">Blue Win</v-list-item-title>
                </v-list-item>
              </v-list>
            </v-menu>
            <v-btn
              v-if="props.item.play_now != 2"
              x-small
              class="px-0 rounded-sm"
              min-width="34"
              color="red"
              @click="
                ;(dialogConfirmDelete = true),
                  (dataDialogDelete = props.item.chart_id)
              "
            >
              <v-icon class="text-16 px-0">mdi-delete</v-icon>
            </v-btn>
          </div>
        </template>
      </v-data-table>
    </div>

    <v-snackbar
      v-model="snackbar"
      timeout="10000"
      app
      centered
      :color="color"
      elevation="3"
    >
      {{ message }}
      <template #action="{ attrs }">
        <v-btn
          color="white"
          icon
          v-bind="attrs"
          @click=";(snackbar = false), hideDis(), hideWinner()"
        >
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </template>
    </v-snackbar>

    <v-dialog v-model="dialogAdd" persistent max-width="400px">
      <v-card>
        <span class="float-right pt-2 pr-2 pointer" @click="dialogAdd = false"
          ><v-icon class="text-14 white--text">mdi-close</v-icon></span
        >
        <div class="pa-4">
          <p class="mb-0 text-18 height-28 font-weight-semi">Add Participant</p>
        </div>
        <v-divider color="white"></v-divider>
        <div class="pa-4">
          <div class="mb-3">
            <v-row>
              <v-col cols="12" class="py-0 text-14">Data Red</v-col>
              <v-col cols="12" sm="6" class="pt-2">
                <v-text-field
                  v-model="dataDialogAdd.redName"
                  hide-details
                  outlined
                  placeholder="Red Name"
                  dense
                  auto
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" class="pt-2">
                <v-text-field
                  v-model="dataDialogAdd.redClub"
                  hide-details
                  outlined
                  placeholder="Red Club"
                  dense
                  auto
                ></v-text-field>
              </v-col>
            </v-row>
          </div>
          <div class="mb-3">
            <v-row>
              <v-col cols="12" class="py-0 text-14">Data Blue</v-col>
              <v-col cols="12" sm="6" class="pt-2">
                <v-text-field
                  v-model="dataDialogAdd.blueName"
                  hide-details
                  outlined
                  placeholder="Blue Name"
                  dense
                  auto
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" class="pt-2">
                <v-text-field
                  v-model="dataDialogAdd.blueClub"
                  hide-details
                  outlined
                  placeholder="Blue Club"
                  dense
                  auto
                ></v-text-field>
              </v-col>
            </v-row>
          </div>
          <div class="mt-4 mb-6">
            <v-text-field
              v-model="dataDialogAdd.match"
              hide-details
              type="number"
              hide-spin-buttons
              outlined
              placeholder="Match Number"
              dense
              auto
            ></v-text-field>
          </div>
          <v-btn
            small
            block
            color="grey darken-1"
            class="rounded-8"
            :loading="loadingAdd"
            @click="addChart()"
            >Submit</v-btn
          >
        </div>
      </v-card>
    </v-dialog>
    <v-dialog v-model="dialogEdit" persistent max-width="400px">
      <v-card>
        <span class="float-right pt-2 pr-2 pointer" @click="dialogEdit = false"
          ><v-icon class="text-14 white--text">mdi-close</v-icon></span
        >
        <div class="pa-4">
          <p class="mb-0 text-18 height-28 font-weight-semi">
            Edit Participant
          </p>
        </div>
        <v-divider color="white"></v-divider>
        <div class="pa-4">
          <div class="mb-3">
            <v-row>
              <v-col cols="12" class="py-0 text-14">Data Red</v-col>
              <v-col cols="12" sm="6" class="pt-2">
                <v-text-field
                  v-model="dataDialogEdit.redName"
                  hide-details
                  outlined
                  placeholder="Red Name"
                  dense
                  auto
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" class="pt-2">
                <v-text-field
                  v-model="dataDialogEdit.redClub"
                  hide-details
                  outlined
                  placeholder="Red Club"
                  dense
                  auto
                ></v-text-field>
              </v-col>
            </v-row>
          </div>
          <div class="mb-3">
            <v-row>
              <v-col cols="12" class="py-0 text-14">Data Blue</v-col>
              <v-col cols="12" sm="6" class="pt-2">
                <v-text-field
                  v-model="dataDialogEdit.blueName"
                  hide-details
                  outlined
                  placeholder="Blue Name"
                  dense
                  auto
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" class="pt-2">
                <v-text-field
                  v-model="dataDialogEdit.blueClub"
                  hide-details
                  outlined
                  placeholder="Blue Club"
                  dense
                  auto
                ></v-text-field>
              </v-col>
            </v-row>
          </div>
          <div class="mt-4 mb-6">
            <v-text-field
              v-model="dataDialogEdit.match"
              hide-details
              hide-spin-buttons
              outlined
              type="number"
              placeholder="Match Number"
              dense
              auto
            ></v-text-field>
          </div>
          <v-btn
            small
            block
            color="grey darken-1"
            class="rounded-8"
            :loading="loadingEdit"
            @click="editChart()"
            >Submit</v-btn
          >
        </div>
      </v-card>
    </v-dialog>
    <v-dialog v-model="dialogConfirmDelete" persistent max-width="400px">
      <v-card>
        <span
          class="float-right pt-2 pr-2 pointer"
          @click="dialogConfirmDelete = false"
          ><v-icon class="text-14 white--text">mdi-close</v-icon></span
        >
        <div class="pa-4">
          <p class="mb-0 text-center text-18 height-28 font-weight-semi">
            Delete Participant
          </p>
        </div>
        <v-divider color="white"></v-divider>
        <div class="pa-4">
          <v-row>
            <v-col cols="6">
              <v-btn
                small
                block
                outlined
                color="white"
                class="rounded-8"
                :loading="loadingDelete"
                @click="deleteChart(dataDialogDelete)"
                >Delete</v-btn
              >
            </v-col>
            <v-col cols="6">
              <v-btn
                small
                block
                color="grey darken-1"
                class="rounded-8"
                @click="dialogConfirmDelete = false"
                >Cancel</v-btn
              >
            </v-col>
          </v-row>
        </div>
      </v-card>
    </v-dialog>

    <!-- Audio -->
    <div class="d-none">
      <audio ref="timesUpAudio" controls>
        <source src="/sound/horn.mp3" type="audio/mpeg" />
      </audio>
    </div>
    <div class="d-none">
      <audio ref="timesUpAudio2" controls>
        <source src="/sound/whistle.mp3" type="audio/mpeg" />
      </audio>
    </div>
  </div>
</template>

<script>
// import WinnerDialogVue from '~/components/WinnerDialog.vue'
export default {
  name: 'ControlsPBJIFighting',
  middleware: 'login',
  // components: { WinnerDialogVue },
  data() {
    return {
      dataMain: {
        martial_id: null,
        tournament_id: null,
        category_id: null,
        chart_id: null,
        game_id: null,
      },
      scoringType: 2,
      categoryName: 'Category',
      tournament: '',

      header: [
        {
          text: 'No',
          align: 'start',
          value: 'number',
          sortable: false,
          class: 'grey--text font-weight-regular',
        },
        {
          text: 'Red Name',
          align: 'start',
          value: 'red_name',
          sortable: false,
          class: 'grey--text font-weight-regular',
        },
        {
          text: 'Red Club',
          align: 'start',
          value: 'red_club',
          sortable: false,
          class: 'grey--text font-weight-regular',
        },
        {
          text: 'Blue Name',
          align: 'start',
          value: 'blue_name',
          sortable: false,
          class: 'grey--text font-weight-regular',
        },
        {
          text: 'Blue Club',
          align: 'start',
          value: 'blue_club',
          sortable: false,
          class: 'grey--text font-weight-regular',
        },
        {
          text: 'Match',
          align: 'start',
          value: 'match',
          sortable: false,
          class: 'grey--text font-weight-regular',
        },
        {
          text: 'Status',
          align: 'start',
          value: 'status',
          sortable: false,
          class: 'grey--text font-weight-regular',
        },
        {
          text: 'Action',
          align: 'center',
          value: 'action',
          sortable: false,
          class: 'grey--text font-weight-regular',
        },
      ],
      participants: [],
      currentMatch: 1,

      time: 0,
      timeStart: false,
      timePause: false,
      inputTime: '',
      settingTime: false,
      changeTime: false,

      redTime: 120,
      redTimeStart: false,
      redTimePause: false,

      blueTime: 120,
      blueTimeStart: false,
      blueTimePause: false,

      osaikomiTime: 0,
      osaikomiTimeStart: false,
      osaikomiTimePause: false,

      redName: 'Player Red',
      redClub: 'Red Club',

      redPoints: 0,
      redIppong1: 0,
      redIppong2: 0,
      redIppong3: 0,
      redWashari: 0,
      redShido: 0,
      redChui: [],
      redIppong3PointAdder: 1,

      blueName: 'Player Blue',
      blueClub: 'Blue Club',

      bluePoints: 0,
      blueIppong1: 0,
      blueIppong2: 0,
      blueIppong3: 0,
      blueWashari: 0,
      blueShido: 0,
      blueChui: [],
      blueIppong3PointAdder: 1,

      dialogWinner: false,
      dialogWinnerTap: false,
      dialogDis: false,
      winner: null,
      disqualified: null,

      gameSaved: true,
      playing: false,

      dialogAdd: false,
      dialogEdit: false,
      dialogConfirmDelete: false,

      dataDialogEdit: {
        redName: '',
        redClub: '',
        blueName: '',
        blueClub: '',
        match: '',
      },
      dataDialogAdd: {
        redName: '',
        redClub: '',
        blueName: '',
        blueClub: '',
        match: '',
      },
      dataDialogDelete: null,

      loadingAdd: false,
      loadingEdit: false,
      loadingSave: false,
      loadingPlay: false,
      loadingDelete: false,

      snackbar: false,
      color: 'primaryred',
      message: '',
    }
  },
  computed: {},
  watch: {
    time() {
      if (this.timeStart && !this.timePause) {
        if (this.time > 0) {
          setTimeout(() => {
            this.time--
            this.setTime(this.time)
          }, 1000)
        } else {
          setTimeout(() => {
            if (this.time === 0) {
              this.playSound()
            }
          }, 50)
        }
      }
    },
    redTime() {
      if (this.redTimeStart && !this.redTimePause) {
        if (this.redTime > 0) {
          setTimeout(() => {
            this.redTime--
            this.setRedTime(this.redTime)
          }, 1000)
        }
      }
    },
    blueTime() {
      if (this.blueTimeStart && !this.blueTimePause) {
        if (this.blueTime > 0) {
          setTimeout(() => {
            this.blueTime--
            this.setBlueTime(this.blueTime)
          }, 1000)
        }
      }
    },
    osaikomiTime() {
      if (this.osaikomiTimeStart && !this.osaikomiTimePause) {
        if (this.osaikomiTime < 15) {
          setTimeout(() => {
            this.osaikomiTime++
            this.setOsaikomiTime(this.osaikomiTime)
          }, 1000)
        }
      }
    },
  },
  mounted() {
    const data = this.$cookies.get('data_chart')
    if (data) {
      this.dataMain.martial_id = data.martial
      this.dataMain.tournament_id = data.tournament
      this.dataMain.category_id = data.category
    }
    this.getParticipant()

    window.addEventListener('keyup', (event) => {
      this.controlOsaikomi(event);
    });
  },
  methods: {
    setTime(t) {
      const local = {
        time: t,
      }
      localStorage.setItem('mainTime', JSON.stringify(local))
    },
    startTime() {
      if (!this.timeStart) {
        this.timeStart = true
        this.timePause = false
        setTimeout(() => {
          const t = this.time - 1;
          this.time = t
          this.setTime(t)
        }, 1000)
      }
    },
    pauseTime() {
      this.timeStart = false
      this.timePause = true
    },
    stopTime() {
      this.time = this.inputTime
      this.timeStart = false
      this.timePause = false
      this.setTime(this.time)
    },

    setRedTime(t) {
      let local = localStorage.getItem('fightingRedTime')
      if (local != null) {
        local = JSON.parse(local)
        local.time = t
      } else {
        local = {
          time: t,
        }
      }
      localStorage.setItem('fightingRedTime', JSON.stringify(local))
    },
    startRedTime() {
      this.redTimeStart = true
      this.redTimePause = false
      const t = this.redTime
      this.redTime = 0
      setTimeout(() => {
        this.redTime = t
      }, 1)
    },
    pauseRedTime() {
      this.redTimeStart = false
      this.redTimePause = true
    },
    stopRedTime() {
      this.redTime = 120
      this.setRedTime(this.redTime)
      this.redTimeStart = false
      this.redTimePause = false
    },

    setBlueTime(t) {
      let local = localStorage.getItem('fightingBlueTime')
      if (local != null) {
        local = JSON.parse(local)
        local.time = t
      } else {
        local = {
          time: t,
        }
      }
      localStorage.setItem('fightingBlueTime', JSON.stringify(local))
    },
    startBlueTime() {
      this.blueTimeStart = true
      this.blueTimePause = false
      const t = this.blueTime
      this.blueTime = 0
      setTimeout(() => {
        this.blueTime = t
      }, 1)
    },
    pauseBlueTime() {
      this.blueTimeStart = false
      this.blueTimePause = true
    },
    stopBlueTime() {
      this.blueTime = 120
      this.setBlueTime(this.blueTime)
      this.blueTimeStart = false
      this.blueTimePause = false
    },

    setOsaikomiTime(t) {
      const local = {
        time: t,
      }
      localStorage.setItem('fightingOsaikomiTime', JSON.stringify(local))
    },
    startOsaikomiTime() {
      if (!this.osaikomiTimeStart) {
        this.osaikomiTimeStart = true
        this.osaikomiTimePause = false
        this.osaikomiTime = 0
        setTimeout(() => {
          this.osaikomiTime = 1
          this.setOsaikomiTime(1)
        }, 1000)
      }
    },
    pauseOsaikomiTime() {
      this.osaikomiTimeStart = false
      this.osaikomiTimePause = true
    },
    stopOsaikomiTime() {
      this.osaikomiTime = 0
      this.osaikomiTimeStart = false
      this.osaikomiTimePause = false
      this.setOsaikomiTime(this.osaikomiTime)
    },
    controlOsaikomi(event) {
      if (event?.keyCode === 17) {
        this.startOsaikomiTime()
      } else if (event?.keyCode === 16) {
        if (this.osaikomiTimeStart) {
          this.pauseOsaikomiTime()
        } else {
          this.stopOsaikomiTime()
        }
      }
    },

    changeRedIppong1(value) {
      let local = localStorage.getItem('fightingRed')
      this.redIppong1 += value
      this.redPoints += value
      if (local != null) {
        local = JSON.parse(local)
        local.ippong1 = this.redIppong1
        local.score = this.redPoints
      } else {
        local = {
          score: this.redPoints,
          ippong1: this.redIppong1,
          ippong2: 0,
          ippong3: 0,
          washari: 0,
          shido: 0,
          chui: 0,
        }
      }
      this.checkRedFullIppong()
      localStorage.setItem('fightingRed', JSON.stringify(local))
    },
    changeRedIppong2(value) {
      let local = localStorage.getItem('fightingRed')
      this.redIppong2 += value
      this.redPoints += value
      if (local != null) {
        local = JSON.parse(local)
        local.ippong2 = this.redIppong2
        local.score = this.redPoints
      } else {
        local = {
          score: this.redPoints,
          ippong1: 0,
          ippong2: this.redIppong2,
          ippong3: 0,
          washari: 0,
          shido: 0,
          chui: 0,
        }
      }
      this.checkRedFullIppong()
      localStorage.setItem('fightingRed', JSON.stringify(local))
    },
    changeRedIppong3(value) {
      let local = localStorage.getItem('fightingRed')
      this.redIppong3 += value
      this.redPoints += value
      if (local != null) {
        local = JSON.parse(local)
        local.ippong3 = this.redIppong3
        local.score = this.redPoints
      } else {
        local = {
          score: this.redPoints,
          ippong1: 0,
          ippong2: 0,
          ippong3: this.redIppong3,
          washari: 0,
          shido: 0,
          chui: 0,
        }
      }
      this.checkRedFullIppong()
      localStorage.setItem('fightingRed', JSON.stringify(local))
    },
    changeRedScore(value) {
      let local = localStorage.getItem('fightingRed')
      this.redPoints += value
      if (local != null) {
        local = JSON.parse(local)
        local.score = this.redPoints
      } else {
        local = {
          score: this.redPoints,
          ippong1: 0,
          ippong2: 0,
          ippong3: 0,
          washari: 0,
          shido: 0,
          chui: 0,
        }
      }
      localStorage.setItem('fightingRed', JSON.stringify(local))
    },
    changeRedWashari(value) {
      let local = localStorage.getItem('fightingRed')
      this.redWashari += value
      this.redPoints += value
      if (local != null) {
        local = JSON.parse(local)
        local.washari = this.redWashari
        local.score = this.redPoints
      } else {
        local = {
          score: this.redPoints,
          ippong1: 0,
          ippong2: 0,
          ippong3: 0,
          washari: this.redWashari,
          shido: 0,
          chui: 0,
        }
      }
      localStorage.setItem('fightingRed', JSON.stringify(local))
    },
    changeRedShido(value) {


      let local = localStorage.getItem('fightingRed')
      // const temp = this.redShido
      this.redShido += value

      // Add Washari
      if (this.redShido === 0) {
        this.changeBlueWashari(value)
      } else if (this.redShido === 1) {
        this.changeBlueWashari(value)
      } else if (this.redShido === 2) {
        this.changeBlueWashari(value)
      } else if (this.redShido === 3) {
        this.changeBlueWashari(value)
        this.redShido = 0;
        if (this.redChui.length > 0) {
          this.redChui = ['1', '2']
          this.changeRedChui()
          this.setDis(1)
        } else {
          this.redChui = ['1']
          this.changeRedChui()
        }
      }

      if (local != null) {
        local = JSON.parse(local)
        local.shido = this.redShido
        local.washari = this.redWashari
        local.score = this.redPoints
        local.chui = this.redChui.length
      } else {
        local = {
          score: this.redPoints,
          ippong1: 0,
          ippong2: 0,
          ippong3: 0,
          washari: this.redWashari,
          shido: this.redShido,
          chui: this.redChui.length,
        }
      }
      localStorage.setItem('fightingRed', JSON.stringify(local))
    },
    addPointRedChui() {
      // this.changeBlueScore(3)
      this.changeBlueWashari(3)
      this.changeRedChui()
    },
    changeRedChui() {
      let local = localStorage.getItem('fightingRed')
      if (local != null) {
        local = JSON.parse(local)
        local.chui = this.redChui.length
      } else {
        local = {
          score: 0,
          ippong1: 0,
          ippong2: 0,
          ippong3: 0,
          washari: 0,
          shido: 0,
          chui: this.redChui.length,
        }
      }
      localStorage.setItem('fightingRed', JSON.stringify(local))

      if (this.redChui.length === 2) {
        this.setDis(1)
      }
    },
    subRedChui() {
      if (this.redChui.length > 0) {
        const id = this.redChui.length - 1
        this.redChui.splice(id, 1)
        this.changeRedChui()
        // this.changeBlueScore(-3)
        this.changeBlueWashari(-3)
      }
    },
    checkRedFullIppong() {
      if (this.redIppong1 && this.redIppong2 && this.redIppong3) {

        const absolutewin = 50 - this.redPoints;
        this.redPoints += absolutewin;

        this.setWinner(1)

        this.blueReset();
      }
    },

    changeBlueIppong1(value) {
      let local = localStorage.getItem('fightingBlue')
      this.blueIppong1 += value
      this.bluePoints += value
      if (local != null) {
        local = JSON.parse(local)
        local.ippong1 = this.blueIppong1
        local.score = this.bluePoints
      } else {
        local = {
          score: this.bluePoints,
          ippong1: this.blueIppong1,
          ippong2: 0,
          ippong3: 0,
          washari: 0,
          shido: 0,
          chui: 0,
        }
      }
      this.checkBlueFullIppong()
      localStorage.setItem('fightingBlue', JSON.stringify(local))
    },
    changeBlueIppong2(value) {
      let local = localStorage.getItem('fightingBlue')
      this.blueIppong2 += value
      this.bluePoints += value
      if (local != null) {
        local = JSON.parse(local)
        local.ippong2 = this.blueIppong2
        local.score = this.bluePoints
      } else {
        local = {
          score: this.bluePoints,
          ippong1: 0,
          ippong2: this.blueIppong2,
          ippong3: 0,
          washari: 0,
          shido: 0,
          chui: 0,
        }
      }
      this.checkBlueFullIppong()
      localStorage.setItem('fightingBlue', JSON.stringify(local))
    },
    changeBlueIppong3(value) {
      let local = localStorage.getItem('fightingBlue')
      this.blueIppong3 += value
      this.bluePoints += value
      if (local != null) {
        local = JSON.parse(local)
        local.ippong3 = this.blueIppong3
        local.score = this.bluePoints
      } else {
        local = {
          score: this.bluePoints,
          ippong1: 0,
          ippong2: 0,
          ippong3: this.blueIppong3,
          washari: 0,
          shido: 0,
          chui: 0,
        }
      }
      this.checkBlueFullIppong()
      localStorage.setItem('fightingBlue', JSON.stringify(local))
    },
    changeBlueScore(value) {
      let local = localStorage.getItem('fightingBlue')
      this.bluePoints += value
      if (local != null) {
        local = JSON.parse(local)
        local.score = this.bluePoints
      } else {
        local = {
          score: this.bluePoints,
          ippong1: 0,
          ippong2: 0,
          ippong3: 0,
          washari: 0,
          shido: 0,
          chui: 0,
        }
      }
      localStorage.setItem('fightingBlue', JSON.stringify(local))
    },
    changeBlueWashari(value) {
      let local = localStorage.getItem('fightingBlue')
      this.blueWashari += value
      this.bluePoints += value
      if (local != null) {
        local = JSON.parse(local)
        local.washari = this.blueWashari
        local.score = this.bluePoints
      } else {
        local = {
          score: this.bluePoints,
          ippong1: 0,
          ippong2: 0,
          ippong3: 0,
          washari: this.blueWashari,
          shido: 0,
          chui: 0,
        }
      }
      localStorage.setItem('fightingBlue', JSON.stringify(local))
    },
    changeBlueShido(value) {
      let local = localStorage.getItem('fightingBlue')
      // const temp = this.blueShido
      this.blueShido += value
      // Add Washari
      if (this.blueShido === 0) {
        this.changeRedWashari(value)
      } else if ( this.blueShido === 1) {
        this.changeRedWashari(value)
      } else if (this.blueShido === 2) {
        this.changeRedWashari(value)
      } else if (this.blueShido === 3) {
        this.changeRedWashari(value)
        this.blueShido = 0;
        if (this.blueChui.length > 0) {
          this.blueChui = ['1', '2']
          this.changeBlueChui()
          this.setDis(2)
        } else {
          this.blueChui = ['1']
          this.changeBlueChui()
        }
      }

      if (local != null) {
        local = JSON.parse(local)
        local.shido = this.blueShido
        local.chui = this.blueChui.length
        local.score = this.bluePoints
      } else {
        local = {
          score: this.bluePoints,
          ippong1: 0,
          ippong2: 0,
          ippong3: 0,
          washari: this.blueWashari,
          shido: this.blueShido,
          chui: this.blueChui.length,
        }
      }
      localStorage.setItem('fightingBlue', JSON.stringify(local))
    },
    addPointBlueChui() {
      // this.changeRedScore(3)
      this.changeRedWashari(3)
      this.changeBlueChui()
    },
    changeBlueChui() {
      let local = localStorage.getItem('fightingBlue')
      if (local != null) {
        local = JSON.parse(local)
        local.chui = this.blueChui.length
        local.shido = this.blueShido
        local.score = this.bluePoints
      } else {
        local = {
          score: this.bluePoints,
          ippong1: this.blueIppong1,
          ippong2: this.blueIppong2,
          ippong3: this.blueIppong3,
          washari: this.blueWashari,
          shido: this.blueShido,
          chui: this.blueChui.length,
        }
      }
      localStorage.setItem('fightingBlue', JSON.stringify(local))

      if (this.blueChui.length === 2) {
        this.setDis(2)
      }
    },
    subBlueChui() {
      if (this.blueChui.length > 0) {
        const id = this.blueChui.length - 1
        this.blueChui.splice(id, 1)
        this.changeBlueChui()
        // this.changeRedScore(-3)
        this.changeRedWashari(-3)
      }
    },
    checkBlueFullIppong() {
      if (this.blueIppong1 && this.blueIppong2 && this.blueIppong3) {
        const absolutewin = 50 - this.bluePoints;
        this.bluePoints += absolutewin;

        this.setWinner(2)

        this.redReset();
      }
    },

    setWinner(winner) {
      let local = localStorage.getItem('dataFightingWinner')
      this.winner = winner
      if (local != null) {
        local = JSON.parse(local)
        local.win = winner
        local.name = winner === 1 ? this.redName : this.blueName
        local.club = winner === 1 ? this.redClub : this.blueClub
        local.score = winner === 1 ? this.redPoints : this.bluePoints
        local.washari = winner === 1 ? this.redWashari : this.blueWashari
        local.shido = winner === 1 ? this.redShido : this.blueShido
        local.chui = winner === 1 ? this.redChui.length : this.blueChui.length
        local.show = true
        this.dialogWinner = true
      } else {
        local = {
          win: winner,
          name: winner === 1 ? this.redName : this.blueName,
          club: winner === 1 ? this.redClub : this.blueClub,
          score: winner === 1 ? this.redPoints : this.bluePoints,
          washari: winner === 1 ? this.redWashari : this.blueWashari,
          shido: winner === 1 ? this.redShido : this.blueShido,
          chui: winner === 1 ? this.redChui.length : this.blueChui.length,
          show: true,
        }
        this.dialogWinner = true
      }

      localStorage.setItem('dataFightingWinner', JSON.stringify(local))
      this.message = winner === 1 ? 'Red Win' : 'Blue Win'
      this.color = winner === 1 ? 'primaryred' : 'primaryblue'
      this.snackbar = true
    },
    hideWinner() {
      let local = localStorage.getItem('dataFightingWinner')
      if (local != null) {
        local = JSON.parse(local)
        local.show = false
      } else {
        local = {
          show: false,
        }
      }
      this.dialogWinner = false

      localStorage.setItem('dataFightingWinner', JSON.stringify(local))
      this.snackbar = false
    },

    redReset(dis = false) {
      this.redPoints = 0
      this.redIppong1 = 0
      this.redIppong2 = 0
      this.redIppong3 = 0
      this.redWashari = 0
      if (!dis) {
        this.redShido = 0
        this.redChui = []
      }

      let local = localStorage.getItem('fightingRed')
      if (local != null) {
        local = JSON.parse(local)
        local.score = this.redPoints = 0
        local.ippong1 = this.redIppong1 = 0
        local.ippong2 = this.redIppong2 = 0
        local.ippong3 = this.redIppong3 = 0
        local.washari = this.redWashari = 0
        local.shido = this.redShido
        local.chui = this.redChui.length
      } else {
        local = {
          score: 0,
          ippong1: 0,
          ippong2: 0,
          ippong3: 0,
          washari: 0,
          shido: this.redShido,
          chui: this.redChui.length,
        }
      }
      localStorage.setItem('fightingRed', JSON.stringify(local))
    },
    blueReset(dis = false) {
      this.bluePoints = 0
      this.blueIppong1 = 0
      this.blueIppong2 = 0
      this.blueIppong3 = 0
      this.blueWashari = 0
      if (!dis) {
        this.blueShido = 0
        this.blueChui = []
      }
      let local = localStorage.getItem('fightingBlue')
      if (local != null) {
        local = JSON.parse(local)
        local.score = this.bluePoints = 0
        local.ippong1 = this.blueIppong1 = 0
        local.ippong2 = this.blueIppong2 = 0
        local.ippong3 = this.blueIppong3 = 0
        local.washari = this.blueWashari = 0
        local.shido = this.blueShido
        local.chui = this.blueChui.length
      } else {
        local = {
          score: 0,
          ippong1: 0,
          ippong2: 0,
          ippong3: 0,
          washari: 0,
          shido: this.blueShido,
          chui: this.blueChui.length,
        }
      }
      localStorage.setItem('fightingBlue', JSON.stringify(local))
    },

    setDis(dis) {
      if (dis === 1) {
        const absolutewin = 50 - this.bluePoints;
        this.changeBlueScore(absolutewin);
        this.redReset(true);
      } else {
        const absolutewinRed = 50 - this.redPoints;
        this.changeRedScore(absolutewinRed);

        this.blueReset(true);
      }

      let local = localStorage.getItem('dataFightingDisqualified')
      if (dis === 1) {
        this.winner = 2
      } else {
        this.winner = 1
      }
      this.disqualified = dis
      if (local != null) {
        local = JSON.parse(local)
        local.name = dis === 1 ? this.redName : this.blueName
        local.club = dis === 1 ? this.redClub : this.blueClub
        local.score = dis === 1 ? this.redPoints : this.bluePoints
        local.washari = dis === 1 ? this.redWashari : this.blueWasaredWashari
        local.shido = dis === 1 ? this.redShido : this.blueShido
        local.chui = dis === 1 ? this.redChui.length : this.blueChui.length
        local.show = true
        this.dialogDis = true
      } else {
        local = {
          name: dis === 1 ? this.redName : this.blueName,
          club: dis === 1 ? this.redClub : this.blueClub,
          score: dis === 1 ? this.redPoints : this.bluePoints,
          washari: dis === 1 ? this.redWashari : this.blueWashari,
          shido: dis === 1 ? this.redShido : this.blueShido,
          chui: dis === 1 ? this.redChui.length : this.blueChui.length,
          show: true,
        }
        this.dialogDis = true
      }

      localStorage.setItem('dataFightingDisqualified', JSON.stringify(local))
      this.message = dis === 1 ? 'Red Hansokumake' : 'Blue Hansokumake'
      this.color = dis === 1 ? 'primaryred' : 'primaryblue'
      this.snackbar = true
    },
    hideDis() {
      let local = localStorage.getItem('dataFightingDisqualified')
      if (local != null) {
        local = JSON.parse(local)
        local.show = false
      } else {
        local = {
          show: false,
        }
      }
      this.dialogDis = false
      this.snackbar = false
      localStorage.setItem('dataFightingDisqualified', JSON.stringify(local))
    },

    async getParticipant() {
      const url = '/api/game/list'
      const q = {
        category_id: this.dataMain.category_id,
      }
      this.participants = []
      await this.$axios
        .get(url, { params: q })
        .then((result) => {
          if (result.data.data.length > 0) {
            let num = 1
            this.tournament = result.data.tournament.tournament_name
            this.categoryName = result.data.category.category_name
            let setCurrent = false
            result.data.data.forEach((item) => {
              if (!setCurrent) {
                if (
                  parseInt(item.play_now) === 0 ||
                  parseInt(item.play_now) === 1
                ) {
                  if (item.match_number != null) {
                    this.currentMatch = item.match_number
                    setCurrent = true
                  }
                }
              }
            })
            result.data.data.forEach((item) => {
              if (this.currentMatch === item.match_number) {
                this.participants.push({
                  chart_id: item.id,
                  red_name: item.red_name,
                  red_club: item.red_club,
                  blue_name: item.blue_name,
                  blue_club: item.blue_club,
                  play_now: item.play_now != null ? parseInt(item.play_now) : 0,
                  match: item.match_number,
                  number: num,
                  game: item.game,
                  martial_id: item.martial_id,
                  category_id: item.category_id,
                  tournament_id: item.tournament_id,
                })
                num++
              }
            })
            this.getPlaying()
          }
        })
        .catch(() => {
          this.snackbar = true
          this.color = 'error'
          this.message = 'Error get participant'
        })
    },
    getPlaying() {
      let play = 0
      const last = this.participants[this.participants.length - 1].chart_id
      this.participants.forEach((p) => {
        if (play === 0) {
          if (p.play_now === 1) {
            play = 1
            this.playing = true
            this.gameSaved = false
            this.setPlayer(p)
          } else if (last === p.chart_id) {
            const data = {
              id: null,
              red_name: '',
              red_club: '',
              blue_name: '',
              blue_club: '',
            }
            this.setWaitingList(data)
          }
        }
      })
    },
    setPlayer(data) {
      this.participants.forEach((p) => {
        if (p.chart_id === data.id) {
          p.play_now = 1
        }
      })
      this.redName = data.red_name
      this.redClub = data.red_club
      this.blueName = data.blue_name
      this.blueClub = data.blue_club

      const local = {
        redName: this.redName,
        redClub: this.redClub,
        blueName: this.blueName,
        blueClub: this.blueClub,
        tournament: this.tournament,
        category: this.categoryName,
      }

      localStorage.setItem('fightingPlayer', JSON.stringify(local))
      this.setWaitingList(data)
    },
    setWaitingList(data) {
      let pre = null
      const wait = []
      this.participants.forEach((p) => {
        if (p.chart_id === data.id) {
          p.play_now = 1
        }
      })
      let prepareId = null
      for (let i = 0; i < this.participants.length; i++) {
        if (data.id != null) {
          if (this.participants[i].chart_id === data.id) {
            if (this.participants[i + 1]) {
              pre = {
                redName: this.participants[i + 1]?.red_name,
                redClub: this.participants[i + 1]?.red_club,
                blueName: this.participants[i + 1]?.blue_name,
                blueClub: this.participants[i + 1]?.blue_club,
              }
              prepareId = i + 1
            }
          }
        } else if (prepareId == null && this.participants[i].play_now === 0) {
          pre = {
            redName: this.participants[i].red_name,
            redClub: this.participants[i].red_club,
            blueName: this.participants[i].blue_name,
            blueClub: this.participants[i].blue_club,
          }
          prepareId = i
        }
        if (i !== prepareId && this.participants[i].play_now === 0) {
          wait.push(this.participants[i])
        }
      }
      const local = {
        category: this.category,
        tournament: this.tournament,
        play: {
          redName: data.red_name,
          redClub: data.red_club,
          blueName: data.blue_name,
          blueClub: data.blue_club,
        },
        prepare: pre,
        waiting: wait,
      }
      localStorage.setItem('waitingList', JSON.stringify(local))
    },
    async setPlay(id) {
      const url = '/api/game/play'
      const q = {
        chart_id: id,
        scoring_type: this.scoringType,
      }
      if (this.gameSaved) {
        this.loadingPlay = true
        await this.$axios
          .post(url, q)
          .then((result) => {
            this.tournament = result.data.tournament.tournament_name
            this.category = result.data.category.category_name
            this.setPlayer(result.data.participant)
            this.participants.forEach((p) => {
              if (p.chart_id === id) {
                p.game = result.data.game
              }
            })

            this.playing = true
            this.gameSaved = false
            this.loadingPlay = false
          })
          .catch(() => {
            this.snackbar = true
            this.color = 'error'
            this.message = 'Error get player'
            this.loadingPlay = false
          })
      } else {
        this.snackbar = true
        this.color = 'error'
        this.message = 'Data not save'
      }
    },
    async saveGame(data) {
      this.hideWinner()
      this.hideDis()
      const url = '/api/game/save'
      const redPoint = {
        point: this.redPoints,
        ippong1: this.redIppong1,
        ippong2: this.redIppong2,
        ippong3: this.redIppong3,
        washari: this.redWashari,
      }
      const redFoul = {
        shido: this.redShido,
        chui: this.redChui.length,
      }
      const bluePoint = {
        point: this.bluePoints,
        ippong1: this.blueIppong1,
        ippong2: this.blueIppong2,
        ippong3: this.blueIppong3,
        washari: this.blueWashari,
      }
      const blueFoul = {
        shido: this.blueShido,
        chui: this.blueChui.length,
      }
      const q = {
        chart_id: data.chart_id,
        game_id: data.game.id,
        winner: this.winner,
        disqualified: this.disqualified,
        red_point: JSON.stringify(redPoint),
        red_foul: JSON.stringify(redFoul),
        blue_point: JSON.stringify(bluePoint),
        blue_foul: JSON.stringify(blueFoul),
      }

      if (this.winner !== null || this.disqualified !== null) {
        this.loadingSave = true
        await this.$axios
          .post(url, q)
          .then((result) => {
            this.getParticipant()
            this.redReset()
            this.blueReset()
            this.gameSaved = true
            this.winner = null
            this.disqualified = null
            this.loadingSave = false
          })
          .catch(() => {
            this.snackbar = true
            this.color = 'error'
            this.message = 'Error save game'
            this.loadingSave = false
          })
      } else {
        this.snackbar = true
        this.color = 'error'
        this.message = 'Error Winner Not Set'
      }
    },
    async autoWin(win, data) {
      const url = '/api/game/save'
      const redPoint = {
        point: this.redPoints,
        ippong1: this.redIppong1,
        ippong2: this.redIppong2,
        ippong3: this.redIppong3,
        washari: this.redWashari,
      }
      const redFoul = {
        shido: this.redShido,
        chui: this.redChui.length,
      }
      const bluePoint = {
        point: this.bluePoints,
        ippong1: this.blueIppong1,
        ippong2: this.blueIppong2,
        ippong3: this.blueIppong3,
        washari: this.blueWashari,
      }
      const blueFoul = {
        shido: this.blueShido,
        chui: this.blueChui.length,
      }
      const q = {
        chart_id: data.chart_id,
        game_id: data.game.id,
        winner: win,
        disqualified: null,
        red_point: JSON.stringify(redPoint),
        red_foul: JSON.stringify(redFoul),
        blue_point: JSON.stringify(bluePoint),
        blue_foul: JSON.stringify(blueFoul),
      }

      this.loadingSave = true
      await this.$axios
        .post(url, q)
        .then((result) => {
          this.getParticipant()
          this.redReset()
          this.blueReset()
          this.gameSaved = true
          this.winner = null
          this.disqualified = null
          this.loadingSave = false
        })
        .catch(() => {
          this.snackbar = true
          this.color = 'error'
          this.message = 'Error save game'
          this.loadingSave = false
        })
    },

    async addChart() {
      const q = {
        martial_id: this.dataMain.martial_id,
        category_id: this.dataMain.category_id,
        tournament_id: this.dataMain.tournament_id,
        red_name: this.dataDialogAdd.redName,
        red_club: this.dataDialogAdd.redClub,
        blue_name: this.dataDialogAdd.blueName,
        blue_club: this.dataDialogAdd.blueClub,
        match_number: this.dataDialogAdd.match,
      }
      const url = '/api/game/create'
      this.loadingAdd = true
      await this.$axios
        .post(url, q)
        .then((result) => {
          this.getParticipant()
          this.loadingAdd = false
          this.dialogAdd = false

          this.snackbar = true
          this.color = 'success'
          this.message = 'Success Add Participant'
        })
        .catch(() => {
          this.snackbar = true
          this.color = 'error'
          this.message = 'Error Add Participant'
          this.loadingAdd = false
        })
    },

    editGame(data) {
      this.dialogEdit = true
      this.dataDialogEdit.redName = data.red_name
      this.dataDialogEdit.redClub = data.red_club
      this.dataDialogEdit.blueName = data.blue_name
      this.dataDialogEdit.blueClub = data.blue_club
      this.dataDialogEdit.match = data.match
      this.dataDialogEdit.id = data.chart_id
    },
    async editChart() {
      const q = {
        id: this.dataDialogEdit.id,
        red_name: this.dataDialogEdit.redName,
        red_club: this.dataDialogEdit.redClub,
        blue_name: this.dataDialogEdit.blueName,
        blue_club: this.dataDialogEdit.blueClub,
        match_number: this.dataDialogEdit.match,
      }
      const url = '/api/game/edit'
      this.loadingEdit = true
      await this.$axios
        .post(url, q)
        .then((result) => {
          this.participants.forEach((p) => {
            if (p.chart_id === this.dataDialogEdit.id) {
              p.red_name = this.dataDialogEdit.redName
              p.red_club = this.dataDialogEdit.redClub
              p.blue_name = this.dataDialogEdit.blueName
              p.blue_club = this.dataDialogEdit.blueClub
              p.match = this.dataDialogEdit.match
            }
          })
          this.loadingEdit = false
          this.dialogEdit = false

          this.snackbar = true
          this.color = 'success'
          this.message = 'Success Edit Participant'
        })
        .catch(() => {
          this.snackbar = true
          this.color = 'error'
          this.message = 'Error Edit Participant'
          this.loadingEdit = false
        })
    },

    async deleteChart() {
      const q = {
        id: this.dataDialogDelete,
      }
      const url = '/api/game/delete'
      this.loadingDelete = true
      await this.$axios
        .get(url, { params: q })
        .then((result) => {
          this.getParticipant()
          this.loadingDelete = false
          this.dialogConfirmDelete = false
          this.snackbar = true
          this.color = 'success'
          this.message = 'Success Delete Participant'
        })
        .catch(() => {
          this.snackbar = true
          this.color = 'error'
          this.message = 'Error Delete Participant'
          this.loadingDelete = false
        })
    },

    playSound() {
      let local = localStorage.getItem('dataAdditional')
      if (local != null) {
        local = JSON.parse(local)
        if (parseInt(local.audio) === 2) {
          this.$refs.timesUpAudio2.play()
        } else {
          this.$refs.timesUpAudio.play()
        }
      } else {
        this.$refs.timesUpAudio.play()
      }
    },
  },
}
</script>

<style scoped>
@import '~/assets/styles.css';

.corner {
  width: 545px;
}
.time-corner {
  width: 345px;
}
.red-corner {
  min-width: 100%;
  border: 3px solid #ef233c;
  border-radius: 24px;
}
.blue-corner {
  min-width: 100%;
  border: 3px solid #243c7a;
  border-radius: 24px;
}
.redblue-corner {
  min-width: 100%;
  border-radius: 24px;
  background: linear-gradient(115.41deg, #ef233c, #243c7a);
  padding: 4px;
}
.redblue-corner-inner {
  background-color: #31323b;
  border-radius: 24px;
  height: 100%;
}
.text-score {
  font-size: 80px;
  line-height: 80px;
}
.text-score-small {
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

hr {
  border-top: 0;
  border-left: 0;
  border-right: 0;
  border-radius: 100px;
  width: 130px;
}
.border-blue {
  border: 3px solid #12348d;
}
.border-red {
  border: 3px solid #ef233c;
}
.divider {
  z-index: 10 !important;
}
.main-timer {
  width: 545px;
  border-radius: 20px;
  background: linear-gradient(115.41deg, #ef233c, #243c7a);
  padding: 4px;
}
.main-timer-inner {
  background-color: #31323b;
  border-radius: 20px;
  height: 100%;
}
.text-timer-medic {
  font-size: 50px;
  line-height: 50px;
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

.field-time {
  max-width: 230px;
}

.card-dashboard {
  max-width: 100%;
}
</style>
