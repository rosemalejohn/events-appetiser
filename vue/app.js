import Vue from 'vue'
import App from './App.vue'
import store from './store'

// Load application plugins
import './plugins'

Vue.config.productionTip = false

new Vue({
  el: '#app',
  store,
  render: (h) => h(App),
})
