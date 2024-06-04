<template>
    <div>
        <div class="hidden h-0">{{ counter }}</div>
<!-- <div class="p">
{{edit_subjects_data}}
    {{classroom}}




</div> -->
        <a-button
            type="primary"
            @click="show_insert_classroom = !show_insert_classroom"
            ><PlusOutlined
        /></a-button>
        <br />
        count:{{ Ap.res?.c_my_classes?.["c_classes"]?.length }}
        <div class="rounded overflow-x-auto w-full m-auto">
            <table cellspacing="0" class="tg w-full">
                <thead class="">
                    <!-- <tr  >
                        <th colspan="32" class="no-border_background pt-4">

                            <div class="p-0 text-center w-full"></div>
                        </th>
                    </tr> -->
                    <tr>
                        <th>
                            #
                            <a-button
                            @click=" show_my_classes();"
                type="text"
                size="small"
                style="padding: 0px"
                class="noprint  "
                >
                
                <ReloadOutlined style="padding: 0px; margin: 0px; width: 12px"
            />
            <!-- <div class="p-0 text-xs"> </div> -->
                                  
                               
        
        </a-button>
                       <!-- <div class="p-0">refresh</div>  -->
                        </th>

                        <th class="w-24">
                            {{ Ap.lang == "en" ? "Name" : "الاسم" }}
                        </th>

                        <th class="w-12">
                            {{ Ap.lang == "en" ? "grade" : "الصف" }}
                        </th>
                        <th class="w-12">
                            {{ Ap.lang == "en" ? "Teacher" : "المعلم" }}
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="(item, index) in Ap.res?.c_my_classes?.[
                            'c_classes'
                        ]"
                        :key="index"
                        :class="{
                            even: (index + 1) % 2 === 0,
                            selected: item['select'] == 1,
                        }"
                    >
                        <td class="w-8">
                    
                        
                       
                       
                       
                       
                            <div class="flex flex-row  ">
        <a-popover trigger="click"  >
            <template #content>
                <div class="text-left w-40 flex whitespace-nowrap">
              
                    <a-button
                        type="primary"
                        size="small"
                        @click="fun_update(item)"
                        class="w-full m-1 rounded px-1"
                        ><EditOutlined
                    /></a-button>
                    <a-button
                        type="primary"
                        danger
                        size="small"
                        @click="fun_delete(item)"
                        class="w-full m-1 rounded px-1"
                        ><DeleteOutlined
                    /></a-button>


                </div>

            </template>
            <a-button
                type="text"
                size="small"
                style="padding: 0px"
                class="noprint  "
                ><MoreOutlined style="padding: 0px; margin: 0px; width: 12px"
            />
            <!-- <div class="p-0 text-xs"> </div> -->
                                    {{ index + 1 }}
                               
        
        </a-button>
        </a-popover>
    </div>
                       
                       
                       
                       
                       
                       
                       
                       
                       
                        </td>
                        <td class="w-24">
                            <div
                                class="p-0"
                                :title="
                                    Ap.lang == 'en'
                                        ? item['ar'] + ' ' + item['detail']
                                        : item['en'] + ' ' + item['detail']
                                "
                            >
                                {{ Ap.lang == "en" ? item["en"] : item["ar"] }}
                            </div>
                        </td>

                        <td>
                            <select
                                class="p-2"
                                v-model="item['grade_id']"
                                @change="update_class_grade(item)"
                            >
                                <option
                                    v-for="(item, index) in Ap.res
                                        ?.c_my_classes?.['c_grades']"
                                    :key="index"
                                    :value="item.id"
                                >
                                    {{
                                        item.ar +
                                        " || " +
                                        item.en +
                                        " || " +
                                        item.detail
                                    }}
                                </option>
                            </select>
                        </td>
                        <td>
                            <a-button
                                type="primary"
                                class="relative px-3 py-1 blue rounded  "
                                @click="
                                    show_edit_subjects_fun(item, item['detail'])
                                "
                            >
                                <!-- ------------------------------------------------ -->
                                <a-tooltip color="purple">
                                    <template #title>
                                        <table class="w-full hover_me">
                                            <tr
                                                v-for="(
                                                    item_sub, index
                                                ) in item?.['my_subjects']"
                                                :key="index"
                                            >
                                                <td>{{ item?.ar }}</td>
                                                <td class="text-2xs">
                                                    {{
                                                        item_sub["my_subject"]
                                                            ?.ar
                                                    }}
                                                </td>
                                                <td
                                                    class="text-2xs whitespace-nowrap"
                                                >
                                                    <!-- {{ item_sub["my_teacher"] }} -->
                                                    {{
                                                        item_sub["my_teacher"]
                                                            ?.ar
                                                    }}
                                                </td>
                                            </tr>
                                        </table>
                                    </template>
                                    <a-badge
                                        class="text-2xs absolute -top-4 left-0 scale-75"
                                        dir="ltr"
                                        :count="item?.['my_subjects']?.length"
                                        :number-style="{
                                            backgroundColor: 'purple',
                                            // backgroundColor: '#52c41a',
                                        }"
                                    />
                                </a-tooltip>
                                <!-- ------------------------------------------------ -->

                                <EditOutlined
                                    @click="
                                        show_edit_subjects_fun(item, item['detail'])
                                    "
                                />
 
                                <!-- {{ item?.["my_subjects"]?.length }} -->
                            </a-button>
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

            <a-modal v-if="show_edit_subjects_modal"
                v-model:open="show_edit_subjects_modal"
                :title="classroom"
                @ok="update_join_class_teacher_subject()"
            >
                <!-- <template #footer>
                    <a-button
                        key="back"
                        @click="
                            show_edit_subjects_modal = !show_edit_subjects_modal
                        "
                        >Return</a-button
                    >
                    <a-button
                        key="submit"
                        type="primary"
                        :loading="loading"
                        @click="
                            show_edit_subjects_modal = !show_edit_subjects_modal
                        "
                        >Submit</a-button
                    >
                </template> -->
                <!-- <p>{{ edit_subjects_data }}</p> item.detail -->
                <c_class_join_class_subject_teacher
                    :data="edit_subjects_data"
                    :classroom="classroom"
                    :my_teachers="Ap.res?.c_my_classes?.hrschooluser"
                    :subjects="Ap.res?.c_my_classes?.c_subjects"
                    >c_class_join_class_subject_teacher
                    err</c_class_join_class_subject_teacher
                >
            </a-modal>

            <!-- add new  _____________________ -->
            <a-modal
                v-model:open="show_insert_classroom"
                @ok="insert_classroom()"
            >
                <!-- admin_id school_id grade_id detail ar en -->
                <!-- :rules="rules"
                v-bind="layout"
                @finish="handleFinish"
                @validate="handleValidate"
                @finishFailed="handleFinishFailed" -->

                <a-form
                    dir="ltr"
                    ref="formRef"
                    name="custom-validation"
                    :model="classroom_data_new"
                >
                    <a-form-item
                        name="grade_id"
                        label="Select"
                        has-feedback
                        :rules="[
                            {
                                required: true,
                                message: 'Please select classroom!',
                            },
                        ]"
                    >
                        <a-select
                            v-model:value="classroom_data_new.grade_id"
                            placeholder="Please select a grade"
                        >
                            <a-select-option
                                v-for="grade in Ap.res?.c_my_classes?.[
                                    'c_grades'
                                ]"
                                :value="grade.id"
                                >{{ grade.ar }}</a-select-option
                            >
                        </a-select>
                    </a-form-item>

                    <a-form-item
                        label="name ar"
                        name="ar"
                        has-feedback
                        :rules="[
                            {
                                required: true,
                                message: 'Please input   name ar!',
                            },
                        ]"
                    >
                        <a-input v-model:value="classroom_data_new.ar" />
                    </a-form-item>

                    <a-form-item
                        label="name en"
                        name="en"
                        has-feedback
                        :rules="[
                            {
                                required: true,
                                message: 'Please input   name en!',
                            },
                        ]"
                    >
                        <a-input v-model:value="classroom_data_new.en" />
                    </a-form-item>

                    <a-form-item
                        label="detail"
                        name="detail"
                        has-feedback
                        :rules="[
                            {
                                required: true,
                                message: 'Please input   detail!',
                            },
                        ]"
                    >
                        <a-input v-model:value="classroom_data_new.detail" />
                    </a-form-item>
                </a-form>

                <!-- <c_class_join_class_subject_teacher
                    :data="edit_subjects_data"
                    :classroom="classroom"
                    :my_teachers="Ap.res?.c_my_classes?.hrschooluser"
                    :subjects="Ap.res?.c_my_classes?.c_subjects"
                    >c_class_join_class_subject_teacher
                    err</c_class_join_class_subject_teacher
                > -->
            </a-modal>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
