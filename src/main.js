import './assets/index.css'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import Alpine from 'alpinejs'

window.Alpine = Alpine
Alpine.start()

const app = createApp(App)

app.use(router)

app.mount('#app')
