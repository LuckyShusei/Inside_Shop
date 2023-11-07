<template>
    <div class="component">
        <nav class="app-bar">
            <i v-if="!!parent" class="fas fa-angle-left cancel-window" @click="closeWindow"></i>
            <ul class="app-nav">
                <template v-if="options.search_button">
                  <li class="app-nav-item" @click="showSearch">
                    <a class="btn btn-app">
                      <i class="fas fa-search" />
                      検索
                    </a>
                  </li>
                </template>
                <li v-for="tool in options.tools" class="app-nav-item" @click="mAction(tool.action)">
                    <a class="btn btn-app">
                        <i :class="tool.icon" />
                        {{ tool.label }}
                    </a>
                </li>
                <template v-if="options.sortable">
                  <li v-if="!sort_list_mode" class="app-nav-item" @click="sortTable">
                    <a class="btn btn-app">
                      <i class="fas fa-arrows-alt-v"></i>
                      並び替え
                    </a>
                  </li>
                  <li v-if="sort_list_mode" class="app-nav-item" @click="sortTableUpdate">
                    <a class="btn btn-app bg-success">
                      <i class="far fa-save"></i>
                      保存
                    </a>
                  </li>
                </template>
            </ul>
            <i v-if="!!parent" class="far fa-window-close close-window" @click="closeWindow"></i>
        </nav>
        <div class="card card-primary card-outline">
            <div class="card-header">
                {{ options.name }}
            </div>
            <div class="card-body">
                <div class="search-area" :style="{display: options.search_button ? 'none' : false}">
                  <template v-for="column in options.search">
                    <div class="form-group row">
                      <div :class="options.search_label_class ? options.search_label_class : 'col-sm-1 text-sm-right'">
                        <parts-label :column="column" />
                      </div>
                      <div :class="options.search_field_class ? options.search_field_class : 'col-sm-11'">
                        <component
                            :is="column.field_type ? 'field-' + column.field_type : 'field-text'"
                            :column="column"
                            :state="state"
                            :masters="masters"
                            :search_field="true"
                        />
                      </div>
                    </div>
                  </template>
                </div>
                <div v-if="options.item_per_page && options.pagination_top">
                    <parts-pagination :all_pages="all_pages" :current_page="current_page" :changePage="changePage"/>
                </div>
                <div class="table-responsive">
                    <table :class="{'table': true, 'table-hover': true, 'datatable': true, 'component-table': true, 'sort-table': options.sortable }">
                        <thead>
                            <tr>
                                <th
                                    v-for="column in options.columns"
                                    :key="column.id"
                                    :style="column.width ? 'width:' + column.width : ''"
                                    :class="[column.sort_by ? 'sorting' : '', (sort.key && sort.key === column.sort_by) ? (sort.order ? 'asc' : 'desc') : '']"
                                    @click="sortBy(column.sort_by)"
                                >
                                    {{ column.label }}
                                </th>
                            </tr>
                        </thead>
                        <tbody :class="{ 'sorting_list' : sort_list_mode }">
                            <tr v-for="line in showList" :key="line.id" :data-line-id="line.id">
                                <template v-for="column in options.columns">
                                  <td @click="showDetail(line, column.no_click_action)" :style="column.width ? 'width:' + column.width : ''">
                                    <component
                                        :is="column.column_type ? 'column-' + column.column_type : 'column-text'"
                                        :value="columnValue(column, line)"
                                        :column="column"
                                        :line="line"
                                        :state="state"
                                        :masters="masters"
                                    />
                                  </td>
                                </template>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-if="options.item_per_page && options.pagination_bottom">
                  <parts-pagination :all_pages="all_pages" :current_page="current_page" :changePage="changePage"/>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</template>

