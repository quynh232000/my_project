<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

enum ProductStatus: string
{
    case PENDING = 'PENDING';
    case ACTIVE = 'ACTIVE';
    case DENY = 'DENY';
}

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $vietnameseNames = [
            'Bộ ga gối 3 món poly coton 1m6x2m và 1m8x2m hàng loại 1',
            'Khăn Tắm, Khăn Gội Đầu, Khăn Lau Mặt LOTUS TOWEL 100% Cotton Cao Cấp Mềm Mịn, Thấm Hút, Không Ra Màu',
            'Hộp Vải Đựng Đồ, Đựng Quần Áo, Đồ Lót Gấp Gọn - Thùng Đựng Đa Năng Có Nắp Đậy',
            'Tấm trải nệm văn phòng gấp gọn size 90x2m topeer mỏng- nệm ngủ văn phòng hàng loại 1 được chọn màu',
            'GỐC HOA HỒNG SIÊU NỤ (KHÁCH ĐƯỢC CHỌN MÀU)- tặng kèm kích rễ mầm + hướng dẫn trồng khi mua từ 5 gốc',
            'Bàn Học Gấp Gọn Tuvaicaocap Bàn Làm Việc Học Sinh Sinh Viên Để LapTop Chận Nhựa Gấp Đa Năng Gỗ MĐF',
            'Ga giường cotton tici phong cách Hàn Quốc, ga nệm mềm mịn không bai xù đã bo chun m6x2m và m8x2m',
            'Chiếu ngủ văn phòng loại lớn',
            'Hạt giống Rau Củ Quả trồng chậu, rau ăn lá,dây leo trồng quanh năm,nảy mầm tốt - Hạt giống Rạng Đông',
            'Gối Spa Chống Đau Mỏi Vai Gáy nặng 900gram/1c {HÀNG NHẬP KHẨU}',
            'Đèn Led Cảm Biến Chuyển Động Yosunlix Đèn Cảm Ứng Gắn Tường Cầu Thang Tủ Quần Áo Thông Minh Sạc USB',
            'Bình đựng nước giữ nhiệt Iced Americano có ống hút dung tích 600ml, Ly cốc giữ nhiệt cute uống cà phê dùng văn phòng',
            'Ly Giữ Nhiệt Iced Americano Inox 304 Đúc Liền Khối Cao Cấp Có Nắp Đậy Tặng Kèm Ống Hút Hàng Loại 1',
            'Bàn trang điểm bệt có ngăn kéo, bàn bệt có ngăn kéo chất liệu gỗ MDF phủ Melamine cao cấp',
            '[Choice] Khăn mặt nhỡ hoa MIHU KB19',
            'Khăn Tắm Gội Đầu Lau Mặt ROYAL TOWEL 100% Cotton Cao Cấp Bông Dày Thấm Hút Không Đổ Lông Dùng Cho Gia Đình Khách Sạn',
            '[GÓI CHÍNH HÃNG 1K] Hạt Giống Xà Lách Xoăn Xanh Chịu Nhiệt Tốt Trồng Quanh Năm Nhanh Thu Hoạch (1gr~200h) - CANH NÔNG',
            'Bình nhựa đựng nước muji trong suốt 350ml, 550ml, 800ml cao cấp nắp chống tràn có quai đeo Water Bottles【Chiosala12】',
            '( Giao Hoả tốc 2h ) Nệm gấp 3 chất liệu PE gọn nhẹ dễ sử dụng 80cm.1m.1m2-1m4-1m6-1m8x2m',
            'Đất Trồng Cây Viên Đất Nén Xơ Dừa Tiện Ích diệt khuẩn kháng sâu bệnh bổ sung nhiều vi sinh hữu cơ cho cây rau củ quả hoa',
        ];


        return [
            'name' => $this->faker->randomElement($vietnameseNames),
            'slug' => $this->faker->word(5, true),
            'image' => $this->faker->word(5, true),
            'sku' => $this->faker->word(3, true),
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 10, 100000),
            'percent_sale' => $this->faker->numberBetween(0, 5),
            'origin' => $this->faker->word(3, true),
            'status' => $this->randomStatus(),
            'category_id' => $this->faker->numberBetween(1, 10),
            'brand_id' => $this->faker->numberBetween(1, 3),
            'stock' => $this->faker->numberBetween(100, 1000),
            'sold' => $this->faker->numberBetween(100, 5000),
            'view_count' => $this->faker->numberBetween(99, 999),
            'priority' => $this->faker->numberBetween(1, 2),
            'is_published' => $this->faker->numberBetween(0, 1),
            'shop_id' => 1,
        ];
    }

    private function randomStatus(): string
    {
        return ProductStatus::cases()[array_rand(ProductStatus::cases())]->value;
    }
}
