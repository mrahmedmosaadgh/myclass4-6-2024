<template>
 
    <button
        @click="save_all()"
        v-if="data_changed"
        class="heart peep css animated-shadow-button fixed bottom-0 z-50"
    >
        <SaveOutlined />
    </button>
    <div class="pt-4 w-screen flex justify-center px-4 relative">
        <!-- <a-button

            class="mx-4 scale-125 hover:scale-150 absolute -top-7"
            type="primary"
            @click="save_all()"
            shape="circle"
        > <SaveOutlined />
        </a-button> -->
        <!-- {{ data?.[0]?.my_class }}
        {{ props.data[0]['marks'] }} -->
        <!-- <div class="rounded bg-white border-2 w-full"> scroll-table-container-->




 
        <div class="rounded overflow-x-auto w-full m-auto"  >
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
                            <!-- <table_head_col_choose
                                class="p-0 whitespace-nowrap hidden"
                                :lang="Ap.lang"
                                :data="props.settings.cols"
                                >table_head_item err</table_head_col_choose
                            > -->

                            <a-tooltip color="purple">
                                <button
                                    class="hover:scale-150"
                                    @click="$emit('view')"
                                >
                                    <ReloadOutlined />
                                </button>
                                <template #title>
                                    {{
                                        Ap.lang == "en"
                                            ? "reload data"
                                            : "اعادة تحميل البيانات"
                                    }}
                                </template>
                            </a-tooltip>

                            #
                        </th>

                        <th class="max-w-min">
                            {{ Ap.lang == "en" ? "Name" : "الاسم" }}
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
                            v-for="(col, col_index) in props.data?.[0]?.['my_subject_title'] "
                            :key="col_index"
                            v-show="
                                col_edit_num == col_index || col_edit_enable
                            "
                        >
                            <a-button  v-if="!Ap.res?.show?.semester?.teacher_close"
                                class="mx-4 m-2"
                                type="text"
                                @click="
                                    col_edit_num = col_index;
                                    col_edit_enable = !col_edit_enable;
                                "
                                shape="circle"
                                ><EditOutlined
                            /></a-button>

                            <!-- v-model:open="visible"  trigger="click"-->
                            <a-popover
                                :title="
                                    Ap.lang == 'en'
                                        ? 'Auto fill column'
                                        : 'الاكمال التلقائي للدرجات'
                                "
                                trigger="click"
                            >
                                <!-- <a-popover title="fill all column"> -->
                                <template #content>
                                    <div class="p-0 w-full flex justify-center"  v-if="!Ap.res?.show?.semester?.teacher_close">
                                        <div
                                            class="p-0 flex flex-col gap-2 w-24"
                                        >
                                            <!-- <a-form-item :name="['user', 'age']" label="Age" :rules="[{ type: 'number', min: 0, max: col['highest_mark'] }]">
    </a-form-item> -->
                                            <div class="p-0 flex flex-col">
                                                <span class="p-0">
                                                    {{
                                                        Ap.lang == "en"
                                                            ? " mark:"
                                                            : "الدرجة"
                                                    }}
                                                </span>
                                                <a-input-number
                                                    class="w-full"
                                                    v-model:value="highest_mark"
                                                    min="0"
                                                    :max="col['highest_mark']"
                                                />
                                            </div>

                                            <div class="p-0 flex gap-4">
                                                <div class="p-0">
                                                    <a-button
                                                        type="primary"
                                                        shape="circle"
                                                        @click="
                                                            fill_all_fun(
                                                                col_index
                                                            )
                                                        "
                                                        class="noprint"
                                                        ><SaveOutlined
                                                    /></a-button>
                                                </div>
                                                <div class="p-0">
                                                    <a-button
                                                        type="primary"
                                                        shape="circle"
                                                        @click="
                                                            fill_all_fun_clear(
                                                                col_index
                                                            )
                                                        "
                                                        class="noprint"
                                                        danger
                                                        ><DeleteOutlined
                                                    /></a-button>
                                                </div>
                                            </div>
                                            <!-- <a @click="fill_all(col_index)">fill all</a> -->
                                        </div>
                                    </div>
                                </template>
                                <div class="p-0">
                                    <!--
                                              <a-tooltip color="purple" >


                                <template #title >
                                  {{Ap.lang == 'en' ? 'highest mark' : ' الدرجة العظمي    '}} <br>

                                 {{Ap.lang == 'en' ? 'Auto fill column' : 'الاكمال التلقائي للدرجات'}}

                                </template>
                                              </a-tooltip> -->

                                    <button
                                        @click="fill_all(col['highest_mark'])"
                                        class="cursor-pointer hover:scale-125"
                                    >
                                        <a-badge
                                            dir="ltr"
                                            :overflowCount="100"
                                            :count="col['highest_mark']"
                                            :number-style="{
                                                backgroundColor: '#fff',
                                                color: '#999',
                                                boxShadow:
                                                    '0 0 0 1px #d9d9d9 inset',
                                            }"
                                        />
                                    </button>
                                </div>
                            </a-popover>

                            <div class=" ">
                                {{ Ap.lang == "en" ? col["en"] : col["ar"] }}
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
                            {{ Ap.lang == "en" ? "Sum" : "المجموع" }}
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

                    >
                        <td class="w-8">
                            <div class="p-0 text-xs flex whitespace-nowrap">
                                <!-- <table_col_action
                                    v-if="settings['can_edit']"
                                    class="p-0"
                                    @row_update="$emit('row_update', item)"
                                    @row_delete="$emit('row_delete', item)"
                                    @row_view="fun_view($event, item)"
                                    >table_col_action err</table_col_action
                                >-->
                                <div class="p-0 text-xs">
                                    {{ index + 1 }}
                                </div>
                            </div>
                        </td>
                        <td class="w-52">
                            <div
                                class="p-0"
                                :title="
                                    Ap.lang == 'en' ? item['ar'] : item['en']
                                "
                            >
                                {{ Ap.lang == "en" ? item["en"] : item["ar"] }}
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
<div class="p-0 flex ">
                            <a-popover trigger="click"  v-if="!Ap.res?.show?.semester?.teacher_close">
                                <template #content>
                                    <div
                                        class="text-left w-40 flex flex-col gap-2 whitespace-nowrap"
                                    >
                                        <!-- <a-button
                                            @click="
                                                col2['edit'] = !col2['edit']
                                            "
                                            type="primary"
                                            size="small"
                                            class="m-1 rounded px-1"
                                            ><SaveOutlined
                                        /></a-button> -->

                                        <div class="p-0  ">
                                            <a-switch
                                                v-model:checked="col2.attend"
                                                :checkedValue="1"
                                                :unCheckedValue="0"
                                                @change="
                                                    data_changed = true;
                                                    col2['attend'] == 0
                                                        ? (col2['mark'] = null)
                                                        : null;
                                                "
                                            />
                                            {{
                                                Ap.lang == "en"
                                                    ? "Attend  "
                                                    : "حاضر"
                                            }}
                                        </div>

                                        <div class="p-0">
                                            <a-switch
                                                v-model:checked="col2.completed"
                                                :checkedValue="1"
                                                :unCheckedValue="0"
                                                @change="
                                                    data_changed = true;
                                                    col2['completed'] == 0
                                                        ? (col2['mark'] = null)
                                                        : null;
                                                "
                                            />

                                            {{
                                                Ap.lang == "en"
                                                    ? "Completed  "
                                                    : " مكتمل"
                                            }}
                                        </div>
                                    </div>
                                </template>
                                <!-- v-if="settings['can_edit']" -->
                                <a-button
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
                            <div
                                class=" "
                                v-if="col2.attend == 1 && col2.completed == 1"
                            >
                                <a-badge
                                    :dot="
                                        col2?.['my_subject_title']?.[col_index]?.[
                                            'highest_mark'
                                        ] *
                                            0.8 >
                                            col2['mark'] && col2['mark']
                                    "
                                >
                                    <a-input-number
                                     v-if="!Ap.res?.show?.semester?.teacher_close"
                                        @change="data_changed = true"
                                        :disabled="col2.attend == 0"
                                        :class="
                                            col2['mark'] == null
                                                ? 'border-gray-200 bg-gray-100'
                                                : 'border-green-500'
                                        "
                                        v-model:value="col2['mark']"
                                        :min="0"
                                        :max="
                                            col2?.['my_subject_title']?.[col_index]?.[
                                                'highest_mark'
                                            ]
                                        "
                                        :status="
                                            col2?.['my_subject_title']?.[col_index]?.[
                                                'highest_mark'
                                            ] *
                                                0.8 >
                                            col2['mark']
                                                ? 'error'
                                                : ''
                                        "
                                    ></a-input-number>
                                    <div class="     text-center"  v-if="Ap.res?.show?.semester?.teacher_close">
{{col2['mark']}}
                                    </div>
                                    <!-- @input="update_cell_fun(col2)" -->
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
                            <div
                                class="p-0 text-red-700 bg-red-100 text-center"
                                v-else
                            >
                                <div class="p-0" v-if="col2.attend == 0">
                                    {{ Ap.lang == "en" ? "Absent  " : "غائب" }}
                                </div>
                                <div class="p-0" v-if="col2.completed == 0">
                                    {{
                                        Ap.lang == "en"
                                            ? "Not completed  "
                                            : "غير مكتمل"
                                    }}
                                </div>
                            </div>