<script>
    import * as $ from "jquery";
    import '../utilities/asset/jquery.ui.core.min';
    import '../utilities/asset/jquery.ui.widget.min';
    import '../utilities/asset/jquery.ui.mouse.min';
    import '../utilities/asset/jquery.ui.sortable.min';

    export default {
      props: ['options', 'state', 'base_data', 'parent', 'masters'],
        data() {
            return {
                sort: {
                    key: '',
                    order: false
                },
                sort_list_mode: false,
            }
        },
        computed: {
            form: function() {
                return new Form(this.options.bind_form);
            },
            showList: function () {
                let list = this.base_data ? this.base_data : this.options.data;
                if (this.options.search.length) {
                  this.options.search.forEach(function (field) {
                    if (field.value !== null && field.value !== '') {
                      list = list.filter((elm) => field.filter(elm));
                    }
                  });
                }
                if (this.sort.key) {
                    list.sort((a, b) => {
                        a = a[this.sort.key];
                        b = b[this.sort.key];
                        return (a === b ? 0 : a > b ? 1 : -1) * (this.sort.order ? 1 : -1);
                    });
                }
                if (this.options.item_per_page) {
                  return list.slice(this.start, this.end);
                } else {
                  return list;
                }
            },
            all_pages: function () {
                if (this.options.data.length && this.options.item_per_page) {
                    return Math.ceil(this.options.data.length / this.options.item_per_page)
                } else {
                    return 1;
                }
            },
            current_page: function () {
                if (this.state.current_page > this.all_pages) {
                    this.state.setCurrentPage(this.all_pages);
                }
                return this.state.current_page;
            },
            start: function () {
                return ((this.state.current_page - 1) * this.options.item_per_page);
            },
            end: function () {
                return this.start + this.options.item_per_page;
            }
        },
        mounted() {
            this.loadList();
        },
        created() {
          if (!this.parent) {
            this.$root.$refs.content = this;
          }
        },
        methods: {
            find: function (needle, arr) {
                if (arr) {
                   let found = arr.find(x => ((x.key !== '' && x.key !== null) && String(x.key) === String(needle)));
                   if (found) {
                     return found.label;
                   } else {
                     return needle;
                   }
                }
            },
            bitmap: function (needle, arr) {
              if (arr) {
                let ret = '';
                let count = 0;
                for (let i in arr) {
                  let ob = arr[i];
                  if (needle & Math.pow(2, ob.key)) {
                    if (count) {
                      ret += ', ';
                    }
                    ret += ob.label;
                    count++;
                  }
                }
                return ret;
              }
            },
            closeWindow() {
              if (this.parent) {
                this.$parent.state.editMode(false);
                this.$parent.state.setCurrentComponent('list');
              }
            },
            columnValue: function (column, line) {
              if (column.relation) {
                return this.mFormat(line[column.relation] ? line[column.relation][column.options.val] : '', column.formatter, column.format_options);
              } else if (column.field_type === 'checkbox') {
                return this.bitmap(line[column.bind], this.masters.options[column.options.rel]);
              } else if (column.options && column.options.rel) {
                return this.find(line[column.bind], this.masters.options[column.options.rel]);
              } else {
                return this.mFormat(line[column.bind], column.formatter, column.format_options);
              }
            },
            approve: function (id, bind, buttonState) {
              let currentRow = this.options.data.find((d) => String(id) === String(d.id));
              currentRow[bind] = buttonState ? 1 : 0;
              let form = new Form(currentRow);
              this.$store.commit('startLoading');
              this.options.updateData(id, form)
                  .then(() => {
                    this.$store.commit('completeLoading');
                  });
            },
            changePage: function (page) {
                if (page) {
                    this.state.setCurrentPage(page);
                } else {
                    this.state.setCurrentPage(1);
                }
            },
            sortBy: function(key) {
                this.sort.order = this.sort.key === key ? !this.sort.order : false;
                this.sort.key = key;
                this.state.setCurrentPage(1);
            },
            addItem: function () {
                this.state.setCurrentComponent('detail');
                this.state.editMode(true);
                this.state.csvMode(false);
                this.state.setCurrentData(false);
            },
            addCSVItem: function () {
                this.state.setCurrentComponent('detail');
                this.state.editMode(false);
                this.state.csvMode(true);
                this.state.setCurrentData(false);
            },
            showDetail: function (line, no_action_flag) {
              if (!no_action_flag) {
                this.state.setCurrentComponent('detail');
                this.state.editMode(false);
                this.state.csvMode(false);
                this.state.setCurrentData(line);
              }
            },
            remove: function (id) {
                this.form['id'] = id;
                this.form['submit_type'] = {active_flag: 0};
                let _vm = this;
                if (this.options.updateData) {
                    this.$store.commit('startLoading');
                    this.$store.commit('completeLoading');
                    this.options.updateData(id, this.form)
                        .then((data) => {
                            _vm.$router.go(_vm.$router.currentRoute)
                        });
                }
            },
            showSearch: function  () {
              $('.search-area').slideToggle();
            },
            sortTable: function () {
              this.sort_list_mode = true;
              $('.sort-table tbody td').each(function(){
                $(this).width($(this).width());
              });
              $('.sort-table tbody').sortable({
                items: 'tr',
                cursor: 'move'
              });
            },
            sortTableUpdate: function () {
              this.$store.commit('startLoading');
              let id_list = [];
              $('.sorting_list tr').each(function() {
                id_list.push($(this).attr('data-line-id'));
              });
              this.sort_list_mode = false;
              $('.sort-table tbody').sortable('destroy');
              window.axios.put(`/api/${this.options.resource}/updateSort`, {id_list: id_list}).then(() => {
                this.$store.commit('completeLoading');
              });
            },
            loadList: function () {
              if (this.options.default_order && this.options.default_order.key) {
                this.sort.key   = this.options.default_order.key;
                this.sort.order = this.options.default_order.order !== 'desc';
              }
              if (!this.base_data && !this.options.column) {
                this.options.data = [];
                this.$store.commit('startLoading');
                let self = this;
                this.options.getList().then(({data}) => {
                  self.options.data = data;
                  this.$store.commit('completeLoading');
                });
              } else {
                this.options.data = [];
              }
            },
            reload: function () {
                this.loadList();
            }
        }
    }
</script>
