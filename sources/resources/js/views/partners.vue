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
        const resource = 'partners';
        return {
            state: new window.mopi.state('list'),
            masters: new window.mopi.masters(),
            list_options: window.mopi.listOptions({
                name: '一覧',
                resource: resource,
                item_per_page: 0,
                sortable: true,
                default_order: {key: 'sort_order', order: 'asc'},
                search_button: true,
                tools: [
                    { label: '新規', icon: 'fas fa-plus', action: 'addItem' },
                ],
                search: [
                  { label: '名称', bind: 'name,official_name', field_type: 'text', condition: 'like', match: 'left,right', value: null},
                  { label: '有効', bind: 'active_flag',
                    field_type: 'select',
                    options: { rel: 'active_flag' },
                    width: 'auto',
                    please_select: true,
                    please_select_text: 'すべて（無効を含む）',
                    value: 1
                  },
                  { label: 'パートナー種別', bind: 'partner_type',
                    field_type: 'checkbox',
                    options: { rel: 'partner_type' },
                    value: null
                  },
                ],
                columns: [
                  { label: 'ID', bind: 'id', width: '100px', sort_by: 'id'},
                  { label: '名称', bind: 'name', sort_by: 'name', width: '25%'},
                  { label: '正式名称', bind: 'official_name', sort_by: 'official_name' },
                  { label: 'パートナー種別', bind: 'partner_type',
                    field_type: 'checkbox',
                    options: { rel: 'partner_type' },
                    sort_by: 'partner_type',
                    width: '180px'
                  },
                  { label: '更新日', bind: 'updated_at', width: '220px', formatter: 'moment', format_options: ['YYYY年MM月DD日'], sort_by: 'updated_at' },
                  { label: '有効', bind: 'active_flag',
                    column_type: 'toggle',
                    sort_by: 'active_flag',
                    no_click_action: true,
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
                  { label: '正式名称', bind: 'official_name', required: true, editable: true },
                  { label: 'パートナー種別', bind: 'partner_type',
                    field_type: 'checkbox',
                    options: { rel: 'partner_type', label_format: 'id:name'},
                    required: true, editable: true
                  },
                  { label: '有効', bind: 'active_flag',
                    field_type: 'toggle',
                    default: 1,
                    options: { rel: 'active_flag' },
                    required: true, editable: true
                  },
                  {label: '作成日', bind: 'created_at', formatter: 'moment', format_options: ['YYYY年MM月DD日'], editable: false, field_type: 'update_at', no_create: true},
                  {label: '更新日', bind: 'updated_at', formatter: 'moment', format_options: ['YYYY年MM月DD日'], editable: false, field_type: 'update_at', no_create: true},
                ]
            })
        }
    },
};
</script>

<style scoped>

</style>
