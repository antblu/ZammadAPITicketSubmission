import Vue from 'vue'
import App from './App.vue'

// expose Nextcloud i18n helpers
Vue.mixin({ methods: { t, n } })

new (Vue.extend(App))().$mount('#zammad-help')
