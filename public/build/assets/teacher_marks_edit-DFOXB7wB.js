import I from"./teacher_dashboard_com-CseVHc3N.js";import A from"./marks_edit-CvESKM4U.js";import{u as B}from"./appstore-i93wDcAb.js";import{_ as D}from"./_plugin-vue_export-helper-DlAUqK2U.js";import{d as e,y as j,m as C,o as w,e as x,g as k,u as y,f as E,a as i,t as G,b,w as H,G as M,H as T}from"./app-DuCM5fMY.js";import"./corner-CBvBHdsw.js";import"./LoadingOutlined-C7QN_DUS.js";import"./AntdIcon-9khPcjWE.js";import"./useState-BLwVHUq_.js";import"./CloseOutlined-CxVmtEZu.js";import"./CheckOutlined-ClQcdeBd.js";import"./ExclamationCircleFilled-B0V7oa9j.js";import"./CloseCircleFilled-BQZlZZal.js";import"./index-DCh57rzN.js";import"./KeyCode-B_gOgbN6.js";import"./index-BPASUVML.js";import"./motion-DAWOpLEP.js";import"./shallowequal-BtM4LMc3.js";import"./_arrayIncludes-BICyThra.js";import"./collapseMotion-iRHk9BZf.js";import"./slide-B7qp9WAr.js";import"./index-Da8uXs_6.js";import"./index-CLPL0Y6L.js";import"./hasIn-DNGWpuSq.js";import"./_flatRest-18Z7FUzD.js";import"./isMobile-BbN7I0i_.js";import"./useMergedState-Y_64JI8B.js";import"./PlusOutlined-CuKesnqQ.js";import"./isPlainObject-CkZT4Lg7.js";import"./main_co-B_5p6Rco.js";import"./my_table-clBnlGMs.js";import"./SaveOutlined-C-xOJ6-3.js";import"./ReloadOutlined-CERf7MDg.js";import"./EditOutlined-CQNci86I.js";import"./DeleteOutlined-B394q2Md.js";import"./MoreOutlined-Dn8n-63j.js";import"./index-lgGGxHJv.js";import"./index-XB80zlEa.js";import"./Ribbon-Tv3FPnrK.js";import"./index-C6upw1zv.js";import"./DownOutlined-BUTiwnGH.js";import"./FormItemContext-WqdLE0eK.js";import"./index-Nnij7LAV.js";import"./index-D9SNFcq0.js";import"./index-RfeOYOn2.js";import"./form_create-CqHG_feg.js";import"./index-BSMZMoC6.js";import"./Search-DKdOCY9h.js";import"./EyeOutlined-CMaT_qmz.js";import"./index-DyeIOCE9.js";import"./pickAttrs-BzBa2xXa.js";import"./move-C_MpYLjS.js";import"./index-DGrp3v0u.js";import"./FormItem-CXqkb-Sw.js";import"./styleChecker-Bo7eabvc.js";import"./form_update-DPeDnIIX.js";import"./PrinterOutlined-C9PcfO5m.js";const n=m=>(M("data-v-221a3c6f"),m=m(),T(),m),$={key:0,class:"text-center red"},q=n(()=>i("div",{class:"p-2"},"No classes found",-1)),z=n(()=>i("div",{class:"p-2"},"لا يوجد فصول",-1)),F=[q,z],J={class:"hidden h-0"},K={class:"p-0 overflow-auto h-64"},L=n(()=>i("div",{class:"p-12"},null,-1)),O={__name:"teacher_marks_edit",props:["data"],setup(m){const t=B();e(null),e(null),e(null);const l=e({});j(()=>{c()});const c=()=>{t.d({fun:"show",data:null},{route:"/api/teacher_marks_edit",msg:t.lang=="en"?"Done with success":"تم بنجاح",loading:!0,res_ver:"show",msg_error:"msg_error",sys_error:!0,log:!0,d_fun:"show"})},u=e("view"),p=e({my_mood:"view"});e({teacher_start:"",teacher_end:"",student_start:"",student_end:"",en:"",ar:"",stage:null,grades:"",notes:null});const N=C(()=>(t.d_fun=="create"&&(u.value="view",p.value.my_mood="view"),t.d_fun=="create"&&(u.value="view",p.value.my_mood="view"),t.d_fun=="save_all"&&(c(),h(g.value)),t.d_counter)),g=e([]),h=r=>{if(g.value=r,l.value.school_id=r.school_id,l.value.subject_id=r.subject_id,l.value.class_id=r.class_id,!r.class_id){alert("no class selected");return}S()},f=e({}),S=()=>{var r={fun:"class_marks2",data:l.value},s={route:"/api/teacher_marks_edit",msg:t.lang=="en"?"Done with success":"تم بنجاح",loading:!0,res_ver:"class_marks2",msg_error:"msg_error",sys_error:!0,log:!0,d_fun:"class_marks2"};t.loading=!0,axios.post(s.route,{data:r}).then(o=>{f.value=o.data,t.d_counter++,t.d_fun=s.d_fun,t.res[s.res_ver]=o.data,t.loading=!1,(s==null?void 0:s.msg)!=null&&t.msg("success",s.msg)}).catch(o=>{var a,d,v;if(t.loading=!1,((a=o==null?void 0:o.response)==null?void 0:a.status)==419){if(!confirm("reload"))return;window.location.reload()}var _=s.msg_error+" :"+((v=(d=o==null?void 0:o.response)==null?void 0:d.data)==null?void 0:v.message);s.msg!=null&&t.msg("error",_)})};e(null),e([{col:"ar",en:"Name Arabic",show:!0,ar:"الاسم عربي  "},{col:"en",en:"teacher_start",show:!0,ar:"بداية المعلم"},{col:"notes",en:"notes",show:!0,ar:"ملاحظات"}]);function V(){t.d({fun:"school_list",data:null},{route:"/api/teacher_marks_edit",msg:null,loading:!0,res_ver:"school_list",msg_error:"msg_error",sys_error:!0,log:!0,d_fun:"school_list"})}return V(),(r,s)=>{var o,_,a;return w(),x("div",null,[k("xxxxxxxxxxxxxx "),((a=(_=(o=y(t).res)==null?void 0:o.show)==null?void 0:_.my_classes)==null?void 0:a.length)==0?(w(),x("div",$,F)):E("",!0),i("div",J,G(N.value),1),i("div",K,[b(I,{class:"red bg-transparent border",data:{lang:y(t).lang},onView:s[0]||(s[0]=d=>h(d))},null,8,["data"])]),b(A,{data_edit:f.value},{default:H(()=>[k(" marks_edit err ")]),_:1},8,["data_edit"]),L])}}},Ut=D(O,[["__scopeId","data-v-221a3c6f"]]);export{Ut as default};