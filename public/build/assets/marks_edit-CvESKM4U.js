import b from"./main_co-B_5p6Rco.js";import{u as B}from"./appstore-i93wDcAb.js";import{d as r,m as D,o as m,e as p,g as N,a as v,t as V,c as $,ah as x,f as A}from"./app-DuCM5fMY.js";import"./my_table-clBnlGMs.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./SaveOutlined-C-xOJ6-3.js";import"./AntdIcon-9khPcjWE.js";import"./ReloadOutlined-CERf7MDg.js";import"./EditOutlined-CQNci86I.js";import"./DeleteOutlined-B394q2Md.js";import"./MoreOutlined-Dn8n-63j.js";import"./index-lgGGxHJv.js";import"./LoadingOutlined-C7QN_DUS.js";import"./useState-BLwVHUq_.js";import"./index-XB80zlEa.js";import"./motion-DAWOpLEP.js";import"./Ribbon-Tv3FPnrK.js";import"./index-CLPL0Y6L.js";import"./index-C6upw1zv.js";import"./DownOutlined-BUTiwnGH.js";import"./isMobile-BbN7I0i_.js";import"./KeyCode-B_gOgbN6.js";import"./FormItemContext-WqdLE0eK.js";import"./index-Nnij7LAV.js";import"./index-D9SNFcq0.js";import"./index-RfeOYOn2.js";import"./form_create-CqHG_feg.js";import"./index-BSMZMoC6.js";import"./Search-DKdOCY9h.js";import"./CloseCircleFilled-BQZlZZal.js";import"./isPlainObject-CkZT4Lg7.js";import"./index-Da8uXs_6.js";import"./EyeOutlined-CMaT_qmz.js";import"./index-DyeIOCE9.js";import"./pickAttrs-BzBa2xXa.js";import"./slide-B7qp9WAr.js";import"./useMergedState-Y_64JI8B.js";import"./CheckOutlined-ClQcdeBd.js";import"./CloseOutlined-CxVmtEZu.js";import"./move-C_MpYLjS.js";import"./index-DGrp3v0u.js";import"./FormItem-CXqkb-Sw.js";import"./ExclamationCircleFilled-B0V7oa9j.js";import"./hasIn-DNGWpuSq.js";import"./styleChecker-Bo7eabvc.js";import"./collapseMotion-iRHk9BZf.js";import"./_arrayIncludes-BICyThra.js";import"./_flatRest-18Z7FUzD.js";import"./index-DCh57rzN.js";import"./index-BPASUVML.js";import"./shallowequal-BtM4LMc3.js";import"./PlusOutlined-CuKesnqQ.js";import"./form_update-DPeDnIIX.js";import"./PrinterOutlined-C9PcfO5m.js";const j={class:"hidden h-0"},C={key:0,class:"p-0 w-full"},T=v("div",{class:"p-12"},null,-1),zt={__name:"marks_edit",props:["data_edit"],setup(l){const o=B(),a=r({}),n=r("view"),i=r({my_mood:"view"}),f=r({teacher_start:"",teacher_end:"",student_start:"",student_end:"",en:"",ar:"",stage:null,grades:"",notes:null}),g=D(()=>(o.d_fun=="create"&&(n.value="view",i.value.my_mood="view"),o.d_fun=="create"&&(n.value="view",i.value.my_mood="view"),o.d_fun=="save_all"&&(show_my_classes(),h(_.value)),o.d_counter)),_=r([]),h=t=>{_.value=t,a.value.school_id=t.school_id,a.value.subject_id=t.subject_id,a.value.class_id=t.class_id,d()},d=()=>{o.d({fun:"class_marks2",data:a.value},{route:"/api/teacher_marks_edit",msg:o.lang=="en"?"Done with success":"تم بنجاح",loading:!0,res_ver:"class_marks2",msg_error:"msg_error",sys_error:!0,log:!0,d_fun:"class_marks2"})},w=r(null),k=r([{col:"ar",en:"Name Arabic",show:!0,ar:"الاسم عربي  "},{col:"en",en:"teacher_start",show:!0,ar:"بداية المعلم"},{col:"notes",en:"notes",show:!0,ar:"ملاحظات"}]);function y(){o.d({fun:"school_list",data:null},{route:"/api/teacher_marks_edit",msg:null,loading:!0,res_ver:"school_list",msg_error:"msg_error",sys_error:!0,log:!0,d_fun:"school_list"})}y();function S(t){if(!selected_school_id.value){alert("no school selected");return}o.d({fun:"create",data:{school_id:selected_school_id.value,semester_id:data_edit.data[0].semester_id,data:t}},{route:"/api/teacher_marks_edit",msg:o.lang=="en"?"create Done with success":" create تم بنجاح",loading:!0,res_ver:"create",msg_error:"msg_error",sys_error:!0,log:!0,d_fun:"create"})}function E(t){}function q(t){}return(t,e)=>{var u,c;return m(),p("div",null,[N(" vvvvvvvvvvvvvvvvvvvvvvvvvvvv fffffffffffffff "),v("div",j,V(g.value),1),(u=l.data_edit)!=null&&u.data?(m(),p("div",C,[(m(),$(x(b),{data:(c=l.data_edit)==null?void 0:c.data,data_create:f.value,my_mood1:i.value,onView:e[0]||(e[0]=s=>d()),settings:{title:w.value,lang:"ar",cols:k.value,can_edit:!1,can_new:!1},onSave_update:e[1]||(e[1]=s=>t.show_my_classes()),onSave_create:e[2]||(e[2]=s=>S(s)),onSave_delete:e[3]||(e[3]=s=>void 0),onText_filter:e[4]||(e[4]=s=>void 0)},null,40,["data","data_create","my_mood1","settings"]))])):A("",!0),T])}}};export{zt as default};