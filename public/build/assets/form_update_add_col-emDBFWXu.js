import{M as B,S as A}from"./MinusCircleOutlined-XRSzOqqT.js";import{P as S}from"./PlusOutlined-CuKesnqQ.js";import{a as V}from"./index-DyeIOCE9.js";import"./index-BSMZMoC6.js";import{I as q}from"./Search-DKdOCY9h.js";import{B as L}from"./index-lgGGxHJv.js";import{F as O}from"./index-DGrp3v0u.js";import{K as T,d as h,m as $,s as I,o as r,c as d,w as t,e as c,F as y,h as k,f as P,b as e,g as f,u as C}from"./app-DuCM5fMY.js";import{_ as R}from"./FormItem-CXqkb-Sw.js";import"./LoadingOutlined-C7QN_DUS.js";import"./AntdIcon-9khPcjWE.js";import"./motion-DAWOpLEP.js";import"./useState-BLwVHUq_.js";import"./KeyCode-B_gOgbN6.js";import"./pickAttrs-BzBa2xXa.js";import"./slide-B7qp9WAr.js";import"./index-Da8uXs_6.js";import"./isMobile-BbN7I0i_.js";import"./useMergedState-Y_64JI8B.js";import"./DownOutlined-BUTiwnGH.js";import"./CheckOutlined-ClQcdeBd.js";import"./CloseOutlined-CxVmtEZu.js";import"./CloseCircleFilled-BQZlZZal.js";import"./FormItemContext-WqdLE0eK.js";import"./index-Nnij7LAV.js";import"./move-C_MpYLjS.js";import"./EyeOutlined-CMaT_qmz.js";import"./isPlainObject-CkZT4Lg7.js";import"./hasIn-DNGWpuSq.js";import"./_arrayIncludes-BICyThra.js";import"./collapseMotion-iRHk9BZf.js";import"./_flatRest-18Z7FUzD.js";import"./ExclamationCircleFilled-B0V7oa9j.js";import"./styleChecker-Bo7eabvc.js";import"./index-CLPL0Y6L.js";const D={key:0,class:"p-0"},we=T({__name:"form_update_add_col",props:["data","lang","titles"],setup(s){const w=h(),n=h([]);$(()=>(n.value=n.value.slice(0,1),n.value.slice(0,1)));const m=I({users:[]}),x=p=>{const l=m.users.indexOf(p);l!==-1&&m.users.splice(l,1)},N=()=>{m.users.push({first:"",last:"",id:Date.now()})},U=p=>{},_=()=>(n.value=n.value.slice(0,1),n.value.slice(0,1));return(p,l)=>{const v=V,i=R,g=q,M=A,b=L,F=O;return r(),d(F,{ref_key:"formRef",ref:w,name:"dynamic_form_nest_item",model:m,onFinish:U},{default:t(()=>[s.titles?(r(),c("div",D,[(r(!0),c(y,null,k(s.titles,(a,u)=>(r(),d(v,{key:u,value:a.ar,"onUpdate:value":o=>a.ar=o,class:"w-24",mode:"tags",style:{width:"244px"},placeholder:"Tags Mode",options:a,"show-search":"",onChange:l[0]||(l[0]=o=>_()),"field-names":{label:"ar",value:"id",options:"data"}},null,8,["value","onUpdate:value","options"]))),128))])):P("",!0),(r(!0),c(y,null,k(m.users,(a,u)=>(r(),d(M,{key:a.id,style:{display:"flex","margin-bottom":"8px"},align:"baseline"},{default:t(()=>[e(i,{label:s.lang=="en"?"Name Arabic":"الاسم عربي",name:["users",u,"first"],rules:{required:!0,message:"Missing first name"}},{default:t(()=>[f(' v-model:value="title2" '),e(v,{class:"w-24",mode:"tags",style:{width:"244px"},placeholder:"Tags Mode",options:s.data,"show-search":"",onChange:l[1]||(l[1]=o=>_()),"field-names":{label:"ar",value:"ar",options:"data"}},null,8,["options"])]),_:2},1032,["label","name"]),e(i,{label:s.lang=="en"?"Name Arabic":"الاسم عربي",name:["users",u,"last"],rules:{required:!0,message:"Missing last name"}},{default:t(()=>[e(g,{value:a.last,"onUpdate:value":o=>a.last=o,placeholder:"Last Name"},null,8,["value","onUpdate:value"])]),_:2},1032,["label","name"]),e(i,{label:s.lang=="en"?"Name Arabic":"الاسم عربي",name:["users",u,"last"],rules:{required:!0,message:"Missing last name"}},{default:t(()=>[e(g,{value:a.last,"onUpdate:value":o=>a.last=o,placeholder:"Last Name"},null,8,["value","onUpdate:value"])]),_:2},1032,["label","name"]),e(C(B),{onClick:o=>x(a)},null,8,["onClick"])]),_:2},1024))),128)),e(i,null,{default:t(()=>[e(b,{type:"dashed",block:"",onClick:N},{default:t(()=>[e(C(S)),f(" Add user ")]),_:1})]),_:1}),e(i,null,{default:t(()=>[e(b,{type:"primary","html-type":"submit"},{default:t(()=>[f("Submit")]),_:1})]),_:1})]),_:1},8,["model"])}}});export{we as default};