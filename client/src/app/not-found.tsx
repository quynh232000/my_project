import Link from 'next/link';

export default function NotFound() {
	return (
		<div className="flex items-center justify-center min-h-screen bg-gradient-to-br from-purple-50 to-blue-100 px-4">
			<div className="text-center">
				<h1 className="text-9xl font-extrabold text-primary-600 drop-shadow-lg animate-bounce">
				404
				</h1>
				<h2 className="text-3xl font-semibold text-gray-800 mt-4 animate-fadeIn">
				Không tìm thấy nội dung 😓
				</h2>
				<p className="text-gray-600 mt-2 animate-fadeIn delay-100">
				URL của nội dung này đã bị thay đổi hoặc không còn tồn tại.
				<br />
				Nếu bạn đang lưu URL này, hãy thử truy cập lại từ trang chủ thay vì dùng URL đã lưu.
				</p>
				<Link
				href="/"
				className="mt-6 inline-block px-6 py-3 bg-primary-500 text-white text-lg rounded-full shadow hover:bg-primary-500 transition duration-300"
				>
				Về trang chủ
				</Link>
			</div>
		</div>
	);
}
