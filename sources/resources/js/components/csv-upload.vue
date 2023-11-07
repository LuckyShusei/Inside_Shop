<template>
    <!-- Main content -->
    <div class="component">
        <nav class="app-bar">
            <ul class="app-nav">
                <li class="app-nav-item">
                    <a
                        v-if="options.editable && state.edit_mode" class="btn btn-app" :disabled="form.errors.any()"
                        @click.prevent="submit"
                    >
                        <i class="fas fa-save" />
                        保存
                    </a>
                </li>
                <li v-for="tool in options.tools" class="app-nav-item">
                    <a class="btn btn-app" @click="mAction(tool.action)">
                        <i :class="tool.icon" />
                        {{ tool.label }}
                    </a>
                </li>
            </ul>
        </nav>
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <span>
                        {{ options.name_csv }}
                    </span>
                </h3>
            </div>
            <form class="form-horizontal" @keydown="errors && errors.clear()">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">CSVファイルを選択</label>
                        <div class="col-sm-10">
                            <label for="file" class="btn btn-lv-regular">ファイルを選択</label>
                            {{ file.name }}
                            <input
                                id="file" ref="file" type="file"
                                required="required"
                                accept="text/csv,text/tsv" style="visibility:hidden;" @change="selectFile()"
                            >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" />
                        <div class="col-sm-10">
                            <button
                                id="upload-button"
                                class="btn-primary" data-style="expand-right" @click.prevent="submitFile()"
                            >
                                <span>一括登録を実行</span>
                            </button>

                            <div :class="[error ? 'text-danger' : 'text-success']">
                                {{ msg }}
                            </div>
                        </div>
                    </div>
                    <div class="card-header">
                        <div class="row justify-content-between">
                            <div class="col-6">
                                <div
                                    class="d-inline-block" data-tooltip="true" data-placement="top"
                                    title=""
                                    data-original-title="雛形ファイルをダウンロードして編集すれば、簡単に所定の型のCSVデータを作成できます。"
                                >
                                    <span class="align-middle">CSVファイルフォーマット</span>
                                    <i class="fa fa-question-circle fa-lg fa-lg ml-1" />
                                </div>
                            </div>
                            <div class="col-4 text-right">
                                <a :href="['/admin/assets/template/'+options.template_file_csv]">雛形ファイルダウンロード</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover datatable table-bordered">
                            <tbody>
                                <tr v-for="column in options.columns_csv">
                                    <td v-if="column.csv_comment" class="w-25">
                                        {{ column.label }}
                                        <span v-if="column.required" class="badge badge-primary ml-1">必須</span>
                                    </td>
                                    <td v-if="column.csv_comment">
                                        {{ column.csv_comment }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>

    export default {
        props: ['options', 'list', 'state'],
        data() {
            return {
                current_id : this.state.current_data.id,
                error: false,
                msg: '',
                file: '',
                data: this.state.current_data,
                errors: false
            }
        },
        computed: {
          form: function () {
            return new Form({'param': ''});
          },
        },
        created() {
            this.$root.$refs.content = this;
        },
        methods: {
            submit() {
              this.$store.commit('startLoading');
              this.options.createDataFromCSV(this.form)
                  .then((data) => {
                    this.$store.commit('completeLoading');
                    if (this.list) {
                      this.list.push(data);
                    }
                    this.closeWindow();
                  })
                  .catch(() => {
                    this.$store.commit('completeLoading');
                    this.errors = this.form.errors;
                  });
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
            submitFile() {
                if (this.file) {
                    this.$store.commit('startLoading');
                    let formData = new FormData();
                    formData.append('input_file', this.file);
                    this.form['param'] = formData;
                    let _v = this;
                    this.options.createDataFromCSV(this.form)
                        .then(value => {
                            this.$store.commit('completeLoading');
                            this.state.editMode(false);
                            this.error = false;
                            this.msg = 'ファイルを正常にアップロード';
                            _v.file = '';
                        })
                        .catch(reason => {
                            this.$store.commit('completeLoading');
                            this.error = true;
                            this.msg = 'CSVのフォーマットが一致しません';
                            _v.file = '';
                        });
                }
            },
            selectFile() {
                this.file = this.$refs.file.files[0];
            },
            reload() {
                this.closeWindow();
            }

        },
        mounted() {
        }
    }

</script>
