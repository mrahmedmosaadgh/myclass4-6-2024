<template>
    <div>xxxxxxxxxxxxxx
        <!-- resources\js\pages\hr\school_admin\new\data\c_teacher\teacher_marks_edit\teacher_marks_edit.vue -->
        <div class="text-center red" v-if="Ap.res?.show?.my_classes?.length == 0">
            <div class="p-2">No classes found</div>
            <div class="p-2">لا يوجد فصول</div>
        </div>

        <div class="hidden h-0">{{ counter }}</div>

        <div class="p-0 overflow-auto h-64">
            <dashboard class="red bg-transparent border" :data="{ lang: Ap.lang }" @view="get_class_marks($event)">
            </dashboard>
            <!-- @class_id="get_class_marks($event)" -->
        </div>

        <!-- <div class="p-0 w-full" v-if="Ap.res?.class_marks?.['data']">
            <component
                :is="main_co"
                :data="Ap.res?.class_marks?.['data']"
                :data_create="data_create"
                :my_mood1="mood2"
                @view="get_class_marks_db()"
                :settings="{resources/js/pages/hr/school_admin/new/data/c_teacher/teacher_marks_edit/teacher_marks_edit.vue
                    title: title,
                    lang: 'ar',
                    cols: cols,
                    can_edit: false,
                    can_new: false,
                }"
                @save_update="show_my_classes()"
                @save_create="fun_create($event)"
                @save_delete="fun_delete($event)"
                @text_filter="fun_filter($event)"
            ></component>
        </div> v-if="pass=='ksa1234'"-->
        <!-- <input type="text" v-model="pass"> -->
        <marks_edit 
        :data_edit="data_edit"
        >
        marks_edit err
        </marks_edit>
        <div class="p-12"></div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
// import main_co from "./co/table4/main_co.vue";
import dashboard from "./co/teacher_dashboard_com.vue";
// import c_subject_marks_print_table from "@/pages/hr/school_admin/new/reports/c_marks/c_print/co/c_subject_marks_print_table.vue";
import message from 'vue-m-message'

import marks_edit from "./co/marks_edit.vue";
//resources/js/pages/hr/school_admin/new/data/c_marks/c_print/marks_edit.vue
import { useAppStore } from "@/stores/appstore";
// import { SearchOutlined } from "@ant-design/icons-vue";
const props = defineProps(["data"]);
const Ap = useAppStore();
const selected_school_id = ref(null);
const class_id = ref(null);
const pass = ref(null);
const data_to_get_class_marks = ref({});

onMounted(() => {
    show_my_classes();
});
const show_my_classes = () => {
    Ap.d(
        {
            fun: "show",
            data: null,
            // data: {school_id:selected_school_id,class_id:class_id},
        },
        {
            route: "/api/teacher_marks_edit",
            msg: Ap.lang == "en" ? "Done with success" : "تم بنجاح",
            loading: true,
            res_ver: "show",
            msg_error: "msg_error",
            sys_error: true,
            log: true,
            d_fun: "show",
        }
    );
};

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
    if (!event.class_id) {
        alert("no class selected");
        return;
    }

    get_class_marks_db();
};

const data_edit = ref({})
const get_class_marks_db = () => {

    //console.log("data", data_to_get_class_marks.value);

    // Ap.d(
    //     {
    //         fun: "class_marks2",
    //         data: data_to_get_class_marks.value,
    //     },
    //     {
    //         route: "/api/teacher_marks_edit",
    //         msg: Ap.lang == "en" ? "Done with success" : "تم بنجاح",
    //         loading: true,
    //         res_ver: "class_marks2",
    //         msg_error: "msg_error",
    //         sys_error: true,
    //         log: true,
    //         d_fun: "class_marks2",
    //     }
    // );


    /////////////////////////



    var db_data = {
        fun: "class_marks2",
        data: data_to_get_class_marks.value,
    }


    var options = {
        route: "/api/teacher_marks_edit",
        msg: Ap.lang == "en" ? "Done with success" : "تم بنجاح",
        loading: true,
        res_ver: "class_marks2",
        msg_error: "msg_error",
        sys_error: true,
        log: true,
        d_fun: "class_marks2",
    }


    options.loading ? (Ap.loading = true) : (Ap.loading = false);

    axios
        .post(options.route, { data: db_data })
        .then((response) => {
            data_edit.value = response.data

            Ap.d_counter++;
            Ap.d_fun = options.d_fun;

            if (options.res_ver) {
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

















};

const title = ref(null);
// const title = ref("<div class='p-0 red'>hi</div>");
const cols = ref([
    // { col: "ar", en: "Name", show: true, ar: "Name" },
    { col: "ar", en: "Name Arabic", show: true, ar: "الاسم عربي  " },
    {
        col: "en",
        en: "teacher_start",
        show: true,
        ar: "بداية المعلم",
    },
    // { col: "teacher_end", en: "teacher_end", show: true, ar: "نهاية المعلم" },
    // {
    //     col: "student_start",
    //     en: "student_start",
    //     show: true,
    //     ar: "بداية الطالب",
    // },
    // { col: "student_end", en: "student_end", show: true, ar: "نهاية الطالب" },
    // { col: "stage", en: "stage", show: true, ar: "مرحلة الطالب" },
    // { col: "grades", en: "grades", show: true, ar: "الصفوف الدراسة" },
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
                semester_id: Ap.res?.class_marks2["data"][0]["semester_id"],
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














function fun_delete(event) {
    //console.log("fun_delete", event);
}
function fun_filter(event) {
    //console.log("fun_filter", event);
}

function fun_before(fun) { }

function fun_next(res, fun) { }
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
