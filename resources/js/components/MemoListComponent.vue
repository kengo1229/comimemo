<template>
  <div class="container">
    <div class="row">
      <div class="col-sm-4 mb-4" v-for="memo in memos" :key="memo.id">
        <router-link v-bind:to="{name: 'memo.show', params: {memoId: memo.id}}">
          <div class="card border-0 h-100">
            <div class="card-body mouseover">
              <h5 class="card-title text-center">{{ memo.name }}</h5>
              <div class="card">
                <ul class="list-group list-group-flush" v-for="memo_item in memo.memo_items.slice(0,5)" :key="memo_item.id">
                  <li class="list-group-item  d-flex justify-content-between">{{ memo_item.comic_title.substr(0,12) }}<span>{{ memo_item.comic_number }}巻</span></li>
                </ul>
              </div>
            </div>
          </div>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
    export default {
        data: function () {
            return {
                memos: []
            }
        },
        methods: {
            getMemos() {
                axios.get('/api/comimemo')
                    .then((res) => {
                        this.memos = res.data;
                    });
            }
        },
        mounted() {
            this.getMemos();
        },
    }
</script>
