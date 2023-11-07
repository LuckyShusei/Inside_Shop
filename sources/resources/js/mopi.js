require('./bootstrap');
import axios from 'axios';
import Settings from '../setting/setting.json';
import Vue from "vue";
import Vuex from "vuex";
import Form from "./utilities/Form";
import VueRouter from "vue-router";
import ToggleButton from "vue-js-toggle-button";
import Multiselect from 'vue-multiselect'
import "vue-multiselect/dist/vue-multiselect.min.css";
const moment = require('moment');
require('moment-timezone');

window.Form = Form;
window.options = require('../setting/setting.json').options;
window.Vue = Vue;
window.axios = axios;

const { masters } = Settings;

Vue.use(VueRouter);
Vue.use(Vuex);
Vue.use(ToggleButton)


function Mopi() {
    const self = this;

    this.init = function (options) {
        const components = options.components
        if (components) {
            components.forEach((c) => Vue.component('component-' + c, require('./components/' + c).default))
        }
        const fields = options.fields
        if (fields) {
            fields.forEach((f) => Vue.component('field-' + f, require('./components/fields/' + f).default));
        }
        const columns = options.columns
        if (columns) {
            columns.forEach((c) => Vue.component('column-' + c, require('./components/columns/' + c).default));
        }
        Vue.component('page-header', require('./components/parts/page-header').default);
        Vue.component('progress-bar', require('./components/parts/progress-bar').default);
        Vue.component('menu-bar', require('./components/parts/menu-bar').default);
        Vue.component('parts-label', require('./components/parts/label').default);
        Vue.component('parts-form-error', require('./components/parts/form-error').default);
        Vue.component('parts-pagination', require('./components/parts/pagination').default);
        Vue.component(
            'passport-clients',
            require('./components/passport/Clients.vue').default,
        );
        Vue.component(
            'passport-authorized-clients',
            require('./components/passport/AuthorizedClients.vue').default,
        );
        Vue.component(
            'passport-personal-access-tokens',
            require('./components/passport/PersonalAccessTokens.vue').default,
        );
        Vue.component('multiselect', Multiselect);

        Vue.mixin({
            computed: {
                appLoading() {
                    return this.$store.state.loading;
                },
            },
            methods: {
                mFormat(value, formatter, options) {
                    if (!formatter) {
                        return value;
                    }
                    return window.mopi.format[formatter](value, options);
                },
                mAction(command) {
                    this[command]();
                },
                alert(func, subject, message, agree, cancel, only_func) {
                    if (!only_func) {
                        const $Alert = $('#__mopi_alert');

                        $('.subject', $Alert).html(subject);
                        $('.message', $Alert).html(message);
                        $('.agree', $Alert).html(agree ? agree : 'はい');
                        $('.cancel', $Alert).html(cancel ? cancel : 'キャンセル');

                        $Alert.modal('show');
                        $('.func', $Alert).off('click');
                        $('.func', $Alert).on('click', function(){
                            func();
                            $Alert.modal('hide');
                        });
                    } else {
                        func();
                    }
                },
                toSearchText: function (text) {
                    return text.replace(/[Ａ-Ｚａ-ｚ０-９｀～！＠＃＄％＾＆＊（）＿＋－＝［］＼；＇，／｛｝｜：＂＜＞？]/g, function (s) {
                        return String.fromCharCode(s.charCodeAt(0) - 65248);
                    }).replace(/　/g, ' ')
                    .replace(/−/g, '-')
                    .replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                },
            },
        });
    };
    this.store = new Vuex.Store({
        state: {
            loading: false,
        },
        mutations: {
            startLoading(state) {
                state.loading = true;
            },
            completeLoading(state) {
                state.loading = false;
            },
        },
    });
    this.format = {
        moment(value, options) {
            if (!value) {
                return '';
            }
            moment.tz.setDefault('Asia/Tokyo');
            const date = moment(value);
            return date.format(options[0]);
        },
        currency(value) {
            return new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(value);
        },
    };
    this.state = function (currentComponentName, loadList) {
        this.current_component = currentComponentName;
        this.edit_mode = false;
        this.csv_mode = false;
        this.current_id = false;
        this.current_data = {};
        this.current_page = 1;
        this.setCurrentComponent = (name) => this.current_component = name;
        this.editMode = (flag) => this.edit_mode = flag;
        this.csvMode = (flag) => this.csv_mode = flag;
        this.setCurrentId = (id) => this.current_id = id;
        this.setCurrentData = (data) => this.current_data = data;
        this.setCurrentPage = (page) => this.current_page = page;
        return this;
    };
    this.masters = function (loadList, localList) {
        this.loaded = false;
        this.options = {};
        this.basic   = self.basicMaster;
        let _t = this;
        for (let o in window.options) {
            _t.options[String(o)] = window.options[o];
        }
        if (localList) {
            for (let l in localList) {
                _t.options[String(l)] = localList[l];
            }
        }
        if (loadList) {
            _t.counter = 0;
            loadList.forEach((res) => {
                let name = !res.resource ? res.rel_name : res.resource;
                self.getResourceList(res.resource, res.filter).then(({data}) => {
                    let arr = [];
                    data.forEach ((d) => {
                        arr.push({key: d[res.key_column], label: d[res.label_column]});
                    });
                    _t.options[String(name)] = arr;
                    _t.counter++;
                    if (_t.counter >= loadList.length) {
                        _t.loaded = true;
                    }
                });
            });
        } else {
            _t.loaded = true;
        }
        return this;
    };
    this.template_list_options = {
        name: '一覧',
        resource: '',
        item_per_page: 10,
        pagination_top: true,
        pagination_bottom: true,
        search_button: false,
        tools: [],
        search: [],
        columns: [],
        data: [],
        async getList() {
            return window.axios.get(`/api/${this.resource}`);
        },
        async updateData(id, obj) {
            return (obj || window.axios).put(`/api/${this.resource}/${id}`);
        },
        async deleteData(id, obj) {
            return (obj || window.axios).delete(`/api/${this.resource}/${id}`);
        },
    };
    this.template_detail_options = {
        name: '詳細',
        name_new: '新規作成',
        name_update: '詳細：編集',
        resource: '',
        editable: false,
        deletable: false,
        edit_modal_option: {
            use_modal: true,
            with_name_column: 'name',
            with_name_message: ' を保存してよろしいですか？',
            subject: '保存',
            message: '保存してよろしいですか？',
            cancel_button: 'キャンセル',
            agree_button: 'はい'
        },
        delete_modal_option: {
            use_modal: true,
            with_name_column: 'name',
            with_name_message: ' を削除してよろしいですか？',
            subject: '削除',
            message: '削除してよろしいですか？',
            cancel_button: 'キャンセル',
            agree_button: 'はい'
        },
        tools: [],
        columns: [],
        async getData(id) {
            return window.axios.get(`/api/${this.resource}/${id}`);
        },
        async updateData(id, obj) {
            return (obj || window.axios).put(`/api/${this.resource}/${id}`);
        },
        async createData(obj) {
            return (obj || window.axios).post(`/api/${this.resource}`);
        },
        async deleteData(id, obj) {
            return (obj || window.axios).delete(`/api/${this.resource}/${id}`);
        },
        async createDataFromCSV(obj) {
            return obj.postMultipart(`/api/${this.resource}/csv`);
        },
    };
    this.listOptions = function (options) {
        for (const i in this.template_list_options) {
            if (typeof options[i] === 'undefined') {
                options[i] = this.template_list_options[i];
            }
        }
        return options;
    };
    this.detailOptions = function (options) {
        for (const i in this.template_detail_options) {
            if (typeof options[i] === 'undefined') {
                options[i] = this.template_detail_options[i];
            }
        }
        return options;
    };
    this.getResourceList = async function (resource_name, filters) {
        let ret;
        await window.axios.get(`/api/${resource_name}`).then(({data}) => {
            ret = data;
        });
        if (filters) {
            ret = ret.filter((elm) => {
                for (let i in filters) {
                    let filter = filters[i];
                    let value = elm[filter.column];
                    let flg = false;
                    if (
                        (filter.lt !== undefined && value < filter.lt)
                        ||
                        (filter.lteq !== undefined && value <= filter.lteq)
                        ||
                        (filter.gt !== undefined && value > filter.gt)
                        ||
                        (filter.gteq !== undefined && value >= filter.gteq)
                        ||
                        (filter.and !== undefined && value & filter.and)
                        ||
                        (filter.ne !== undefined && value !== filter.ne)
                        ||
                        (filter.eq !== undefined && String(value) === String(filter.eq))
                    ) {
                        flg = true;
                    }
                    return flg;
                }
            });
        }
        return {data:ret};
    };

    this.auth = {};
    this.basicMaster = [];
    window.axios.get('/api/me').then(({ data }) => {
        self.auth = data;
    }).then(() => {
        for (const key in masters) {
            window.axios.get(`/api/${masters[key]}`).then(({ data }) => {
                self.basicMaster[masters[key]] = data;
            });
        }
    });
}

export default new Mopi();
