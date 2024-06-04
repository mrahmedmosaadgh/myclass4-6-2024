<template>


  <div class="flex flex-wrap justify-center p-4">

        <a-card class=" cursor-auto"
            size="small"
            style="width: 150px; height: 100px"


            :dir="Ap.lang == 'en' ? 'lrt' : 'rtl'"
        >
                    <a-badge-ribbon
                 :text="'classrooms:'+Ap.res?.my_classes?.['c_classes']?.length"


                color="purple"
                class="w-full text-center"
            />
 
                    <div class="text-center">


<!-- classrooms:{{ Ap.res?.my_classes['c_classes']?.length }} -->
        </div>
            <!-- </a-badge-ribbon> -->


        </a-card>
    </div>
    <div class="flex flex-wrap justify-center gap-2    ">

    <!-- Ap.res?.show?.my_classes{{ Ap.res?.my_classes }} -->



        <a-card  @click="$emit('view', item)"
            size="small"
            style="width: 150px; height: 200px"
            hoverable
            v-for="(item, index) in Ap.res?.my_classes?.['c_classes']"
            :key="index"
            :dir="Ap.lang == 'en' ? 'lrt' : 'rtl'"
        >
            <a-badge-ribbon
                :text="
                    Ap.lang == 'en' ? item['en'] : item['ar']
                "
                color="purple"
                class="w-full text-center"
            >
            </a-badge-ribbon>
            <!-- <template #extra><a href="#">more</a></template> -->
            <div class="pt-8 pb-3 text-xl text-center rounded">
                <!-- title=" " -->




                    <div class="p-0 flex flex-col  relative justify-center" >
                        <!-- <div
                            class="my-3 px-3 w-16 relative bg-blue-600 text-white text-xl rounded-full hover:scale-125 cursor-pointer"
                        >
                            {{ item['ar']  }}
                        </div>
                            <div class="p-0 text-2xs     opacity-40">
                             {{ item['en']  }} :
                             {{ item['detail']  }}
                            </div> -->



                            <div class="m-4 text-xs  green  rounded-full    ">



      <a-tooltip placement="top">
        <template #title>
<div class="p-0">
      <div v-for="(item2,index) in item?.['my_subjects'] " :key="index">
      <table  >
<tr dtr="rtl">
<td class="text-2xs w-20 border-b-2  ">
{{ item2['my_subject']['ar']  }}
</td>
<td class="text-2xs w-28 border-b-2  ">
{{ item2['my_teacher']['name_ar']  }}
</td>

</tr>
      </table>



      </div>
</div>


        </template>
        <div class="p-0">
subjects:{{ item?.['my_subjects']?.length }}
        </div>
      </a-tooltip>

                            </div>

                    </div>


                <!-- <template #title>


    </template> -->
                <!-- <a-card title="Pushes open the window" size="small">and raises the spyglass.</a-card> -->
                <!-- title="Default size card" -->

                <!-- <a-progress class="scale-50" type="circle" :percent=" item['class_marks_finished_percent']" /> -->
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
// import { methodOf } from "lodash";
// @/components/best/animate_number.vue
const props = defineProps(["data"]);

const Ap = useAppStore();
const selected_school_id = ref(null);
const class_id = ref(null);
const student_count = ref([]);
// onMounted(() => {
//     Ap.d(
//         {
//             fun: "show",
//             data: null,
//             // data: {school_id:selected_school_id,class_id:class_id},
//         },
//         {
//             route: "/api/teacher_marks_edit",
//             msg: null,
//             // msg: Ap.lang == 'en' ? 'Done with success' : 'تم بنجاح',
//             loading: true,
//             res_ver: "show",
//             msg_error: "msg_error",
//             sys_error: true,
//             log: true,
//             d_fun: "show",
//         }
//     );
// });
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
</style>
