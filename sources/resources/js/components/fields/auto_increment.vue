<template>
  <div class="form-field">
    <div v-if="state.current_data.id" class="form-value">
      <div>{{ mFormat(data[column.bind], column.formatter, column.format_options) }}</div>
    </div>
  </div>
</template>

<script>
    export default {
        props: ['column', 'data', 'state', 'errors', 'form'],
        mounted() {
          if (this.state.current_data.id) {
            this.form[this.column.bind] = this.state.current_data.id;
          }
        },
    }
</script>
