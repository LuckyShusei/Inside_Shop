<template>
    <div class="application">
        <page-header :name="name" />

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
</template>

<script>
    export default {
        props: {
            name: {
                type: String,
            },
            view: {
                type: String,
            },
        },
    }
</script>
