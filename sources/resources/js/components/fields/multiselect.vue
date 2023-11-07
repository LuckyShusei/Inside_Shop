<template>
  <div class="form-field">
    <div v-if="showForm && masters.loaded && (!state.current_data.id || $parent.detailDataLoaded)">
      <multiselect
          :value="selectedData"
          :options="masters.options[column.options.rel]"
          :label="'label'"
          :track-by="'key'"
          :multiple="true"
          :close-on-select="true"
          :placeholder="'（選択してください）'"
          @input="onSelect"
      >
      </multiselect>
      <parts-form-error :errors="errors" :column="column" />
    </div>
    <div v-else-if="state.current_data.id && masters.loaded && $parent.detailDataLoaded" class="form-value">
      <div v-for="(d) in selectedData">
        {{ d.label }}
      </div>
    </div>
    <div v-else class="form-value">
      <i class="fas fa-spinner fa-spin"></i>
    </div>
  </div>
</template>

<script>
export default {
    props: ['column', 'data', 'state', 'errors', 'form', 'search_field', 'masters'],
    data() {
        return {
          selectedData: [],
          loaded: false
        };
    },
    computed: {
      showForm: function () {
        return this.search_field || (this.state.edit_mode && this.column.editable);
      },
      listOptions: function () {
        return this.masters.options[this.column.options.rel];
      }
    },
    watch: {
      '$parent.detailDataLoaded': function (new_data, old_data)
      {
        if (new_data) {
          this.form[this.column.bind].forEach((elm) => {
            this.selectedData.push({key: elm[this.column.options.key_column ? this.column.options.key_column : 'id'], label: elm[this.column.options.label_column ? this.column.options.label_column : 'name']});
          });
        }
      }
    },
    methods: {
      onSelect (e) {
        this.selectedData = e;
        let self = this;
        this.form[this.column.bind] = [];
        e.forEach((elm) => {
          let ob = {};
          ob[self.column.options.key_column ? this.column.options.key_column : 'id']       = elm.key;
          ob[self.column.options.label_column ? this.column.options.label_column : 'name'] = elm.label;
          self.form[self.column.bind].push(ob);
        });
      },
    },
    created() {
    },
    mounted() {
    }
};
</script>
