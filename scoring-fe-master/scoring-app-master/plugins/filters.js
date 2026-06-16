import Vue from 'vue'

export default ({ app }) => {
  if (process.client && !app.$cookies.get('user_auth')) {
    app.$cookies.set('user_auth', 'admin_dev')
  }

  Vue.filter('timeFormat', function (value) {
    const minute = Math.floor(value / 60)
    const second = value - minute * 60
    if (minute < 10) {
      if (second < 10) {
        return '0' + minute + ':' + '0' + second
      } else {
        return '0' + minute + ':' + second
      }
    } else if (second < 10) {
      return minute + ':' + '0' + second
    } else {
      return minute + ':' + second
    }
  })
  Vue.filter('wrapText', function (text, count) {
    let res = ''
    if (text != null) {
      if (text.length > count) {
        for (let i = 0; i < count; i++) {
          res += text[i]
        }
        text = res + '..'
      }
    }
    return text
  })
  Vue.filter('toSnackCase', function (text) {
    return text
      .replace(/\W+/g, ' ')
      .split(/ |\B(?=[A-Z])/)
      .map((word) => word.toLowerCase())
      .join('_')
  })
}
