<template>
  <div class="form-field">
    <div v-if="showForm">
      <select class="form-control"
              @change="form ? (form[column.bind]  = $event.target.value) : (column.value = $event.target.value)"
              :required="column.required"
              :style="{ width: column.width, height: column.height }"
      >
        <option
            v-if="column.please_select"
            value=""
            v-text="column.please_select_text ? column.please_select_text : ' （選択してください）'"
        ></option>
        <option v-for="n of column.max" :value="n" v-if="n >= column.min"
                :selected="String(n) === String(form ? form[column.bind] : column.value)"
        >
          {{ n }}
        </option>
      </select>
      <parts-form-error :errors="errors" :column="column" />
    </div>
    <div v-else-if="state.current_data.id" class="form-value">
      <div>{{ mFormat(data[column.relation] ? data[column.relation][column.options.val] : '', column.formatter, column.format_options) }}</div>
    </div>
  </div>
</template>

<script>
    export default {
      props: ['column', 'data', 'state', 'errors', 'form', 'search_field'],
      computed: {
        showForm: function () {
          return this.search_field || (this.state.edit_mode && this.column.editable);
        }
      },
      created() {
        let self = this;
        this.column.filter = function (elm) {
          return String(elm[self.column.bind]) === String(self.column.value);
        };
      }
    }
</script>
