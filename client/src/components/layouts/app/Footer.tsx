import { EqualApproximatelyIcon, Phone, WholeWord } from 'lucide-react';
import Image from 'next/image';
import Link from 'next/link';
import React from 'react'

function Footer() {
    const i_vnpay = "/images/footer/vnpay.png";
    const i_mb = "/images/footer/mb.png";
    const i_cod = "/images/footer/cod.png";
    const i_facebook = "/images/footer/facebook.png";
    const i_instagram = "/images/footer/instagram.png";
    const i_youtube = "/images/footer/youtube.png";
    const i_tiktok = "/images/footer/tiktok.png";
    const i_googleplay = "/images/footer/googleplay.png";
    const i_appstore = "/images/footer/appstore.png";
    const data = {
        appName: "Quin Ecommerce",
        app: {
            email: "quynh232000@gmail.com",
            phone: "0358723520",
            website: "https://booking.mr-quynh.site",
            nameCompany: "Công Ty TNHH Quin Booking",
            members: "Nguyễn Văn Quynh",
            address: ["CV Phần mềm Quang Trung, Quận 12, TP. HCM"],
        },
    };
  return (
    <div className="w-full bg-gray-50">
      <div className="m-auto w-full px-2 xl:w-content xl:px-0">
        <div className="flex flex-col gap-5 border-b py-8">
          <div className="grid grid-cols-2 gap-4 lg:grid-cols-4">
            <div>
              <div className="mb-4 font-semibold uppercase">
                Về chúng tôi
              </div>
              <div className="flex flex-col gap-2">
                <Link href={"/about-us"}>Giới thiệu</Link>
                <Link href={"/lien-he"}>Liên hệ</Link>
                <Link href={"/chinh-sach"}>Chính sách bảo mật</Link>
                <Link href={"/bai-viet/blog/category"}>Tin tức mới</Link>
              </div>
            </div>
            <div>
              <div className="mb-4 font-semibold uppercase">
                Hỗ trợ khách hàng
              </div>
              <div className="flex flex-col gap-2">
                <Link href={"/bai-viet/qa/category"}>Câu hỏi thường gặp</Link>
                <Link href={"/bai-viet/edu/category"}>Hướng dẫn sử dụng</Link>
                <Link href={"#"}>Phưng thức thanh toán</Link>
                <Link href={"#"}>Chính sách bảo hành</Link>
                <Link href={"/affiliate/welcome"}>Tiếp thị liên kết</Link>
                <Link href={"/sign-in"}>Đăng nhập HMS</Link>
              </div>
            </div>
            <div>
              <div className="mb-4 font-semibold uppercase">
                Phương thức thanh toán
              </div>
              <div className="flex flex-col gap-2">
                <div className="flex gap-2">
                  <div className="h-[40px] max-w-[56px] cursor-pointer rounded-lg border border-transparent hover:border-gray-300">
                    <Image width={40} height={40}  
                      
                      className="h-full w-full object-contain"
                      src={i_cod}
                      alt="Quin Ecommerce" title="Quin Ecommerce"
                    />
                  </div>
                  <div className="h-[40px] max-w-[61px] cursor-pointer rounded-lg border border-transparent hover:border-gray-300">
                    <Image width={40} height={40}  
                      
                      className="h-full w-full object-contain"
                      src={i_vnpay}
                      alt="Quin Ecommerce" title="Quin Ecommerce"
                    />
                  </div>
                  <div className="h-[40px] max-w-[90px] cursor-pointer rounded-lg border border-transparent hover:border-gray-300">
                    <Image width={40} height={40}  
                      
                      className="h-full w-full object-contain"
                      src={i_mb}
                      alt="Quin Ecommerce" title="Quin Ecommerce"
                    />
                  </div>
                </div>
              </div>
              <div className="my-4 mt-6 font-bold uppercase">
               Theo dõi chúng tôi
              </div>
              <div className="flex flex-col gap-2">
                <div className="flex gap-2">
                  <div className="h-[40px] w-[40px] cursor-pointer rounded-lg border border-transparent hover:border-gray-300">
                    <Image width={40} height={40}  
                      
                      className="h-full w-full object-contain"
                      src={i_facebook}
                      alt="Quin Ecommerce" title="Quin Ecommerce"
                    />
                  </div>
                  <div className="h-[40px] w-[40px] cursor-pointer rounded-lg border border-transparent hover:border-gray-300">
                    <Image width={40} height={40}  
                      
                      className="h-full w-full object-contain"
                      src={i_instagram}
                      alt="Quin Ecommerce" title="Quin Ecommerce"
                    />
                  </div>
                  <div className="h-[40px] w-[40px] cursor-pointer rounded-lg border border-transparent hover:border-gray-300">
                    <Image width={40} height={40}  
                      
                      className="h-full w-full object-contain"
                      src={i_youtube}
                      alt="Quin Ecommerce" title="Quin Ecommerce"
                    />
                  </div>
                  <div className="h-[40px] w-[40px] cursor-pointer rounded-lg border border-transparent hover:border-gray-300">
                    <Image width={40} height={40}  
                      
                      className="h-full w-full object-contain"
                      src={i_tiktok}
                      alt="Quin Ecommerce" title="Quin Ecommerce"
                    />
                  </div>
                </div>
              </div>
            </div>
            <div>
              <div className="mb-4 font-semibold uppercase">
              Tải ứng dụng QuinShop
              </div>
              <div className="flex gap-3">
                <div>
                  <Image width={40} height={40}  
                    
                    className="w-[120px]"
                    src="https://hexdocs.pm/qr_code/docs/qrcode.svg"
                    alt="Quin Ecommerce" title="Quin Ecommerce"
                  />
                </div>
                <div className="flex flex-col justify-center gap-3">
                  <div className="">
                    <Image width={40} height={40}  
                      
                      className="h-full w-full object-cover"
                      src={i_googleplay}
                      alt="Quin Ecommerce" title="Quin Ecommerce"
                    />
                  </div>
                  <div className="">
                    <Image width={40} height={40}  
                      
                      className="h-full w-full object-cover"
                      src={i_appstore}
                      alt="Quin Ecommerce" title="Quin Ecommerce"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div className="mt-5 grid grid-cols-4 gap-4">
            <div className="col-span-4 lg:col-span-3">
              <div>
                <div className="mb-4 font-semibold uppercase">
                  Thông tin doanh nghiệp
                </div>
                <div className="flex flex-col gap-2">
                  <div className="flex gap-2">
                    <div className="font-semibold">Địa chỉ:</div>
                    <div>{data.app.address[0]}</div>
                  </div>
                  <div className="flex gap-2">
                    <div className="font-semibold">
                    Mã số doanh nghiệp:
                    </div>
                    <div>1307202386 do Sở Kế hoạch & Đầu tư TP Hồ Chí Minh cấp lần đầu ngày 11/02/2018</div>
                  </div>
                  <div className="flex gap-2">
                    <div className="font-semibold">
                     Chịu trách nhiệm quản lý nội dung:
                    </div>
                    <div>{data.app.members}</div>
                  </div>
                </div>
              </div>
            </div>
            <div className="col-span-4 lg:col-span-1">
              <div className="mb-4 font-semibold uppercase">
               Thông tin liên hệ
              </div>
              <div className="flex flex-col gap-2">
                <div className="flex items-center gap-2">
                  <div className="text-primary-500">
                    <EqualApproximatelyIcon />
                  </div>
                  <span>{data.app.email}</span>
                </div>
                <div className="flex items-center gap-2">
                  <div className="text-primary-500">
                    <Phone />
                  </div>
                  <span>{data.app.phone}</span>
                </div>
                <div className="flex items-center gap-2">
                  <div className="text-primary-500">
                    <WholeWord />
                  </div>
                  <span>{data.app.website}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div className="flex justify-center py-3 text-gray-500">
          <span>
            Copyright © 2025. All rights reserved. {data.app.nameCompany}
          </span>
        </div>
      </div>
    </div>
  )
}

export default Footer