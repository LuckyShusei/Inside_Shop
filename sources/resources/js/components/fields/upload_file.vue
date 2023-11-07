<template>
  <div class="form-field">
    <div class="file_thumbnail_loading fa-2x" v-if="file_loading">
      <i class="fas fa-spinner fa-spin"></i>
    </div>
    <template v-if="!!file_thumbnail">
      <img :src="file_thumbnail" class="file_thumbnail" alt="">
      <div class="upload_modify_buttons">
        <p @click="changeFile" v-if="isEdit && !upload_file_mode">
          <i class="fas fa-sync-alt"></i> 変更する
        </p>
        <p @click="removeFile" v-if="isEdit">
          <i class="fas fa-trash-alt"></i> 削除する
        </p>
      </div>
      <ul v-if="isUploadSuccess">
        <li v-for="file in files">{{ file.name }}</li>
      </ul>
    </template>
    <div class="form-value" v-if="!isEdit && state.current_data.id && !form[column.bind]">
      なし
    </div>
    <input v-model="form[column.bind]" type="hidden">
    <div v-show="isEdit && upload_file_mode">
      <div
          class="upload_zone"
          @dragenter="dragEnter"
          @dragleave="dragLeave"
          @dragover.prevent
          @drop.prevent="dropFile"
          :class="{enter: isEnter}"
      >
        ここにファイルをドロップするか、「選択」ボタンを押してファイルを選択してください。
      </div>
      <a class="btn bg-primary" @click.prevent="uploadBtnClick">
        選択
      </a>
    </div>
    <input
        type="file"
        :accept="column.accept" style="display:none;"
        class="input-file"
        ref="uploadBtn"
        @change="uploadInputFile"
    >
    <parts-form-error :errors="errors" :column="column" />
    <div class="progress" v-show="progress">
      <div ref="progress" class="progress-bar bg-primary progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0">
        <span class="sr-only"></span>
      </div>
    </div>
  </div>
</template>

<script>
import $ from 'jquery';

export default {
  props: ['column', 'data', 'state', 'errors', 'form'],
  data() {
    return {
      isEnter: false,
      isUploadSuccess: false,
      upload_file_mode: false,
      file_loading: false,
      file_thumbnail: '',
      progress: 0,
      files: []
    }
  },
  computed: {
      isEdit() {
          return this.state.edit_mode && this.column.editable;
      }
  },
  methods: {
    dragEnter() {
      this.isEnter = true;
    },
    dragLeave() {
      this.isEnter = false;
    },
    removeFile() {
      this.file_thumbnail = null;
      this.$parent.disuse_files.push(this.form[this.column.bind]);
      this.form[this.column.bind] = null;
      this.upload_file_mode = true;
    },
    changeFile() {
      this.$parent.disuse_files.push(this.form[this.column.bind]);
      this.upload_file_mode = true;
    },
    uploadInputFile (e) {
      this.files = [...e.target.files];
      this.uploadData();
    },
    uploadData () {
      self = this;
      self.upload_file_mode = false;
      this.files.forEach(file => {
        let form = new FormData()
        form.append('input_file', file);
        form.append('organization_id', window.mopi.auth.user.organization_id);
        self.progress = true;
        window.axios.post('/api/sys-files/temp', form, { onUploadProgress: self.onUpload })
            .then(({data}) => {
              if (data) {
                self.form[self.column.bind] = data.id;
                self.isUploadSuccess = true;
                self.progress = false;
                self.file_thumbnail = 'data:' + data.mime_type + ';base64,' + data.data;
                self.$parent.reserve_files.push(data.id);
              }
            }).catch(error => {
              self.$parent.disuse_files.push(data.id);
              console.log(error)
        });
      });
    },
    dropFile() {
      this.isEnter = false;
      this.files = [...event.dataTransfer.files];
      this.uploadData();
    },
    onUpload(e) {
      this.$refs.progress.style.width = Math.floor((e.loaded * 100) / e.total) + '%';
    },
    uploadBtnClick(e) {
      this.$refs.uploadBtn.click();
    }
  },
  mounted() {
    this.files = [];
    this.isUploadSuccess = false;
    let file_id = this.form[this.column.bind];
    let self = this;
    if (file_id) {
      this.file_loading = true;
      window.axios.get('/api/sys-files/thumbnail/' + file_id)
          .then(({data}) => {
            self.file_loading = false;
            if (data) {
              self.file_thumbnail = 'data:' + data.mime_type + ';base64,' + data.data;
            }
          });
    } else {
      this.upload_file_mode = true;
    }
  }
};
</script>
