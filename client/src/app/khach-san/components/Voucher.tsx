

function Voucher() {
  return (
    <div className="w-content m-auto">
        <div>
            <div className="text-2xl font-semibold">Mã giá giá <span className="text-primary-500">(2)</span></div>
            <div className="grid grid-cols-2 gap-6 mt-5">
                <div className="flex   bg-primary-50 overflow-hidden cursor-pointer">
                    <div className="flex gap-3 flex-col flex-1 border-primary-500 border p-5 rounded-t-lg rounded-l-lg rounded-b-lg rounded-r-none border-r-0">
                        <div className="text-lg font-semibold">Giảm 8% đơn đặt phòng khách sạn</div>
                        <div>
                            <div className="text-sm text-gray-600">Hạn sử dụng 31/7</div>
                            <div className="text-sm text-gray-600">Nhập mã khi thanh toán</div>
                            <div className="text-primary-500 text-[14px]">Điều kiện và thể lệ chương trình</div>
                        </div>
                    </div>
                    <div className="w-[6px]  relative">
                        <div className="w-[26px] h-[29px] border border-primary-500 bg-white rounded-full absolute top-[-14px] z-[1]"></div>
                        <div className=" absolute top-[24px] z-[1] right-[-8px] bottom-[24px] w-1 border-r-2 border-primary-500 border-dashed "></div>
                        <div className="w-[26px] h-[29px] border border-primary-500 bg-white rounded-full absolute bottom-[-14px] z-[1]"></div>
                    </div>
                    <div className="text-center border-primary-500 border p-5 rounded-t-lg rounded-r-lg rounded-b-lg rounded-l-none border-l-0">
                        <div>Nhập mã</div>
                        <div className="text-primary-500 font-semibold text-xl py-1">NANGVANG25</div>
                        <div>
                            <button className="text-white bg-primary-500 hover:bg-primary-600 cursor-pointer rounded-lg py-2 px-3">Nhập mã</button>
                        </div>
                    </div>
                </div>
                <div className="flex   bg-primary-50 overflow-hidden cursor-pointer">
                    <div className="flex gap-3 flex-col flex-1 border-primary-500 border p-5 rounded-t-lg rounded-l-lg rounded-b-lg rounded-r-none border-r-0">
                        <div className="text-lg font-semibold">Giảm 8% đơn đặt phòng khách sạn</div>
                        <div>
                            <div className="text-sm text-gray-600">Hạn sử dụng 31/7</div>
                            <div className="text-sm text-gray-600">Nhập mã khi thanh toán</div>
                            <div className="text-primary-500 text-[14px]">Điều kiện và thể lệ chương trình</div>
                        </div>
                    </div>
                    <div className="w-[6px]  relative">
                        <div className="w-[26px] h-[29px] border border-primary-500 bg-white rounded-full absolute top-[-14px] z-[1]"></div>
                        <div className=" absolute top-[24px] z-[1] right-[-8px] bottom-[24px] w-1 border-r-2 border-primary-500 border-dashed "></div>
                        <div className="w-[26px] h-[29px] border border-primary-500 bg-white rounded-full absolute bottom-[-14px] z-[1]"></div>
                    </div>
                    <div className="text-center border-primary-500 border p-5 rounded-t-lg rounded-r-lg rounded-b-lg rounded-l-none border-l-0">
                        <div>Nhập mã</div>
                        <div className="text-primary-500 font-semibold text-xl py-1">NANGVANG25</div>
                        <div>
                            <button className="text-white bg-primary-500 hover:bg-primary-600 cursor-pointer rounded-lg py-2 px-3">Nhập mã</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  )
}

export default Voucher