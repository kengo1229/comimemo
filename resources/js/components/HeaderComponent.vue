<template>
  <header>
    <div class="w-100 clearfix">
      <nav class="float-right pt-3 pr-2">
        <router-link v-bind:to="{name: 'memo.list'}">ホーム</router-link>
        <router-link v-bind:to="{name: 'memo.create'}">新規作成</router-link>
      </nav>
    </div>
    <h1 class="pb-3 text-center title-font">
      <router-link v-bind:to="{name: 'memo.list'}">コミメモ</router-link>
    </h1>
  </header>
</template>
