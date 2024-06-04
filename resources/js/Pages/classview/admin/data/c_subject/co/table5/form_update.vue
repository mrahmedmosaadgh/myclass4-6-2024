<template>
    <div :dir="lang == 'en' ? 'lrt' : 'rtl'" v-if="props.data">
        <a-badge-ribbon
            text="update    semester Exam"
            dir="ltr"
            class="w-full text-center"
            color="blue"
        >
            <a-card
                hoverable
                title=" "
                class="cursor-default w-full"
                :dir="lang == 'en' ? 'lrt' : 'rtl'"
            >

                <a-form
                    :dir="lang == 'en' ? 'lrt' : 'rtl'"
                    ref="formRef"
                    name="custom-validation"
                    :model="data"
                    :rules="rules"
                    v-bind="layout"
                >
                    <a-form-item
                        has-feedback
                        :label="lang == 'en' ? 'detail' : 'تفاصيل  '"
                        name="detail"
                    >
                        <a-input
                            v-model:value="props.data.detail"
                            type="text"
                            autocomplete="off"
                        />
                    </a-form-item>

                    <a-form-item
                        has-feedback
                        :label="lang == 'en' ? 'Name Arabic' : 'الاسم عربي'"
                        name="ar"
                    >
                        <a-input
                            v-model:value="props.data.ar"
                            type="text"
                            autocomplete="off"
                        />
                    </a-form-item>
                    <a-form-item
                        has-feedback
                        :label="lang == 'en' ? 'Name English' : 'الاسم English'"
                        name="en"
                    >
                        <a-input
                            v-model:value="props.data.en"
                            type="text"
                            autocomplete="off"
                        />
                    </a-form-item>

                    <!-- {{ props.data.my_subject_title[0] }} -->
                    <div class="rounded overflow-x-auto w-full m-auto">
                        <table cellspacing="0" class="tg w-full">
                            <thead class="">
                                <tr>
                                    <th>#</th>
                                    <th>{{ tr("ar") }}-{{ tr("en") }}</th>

                                    <th>
                                        {{ tr("highest_mark") }}
                                    </th>

                                    <th>
                                        {{ tr("edit") }}
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
  <!-- @click.ctrl="handleCtrlClick(index)" -->
                                <tr
                          v-for="(item, index) in props.data.my_subject_title"
                                    :key="index"
                                    :class="{
                                        even: (index + 1) % 2 === 0,
                                        selected: item['select'] == 1,
                                    }"

                                >
                                    <td class="w-8">
                                        <div
                                            class="p-0 text-xs flex whitespace-nowrap"
                                        >
                                            <div class="p-0 text-xs">
                                                {{ index + 1 }}
                                            </div>
                                        </div>
                                    </td>
                                    <!-- @dblclick="edit_mood(item)" -->
                                    <td>
                                        {{
                                            lang == "en"
                                                ? item["en"]
                                                : item["ar"]
                                        }}
                                        <div class="p-0 text-gray-400 text-xs">
                                            {{
                                                lang == "en"
                                                    ? item["ar"]
                                                    : item["en"]
                                            }}
                                            <br />
                                            <div
                                                class="p-0 text-2xs text-gray-300"
                                            >
                                                {{ item["detail"] }}
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        {{ item.highest_mark }}
                                        <div class="p-0 text-gray-400 text-xs">
                                            min:{{ item.lowest_mark }}
                                        </div>
                                    </td>
                                    <td>
                                        <a-button
                                            type="primary"
                                            shape="circle"
                                            @click="show_update(item)"
                                            size="small"
                                            ><EditOutlined
                                        /></a-button>
                                        <a-button
                                            type="primary"
                                            shape="circle"
                                            @click="removeUser(item)"
                                            size="small"
                                            class="mx-8"
                                            danger
                                            ><DeleteOutlined
                                        /></a-button>
                                    </td>

                                    <!-- <td>
                                        <MinusCircleOutlined
                                            @click="removeUser(item)"
                                        />
                                    </td> -->
                                </tr>
                            </tbody>
                            <tfoot v-if="props.data['data_title_sum']">
                                <tr>
                                    <th>
                                        {{ lang == "en" ? "sum" : "المجموع" }}
                                    </th>

