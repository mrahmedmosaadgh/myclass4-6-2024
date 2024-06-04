<template>
    <div class="pt-4 w-screen flex justify-center px-4 relative">



  <!-- <a-drawer :width="100" title="Basic Drawer"  placement="top" :open="open_fill_all" @close="onClose"> -->
  <a-drawer :width="100" title="Basic Drawer"  placement="top" :open="open_fill_all2"   >
    <template #extra>
      <a-button style="margin-right: 8px">Cancel</a-button>
      <a-button type="primary">Submit</a-button>

      <!-- <a-button style="margin-right: 8px" @click="onClose">Cancel</a-button>
      <a-button type="primary" @click="onClose">Submit</a-button> -->

    </template>
    <p>Some contents...</p>
    <p>Some contents...</p>
    <!-- <p>Some contents...</p> -->
  </a-drawer>


  <a-button type="primary" @click="open_fill_all=!open_fill_all">Open</a-button>
  <a-drawer :height="200"
    v-model:open="open_fill_all"
    class="custom-class"
    root-class-name="root-class-name"
    :root-style="{ color: 'blue' }"
    style="color: red"
    title="Basic Drawer"
    placement="top"
    @after-open-change="afterOpenChange"
  >
    <p>Some contents...</p>
    <p>Some contents...</p>
    <p>Some contents...</p>
  </a-drawer>




        <a-button
            class="mx-4 scale-125 hover:scale-150 absolute -top-7"
            type="primary"
            @click="save_all()"
            shape="circle"
            ><SaveOutlined
        /></a-button>
        <!-- <div class="rounded bg-white border-2 w-full"> scroll-table-container-->
        <div class="rounded overflow-x-auto w-full m-auto">
            <table cellspacing="0" class="tg w-full">
                <thead class="">
                    <tr v-if="props.settings?.title">
                        <th colspan="32" class="no-border_background pt-4">
                            <div
                                class="p-0 text-center flex"
                                v-html="props.settings?.title"
                            ></div>
                            <div class="p-0 text-center w-full"></div>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <table_head_col_choose
                                class="p-0 whitespace-nowrap hidden"
                                :lang=" Ap.lang"
                                :data="props.settings.cols"
                                >table_head_item err</table_head_col_choose
                            >#
                        </th>

                        <th class="max-w-min">
                            {{  Ap.lang == "en" ? "Name" : "الاسم" }}
                            <!-- <a-button
                                class="px-2"
                                type="text"
                                @click="col_edit_enable = !col_edit_enable"
                                shape="circle"
                                ><EditOutlined
                            /></a-button> -->
                        </th>
                        <!-- <th>
                            {{
                                props.data[0]["marks"][0]["my_subject_title"][
                                    "ar"
                                ]
                            }}</th> -->
                        <!-- props.data[0]['marks'] -->
                        <!-- {{ props.data[0]['marks'][0]['my_subject_title'] }} -->

                        <th
                            class="w-32"
                            v-for="(col, col_index) in props.data[0][
                                'marks'
                            ][0]['my_subject_title']"
                            :key="col_index"
                            v-show="
                                col_edit_num == col_index || col_edit_enable
                            "
                        >
                            <a-button
                                class="mx-4 m-2"
                                type="text"
                                @click="
                                    col_edit_num = col_index;
                                    col_edit_enable = !col_edit_enable;
                                "
                                shape="circle"
                                ><EditOutlined
                            /></a-button>

                            <a-badge
                                class="cursor-pointer hover:scale-125"
                                @click="fill_all(col_index)"
                                dir="ltr"
                                :overflowCount="1000"
                                :count="col['highest_mark']"
                                :number-style="{
                                    backgroundColor: '#fff',
                                    color: '#999',
                                    boxShadow: '0 0 0 1px #d9d9d9 inset',
                                }"
                            />
                            <div class=" ">
                                {{
                                     Ap.lang == "en"
                                        ? col["en"]
                                        : col["ar"]
                                }}
                            </div>

                            <!--
                            <a-badge
                                dir="ltr"
                                placement="right"
                                :count="col['highest_mark']"
                                title="Custom hover text"
                                color="orange"
                            >
                                <div class=" ">
                                    {{ col["my_subject_title"]["ar"] }}
                                </div>
                            </a-badge> -->
                            <!-- <a-avatar shape="square" size="large" /> -->

                            <!-- ["my_subject_title"][""]mark_order -->
                            <!-- :max({{ col["my_subject_title"]["highest_mark"] }}) -->
                        </th>
                        <th class="w-12">
                            {{  Ap.lang == "en" ? "Sum" : "المجموع" }}
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
                                    v-if="settings['can_edit']"
                                    class="p-0"
                                    @row_update="$emit('row_update', item)"
                                    @row_delete="$emit('row_delete', item)"
                                    @row_view="fun_view($event, item)"
                                    >table_col_action err</table_col_action
                                >
                                <div class="p-0 text-xs">
                                    {{ index + 1 }}
                                </div>
                            </div>
                        </td>
                        <td class="w-52">
                            <div
                                class="p-0"
                                :title="
                                     Ap.lang == 'en'
                                        ? item['name_ar']
                                        : item['name_en']
                                "
                            >
                                {{
                                     Ap.lang == "en"
                                        ? item["name_en"]
                                        : item["name_ar"]
                                }}
                            </div>
                        </td>
                        <td
                            v-for="(col2, col_index) in item['marks']"
                            :key="col_index"
                            v-show="
                                col_edit_num == col_index || col_edit_enable
                            "
                        >
                            <!-- v-show="props.data[0]['marks'][0]['my_subject_title'][col_index]['edit']" -->
                            <!-- //// v-model:open="open_option"////////////////////////////////////////////////////////////////////// -->
                            <!-- @click="
                                                // $emit('row_update');
                                                // open_option = !open_option
                                            " -->
                            <!-- {{item['marks']}} -->
                            <!-- {{ col2["mark"] }} -->
                            <!-- {{ col_edit_num == col_index }} -->

                            <a-popover trigger="click">
                                <template #content>
                                    <div
                                        class="text-left w-40 flex whitespace-nowrap"
                                    >
                                        <a-button
                                            @click="
                                                col2['edit'] = !col2['edit']
                                            "
                                            type="primary"
                                            size="small"
                                            class="m-1 rounded px-1"
                                            ><EditOutlined
                                        /></a-button>

                                        <a-switch
                                            v-model:checked="col2.attend"
                                            :checkedValue="1"
                                            :unCheckedValue="0"
                                            @change="
                                                col2['attend'] == 0
                                                    ? (col2['mark'] = null)
                                                    : null
                                            "
                                        />
                                    </div>
                                </template>
                                <a-button
                                    v-if="settings['can_edit']"
                                    type="text"
                                    size="small"
                                    style="padding: 0px"
                                    class="noprint"
                                    ><MoreOutlined
                                        style="
                                            padding: 0px;
                                            margin: 0px;
                                            width: 12px;
                                        "
                                /></a-button>
                            </a-popover>

                            <!-- ///////////////////v-if="col2['edit'] == true"/// style="width: 100%"//////////////////////////////////////////////////// -->
                            <div class=" " v-if="col2.attend == 1">
                                <a-badge
                                    :dot="
                                        col2['my_subject_title'][col_index][
                                            'highest_mark'
                                        ] *
                                            0.8 >
                                        col2['mark'] && col2['mark']
                                    "
                                >
                                    <a-input-number
                                        :disabled="col2.attend == 0"
                                        :class="
                                            col2['mark'] == null
                                                ? 'border-gray-200 bg-gray-100'
                                                : 'border-green-500'
                                        "
                                        v-model:value="col2['mark']"
                                        :min="0"
                                        :max="
                                            col2['my_subject_title'][col_index][
                                                'highest_mark'
                                            ]
                                        "
                                        :status="
                                            col2['my_subject_title'][col_index][
                                                'highest_mark'
                                            ] *
                                                0.8 >
                                            col2['mark']
                                                ? 'error'
                                                : ''
                                        "
                                        @input="update_cell_fun(col2)"
                                    ></a-input-number>
                                </a-badge>

                                <!-- @change="update_cell_fun(col2)" -->
                                <div
                                    v-if="col2['edit'] == false"
                                    class="px-2 w-12 h-6 red"
                                    @dblclick="col2['edit'] = true"
                                >
                                    {{ col2["mark"] }}
                                </div>
                            </div>
                            <div class="p-0" v-else>
                                {{ "Absent" }}
                            </div>

                            <!-- :max="col2['highest_mark']" min="0" -->

                            <!-- <input type="number" class="w-12" v-model="col2['mark']"  @change="update_fun(col2['id'] ,col2['mark'],col2)"> -->
                            <div class="p-0 text-xs flex whitespace-nowrap">
                                <div class="p-0 text-xs">
                                    <!-- {{ col2 }} -->
                                    <!-- {{ col2['id'] }}:   {{ col2['mark'] }}:{{col2['mark_order']  }}:{{col2['my_subject_title']['ar']   }} -->
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="p-0 relative" v-if="item?.mark_sum?.['mark']">
                                <div
                                    class="h2 w-6 mx-8 p-1 text-xs red rounded-full text-center"
                                    :class="
                                        item?.mark_sum?.['mark'] > 90
                                            ? 'green'
                                            : 'red'
                                    "
                                >
                                    {{ item?.mark_sum?.["letter"] }}
                                </div>
                                <div class=" ">
                                    {{ item?.mark_sum?.["mark"] }}
                                </div>
                            </div>
                        </td>
                        <!-- <td>{{ item?.mark_sum?.["letter"] }}</td> -->
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
import {
    PlusOutlined,
    MoreOutlined,
    EditOutlined,
    SaveOutlined,
} from "@ant-design/icons-vue";
import { ref, onMounted } from "vue";

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
const col_edit_num = ref(0);
const open_fill_all = ref(false);
const col_edit_enable = ref(true);

