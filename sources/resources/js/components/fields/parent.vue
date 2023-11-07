<template>
    <div class="form-value">
      <div>{{ mFormat(parent.name, column.formatter, column.format_options) }}</div>
    </div>
</template>

<script>
    export default {
      props: ['column', 'data', 'state', 'errors', 'form', 'parent'],
      created() {
        this.form[this.column.bind] = this.parent.id;
      }
    }
</script>
