<template>
    <!-- <div class="p-0 text-2xl">{{ classroom }}</div> -->
    <!-- {{ data }} -->

    <div class="rounded overflow-x-auto w-full m-auto">
        <table cellspacing="0" class="tg w-full">
            <thead class="">
                <!-- <tr  >
                        <th colspan="32" class="no-border_background pt-4">

                            <div class="p-0 text-center w-full"></div>
                        </th>
                    </tr> -->
                <tr>
                    <th>#</th>

                    <th class="w-24">
                        {{ Ap.lang == "en" ? "Name" : "الاسم" }}
                    </th>

                    <th class="w-12">
                        {{ Ap.lang == "en" ? "grade" : "الصف" }}
                    </th>
                    <th class="w-12">
                        {{ Ap.lang == "en" ? "details" : "التفاصيل" }}
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
                                {{ index1 + 1 }}:{{ item?.deleted == 1 }}
                                <!-- v-show="item.delete == 1" -->
                            </div>
                        </div>
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
                            old: {{ item?.my_subject?.ar }}
                        </div>
                        <!-- {{ item?.my_subject?.ar }} -->
                        <select class="w-44" v-model="item.subject_id">
                            <!-- @change="update_class_grade(item)" -->
                            <option
                                v-for="(subject, index) in subjects"
                                :key="index"
                                :value="subject.id"
                            >
                                {{
                                    subject.ar +
                                    " || " +
                                    subject.en +
                                    " || " +
                                    subject.detail
                                }}
                            </option>
                        </select>
                    </td>

                    <td>
                        <!-- {{ item }} -->

                        <div
                            class="p-0 text-gray-400"
                            v-if="item?.teacher_id != item?.my_teacher?.user_id"
                        >
                            old: {{ item?.my_teacher?.name_ar }}
                        </div>
                        <!-- {{ item?.my_teacher?.name_ar }} -->
                        <select class="w-44" v-model="item.teacher_id">
                            <!-- @change="update_class_grade(item)" -->
                            {{
                                my_teachers
                            }}
                            <option
                                v-for="(teacher, index) in my_teachers"
                                :key="index"
                                :value="teacher.user_id"
                            >
                                {{ teacher.my_user?.name_ar }}
                                <!-- {{ teacher.name_ar + " || " + teacher.name_en }} -->
                            </option>
                        </select>
                    </td>
                    <td>
                        {{ item.deleted == 1 }}
                        <a-button type="primary" @click="item.deleted = 1"
                            >Submit</a-button
                        >
                    </td>
                </tr>
            </tbody>
        </table>

        <a-button type="primary" @click="add_record()">add_record()</a-button>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { EyeOutlined } from "@ant-design/icons-vue";
import { useAppStore } from "@/stores/appstore";
// import animate_number from "@/components/best/animate_number.vue";
const props = defineProps(["data", "subjects", "my_teachers", "classroom"]);
const Ap = useAppStore();

onMounted(() => {
    props.data?.my_subjects.forEach((element) => {
        element["deleted"] = 0;
    });
});

function fun_delete(event) {
    //console.log("fun_delete", event);
}
function add_record() {
    var data = {
        id: null,
        my_teacher: { name_ar: "" },
        my_subject: { id: null },
        class_id: "",
        teacher_id: "",
        subject_id: "",
        deleted: 0,
    };
    props.data?.my_subjects.push(data);
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
