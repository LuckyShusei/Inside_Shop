<template>
  <div class="form-field">
    <div v-if="showForm">
      <div class="field-checkbox">
        <input type="text"
               :required="column.required"
               :value="checked_value_computed"
               v-show="false"
        >
        <template v-if="masters.loaded">
          <template v-for="(op, idx) in listOptions">
            <div class="form-check d-inline" style="margin-right: 30px">
              <label :for="column.bind + '__' + idx">
                <input type="checkbox"
                       class="form-check-input"
                       :id="column.bind + '__' + idx"
                       :value="op.key"
                       v-model="checked_value"
                >
                {{ op.label }}
              </label>
            </div>
          </template>
        </template>
      </div>
      <parts-form-error :errors="errors" :column="column" />
    </div>
    <div v-else-if="masters.loaded && state.current_data.id" class="form-value">
      <div>
        <template v-for="(op, idx) in checkedList">
          <span v-if="idx">, </span>
          {{ mFormat(op.label, column.formatter, column.format_options) }}
        </template>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    props: ['column', 'data', 'state', 'errors', 'form', 'search_field', 'masters'],
    data() {
        return {
            listOptions: [],
            checked_value: []
        };
    },
    computed: {
      showForm: function () {
        return this.search_field || (this.state.edit_mode && this.column.editable);
      },
      checked_value_computed: function () {
        let ret = 0;
        for (let i in this.checked_value) {
          ret += Math.pow(2, this.checked_value[i]);
        }
        if (ret) {
          if (this.form) {
            this.form[this.column.bind] = ret;
          } else {
            this.column.value = ret;
          }
        } else {
          if (this.form) {
            this.form[this.column.bind] = null;
          } else {
            this.column.value = null;
          }
        }
        return ret;
      },
      checkedList: function () {
        let list = [];
        for (let op in this.listOptions) {
          if ((this.form ? this.form[this.column.bind] : this.column.value) & Math.pow(2, this.listOptions[op].key)) {
            list.push(this.listOptions[op]);
          }
        }
        return list;
      }
    },
    mounted() {
      const self = this;
      self.listOptions = self.masters.options[self.column.options.rel];
      if (self.listOptions) {
        for (let op in self.listOptions) {
          if ((this.form ? this.form[this.column.bind] : this.column.value) & Math.pow(2, self.listOptions[op].key)) {
            this.checked_value.push(self.listOptions[op].key);
          }
        }
      }
    },
    created() {
      let self = this;
      this.column.filter = function (elm) {
        if (self.column.value) {
          return elm[self.column.bind] & self.column.value;
        } else {
          return true;
        }
      };
    }
};
</script>
