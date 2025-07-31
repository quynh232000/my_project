'use client';

import { useSearchParams, useRouter, usePathname } from 'next/navigation';
import React from 'react';
import { FaAngleLeft, FaAngleRight } from 'react-icons/fa6';

interface PaginationProps {
  total: number; // tổng số item
  limit: number; // số item mỗi trang
}

export default function Pagination({ total, limit }: PaginationProps) {
  const totalPages = Math.ceil(total / limit);

  const searchParams = useSearchParams();
  const router = useRouter();
  const pathname = usePathname();

  const currentPage = Number(searchParams.get('page') || 1);

  const changePage = (page: number) => {
    const params = new URLSearchParams(searchParams);
    params.set('page', page.toString());
    router.push(`${pathname}?${params.toString()}`);
  };

  if (totalPages <= 1) return null;

  return (
    <div className=" gap-2 mt-4 flex justify-center items-center my-14">
      <button
        disabled={currentPage <= 1}
        onClick={() => changePage(currentPage - 1)}
        className="px-3 py-1  disabled:opacity-50 border flex items-center justify-center shadow-lg  w-12 h-12 rounded-full"
      >
        <FaAngleLeft />
      </button>

      {Array.from({ length: totalPages }, (_, i) => {
        const page = i + 1;
        return (
          <button
            key={page}
            onClick={() => changePage(page)}
            className={`px-3 py-1 border  w-12 h-12 rounded-full shadow-lg ${
              page === currentPage ? 'bg-primary-500 text-white' : 'hover:bg-primary-100'
            }`}
          >
            {page}
          </button>
        );
      })}

      <button
        disabled={currentPage >= totalPages}
        onClick={() => changePage(currentPage + 1)}
        className="px-3 py-1  disabled:opacity-50 shadow-lg border flex justify-center items-center  w-12 h-12 rounded-full"
      >
       <FaAngleRight />
      </button>
    </div>
  );
}
