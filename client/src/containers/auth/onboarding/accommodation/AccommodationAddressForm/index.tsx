// 'use client';
// import { AccommodationContainer } from '@/containers/auth/onboarding/accommodation/common/AccommodationContainer';
// import * as React from 'react';
// import { useEffect, useState } from 'react';
// import {
// 	Commune,
// 	District,
// 	getVietnamDivision,
// 	Province,
// } from '@/app/actions/divisions/vietnam/actions';
// import SelectPopover from '@/components/shared/Select/SelectPopover';
// import { cn } from '@/lib/utils';
// import IconChevron from '@/assets/Icons/outline/IconChevron';
// import { Label } from '@/components/ui/label';
// import { Input } from '@/components/ui/input';
// import { TextVariants } from '@/components/shared/Typography/TextVariants';
//
// const AccommodationAddressForm = () => {
// 	const [list, setList] = useState<{
// 		provinces: Province[];
// 		districts: District[];
// 		communes: Commune[];
// 	}>({
// 		provinces: [],
// 		districts: [],
// 		communes: [],
// 	});
//
// 	const [province, setProvince] = useState<Province>();
// 	const [district, setDistrict] = useState<District>();
// 	const [commune, setCommune] = useState<Commune>();
//
// 	const fetchDivision = async (idProvince?: string, idDistrict?: string) => {
// 		return await getVietnamDivision(idProvince, idDistrict);
// 	};
//
// 	useEffect(() => {
// 		fetchDivision().then((res) => {
// 			if (res) {
// 				setList(res);
// 				const { provinces, districts, communes } = res;
// 				setProvince(provinces[0]);
// 				setDistrict(districts[0]);
// 				setCommune(communes[0]);
// 			}
// 		});
// 	}, []);
//
// 	console.log('province', province);
//
// 	return (
// 		<AccommodationContainer title={'Địa chỉ chỗ nghỉ của bạn'}>
// 			<div className={'grid grid-cols-2 gap-3'}>
// 				<div>
// 					<Label>Quốc gia</Label>
// 					<div
// 						className={cn(
// 							TextVariants.caption_14px_400,
// 							'flex w-full items-center justify-between rounded-lg border-2 border-other-divider p-3 text-start'
// 						)}>
// 						Việt Nam
// 						<IconChevron
// 							direction={'up'}
// 							width={12}
// 							height={12}
// 							className={'ml-auto inline-block'}
// 						/>
// 					</div>
// 				</div>
//
// 				<SelectPopover
// 					label={'Tỉnh/Thành phố'}
// 					data={list.provinces}
// 					triggerLabel={province?.name}
// 					renderItem={(item, index) => (
// 						<button
// 							key={index}
// 							onClick={() => {
// 								setProvince(item);
// 								fetchDivision(item.idProvince).then((res) => {
// 									setList(res);
// 									setDistrict(res.districts[0]);
// 									setCommune(res.communes[0]);
// 								});
// 							}}
// 							className={cn('p-2 text-start', TextVariants.caption_14px_400)}>
// 							{item.name}
// 						</button>
// 					)}
// 				/>
// 				<SelectPopover
// 					label={'Quận/Huyện'}
// 					data={list.districts}
// 					triggerLabel={district?.name}
// 					renderItem={(district, index) => (
// 						<button
// 							key={index}
// 							onClick={() => {
// 								setDistrict(district);
// 								fetchDivision(district.idProvince, district.idDistrict).then(
// 									(res) => {
// 										setList(res);
// 										setCommune(res.communes[0]);
// 									}
// 								);
// 							}}
// 							className={cn('p-2 text-start', TextVariants.caption_14px_400)}>
// 							{district.name}
// 						</button>
// 					)}
// 				/>
// 				<SelectPopover
// 					label={'Phường/Xã'}
// 					data={list.communes}
// 					triggerLabel={commune?.name}
// 					renderItem={(value, index) => (
// 						<button
// 							key={index}
// 							onClick={() => {
// 								console.log(value);
// 								setCommune(value);
// 							}}
// 							className={cn('p-2 text-start', TextVariants.caption_14px_400)}>
// 							{value.name}
// 						</button>
// 					)}
// 				/>
//
// 				<div className={'col-span-2'}>
// 					<Label>Địa chỉ cụ thể</Label>
// 					<Input placeholder={'Ví dụ: 123 Đường 3/2'} />
// 				</div>
// 			</div>
// 		</AccommodationContainer>
// 	);
// };
//
// export default AccommodationAddressForm;
