'use client';
import React, { useEffect, useState } from 'react';
import { cn } from '@/lib/utils';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import { IconDownload } from '@/assets/Icons/outline';
import { GlobalUI } from '@/themes/type';
import { Button } from '@/components/ui/button';
import { useRoomStore } from '@/store/room/store';
import {
	mapPriceHistory,
	TPriceHistory,
} from '@/containers/price/history/data';

const ActionDownloadCsv = () => {
	const [priceHistory, setPriceHistory] = useState<TPriceHistory[]>([]);
	const priceHistoryList = useRoomStore((state) => state.priceHistoryList);
	useEffect(() => {
		if (priceHistoryList.length > 0) {
			setPriceHistory(mapPriceHistory(priceHistoryList));
		}
	}, [priceHistoryList]);

	function convertArrayOfObjectsToCSV<T extends object>(args: {
		data: T[];
		header: string[];
	}): string | undefined {
		const data = args.data;
		if (!data || !data.length) return;

		const keys = Object.keys(data[0]) as (keyof T)[];
		const csvString = args.header;
		const result = [csvString];

		data.forEach((item) => {
			const arr: string[] = [];
			keys.forEach((key) => {
				const value = item[key];
				arr.push((value as string) || '');
			});
			result.push(arr);
		});

		return result.map((item) => item.join(',')).join('\n');
	}

	const handleDownloadCSV = (args: { filename: string }) => {
		let csv = convertArrayOfObjectsToCSV({
			data: priceHistory,
			header: [
				'ID',
				'Updated date',
				'Created by',
				'Room name',
				'New price',
				'Old price',
				'Type price',
				'Apply date',
			],
		});
		if (!csv) return;

		const filename = args.filename || 'export.csv';

		if (!csv.match(/^data:text\/csv/i)) {
			csv = 'data:text/csv;charset=utf-8,\uFEFF' + csv;
		}

		const data = encodeURI(csv);

		const link = document.createElement('a');
		link.setAttribute('href', data);
		link.setAttribute('download', filename);
		link.click();
	};

	return (
		<Button
			onClick={() =>
				handleDownloadCSV({
					filename: `price_history_${new Date().getTime()}.csv`,
				})
			}
			className={cn(
				'bg-0 hover:bg-0 h-10 rounded-lg px-8 py-3 text-secondary-500',
				TextVariants.caption_14px_600
			)}>
			<IconDownload
				color={GlobalUI.colors.secondary['500']}
				className={'size-6'}
			/>
			Xuất file (.csv)
		</Button>
	);
};

export default ActionDownloadCsv;