// import main_co from "./co/table4/main_co.vue";
// import dashboard from "./co/teacher_dashboard_com.vue";
import { EditOutlined, PlusOutlined,MoreOutlined,DeleteOutlined ,ReloadOutlined} from "@ant-design/icons-vue";

import c_class_insert from "./co/c_class_insert.vue";
import c_class_join_class_subject_teacher from "./co/c_class_join_class_subject_teacher.vue";

// resources/js/pages/hr/school_admin/school_setup/classroom/co/c_class_insert.vue

import { useAppStore } from "@/stores/appstore";
const Ap = useAppStore();
const activeKey = ref([]);
const data_to_get_class_marks = ref({});
const open_change_sequence = ref(false);
const current_sequence = ref(null);
const up_sequence = ref(null);
const school_id = ref(Ap.res?.c_my_classes?.["c_classes"]?.[0]?.["school_id"]);
const classroom = ref(null);
const classroom_data_new = ref({});
onMounted(() => {
    show_my_classes();
});

const show_edit_subjects_modal = ref(false);
const edit_subjects_data = ref({});
const show_edit_subjects_fun = (item, my_classroom) => {
    //console.log(item, my_classroom);
    edit_subjects_data.value = item;
    classroom.value = my_classroom;
    show_edit_subjects_modal.value = true;
    // if (!confirm("Are you sure!")) {
    //     return;
    // }
};





