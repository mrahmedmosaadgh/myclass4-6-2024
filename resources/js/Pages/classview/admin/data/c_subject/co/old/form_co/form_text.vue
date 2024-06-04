<template>
<div>
new user
component for every felid
edit view

<!-- <a-button             @click="
                fun_db({
                    route: '/api/hr/add_new_user',
                    fun: 'create_temp_user',
                    // school_id: school_id,
                    // data: data_to_db,
                })
            "  type="primary">

backup
</a-button> -->
 <br><Button type="primary">Dashed Button</Button>

 <component :is="name"></component>
 <component :is="name"></component>



</div>
  </template>

  <script setup>
  import {  ref } from "vue";
import { Button } from "ant-design-vue";
import name from "./comp/data_1_name.vue";
// import "ant-design-vue/dist/antd.css";
  const message = "It is not in a Form";


function fun_before(fun) {


}

function fun_next(res, fun) {



}
function fun_db(data) {
    if (!data.route) {Ap.ms("error", "empty route", 1, 1);}
    fun_before(data.fun);
        try {axios.post(data.route, data).then((res) => {
            Ap.ms("success", "loading done", 1, 1);
            //console.log("db", res.data);
            fun_next(res.data, data.fun);
    });} catch (e) {Ap.ms("error", "loading error", 1, 1);}

}

  </script>
