<template>
    <div :dir="lang == 'en' ? 'lrt' : 'rtl'">
        <!-- @finish="handleFinish"
                @validate="handleValidate"
                @finishFailed="handleFinishFailed" -->
        <a-badge-ribbon
            text="Create new semester Exam"
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
                        :label="lang == 'en' ? 'en' : 'الاسم انجليزي'"
                        name="name"
                    >
                        <a-input
                            v-model:value="props.data.en"
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
                        /> </a-form-item>

                    <a-form-item
                        has-feedback
                        :label="lang == 'en' ? 'detail  ' : 'تفاصيل'"
                        name="detail"
                    >
                        <a-input
                            v-model:value="props.data.detail"
                            type="text"
                            autocomplete="off"
                        /> </a-form-item>



                    <a-form-item has-feedback label="notes" name="notes">
                        <a-input
                            v-model:value="props.data.notes"
                            type="text"
                            autocomplete="off"
                        />
                    </a-form-item>

                    <a-form-item :wrapper-col="{ span: 14, offset: 4 }">
                        <a-button
                            type="primary"
                            html-type="submit"
                            @click="save_create()"
                            >Submit</a-button
                        >
                        <a-button
                            style="margin-left: 10px"
                            @click="
                                formRef.resetFields();
                                $emit('cancel');
                            "
                            >Reset</a-button
                        >
                    </a-form-item>
                </a-form>
            </a-card>
        </a-badge-ribbon>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
const props = defineProps(["open_me", "data", "lang"]);
const emit = defineEmits(["save_create", "cancel"]);

onMounted(() => {
    clear_values();
});
const clear_values = () => {
    //console.log("clear_values");
    for (const key in props.data) {
        if (props.data.hasOwnProperty(key)) {
            // Ensure enumerable property
            props.data[key] = ""; // Set value to undefined (or desired default)
        }
    }
    // props.data.grades_array = [];
};

const layout = {
    labelCol: { span: 8 },
    wrapperCol: { span: 14 },
};
const formRef = ref();
// const grades = ref([])
// const grades_fun = () => {
//     //console.log(props.data);

//     props.data.grades = props.data.grades_array.join(",");
//     // return props.data.grades;
// };
const save_create = () => {


    if (props.data.en == "" || props.data.ar == "") {
        alert("Name is required");
        return;
    }

    emit("save_create");
};

const rules = {
    en: [{ required: true, trigger: "change" }],
    ar: [{ required: true, trigger: "change" }],
    // grades: [{ required: true, trigger: "change" }],
    // stage: [{ required: true, trigger: "change" }],
    // name: [{ required: true, trigger: "change" }],
    //   name: [{ required: true, validator: validatePass, trigger: 'change' }],
    //   checkPass: [{ validator: validatePass2, trigger: 'change' }],
    //   age: [{ validator: checkAge, trigger: 'change' }],
};
</script>
