import Vue from 'vue'
import {
  Loading,
} from 'quasar'


export default {
  get(url, params) {
    Loading.show()
    return Vue.prototype.$axios.get(
      url,
      {
        params: params,
      }
    )
      .then((resp) => {
        if (!resp.data) {
          return null
        }
        return resp.data
      }).catch((err) => {
        console.log(err)
        // show alert
      })
      .finally(() => {
        Loading.hide()
        Vue.prototype.$events.fire('unblock-ui')
      })
  },
  post(url, params) {
    Loading.show()
    return Vue.prototype.$axios.post(
      url, params
    )
      .then((resp) => {
        if (!resp.data) {
          return null
        }
        return resp.data
      }).catch((err) => {
        console.log(err)
        // show alert
      })
      .finally(() => {
        Loading.hide()

        Vue.prototype.$events.fire('unblock-ui')
      })
  },
  delete(url) {
    return Vue.prototype.$axios.delete(url)
      .then((resp) => {
        if (!resp.data) {
          return null
        }
        return resp.data
      }).catch((err) => {
        console.log(err)
        // show alert
      })
      .finally(() => {
        Vue.prototype.$events.fire('unblock-ui')
      })
  }
}
