<template>
  <div :class="{'form-label': true, 'has-child' : !!column.columns} ">
    <label
        :for="column.bind"
        class="col-form-label"
    >{{ column.label }}
      <span
          v-if="column.required"
          class="badge badge-primary ml-1"
      >必須</span>
    </label>
  </div>
</template>

<script>
export default {
    props: ['column']
}
</script>