<th>

                                        {{
                                            lang == "en"
                                                ? props.data['data_title_sum']["en"]
                                                : props.data['data_title_sum']["ar"]
                                        }}
                                        <div class="p-0 text-gray-400 text-xs">
                                            {{
                                                lang == "en"
                                                    ? props.data['data_title_sum']["ar"]
                                                    : props.data['data_title_sum']["en"]
                                            }}
                                            <br />
                                            <div
                                                class="p-0 text-2xs text-gray-300"
                                            >
                                                {{ props.data['data_title_sum']["detail"] }}
                                            </div>
                                        </div>


</th>

                                    <th>{{ props.data['data_title_sum']['highest_mark'] }}




                                    </th>
<th>
                                        <div class="p-0 text-gray-200 text-xs">
                                            min:{{ props.data['data_title_sum']['lowest_mark'] }}

                            <a-input-number
                                v-model:value="props.data['data_title_sum']['lowest_mark']"
                                @change="title_sum()"
                            ></a-input-number>
                                        </div>

</th>
                                    <!-- <th>
                                        <a-button
                                            type="primary"
                                            shape="circle"
                                            @click="show_update(item)"
                                            size="small"
                                            ><EditOutlined
                                        /></a-button>
                                        <a-button
                                            type="primary"
                                            shape="circle"
                                            @click="removeUser(item)"
                                            size="small"
                                            class="mx-8"
                                            danger
                                            ><DeleteOutlined
                                        /></a-button>
                                    </th> -->

                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- title=" " -->
                    <a-button
                        type="primary"
                        class="m-2"
                        shape="circle"
                        @click="add_record()"
                        ><PlusOutlined
                    /></a-button>
                     <!-- v-model="" -->
<!-- <details>
  <summary>

  </summary>
  <pre dir="ltr" >{{ JSON.stringify(props.data['my_subject_title'], null, 2) }}</pre>
</details> -->
                      <select v-model="array_copy" @change="add_record_copy()" >
                      <option v-for="(item,index) in props.data['titles']" :key="index" :value="item">{{item.ar}}</option>
                     </select>

                    <a-form-item
                        has-feedback
                        :label="lang == 'en' ? 'notes' : 'ملاحظات'"
                        name="notes"
                    >
                        <a-input
                            v-model:value="props.data.notes"
                            type="text"
                            autocomplete="off"
                        />
                    </a-form-item>
                    <!-- :wrapper-col="{ span: 14, offset: 4 }" -->

                    <div class="flex">
                        <a-button
                            class="mx-1"
                            type="primary"
                            html-type="submit"
                            @click="save_update()"
                        >
                            {{ lang == "en" ? " Save " : " حفظ التعديل  " }}
                        </a-button>

                        <!-- <a-button
                            class="mx-1"
                            type="primary"
                            html-type="submit"
                            @click="save_update_without_titles()"
                        >
                            {{ lang == "en" ? " Save without titles" : "without titles  حفظ التعديل  " }}
                        </a-button> -->

                        <a-button class="mx-1" @click="$emit('cancel')">
                            {{ lang == "en" ? " Cancel" : " الغاء    " }}
                        </a-button>
                    </div>
                </a-form>
            </a-card>
        </a-badge-ribbon>

        <!-- ///////////////////open_update///////////////////////// -->
        <a-modal
            :dir="lang == 'en' ? 'ltr' : 'rtl'"
            v-model:open="open_update"
            :maskClosable="false"
            @ok="open_update = !open_update;title_sum ()"
            class="flex"
        >
            <table
                class="border-0 w-100 px-8"
                :dir="lang == 'en' ? 'ltr' : 'rtl'"
            >
                <tr>
                    <td>
                        <div>{{ tr("ar") }}</div>
                        <a-input v-model:value="data_update['ar']" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <div>{{ tr("en") }}</div>
                        <a-input v-model:value="data_update['en']" />
                    </td>
                </tr>

                <tr>
                    <td>
                        <div>
                            {{ tr("detail") }}
                        </div>
                        <a-input v-model:value="data_update['detail']" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="flex justify-between">
                            <div class="p-0">{{ tr("is_final") }}:</div>
                            <a-switch
                                size="small"
                                v-model:checked="data_update['is_final']"
                                :unCheckedValue="0"
                                :checkedValue="1"

                            />
                        </div>
                    </td>
                </tr>
                <!-- <tr>
                    <td>
                        <div class="flex justify-between">
                            <div class="p-0">{{ tr("is_total") }}:</div>

                            <a-switch
                                size="small"
                                v-model:checked="data_update['is_total']"
                                :unCheckedValue="0"
                                :checkedValue="1"

                            />
                        </div>
                    </td>
                </tr> -->
            </table>

            <table
                class="border-0 w-100 px-8"
                :dir="lang == 'en' ? 'ltr' : 'rtl'"
            >
                <tr>
                    <td>
                        <div class="flex p-1 justify-between">
                            <div class="p-1">
                                <span class="px-1 text-red-400">*</span
                                >{{ tr("max") }}
                            </div>
                            <a-input-number
                                v-model:value="data_update['highest_mark']"

                            ></a-input-number>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="flex p-1 justify-between">
                            <div class="p-1">
                                <span class="px-1 text-transparent">*</span
                                >{{ tr("min") }}
                            </div>
                            <a-input-number
                                v-model:value="data_update['lowest_mark']"
                            ></a-input-number>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="flex justify-between">
                            <div class="p-0">{{ tr("is_calc") }}:</div>

                            <a-switch
                                size="small"
                                v-model:checked="data_update['is_calc']"
                                :unCheckedValue="0"
                                :checkedValue="1"

                            />
                        </div>
                    </td>
                </tr>
            </table>
        </a-modal>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import form_update_add_col from "./form_update_add_col.vue";
