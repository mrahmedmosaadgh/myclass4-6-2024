<template>
    <div>
        <div class="hidden h-0">{{ counter }}</div>

        <div class="rounded overflow-x-auto w-full m-auto">
            <table cellspacing="0" class="tg">
                <thead class="">
                    <!-- <tr  >
                        <th colspan="32" class="no-border_background pt-4">

                            <div class="p-0 text-center w-full"></div>
                        </th>
                    </tr> -->
                    <tr>
                        <th>#</th>

                        <th class="w-80">
                            <div class="p-0 flex">
                                <div class="p-0">
                                    <a-form-item has-feedback name="ar">
                                        <div class="p-0 text-xs text-gray-300">
                                            filter Ar/En/classroom بحث بالاسم -
                                            عربي - انجليزي
                                            <br />
                                            بحث بالفصل
                                        </div>

                                        <a-input-search
                                            @keyup.enter="show_fun()"
                                            v-model:value="filter_text"
                                            type="text"
                                            autocomplete="off"
                                            @search="show_fun()"
                                        />
                                    </a-form-item>
                                </div>
                            </div>
                            {{ Ap.lang == "en" ? "Name" : "الاسم" }}
                        </th>
                        <th class="w-24">
                            {{ Ap.lang == "en" ? "classroom" : "الفصل" }}
                            - count:{{ my_students?.c_students?.length }}
                        </th>
                    </tr>
                </thead>
                <!-- @click.ctrl="handleCtrlClick(index)" -->
                <tbody>
                    <tr
                        v-for="(item, index) in my_students?.c_students"
                        :key="index"
                        :class="{
                            even: (index + 1) % 2 === 0,
                            selected: item['select'] == 1,
                        }"
                    >
                        <td class="w-8">
                            <div class="p-0 text-xs flex whitespace-nowrap">
                                <div class="p-0 text-xs">
                                    {{ index + 1 }}
                                </div>
                            </div>
                        </td>

                        <td class="w-24">
                            <div class="p-0 flex m-auto">
                                <div
                                    class="pt-2 flex"
                                    :title="
                                        Ap.lang == 'en'
                                            ? item['ar'] + ' ' + item['detail']
                                            : item['en'] + ' ' + item['detail']
                                    "
                                >
                                    <div
                                        class="p-0 cursor-pointer"
                                        @click="update_block_fun(item)"
                                    >
                                        {{
                                            Ap.lang == "en"
                                                ? item["en"]
                                                : item["ar"]
                                        }}
                                    </div>
                                    <div class="p-0">
                                        <a-alert
                                            class="px-1 py-0 m-0 text-center text-xs red"
                                            message="Blocked"
                                            v-if="item?.paid == 0"
                                            :type="
                                                item?.paid == 0
                                                    ? 'error'
                                                    : 'success'
                                            "
                                        />
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <!-- {{ item }} -->
                            <!-- <pre dir="ltr">{{
                                JSON.stringify(item?.my_class, null, 2)
                            }}</pre> -->

                            {{
                                Ap.lang == "en"
                                    ? item?.my_class?.en
                                    : item?.my_class?.ar
                            }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import insert from "./co/insert.vue";
import update from "./co/update.vue";
import {
    PlusOutlined,
    MoreOutlined,
    EditOutlined,
    SaveOutlined,
    ReloadOutlined,
} from "@ant-design/icons-vue";
import { useAppStore } from "@/stores/appstore";
const Ap = useAppStore();
const my_db_route = ref("/api/school_admin/c_student_block");

const data_to_get_class_marks = ref({});
const open_change_sequence = ref(false);
const current_sequence = ref(null);
const up_sequence = ref(null);
const school_id = ref(Ap.res?.my_students?.["c_students"][0]["school_id"]);
const classroom = ref(null);
const insert_data = ref({});
onMounted(() => {
    Ap.res.my_students = [];
    // my_classes_fun();
    // show_fun();
});

const filter_text = ref(null);
const filter_col = ref("name");

const copy_fun = (email, my_password) => {
    alert(email, my_password);
};
const un_block_fun = (item) => {
    //console.log(item);
    //console.log(item?.paid);
};
const my_classes_fun = () => {
    Ap.d(
        {
            fun: "my_classes",
            data: null,
            // data: {school_id:selected_school_id,class_id:class_id},
        },
        {
            route: my_db_route.value,
            msg: null,
            loading: false,
            res_ver: "my_classes",
            msg_error: "msg_error",
            sys_error: true,
            log: true,
            d_fun: "my_classes",
        }
    );
};

const update_show = ref(false);
const update_data = ref({});
const update_show_fun = (item) => {
    update_data.value = item;
    // classroom.value = my_classroom;
    update_show.value = !update_show.value;
};

const update_block_fun = (item) => {
    var status = 0;
    var status_msg = "Block";
    if (item.paid == 0) {
        status = 1;
        status_msg = "Un Block";
    }
    if (!confirm("Are you sure! " + status_msg + ":" + item.ar)) {
        return;
    }

    var data = {
        fun: "update_block_fun",
        data: status,
        id: item.id,
        filter_text: filter_text.value,
        // data: {school_id:selected_school_id,class_id:class_id},
    };

    axios
        .post(my_db_route.value, { data: data })
        .then((response) => {
            my_students.value = response.data;
        })
        .catch((error) => {
            var msg1 = error?.response?.data?.message;

            //console.log("error.response ");
            //console.log(error?.response?.data?.message);
            // message.error(error?.response?.data?.message);

            //    Ap.msg.error(msg1)
            //   this.error = error.response.data.errors.username[0]; // Assuming Laravel error format
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

const my_students = ref([]);
const show_fun = () => {
    // Ap.d(
    //     {
    //         fun: "show",
    //         data: filter_text.value,
    //         // data: {school_id:selected_school_id,class_id:class_id},
    //     },
    //     {
    //         route: my_db_route.value,
    //         msg: Ap.lang == "en" ? "Done with success" : "تم بنجاح",
    //         loading: true,
    //         res_ver: "my_students",
    //         msg_error: "msg_error",
    //         sys_error: true,
    //         log: true,
    //         d_fun: "my_students",
    //     }
    // );

    var data = {
        fun: "show",
        data: filter_text.value,
        // data: {school_id:selected_school_id,class_id:class_id},
    };

    axios
        .post(my_db_route.value, { data: data })
        .then((response) => {
            my_students.value = response.data;
        })
        .catch((error) => {
            var msg1 = error?.response?.data?.message;

            //console.log("error.response ");
            //console.log(error?.response?.data?.message);
            // message.error(error?.response?.data?.message);

            // Ap.msg(msg1)
            //   this.error = error.response.data.errors.username[0]; // Assuming Laravel error format
        });
};

// const  semester_id = ref(Ap.res?.class_marks[0]['semester_id']);
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
    if (Ap.d_fun == "update") {
        update_show.value = false;
        show_fun();
    }
    if (Ap.d_fun == "delete") {
        show_fun();
    }

    if (Ap.d_fun == "create") {
        mood.value = "view";
        mood2.value["my_mood"] = "view";
    }

    if (Ap.d_fun == "save_all") {
        show_fun();
        // get_class_marks(get_class_marks_data.value);
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
