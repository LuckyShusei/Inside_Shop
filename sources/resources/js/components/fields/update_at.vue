<template>
  <div class="form-field">
    <div class="form-value">
      {{ mFormat(data[column.bind], column.formatter, column.format_options) }}
    </div>
  </div>
</template>

<script>
    export default {
        props: ['column', 'data', 'state', 'errors', 'form']
    }
</script>
