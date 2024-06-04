<template>
    <div>
        <div class="w-full flex justify-center relative pt-2">
            <div
                class="absolute -top-2 float-right flex gap-2 w-full px-4 noprint"
            >
                <a-button
                    v-if="my_mood1.my_mood == 'view'"
                    class="px-1"
                    type="primary"
                    @click="change_mood('create')"
                    shape="circle"
                    ><PlusOutlined
                /></a-button>
                <a-button
                    v-if="my_mood1.my_mood == 'create'"
                    class="px-1"
                    type="primary"
                    @click="my_mood1.my_mood = 'view'"
                    shape="circle"
                >
                    <EyeOutlined />
                </a-button>

                <a-button
                    class="px-1"
                    type="primary"
                    @click="my_mood1.my_mood = 'view'"
                    shape="circle"
                >
                    <PrinterOutlined />
                </a-button>
                <a-button
                    class="px-1"
                    type="primary"
                    @click="my_mood1.my_mood = 'view'"
                    shape="circle"
                >
                    <FileExcelOutlined />
                </a-button>
            </div>
 <!-- @save_create="fun_create($event)" @save_update="fun_update($event)" -->
            <div>
                <div>
                    <my_table
                        v-if="my_mood1.my_mood == 'view'"
                        :data="props.data"
                        :db_view="props.db_view"
                        :data_create="props.data_create"
                        :settings="props.settings"

                        
                        @row_delete="save_delete($event)"
                        @save_delete="fun_delete($event)"
                        @text_filter="fun_filter($event)"
                        @view="$emit('view')"
                        @row_update="row_update_fun($event)"
                    ></my_table>

                </div>
            </div>
<!-- sm:w-full lg:w-1/2 lg:px-12 -->
            <form_update
                class=""
                v-if="my_mood1.my_mood == 'update'"
                :open_me="open"
                :data="form_update_data"
                :lang="settings.lang"
                @save_update="save_update($event)"
                @cancel="change_mood('view')"
            ></form_update>
            <!-- class="w-full px-8" -->
            <form_create
                v-if="my_mood1.my_mood == 'create'"
                :open_me="open_form_create"
                :lang="settings.lang"
                :data="props.data_create"
                @save_create="save_create(props.data_create)"
                @cancel="change_mood('view')"
            ></form_create>
        </div>
    </div>
</template>
<script setup>
import {
    PlusOutlined,
    EyeOutlined,
    PrinterOutlined,
    FileExcelOutlined,
} from "@ant-design/icons-vue";
import {  ref } from "vue";

import { useAppStore } from "@/stores/appstore";

import my_table from "./my_table.vue";
import form_create from "./form_create.vue";
import form_update from "./form_update.vue";
// const props = defineProps(["data", "settings", "data_create",'db_view']);

const props = defineProps({
    data: {
        type: Object,
        default: () => ({}), // An empty object as default value
    },
    settings: {
        type: Object,
        default: () => ({}), // An empty object as default value
    },
    data_create: {
        type: Object, // No default value, as it's likely a callback
    },


    my_mood1: {
        type: Object, // No default value, as it's likely a callback
        default: () => ({ my_mood: "view" }),
    },
    db_view: {
        type: Boolean,
        default: false, // Default to false for the boolean prop
    },
});

const emit = defineEmits([
    "save_update",
    "save_create",
    "save_delete",
    "text_filter",
    "view",
]);
// const Ap = useAppStore();

const open = ref({ open_me: false });
// const mood = ref('view');
const open_form_create = ref({ open_me: false });
const update_data = ref({});
const form_update_data = ref({});
const table_sort_mood = ref(1);
const search_text = ref("");
const col = ref("");
const table_head_item_data = ref({
    sort: table_sort_mood.value,
    col: "name",
    text: "name 122",
    search_text: search_text.value,
});

const table_head_col_choose_data = ref([
    { val: true, col: "name", text: "name 122" },
    { val: true, col: "date", text: "date" },
    { val: true, col: "ee", text: "ee ee" },
    { val: true, col: "www", text: "ee wwww" },
]);

// const my_mood = ref("view");
const change_mood = (txt) => {
    //console.log(txt);
    //console.log(props.settings);

    props.my_mood1.my_mood = txt;
};
const filter_fun = (event) => {
    //console.log(event);
};

const handleSearch = (selectedKeys, confirm, dataIndex) => {
    confirm();
    state.searchText = selectedKeys[0];
    state.searchedColumn = dataIndex;
};

const handleReset = (clearFilters) => {
    clearFilters({ confirm: true });
    state.searchText = "";
};

function save_update(event) {
    emit("save_update", event);
    //console.log("save_update", event);
    $emit('view')
}
function save_create(data) {
    emit("save_create", data);
    // //console.log("save_create", item);
}
// function save_delete(event, item) {
function save_delete(event) {
    if (!confirm("are you sure?")) {
        return;
    }
    emit("save_delete", event);
    //console.log("save_delete", item);
}

function row_update_fun(event) {
    form_update_data.value = event;
    //console.log("fun_update", event);

    props.my_mood1.my_mood = "update";
}

function fun_delete(event, item) {
    console.log("fun_delete", event, item);
}
function fun_create(event, item) {
    //console.log("fun_create", event, item);
}
function fun_view(event, item) {
    //console.log("fun_view", event, item);
}

function fun_new(event) {
    //console.log(event);
}

function sort_me(type, col) {
    if (type == 1) {
        table_data.value.sort((a, b) => {
            const isNumeric = !isNaN(parseFloat(a[col])) && isFinite(a[col]);

            if (isNumeric) {
                // Compare as numbers:
                return a[col] - b[col];
            } else {
                // Compare as strings (case-insensitive):
                return a[col].localeCompare(b[col]);
            }
        });
    }

    if (type == 2) {
        table_data.value.sort((a, b) => {
            const isNumeric = !isNaN(parseFloat(a[col])) && isFinite(a[col]);

            if (isNumeric) {
                // Compare as numbers:
                return b[col] - a[col];
            } else {
                // Compare as strings (case-insensitive):
                return b[col].localeCompare(a[col]);
            }
        });
    }
    if (type == 0) {
        // return data
    }
}
</script>
<style scoped>
.highlight {
    background-color: rgb(255, 192, 105);
    padding: 0px;
}

tr .no-border_background {
    background-color: transparent !important;
    color: black !important;
    border: 0px solid transparent;
}
</style>
