<template>
  <div class="td-inner">
    <div class="file_thumbnail_loading" v-if="file_loading">
      <i class="fas fa-spinner fa-spin"></i>
    </div>
    <template v-if="!!file_thumbnail">
      <img :src="file_thumbnail" class="file_thumbnail" alt="">
    </template>
  </div>
</template>

<script>
export default {
  props: ['column', 'line', 'state', 'masters', 'value'],
  data() {
    return {
      file_loading: false,
      file_thumbnail: '',
    }
  },

  methods: {
    getThumbnail: function (file_id) {
      this.file_loading = true;
      let self = this;
      window.axios.get('/api/sys-files/thumbnail/' + file_id)
          .then(({data}) => {
            self.file_loading = false;
            if (data) {
              self.file_thumbnail = 'data:' + data.mime_type + ';base64,' + data.data;
            }
          });
    }
  },
  watch: {
    value: function(new_id, old_id) {
      this.getThumbnail(new_id);
    }
  },
  mounted() {
    this.getThumbnail(this.value);
  }
}
</script>