</div>
                        </td>
                        <td>
                            <div
                                class="p-0 relative"
                                v-if="item?.mark_sum?.['mark']"
                            >
                          {{  item?.mark_sum?.['mark']}}
                                <div
                                    v-if="item?.mark_sum?.['completed'] == 1"
                                    class="h2 w-6 mx-8 p-1 text-xs red rounded-full text-center"
                                    :class="
                                        item?.mark_sum?.['mark'] > 90
                                            ? 'green'
                                            : 'red'
                                    "
                                >
                                    {{ item?.mark_sum?.["letter"] }}
                                </div>


 

                                <div class="p-0" v-else>
                                    <div
                                        class="p-0"
                                        v-if="item?.mark_sum?.attend == 0"
                                    >
                                        {{
                                            Ap.lang == "en"
                                                ? "Absent  "
                                                : "غائب"
                                        }}
                                    </div>





                                    <div
                                        class="p-0 text-2xs opacity-50"
                                        v-if="item?.mark_sum?.completed == 0"
                                    >
                                        {{
                                            Ap.lang == "en"
                                                ? "Not completed  "
                                                : "غير مكتمل"
                                        }}
                                    </div>
                                </div>

                                <!-- <div class=" ">
                                    {{ item?.mark_sum?.["completed"] }}
                                </div> -->
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
    ReloadOutlined,
    SaveOutlined,
    DeleteOutlined,
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
const data_changed = ref(false);
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
    var msg1 =
        Ap.lang == "en"
            ? "Are you sure to  save all records        ?"
            : "هل ترغب في حفظ كل السجلات    ";

    if (!confirm(msg1)) {
        return;
    }
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
            msg_error: "save marks error",
            sys_error: true,
            log: true,
            d_fun: "save_all",
        }
    );
    data_changed.value = false;
};

