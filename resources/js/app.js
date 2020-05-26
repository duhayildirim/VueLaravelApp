require('./bootstrap');
window.Vue = require('vue');
// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

import App from './components/App.vue';
import router from './router/index.js';

const app = new Vue({
    el: '#app',
    template: '<App/>',
    components: { App },
    router : router
});

// new Vue({
//     render: h => h(App),
// }).$mount('#app') şeklinde kullanabilrim yada üsteki gibi
