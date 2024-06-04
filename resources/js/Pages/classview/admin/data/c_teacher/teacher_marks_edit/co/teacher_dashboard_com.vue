<template>
   <!-- resources\js\pages\hr\school_admin\new\data\c_teacher\teacher_marks_edit\co\teacher_dashboard_com.vue -->
   






   <div class="flex flex-wrap justify-center gap-2     ">
        <a-card class="hover:opacity-80 " :class="index==selected_card?' opacity-100   shadow2 ':' opacity-50  ' "
        @click="change_class(index,item)"
            size="small"
            style="width: 150px; height: 200px"
            hoverable
            v-for="(item, index) in Ap.res?.show?.my_classes"
            :key="index"
            :dir="Ap.lang == 'en' ? 'lrt' : 'rtl'"
        >

  
<corner  :text="Ap.lang == 'en' ? item.my_subject.en : item.my_subject.ar" color="purple"></corner>

        <!-- <div class="  speech-bubble">hhhh</div> -->
 
            <!-- <template #extra><a href="#">more</a></template> -->
            <div class=" pb-3 text-xl text-center rounded">
            <!-- <div class="pt-8 pb-3 text-xl text-center rounded"> -->
                <!-- title=" " -->

                <a-tooltip placement="top">
                    <template #title>
                        <span> click to show </span>
                    </template>

                    <!-- <a-badge size="small" class="m-1   " dir="ltr" :count="20" color="purple" title="Custom hover text">
  </a-badge> -->
  <div class="h-8 relative   "></div>
                    <div class="p-0 flex relative justify-center" >
                        <div
                            class="  px-2   relative bg-blue-600 rounded-full text-white text-xl   hover:scale-125 cursor-pointer"
                        >

                            {{ item.label }}
                            <!-- <EyeOutlined class=" absolute w-4 left-4 opacity-5" /> -->
                        </div>
                        <!-- students number _________________________________________________________ -->

                        <div
                            class="flex justify-center absolute top-10 pb-1 left-4"
                        >
                            <div
                                dir="ltr"
                                class="flex ltr text-xs text-gray-400 w-fit px-2 p-1 rounded-full"
                            >
                                <!-- :number="item['count']" -->
                                <animate_number
                                    class="px-1"
                                    :duration="100"
                                    :number="item['count']"
                                    >animate_number err templa</animate_number
                                >

                                <div
                                    class="p-0 text-2xs whitespace-nowrap text-gray-400"
                                    :dir="Ap.lang == 'en' ? 'ltr' : 'rtl'"
                                >
                                    {{
                                        Ap.lang == "en"
                                            ? "students:"
                                            : "عدد الطلاب :"
                                    }}
                                </div>
                            </div>
                        </div>
                        <!-- students number _________________________________________________________ -->
                    </div>
                </a-tooltip>

                <!-- <template #title>

     DFDS
    </template> -->
                <!-- <a-card title="Pushes open the window" size="small">and raises the spyglass.</a-card> -->
                <!-- title="Default size card" -->

                <a-progress class="scale-50" type="circle" :percent=" item['class_marks_finished_percent']" />
            </div>
        </a-card>

        <!-- :percent="
                                        item['class_marks_finished_percent']
                                    " -->
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";

// import table3 from "./co/table3/table.vue";
import { EyeOutlined } from "@ant-design/icons-vue";

import { useAppStore } from "@/stores/appstore";
import animate_number from "@/components/best/animate_number.vue";
import corner from "./corner.vue";
// resources\js\pages\hr\school_admin\new\data\c_teacher\teacher_marks_edit\co\corner.vue

// import { methodOf } from "lodash";
// @/components/best/animate_number.vue
const props = defineProps(["data"]);
const emits = defineEmits(["view"]);

const Ap = useAppStore();
const selected_school_id = ref(null);
const class_id = ref(null);
const student_count = ref([]);
const selected_card = ref(-1);

onMounted(() => {
    Ap.d(
        {
            fun: "show",
            data: null,
            // data: {school_id:selected_school_id,class_id:class_id},
        },
        {
            route: "/api/teacher_marks_edit",
            msg: null,
            // msg: Ap.lang == 'en' ? 'Done with success' : 'تم بنجاح',
            loading: true,
            res_ver: "show",
            msg_error: "msg_error",
            sys_error: true,
            log: true,
            d_fun: "show",
        }
    );
});
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

    // if (Ap.d_fun == "school_list") {
    //     selected_school_id.value = Ap.res?.school_list?.[0]["school_id"];
    //     if (!selected_school_id.value) {
    //         alert("no school selected");
    //         return;
    //     }

    //     // Ap.d(
    //     //     {
    //     //         fun: "school_exams",
    //     //         data: selected_school_id.value,
    //     //     },
    //     //     {
    //     //         route: "/api/school_admin/add_school_exam_new",
    //     //         msg: Ap.lang == "en" ? "Done with success" : "تم بنجاح",
    //     //         loading: true,
    //     //         res_ver: "school_exams",
    //     //         msg_error: "msg_error",
    //     //         sys_error: true,
    //     //         log: true,
    //     //         d_fun: "school_exams",
    //     //     }
    //     // );
    //     Ap.d_fun = null;
    // }

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


function change_class(index,item) {
        var msg1 =
        Ap.lang == "en"
            ? "Are you sure         ?"
            : " تاكيد : عرض الفصل ";

    if (!confirm(msg1)) {
        return;
    }
selected_card.value=index;
// if( item.length<1){
//     return
// }
// alert(item)
emits('view', item)
// emits('classroom', item)
}

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
// my_schools_list();

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
.ribbon{
    background-color: blueviolet;
    border-radius: 4px;
    position: relative;
    height: 22px;
     
}
.ribbon::after{
    content: 'ggg';
    position: absolute;
    background-color: blue;
    width: 12px;
    top: 22px;
    left: 0;
    clip-path: polygon(100%   0%, 100%  0%,100%    10%); /* Defines triangle shape */

}

 
</style>
<style  >
.speech-bubble {
  position: relative;
  /* width: 200px; Adjust width as needed */
  /* height: 100px; Adjust height as needed */
  background-color: #FFDECE; /* Light orange background */
  border-radius: 10px; /* Rounded corners */
  padding: 20px; /* Inner padding for content */
}

.speech-bubble__arrow {
  position: absolute;
  bottom: -30px; /* Offset from the bottom edge */
  left:  0px; /* Offset from the left edge */
  width: 20px; /* Adjust width as needed */
    background-color: blue;
  fill: currentColor; /* Inherits fill color from the parent element */
}
.corner {
    position: absolute;
    top: 100%;
    width: 10px;
    height: 10px;
    /* color: currentcolor; */
    border: 6px solid;
    transform: scaleY(0.75);
     
    transform-origin: top;
    filter: brightness(75%);
/* color:green  ; */
    inset-inline-end: 0;
    border-inline-end-color: transparent;
    border-block-end-color: transparent;
}

</style>