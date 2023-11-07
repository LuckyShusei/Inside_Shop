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
        default: '',
      },
    },

    data() {
        const resource = 'organizations';
        return {
            state: new window.mopi.state('list'),
            masters: new window.mopi.masters(),
            list_options: window.mopi.listOptions({
                name: '一覧',
                resource: resource,
                item_per_page: 10,
                sortable: true,
                search_button: true,
                default_order: {key: 'sort_order', order: 'asc'},
                tools: [
                    { label: '新規', icon: 'fas fa-plus', action: 'addItem' },
                ],
                search: [
                  { label: '名称', bind: 'name', field_type: 'text', condition: 'like', match: 'left,right', value: null},
                  { label: '有効', bind: 'active_flag',
                    field_type: 'select',
                    options: { rel: 'active_flag', key: 'id', val: 'name' },
                    width: 'auto',
                    please_select: true,
                    please_select_text: 'すべて（無効を含む）',
                    value: 1
                  },
                ],
                columns: [
                    {label: 'ID', bind: 'id', width: '100px', sort_by: 'id'},
                    {label: '名称', bind: 'name', sort_by: 'name'},
                    {label: '有効', bind: 'active_flag',
                      options: { rel: 'active_flag', key: 'id', val: 'name' },
                      sort_by: 'active_flag', width: '140px'},
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
                    {label: '名称', bind: 'name', required: true, editable: true},
                    {
                      label: 'ロゴ画像',
                      bind: 'logo_image',
                      editable: true,
                      field_type: 'upload_file',
                      file_option: {use: 'sys-file'},
                      accept: 'image/*'
                    },
                    {label: '組織メール（from）', bind: 'information_mail_from', required: true, editable: true},
                    {label: '組織メール（to）', bind: 'information_mail_to', required: true, editable: true},
                    { label: '有効', bind: 'active_flag',
                      field_type: 'toggle',
                      default: 1,
                      options: { rel: 'active_flag', key: 'id', val: 'name' },
                      required: true, editable: true
                    },
                    {label: '作成日', bind: 'created_at', formatter: 'moment', format_options: ['YYYY年MM月DD日'], editable: false, field_type: 'update_at', no_create: true},
                    {label: '更新日', bind: 'updated_at', formatter: 'moment', format_options: ['YYYY年MM月DD日'], editable: false, field_type: 'update_at', no_create: true},
                ],
            }),
        };
    },
};

</script>
