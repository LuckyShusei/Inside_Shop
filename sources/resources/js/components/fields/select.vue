<template>
  <div class="form-field">
    <div v-if="showForm">
      <select
          @change="form ? (form[column.bind]  = $event.target.value) : (column.value = $event.target.value)"
          class="form-control"
          :required="column.required"
          :style="{ width: column.width, height: column.height }"
      >
        <option
            v-if="column.please_select"
            value=""
            v-text="column.please_select_text ? column.please_select_text : ' （選択してください）'"
        >
        </option>
        <template v-if="masters.loaded">
          <option
              v-for="op in listOptions"
              :value="op.key"
              :selected="String(op.key) === String(form ? form[column.bind] : column.value)"
              v-text="column.options.label_format ? (op.key + ': ' + op.label) : op.label"
          >
          </option>
        </template>
      </select>
      <parts-form-error :errors="errors" :column="column" />
    </div>
    <div v-else-if="state.current_data.id && this.masters.loaded" class="form-value">
      <div>
        {{ mFormat(selectedValue, column.formatter, column.format_options) }}
      </div>
    </div>
  </div>
</template>

<script>
export default {
    props: ['column', 'data', 'state', 'errors', 'form', 'search_field', 'masters'],
    data() {
        return {
        };
    },
    computed: {
      showForm: function () {
        return this.search_field || (this.state.edit_mode && this.column.editable);
      },
      selectedValue: function () {
        if (this.listOptions && this.listOptions.length) {
          let self = this;
          let line = this.listOptions.find((l) => {
           return  String(l.key) === String(self.form[self.column.bind])
          });
          return line.label;
        }
      },
      listOptions: function () {
        return this.masters.options[this.column.options.rel];
      }
    },
    created() {
      let self = this;
      this.column.filter = function (elm) {
        return String(elm[self.column.bind]) === String(self.column.value);
      };
    },
    mounted() {
    },
};
</script>
