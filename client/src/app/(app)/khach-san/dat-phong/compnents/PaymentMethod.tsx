import React from "react";
import {
  Accordion,
  AccordionHeader,
  Radio,
} from "@material-tailwind/react";
import Image from "next/image";
const paymentMethods = [
    {
        id:1,
        key:'cod',
        name:'Thanh toán tại khách sạn',
        image:'/images/payment/cod.png'
    },
    {
        id:2,
        key:'banking',
        name:'Chuyển khoản ngân hàng',
        image:'/images/payment/mb.png'
    },
    {
        id:3,
        key:'vnpay',
        name:'VNPay QR',
        image:'/images/payment/vnpay.jpg'
    },
    {
        id:4,
        key:'momo',
        name:'Ví MoMo',
        image:'/images/payment/momo.webp'
    },
    {
        id:5,
        key:'zalopay',
        name:'Zalopay',
        image:'/images/payment/zalopay.webp'
    },
]
function PaymentMethod({setPaymentMethod,paymentMethod}:{setPaymentMethod:(i:string)=>void,paymentMethod:string}) {
  
 

    return (
        <div>
            {paymentMethods.map(item=>{
                return <Accordion key={item.id} {...({} as any)} open={paymentMethod == item.key}>
                    <AccordionHeader  {...({} as any)} >
                        <label  htmlFor={"method"+item.id} className="text-[16px] flex justify-between items-center w-full cursor-pointer">
                            <div  className="flex gap-4 items-center">
                                <div className=" relative w-[32px] h-[32px]">
                                    <Image
                                    alt=""
                                    fill
                                    className=" object-contain w-full h-full rounded-sm"
                                    src={item.image ?? "/images/payment/vnpay.jpg"}
                                    />
                                </div>
                                <div className="text-lg text-gray-600">{item.name}</div>
                            </div>
                            <div><Radio checked={paymentMethod == item.key} onChange={()=>setPaymentMethod(item.key)} name="payment_method" id={"method"+item.id} {...({} as any)} className=" border-green-300" color="purple"/></div>
                        </label>
                    </AccordionHeader>
            </Accordion>
            })}
            
        </div>
    )
}

export default PaymentMethod