<template>
    <!-- Main content -->
    <div class="component">
      <template v-if="options.tabs && current_id">
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link active" id="tab-for-home" @click.prevent="selectTab('home')">{{ options.name }}</a>
          </li>
          <li v-for="child in options.children" class="nav-item">
            <a class="nav-link" :id="'tab-for-' + child.list_options.column" @click.prevent="selectTab(child.list_options.column)">{{ child.list_options.name }}</a>
          </li>
        </ul>
      </template>
      <div :class="options.tabs ? 'tab-content' : ''">
        <div :class=" options.tabs ? ' tab-pane show active' : '' " id="home-tab">
          <nav class="app-bar">
            <i class="fas fa-angle-left cancel-window" @click="cancelWindow"></i>
            <ul class="app-nav">
              <li class="app-nav-item">
                <a v-if="options.editable && !state.edit_mode" class="btn btn-app" @click.prevent="edit">
                  <i class="fas fa-edit" />編集
                </a>
                <a v-if="options.editable && state.edit_mode" class="btn btn-app" :disabled="form.errors.any()" @click.prevent="alert(
                    submit, edit_modal_subject, edit_modal_message, edit_modal_agree, edit_modal_cancel, edit_modal_use
                   )">
                  <i class="fas fa-save" />保存
                </a>
              </li>
              <li v-if="options.deletable && !state.edit_mode" class="app-nav-item">
                <a class="btn btn-app" @click.prevent="alert(
                    remove, delete_modal_subject, delete_modal_message, delete_modal_agree, delete_modal_cancel, delete_modal_use
                )">
                  <i class="fas fa-trash-alt" />削除
                </a>
              </li>
              <li v-for="tool in options.tools" class="app-nav-item">
                <a class="btn btn-app" @click="mAction(tool.action)">
                  <i :class="tool.icon" />
                  {{ tool.label }}
                </a>
              </li>
            </ul>
            <i class="far fa-window-close close-window" @click="closeWindow"></i>
          </nav>
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">
                    <span v-if="state.edit_mode && !current_id">
                        {{ options.name_new }}
                    </span>
                <span v-else-if="state.edit_mode">
                        {{ options.name_update }}
                    </span>
                <span v-else>
                        {{ options.name }}
                    </span>
              </h3>
            </div>
            <form class="form-horizontal" @keydown="errors && errors.clear()">
              <div class="card-body">
                <template v-for="column in options.columns">
                  <div class="form-group row" v-show="checkRow(column)">
                    <div :class="options.label_class ? options.label_class : 'col-sm-2 text-sm-right'">
                      <parts-label :column="column"/>
                    </div>
                    <div :class="options.field_class ? options.field_class : 'col-sm-9'">
                      <template v-if="column.columns">
                        <div class="field-group">
                          <template v-for="child_column in column.columns">
                            <div v-if="child_column.label" class="inner-label">
                              {{ child_column.label }}
                            </div>
                            <component
                                :is="child_column.field_type ? 'field-' + child_column.field_type : 'field-text'"
                                :column="child_column"
                                :data="data"
                                :form="form"
                                :state="state"
                                :errors="errors"
                                :parent="parent"
                                :masters="masters"
                            />
                          </template>
                        </div>
                      </template>
                      <template v-else>
                        <component
                            :is="column.field_type ? 'field-' + column.field_type : 'field-text'"
                            :column="column"
                            :data="data"
                            :form="form"
                            :state="state"
                            :errors="errors"
                            :parent="parent"
                            :masters="masters"
                        />
                      </template>
                    </div>
                  </div>
                </template>
              </div>
            </form>
          </div>
        </div>
        <template v-for="child in options.children">
          <div :class="options.tabs ? 'tab-pane' : 'no-tab-pane'" :id="child.list_options.column + '-tab'">
            <component-list
                v-if="child.state.current_component === 'list'"
                :options="child.list_options"
                :state="child.state"
                :masters="child.masters"
                :base_data="data[child.list_options.column]"
                :parent="data"
            />
            <component-detail
                v-if="child.state.current_component === 'detail'"
                :options="child.detail_options"
                :list="data[child.list_options.column]"
                :state="child.state"
                :masters="child.masters"
                :parent="data"
            />
          </div>
        </template>
      </div>
    </div>
</template>

