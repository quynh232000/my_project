"use client";

import { SLoginGoogle } from "@/services/app/auth/SLoginGoogle";
import { useUserInformationStore } from "@/store/user-information/store";
import {  GoogleLogin } from "@react-oauth/google";
import { toast } from "sonner";
import Cookies from 'js-cookie';
import { DEFAULT_COOKIE_OPTIONS } from "@/utils/cookie";
import { addDays } from "date-fns/esm";
import { useRouter } from "next/navigation";
export default function LoginGoogle({
  setOpen,
}: {
  setOpen: (a: boolean) => void;
}) {
  const setUserInformationState = useUserInformationStore(
    (state) => state.setUserInformationState
  );
  const router = useRouter()
  return (
    <GoogleLogin
      onSuccess={(credentialResponse) => {
        const token = credentialResponse.credential; // <-- ID Token (JWT)
        if (token) {
          SLoginGoogle({ token }).then((res) => {
            if (res) {
              toast.success(res.message);
              setUserInformationState(res.data);
              setOpen(false);
              Cookies.set("access_token", res.meta.access_token, {
                ...DEFAULT_COOKIE_OPTIONS,
                expires: addDays(new Date(), 7),
              });
              if (res.meta.refresh_token) {
                Cookies.set("refresh_token", res.meta.refresh_token, {
                  ...DEFAULT_COOKIE_OPTIONS,
                  expires: addDays(new Date(), 7),
                });
              }
              router.push('/')
            } else {
              toast.error("Đã xảy ra lỗi");
            }
          });
        } else {
          toast.error("Đã xảy ra lỗi");
        }
      }}
      onError={() => {
        console.log("Login Failed");
        toast.error("Google login failed");
      }}
    />
  );
}


// import { SLoginGoogle } from "@/services/app/auth/SLoginGoogle";
// import { useUserInformationStore } from "@/store/user-information/store";
// import {  useGoogleLogin } from "@react-oauth/google";
// import { toast } from "sonner";
// import Cookies from 'js-cookie';
// import { DEFAULT_COOKIE_OPTIONS } from "@/utils/cookie";
// import { addDays } from "date-fns/esm";
// export default function LoginGoogle({setOpen}:{setOpen:((a:boolean)=>void)}) {
//     const setUserInformationState = useUserInformationStore(
//                     (state) => state.setUserInformationState
//                 );
//     const login = useGoogleLogin({
//         onSuccess: (tokenResponse) => {
//             const token = tokenResponse.access_token
//         if(token){
//             SLoginGoogle({token}).then(res=>{
//                 if(res){
//                     toast.success(res.message)
//                         setUserInformationState(res.data);
//                         setOpen(false)
//                         Cookies.set('access_token',res.meta.access_token,{
//                             ...DEFAULT_COOKIE_OPTIONS,
//                             expires: addDays(new Date(), 7),
//                         })
//                         if(res.meta.refresh_token){
//                             Cookies.set('refresh_token',res.meta.refresh_token,{
//                             ...DEFAULT_COOKIE_OPTIONS,
//                             expires: addDays(new Date(), 7),
//                         })
//                         }
//                 }else{
//                     toast.error('Đã xảy ra lỗi')
//                 }
//             })
//         }else{
//             toast.error('Đã xảy ra lỗi')
//         }
//         },
//         onError: () => console.log("Login Failed"),
//     });

//   return (
//     <button
//       onClick={() => login()}
//       className=" gap-2 border border-primary-200 hover:bg-primary-50 w-full flex justify-center items-center px-4 py-2 rounded-lg"
//     >
//       <svg
//         xmlns="http://www.w3.org/2000/svg"
//         viewBox="0 0 48 48"
//         className="w-5 h-5"
//       >
//         <path
//           fill="#FFC107"
//           d="M43.6 20.5H42V20H24v8h11.3C33.6 33.1 29.3 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.9 1.2 8 3.1l5.7-5.7C34.1 6.5 29.3 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.3-.1-2.3-.4-3.5z"
//         />
//         <path
//           fill="#FF3D00"
//           d="M6.3 14.7l6.6 4.8C14.2 16 18.8 14 24 14c3.1 0 5.9 1.2 8 3.1l5.7-5.7C34.1 6.5 29.3 4 24 4c-7.4 0-13.7 4-17.7 10.7z"
//         />
//         <path
//           fill="#4CAF50"
//           d="M24 44c5.2 0 10.1-2 13.7-5.3l-6.3-5.2C29.2 35.8 26.7 37 24 37c-5.3 0-9.8-3.4-11.4-8.1l-6.6 5.1C10.3 39.8 16.7 44 24 44z"
//         />
//         <path
//           fill="#1976D2"
//           d="M43.6 20.5H42V20H24v8h11.3c-1.1 3.2-3.6 5.7-6.6 7.1l6.3 5.2C39.6 37.1 44 31.1 44 24c0-1.3-.1-2.3-.4-3.5z"
//         />
//       </svg>
//       Đăng nhập với Google
//     </button>
//   );
// }