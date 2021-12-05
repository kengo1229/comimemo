<template>
  <div class="container">
    <h3 class="text-center">新作作成</h3>
    <div class="col-sm-10 mx-auto">
      <form class="clearfix" v-on:submit.prevent="createMemo">
        <div class="form-group">
          <label for="memo">メモ</label>
          <textarea id="memo"  class="form-control w-100" rows="15" placeholder="段落ごとに「コミックタイトル+巻数」の形式で入力してください" v-model="memo.comic" required></textarea>
          <span class="text-danger">{{ errMessages.comic }}</span>
        </div>
        <div class="col-sm-6 form-group px-0 float-right clearfix">
          <label for="name" class="d-block">メモ名（20文字以内）</label>
          <input type="text"  id="name" class="form-control w-100 d-inline" placeholder="タイトルを入力してください" v-model="memo.name" required max="20">
          <span class="text-danger">{{ errMessages.name }}</span>
          <button type="submit" class="btn bg-white float-right border mouseover mt-3">作成</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
    data: function() {
        return {
            memo: {},
            errMessages: {}
        }
    },
    methods: {
        createMemo() {
            axios.post('/api/comimemo/memo', this.memo)
                .then((res) => {
                  this.$router.push({name: 'memo.list'});
                })
                .catch(e =>{
                  this.errMessages = e.response.data;
                });
        },
    },
}
</script>
