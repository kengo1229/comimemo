<template>
<div>
    <div class="col-sm-4 mx-auto">
        <h3 class="card-title text-center">{{ memo.name }}<i class="fas fa-pen pl-3 mouseover" v-on:click="toggleFormFlg"></i></h3>
        <form class="my-2 rounded clearfix" v-if="formFlg" v-on:submit.prevent="updateMemo">
            <div class="form-group mb-3">
                <label for="name" class="d-block">メモ名変更（20文字以内）</label>
                <input type="text" id="name" class="form-control d-inline" v-model="memo.name" reuqired max="20">
                <span class="text-danger">{{ errMessages.name }}</span>
            </div>
            <button type="submit" class="btn bg-white float-right border mb-3 mouseover">変更</button>
        </form>
    </div>
    <div class="container clearfix">
        <button type="submit" class="float-right" v-on:click="deleteMemo()">メモ削除</button>
    </div>
    <div class="container clearfix mb-5">
        <div class="row">
            <div class="col-sm">
                <div class="card border-0">
                    <form class="my-2" v-on:submit.prevent="createMemoItem">
                        <div class="d-flex align-items-center justify-content-center py-2">
                            <div class="form-group col-6 col-sm-4 px-0 mb-0">
                                <label for="comic_title" class="mb-0 small-font">マンガタイトル（30文字以内）</label>
                                <input type="text" id="comic_title" class="form-control w-100 d-inline"  v-model="secondaryItem.secondaryTitle" required max="30">
                            </div>
                            <div class="col-3 col-sm-2">
                                <label for="comic_number" class="mb-0">巻数</label>
                                <input type="number" id="comic_number" class="form-control  d-inline"   v-model.number="secondaryItem.secondaryNumber" required min="1" max="300">
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn bg-white float-right border mouseover">追加</button>
                            </div>
                        </div>
                        <div class="col-6 mx-auto">
                          <p class="text-danger mb-0">{{ errMessages.secondaryTitle }}</p>
                          <p class="text-danger mb-0">{{ errMessages.secondaryNumber }}</p>
                        </div>
                    </form>
                    <div class="card-body">
                        <div class="card col-sm-10 m-auto pt-2 px-1 px-sm-3">
                          <div class="clearfix">
                            <button class="float-right" v-on:click="toggleEditFlg">編集切替</button>
                          </div>
                          <form class="my-2 my-sm-0" v-on:submit.prevent="updateMemoItem">
                            <draggable v-model="memo.memo_items" handle=".handle" @end="onEnd">
                              <div class="d-flex align-items-center justify-content-around py-1 mb-1 rounded" v-for="item in memo.memo_items" v-bind:class="{'bg-notice': item.is_colored}" :key="item.id">
                                  <i class="fas fa-ellipsis-v handle d-none d-sm-inline"></i>
                                  <div class="form-group form-check d-none d-sm-block">
                                      <input type="checkbox" name="check" class="js-check form-check-input" v-bind:value="item.id" v-model="secondaryMemo.itemId">
                                  </div>
                                  <div class="form-group col-9 col-sm-6 mb-0 px-0">
                                      <input type="text" class="form-control w-100 d-inline px-sm-2" v-model="item.comic_title" v-bind:readonly=readonly required max="30">
                                  </div>
                                  <div class="col-2 col-sm-1 px-0">
                                      <input type="number" class="form-control d-inline px-1 px-sm-2" v-model="item.comic_number" v-bind:readonly=readonly required min="1" max="300">
                                  </div>
                                  <div class="pt-1 d-none d-sm-block">
                                    <button type="submit" class="mr-3"  v-on:click.prevent=" item.is_colored = !item.is_colored">
                                        <i class="fas fa-paint-brush fa-2x mouseover"></i>
                                    </button>
                                    <button type="submit" class="float-right" v-on:click.prevent="deleteMemoItem(item.id)">
                                        <i class="fas fa-trash-alt fa-2x mouseover"></i>
                                    </button>
                                  </div>
                              </div>
                            </draggable>
                            <div class="mt-1 clearfix mt-sm-2">
                                <button type="submit" class="btn bg-white float-right border mouseover" v-bind:disabled="disabled">編集</button>
                            </div>
                          </form>
                            <form class="float-right clearfix d-none d-sm-inline" v-on:submit.prevent="makeMemo">
                                <div class="col-sm-6 form-group mt-2 mt-sm-0 px-0 float-right">
                                    <label for="title" class="d-block">別メモ作成（チェックボックスオン必須）</label>
                                    <input type="text" id="title" class="form-control d-inline" placeholder="20文字以内でタイトルを入力してください" v-model="secondaryMemo.secondaryName">
                                    <span class="text-danger">{{ errMessages.secondaryName }}</span>
                                    <span class="text-danger">{{ errMessage }}</span>
                                    <button type="submit" class="js-submit btn bg-white float-right border mt-3 mouseover">作成</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import draggable from 'vuedraggable'
