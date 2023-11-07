<template>
    <toggle-button
        :value="!!line[column.bind]"
        :sync="true"
        :name="column.bind + '__' + line.id"
        @change="approve(line.id, column.bind, $event.value)"
    ></toggle-button>
</template>

<script>
export default {
  props: ['column', 'line', 'state', 'masters', 'value'],
  methods: {
    approve: function (id, bind, buttonState) {
      this.$parent.approve(id, bind, buttonState);
    }
  }
}
</script>
