import VueRouter from 'vue-router';

import HeaderComponent from "./components/HeaderComponent";
import FooterComponent from "./components/FooterComponent";
import MemoListComponent from "./components/MemoListComponent";
import MemoCreateComponent from "./components/MemoCreateComponent";
import MemoShowComponent from "./components/MemoShowComponent";

require('./bootstrap');

window.Vue = require('vue');


Vue.component('header-component', HeaderComponent);
Vue.component('footer-component', FooterComponent);

//vueの中でvuerouterを使えるようにインストール
Vue.use(VueRouter);

const router = new VueRouter({
   mode: 'history',
   routes: [
       {
           path: '/',
           name: 'memo.list',
           component: MemoListComponent
       },
       {
           path: '/memo/create',
           name: 'memo.create',
           component: MemoCreateComponent
       },
       {
           path: '/memo/:memoId',
           name: 'memo.show',
           component: MemoShowComponent,
           props: true
       },
   ]
});
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
/*
vue-routerを宣言
*/


const app = new Vue({
    el: '#app',
    router
});

// footerを最下部に固定
$(function(){
  var $ftr = $('#footer');
  if( window.innerHeight > $ftr.offset().top + $ftr.outerHeight() ){
    $ftr.attr({'style': 'position:fixed; top:' + (window.innerHeight - $ftr.outerHeight()) + 'px;' });
  }
});
