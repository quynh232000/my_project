import React from 'react';
import { getFullURLServerComponent } from '@/utils/url/getFullURLServerComponent';
import DashboardContainer from '@/components/shared/Dashboard/DashboardContainer';
import { DashboardHeroTitle } from '@/components/shared/Dashboard/DashboardHeroTitle';
import { DashboardCard } from '@/components/shared/Dashboard/DashboardCard';
import AlbumManager from '@/containers/album-manager/AlbumManager';
import ImageUploadNote from '@/containers/album-manager/ImageUploadNote';
import ImageGalleryAction from '@/containers/album-manager/common/ImageGalleryAction';

const Page = async () => {
	const { pathName } = await getFullURLServerComponent();
	return (
		<DashboardContainer>
			<DashboardHeroTitle
				pathName={pathName}
				title={'Thư viện ảnh'}
				extraContent={<ImageUploadNote/>}
				extraTitle={<ImageGalleryAction/>}
			/>
			<DashboardCard>
				<AlbumManager/>
			</DashboardCard>
		</DashboardContainer>
	);
};

export default Page;
