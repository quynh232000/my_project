"use client";

import { motion } from "framer-motion";
import { useEffect } from "react";
import confetti from "canvas-confetti";
import { CheckCircle } from "lucide-react";
import Link from "next/link";

interface BookingInfo {
  hotelName: string;
  checkIn: string;
  checkOut: string;
  bookingCode: string;
  totalPrice: number;
}

export default function BookingSuccessPage() {
  const booking: BookingInfo = {
    hotelName: "The Grand Riverside Hotel",
    checkIn: "2025-08-20",
    checkOut: "2025-08-23",
    bookingCode: "ABCD1234",
    totalPrice: 4200000,
  };

  useEffect(() => {
    const fire = () => {
      confetti({ particleCount: 120, spread: 70, origin: { y: 0.6 } });
    };
    fire();
    const timer = setTimeout(fire, 800);
    return () => clearTimeout(timer);
  }, []);

  return (
    <div className="min-h-screen flex items-center justify-center p-4 relative overflow-hidden font-sans">
      {/* Nền gradient pastel theo primary */}
      <div className="absolute inset-0 bg-gradient-to-br from-primary-100 via-primary-50 to-white animate-gradient" />
      <div className="absolute -top-40 -left-40 w-96 h-96 bg-primary-300/15 rounded-full blur-3xl animate-pulse" />
      <div className="absolute -bottom-40 -right-40 w-96 h-96 bg-primary-400/15 rounded-full blur-3xl animate-pulse" />

      {/* Thẻ glassmorphism */}
      <motion.div
        initial={{ opacity: 0, scale: 0.85 }}
        animate={{ opacity: 1, scale: 1 }}
        transition={{ duration: 0.6 }}
        className="relative z-10 backdrop-blur-xl bg-white/30 rounded-3xl shadow-2xl p-8 max-w-lg w-full text-center border border-primary-200/30"
      >
        {/* Icon check */}
        <motion.div
          initial={{ rotate: -30, scale: 0 }}
          animate={{ rotate: 0, scale: 1 }}
          transition={{ type: "spring", stiffness: 140 }}
          className="flex justify-center"
        >
          <CheckCircle className="w-20 h-20 text-primary-500 drop-shadow-lg animate-pulse" />
        </motion.div>

        <h1 className="text-3xl font-extrabold mt-4 text-gray-800">
          Đặt phòng thành công!
        </h1>
        <p className="text-gray-600 mt-2 text-lg">
          Cảm ơn bạn đã chọn{" "}
          <span className="font-semibold text-primary-600">{booking.hotelName}</span>
        </p>

        {/* Thông tin đặt phòng */}
        <div className="mt-6 space-y-2 text-left bg-white/50 p-5 rounded-xl border border-primary-200/40 shadow-inner">
          <p className="text-gray-700">
            <span className="font-medium">Ngày nhận phòng:</span> {booking.checkIn}
          </p>
          <p className="text-gray-700">
            <span className="font-medium">Ngày trả phòng:</span> {booking.checkOut}
          </p>
          <p className="text-gray-700">
            <span className="font-medium">Mã đặt phòng:</span> {booking.bookingCode}
          </p>
          <p className="text-gray-700">
            <span className="font-medium">Tổng tiền:</span>{" "}
            {booking.totalPrice.toLocaleString()}₫
          </p>
        </div>

        {/* Nút hành động */}
        <motion.div
          initial={{ y: 20, opacity: 0 }}
          animate={{ y: 0, opacity: 1 }}
          transition={{ delay: 0.4 }}
          className="mt-6 flex gap-4 justify-center"
        >
          <Link
            href="/"
            className="px-6 py-2 rounded-lg font-semibold text-white bg-gradient-to-r from-primary-500 to-primary-400 hover:from-primary-400 hover:to-primary-300 shadow-lg transition"
          >
            Về trang chủ
          </Link>
          <Link
            href="/booking/detail"
            className="px-6 py-2 border border-primary-300 text-primary-600 rounded-lg hover:bg-primary-50 transition"
          >
            Xem chi tiết
          </Link>
        </motion.div>
      </motion.div>

      {/* CSS cho gradient động */}
      <style jsx>{`
        .animate-gradient {
          background-size: 400% 400%;
          animation: gradientBG 15s ease infinite;
        }
        @keyframes gradientBG {
          0% { background-position: 0% 50%; }
          50% { background-position: 100% 50%; }
          100% { background-position: 0% 50%; }
        }
      `}</style>
    </div>
  );
}
