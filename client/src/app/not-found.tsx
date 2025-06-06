import Link from 'next/link';

export default function NotFound() {
	return (
		<div className={'flex h-screen w-full flex-col bg-blue-100'}>
			<div className={'flex flex-col items-center px-4 pb-32 pt-12'}>
				<div className={'h-96 w-full'}></div>
				<div
					className={
						'mx-auto flex w-full flex-col items-center justify-center'
					}>
					<h2
						className={
							'text-flight-500 mb-4 text-center text-2xl font-semibold'
						}>
						Oops! Trang bạn tìm kiếm <br className={'md:hidden'} />
						không tồn tại.
					</h2>
					<p
						className={'mb-8 text-center text-md font-normal text-neutral-500'}>
						Có vẻ như đường dẫn không đúng hoặc trang này đã bị xóa. Hãy kiểm
						tra lại hoặc trở về trang chủ để tiếp tục khám phá.
					</p>
				</div>
				<Link
					href={'/'}
					className={
						'rounded-lg bg-secondary-500 px-6 py-3 leading-6 text-white'
					}>
					Trở về trang chủ
				</Link>
			</div>
		</div>
	);
}
