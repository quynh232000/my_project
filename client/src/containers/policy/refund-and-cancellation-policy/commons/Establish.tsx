'use client';
import IconExclamationCircle from '@/assets/Icons/outline/IconExclamationCircle';
import IconPlus from '@/assets/Icons/outline/IconPlus';
import IconSettings from '@/assets/Icons/outline/IconSettings';
import Typography from '@/components/shared/Typography';
import { Button } from '@/components/ui/button';
import {
	Dialog,
	DialogContent,
	DialogDescription,
	DialogHeader,
	DialogTitle,
} from '@/components/ui/dialog';
import { Skeleton } from '@/components/ui/skeleton';
import { DashboardRouter } from '@/constants/routers';
import { CancellationTimeline } from '@/containers/policy/refund-and-cancellation-policy/commons/CancellationTimeline';
import SeparateCancellationPolicyItem from '@/containers/policy/refund-and-cancellation-policy/commons/SeparateCancellationPolicyItem';
import SeparateCancellationPolicyForm from '@/containers/policy/separate-cancellation-policy/SeparateCancellationPolicyForm';
import { SeparatelyPolicyRow } from '@/lib/schemas/policy/cancelPolicy';
import { deleteCancelPolicy } from '@/services/policy/cancel/deleteCancelPolicy';
import {
	CancelPolicyStatus,
	ICancelPolicy,
} from '@/services/policy/cancel/getCancelPolicy';
import { updateCancelPolicy } from '@/services/policy/cancel/updateCancelPolicy';
import { useCancelPolicyStore } from '@/store/cancel-policy/store';
import { useLoadingStore } from '@/store/loading/store';
import { useRouter } from 'next/navigation';
import { useEffect, useMemo, useState } from 'react';
import { toast } from 'sonner';
import { useShallow } from 'zustand/react/shallow';

