'use client';
import { useMemo, useState } from 'react';

interface UsePaginationProps {
	totalItems: number;
	itemsPerPage: number;
	initialPage?: number;
}

interface UsePaginationReturn {
	currentPage: number;
	totalPages: number;
	nextPage: () => void;
	previousPage: () => void;
	goToPage: (page: number) => void;
	paginatedItems: [number, number];
}

export const usePagination = ({
	totalItems,
	itemsPerPage,
	initialPage = 1,
}: UsePaginationProps): UsePaginationReturn => {
	const [currentPage, setCurrentPage] = useState(initialPage);

	const totalPages = useMemo(() => Math.ceil(totalItems / itemsPerPage), [totalItems, itemsPerPage]);

	const nextPage = () => {
		setCurrentPage((page) => Math.min(page + 1, totalPages));
	};

	const previousPage = () => {
		setCurrentPage((page) => Math.max(page - 1, 1));
	};

	const goToPage = (page: number) => {
		const pageNumber = Math.max(1, Math.min(page, totalPages));
		setCurrentPage(pageNumber);
	};

	const paginatedItems = useMemo(() => {
		const startIndex = (currentPage - 1) * itemsPerPage;
		const endIndex = Math.min(startIndex + itemsPerPage, totalItems);
		return [startIndex, endIndex] as [number, number];
	}, [currentPage, itemsPerPage, totalItems]);

	return {
		currentPage,
		totalPages,
		nextPage,
		previousPage,
		goToPage,
		paginatedItems,
	};
};
