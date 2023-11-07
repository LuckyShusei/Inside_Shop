<template>
  <div class="form-field">
    <div v-if="state.edit_mode && column.editable && mounted_mode">
      <toggle-button
          :value="value"
          @change="changeValue($event.value)"
      />
      <input type="text" class="form-control"
             :id="column.bind" :name="column.bind" :required="column.required"
             :value="value_computed"
             v-show="false"
      >
      <parts-form-error :errors="errors" :column="column" />
    </div>
    <div v-else-if="masters.loaded && state.current_data.id" class="form-value">
      <template v-for="op in listOptions">
        <template v-if="String(op.key) === String(form[column.bind])">
          {{ mFormat(op.label, column.formatter, column.format_options) }}
        </template>
      </template>
    </div>
  </div>
</template>

<script>
export default {
    props: ['column', 'data', 'state', 'errors', 'form', 'masters'],
    data() {
        return {
            value: false,
            mounted_mode: false,
        };
    },
    computed: {
      value_computed: function () {
        return this.value ? 1 : 0;
      },
      listOptions: function () {
        return this.masters.options[this.column.options.rel];
      }
    },
    methods: {
      changeValue: function (buttonState) {
        this.form[this.column.bind] = buttonState ? 1 : 0;
        this.value = buttonState;
      }
    },
    mounted() {
        this.value = Boolean(this.form[this.column.bind]);
        this.mounted_mode = true;
    },
};
</script>
