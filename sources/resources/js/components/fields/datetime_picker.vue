<template>
  <div class="form-field">
    <div v-if="showForm" class="input-group date">
      <datetime
          v-model="date"
          :required="column.required"
          :type="column.picker_type ? column.picker_type : 'date'"
          input-class="form-control"
          zone="Asia/Tokyo"
          auto
          @close="pickerClosed"
      >
      </datetime>
      <parts-form-error :errors="errors" :column="column" />
    </div>
    <div v-else-if="state.current_data.id" class="form-value">
      <div>{{ dateFormat(data[column.bind]) }}</div>
    </div>
  </div>
</template>

<script>
    import {Datetime} from 'vue-datetime';
    import {Settings} from 'luxon'
    import 'vue-datetime/dist/vue-datetime.css'

    Settings.defaultLocale = 'ja'
    let moment = require("moment");
    require("moment-timezone");
    moment.tz.setDefault('Asia/Tokyo');

    function formatDate(originalData, bind) {
        return moment(originalData[bind]).format();
    }

    export default {
        data() {
            return {
                date: formatDate(this.form, this.column.bind)
            }
        },
        components: {
            datetime: Datetime
        },
        methods: {
            dateFormat: function (value) {
                return moment(value).format(this.column.date_format);
            },
            pickerClosed: function () {
              let val = moment(this.date).format('YYYY-MM-DD HH:mm:ss');
                if (this.form) {
                  this.form[this.column.bind] = val;
                } else {
                  this.column.value = val;
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
