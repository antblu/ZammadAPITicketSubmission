import Vue from 'vue'
import App from './App.vue'

Vue.config.productionTip = false

// i18n helpers provided by Nextcloud global (t, n)
Vue.mixin({ methods: { t, n } })

const View = Vue.extend(App)
new View().$mount('#zammadapiticketsubmission')
