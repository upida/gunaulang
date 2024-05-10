import{m as s,o as y,c as S,w as i,a,d as b,t as h,b as o,T as D,k as O,s as k,l as T,f as B,u as f,F as C,Z as z,x as K,n as j,p as A,O as P}from"./app-DN-RUE--.js";import{_ as E}from"./BasicLayout-CC9BFqav.js";import{_ as H}from"./CardSearch-Ch4CIjhZ.js";import{P as I}from"./PrimaryButton-CyOW_sER.js";import{_ as R}from"./Toggle-CB4Xez9i.js";import"./ApplicationLogo-CICgJVQf.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";import"./TextInput-C245VMaA.js";const Z={class:"text-green-600 items-center flex cursor-pointer"},q={__name:"CardProduct",props:{image:{type:String,default:""},name:{type:String},description:{type:String},distance:{type:[String,Number]},store_name:{type:String},image:{type:Array}},emits:["edit"],setup(u,{emit:w}){const e=u,m=l=>l?l<1e3?`${l} M`:`${Math.round(l/1e3)} KM`:"0 M";return(l,V)=>{const g=s("v-img"),p=s("v-card-title"),c=s("v-icon"),v=s("v-card-text"),t=s("v-card");return y(),S(t,{class:"","max-width":"400"},{default:i(()=>{var d,_;return[a(g,{class:"text-white align-end",height:"200",cover:"",src:`${l.route().t.url}/storage/${(_=(d=e.image)==null?void 0:d[0])==null?void 0:_.path}`},null,8,["src"]),a(p,{class:"pt-4"},{default:i(()=>[b(h(e.name),1)]),_:1}),a(v,null,{default:i(()=>[o("div",null,h(m(e.distance)),1),o("div",Z,[a(c,{icon:"mdi-store-outline",class:"mr-2"}),b(h(e.store_name),1)])]),_:1})]}),_:1})}}},G={class:"py-12"},J={class:"max-w-7xl mx-auto px-6 lg:px-8 space-y-8"},Q={class:"flex space-x-5 items-center"},W={class:"bg-white rounded-lg shadow p-6"},X=o("label",{for:""},"Rentang harga",-1),Y=o("label",{for:""},"Rentang tanggal kadaluwarsa",-1),ee={class:"font-bold text-lg mb-5 text-uppercase"},te={class:"grid sm:grid-cols-4 grid-cols-1 gap-6"},de={__name:"Index",props:{canLogin:{type:Boolean},canRegister:{type:Boolean},data:{type:Object}},setup(u){const w=D({is_active:!1,name:"",phone:"",address:"",subdistrict:"",district:"",city:"",province:"",latitude:"",longitude:"",gmaps_point:"",notes:""});let e=O({price_start:"",price_end:"",keyword:"",expired_at_start:null,expired_at_end:null,is_new:!1,is_food:!1});const m=k(!1),l=k(!1),V=(v,t)=>{P.get(`/${v}/${t}`)},g=(v="")=>{var t,d,_,x;e.expired_at_start=((t=c.value)==null?void 0:t[0])??void 0,e.expired_at_end=((d=c.value)==null?void 0:d[1])??void 0,e.price_start=((_=p.value)==null?void 0:_[0])??void 0,e.price_end=((x=p.value)==null?void 0:x[1])??void 0,e.is_new=m.value,e.is_food=l.value,e.keyword=v??void 0,P.get("/search",e)},p=k([0,1e5]),c=k();return T(()=>{e.keyword=route().params.keyword,e={...e,...route().params},c.value=[e.expired_at_start,e.expired_at_end],m.value=e.is_new==="true",l.value=e.is_food==="true"}),(v,t)=>{const d=s("v-icon"),_=s("v-range-slider"),x=s("VueDatePicker"),M=s("v-card-text"),F=s("v-spacer"),L=s("v-card-actions"),U=s("v-card"),N=s("v-dialog");return y(),B(C,null,[a(f(z),{title:"Setiap Bagian Berharga"}),a(E,{canLogin:u.canLogin,canRegister:u.canRegister},{default:i(()=>{var $;return[o("div",G,[o("div",J,[o("div",Q,[a(H,{modelValue:f(e).keyword,"onUpdate:modelValue":t[0]||(t[0]=n=>f(e).keyword=n),onSearch:t[1]||(t[1]=n=>g(n)),class:"w-full"},null,8,["modelValue"]),a(N,{"max-width":"600"},{activator:i(({props:n})=>[o("div",W,[a(d,K(n,{icon:"mdi-filter-outline",class:"cursor-pointer"}),null,16)])]),default:i(({isActive:n})=>[a(U,{title:"Filter"},{default:i(()=>[a(M,{class:"py-6 flex flex-col space-y-6"},{default:i(()=>[o("div",null,[X,a(_,{modelValue:p.value,"onUpdate:modelValue":t[2]||(t[2]=r=>p.value=r),min:0,max:1e5,"thumb-label":"always","hide-details":"",strict:""},null,8,["modelValue"])]),o("div",null,[Y,a(x,{class:"z-50 relative",modelValue:c.value,"onUpdate:modelValue":t[3]||(t[3]=r=>c.value=r),range:"","auto-apply":"","enable-time-picker":!1,"auto-position":!1,"teleport-center":""},null,8,["modelValue"])]),o("div",null,[a(R,{checked:m.value,"onUpdate:checked":t[4]||(t[4]=r=>m.value=r),label:"Kondisi baru"},null,8,["checked"])]),o("div",null,[a(R,{checked:l.value,"onUpdate:checked":t[5]||(t[5]=r=>l.value=r),label:"Makanan"},null,8,["checked"])])]),_:1}),a(L,null,{default:i(()=>[a(F),a(I,{onClick:r=>{n.value=!1,g()},class:j(["ms-4",{"opacity-25":f(w).processing}]),disabled:f(w).processing},{default:i(()=>[b(" Tampilkan ")]),_:2},1032,["onClick","class","disabled"])]),_:2},1024)]),_:2},1024)]),_:1})]),o("h1",ee,h(($=u.data.product)==null?void 0:$.length)+" Hasil Pencarian ",1),o("div",te,[(y(!0),B(C,null,A(u.data.product,n=>(y(),S(q,{name:n.title,onClick:r=>V(n.storename,n.title),image:n.media,distance:n.distance,store_name:n.name},null,8,["name","onClick","image","distance","store_name"]))),256))])])])]}),_:1},8,["canLogin","canRegister"])],64)}}};export{de as default};
