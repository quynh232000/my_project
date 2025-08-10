"use client";

import { motion } from "framer-motion";
import { Plane } from "lucide-react";
import Image from "next/image";

export default function SkeLoading() {
  return (
    <div className="flex flex-col items-center justify-center min-h-[400px] relative overflow-hidden bg-gradient-to-b from-blue-50 to-white">

      {/* Máy bay bay ngang */}
      <motion.div
        initial={{ x: "-150%", y: -30 }}
        animate={{ x: "150%", y: -30 }}
        transition={{ repeat: Infinity, duration: 6, ease: "linear" }}
        className="absolute top-12"
      >
        <Plane className="w-10 h-10 text-blue-500 rotate-45 drop-shadow-md" />
      </motion.div>

      {/* Hình minh họa khách sạn */}
      {/* <motion.div
        initial={{ scale: 0.9, opacity: 0 }}
        animate={{ scale: 1, opacity: 1 }}
        transition={{ duration: 0.8, ease: "easeOut" }}
        className="relative w-60 h-36 mt-10"
      >
        <Image
          src="/images/icon/Flying around the world-amico.svg" // bạn thay ảnh minh họa hotel ở public/
          alt="Hotel Loading"
          fill
          className="object-contain"
        />
      </motion.div> */}

      {/* Người kéo vali */}
      <motion.div
        initial={{ x: -30, opacity: 0 }}
        animate={{ x: 0, opacity: 1 }}
        transition={{ duration: 1, delay: 0.3 }}
        className="relative w-28 h-28 mt-4"
      >
        <Image
          src="/images/icon/Flying around the world-amico.svg" // ảnh người kéo vali
          alt="Traveler"
          fill
          className="object-contain"
        />
      </motion.div>

      {/* Skeleton shimmer */}
      <div className="relative w-64 h-5 overflow-hidden rounded-md bg-gray-200 mt-6">
        <motion.div
          className="absolute inset-0 bg-gradient-to-r from-transparent via-white/70 to-transparent"
          animate={{ x: ["-100%", "100%"] }}
          transition={{ repeat: Infinity, duration: 1.5 }}
        />
      </div>

      {/* Subtitle */}
      <motion.p
        initial={{ opacity: 0 }}
        animate={{ opacity: 1 }}
        transition={{ duration: 1, repeat: Infinity, repeatType: "reverse" }}
        className="text-sm text-gray-600 mt-3"
      >
        Đang tìm khách sạn phù hợp cho bạn...
      </motion.p>
    </div>
  );
}
