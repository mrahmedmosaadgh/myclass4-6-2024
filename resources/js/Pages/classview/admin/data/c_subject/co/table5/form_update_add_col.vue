<template>
    <a-form
        ref="formRef"
        name="dynamic_form_nest_item"
        :model="dynamicValidateForm"
        @finish="onFinish"
    >
    <div class="p-0" v-if="titles">

   
        <a-select 
            v-for="(title, index) in titles"
            :key="index"
            v-model:value="title.ar"
            class="w-24"
            mode="tags"
            style="width: 244px"
            placeholder="Tags Mode"
            :options="title"
            show-search
            @change="handleChange()"
            :field-names="{ label: 'ar', value: 'id', options: 'data' }"
        ></a-select>

       </div>  
        <a-space
            v-for="(user, index) in dynamicValidateForm.users"
            :key="user.id"
            style="display: flex; margin-bottom: 8px"
            align="baseline"
        >
            <a-form-item
                :label="lang == 'en' ? 'Name Arabic' : 'الاسم عربي'"
                :name="['users', index, 'first']"
                :rules="{
                    required: true,
                    message: 'Missing first name',
                }"
            >     v-model:value="title2"
                <a-select
               
                    class="w-24"
                    mode="tags"
                    style="width: 244px"
                    placeholder="Tags Mode"
                    :options="data"
                    show-search
                    @change="handleChange()"
                    :field-names="{ label: 'ar', value: 'ar', options: 'data' }"
                ></a-select>
                <!-- mode="tags"    style="width: 100%" @change="handleChange" -->

                <!-- <a-input v-model:value="user.first" placeholder="First Name" /> -->
            </a-form-item>
            <a-form-item
                :label="lang == 'en' ? 'Name Arabic' : 'الاسم عربي'"
                :name="['users', index, 'last']"
                :rules="{
                    required: true,
                    message: 'Missing last name',
                }"
            >
                <a-input v-model:value="user.last" placeholder="Last Name" />
            </a-form-item>

            <a-form-item
                :label="lang == 'en' ? 'Name Arabic' : 'الاسم عربي'"
                :name="['users', index, 'last']"
                :rules="{
                    required: true,
                    message: 'Missing last name',
                }"
            >
                <a-input v-model:value="user.last" placeholder="Last Name" />
            </a-form-item>

            <MinusCircleOutlined @click="removeUser(user)" />
        </a-space>
        <a-form-item>
            <a-button type="dashed" block @click="addUser">
                <PlusOutlined />
                Add user
            </a-button>
        </a-form-item>
        <a-form-item>
            <a-button type="primary" html-type="submit">Submit</a-button>
        </a-form-item>
    </a-form>
</template>
<script lang="ts" setup>
import { reactive, ref, computed } from "vue";
import { MinusCircleOutlined, PlusOutlined } from "@ant-design/icons-vue";
import type { FormInstance } from "ant-design-vue";
defineProps(["data", "lang", "titles"]);
interface User {
    first: string;
    last: string;
    id: number;
}

const formRef = ref<FormInstance>();
const array = ref([]);
const limitedArray = computed(() => {
    array.value = array.value.slice(0, 1);
    return array.value.slice(0, 1);
});
// limitedArray() {
//       // Return a copy of the array, limited to 2 elements
//       return this.myArray.slice(0, 2);
//     }

const dynamicValidateForm = reactive<{ users: User[] }>({
    users: [],
});
const removeUser = (item: User) => {
    const index = dynamicValidateForm.users.indexOf(item);
    if (index !== -1) {
        dynamicValidateForm.users.splice(index, 1);
    }
};
const addUser = () => {
    dynamicValidateForm.users.push({
        first: "",
        last: "",
        id: Date.now(),
    });
};

const onFinish = (values) => {
    //console.log("Received values of form:", values);
    //console.log("dynamicValidateForm.users:", dynamicValidateForm.users);
};
const handleChange = () => {
    array.value = array.value.slice(0, 1);
    return array.value.slice(0, 1);
};
</script>
