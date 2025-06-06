import {DefaultImages} from '@/assets';
import {AppName, AppURL} from "@/lib/seeds/global";

export const baseOpenGraph = {
  locale: 'vi_vn',
  type: 'website',
  siteName: AppName,
  url: AppURL,
  images: [
    {
      url: DefaultImages.banners.blue,
      width: 1200,
      height: 630,
      alt: AppName,
    },
  ],
};
