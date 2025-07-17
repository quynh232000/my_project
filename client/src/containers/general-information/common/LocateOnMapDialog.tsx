import IconLightBulb from '@/assets/Icons/filled/IconLightBulb';
import ButtonActionGroup from '@/components/shared/Button/ButtonActionGroup';
import Typography from '@/components/shared/Typography';
import { TextVariants } from '@/components/shared/Typography/TextVariants';
import {
	Dialog,
	DialogClose,
	DialogContent,
	DialogDescription,
	DialogFooter,
	DialogHeader,
	DialogTitle,
} from '@/components/ui/dialog';
import {
	Form,
	FormControl,
	FormField,
	FormItem,
	FormLabel,
	FormMessage,
} from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Skeleton } from '@/components/ui/skeleton';
import {
	locateOnMapSchema,
	TLocateOnMap,
} from '@/lib/schemas/property-profile/general-information';
import { GOOGLE_MAP_API_URL } from '@/services/type';
import { zodResolver } from '@hookform/resolvers/zod';
import { X } from 'lucide-react';
import Link from 'next/link';
import { useEffect } from 'react';
import { useForm } from 'react-hook-form';

interface LocateOnMapDialogProps {
	open: boolean;
	onClose: () => void;
	defaultValues?: {
		latitude: number;
		longitude: number;
	};
	onSubmit: (data: TLocateOnMap) => void;
}

export default function LocateOnMapDialog({
	defaultValues,
	open,
	onClose,
	onSubmit,
}: LocateOnMapDialogProps) {
	const form = useForm<TLocateOnMap>({
		resolver: zodResolver(locateOnMapSchema),
		mode: 'onChange',
		defaultValues: {
			latitude: NaN,
			longitude: NaN,
		},
	});

	const { control, handleSubmit, watch } = form;

	const [lat, lon] = watch(['latitude', 'longitude']);

	useEffect(() => {
		if (defaultValues) {
			form.reset(defaultValues);
		}
	}, [defaultValues]);

	const _onSubmit = (data: TLocateOnMap) => {
		onSubmit(data);
		onClose();
	};

	return (
		<Dialog open={open} onOpenChange={(change) => !change && onClose()}>
			<DialogContent
				hideButtonClose={true}
				className={'max-w-[888px] gap-4 p-6'}>
				<DialogHeader className="flex-row items-center justify-between">
					<DialogTitle
						className={`${TextVariants.content_16px_600} text-neutral-700`}>
						Định vị trên bản đồ
					</DialogTitle>
					<DialogDescription></DialogDescription>
					<DialogClose>
						<X className="h-5 w-5" />
					</DialogClose>
				</DialogHeader>
				<Form {...form}>
					<div className={'flex gap-4'}>
						<FormField
							name="longitude"
							control={control}
							render={({
								field: { value, onChange, ...props },
							}) => (
								<FormItem className={'relative flex-1'}>
									<FormLabel required>Kinh độ</FormLabel>
									<FormControl>
										<Input
											required
											type="number"
											placeholder="106.701303"
											{...props}
											value={
												isNaN(Number(value))
													? ''
													: value
											}
											onChange={(e) =>
												onChange(
													e.target.value?.length
														? Number(e.target.value)
														: NaN
												)
											}
										/>
									</FormControl>
									<FormMessage />
								</FormItem>
							)}
						/>
						<FormField
							name="latitude"
							control={control}
							render={({
								field: { value, onChange, ...props },
							}) => (
								<FormItem className={'relative flex-1'}>
									<FormLabel required>Vĩ độ</FormLabel>
									<FormControl>
										<Input
											required
											type="number"
											placeholder="10.7754514"
											{...props}
											value={
												isNaN(Number(value))
													? ''
													: value
											}
											onChange={(e) =>
												onChange(
													e.target.value?.length
														? Number(e.target.value)
														: NaN
												)
											}
										/>
									</FormControl>
									<FormMessage />
								</FormItem>
							)}
						/>
					</div>
					<div className={'relative h-[380px] w-full'}>
						<Typography>
							Định vị trên bản đồ{' '}
							<span className="text-red-500">*</span>
						</Typography>
						{!!lat && !!lon ? (
							<iframe
								title="gg-map"
								allowFullScreen
								referrerPolicy="no-referrer-when-downgrade"
								className={
									'absolute inset-0 top-[30px] h-[350px] w-full rounded-xl'
								}
								style={{ zIndex: 1 }}
								src={`https://www.google.com/maps/embed/v1/place?key=${GOOGLE_MAP_API_URL}
									&language=vi&q=${lat},${lon}`}
							/>
						) : (
							<Skeleton
								className={
									'absolute inset-0 top-[30px] h-[350px] w-full rounded-xl'
								}
							/>
						)}
					</div>
				</Form>
				<DialogFooter>
					<div className="flex w-full items-center justify-between">
						<Typography
							className="flex items-center gap-1.5"
							variant="caption_12px_500">
							<IconLightBulb className="h-4 w-4" />
							<Link
								target="_blank"
								href="https://support.google.com/maps/answer/18539?hl=vi&co=GENIE.Platform%3DDesktop"
								className="italic underline">
								Hướng dẫn lấy kinh độ và vĩ độ trên Google Map
							</Link>
						</Typography>
						<ButtonActionGroup
							className="mt-2"
							titleBtnCancel="Huỷ bỏ"
							titleBtnConfirm="Xác nhận"
							actionCancel={onClose}
							actionSubmit={handleSubmit(_onSubmit)}
						/>
					</div>
				</DialogFooter>
			</DialogContent>
		</Dialog>
	);
}