function fun_delete(event) {
    Ap.d(
        {
            fun: "delete",
            data: {
                // school_id: selected_school_id.value,
                data: event,
            },
            // data: {school_id:selected_school_id.value,data:data_create.value}
        },
        {
            route: "/api/school_admin/c_class",
            msg:
                Ap.lang == "en"
                    ? "delete Done with success"
                    : " delete تم بنجاح",
            loading: true,
            res_ver: "view",
            msg_error: "msg_error",
            sys_error: true,
            log: true,
            d_fun: "view",
        }
    );
}








const update_class_grade = (item) => {
    //console.log(item);

    if (!confirm("Are you sure!")) {
        return;
    }
    Ap.d(
        {
            fun: "update_class_grade",
            data: item,
            // data: {school_id:selected_school_id,class_id:class_id},
        },
        {
            route: "/api/school_admin/c_class",
            msg: Ap.lang == "en" ? "Done with success" : "تم بنجاح",
            loading: true,
            res_ver: "update_class_grade",
            msg_error: "msg_error",
            sys_error: true,
            log: true,
            d_fun: "update_class_grade",
        }
    );

    //console.log("item");
};

const show_insert_classroom = ref(false);

const insert_classroom = () => {
    classroom_data_new.value["school_id"] = school_id.value;

    //console.log("insert_classroom");
    if (!confirm("Are you sure!")) {
        return;
    }
    Ap.d(
        {
            fun: "insert_classroom",
            data: classroom_data_new.value,
            // data: {school_id:selected_school_id,class_id:class_id},
        },
        {
            route: "/api/school_admin/c_class",
            msg: Ap.lang == "en" ? "Done with success" : "تم بنجاح",
            loading: true,
            res_ver: "insert_classroom",
            msg_error: "msg_error",
            sys_error: true,
            log: true,
            d_fun: "insert_classroom",
        }
    );
    show_insert_classroom.value=!show_insert_classroom.value
};

