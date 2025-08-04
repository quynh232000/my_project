'use client';
import { FaAngleLeft, FaAngleRight } from 'react-icons/fa';
import { useSearchParams, useRouter, usePathname } from 'next/navigation';

interface PaginationProps {
  total: number; // tổng số item
  limit: number; // số item mỗi trang
  siblingCount?: number; // số trang hiển thị 2 bên trang hiện tại
}

export default function Pagination({ total, limit, siblingCount = 1 }: PaginationProps) {
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

  // Tạo mảng hiển thị trang
  const getPageNumbers = () => {
    const pages: (number | string)[] = [];

    const leftSibling = Math.max(currentPage - siblingCount, 1);
    const rightSibling = Math.min(currentPage + siblingCount, totalPages);

    if (leftSibling > 2) {
      pages.push(1, '...');
    } else {
      for (let i = 1; i < leftSibling; i++) {
        pages.push(i);
      }
    }

    for (let i = leftSibling; i <= rightSibling; i++) {
      pages.push(i);
    }

    if (rightSibling < totalPages - 1) {
      pages.push('...', totalPages);
    } else {
      for (let i = rightSibling + 1; i <= totalPages; i++) {
        pages.push(i);
      }
    }

    return pages;
  };

  const pages = getPageNumbers();

  return (
    <div className="gap-2 mt-8 flex justify-center items-center my-14 flex-wrap">
      <button
        disabled={currentPage <= 1}
        onClick={() => changePage(currentPage - 1)}
        className="px-3 py-1 disabled:opacity-50 border flex items-center justify-center shadow w-10 h-10 rounded-full"
      >
        <FaAngleLeft />
      </button>

      {pages.map((page, index) => (
        <button
          key={index}
          disabled={page === '...'}
          onClick={() => typeof page === 'number' && changePage(page)}
          className={`px-3 py-1 border w-10 h-10 rounded-full shadow text-sm
            ${page === currentPage ? 'bg-primary-500 text-white' : 'hover:bg-primary-100'}
            ${page === '...' ? 'cursor-default bg-transparent border-none shadow-none text-gray-400' : ''}
          `}
        >
          {page}
        </button>
      ))}

      <button
        disabled={currentPage >= totalPages}
        onClick={() => changePage(currentPage + 1)}
        className="px-3 py-1 disabled:opacity-50 border flex items-center justify-center shadow w-10 h-10 rounded-full"
      >
        <FaAngleRight />
      </button>
    </div>
  );
}
