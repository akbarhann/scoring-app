export const state = () => ({
  redPoints: 0,
  redIppong1: 0,
  redIppong2: 0,
  redIppong3: 0,
  redWashari: 0,
  redShido: 0,
  redChui: 0,
  redMedicTime: 0,

  bluePoints: 0,
  blueIppong1: 0,
  blueIppong2: 0,
  blueIppong3: 0,
  blueWashari: 0,
  blueShido: 0,
  blueChui: 0,
  blueMedicTime: 0,

  mainTime: 0,
  title: 'Tournament Name',
  category: 'Category',
})

export const mutations = {
  setTitle(state, data) {
    state.title = data.title
    state.category = data.category
  },

  setRedPoint(state, point) {
    state.redPoints += point
  },
  setRedIppong1(state, point) {
    state.redIppong1 += point
  },
  setRedIppong2(state, point) {
    state.redIppong2 += point
  },
  setRedIppong3(state, point) {
    state.redIppong3 += point
  },
  setRedWashari(state, point) {
    state.redWashari += point
  },
  setRedShido(state, point) {
    state.redShido += point
  },
  setRedChui(state, point) {
    state.redChui += point
  },

  setBluePoint(state, point) {
    state.bluePoints += point
  },
  setBlueIppong1(state, point) {
    state.blueIppong1 += point
  },
  setBlueIppong2(state, point) {
    state.blueIppong2 += point
  },
  setBlueIppong3(state, point) {
    state.blueIppong3 += point
  },
  setBlueWashari(state, point) {
    state.blueWashari += point
  },
  setBlueShido(state, point) {
    state.blueShido += point
  },
  setBlueChui(state, point) {
    state.blueChui += point
  },

  setTime(state, time) {
    state.mainTime = time
  },
  setStartTime(state, start) {
    state.startTime = start
  },
}

export const actions = {}
