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
        const resource = 'projects';
        return {
            state: new window.mopi.state('list'),
            masters: new window.mopi.masters([
              {rel_name: 'partners', resource: 'partners', key_column: 'id', label_column: 'name',
                filter: [
                  {column: 'partner_type', and: Math.pow(2, 1)}
                ]},
              {rel_name: 'users', resource: 'users', key_column: 'id', label_column: 'name'}
            ]),
            list_options: window.mopi.listOptions({
                name: '一覧',
                resource: resource,
                item_per_page: 10,
                default_order: {key: 'end_date', order: 'desc'},
                search_button: true,
                search_label_class: 'col-sm-2 text-sm-right',
                search_field_class: 'col-sm-10',
                search: [
                  { label: '名称', bind: 'name', field_type: 'text', condition: 'like', match: 'left,right', value: null},
                  { label: '有効', bind: 'active_flag',
                    field_type: 'select',
                    options: { rel: 'active_flag' },
                    width: 'auto',
                    please_select: true,
                    please_select_text: 'すべて（無効を含む）',
                    value: 1
                  },
                  { label: 'クライアント', bind: 'client',
                    field_type: 'select',
                    please_select: true,
                    please_select_text: '（すべて）',
                    options: { rel: 'partners' },
                    sort_by: 'client',
                    value: null
                  },
                  {
                    label: 'プロジェクト種別', bind: 'project_type',
                    field_type: 'select',
                    please_select: true,
                    please_select_text: '（すべて）',
                    options: {rel: 'project_type', label_format: 'id:name'},
                    value: null
                  },
                  { label: '状態', bind: 'status',
                    field_type: 'select',
                    please_select: true,
                    please_select_text: '（すべて）',
                    options: { rel: 'project_status' },
                    value: null
                  },
                ],
                tools: [
                    { label: '新規', icon: 'fas fa-plus', action: 'addItem' }
                ],
                columns: [
                  { label: 'ID', bind: 'id', width: '100px', sort_by: 'id'},
                  { label: 'イメージ', bind: 'image', width: '160px', column_type: 'thumbnail'},
                  { label: '名称', bind: 'name', sort_by: 'name', width: '25%'},
                  { label: 'クライアント', bind: 'client',
                    options: { rel: 'partners' },
                    sort_by: 'client',
                    width: '180px'
                  },
                  { label: 'プロジェクト種別', bind: 'project_type',
                    options: { rel: 'project_type' },
                    sort_by: 'project_type',
                    width: '180px'
                  },
                  { label: '状態', bind: 'status',
                    options: { rel: 'project_status' },
                    sort_by: 'project_status',
                    width: '140px'
                  },
                  { label: '更新日', bind: 'updated_at', width: '220px', formatter: 'moment', format_options: ['YYYY年MM月DD日'], sort_by: 'updated_at' },
                  { label: '有効', bind: 'active_flag',
                    column_type: 'toggle',
                    no_click_action: true,
                    sort_by: 'active_flag',
                    width: '140px'
                  }
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
                  { label: '名称', bind: 'name', required: true, editable: true },
                  { label: 'プロジェクト種別', bind: 'project_type',
                    field_type: 'select',
                    please_select: true,
                    options: { rel: 'project_type', label_format: 'id:name'},
                    required: true, editable: true
                  },
                  {
                    label: 'イメージ画像',
                    bind: 'image',
                    editable: true,
                    field_type: 'upload_file',
                    file_option: {use: 'sys-file'},
                    accept: 'image/*'
                  },
                  { label: 'クライアント', bind: 'client',
                    field_type: 'select',
                    please_select: true,
                    options: { rel: 'partners', label_format: 'id:name' },
                    required: false, editable: true
                  },
                  { label: 'マネージャ', bind: 'manager',
                    field_type: 'select',
                    please_select: true,
                    options: { rel: 'users', label_format: 'id:name'},
                    required: false, editable: true
                  },
                  { label: '詳細', bind: 'detail',
                    field_type: 'textarea',
                    height: '5em',
                    required: false, editable: true
                  },
                  { label: '状態', bind: 'status',
                    field_type: 'select',
                    please_select: true,
                    default: 1,
                    options: { rel: 'project_status' },
                    required: true, editable: true
                  },
                  {
                    label: '開始日', bind: 'start_date', required: false, editable: true, field_type: 'datetime_picker', picker_type: 'date', date_format: 'YYYY年MM月DD日',
                  },
                  {
                    label: '終了日', bind: 'end_date', required: false, editable: true, field_type: 'datetime_picker', picker_type: 'date', date_format: 'YYYY年MM月DD日',
                  },
                  { label: '有効', bind: 'active_flag',
                    field_type: 'toggle',
                    default: 1,
                    options: { rel: 'active_flag' },
                    required: true, editable: true
                  },
                  {label: '作成日', bind: 'created_at', formatter: 'moment', format_options: ['YYYY年MM月DD日'], editable: false, field_type: 'update_at', no_create: true},
                  {label: '更新日', bind: 'updated_at', formatter: 'moment', format_options: ['YYYY年MM月DD日'], editable: false, field_type: 'update_at', no_create: true},
                ],
              tabs: true,
              children: [{
                state: new window.mopi.state('list'),
                masters: new window.mopi.masters([
                  {rel_name: 'users', resource: 'users', key_column: 'id', label_column: 'name'}
                ]),
                list_options: window.mopi.listOptions({
                  name: '案件',
                  column: 'items',
                  resource: 'items',
                  item_per_page: 10,
                  tools: [
                    { label: '新規', icon: 'fas fa-plus', action: 'addItem' },
                  ],
                  columns: [
                    {
                      label: 'ID', bind: 'id', width: '100px', sort_by: 'id',
                    },
                    { label: '名称', bind: 'name', sort_by: 'name' },
                    { label: '案件種別', bind: 'item_type',
                      options: { rel: 'item_type' },
                      sort_by: 'item_type',
                      width: '180px'
                    },
                    { label: '状態', bind: 'status',
                      options: { rel: 'project_status' },
                      sort_by: 'project_status',
                      width: '140px'
                    },
                    { label: '開始日', bind: 'start_date', width: '220px', formatter: 'moment', format_options: ['YYYY年MM月DD日'], sort_by: 'start_date' },
                    { label: '終了日', bind: 'end_date', width: '220px', formatter: 'moment', format_options: ['YYYY年MM月DD日'], sort_by: 'end_date' },
                    {
                      label: '更新日', bind: 'updated_at', width: '220px', formatter: 'moment', format_options: ['YYYY年MM月DD日'], sort_by: 'updated_at',
                    },
                    { label: '有効', bind: 'active_flag',
                      field_type: 'toggle',
                      sort_by: 'active_flag',
                      width: '140px'
                    }
                  ],
                }),
                detail_options: window.mopi.detailOptions({
                  name: '詳細',
                  resource: 'items',
                  editable: true,
                  deletable: true,
                  columns: [
                    {label: 'ID', bind: 'id', type: 'auto_increment', field_type: 'auto_increment', no_create: true},
                    { label: 'プロジェクト', bind: 'project_id',
                      field_type: 'parent',
                      required: true, editable: true,
                    },
                    {label: '名称', bind: 'name', required: true, editable: true},
                    {
                      label: '案件種別', bind: 'item_type',
                      field_type: 'select',
                      please_select: true,
                      options: {rel: 'item_type', label_format: 'id:name'},
                      required: true, editable: true
                    },
                    {
                      label: 'マネージャ', bind: 'manager',
                      field_type: 'select',
                      please_select: true,
                      options: { rel: 'users', label_format: 'id:name'},
                      required: false, editable: true
                    },
                    {
                      label: '詳細', bind: 'detail',
                      field_type: 'textarea',
                      height: '5em',
                      required: false, editable: true
                    },
                    {
                      label: '状態', bind: 'status',
                      field_type: 'select',
                      please_select: true,
                      default: 1,
                      options: {rel: 'project_status' },
                      required: true, editable: true
                    },
                    {
                      label: '開始日',
                      bind: 'start_date',
                      required: false,
                      editable: true,
                      field_type: 'datetime_picker',
                      picker_type: 'date',
                      date_format: 'YYYY年MM月DD日',
                    },
                    {
                      label: '終了日',
                      bind: 'end_date',
                      required: false,
                      editable: true,
                      field_type: 'datetime_picker',
                      picker_type: 'date',
                      date_format: 'YYYY年MM月DD日',
                    },
                    {
                      label: '有効', bind: 'active_flag',
                      field_type: 'toggle',
                      default: 1,
                      options: {rel: 'active_flag' },
                      required: true, editable: true
                    },
                    {label: '作成日', bind: 'created_at', formatter: 'moment', format_options: ['YYYY年MM月DD日'], editable: false, field_type: 'update_at', no_create: true},
                    {label: '更新日', bind: 'updated_at', formatter: 'moment', format_options: ['YYYY年MM月DD日'], editable: false, field_type: 'update_at', no_create: true},
                  ],
                })
              }]
            }),
        };
    }
};
</script>

<style scoped>

</style>
