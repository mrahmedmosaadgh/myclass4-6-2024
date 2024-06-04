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

                    <!-- props.data.my_subject_title -->

                    <!-- <form_update_add_col :data="props.data.my_subject_title"    :titles="props.data.titles"  lang="ar"></form_update_add_col> -->

                    <div
                        v-for="(item, index) in props.data.my_subject_title"
                        :key="index"
                        class="flex-col flex"
                    >
                        <a-card
                            hoverable
                            class="cursor-default w-full"
                            :dir="lang == 'en' ? 'lrt' : 'rtl'"
                        >
                            <!-- title=" " -->
                            <template #title>
                                <a-form-item
                                    has-feedback
                                    :label="
                                        lang == 'en'
                                            ? '   detail '
                                            : ' detail   '
                                    "
                                    name="detail"
                                >
                                    <a-input
                                        v-model:value="item.detail"
                                        type="text"
                                        autocomplete="off"
                                    />
                                </a-form-item>
                            </template>
                            <div
                                class="p-0 w-full flex-row flex justify-evenly"
                            >
                                <a-form-item
                                    has-feedback
                                    :label="
                                        lang == 'en' ? ' name ' : 'الاسم عربي  '
                                    "
                                    name="ar"
                                >
                                    <a-input
                                        v-model:value="item.ar"
                                        type="text"
                                        autocomplete="off"
                                    />
                                </a-form-item>
                                <a-form-item
                                    has-feedback
                                    :label="
                                        lang == 'en'
                                            ? ' name English'
                                            : 'English الاسم '
                                    "
                                    name="en"
                                >
                                    <a-input
                                        v-model:value="item.en"
                                        type="text"
                                        autocomplete="off"
                                    />
                                </a-form-item>
                            </div>

                            <div
                                class="p-0 w-full flex-row flex justify-evenly"
                            >
                                <a-form-item
                                    has-feedback
                                    :label="
                                        lang == 'en'
                                            ? '   highest_mark '
                                            : ' highest_mark   '
                                    "
                                    name="highest_mark"
                                >
                                    <a-input
                                        v-model:value="item.highest_mark"
                                        type="number"
                                        autocomplete="off"
                                    />
                                </a-form-item>
                                <a-form-item
                                    has-feedback
                                    :label="
                                        lang == 'en'
                                            ? '   lowest_mark '
                                            : ' lowest_mark   '
                                    "
                                    name="lowest_mark"
                                >
                                    <a-input
                                        v-model:value="item.lowest_mark"
                                        type="number"
                                        autocomplete="off"
                                    />
                                </a-form-item>
                            </div>
                        </a-card>

                        <!-- {{ item.ar }}- {{ item.en }}- {{ item.detail }}- {{ item.highest_mark }}- {{ item.lowest_mark }}- {{ item.is_calc }}-
        {{ item.is_final }} -{{ item.is_total }}-{{ item.notes }} -->
                        <!--
        { "id": 1, "admin_id": 1, "school_id": 4, "semester_id": 8, "subject_id": 1, "sequence": 1,
         "detail": null, "ar": "hw", "en": "hw ar", "highest_mark": 10, "lowest_mark": null,
         "is_calc": 1, "is_final": 0, "is_total": 0, "notes": "",

          "created_at": null, "updated_at": null } -->
                    </div>
                    <a-button type="dashed" block @click="addUser">
                        <PlusOutlined />
                        Add user
                    </a-button>
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
                            @click="$emit('cancel')"
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
import form_update_add_col from "./form_update_add_col.vue";
const props = defineProps(["open_me", "data", "lang"]);
const emit = defineEmits(["save_update", "cancel"]);

import { PlusOutlined } from "@ant-design/icons-vue";

onMounted(() => {
    // props.data.grades_array = props.data.grades.split(",").map(Number);
    // clear_values();
});
const clear_values = () => {
    //console.log("clear_values");
    // for (const key in props.data) {
    //     if (props.data.hasOwnProperty(key)) {
    //  "detail": null, "ar": "hw", "en": "hw ar", "highest_mark": 10, "lowest_mark": null,
    //  "is_calc": 1, "is_final": 0, "is_total": 0, "notes": "",
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

    emit("save_update", props.data);
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
