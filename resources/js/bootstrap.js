import 'bootstrap';
import { createApp } from 'vue'

window.createApp = createApp;
import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
