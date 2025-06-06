import StoreLayout from '@/components/layouts/store-layout/StoreLayout';

export default function Layout({ children }: { children: React.ReactNode }) {
	return <StoreLayout>{children}</StoreLayout>;
}
