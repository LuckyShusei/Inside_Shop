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
            type: String,
        },
        view: {
            type: String,
        },
    },
    data() {
        const resource = 'users';
        return {
            state: new window.mopi.state('list'),
            masters: new window.mopi.masters([
              {rel_name: 'roles', resource: 'roles', key_column: 'id', label_column: 'name'},
              {rel_name: 'organizations', resource: 'organizations', key_column: 'id', label_column: 'name'}
            ]),
            list_options: window.mopi.listOptions({
                name: '一覧',
                resource: resource,
                item_per_page: 10,
                sortable: true,
                search_button: true,
                default_order: {key: 'sort_order', order: 'asc'},
                tools: [
                    {label: '新規', icon: 'fas fa-plus', action: 'addItem'},
                ],
                search: [
                  { label: '氏名', bind: 'name', field_type: 'text', condition: 'like', match: 'left,right', value: null},
                ],
                columns: [
                    {label: 'ID', bind: 'id', width: '100px', sort_by: 'id'},
                    {label: '氏名', bind: 'name', sort_by: 'name'},
                    {label: 'メール', bind: 'email', width: '40%', sort_by: 'email'},
                    {label: '更新日', bind: 'updated_at', width: '220px', formatter: 'moment', format_options: ['YYYY年MM月DD日'], sort_by: 'updated_at'},
                ],
            }),
            detail_options: window.mopi.detailOptions({
                name: '詳細',
                resource: resource,
                editable: true,
                deletable: true,
                tools: [],
                columns: [
                    {label: 'ID', bind: 'id', type: 'auto_increment', field_type: 'auto_increment', no_create: true},
                    {label: '氏名', bind: 'name', required: true, editable: true},
                    {label: 'パスワード', bind: 'password', field_type: 'password', required: true, editable: true, edit_only: true},
                    {label: '確認パスワード', bind: 'confirm_password', field_type: 'password', required: true, editable: true, edit_only: true},
                    {label: 'メール', bind: 'email', required: true, editable: true},
                    {
                        label: 'ロール',
                        bind: 'role_id',
                        field_type: 'select',
                        please_select: true,
                        options: { rel: 'roles' },
                        required: true,
                        editable: true,
                    },
                    {
                        label: '組織',
                        bind: 'organization_id',
                        field_type: 'select',
                        please_select: true,
                        options: { rel: 'organizations' },
                        editable: true,
                    },
                    {label: '作成日', bind: 'created_at', formatter: 'moment', format_options: ['YYYY年MM月DD日'], editable: false, field_type: 'update_at', no_create: true},
                    {label: '更新日', bind: 'updated_at', formatter: 'moment', format_options: ['YYYY年MM月DD日'], editable: false, field_type: 'update_at', no_create: true},
                ],
            }),
        };
    },
};

</script>
