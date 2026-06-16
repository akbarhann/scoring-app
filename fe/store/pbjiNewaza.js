export const state = () => ({
  redPoints: 0,
  redAdvantages: 0,
  redFouls: 0,

  bluePoints: 0,
  blueAdvantages: 0,
  blueFouls: 0,

  mainTime: 0,
  timeStart: false,
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
  setRedAdvantages(state, adv) {
    state.redAdvantages += adv
  },
  setRedFoul(state, foul) {
    state.redFouls += foul
  },
  setBluePoint(state, point) {
    state.bluePoints += point
  },
  setBlueAdvantages(state, adv) {
    state.blueAdvantages += adv
  },
  setBlueFoul(state, foul) {
    state.blueFouls += foul
  },
  setTime(state, time) {
    state.mainTime = time
  },
  setStartTime(state, start) {
    state.startTime = start
  },
}

export const actions = {}