const update_join_class_teacher_subject = () => {
    show_edit_subjects_modal.value = !show_edit_subjects_modal.value;
    if (!confirm("Are you sure!")) {
        return;
    }
    Ap.d(
        {
            fun: "update_join_class_teacher_subject",
            data: edit_subjects_data.value,
            // data: {school_id:selected_school_id,class_id:class_id},
        },
        {
            route: "/api/school_admin/c_class",
            msg: Ap.lang == "en" ? "Done with success" : "تم بنجاح",
            loading: true,
            res_ver: "update_join_class_teacher_subject",
            msg_error: "msg_error",
            sys_error: true,
            log: true,
            d_fun: "update_join_class_teacher_subject",
        }
    );
};

const change_sequence_fun = () => {
    start_my_mood.value = !start_my_mood.value;
    var counter = 1;
    Ap.res?.c_my_classes?.["c_classes"].forEach((element, key) => {
        element["sequence"] = counter;
        counter++;
    });
};

const first_place1 = ref(null);
const to_place1 = ref(null);
const my_mood = ref(false);
const start_my_mood = ref(false);
const first_place = (index) => {
    my_mood.value = true;

    first_place1.value = index;
    open_change_sequence.value = !open_change_sequence.value;
};

const move_here = (index) => {
    // up_sequence.value=Ap.res?.c_my_classes?.['c_classes'][index]['sequence']

    var new_sequence = Ap.res?.c_my_classes?.["c_classes"]?.[index]?.["sequence"];
    //   var old_sequence=Ap.res?.c_my_classes?.['c_classes']?.[first_place1.value]?.['sequence']

    // Ap.res.my_classes['c_classes'][index]['sequence']=old_sequence
    Ap.res.my_classes["c_classes"][first_place1.value]["sequence"] =
        new_sequence - 1;
    //console.log(Ap.res.my_classes["c_classes"], index);

    Ap.res.my_classes["c_classes"].sort((a, b) => a.sequence - b.sequence);

    var counter = 1;
    Ap.res?.c_my_classes?.["c_classes"].forEach((element, key) => {
        if (index == key) {
        }
        element["sequence"] = counter;
        counter++;
    });

    // //   var items = Ap.res.my_classes['c_classes'];
    //   var item = Ap.res.my_classes['c_classes'].splice(first_place1.value, 1)[0];

    //   // Insert the item at index 3
    //   Ap.res.my_classes['c_classes'].splice(index, 0, item);
    // //   Ap.res.my_classes['c_classes']=items

    //console.log("done");
    my_mood.value = false;

    // open_change_sequence.value=!open_change_sequence.value
};

const show_my_classes = () => {
    Ap.d(
        {
            fun: "show",
            data: null,
            // data: {school_id:selected_school_id,class_id:class_id},
        },
        {
            route: "/api/school_admin/c_class",
            msg: Ap.lang == "en" ? "Done with success" : "تم بنجاح",
            loading: true,
            res_ver: "c_my_classes",
            msg_error: "msg_error",
            sys_error: true,
            log: true,
            d_fun: "c_my_classes",
        }
    );
};

// const  semester_id = ref(Ap.res?.class_marks[0]['semester_id']);
const mood = ref("view");
const mood2 = ref({ my_mood: "view" });
const data_create = ref({
    teacher_start: "",
    teacher_end: "",
    student_start: "",
    student_end: "",
    en: "",
    ar: "",
    stage: null,
    grades: "",
    notes: null,
});
// "id": 2, "admin_id": 1, "school_id": 4, "semester_id": 1,