const highest_mark = ref(null);
const fill_all = (max) => {
    highest_mark.value = max;
};

const fill_all_fun_clear = (col_index) => {
    props.data.forEach((element, key) => {
        element["marks"][col_index]["mark"] = null;
    });
    data_changed.value = true;
};

const fill_all_fun = (col_index) => {
    data_changed.value = true;
    props.data.forEach((element, key) => {
        element["marks"][col_index]["mark"] = highest_mark.value;
        element["marks"][col_index]["attend"] = 1;
        element["marks"][col_index]["completed"] = 1;
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

/* /////////////////////////////// */
.heart-peep {
    /* position: relative; */
    /* display: inline-block; */
    padding: 20px 50px;
    border: 2px solid #ccc;
    border-radius: 5px;
    color: #333;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
    /* position: fixed; */
    /* bottom: 0px; */
}

.heart-peep:hover,
.heart-peep,
.heart-peep:active {
    background-color: #fff;
    border-color: #f00;
    transform: scale(1.1); /* Slight scale-up for emphasis */
}

/* .heart-peep:after {
    content: "";
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    height: 10px;
    width: 10px;
    border-radius: 50%;
    background-color: #f00;
    box-shadow: 0 0 5px #f00;
    opacity: 0;
    transition: opacity 0.1s ease-in-out;
} */

.heart-peep:hover:after,
.heart-peep,
.heart-peep:active:after {
    opacity: 1;
    animation: heart-peep 2.5s ease-in-out infinite;
    /* animation: heart-peep 0.5s ease-in-out forwards; */
}

@keyframes heart-peep {
    0% {
        transform: translate(-50%, -50%) scale(0.8);
    }
    50% {
        transform: translate(-50%, -50%) scale(1);
    }
    100% {
        transform: translate(-50%, -50%) scale(0.8);
        /* opacity: 0; */
    }
}
/* //////////////////////////////////// */

.animated-shadow-button {
    /* position: relative;
    display: inline-block; */
    padding: 20px 50px;
    margin: 20px 50px;
    border: none;
    background-color: green;
    border-radius: 5px;
    color: white;
    cursor: pointer;
    box-shadow: 0 0 5px rgba(255, 255, 255, 0.7),
        10px 10px 15px rgba(0, 0, 0, 0.3);
    /* transition: all 0.3s ease-in-out; */
    animation: heart-peep 2.5s ease-in-out infinite;
}

.animated-shadow-button:after {
    content: "";
    position: absolute; /* Position the shadow */
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border-radius: inherit; /* Inherit border-radius for smooth edges */
    box-shadow: 0 0 5px rgba(255, 255, 255, 0.7),
        10px 10px 15px rgba(0, 0, 0, 0.3);

    /* transition: box-shadow 0.3s ease-in-out; */
    /* animation: heart-peep 2.5s ease-in-out infinite; */
}

.animated-shadow-button:hover,
.animated-shadow-button:active {
    /* transform: scale(1.05); Subtle zoom on hover */
    box-shadow: 0 0 15px rgba(255, 255, 255, 0.7),
        10px 10px 15px rgba(0, 0, 0, 0.3);
    animation: heart-peep 2.5s ease-in-out infinite;
}
</style>
