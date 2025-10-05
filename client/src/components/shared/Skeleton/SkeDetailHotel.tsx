import React from 'react'
import { motion } from 'framer-motion';

function SkeDetailHotel() {
  return (
     <motion.div
      className="w-content mx-auto pb-6"
      initial={{ opacity: 0 }}
      animate={{ opacity: 1 }}
      transition={{ duration: 0.4 }}
    >
      <div className="space-y-8">
        {/* Card wrapper */}
        <div className="p-6 rounded-xl shadow-md bg-white space-y-6">

          {/* Title & Breadcrumb */}
          <div className="space-y-2">
            <div className="h-4 w-1/4 rounded bg-gradient-to-r from-gray-200 via-gray-300 to-gray-200" />
            <div className="h-8 w-2/3 rounded bg-gradient-to-r from-gray-200 via-gray-300 to-gray-200" />
          </div>

          {/* Rating & Address */}
          <div className="flex items-center gap-4">
            <div className="flex items-center gap-2">
              <div className="w-5 h-5 rounded-full bg-gradient-to-r from-gray-200 via-gray-300 to-gray-200" />
              <div className="h-4 w-16 rounded bg-gradient-to-r from-gray-200 via-gray-300 to-gray-200" />
            </div>
            <div className="h-4 w-48 rounded bg-gradient-to-r from-gray-200 via-gray-300 to-gray-200" />
          </div>

          {/* Gallery */}
          <div className="grid grid-cols-4 gap-4 rounded-xl overflow-hidden">
            <div className="col-span-2 h-64 rounded-lg bg-gradient-to-r from-gray-200 via-gray-300 to-gray-200" />
            <div className="flex flex-col gap-4">
              <div className="h-32 rounded-lg bg-gradient-to-r from-gray-200 via-gray-300 to-gray-200" />
              <div className="h-32 rounded-lg bg-gradient-to-r from-gray-200 via-gray-300 to-gray-200" />
            </div>
            <div className="flex flex-col gap-4">
              <div className="h-32 rounded-lg bg-gradient-to-r from-gray-200 via-gray-300 to-gray-200" />
              <div className="relative h-32 rounded-lg bg-gradient-to-r from-gray-200 via-gray-300 to-gray-200">
                <div className="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center text-white text-sm font-semibold">
                  +13
                </div>
              </div>
            </div>
          </div>

          {/* Price + Button */}
          <div className="flex justify-between items-center">
            <div className="h-6 w-36 rounded-lg bg-gradient-to-r from-gray-200 via-gray-300 to-gray-200" />
            <div className="h-10 w-40 rounded-full bg-gradient-to-r from-gray-300 via-gray-400 to-gray-300" />
          </div>
        </div>

        {/* Tabs Section */}
        <div className="grid grid-cols-3 gap-6">
          {[...Array(3)].map((_, i) => (
            <div
              key={i}
              className="p-4 border border-gray-200 rounded-xl shadow-sm bg-white space-y-4"
            >
              <div className="h-4 w-1/3 rounded bg-gradient-to-r from-gray-200 via-gray-300 to-gray-200" />
              <div className="h-4 w-3/4 rounded bg-gradient-to-r from-gray-200 via-gray-300 to-gray-200" />
              <div className="h-4 w-2/3 rounded bg-gradient-to-r from-gray-200 via-gray-300 to-gray-200" />
              <div className="flex items-center gap-2 mt-2">
                <div className="w-6 h-6 rounded-full bg-gradient-to-r from-gray-200 via-gray-300 to-gray-200" />
                <div className="h-3 w-20 rounded bg-gradient-to-r from-gray-200 via-gray-300 to-gray-200" />
              </div>
            </div>
          ))}
        </div>
      </div>
    </motion.div>
  )
}

export default SkeDetailHotel