<script>

    export default {
        props: ['options', 'list', 'state', 'parent', 'masters'],
        data() {
            return {
                current_id : this.state.current_data.id,
                error: false,
                msg: '',
                reserve_files: [],
                disuse_files: [],
                data: this.state.current_data,
                errors: false,
                edit_modal_subject: this.options.edit_modal_option.subject,
                edit_modal_agree: this.options.edit_modal_option.agree_button,
                edit_modal_cancel: this.options.edit_modal_option.cancel_button,
                edit_modal_use: !this.options.edit_modal_option.use_modal,
                delete_modal_subject: this.options.delete_modal_option.subject,
                delete_modal_agree: this.options.delete_modal_option.agree_button,
                delete_modal_cancel: this.options.delete_modal_option.cancel_button,
                delete_modal_use: !this.options.delete_modal_option.use_modal,
                detailDataLoaded: false
            }
        },
        computed: {
            form: function () {
                let form_columns = {};
                let self = this;
                let callFunc = function (elm) {
                  if (elm.columns) {
                    elm.columns.forEach((elm2) => callFunc(elm2));
                  } else if (elm.editable) {
                    if (self.current_id) {
                      form_columns[elm.bind] = self.data[elm.bind];
                    } else {
                      if (elm.bind !== 'id') {
                        if (elm.default) {
                          form_columns[elm.bind] = elm.default;
                        } else {
                          form_columns[elm.bind] = '';
                        }
                      }
                    }
                  }
                  if (elm.field_type === 'password' && self.data) {
                    form_columns[elm.bind] = '********';
                  }
                };
                this.options.columns.forEach((elm) => callFunc(elm));
                if (!form_columns.organization_id) {
                  form_columns.organization_id = window.mopi.auth.user.organization_id;
                }
                return new Form(form_columns)
            },
            edit_modal_message: function ()
            {
              if (this.options.edit_modal_option.with_name_column
              && this.data[this.options.edit_modal_option.with_name_column]) {
                return this.data[this.options.edit_modal_option.with_name_column] + this.options.edit_modal_option.with_name_message;
              } else {
                return this.options.edit_modal_option.message;
              }
            },
            delete_modal_message: function ()
            {
              if (this.options.delete_modal_option.with_name_column
                  && this.data[this.options.delete_modal_option.with_name_column]) {
                return this.data[this.options.delete_modal_option.with_name_column] + this.options.delete_modal_option.with_name_message;
              } else {
                return this.options.delete_modal_option.message;
              }
            }
        },
        created() {
          if (!this.parent) {
            this.$root.$refs.content = this;
          }
        },

        methods: {
            submit() {
                if (this.current_id) {
                    this.$store.commit('startLoading');
                    this.options.updateData(this.current_id, this.form)
                        .then((data) => {
                            if (this.list) {
                                for (let i in this.list) {
                                    if (this.list[i]['id'] === this.current_id) {
                                        for (let key in this.list[i]) {
                                          this.list[i][key] = data[key];
                                        }
                                    }
                                }
                            }
                            for (let field in this.form) {
                                if (this.form.hasOwnProperty(field)) {
                                    this.data[field] = data[field];
                                }
                            }
                            this.state.editMode(false);
                            this.$store.commit('completeLoading');
                            this.updateFiles();
                        })
                        .catch(() => {
                            this.$store.commit('completeLoading');
                            this.errors = this.form.errors;
                        });
                } else {
                    this.$store.commit('startLoading');
                    this.options.createData(this.form)
                        .then((data) => {
                            if (this.list) {
                                this.list.push(data);
                            }
                            this.$store.commit('completeLoading');
                            this.closeWindow();
                            this.updateFiles();
                        })
                        .catch(() => {
                            this.$store.commit('completeLoading');
                            this.errors = this.form.errors;
                        });
                }
            },
            updateFiles() {
              if (this.reserve_files.length) {
                this.reserve_files.forEach((file) => {
                  window.axios.put('/api/sys-files/register', {id: file});
                });
                this.reserve_files = [];
              }
              if (this.disuse_files.length) {
                this.disuse_files.forEach((file) => {
                  window.axios.delete('/api/sys-files/' + file);
                });
                this.disuse_files = [];
              }
            },
            closeWindow() {
              this.state.editMode(false);
              this.state.setCurrentComponent('list');
            },
            cancelWindow() {
              if (this.state.edit_mode && this.current_id) {
                this.state.editMode(false);
              } else {
                this.state.editMode(false);
                this.state.setCurrentComponent('list');
              }
            },
            checkRow(column) {
              let flag = true;
              if (column.no_create && !this.current_id) {
                flag = false;
              }
              if (column.edit_only && !this.state.edit_mode) {
                flag = false;
              }
              return flag;
            },
            edit() {
                this.state.editMode(true);
            },
            remove() {
              let delete_id = this.current_id.toString();
              if (this.list) {
                for (let i in this.list) {
                  if (this.list[i]['id'].toString() === delete_id) {
                    this.list.splice(i, 1);
                    break;
                  }
                }
              }
              if (this.options.deleteData) {
                this.$store.commit('startLoading');
                this.options.deleteData(delete_id, this.form)
                    .then((data) => {
                      this.$store.commit('completeLoading');
                      this.state.editMode(false);
                      this.state.setCurrentComponent('list');
                    });
              }
            },
            reload() {
                this.closeWindow();
            },
            selectTab(tab_id) {
              $('.nav-link').removeClass('active');
              $('#tab-for-' + tab_id).addClass('active');
              $('.tab-pane').removeClass('active').removeClass('show');
              $('#' + tab_id + '-tab').addClass('active').addClass('show');
            }
        },
        mounted() {
            if (this.options.getData) {
              if (this.state.current_data.id) {
                this.options.getData(this.state.current_data.id)
                    .then(({ data }) => {
                      this.$store.commit('completeLoading');
                      this.data = data
                      this.detailDataLoaded = true;
                    });
              }
            }
        }
    }

</script>