const open = ref({ open_me: false });
const open_option = ref(false);
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
const save_all = () => {
    Ap.d(
        {
            fun: "save_all",
            data: props.data,
            // data: {school_id:selected_school_id,class_id:class_id},
        },
        {
            route: "/api/teacher_marks_edit",
            msg: Ap.lang == "en" ? "Done with success" : "تم بنجاح",
            loading: true,
            res_ver: "save_all",
            msg_error: "msg_error",
            sys_error: true,
            log: true,
            d_fun: "save_all",
        }
    );
};

const fill_all = () => {
open_fill_all.value=!open_fill_all.value
}


const fill_all_fun = (col_index) => {
    var msg1 =
          Ap.lang == "en"
            ? "Are you sure to fill all records with full mark  ?"
            : "هل ترغب في ملاء كل السجلات بالدرجة النهائية";

    if (!confirm(msg1)) {
        return;
    }
    //console.log(col_index);
    var highest_mark =
        props.data[0]["marks"][0]["my_subject_title"][col_index][
            "highest_mark"
        ];
    //console.log(highest_mark);
    props.data.forEach((element, key) => {
        element["marks"][col_index]["mark"] = highest_mark;
        //console.log(element["marks"][col_index]["mark"]);
        //   //console.log(`Element at key key is ${element}`);
    });
};

const edit_col = (col_index) => {
    //console.log(col_index);
    col_edit_num.value = col_index;
};

const update_cell_fun = (data) => {
    //console.log(data);
    //console.log(data["mark"]);
    //     if(data['mark']>data["my_subject_title"]["highest_mark"]){
    // data['mark']=null
    // alert('err')
    //     }
};

const update_fun = (id, val, data) => {
    if (data["my_subject_title"]["highest_mark"] < val) {
        alert("err");
        data["mark"] = null;
        //console.log(data["highest_mark"] < val);
    } else {
        //console.log(data);
    }
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
