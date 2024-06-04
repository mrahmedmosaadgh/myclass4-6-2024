<template>
    <div>
vvvvvvvvvvvvvvvvvvvvvvvvvvvv
fffffffffffffff
        <div class="hidden h-0">{{ counter }}</div>


        <div class="p-0 w-full" v-if="data_edit?.['data']">
            <component
                :is="main_co"
                :data="data_edit?.['data']"
                :data_create="data_create"
                :my_mood1="mood2"
                @view="get_class_marks_db()"
                :settings="{
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
        </div>

        <div class="p-12"></div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import main_co from "./table4/main_co.vue";
import { useAppStore } from "@/stores/appstore";
const props = defineProps(["data_edit"]);
const Ap = useAppStore();
 
const data_to_get_class_marks = ref({});

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
            fun: "class_marks2",
            data: data_to_get_class_marks.value,
        },
        {
            route: "/api/teacher_marks_edit",
            msg: Ap.lang == "en" ? "Done with success" : "تم بنجاح",
            loading: true,
            res_ver: "class_marks2",
            msg_error: "msg_error",
            sys_error: true,
            log: true,
            d_fun: "class_marks2",
        }
    );
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
                semester_id: data_edit["data"][0]["semester_id"],
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

