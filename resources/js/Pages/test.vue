<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
// import Welcome from '@/Components/Welcome.vue';
// import { StarOutlined, StarFilled, StarTwoTone } from '@ant-design/icons-vue';
import { ref } from 'vue';
const state=ref({})
// import Calendar from 'primevue/Calendar';
import { CheckOutlined, CloseOutlined } from '@ant-design/icons-vue';
</script>

<template>
    <AppLayout title="test">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                test 
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden min-h-72   shadow-xl sm:rounded-lg">
                  
 


                    <a-switch v-model:checked="state.checked1" checked-children="开" un-checked-children="关" />
    <a-switch v-model:checked="state.checked2" checked-children="1" un-checked-children="0" />
    <a-switch v-model:checked="state.checked3">
      <template #checkedChildren><check-outlined /></template>
      <template #unCheckedChildren><close-outlined /></template>
    </a-switch>


                </div> 
 

                <!-- <pre>{{ JSON.stringify($page , null, 2) }}</pre> -->
            </div>
        </div>
    </AppLayout>
</template>
