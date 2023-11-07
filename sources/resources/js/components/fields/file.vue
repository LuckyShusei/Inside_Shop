<template>
  <div class="form-field">
    <input type="text" class="form-control" v-bind:id="column.bind" v-bind:name="column.bind"
           v-model="form[column.bind]" v-bind:required="column.required"
           v-bind:style="{ width: column.width, height: column.height }"
    >
  </div>
</template>

<script>
    export default {
        props: ['column', 'data', 'state', 'errors', 'form']
    }
</script>
