import{T as P,k as C,s as D,l as $,m as n,o as m,f as h,a as e,u as S,w as s,F as x,Z as q,b as t,p as k,t as d,d as p,Q as b,O as F,c as w}from"./app-8-w6o4Bu.js";import{_ as M}from"./BasicLayout-CGxwuHuQ.js";import{_ as O}from"./TextInput-tmRbSbIb.js";import{P as U}from"./PrimaryButton-DGt6v6F_.js";import{_ as I}from"./Address-MZSRajaz.js";import"./ApplicationLogo-BxCuFeai.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const E={class:"py-12"},K={class:"max-w-7xl mx-auto px-6 lg:px-8 space-y-5"},Q=t("h1",{class:"font-bold text-lg text-uppercase"},"Pemesanan",-1),Z=t("h2",{class:"font-semibold text-md"},"Lokasi Penerima",-1),z=t("h2",{class:"font-semibold text-md"},"Detail Pesanan",-1),A={class:"space-y-6"},G={class:"w-full justify-between flex items-center"},H={class:"text-sm"},J={class:"flex sm:flex-row flex-col items-center sm:justify-between"},W={class:"flex items-center"},X={class:"ml-4"},Y={class:"flex items-center space-x-5"},tt=t("h1",{class:"font-bold"},"Total:",-1),et={class:"p-4 sm:p-8 bg-white shadow sm:rounded-lg"},st=t("h2",{class:"font-semibold text-md"}," Merasa Terbantu? Kirim donasi untuk layanan kami ",-1),at=t("h2",{class:"font-semibold text-md"},"Detail Pembayaran",-1),ot={class:"p-4 sm:p-8 bg-white shadow sm:rounded-lg grid grid-cols-2 gap-2 items-center"},nt=t("p",null,"Subtotal",-1),lt={class:"text-right"},dt=t("p",null,"Donasi",-1),it={class:"text-right"},ct=t("p",{class:"font-bold"},"Total",-1),rt={class:"text-right font-bold"},xt={__name:"Index",props:{canLogin:{type:Boolean},canRegister:{type:Boolean},data:{type:Object}},setup(i){P({is_active:!1,name:"",phone:"",address:"",subdistrict:"",district:"",city:"",province:"",latitude:"",longitude:"",gmaps_point:"",notes:""});const c=C({edit:!1,checkout:!1}),B=()=>{console.log(b().props.data);const l={products:b().props.data.products.map(a=>({store:{id:a.store.id},total:a.total,products:a.products.map(r=>({id:r.id,title:r.title,quantity:r.quantity,price:r.price}))})),address:b().props.data.address,donate:u.value};F.post("/order/add",l)},u=D(null),_=l=>l!=null&&l>0?(l=Math.round(l),l.toLocaleString("id-ID")):0;return $(()=>{}),(l,a)=>{const r=n("v-card-title"),V=n("v-card-item"),f=n("v-divider"),R=n("v-list-item"),L=n("v-list"),T=n("v-card-text"),j=n("v-card-actions"),N=n("v-card"),g=n("v-btn"),y=n("v-snackbar");return m(),h(x,null,[e(S(q),{title:"Setiap Bagian Berharga"}),e(M,{canLogin:i.canLogin,canRegister:i.canRegister},{default:s(()=>[t("div",E,[t("div",K,[Q,Z,e(I,{address:i.data.address.address,name:i.data.address.name},null,8,["address","name"]),z,t("div",A,[(m(!0),h(x,null,k(i.data.products,o=>(m(),w(N,{class:"w-full py-2"},{default:s(()=>[e(V,null,{default:s(()=>[e(r,null,{default:s(()=>[t("div",G,[t("p",null,d(o.store.name),1),t("p",H,d(o.store.province),1)])]),_:2},1024)]),_:2},1024),e(f),e(T,null,{default:s(()=>[e(L,{lines:"two"},{default:s(()=>[(m(!0),h(x,null,k(o.products,v=>(m(),w(R,{rounded:"0",class:"items-center"},{title:s(()=>[t("div",J,[t("div",W,[t("p",X,d(v.title),1)]),t("div",Y,[t("p",null," Rp "+d(_(v.price)),1),t("p",null,"x "+d(v.quantity),1)])])]),_:2},1024))),256)),e(f,{inset:""})]),_:2},1024)]),_:2},1024),e(f),e(j,{class:"flex justify-end space-x-5 px-8"},{default:s(()=>[tt,t("p",null,"Rp "+d(_(o.total.all)),1)]),_:2},1024)]),_:2},1024))),256)),t("div",et,[st,e(O,{class:"w-full",modelValue:u.value,"onUpdate:modelValue":a[0]||(a[0]=o=>u.value=o)},null,8,["modelValue"])]),at,t("div",ot,[nt,t("p",lt," Rp "+d(_(i.data.total.products)),1),dt,t("p",it,"Rp "+d(_(u.value)),1),ct,t("p",rt," Rp "+d(_(Number(i.data.total.all)+Number(u.value))),1)]),e(U,{onClick:B,class:"w-full py-3 flex justify-center items-center"},{default:s(()=>[p(" Bayar sekarang ")]),_:1})])])])]),_:1},8,["canLogin","canRegister"]),e(y,{modelValue:c.edit,"onUpdate:modelValue":a[2]||(a[2]=o=>c.edit=o)},{actions:s(()=>[e(g,{color:"pink",variant:"text",onClick:a[1]||(a[1]=o=>c.edit=!1)},{default:s(()=>[p(" Tutup ")]),_:1})]),default:s(()=>[p(" Berhasil mengubah jumlah ")]),_:1},8,["modelValue"]),e(y,{modelValue:c.checkout,"onUpdate:modelValue":a[4]||(a[4]=o=>c.checkout=o)},{actions:s(()=>[e(g,{color:"pink",variant:"text",onClick:a[3]||(a[3]=o=>c.edit=!1)},{default:s(()=>[p(" Tutup ")]),_:1})]),default:s(()=>[p(" Berhasil checkout ")]),_:1},8,["modelValue"])],64)}}};export{xt as default};