const props = defineProps(["open_me", "data", "lang"]);
const emit = defineEmits(["save_update", "cancel"]);
const open_update = ref(false);
const data_update = ref({});
import { message } from "ant-design-vue";

import {
    PlusOutlined,
    MinusCircleOutlined,
    DeleteOutlined,
    EditOutlined,
} from "@ant-design/icons-vue";
import { useAppStore } from "@/stores/appstore";
const Ap = useAppStore();
//
onMounted(() => {
    if(props.data.c_subject_title_sum){
props.data['data_title_sum']=props.data.c_subject_title_sum
    }else{
    props.data['data_title_sum']={'lowest_mark':null,'highest_mark':null}

    }

    // props.data.grades_array = props.data.grades.split(",").map(Number);
    // clear_values();
    title_sum ()
});
// const data_title_sum = ref({})
const cols = ref({
    detail: { col: "detail", en: "detail", show: true, ar: "تفاصيل" },
    ar: { col: "ar", en: "Name Arabic", show: true, ar: "الاسم عربي  " },
    en: { col: "en", en: "Name English", show: true, ar: "الاسم  English  " },
    highest_mark: {
        col: "highest_mark",
        en: "highest_mark",
        show: true,
        ar: "   الدرجة العظمي",
    },
    lowest_mark: {
        col: "lowest_mark",
        en: "lowest_mark",
        show: true,
        ar: "الحالة",
    },
    is_calc: {
        col: "is_calc",
        en: "calculated",
        show: true,
        ar: "يتم احتسابها",
    },
    is_final: {
        col: "is_final",
        en: "final",
        show: true,
        ar: "اختبار نهائي  ",
    },

    choose: {
        col: "choose",
        en: "choose",
        show: true,
        ar: " اختر ",
    },
    edit: {
        col: "edit",
        en: "Edit",
        show: true,
        ar: " تعديل ",
    },
    add_exam: {
        col: "add_exam",
        en: "Add Exam",
        show: true,
        ar: "  اضافة اختبار     ",
    },
    total_not_found: {
        col: "total not found",
        en: "total not found",
        show: true,
        ar: "  المجموع غير موجود        ",
    },
    total_duplicated: {
        col: "total duplicated",
        en: "total not found",
        show: true,
        ar: "  المجموع  متكرر          ",
    },
    highest_mark_empty: {
        col: "highest_mark_empty",
        en: "highest_mark_empty",
        show: true,
        ar: "الدرجة فارعة",
    },
    max: {
        col: "max",
        en: "Max",
        show: true,
        ar: " الدرجة العظمي  ",
    },
    min: {
        col: "min",
        en: "Min",
        show: true,
        ar: "الدرجة الصغري",
    },
    is_final_not_found: {
        col: "is_final_not_found",
        en: " final exam not_found",
        show: true,
        ar: " الاختبار النهائي غير محدد    ",
    },
    notes: { col: "notes", en: "notes", show: true, ar: "ملاحظات" },
});

const tr = (txt) => {
    // //console.log(props.lang);
    // //console.log(txt);
    // //console.log(cols.value);
    // //console.log(cols.value[txt]);

    return cols.value[txt]?.[props.lang] || txt;
};

