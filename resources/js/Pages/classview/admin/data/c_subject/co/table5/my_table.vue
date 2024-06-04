<template>
    <div class="pt-4   w-screen  flex justify-center px-4">

        <!-- <div class="rounded bg-white border-2 w-full"> scroll-table-container-->
        <div class="rounded  overflow-x-auto   w-full    m-auto    ">
            <table cellspacing="0"  class="tg w-full">
                <thead class="">
                    <!-- <tr>
                        <th colspan="32" class="no-border_background pt-4">
                            <div
                                class="p-0 text-center flex"
                                v-html="props.settings?.title"
                            ></div>
                            <div class="p-0 text-center w-full"></div>
                        </th>
                    </tr> -->
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
                            <div class="p-0 text-xs flex whitespace-nowrap justify-items-center">
                                <table_col_action
                                    class="px-2 scale-x-150  "
                                    @row_update="$emit('row_update', item)"
                                    @row_delete="$emit('row_delete', item)"
                                    @row_view="fun_view($event, item)"
                                    >table_col_action err</table_col_action>


                                    <!-- <a-button type="primary" shape="circle"  @click="$emit('row_update', item)"   size="small"><EditOutlined /></a-button>
<a-button type="primary" shape="circle" @click="$emit('row_delete', item)"  size="small" class="mx-8" danger><DeleteOutlined /></a-button> -->


                                <div class="pt-1 text-xs">
                                    {{ index + 1 }}
                                </div>
                            </div>
                        </td>
<td>
<!-- {{ item?.report_title }} -->
<!-- <input type="text" v-model="item.report_title"> -->
<my_check_box class=" text-2xl  "
:checkbox_data="{data:item?.report_title,text:'   '}"
:val="{val_true:1, val_false:0}"
@val="item.report_title=$event;update_val_fun(item.id,'report_title',item?.report_title)"

 >my_check_box err</my_check_box>
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
</template>
<script setup>
// import { PlusOutlined, PlusCircleFilled } from "@ant-design/icons-vue";
import {  ref, onMounted } from "vue";

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
    "view",
]);
const Ap = useAppStore();
onMounted(() => {
    emit("view");
});

function update_val_fun(id,col,val){

    d(
        {
            fun: "update_val_c_subject",
            data: { id:id,col:col ,val:val },
            // data: { student_id: 1265 },
            // data: {school_id:selected_school_id,class_id:class_id},
        },
        {
            route: "/api/school_admin/c_subject",
            msg: null,
            // msg: Ap.lang == 'en' ? 'Done with success' : 'تم بنجاح',
            loading: true,
            res_ver: "update_val_c_subject",
            msg_error: "msg_error",
            sys_error: true,
            log: true,
            d_fun: "update_val_c_subject",
        }
    );
}
function d(
    db_data = null,
    options = {
        route: null,
        msg: null,
        // msg_duration:2000,
        loading: true,
        log: true,
        res_ver: "ver",
        msg_error: "Error",
        sys_error: false,
        d_fun: null,
    }
) {
    // //console.log(options);
    // //console.log(db_data);
    if (options.route == null) {
        message.error("no route");
        return;
    }

    options.loading ? (Ap.loading = true) : (Ap.loading = false);

    axios
        .post(options.route, { data: db_data })
        .then((response) => {
            Ap.d_counter++;
            Ap.d_fun = options.d_fun;

            if(options.res_ver){

            Ap.res[options.res_ver] = response.data;
            }

            Ap.loading = false;
            options?.msg != null ? message.success(options.msg) : null;

            if (options.log) {
                //console.log(response);
            }
            //console.log(1);
        })
        .catch((error) => {
            //console.log(0);

            Ap.loading = false;

            //console.log(error?.response?.status);
            if (error?.response?.status == 419) {
                if (!confirm("reload")) {
                    return;
                }
                window.location.reload();
            }

            //console.log("db res error");
            var msg1 = options.sys_error
                ? options.msg_error + " :" + error?.response?.data?.message
                : null;

            //console.log("error.response ");
            //console.log(error?.response?.data?.message);
            // message.error(error?.response?.data?.message);

            options.msg != null ? message.error(msg1) : null;
        });
}
const open = ref({ open_me: false });
const update_data = ref({});
const table_sort_mood = ref(1);
const search_text = ref("");
const table_head_item_data = ref({
    sort: table_sort_mood.value,
    col: "name",
    text: "name 122",
    search_text: search_text.value,
});


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

function fun_row_update(event, item) {
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
.scroll-table-container {
    overflow-x: auto;
    overflow-y: auto;
     width: 100%;
     background-color: white;


     margin: auto;
    /* max-width: 1200px; */
    /* height: 400px; Adjust height as needed */
    border: 1px solid white;
}

@media print {
    .scroll-table-container {
        width: 100%;
        overflow: visible;
        border: 0px solid #000000;
        padding: auto;
    }
    /* table {
        table-layout:auto;
        border-collapse: collapse;
        width: 100%;
        color: black;
        table-layout: fixed; Optional to prevent horizontal scrolling
    } */
}



tr .no-border_background {
    background-color: transparent !important;
    color: black !important;
    border: 0px solid transparent;
}
</style>