export default {
    components: {draggable},
    props: {
      // どちらか片方にするとVue warnがでるので両方許容させる
        memoId: [String, Number]
    },
    data: function() {
        return {
            memo: {},
            item: {},
            newItem: {},
            secondaryMemo:{
              secondaryName: '',
              itemId: [],
            },
            secondaryItem:{
              secondaryTitle: '',
              secondaryNumber: '',
            },
            errMessages: {},
            errMessage: '',
            formFlg: false,
            readonly: true,
            disabled: true,
        }
    },
    methods: {
        getMemo() {
            axios.get('/api/comimemo/memo/' + this.memoId)
                .then((res) => {
                    this.memo = res.data,
                    this.item = res.data.memo_items;
                });
        },
        makeMemo() {
          /*
          バック側でバリデーションチェックする前にフロント側で
          チェックボックスが最低1つチェックされていることを確認する
          */
          let arr_checkBoxes = document.getElementsByClassName("js-check");
          let count = 0;
          for (let i = 0; i < arr_checkBoxes.length; i++) {
              if (arr_checkBoxes[i].checked) {
                  count++;
              }
          }
          if (count > 0) {
            this.errMessage = '';
            axios.post('/api/comimemo/memo/make', this.secondaryMemo)
                  .then((res) => {
                     this.$router.push({name: 'memo.list'})
                  })
                  .catch(e =>{
                    this.errMessages = e.response.data;
                  });
          } else {
            this.errMessages = {};
            this.errMessage = 'チェックボックスを1つ以上選択してください';
          };
        },
        updateMemo() {
            axios.put('/api/comimemo/memo/' + this.memoId, this.memo)
                  .then((res) => {
                      this.errMessages = {},
                      this.formFlg = false,
                      this.getMemo();
                  })
                  .catch(e =>{
                    this.errMessages = e.response.data;
                  });
        },
        deleteMemo() {
            axios.delete('/api/comimemo/memo/' + this.memoId)
                .then((res) => {
                    this.$router.push({name: 'memo.list'});
                });

        },
        createMemoItem() {
            axios.post('/api/comimemo/memo/' + this.memoId, this.secondaryItem)
                .then((res) => {
                  this.errMessages = {},
                  this.secondaryItem = {},
                  this.getMemo();
                })
                .catch(e =>{
                  this.errMessages = e.response.data;
                });
        },
        updateMemoItem() {
            axios.put('/api/comimemo/memo/' + this.memoId + '/item', this.item)
                  .then((res) => {
                    this.errMessages = {},
                    this.readonly = true,
                    this.disabled = true,
                    this.getMemo();
                  })
                  .catch(e =>{
                    this.errMessages = e.response.data;
                  });
        },
        deleteMemoItem(id) {
            axios.delete('/api/comimemo/memo/item/' + id)
                .then((res) => {
                    this.getMemo();
                });
        },
        onEnd() {
          /*
          vuedraggableと紐づいているデータをメモ項目が入っている
          オブジェクトに入れる
          これをしないと並び替えがDBに反映されない
          */
          this.item = this.memo.memo_items;
        },
        toggleFormFlg() {
          this.formFlg = !this.formFlg;
        },
        toggleEditFlg() {
          this.readonly = !this.readonly;
          this.disabled = !this.disabled;
        },
    },
    mounted() {
        this.getMemo();
    },
}
</script>