const title_sum = () => {

//   props.data['data_title_sum']['lowest_mark']=0
  props.data['data_title_sum']['highest_mark']=0
    props.data.my_subject_title.forEach((e, key) => {
//       //console.log(e.is_calc);
//       //console.log(typeof e.highest_mark);
//  //console.log(typeof  props.data['data_title_sum']['lowest_mark']);
        if (e.is_calc == 1) {

            var num11=props.data['data_title_sum']['highest_mark'];
var num22=e.highest_mark;

if (num22==null){
num22=0
}
props.data['data_title_sum']['highest_mark']=num11+num22


        }


    });


}
const array_copy =ref({})
const add_record_copy = () => {
    // var data = {
    //     id: null,
    //     detail: null,
    //     ar: null,
    //     en: null,
    //     highest_mark: null,
    //     lowest_mark: null,
    //     is_calc: 1,
    //     is_final: 0,
    //     // is_total: 0,
    //     notes: null,
    // };
array_copy.value['id']=null
    //   "id": 1,
    //   "admin_id": 1,
    //   "school_id": 4,
    //   "semester_id": 8,
    //   "subject_id": 1,
    //   "sequence": 1,
    //   "detail": "Participation/المشاركة",
    //   "ar": "المشاركة",
    //   "en": "Participation",
    //   "highest_mark": 15,
    //   "lowest_mark": null,
    //   "is_calc": 1,
    //   "is_final": 0,
    //   "notes": null,
    //   "created_at": null,
    //   "updated_at": null



    props.data.my_subject_title.push(array_copy.value);
    title_sum ()
};

const add_record = () => {
    var data = {
        id: null,
        detail: null,
        ar: null,
        en: null,
        highest_mark: null,
        lowest_mark: null,
        is_calc: 1,
        is_final: 0,
        // is_total: 0,
        notes: null,
    };
    props.data.my_subject_title.push(data);
};
const removeUser = (item) => {
    if (!confirm("Are you sure?")) {
        return;
    }
    const index = props.data.my_subject_title.indexOf(item);
    if (index !== -1) {
        props.data.my_subject_title.splice(index, 1);
    }
    title_sum ()
};
const edit_mood = (item) => {
    if (item["isEditing"] == true) {
        item["isEditing"] = false;
    } else {
        item["isEditing"] = true;
    }

    // if(!confirm('Are you sure?')){return}
    //console.log(item["isEditing"]);
    //   const index = props.data.my_subject_title.indexOf(item);
    //   if (index !== -1) {
    //     props.data.my_subject_title.splice(index, 1);
    //   }
};

const layout = {
    labelCol: { span: 8 },
    wrapperCol: { span: 14 },
};
const formRef = ref();
// const grades = ref([])
const grades_fun = () => {
    //console.log(props.data);
    // props.data.grades_array = props.data.grades.split(",").map(Number);
    props.data.grades = props.data.grades_array.join(",");
    // return props.data.grades;
};

const show_update = (my_data) => {
    open_update.value = true;
    data_update.value = my_data;
};

const save_update = () => {
    title_sum ()
    //console.log(props.data);

    Ap.d(
        {
            fun: "save_update",
            data: props.data,
        },
        {
            route: "/api/school_admin/c_subject",
            msg: Ap.lang == "en" ? "Done with success" : "تم بنجاح",
            loading: true,
            res_ver: "save_update",
            msg_error: "msg_error",
            sys_error: true,
            log: true,
            d_fun: "save_update",
        }
    );

    // if (props.data.grades == "" || props.data.grades == null) {
    //     alert("choose grades");
    //     return;
    // }

    // if (props.data.name == "" || props.data.name_ar == "") {
    //     alert("Name is required");
    //     return;
    // }

    emit("show");
     emit('cancel')
};

const rules = {
    name: [{ required: true, trigger: "change" }],
    name_ar: [{ required: true, trigger: "change" }],
    grades: [{ required: true, trigger: "change" }],
    stage: [{ required: true, trigger: "change" }],
    // name: [{ required: true, trigger: "change" }],
    //   name: [{ required: true, validator: validatePass, trigger: 'change' }],
    //   checkPass: [{ validator: validatePass2, trigger: 'change' }],
    //   age: [{ validator: checkAge, trigger: 'change' }],
};
</script>
<style scoped>
.border-0 {
    border-width: 0px !important;
    background-color: transparent !important;
}

.border-0 tr {
    border-width: 0px !important;
    background-color: transparent !important;
}
.border-0 td {
    border-width: 0px !important;
    background-color: transparent !important;
}
</style>
