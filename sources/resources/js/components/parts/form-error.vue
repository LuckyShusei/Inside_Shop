<template>
    <span
        v-if="errors && errors.has(column.bind)"
        class="invalid-feedback d-block"
        role="alert"
        v-text="errors.get(column.bind)"
    />
</template>

<script>
export default {
    props: ['column', 'errors']
}
</script>
