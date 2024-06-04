<template>
    <!-- <div class="p-0 text-2xl">{{ classroom }}</div> -->
    <!-- {{ data }} -->

    <div
        class="rounded overflow-x-auto w-full m-auto"
        :dir="Ap.lang == 'en' ? 'ltr' : 'rtl'"
    >
        <table
            cellspacing="0"
            class="tg w-full"
            :dir="Ap.lang == 'en' ? 'ltr' : 'rtl'"
        >
            <thead class="">
                <!-- <tr  >
                        <th colspan="32" class="no-border_background pt-4">

                            <div class="p-0 text-center w-full"></div>
                        </th>
                    </tr> -->
                <tr>
                    <th>#</th>

                    <th class="w-24">
                        {{
                            Ap.lang == "en"
                                ? "report order"
                                : "الترتيب في التقرير"
                        }}
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
                    v-for="(item, index1) in data?.my_subjects"
                    :key="index1"
                    v-show="item?.deleted == 0"
                >
                    <td class="w-8">
                        <div class="p-0 text-xs flex whitespace-nowrap">
                            <div class="p-0 text-xs">
                                {{ index1 + 1 }}
                                <!-- v-show="item.delete == 1" -->
                            </div>
                        </div>
                    </td>

                    <td>


 <a-button type="primary" @click="counter++;item.report_sequence=counter;update_report_sequence_fun(item)"><div class=" px-1 green" >{{ item?.report_sequence }}</div></a-button>
                    </td>
                    <td class="w-24">
                        <div
                            class="p-0"
                            :title="
                                Ap.lang == 'en'
                                    ? item?.['ar'] + ' ' + item?.['detail']
                                    : item?.['en'] + ' ' + item?.['detail']
                            "
                        >
                            {{ Ap.lang == "en" ? item?.["en"] : item?.["ar"] }}
                        </div>
                    </td>

                    <td>
                        <div
                            class="p-0 text-gray-400"
                            v-if="item.subject_id != item.my_subject.id"
                        >
                            <!-- old: {{ item?.my_subject?.ar }} -->
                        </div>
                        <!-- {{ item?.my_subject?.ar }} -->
                        <!-- @change="update_class_grade(item)" -->
                        <select class="w-44 p-2" v-model="item.subject_id">
                            <option
                                v-for="(subject, index) in subjects"
                                :key="index"
                                :value="subject.id"
                            >
                                {{ subject.ar + " || " + subject.detail }}

                                <!-- {{
                                    subject.ar +
                                    " || " +
                                    subject.en +
                                    " || " +
                                    subject.detail
                                }} -->
                            </option>
                        </select>

                        <!-- <a-select
                            v-model:value="item.subject_id"
                            show-search
                            placeholder="Select a person"
                            style="width: 200px"
                            :options="subjects"
                            :filter-option="subjects"
                        ></a-select> -->
                        <!-- @focus="handleFocus"
    @blur="handleBlur"
    @change="handleChange" -->
                    </td>

                    <td>
                        <!-- {{ item }} -->

                        <!-- <div
                            class="p-0 text-gray-400"
                            v-if="item?.teacher_id != item?.my_teacher?.user_id"
                        >
                            old: {{ item?.my_teacher?.ar }}
                        </div> -->
                        <!-- {{ item?.my_teacher?.ar }} -->
                        <select class="w-44 p-2" v-model="item.teacher_id">
                            <!-- @change="update_class_grade(item)" -->
                            {{
                                my_teachers
                            }}
                            <option
                                v-for="(teacher, index) in my_teachers"
                                :key="index"
                                :value="teacher.user_id"
                            >
                                {{ teacher.my_user?.ar }}
                                <!-- {{ teacher.ar + " || " + teacher.en }} -->
                            </option>
                        </select>

                        <!-- <a-select
                            v-model:value="value"
                            show-search
                            placeholder="Select a person"
                            style="width: 200px"
                            :options="my_teachers"
                            :filter-option="my_teachers"
                            :field-names="{
                                label: 'ar',
                                value: 'user_id',
                                options: 'children',
                            }"
                        ></a-select> -->
                        <!-- @focus="handleFocus"
    @blur="handleBlur"
    @change="handleChange" -->
                    </td>
                    <td>
                        <a-button
                            type="primary"
                            shape="circle"
                            danger
                            @click="delete_item(index1)"
                            ><DeleteOutlined
                        /></a-button>
                    </td>
                </tr>
            </tbody>
        </table>

        <a-button type="primary" @click="add_record()">
            <PlusOutlined
        /></a-button>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import {
    EyeOutlined,
    DeleteOutlined,
    PlusOutlined,
} from "@ant-design/icons-vue";
import { useAppStore } from "@/stores/appstore";
// import animate_number from "@/components/best/animate_number.vue";
const props = defineProps(["data", "subjects", "my_teachers", "classroom"]);
const Ap = useAppStore();
const counter = ref(0);

onMounted(() => {
    props.data?.my_subjects.forEach((element) => {
        element["deleted"] = 0;
    });
});






function update_report_sequence_fun(item) {
    //console.log("update_report_sequence_fun", item);

            // route: "/api/school_admin/c_class",
            // msg: Ap.lang == "en" ? "Done with success" : "تم بنجاح",
            // loading: true,
            // res_ver: "update_class_grade",
            // msg_error: "msg_error",
            // sys_error: true,
            // log: true,
            // d_fun: "update_class_grade",

   var db_data =        {
            fun: "update_report_sequence",
            data: item,
            // data: {school_id:selected_school_id,class_id:class_id},
        }
   var options = {
        route: "/api/school_admin/c_class",
        msg: null,
        // msg_duration:2000,
        loading: true,
        log: true,
        res_ver: "update_report_sequence",
        msg_error: "Error",
        sys_error: false,
        d_fun: null,
    }

    // //console.log(options);
    // //console.log(db_data);
    if (options.route == null) {
        message.error("no route");
        return;
    }

    options.loading ? (Ap.loading = true) : (Ap.loading = false);

    axios
        .post(options.route, { data: db_data })
        .then((response) => {
            Ap.d_counter++;
            Ap.d_fun = options.d_fun;

            if(options.res_ver){

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


}
function add_record() {
    var data = {
        id: null,
        my_teacher: { ar: "" },
        my_subject: { id: null },
        class_id: "",
        teacher_id: "",
        subject_id: "",
        deleted: 0,
    };
    props.data?.my_subjects.push(data);
}
function delete_item(index1) {
    //console.log(index1);
    if (!confirm("Are you sure!")) {
        return;
    }
    //    item.deleted = 1
    props.data.my_subjects[index1].deleted = 1;
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
