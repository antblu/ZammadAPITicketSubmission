import Vue from 'vue'
import App from './App.vue'

Vue.config.productionTip = false

// Make Nextcloud i18n helpers available
Vue.mixin({ methods: { t, n } })

new (Vue.extend(App))().$mount('#zammad-help')
