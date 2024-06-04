<template>
    <div>
        <!-- title="Title" -->
        <a-modal
            v-model:open="open_me.open_me"
            :maskClosable="false"
            @ok="open_me.open_me = !open_me.open_me"
        >
            <template #footer>
                <a-button key="back" @click="handleCancel">Return</a-button>
                <a-button key="submit" type="primary" :loading="loading" @click="open_me.open_me=!open_me.open_me">Submit</a-button>
            </template>
            form create
            <!-- <input type="search" v-model="data.name" />
            <a-button
                type="primary"
                @click="
                    $emit('save_create', data);
                    open_me.open_me = !open_me.open_me;
                "
                >Submit</a-button -->

            <!-- :disabled="componentDisabled" -->

            <a-form
                dir="ltr"
                ref="formRef"
                name="custom-validation"
                :model="data"
                :rules="rules"
                v-bind="layout"
                @finish="handleFinish"
                @validate="handleValidate"
                @finishFailed="handleFinishFailed"
            >
                <a-badge-ribbon text="Name">
      <a-card hoverable  size="small">

                <a-form-item has-feedback label="name" name="name">
                    <a-input
                        v-model:value="data.name"
                        type="text"
                        autocomplete="off"
                    />
                </a-form-item>

                <a-form-item has-feedback label="name_ar" name="name_ar">
                    <a-input
                        v-model:value="data.name_ar"
                        type="text"
                        autocomplete="off"
                    />
                </a-form-item>

      </a-card>
    </a-badge-ribbon>




                <a-badge-ribbon text="Teacher">
                    <a-card
                        hoverable
                        class=" m-2"
                        title="   Teacher can edit marks"
                        size="small"
                    >
                        <a-form-item
                            has-feedback
                            label="teacher_start"
                            name="teacher_start"
                        >
                            <a-input
                                v-model:value="data.teacher_start"
                                type="datetime-local"
                                autocomplete="off"
                            />
                        </a-form-item>

                        <a-form-item
                            has-feedback
                            label="teacher_end"
                            name="teacher_end"
                        >
                            <a-input
                                v-model:value="data.teacher_end"
                                type="datetime-local"
                                autocomplete="off"
                            />
                        </a-form-item>
                    </a-card>
                </a-badge-ribbon>

                <a-badge-ribbon text="Student">
                    <a-card hoverable  title="   Student can see marks" class=" m-2" size="small">
                        <!-- title="Pushes open the window" -->
                        <a-form-item
                            has-feedback
                            label="start"
                            name="student_start"
                        >
                            <a-input
                                v-model:value="data.student_start"
                                type="datetime-local"
                                autocomplete="off"
                            />
                        </a-form-item>

                        <a-form-item
                            has-feedback
                            label="end"
                            name="student_end"
                        >
                            <a-input
                                v-model:value="data.student_end"
                                type="datetime-local"
                                autocomplete="off"
                            />
                        </a-form-item>
                    </a-card>
                </a-badge-ribbon>

                <a-form-item
                    name="stage"
                    label="Select"
                    has-feedback
                    :rules="[
                        {
                            required: true,
                            message: 'Please select your country!',
                        },
                    ]"
                >
                    <a-select
                        v-model:value="data.stage"
                        placeholder="Please select a country"
                    >
                        <a-select-option :value="1">primary</a-select-option>
                        <a-select-option :value="2">Middle</a-select-option>
                        <a-select-option :value="3">Secondary</a-select-option>
                    </a-select>
                </a-form-item>

                <!-- :wrapper-col="{ span: 14, offset: 4 }"  -->

                <a-form-item
                    name="grades_array"
                    label="Select grades"
                    :rules="[
                        {
                            required: true,
                            message: 'Please select exam grades!',
                            type: 'array',
                        },
                    ]"
                >
                    <a-select
                        v-model:value="data.grades_array"
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
                <br />
                <a-form-item has-feedback label="notes" name="notes">
                    <a-input
                        v-model:value="data.notes"
                        type="text"
                        autocomplete="off"
                    />
                </a-form-item>

                <a-form-item :wrapper-col="{ span: 14, offset: 4 }">
                    <a-button type="primary" html-type="submit"
                        >Submit</a-button
                    >
                    <a-button
                        style="margin-left: 10px"
                        @click="formRef.resetFields()"
                        >Reset</a-button
                    >
                </a-form-item>
            </a-form>
        </a-modal>
    </div>
</template>

<script setup>
import { computed, ref } from "vue";
const props = defineProps(["open_me", "data"]);
defineEmits(["save_create"]);

const layout = {
    labelCol: { span: 6 },
    wrapperCol: { span: 14 },
};
const formRef = ref();
// const grades = ref([])
const grades_fun = () => {
    //console.log(props.data);

    props.data.grades = props.data.grades_array.join(",");
    // return props.data.grades;
};
const rules = {
    name: [{ required: true, trigger: "change" }],
    //   name: [{ required: true, validator: validatePass, trigger: 'change' }],
    //   checkPass: [{ validator: validatePass2, trigger: 'change' }],
    //   age: [{ validator: checkAge, trigger: 'change' }],
};
</script>
