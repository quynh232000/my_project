import SelectPopup from '@/components/shared/Select/SelectPopup';
import Typography from '@/components/shared/Typography';
import {
	FormControl,
	FormField,
	FormItem,
	FormLabel,
	FormMessage,
} from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { mapToLabelValue } from '@/containers/setting-room/helpers';
import useDebounce from '@/hooks/use-debounce';
import { AccommodationInfo } from '@/lib/schemas/property-profile/general-information';
import { useAddressStore } from '@/store/address/store';
import Image from 'next/image';
import { useCallback, useEffect, useMemo, useState } from 'react';
import { useFormContext, useWatch } from 'react-hook-form';
import LocateOnMapDialog from './LocateOnMapDialog';
import { getAddressCoordinate } from '@/services/address/getAddressCoordinate';
import { useLoadingStore } from '@/store/loading/store';
import { GOOGLE_MAP_API_URL } from '@/services/type';

type AddressType = 'listCountry' | 'listProvince' | 'listWard';

export default function AddressInfo() {
	const { listCountry, listProvince, listWard, getAddress } =
		useAddressStore();
	const setLoading = useLoadingStore((state) => state.setLoading);
	const { setValue, control } = useFormContext<AccommodationInfo>();
	const [fullyAddress, setFullyAddress] = useState('');
	const [showModal, setShowModal] = useState(false);

	const [latitude, longitude, country, province, ward, fullAddress] =
		useWatch({
			control,
			name: [
				'address.latitude',
				'address.longitude',
				'address.country_id',
				'address.province_id',
				'address.ward_id',
				'address.address',
			],
		});

	const addressData = useMemo(
		() => ({
			countryStr:
				listCountry.find(
					(countryItem) => `${countryItem.id}` === `${country}`
				)?.name ?? '',
			provinceStr:
				listProvince.list.find(
					(provinceItem) => `${provinceItem.id}` === `${province}`
				)?.name ?? '',
			
			wardStr:
				listWard.list.find((wardItem) => `${wardItem.id}` === `${ward}`)
					?.name ?? '',
		}),
		[
			country,
			province,
			ward,
			listCountry,
			listProvince.list,
			listWard.list,
		]
	);

	const selectData = useMemo(
		() => ({
			countryData: mapToLabelValue(listCountry),
			provinceData: mapToLabelValue(listProvince.list) ?? [],
			wardData: mapToLabelValue(listWard.list) ?? [],
		}),
		[listCountry, listProvince.list,  listWard.list]
	);

	const fetchAddressData = useCallback(
		async (type: AddressType, id?: number) => {
			try {
				await getAddress(type, id);
			} catch (error) {
				console.error(`Error fetching ${type}:`, error);
			}
		},
		[getAddress]
	);

	useEffect(() => {
		fetchAddressData('listCountry');
	}, [fetchAddressData]);

	useEffect(() => {
		if (country) {
			fetchAddressData('listProvince', Number(country));
		}
	}, [country, fetchAddressData]);

	useEffect(() => {
		if (province) {
			fetchAddressData('listWard', Number(province));
		}
	}, [province, fetchAddressData]);



	useEffect(() => {
		if (listProvince.upperId && listProvince.upperId !== province) {
			setValue('address.province_id', NaN);
			setValue('address.address', '');
		}
	}, [listProvince, province, setValue]);

	useEffect(() => {
		if (listWard.upperId && listWard.upperId !== ward) {
			setValue('address.ward_id', NaN);
			setValue('address.address', '');
		}
	}, [listWard, province, setValue]);

	const onAddressChange = useDebounce((address: string) => {
		setFullyAddress(address);
	}, 1000);

	useEffect(() => {
		if (!!country && !!province && !!province && !!ward && !!fullAddress) {
			const { countryStr, provinceStr, wardStr } = addressData;
			const fullyAddress = `${fullAddress?.trim()}, ${wardStr}, ${provinceStr}, ${provinceStr}, ${countryStr}`;
			onAddressChange(fullyAddress);
			setValue('address.fullAddress', fullyAddress);
		} else {
			onAddressChange('');
		}
	}, [
		country,
		province,
		ward,
		fullAddress,
		addressData,
		onAddressChange,
		setValue,
	]);

	const fetchCoordinate = useCallback(async () => {
		if (fullyAddress && !latitude && !longitude) {
			setLoading(true);
			const coordinate = await getAddressCoordinate(fullyAddress);
			if (coordinate) {
				setValue('address.latitude', coordinate.latitude);
				setValue('address.longitude', coordinate.longitude);
			}
			setLoading(false);
		}
	}, [fullyAddress, latitude, longitude, setValue, setLoading]);

	const renderMap = useMemo(() => {
		return (
			<div className={'relative h-full w-full'}>
				{fullyAddress.length === 0 ? (
					<Image
						width={954}
						height={654}
						alt={'Image Upload'}
						priority
						src={'/images/pages/general-information/image-map.png'}
						className={'h-full w-full object-cover'}
					/>
				) : (
					<iframe
						title="gg-map"
						loading="lazy"
						allowFullScreen={false}
						referrerPolicy="no-referrer-when-downgrade"
						className={'h-full w-full'}
						src={`https://www.google.com/maps/embed/v1/place?key=${GOOGLE_MAP_API_URL}
								&language=vi&q=${fullyAddress}`}
					/>
				)}
				<div
					className={
						'absolute left-0 top-0 h-full w-full cursor-pointer'
					}
					onClick={() => {
						fetchCoordinate().then(() => {
							setShowModal(true);
						});
					}}
				/>
			</div>
		);
	}, [fullyAddress, fetchCoordinate]);

	return (
		<div className={'space-y-6'}>
			<Typography
				tag="p"
				text={'Địa chỉ chỗ nghỉ'}
				className={
					'text-md font-semibold leading-6 tracking-[-0.32px] text-neutral-700'
				}
			/>
			<div className={'grid grid-cols-3 gap-6'}>
				<div className={'col-span-12 space-y-4 lg:col-span-2'}>
					<div className={'grid grid-cols-2 gap-4'}>
						<div className={'col-span-12 lg:col-span-1'}>
							<FormField
								name="address.country_id"
								control={control}
								render={({
									field: { value, onChange, ...props },
								}) => (
									<FormItem className={'col-span-2'}>
										<FormLabel required>Quốc gia</FormLabel>
										<FormControl>
											<SelectPopup
												placeholder={'Chọn quốc gia'}
												className="h-[44px] rounded-lg bg-white py-2"
												labelClassName="mb-2"
												data={selectData.countryData}
												selectedValue={value}
												onChange={onChange}
												controllerRenderProps={props}
											/>
										</FormControl>
										<FormMessage />
									</FormItem>
								)}
							/>
						</div>
						<div className={'col-span-12 lg:col-span-1'}>
							<FormField
								name="address.province_id"
								control={control}
								render={({
									field: { value, onChange, ...props },
								}) => (
									<FormItem className={'col-span-2'}>
										<FormLabel required>
											Tỉnh/Thành phố
										</FormLabel>
										<FormControl>
											<SelectPopup
												placeholder={
													'Chọn Tỉnh/Thành phố'
												}
												className="h-[44px] rounded-lg bg-white py-2"
												labelClassName="mb-2"
												data={selectData.provinceData}
												controllerRenderProps={{
													...props,
												}}
												selectedValue={value}
												onChange={onChange}
											/>
										</FormControl>
										<FormMessage />
									</FormItem>
								)}
							/>
						</div>
					</div>
					<div className={'grid grid-cols-2 gap-4'}>
						
						<div className={'col-span-12 lg:col-span-1'}>
							<FormField
								name="address.ward_id"
								control={control}
								render={({
									field: { value, onChange, ...props },
								}) => (
									<FormItem className={'col-span-2'}>
										<FormLabel required>
											Phường/Xã
										</FormLabel>
										<FormControl>
											<SelectPopup
												labelClassName="mb-2"
												className="h-[44px] rounded-lg bg-white py-2"
												placeholder={'Chọn Phường/Xã'}
												data={selectData.wardData}
												controllerRenderProps={{
													...props,
												}}
												selectedValue={value}
												onChange={onChange}
											/>
										</FormControl>
										<FormMessage />
									</FormItem>
								)}
							/>
						</div>
					</div>
					<FormField
						name="address.address"
						control={control}
						render={({ field }) => (
							<FormItem className={'col-span-2'}>
								<FormLabel required>Địa chỉ</FormLabel>
								<FormControl>
									<Input
										type="text"
										placeholder="12 Phạm Phú Thứ"
										className={'h-[44px] py-2 leading-6'}
										{...field}
									/>
								</FormControl>
								<FormMessage />
							</FormItem>
						)}
					/>
				</div>

				<div className={'col-span-12 lg:col-span-1'}>
					<Typography
						variant="caption_14px_500"
						text="Định vị trên bản đồ "
						className="flex items-start gap-1 text-neutral-600">
						<span className={'text-red-500'}>*</span>
					</Typography>

					<div
						className={
							'mt-2 h-[220px] w-full overflow-hidden rounded-xl'
						}>
						{renderMap}
					</div>
				</div>
			</div>
			<LocateOnMapDialog
				open={showModal}
				onClose={() => setShowModal(false)}
				defaultValues={
					latitude && longitude ? { latitude, longitude } : undefined
				}
				onSubmit={(data) => {
					setValue('address.latitude', data.latitude || 0);
					setValue('address.longitude', data.longitude || 0);
				}}
			/>
		</div>
	);
}
