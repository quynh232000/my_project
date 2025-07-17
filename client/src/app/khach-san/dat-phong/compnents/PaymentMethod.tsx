import React from "react";
import {
  Accordion,
  AccordionHeader,
  AccordionBody,
  Radio,
} from "@material-tailwind/react";
import Image from "next/image";

function PaymentMethod() {
    const [open, setOpen] = React.useState(1);
 
  const handleOpen = (value:any) => setOpen(open === value ? 0 : value);
  return (
    <div>
        {/* item */}
        <Accordion {...({} as any)} open={open === 1}>
                <AccordionHeader  {...({} as any)} >
                    <label  htmlFor="method1" className="text-[16px] flex justify-between items-center w-full">
                        <div onClick={() => handleOpen(1)} className="flex gap-4 items-center">
                            <div className=" relative w-[32px] h-[32px]">
                                <Image
                                 alt=""
                                 fill
                                  className=" object-cover w-full h-full rounded-sm"
                                 src={"/images/common/hotel_1.jpg"}
                                />
                            </div>
                            <div className="text-lg text-gray-600">Chuyển khoản (VietQR miễn phí)</div>
                        </div>
                        <div><Radio name="payment_method" id="method1" {...({} as any)} className=" border-green-300" color="purple"/></div>
                    </label>
                </AccordionHeader>
                <AccordionBody>
                    <div className="text-md font-normal">
                        Hướng dẫn thanh toán sẽ được gửi tới Quý khách khi nhấn nút Thanh toán. 
                        Phòng sẽ được giữ cho bạn, vui lòng thanh toán trước <span className="text-primary-500">00:03 17/07/2025</span>. 
                        <span className="font-semibold"> Quá thời hạn thanh toán trên, chúng tôi không thể đảm bảo giữ phòng cho Quý Khách. </span>
                    </div>
                </AccordionBody>
        </Accordion>
        {/* item */}
        <Accordion {...({} as any)} open={open === 2}>
                <AccordionHeader  {...({} as any)} >
                    <label  htmlFor="method2" className="text-[16px] flex justify-between items-center w-full cursor-pointer">
                        <div onClick={() => handleOpen(2)} className="flex gap-4 items-center">
                            <div className=" relative w-[32px] h-[32px]">
                                <Image
                                 alt=""
                                 fill
                                  className=" object-cover w-full h-full rounded-sm"
                                 src={"/images/common/hotel_1.jpg"}
                                />
                            </div>
                            <div className="text-lg text-gray-600">Vnpay QR</div>
                        </div>
                        <div><Radio name="payment_method" id="method2" {...({} as any)} className=" border-green-300" color="purple"/></div>
                    </label>
                </AccordionHeader>
        </Accordion>
        {/* item */}
        <Accordion {...({} as any)} open={open === 3}>
                <AccordionHeader  {...({} as any)} >
                    <label  htmlFor="method3" className="text-[16px] flex justify-between items-center w-full">
                        <div onClick={() => handleOpen(3)} className="flex gap-4 items-center">
                            <div className=" relative w-[32px] h-[32px]">
                                <Image
                                 alt=""
                                 fill
                                  className=" object-cover w-full h-full rounded-sm"
                                 src={"/images/common/hotel_1.jpg"}
                                />
                            </div>
                            <div className="text-lg text-gray-600">ATM/Internet Banking</div>
                        </div>
                        <div><Radio name="payment_method" id="method3" {...({} as any)} className=" border-green-300" color="purple"/></div>
                    </label>
                </AccordionHeader>
                <AccordionBody>
                    <div className="grid grid-cols-5 gap-1">
                            <div className=" relative w-full h-[52px] border p-2 rounded-lg shadow-md">
                                <Image
                                    alt=""
                                    fill
                                    className=" object-cover w-full h-full rounded-lg"
                                    src={"/images/common/hotel_1.jpg"}
                                />
                            </div>
                            <div className=" relative w-full h-[52px] border p-2 rounded-lg shadow-md">
                                <Image
                                    alt=""
                                    fill
                                    className=" object-cover w-full h-full rounded-lg"
                                    src={"/images/common/hotel_1.jpg"}
                                />
                            </div>
                            <div className=" relative w-full h-[52px] border p-2 rounded-lg shadow-md">
                                <Image
                                    alt=""
                                    fill
                                    className=" object-cover w-full h-full rounded-lg"
                                    src={"/images/common/hotel_1.jpg"}
                                />
                            </div>
                            <div className=" relative w-full h-[52px] border p-2 rounded-lg shadow-md">
                                <Image
                                    alt=""
                                    fill
                                    className=" object-cover w-full h-full rounded-lg"
                                    src={"/images/common/hotel_1.jpg"}
                                />
                            </div>
                            <div className=" relative w-full h-[52px] border p-2 rounded-lg shadow-md">
                                <Image
                                    alt=""
                                    fill
                                    className=" object-cover w-full h-full rounded-lg"
                                    src={"/images/common/hotel_1.jpg"}
                                />
                            </div>
                            <div className=" relative w-full h-[52px] border p-2 rounded-lg shadow-md">
                                <Image
                                    alt=""
                                    fill
                                    className=" object-cover w-full h-full rounded-lg"
                                    src={"/images/common/hotel_1.jpg"}
                                />
                            </div>
                            <div className=" relative w-full h-[52px] border p-2 rounded-lg shadow-md">
                                <Image
                                    alt=""
                                    fill
                                    className=" object-cover w-full h-full rounded-lg"
                                    src={"/images/common/hotel_1.jpg"}
                                />
                            </div>
                            <div className=" relative w-full h-[52px] border p-2 rounded-lg shadow-md">
                                <Image
                                    alt=""
                                    fill
                                    className=" object-cover w-full h-full rounded-lg"
                                    src={"/images/common/hotel_1.jpg"}
                                />
                            </div>
                            <div className=" relative w-full h-[52px] border p-2 rounded-lg shadow-md">
                                <Image
                                    alt=""
                                    fill
                                    className=" object-cover w-full h-full rounded-lg"
                                    src={"/images/common/hotel_1.jpg"}
                                />
                            </div>
                            <div className=" relative w-full h-[52px] border p-2 rounded-lg shadow-md">
                                <Image
                                    alt=""
                                    fill
                                    className=" object-cover w-full h-full rounded-lg"
                                    src={"/images/common/hotel_1.jpg"}
                                />
                            </div>
                            
                        
                    </div>
                </AccordionBody>
        </Accordion>
        {/* item */}
        <Accordion {...({} as any)} open={open === 2}>
                <AccordionHeader  {...({} as any)} >
                    <label  htmlFor="method4" className="text-[16px] flex justify-between items-center w-full cursor-pointer">
                        <div onClick={() => handleOpen(2)} className="flex gap-4 items-center">
                            <div className=" relative w-[32px] h-[32px]">
                                <Image
                                 alt=""
                                 fill
                                  className=" object-cover w-full h-full rounded-sm"
                                 src={"/images/common/hotel_1.jpg"}
                                />
                            </div>
                            <div className="text-lg text-gray-600">Ví MoMo</div>
                        </div>
                        <div><Radio name="payment_method" id="method4" {...({} as any)} className=" border-green-300" color="purple"/></div>
                    </label>
                </AccordionHeader>
        </Accordion>
         {/* item */}
        <Accordion {...({} as any)} open={open === 2}>
                <AccordionHeader  {...({} as any)} >
                    <label  htmlFor="method5" className="text-[16px] flex justify-between items-center w-full cursor-pointer">
                        <div onClick={() => handleOpen(2)} className="flex gap-4 items-center">
                            <div className=" relative w-[32px] h-[32px]">
                                <Image
                                 alt=""
                                 fill
                                  className=" object-cover w-full h-full rounded-sm"
                                 src={"/images/common/hotel_1.jpg"}
                                />
                            </div>
                            <div className="text-lg text-gray-600">Zalopay</div>
                        </div>
                        <div><Radio name="payment_method" id="method5" {...({} as any)} className=" border-green-300" color="purple"/></div>
                    </label>
                </AccordionHeader>
        </Accordion>
           
    </div>
  )
}

export default PaymentMethod