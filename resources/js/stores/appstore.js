import { defineStore } from 'pinia';
import { notification } from "ant-design-vue";
import { message } from "ant-design-vue";
export const useAppStore = defineStore('app', {
    // export const uApStore = defineStore('app', {
    state: () => ({
        user: null, // Store user information here
        loading: false, 
        msg: message,
        noti: notification,
        res: {},  
        roles: new Set(),
        permissions: new Set(),
    }),
    actions: {
        setUser(user) {
            this.user = user;
        },
        async d(
            db_data = null,
            options = {
                route: null,
                msg: null,
                // msg_duration:2000,
                loading: true,
                log: true,
                res_ver: "ver",
                msg_error: "Error",
                sys_error: false,
                d_fun: null,
            }
        ) {
            // console.log(options);
            // console.log(db_data);
            if (options.route == null) {
                message.error("no route");
                return;
            }

            options.loading ? (this.loading = true) : (this.loading = false);

            await axios
                .post(options.route, { data: db_data })
                .then((response) => {
 
                    this.res[options.res_ver] = response.data;

                    this.loading = false;
                    options?.msg != null ? message.success(options.msg) : null;

                    if (options.log) {
                        // console.log(response);
                    }
                    // console.log(1);
                })
                .catch((error) => {
                    // console.log(0);

                    this.loading = false;

                    // console.log(error?.response?.status);
                    if (error?.response?.status == 419) {
                        if (!confirm("reload")) {
                            return;
                        }
                        window.location.reload();
                    }

                    // console.log("db res error");
                    var msg1 = options.sys_error
                        ? options.msg_error + " :" + error?.response?.data?.message
                        : null;

                    // console.log("error.response ");
                    // console.log(error?.response?.data?.message);
                    // message.error(error?.response?.data?.message);


                    options.msg != null ? message.error(msg1) : null;
                });
        },

        ms(
            type = "success",
            content = "success",
            key = 1,
            duration = 1,
            my_class
        ) {

              if( type == "destroy" ){
                this.msg.destroy(key);
            // this.msg['destroy'](0);
  return
        }
            this.msg[type]({
                content: content,
                key: key,
                duration: duration,
                class: my_class,
            });
            // this.msg.success({ content:content, duration: duration });
            // message.success({ content: 'Loaded!', key, duration: 2 });
        
      
        
         
              
        },
        nt(
            type = "success",
            content,
            description = null,
            duration = 1000,
            placement = "bottomRight"
        ) {
            // msg[type](content, { duration: duration });
            // this.notification[type]({
            this.noti[type]({
                message: content,
                description: description,
                duration: duration,
                placement: placement,
            });
        },
    },
});
