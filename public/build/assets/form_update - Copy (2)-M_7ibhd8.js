import{P as N}from"./PlusOutlined-CuKesnqQ.js";import"./index-BSMZMoC6.js";import{I as q}from"./Search-DKdOCY9h.js";import{C as B}from"./index-DCh57rzN.js";import{B as E}from"./index-lgGGxHJv.js";import{F}from"./index-DGrp3v0u.js";import{y as V,d as j,o as s,e as i,b as e,w as t,f as P,E as $,F as A,h as I,a as g,u as R,g as f,t as v}from"./app-DuCM5fMY.js";import{_ as S}from"./Ribbon-Tv3FPnrK.js";import{_ as D}from"./FormItem-CXqkb-Sw.js";import"./AntdIcon-9khPcjWE.js";import"./LoadingOutlined-C7QN_DUS.js";import"./FormItemContext-WqdLE0eK.js";import"./index-Nnij7LAV.js";import"./CloseCircleFilled-BQZlZZal.js";import"./motion-DAWOpLEP.js";import"./useState-BLwVHUq_.js";import"./index-Da8uXs_6.js";import"./EyeOutlined-CMaT_qmz.js";import"./isPlainObject-CkZT4Lg7.js";import"./KeyCode-B_gOgbN6.js";import"./index-BPASUVML.js";import"./shallowequal-BtM4LMc3.js";import"./_arrayIncludes-BICyThra.js";import"./collapseMotion-iRHk9BZf.js";import"./slide-B7qp9WAr.js";import"./index-CLPL0Y6L.js";import"./hasIn-DNGWpuSq.js";import"./_flatRest-18Z7FUzD.js";import"./isMobile-BbN7I0i_.js";import"./useMergedState-Y_64JI8B.js";import"./CloseOutlined-CxVmtEZu.js";import"./ExclamationCircleFilled-B0V7oa9j.js";import"./styleChecker-Bo7eabvc.js";const L=["dir"],M={class:"p-0 w-full flex-row flex justify-evenly"},O={class:"p-0 w-full flex-row flex justify-evenly"},xe={__name:"form_update - Copy (2)",props:["open_me","data","lang"],emits:["save_update","cancel"],setup(l,{emit:b}){const o=l,_=b;V(()=>{});const k={labelCol:{span:8},wrapperCol:{span:14}},h=j(),y=()=>{if(o.data.grades==""||o.data.grades==null){alert("choose grades");return}if(o.data.name==""||o.data.name_ar==""){alert("Name is required");return}_("save_update",o.data)},x={name:[{required:!0,trigger:"change"}],name_ar:[{required:!0,trigger:"change"}],grades:[{required:!0,trigger:"change"}],stage:[{required:!0,trigger:"change"}]};return(p,n)=>{const d=q,r=D,c=B,m=E,w=F,U=S;return o.data?(s(),i("div",{key:0,dir:l.lang=="en"?"lrt":"rtl"},[e(U,{text:"update    semester Exam",dir:"ltr",class:"w-full text-center",color:"blue"},{default:t(()=>[e(c,{hoverable:"",title:" ",class:"cursor-default w-full",dir:l.lang=="en"?"lrt":"rtl"},{default:t(()=>[e(w,$({dir:l.lang=="en"?"lrt":"rtl",ref_key:"formRef",ref:h,name:"custom-validation",model:l.data,rules:x},k),{default:t(()=>[e(r,{"has-feedback":"",label:l.lang=="en"?"name":"الاسم انجليزي",name:"name"},{default:t(()=>[e(d,{value:o.data.detail,"onUpdate:value":n[0]||(n[0]=a=>o.data.detail=a),type:"text",autocomplete:"off"},null,8,["value"])]),_:1},8,["label"]),e(r,{"has-feedback":"",label:l.lang=="en"?"Name Arabic":"الاسم عربي",name:"ar"},{default:t(()=>[e(d,{value:o.data.ar,"onUpdate:value":n[1]||(n[1]=a=>o.data.ar=a),type:"text",autocomplete:"off"},null,8,["value"])]),_:1},8,["label"]),(s(!0),i(A,null,I(o.data.my_subject_title,(a,C)=>(s(),i("div",{key:C,class:"flex-col flex"},[e(c,{hoverable:"",class:"cursor-default w-full",dir:l.lang=="en"?"lrt":"rtl"},{title:t(()=>[e(r,{"has-feedback":"",label:l.lang=="en"?"   detail ":" detail   ",name:"detail"},{default:t(()=>[e(d,{value:a.detail,"onUpdate:value":u=>a.detail=u,type:"text",autocomplete:"off"},null,8,["value","onUpdate:value"])]),_:2},1032,["label"])]),default:t(()=>[g("div",M,[e(r,{"has-feedback":"",label:l.lang=="en"?" name ":"الاسم عربي  ",name:"ar"},{default:t(()=>[e(d,{value:a.ar,"onUpdate:value":u=>a.ar=u,type:"text",autocomplete:"off"},null,8,["value","onUpdate:value"])]),_:2},1032,["label"]),e(r,{"has-feedback":"",label:l.lang=="en"?" name English":"English الاسم ",name:"en"},{default:t(()=>[e(d,{value:a.en,"onUpdate:value":u=>a.en=u,type:"text",autocomplete:"off"},null,8,["value","onUpdate:value"])]),_:2},1032,["label"])]),g("div",O,[e(r,{"has-feedback":"",label:l.lang=="en"?"   highest_mark ":" highest_mark   ",name:"highest_mark"},{default:t(()=>[e(d,{value:a.highest_mark,"onUpdate:value":u=>a.highest_mark=u,type:"number",autocomplete:"off"},null,8,["value","onUpdate:value"])]),_:2},1032,["label"]),e(r,{"has-feedback":"",label:l.lang=="en"?"   lowest_mark ":" lowest_mark   ",name:"lowest_mark"},{default:t(()=>[e(d,{value:a.lowest_mark,"onUpdate:value":u=>a.lowest_mark=u,type:"number",autocomplete:"off"},null,8,["value","onUpdate:value"])]),_:2},1032,["label"])])]),_:2},1032,["dir"])]))),128)),e(m,{type:"dashed",block:"",onClick:p.addUser},{default:t(()=>[e(R(N)),f(" Add user ")]),_:1},8,["onClick"]),e(r,{"has-feedback":"",label:"notes",name:"notes"},{default:t(()=>[e(d,{value:o.data.notes,"onUpdate:value":n[2]||(n[2]=a=>o.data.notes=a),type:"text",autocomplete:"off"},null,8,["value"])]),_:1}),e(r,{"wrapper-col":{span:14,offset:4}},{default:t(()=>[e(m,{class:"px-8 mx-4",type:"primary","html-type":"submit",onClick:n[3]||(n[3]=a=>y())},{default:t(()=>[f(v(l.lang=="en"?" Save ":" حفظ التعديل  "),1)]),_:1}),e(m,{style:{"margin-left":"10px"},onClick:n[4]||(n[4]=a=>p.$emit("cancel"))},{default:t(()=>[f(v(l.lang=="en"?" Cancel":" الغاء    "),1)]),_:1})]),_:1})]),_:1},16,["dir","model"])]),_:1},8,["dir"])]),_:1})],8,L)):P("",!0)}}};export{xe as default};
