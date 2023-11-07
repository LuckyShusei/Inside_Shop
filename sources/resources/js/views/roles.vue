<template>
  <div class="application">
    <page-header :name="name" />

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <component-list
            v-show="state.current_component === 'list'"
            :options="list_options"
            :state="state"
            :masters="masters"
            :base_data="false"
        />
        <component-detail
            v-if="state.current_component === 'detail'"
            :options="detail_options"
            :list="list_options.data"
            :state="state"
            :masters="masters"
            :base_data="false"
        />
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
            type: String
        }
    },

    data() {
        const resource = 'roles';
        return {
            state: new window.mopi.state('list'),
            masters: new window.mopi.masters([
                  {rel_name: 'privileges', resource: 'privileges', key_column: 'id', label_column: 'name'}
            ]
            ),
            list_options: window.mopi.listOptions({
                name: '一覧',
                resource: resource,
                item_per_page: 0,
                sortable: true,
                default_order: {key: 'sort_order', order: 'asc'},
                tools: [
                    { label: '新規', icon: 'fas fa-plus', action: 'addItem' },
                ],
                columns: [
                    {label: 'ID', bind: 'id', width: '100px', sort_by: 'id'},
                    {label: '名称', bind: 'name', sort_by: 'name'}
                ],
            }),
            detail_options: window.mopi.detailOptions({
                name: '詳細',
                resource: resource,
                editable: true,
                deletable: true,
                tools: [
                ],
                columns: [
                    {label: 'ID', bind: 'id', type: 'auto_increment', field_type: 'auto_increment', no_create: true},
                    {label: '名称', bind: 'name', required: true, editable: true},
                    {label: '権限', bind: 'privileges', field_type: 'multiselect',
                      options: {rel: 'privileges', key_column: 'id', label_column: 'name'},
                      required: true, editable: true}
                ],
            }),
        };
    },
};

</script>
