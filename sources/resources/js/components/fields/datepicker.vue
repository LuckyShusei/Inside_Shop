<template>
  <div class="form-field">
    <div v-if="showForm" class="input-group date">
      <datepicker
          :value="form ? form[column.bind] : column.value"
          @change="form ? form[column.bind]  = $event.target.value : column.value = $event.target.value"
          :required="column.required"
          :format="dateFodrmat"
          :bootstrap-styling="true"
          :language="ja"
          @closed="pickerClosed"
      >
      </datepicker>
      <parts-form-error :errors="errors" :column="column" />
    </div>
    <div v-else-if="state.current_data.id" class="form-value">
      <div>{{ dateFormat(data[column.bind]) }}</div>
    </div>
  </div>
</template>

<script>
    import datepicker from 'vuejs-datepicker';
    import {ja} from 'vuejs-datepicker/dist/locale';
    let moment = require("moment");
    require("moment-timezone");
    moment.tz.setDefault('Asia/Tokyo');

    export default {
        data() {
            return {
                ja: ja
            }
        },
        components: {
            datepicker
        },
        methods: {
            dateFormat: function (value) {
                return moment(value).format(this.column.date_format);
            },
            pickerClosed: function () {
              let d = moment(this.form[this.column.bind]).format('YYYY-MM-DD');
              if (this.form) {
                this.form[this.column.bind] = d;
              } else {
                this.column.value = d;
              }
            }
        },
        computed: {
          showForm: function () {
            return this.search_field || (this.state.edit_mode && this.column.editable);
          }
        },
        created() {
          let self = this;
          this.column.filter = function (elm) {
            return self.dateFormat('YYYY-MM-DD', elm[self.column.bind]) === self.dateFormat('YYYY-MM-DD', self.column.value);
          };
        },
        props: ['column', 'data', 'state', 'errors', 'form', 'search_field']
    }
</script>