const counter = computed(() => {
    if (Ap.d_fun == "create") {
        mood.value = "view";
        mood2.value["my_mood"] = "view";
    }

    if (Ap.d_fun == "create") {
        mood.value = "view";
        mood2.value["my_mood"] = "view";
    }

    if (Ap.d_fun == "save_all") {
        show_my_classes();
        get_class_marks(get_class_marks_data.value);
    }

    // if (Ap.d_fun == "school_list") {
    //     selected_school_id.value = Ap.res?.school_list?.[0]["school_id"];
    //     if (!selected_school_id.value) {
    //         alert("no school selected");
    //         return;
    //     }

    //     // Ap.d(
    //     //     {
    //     //         fun: "class_marks",
    //     //         data: selected_school_id.value,
    //     //     },
    //     //     {
    //     //         route: "/api/teacher_marks_edit",
    //     //         msg: Ap.lang == "en" ? "Done with success" : "تم بنجاح",
    //     //         loading: true,
    //     //         res_ver: "class_marks",
    //     //         msg_error: "msg_error",
    //     //         sys_error: true,
    //     //         log: true,
    //     //         d_fun: "class_marks",
    //     //     }
    //     // );
    //     Ap.d_fun = null;
    // }

    return Ap.d_counter;
});

const get_class_marks_data = ref([]);
const get_class_marks = (event) => {
    get_class_marks_data.value = event;
    data_to_get_class_marks.value["school_id"] = event.school_id;
    data_to_get_class_marks.value["subject_id"] = event.subject_id;
    data_to_get_class_marks.value["class_id"] = event.class_id;
    get_class_marks_db();
};

const get_class_marks_db = () => {
    //console.log("data", data_to_get_class_marks.value);

    Ap.d(
        {
            fun: "class_marks",
            data: data_to_get_class_marks.value,
        },
        {
            route: "/api/teacher_marks_edit",
            msg: Ap.lang == "en" ? "Done with success" : "تم بنجاح",
            loading: true,
            res_ver: "class_marks",
            msg_error: "msg_error",
            sys_error: true,
            log: true,
            d_fun: "class_marks",
        }
    );
};

function my_schools_list() {
    Ap.d(
        {
            fun: "school_list",
            data: null,
        },
        {
            route: "/api/teacher_marks_edit",
            msg: null,
            // msg: Ap.lang == "en" ? "Done with success" : "تم بنجاح",
            loading: true,
            res_ver: "school_list",
            msg_error: "msg_error",
            sys_error: true,
            log: true,
            d_fun: "school_list",
        }
    );
}
my_schools_list();

function fun_update(event) {
    //console.log("fun_update________________", event);
}
function fun_create(event) {
    //console.log("fun_create", event);
    if (!selected_school_id.value) {
        alert("no school selected");
        return;
    }
    Ap.d(
        {
            fun: "create",
            data: {
                school_id: selected_school_id.value,
                semester_id: Ap.res?.class_marks["data"][0]["semester_id"],
                data: event,
            },
            // data: {school_id:selected_school_id.value,data:data_create.value}
        },
        {
            route: "/api/teacher_marks_edit",
            msg:
                Ap.lang == "en"
                    ? "create Done with success"
                    : " create تم بنجاح",
            loading: true,
            res_ver: "create",
            msg_error: "msg_error",
            sys_error: true,
            log: true,
            d_fun: "create",
        }
    );
}

function fun_filter(event) {
    //console.log("fun_filter", event);
}

function fun_before(fun) {}

function fun_next(res, fun) {}
function fun_db(data) {
    if (!data.route) {
        Ap.ms("error", "empty route", 1, 1);
    }
    fun_before(data.fun);
    try {
        axios.post(data.route, data).then((res) => {
            Ap.ms("success", "loading done", 1, 1);
            //console.log("db", res.data);
            fun_next(res.data, data.fun);
        });
    } catch (e) {
        //console.log(e);
        Ap.ms("error", "loading error", 1, 1);
    }
}
</script>
<style scoped>
.hover_me tr:hover {
    background-color: black;
    scale: 1.2;
}
</style>
