'use client';
import ButtonActionGroup from '@/components/shared/Button/ButtonActionGroup';
import { Form } from '@/components/ui/form';
import AddressInfo from '@/containers/general-information/common/AddressInfo';
import FAQSectionInfo from '@/containers/general-information/common/FAQSectionInfo';
import GeneralInfo from '@/containers/general-information/common/GeneralInfo';
import IntroductionInfo from '@/containers/general-information/common/IntroductionInfo';
import {
	AccommodationInfo,
	AccommodationInfoSchema,
} from '@/lib/schemas/property-profile/general-information';
import { updateAccommodationProfile } from '@/services/accommodation/updateAccommodationProfile';
import { useAccommodationProfileStore } from '@/store/accommodation-profile/store';
import { useAttributeStore } from '@/store/attributes/store';
import { useLanguageStore } from '@/store/languages/store';
import { useLoadingStore } from '@/store/loading/store';
import { zodResolver } from '@hookform/resolvers/zod';
import { memo, useCallback, useEffect } from 'react';
import { useForm } from 'react-hook-form';
import { toast } from 'sonner';
import { useShallow } from 'zustand/react/shallow';

const MemoizedGeneralInfo = memo(GeneralInfo);
const MemoizedAddressInfo = memo(AddressInfo);
const MemoizedFAQSectionInfo = memo(FAQSectionInfo);
const MemoizedIntroductionInfo = memo(IntroductionInfo);

interface GeneralInformationProps {
	onNext: () => void;
}

export default function GeneralInformation({
	onNext,
}: GeneralInformationProps) {
	const { profile, setProfile } = useAccommodationProfileStore(
		useShallow((state) => ({
			profile: state.profile,
			setProfile: state.setProfile,
		}))
	);
	const setLoading = useLoadingStore((state) => state.setLoading);
	const { fetchAccommodationTypeList, fetchChainList } = useAttributeStore(
		useShallow((state) => ({
			fetchAccommodationTypeList: state.fetchAccommodationTypeList,
			fetchChainList: state.fetchChainList,
		}))
	);
	const fetchLanguageList = useLanguageStore(
		(state) => state.fetchLanguageList
	);

	const form = useForm<AccommodationInfo>({
		resolver: zodResolver(AccommodationInfoSchema),
		mode: 'onChange',
	});

	const { reset, handleSubmit } = form;

	const onSubmit = useCallback(
		async (value: AccommodationInfo) => {
			setLoading(true);
			try {

				const res = await updateAccommodationProfile(value);
				
				if (res) {
					toast.success('Cập nhật chỗ nghỉ thành công!');
					if (value.generalInfo.image instanceof File) {
						const url = URL.createObjectURL(
							value.generalInfo.image
						);
						value.generalInfo.image = url;
					}
					setProfile(value);
					window.scrollTo({
						top: 0,
					});
					
				} else {
					toast.error('Có lỗi xãy ra, vui lòng thử lại');
				}
			} catch (error) {
				toast.error('Có lỗi xãy ra, vui lòng thử lại');
			} finally {
				setLoading(false);
			}
		},
		[setLoading]
	);

	useEffect(() => {
		const fetchData = async () => {
			setLoading(true);
			try {
				await Promise.all([
					fetchAccommodationTypeList(),
					fetchChainList(),
					fetchLanguageList(),
				]);
			} catch (error) {
				console.error('Error fetching data:', error);
			} finally {
				setLoading(false);
			}
		};
		fetchData();
	}, [
		fetchChainList,
		fetchAccommodationTypeList,
		fetchLanguageList,
		setLoading,
	]);

	useEffect(() => {
		if (profile) {
			reset(profile);
		}
	}, [profile, reset]);

	return (
		<div className={'mt-8 bg-other-divider-02'}>
			<Form {...form}>
				<form onSubmit={handleSubmit(onSubmit)}>
					<div className={'space-y-8 bg-white'}>
						<MemoizedGeneralInfo />
						<MemoizedAddressInfo />
						<MemoizedIntroductionInfo />
						<MemoizedFAQSectionInfo />
						<ButtonActionGroup actionCancel={onNext} />
					</div>
				</form>
			</Form>
		</div>
	);
}
