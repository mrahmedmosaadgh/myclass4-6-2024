<template>
    <div>
        <div class="w-full flex justify-center pt-4">
            <div class="absolute top-32 float-right   w-full px-4 noprint">
                <a-button
                    type="primary"
                    @click="open_form_create['open_me'] = true"
                    shape="circle"
                    ><PlusOutlined
                /></a-button>
            </div>

            <div
                class="relative p-0 overflow-auto inline-block rounded bg-white border-2"
            >
                <table cellspacing="0" class="tg">
                    <thead class="">
                        <tr>
                            <th
                                colspan="5"
                                class="no-border_background pt-4"
                                v-html="props.settings?.title"
                            ></th>
                        </tr>
                        <tr>
                            <th>
                                <table_head_col_choose
                                    class="p-0 whitespace-nowrap"
                                    :lang="props.settings.lang"
                                    :data="props.settings.cols"
                                    >table_head_item err</table_head_col_choose
                                >
                            </th>
                            <th
                                v-for="(col, col_index) in props.settings.cols"
                                :key="col_index"
                                v-show="col.show"
                            >
                                <table_head_item
                                    class="p-0 whitespace-nowrap"
                                    @my_col="
                                        col = $event;
                                        table_head_item_data.search_text = '';
                                    "
                                    @text_filter="$emit('text_filter', $event)"
                                    :col="col.col"
                                    :text="
                                        props.settings.lang == 'en'
                                            ? col.en
                                            : col.ar
                                    "
                                    :data="table_head_item_data"
                                    >table_head_item err</table_head_item
                                >
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="(item, index) in props.data"
                            :key="index"
                            :class="{
                                even: (index + 1) % 2 === 0,
                                selected: item['select'] == 1,
                            }"
                            @click.ctrl="handleCtrlClick(index)"
                        >
                            <td class="w-8">
                                <div class="p-0 text-xs flex whitespace-nowrap">
                                    <table_col_action
                                        class="p-0"
                                        @update="fun_update($event, item)"
                                        @delete="fun_delete($event, item)"
                                        @view="fun_view($event, item)"
                                        >table_col_action err</table_col_action
                                    >
                                    <div class="p-0 text-xs">
                                        {{ index + 1 }}
                                    </div>
                                </div>
                            </td>

                            <td
                                v-for="(col, col_index) in props.settings.cols"
                                :key="col_index"
                                v-show="col.show"
                            >
                                <div class="p-0 text-xs flex whitespace-nowrap">
                                    <div class="p-0 text-xs">
                                        {{ item[col.col] }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <!-- <tfoot>
                        <tr>
                            <th>Total</th>
                            <td>10</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                    </tfoot> -->
                </table>
            </div>

        </div>
    </div>
</template>
<script setup>
import { PlusOutlined, PlusCircleFilled } from "@ant-design/icons-vue";
import { reactive, ref } from "vue";

import { useAppStore } from "@/stores/appstore";
import table_head_item from "./table_head_item.vue";
import table_head_col_choose from "./table_head_col_choose.vue";
import table_col_action from "./table_col_action.vue";
// import form_create from "./form_create.vue";
// import form_update from "./form_update.vue";
const props = defineProps(["data", "settings", "data_create"]);
const emit = defineEmits([
    "save_update",
    "save_create",
    "save_delete",
    "text_filter",
]);
const Ap = useAppStore();

const open = ref({ open_me: false });
const open_form_create = ref({ open_me: false });
const update_data = ref({});
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

// const table_sort_icon_data = ref(1)
const table_data = ref([
    {
        key: "1",
        name: "John Brown",
        age: 32,
        address: "New York No. 1 Lake Park",
    },
    {
        key: "2",
        name: "Joe Black",
        age: 42,
        address: "London No. 1 Lake Park",
    },
    {
        key: "3",
        name: "Jim Green",
        age: 32,
        address: "Sidney No. 1 Lake Park",
    },
    {
        key: "4",
        name: "Jim Red",
        age: 32,
        address: "London No. 2 Lake Park",
    },
]);

const state = reactive({
    searchText: "",
    searchedColumn: "",
});

const searchInput = ref();

const columns = [
    {
        title: "Name",
        dataIndex: "name",
        key: "name",
        customFilterDropdown: true,
        onFilter: (value, record) =>
            record.name.toString().toLowerCase().includes(value.toLowerCase()),
        onFilterDropdownOpenChange: (visible) => {
            if (visible) {
                setTimeout(() => {
                    searchInput.value.focus();
                }, 100);
            }
        },
    },
    {
        title: "Age",
        dataIndex: "age",
        key: "age",
    },
    {
        title: "Address",
        dataIndex: "address",
        key: "address",
        customFilterDropdown: true,
        onFilter: (value, record) =>
            record.address
                .toString()
                .toLowerCase()
                .includes(value.toLowerCase()),
        onFilterDropdownOpenChange: (visible) => {
            if (visible) {
                setTimeout(() => {
                    searchInput.value.focus();
                }, 100);
            }
        },
    },
];

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

function save_update(event, item) {
    emit("save_update", item);
    //console.log("save_update", item);
}
function save_create(event, item) {
    emit("save_create", item);
    //console.log("save_create", item);
}
function save_delete(event, item) {
    if (!confirm("are you sure?")) {
        return;
    }
    emit("save_delete", item);
    //console.log("save_delete", item);
}

function fun_update(event, item) {
    open.value["open_me"] = true;
    update_data.value = item;
    //console.log("fun_update", event, item);
}

function fun_delete(event, item) {
    //console.log("fun_delete", event, item);
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
