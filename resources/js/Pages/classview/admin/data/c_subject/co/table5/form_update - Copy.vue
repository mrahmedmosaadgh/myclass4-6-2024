<template>
    <div :dir="lang == 'en' ? 'lrt' : 'rtl'" v-if="props.data">
        <!-- @finish="handleFinish"
                @validate="handleValidate"
                @finishFailed="handleFinishFailed" -->
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
                        :label="lang == 'en' ? 'name' : 'الاسم انجليزي'"
                        name="name"
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




                    <!-- </a-badge-ribbon> -->

                    <!-- <a-form-item
                        name="stage"
                        :label="lang == 'en' ? 'stage' : ' المرحلة  '"
                        has-feedback
                        :rules="[
                            {
                                required: true,
                                message: 'Please select your country!',
                            },
                        ]"
                    >
                        <a-select
                            v-model:value="props.data.stage"
                            placeholder="Please select a country"
                        >
                            <a-select-option :value="1"
                                >primary - ابتدائي</a-select-option
                            >
                            <a-select-option :value="2"
                                >Middle - متوسط</a-select-option
                            >
                            <a-select-option :value="3"
                                >Secondary - ثانوي</a-select-option
                            >
                        </a-select>
                    </a-form-item> -->

                    <!-- :wrapper-col="{ span: 14, offset: 4 }"  -->
<!--
                    <a-form-item
                        name="grades_array"
                        :label="lang == 'en' ? ' Grades' : ' الصفوف  '"
                        :rules="[
                            {
                                required: true,
                                message: 'Please select exam grades!',
                                type: 'array',
                            },
                        ]"
                    >

                        <a-select
                            v-if="props.data.grades_array"
                            v-model:value="props.data.grades_array"
                            mode="multiple"
                            placeholder="Please select   grades"
                            @change="grades_fun()"
                        >
                            <a-select-option
                                v-for="num in 12"
                                :key="num"
                                :value="num"
                                >G{{ num }}</a-select-option
                            >
                        </a-select>
                    </a-form-item>
                    <br /> -->





                    <!-- <a-badge-ribbon
                        title=" "
                        :text="
                            lang == 'en'
                                ? 'Teacher can edit marks'
                                : 'المعلم يستطيع تعديل الدرجات'
                        "
                        color="gray   "
                    > -->
                    <!-- <hr class="pb-4" />
                    <div class="pb-2 max-w-60">
                        {{
                            lang == "en"
                                ? "Teacher can edit marks"
                                : "المعلم يستطيع تعديل الدرجات"
                        }}
                        <hr class="w-full" />
                    </div> -->

                    <a-form-item
                        has-feedback
                        :label="lang == 'en' ? 'Start edit' : ' بداية التعديل'"
                        name="teacher_start"
                    >
                        <a-input
                            v-model:value="props.data.teacher_start"
                            type="datetime-local"
                            autocomplete="off"
                        />
                    </a-form-item>

                    <a-form-item
                        has-feedback
                        :label="lang == 'en' ? 'close edit' : ' غلق التعديل'"
                        name="teacher_end"
                    >
                        <a-input
                            v-model:value="props.data.teacher_end"
                            type="datetime-local"
                            autocomplete="off"
                        />
                    </a-form-item>
                    <!-- </a-badge-ribbon> -->
                    <hr class="pb-4" />
                    <div class="pb-2 max-w-60">
                        {{
                            lang == "en"
                                ? "Student can see marks  "
                                : " الطالب يستطيع مشاهدة التقرير  "
                        }}
                        <hr />
                    </div>
                    <!-- <hr class="pb-4" /> -->

                    <!-- <a-badge-ribbon
                        title=" "
                        :text="
                            lang == 'en'
                                ? 'Student can see marks  '
                                : ' الطالب يستطيع مشاهدة التقرير  '
                        "
                        color="gray   "
                    > -->
                    <!-- <hr class="p-2" /> -->

                    <a-form-item
                        has-feedback
                        :label="lang == 'en' ? 'Start' : ' بداية  '"
                        name="student_start"
                    >
                        <a-input
                            v-model:value="props.data.student_start"
                            type="datetime-local"
                            autocomplete="off"
                        />
                    </a-form-item>

                    <a-form-item
                        has-feedback
                        :label="lang == 'en' ? 'End' : '  نهاية  '"
                        name="student_end"
                    >
                        <a-input
                            v-model:value="props.data.student_end"
                            type="datetime-local"
                            autocomplete="off"
                        />

                   </a-form-item>

                    <a-form-item has-feedback label="notes" name="notes">
                        <a-input
                            v-model:value="props.data.notes"
                            type="text"
                            autocomplete="off"
                        />
                    </a-form-item>

                    <a-form-item :wrapper-col="{ span: 14, offset: 4 }">
                        <a-button
                            class="px-8 mx-4"
                            type="primary"
                            html-type="submit"
                            @click="save_update()"
                        >
                            {{ lang == "en" ? " Save " : " حفظ التعديل  " }}
                        </a-button>
                        <a-button
                            style="margin-left: 10px"
                            @click="

                                $emit('cancel');
                            "
                        >
                            {{ lang == "en" ? " Cancel" : " الغاء    " }}
                        </a-button>
                    </a-form-item>
                </a-form>
            </a-card>
        </a-badge-ribbon>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
const props = defineProps(["open_me", "data", "lang"]);
const emit = defineEmits(["save_update", "cancel"]);

onMounted(() => {
    props.data.grades_array = props.data.grades.split(",").map(Number);
    // clear_values();
});
const clear_values = () => {
    //console.log("clear_values");
    // for (const key in props.data) {
    //     if (props.data.hasOwnProperty(key)) {

    //         props.data[key] = "";
    //     }
    // }
    if (props.data && props.data["grades_array"]) {
        props.data["grades_array"] = [];
    } else {
        //console.log(props.data);
        // //console.log(props.data["grades_array"]);

        alert(" no grades_array");
    }
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
const save_update = () => {
    if (props.data.grades == "" || props.data.grades == null) {
        alert("choose grades");
        return;
    }

    if (props.data.name == "" || props.data.name_ar == "") {
        alert("Name is required");
        return;
    }

    emit("save_update",props.data);
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
