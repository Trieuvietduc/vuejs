
import './bootstrap';
import { createApp } from 'vue';
import index from './components/index.vue';
import create from './components/company/create.vue';
import edit from './components/company/edit.vue';
import usercreate from './components/user/create.vue';
import editcreate from './components/user/edit.vue';
import login from './components/login/index.vue';

const app = createApp({});

app.component('index-componnent', index);
app.component('create-componnent', create);
app.component('edit-componnent', edit);
app.component('create-user', usercreate);
app.component('edit-user', editcreate);
app.component('login-component', login);


app.mount('#app');
