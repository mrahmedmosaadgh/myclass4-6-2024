<template>
    <div>
        <!-- title="Title" -->
        <a-modal
            v-model:open="open_me.open_me"
            :maskClosable="false"
            @ok="open_me.open_me = !open_me.open_me"
        >
            <template #footer>
                <!-- <a-button key="back" @click="handleCancel">Return</a-button> -->
                <!-- <a-button key="submit" type="primary" :loading="loading" @click="open_me.open_me=!open_me.open_me">Submit</a-button> -->
            </template>
            form update
            <input type="search" v-model="data.name" />
            <a-button
                type="primary"
                @click="
                    $emit('save_update', data);
                    open_me.open_me = !open_me.open_me;
                "
                >Submit</a-button
            >
        </a-modal>
    </div>
</template>

<script setup>
// import { ref } from "vue";
defineProps(["open_me", "data"]);
defineEmits(["save_update" ]);
</script>
