<template>
  <div class="form-field">
    <div  v-if="state.edit_mode && column.editable">
      <input type="password" class="form-control" v-bind:id="column.bind" v-bind:name="column.bind"
             v-model="form[column.bind]"
             v-bind:required="column.required"
             v-bind:style="{ width: column.width, height: column.height } "
             @focus="$event.target.select()"
      >
      <parts-form-error :errors="errors" :column="column" />
    </div>
  </div>
</template>

<script>
    export default {
        props: ['column', 'data', 'state', 'errors', 'form']
    }
</script>
