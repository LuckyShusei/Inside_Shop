<template>
  <div class="form-field">
    <div v-if="state.edit_mode && column.editable">
                <textarea class="form-control" v-bind:id="column.bind" v-bind:name="column.bind" v-model="form[column.bind]" v-bind:required="column.required"
                          v-bind:style="{ width: column.width, height: column.height }"
                >
                </textarea>
      <parts-form-error :errors="errors" :column="column" />
    </div>
    <div v-else-if="state.current_data.id" class="form-value">
      <div class="white-space-pre">{{ mFormat(data[column.bind], column.formatter, column.format_options) }}</div>
    </div>
  </div>
</template>

<script>
    export default {
        props: ['column', 'data', 'state', 'errors', 'form']
    }
</script>
