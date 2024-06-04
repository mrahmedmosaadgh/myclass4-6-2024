<template>
    <div>
        <div class="hidden h-0">{{ counter }}</div>

        <!-- {{ Ap.res?.school_list?.[0]["school_id"] }} -->

<button @click="Ap.d(
                            {
                                fun: 'show',
                                data: selected_school_id.value,
                            },
                            {
                                route: '/api/school_admin/add_school_exam_new',
                                msg:
                                    Ap.lang == 'en'
                                        ? 'Done with success'
                                        : 'تم بنجاح',
                                loading: true,
                                res_ver: 'school_exams',
                                msg_error: 'msg_error',
                                sys_error: true,
                                log: true,
                                d_fun: 'school_exams',
                            }
                        )">test</button>


        <a-form-item
            :label="Ap.lang == 'en' ? 'School' : 'المدرسة'"
            name="username"
        >
            <!-- :rules="[{ required: true, message: 'Please input your username!' }]" -->
            <div
                class="p-0"
                v-if="Ap.res.school_list && Ap.res.school_list.length < 2"
            >
                {{ Ap.res.school_list[0]["label"] }}
            </div>
            <div class="p-0" v-else>
                <a-select
                    style="min-width: 100%"
                    v-model:value="selected_school_id"
                    :defaultActiveFirstOption="true"
                    show-search
                    placeholder="input search text"
                    :options="Ap.res.school_list"
                    :fieldNames="{ label: 'label', value: 'id' }"
                    @change="
                        Ap.d(
                            {
                                fun: 'school_exams',
                                data: selected_school_id.value,
                            },
                            {
                                route: '/api/school_admin/add_school_exam_new',
                                msg:
                                    Ap.lang == 'en'
                                        ? 'Done with success'
                                        : 'تم بنجاح',
                                loading: true,
                                res_ver: 'school_exams',
                                msg_error: 'msg_error',
                                sys_error: true,
                                log: true,
                                d_fun: 'school_exams',
                            }
                        )
                    "
                ></a-select>
            </div>
        </a-form-item>
        <!-- Ap.res?.school_exams:{{ Ap.res?.school_exams[0]['semester_id'] }} -->
        <div
            class="p-0 w-full"
            v-if="Ap.res?.school_exams && selected_school_id"
        >
            <component
                :is="main_co"
                :data="Ap.res?.school_exams"
                :data_create="data_create"
                :my_mood1="mood2"
                @view="
                    Ap.d(
                        {
                            fun: 'school_exams',
                            data: selected_school_id,
                        },
                        {
                            route: '/api/school_admin/add_school_exam_new',
                            msg:
                                Ap.lang == 'en'
                                    ? 'Done with success'
                                    : 'تم بنجاح',
                            loading: true,
                            res_ver: 'school_exams',
                            msg_error: 'msg_error',
                            sys_error: true,
                            log: true,
                            d_fun: 'school_exams',
                        }
                    )
                "
                :settings="{
                    title: title,
                    lang: 'ar',
                    cols: cols,
                    // my_mood:mood,
                }"
                @save_update="fun_update($event)"
                @save_create="fun_create($event)"
                @save_delete="fun_delete($event)"
                @text_filter="fun_filter($event)"
            ></component>
        </div>

        <div class="p-12"></div>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";
import main_co from "./co/table4/main_co.vue";
// import table3 from "./co/table3/table.vue";

import { useAppStore } from "@/stores/appstore";
import { SearchOutlined } from "@ant-design/icons-vue";
// import { methodOf } from "lodash";
const props = defineProps(["data"]);

const Ap = useAppStore();
const selected_school_id = ref(null);
// const  semester_id = ref(Ap.res?.school_exams[0]['semester_id']);
const mood = ref("view");
const mood2 = ref({ my_mood: "view" });
const data_create = ref({
    teacher_start: "",
    teacher_end: "",
    student_start: "",
    student_end: "",
    name: "",
    name_ar: "",
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

    if (Ap.d_fun == "school_list") {
        selected_school_id.value = Ap.res?.school_list?.[0]["school_id"];
        if (!selected_school_id.value) {
            alert("no school selected");
            return;
        }

        Ap.d(
            {
                fun: "school_exams",
                data: selected_school_id.value,
            },
            {
                route: "/api/school_admin/add_school_exam_new",
                msg: Ap.lang == "en" ? "Done with success" : "تم بنجاح",
                loading: true,
                res_ver: "school_exams",
                msg_error: "msg_error",
                sys_error: true,
                log: true,
                d_fun: "school_exams",
            }
        );
        Ap.d_fun = null;
    }

    return Ap.d_counter;
});

const title = ref("<div class='p-0 red'></div>");
const cols = ref([
    { col: "name", en: "Name", show: true, ar: "Name" },
    { col: "name_ar", en: "Name Arabic", show: true, ar: "الاسم عربي  " },
    {
        col: "teacher_start",
        en: "teacher_start",
        show: true,
        ar: "بداية المعلم",
    },
    { col: "teacher_end", en: "teacher_end", show: true, ar: "نهاية المعلم" },
    {
        col: "student_start",
        en: "student_start",
        show: true,
        ar: "بداية الطالب",
    },
    { col: "student_end", en: "student_end", show: true, ar: "نهاية الطالب" },
    { col: "stage", en: "stage", show: true, ar: "مرحلة الطالب" },
    { col: "grades", en: "grades", show: true, ar: "الصفوف الدراسة" },
    // {col:'status'       ,       en:'status'       ,  show:true,   ar:'الحالة'           },
    { col: "notes", en: "notes", show: true, ar: "ملاحظات" },
]);

function my_schools_list() {
    Ap.d(
        {
            fun: "school_list",
            data: null,
        },
        {
            route: "/api/school_admin/add_school_exam_new",
            msg: Ap.lang == "en" ? "Done with success" : "تم بنجاح",
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
                semester_id: Ap.res?.school_exams[0]["semester_id"],
                data: event,
            },
            // data: {school_id:selected_school_id.value,data:data_create.value}
        },
        {
            route: "/api/school_admin/add_school_exam_new",
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
function fun_delete(event) {
    //console.log("fun_delete", event);
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
/* .ant-select-selection-overflow {
    display: flex!important;
    flex-direction: column!important;
   align-items: left !important;
   align-content: left !important;

}
.ant-select-selection-overflow-item{
display: flex !important;
 float: left  !important;
color: red!important;
width: 200px!important;
} */
</style>
