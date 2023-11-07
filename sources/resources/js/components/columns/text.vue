<template>
  <div class="td-inner">
    {{ value }}
  </div>
</template>

<script>
    export default {
      props: ['column', 'line', 'state', 'masters', 'value', 'columnValue'],
    }
</script>
