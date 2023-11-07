<template>
  <div class="form-field">
    <div v-if="showForm">
      <input type="text"
             class="form-control"
             :value="form ? form[column.bind] : column.value"
             @input="form ? form[column.bind]  = $event.target.value : column.value = $event.target.value"
             :required="column.required"
             :style="{ width: column.width, height: column.height }"
      >
      <parts-form-error :errors="errors" :column="column" />
    </div>
    <div v-else-if="state.current_data.id" class="form-value">
      <div>{{ mFormat(data[column.bind], column.formatter, column.format_options) }}</div>
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
          let flag = false;
          if (self.column.value) {
            let search_value = self.toSearchText(self.column.value);
            if (self.column.condition === 'like') {
              if (self.column.match === 'left') {
                search_value = '^' + search_value;
              } else if (self.column.match === 'right') {
                search_value = search_value + '$';
              }
            } else {
              search_value = '^' + search_value + '$';
            }
            let search_keys = self.column.bind.split(',');
            search_keys.forEach(function (search_key) {
              let sk = self.toSearchText(elm[search_key]);
              if (sk.match(new RegExp(search_value, "gi"))) {
                flag = true;
              }
            })
          } else {
            flag = true;
          }
          return flag;
        };
      }
    }

</script>
