import React, { useState } from 'react'
import {
  Dialog,
  DialogBody,
} from "@material-tailwind/react";
import { IoMdClose } from "react-icons/io";
import { GoInfo } from 'react-icons/go';
import { Policy_cancellation } from '@/services/app/hotel/SGetHotelDetail';
import { format, subDays } from 'date-fns'
import vi from 'date-fns/locale/vi'

function ModelPolicyCancel({
  policy,
  date_start,
  price
}: {
  policy: Policy_cancellation,
  date_start: string,
  price: number
}) {
  const [open, setOpen] = useState(false);
  const checkInDate = new Date(date_start);
  const now = new Date();

  const sortedPolicies = [...policy.policy_cancel_rules].sort((a, b) => b.day - a.day);

  // Lọc các policy còn hiệu lực
  const validPolicies = sortedPolicies.filter(policy => {
    const refundTime = subDays(checkInDate, policy.day);
    return refundTime > now;
  });

  return (
    <div className=''>
      <GoInfo onClick={() => setOpen(true)} className='text-secondary-500 cursor-pointer' />

      <Dialog {...({} as any)}
        open={open}
        size={'sm'}
        handler={() => setOpen(!open)}
      >
        <DialogBody {...({} as any)} className=' min-h-[40vh] text-[16px] font-normal relative p-0 rounded-xl overflow-hidden'>
          <div
            onClick={() => setOpen(!open)}
            className='w-12 h-12 hover:bg-gray-100 absolute right-0 top-0 text-xl rounded-full justify-center items-center flex text-gray-600 cursor-pointer'
          >
            <IoMdClose />
          </div>

          <div className='flex flex-col w-full h-full'>
            <div className='text-center py-4 text-lg w-full font-semibold border-b h-fit'>
              Chính sách hủy
            </div>

            <div className='p-5'>
              <div className='font-semibold'>
                Chính sách hủy: {policy?.name ?? ''}
              </div>

              {validPolicies.length === 0 ? (
                <div className="text-gray-500 italic mt-2">
                  Không còn chính sách hủy áp dụng
                </div>
              ) : (
                <ul className="list-disc pl-5 space-y-1 mt-2">
                  {validPolicies.map((rule, index) => {
                    const refundTime = subDays(checkInDate, rule.day);
                    const formattedDate = format(refundTime, "'15:00' 'ngày' dd/MM/yyyy", { locale: vi });
                    const refundAmount = Math.round(price * (1 - rule.fee / 100));

                    if (rule.fee === 100) {
                      return (
                        <li key={index}>
                          Bạn sẽ không được hoàn tiền nếu hủy phòng từ {formattedDate}
                        </li>
                      );
                    } else {
                      return (
                        <li key={index}>
                          Bạn sẽ được hoàn {refundAmount.toLocaleString('vi-VN')} ₫ nếu hủy phòng trước {formattedDate}
                        </li>
                      );
                    }
                  })}
                </ul>
              )}
            </div>
          </div>
        </DialogBody>
      </Dialog>
    </div>
  )
}

export default ModelPolicyCancel
