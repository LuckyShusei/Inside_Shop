<template>
    <div class="form-group row">
        <div class="col-sm-10">
            <div class="progress" style="display: none;">
                <div
                    class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['column', 'data', 'state', 'errors', 'form']
}
</script>