export default function Establish() {
	const router = useRouter();
	const { global, local, fetchCancelPolicy, updateLocalPolicy } =
		useCancelPolicyStore(
			useShallow((state) => ({
				global: state.global,
				local: state.local,
				fetchCancelPolicy: state.fetchCancelPolicy,
				updateLocalPolicy: state.updateLocalPolicy,
			}))
		);
	const setLoading = useLoadingStore((state) => state.setLoading);

	const [dialog, setDialog] = useState<
		| {
				isOpen: boolean;
				type?: 'updateStatus' | 'delete' | 'edit';
				id?: number;
		  }
		| undefined
	>(undefined);

	const editedPolicy = useMemo(
		() =>
			dialog && dialog.isOpen
				? local?.find((item) => item.id === dialog.id)
				: undefined,
		[dialog?.isOpen, dialog?.id, local]
	);

	useEffect(() => {
		setLoading(true);
		fetchCancelPolicy().finally(() => setLoading(false));
	}, []);

	const handleToggleSetting = () => {
		router.push(DashboardRouter.policyCancelEstablish);
	};
	const handleClick = () => {
		router.push(DashboardRouter.policyCancelAdd);
	};

	const handleUpdatePolicy = (policyItem: ICancelPolicy) => {
		setLoading(true);
		updateCancelPolicy({
			...policyItem,
			policy_rules: [...policyItem.cancel_rules],
		})
			.then(async (res) => {
				if (res.id) {
					updateLocalPolicy({
						...policyItem,
					});
				}
				if (res.status) {
					policyItem.status === CancelPolicyStatus.INACTIVE &&
						(await fetchCancelPolicy(true));
					setDialog({ ...dialog, isOpen: false });
					toast.success('Cập nhật chính sách riêng thành công!');
				} else {
					toast.error(res.message);
				}
			})
			.catch(() => toast.error('Có lỗi xảy ra, vui lòng thử lại!'))
			.finally(() => setLoading(false));
	};

	const handleDeletePolicy = (id: number) => {
		setLoading(true);
		deleteCancelPolicy(id)
			.then(async (res) => {
				await fetchCancelPolicy(true);
				if (res.status) {
					setDialog({ ...dialog, isOpen: false });
					toast.success('Xoá chính sách riêng thành công!');
				} else {
					toast.error(res.message);
				}
			})
			.catch(() => toast.error('Có lỗi xảy ra, vui lòng thử lại!'))
			.finally(() => setLoading(false));
	};

	return (
		<>
			<Typography
				tag="p"
				text="Chính sách hoàn hủy chung của khách sạn"
				variant="content_16px_600"
				className="text-neutral-600"
			/>
			<Typography
				tag="p"
				text="Thiết lập chính sách hoàn hủy chung cho toàn bộ phòng"
				variant="caption_14px_400"
				className="text-neutral-400"
			/>

			<div className="mt-4 rounded-xl bg-white p-4">
				<div className="flex justify-between gap-4">
					<Typography
						tag="p"
						text="Chính sách chung"
						className="text-base font-semibold leading-6 text-neutral-600"
					/>
					<div className="flex">
						{global === null ? (
							<Skeleton className={'h-6 w-[150px] rounded-lg'} />
						) : (
							<>
								{(global?.price_types?.length ?? 0) > 0 && (
									<Typography
										tag="p"
										text={`${global?.price_types?.length} loại giá đang áp dụng`}
										variant="caption_12px_600"
										className="rounded-lg bg-green-50 px-4 py-1 text-accent-02"
									/>
								)}
							</>
						)}
						{global !== null && (
							<div
								onClick={handleToggleSetting}
								className="ml-4 flex cursor-pointer items-center gap-1">
								<IconSettings />
								<Typography
									tag="p"
									text="Thiết lập"
									variant="caption_12px_600"
									className="text-neutral-400"
								/>
							</div>
						)}
					</div>
				</div>
				<div className="mt-4">
					{global === null ? (
						<Skeleton className={'h-[109px] w-full rounded-xl'} />
					) : (
						<CancellationTimeline
							cancelable={
								global
									? global.status ===
										CancelPolicyStatus.ACTIVE
									: false
							}
							policyRow={
								global?.cancel_rules ? global?.cancel_rules : []
							}
						/>
					)}
				</div>
			</div>

			<div className="mt-6">
				<Typography tag="h1" text="Chính sách hoàn hủy riêng" />
				<Typography
					tag="p"
					text="Thiết lập thêm các chính sách riêng cho từng phòng hoặc nhóm phòng"
					className="text-base font-normal leading-6 text-neutral-400"
				/>

				{local && (local?.length ?? 0) > 0 && (
					<div className="mt-4">
						{local?.map((policy, index) => (
							<SeparateCancellationPolicyItem
								policy={policy}
								key={index}
								onChangeActive={(id, isActive) => {
									if (
										isActive ||
										policy.price_types?.length === 0
									) {
										const policyItem = local?.find(
											(item) => item.id === id
										);
										if (policyItem) {
											policyItem.status = isActive
												? CancelPolicyStatus.ACTIVE
												: CancelPolicyStatus.INACTIVE;
											handleUpdatePolicy(policyItem);
										}
									} else {
										setDialog({
											isOpen: true,
											id: id,
											type: 'updateStatus',
										});
									}
								}}
								onEdit={(id) => {
									setDialog({
										isOpen: true,
										id: id,
										type: 'edit',
									});
								}}
								onRemove={(id) => {
									setDialog({
										isOpen: true,
										id: id,
										type: 'delete',
									});
								}}
							/>
						))}
					</div>
				)}

				<div
					onClick={handleClick}
					className="mt-4 flex w-full cursor-pointer items-center rounded-xl border-2 border-dashed border-[#EAF3FF] bg-white p-4">
					<div className="inline-flex h-10 w-10 items-center justify-center rounded-full border-2 border-[#EAF3FF] p-2">
						<IconPlus width={24} height={24} color="#2A85FF" />
					</div>
					<Typography
						tag="p"
						text="Thêm chính sách"
						className="ml-4 text-base font-semibold text-[#2A85FF]"
					/>
				</div>

				<Dialog
					open={!!dialog?.isOpen}
					onOpenChange={(open) => {
						if (!open) setDialog({ ...dialog, isOpen: false });
					}}>
					<DialogContent
						hideButtonClose
						className={`p-8 ${dialog?.type === 'edit' && 'max-h-[90vh] w-[1200px] max-w-[90vw] overflow-y-auto'}`}>
						{dialog?.type === 'updateStatus' ||
						dialog?.type === 'delete' ? (
							<>
								<DialogHeader>
									<DialogTitle className="text-2xl font-semibold leading-8">
										{dialog?.type === 'updateStatus'
											? 'Ngưng kích hoạt chính sách?'
											: 'Xoá chính sách?'}
									</DialogTitle>
									<DialogDescription className="!mt-4 text-base font-normal leading-6">
										{editedPolicy?.code} -{' '}
										{editedPolicy?.name}
									</DialogDescription>
								</DialogHeader>
								{editedPolicy?.price_types &&
									editedPolicy?.price_types.length > 0 && (
										<>
											<div className="gap-4 rounded-xl bg-yellow-50 p-3">
												<div className="flex items-center">
													<IconExclamationCircle
														className="h-6 w-6 p-0.5"
														color="#F9A600"
													/>
													<Typography
														text={`Chính sách này đang được áp dụng cho ${editedPolicy?.price_types?.length} loại giá`}
														variant="caption_14px_400"
														className="ml-2 text-[#F9A600]"
													/>
												</div>
												<ul className="mt-[5px] list-none pl-8">
													{editedPolicy?.price_types?.map(
														(item, key) => (
															<li
																key={key}
																className="text-base font-normal leading-6">
																{item.name}
															</li>
														)
													)}
												</ul>
											</div>
											<Typography variant="caption_14px_400">
												Sau khi{' '}
												{dialog?.type === 'updateStatus'
													? 'ngưng kích hoạt'
													: 'xoá'}
												, phòng này sẽ được tự động áp
												dụng theo chính sách chung của
												khách sạn. Bạn vẫn muốn tiếp
												tục?
											</Typography>
										</>
									)}

								<div className="mt-6 flex w-full justify-center gap-4">
									<Button
										variant={'secondary'}
										onClick={() =>
											setDialog({
												...dialog,
												isOpen: false,
											})
										}>
										Hủy
									</Button>
									<Button
										variant={'destructive'}
										onClick={() => {
											if (dialog?.id) {
												if (
													dialog?.type ===
													'updateStatus'
												) {
													const policyItem =
														local?.find(
															(item) =>
																item.id ===
																dialog?.id
														);
													if (policyItem) {
														policyItem.status =
															CancelPolicyStatus.INACTIVE;
														handleUpdatePolicy(
															policyItem
														);
													}
												} else {
													handleDeletePolicy(
														dialog?.id
													);
												}
											}
										}}>
										{dialog?.type === 'updateStatus'
											? 'Ngưng kích hoạt'
											: 'Xoá chính sách'}
									</Button>
								</div>
							</>
						) : (
							<>
								<DialogHeader>
									<DialogTitle>
										Chỉnh sửa chính sách
									</DialogTitle>
									<DialogDescription>
										Bạn sẽ chỉnh sửa chính sách ở đây
									</DialogDescription>
								</DialogHeader>
								<SeparateCancellationPolicyForm
									onCancel={() =>
										setDialog({ ...dialog, isOpen: false })
									}
									defaultValues={
										editedPolicy
											? {
													id: editedPolicy?.id,
													code: editedPolicy?.code,
													name: editedPolicy?.name,
													status:
														editedPolicy?.status ===
														CancelPolicyStatus.ACTIVE,
													rows:
														editedPolicy?.cancel_rules ??
														[],
												}
											: undefined
									}
									isDialog={true}
									onSubmit={(data: SeparatelyPolicyRow) => {
										if (data?.id) {
											handleUpdatePolicy({
												id: data?.id,
												code: data?.code,
												is_global: false,
												name: data?.name,
												status: data?.status
													? CancelPolicyStatus.ACTIVE
													: CancelPolicyStatus.INACTIVE,
												cancel_rules: data?.rows ?? [],
											});
										}
									}}
								/>
							</>
						)}
					</DialogContent>
				</Dialog>
			</div>
		</>
	);
}
