<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\Brand;
use App\Models\BrandCategory;
use App\Models\Category;
use App\Models\CoinRule;
use App\Models\PaymentMethod;
use App\Models\PostTypes;
use App\Models\Product;
use App\Models\Role;
use App\Models\Setting;
use App\Models\Shop;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\UserRole;
use Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $bank_data = array(array(1, 'Ngân hàng TMCP Kiên Long', 'KienLongBank', 'KLB', '970452', 'https://img.mservice.com.vn/momo_app_v2/img/KLB.png'), array(2, 'Ngân hàng TMCP Sài Gòn Thương Tín', 'Sacombank', 'STB', '970403', 'https://img.mservice.com.vn/momo_app_v2/img/STB.png'), array(3, 'Ngân hàng Công nghiệp Hàn Quốc - Chi nhánh Hà Nội', 'IBKHN', 'IBKHN', '970455', 'https://img.mservice.io/momo_app_v2/new_version/All_team_/new_logo_bank/ic_ibk_bank.png'), array(4, 'Ngân hàng TMCP Đầu tư và Phát triển Việt Nam', 'BIDV', 'BIDV', '970418', 'https://img.mservice.com.vn/momo_app_v2/img/BIDV.png'), array(5, 'Ngân hàng Liên doanh Việt - Nga', 'VRB', 'VRB', '970421', 'https://img.mservice.com.vn/momo_app_v2/img/VRB.png'), array(6, 'Ngân hàng KEB Hana – Chi nhánh Thành phố Hồ Chí Minh', 'KebHanaHCM', 'KEBHANAHCM', '970466', 'https://img.mservice.com.vn/app/img/payment/KEBHANAHCM.png'), array(7, 'Ngân hàng TMCP Sài Gòn - Hà Nội', 'SHB', 'SHB', '970443', 'https://img.mservice.com.vn/momo_app_v2/img/SHB.png'), array(8, 'Ngân hàng TNHH MTV Public Việt Nam', 'PublicBank', 'PBVN', '970439', 'https://img.mservice.com.vn/momo_app_v2/img/PBVN.png'), array(9, 'DBS Bank Ltd - Chi nhánh Thành phố Hồ Chí Minh', 'DBSBank', 'DBS', '796500', 'https://img.mservice.io/momo_app_v2/new_version/All_team_/new_logo_bank/ic_dbs.png'), array(10, 'Ngân hàng Nông nghiệp và Phát triển Nông thôn Việt Nam', 'Agribank', 'VARB', '970405', 'https://img.mservice.com.vn/momo_app_v2/img/VARB.png'), array(11, 'Ngân hàng Nông nghiệp và Phát triển Nông thôn Việt Nam', 'VietCredit', 'CFC', '970460', 'https://img.mservice.com.vn/momo_app_v2/img/CFC.png'), array(12, 'Ngân hàng TMCP Quân đội', 'MBBank', 'MB', '970422', 'https://img.mservice.com.vn/momo_app_v2/img/MB.png'), array(13, 'Ngân hàng TMCP Đông Á', 'DongABank', 'DAB', '970406', 'https://img.mservice.com.vn/momo_app_v2/img/DAB.png'), array(14, 'Ngân hàng TMCP Việt Nam Thương Tín', 'VietBank', 'VB', '970433', 'https://img.mservice.com.vn/momo_app_v2/img/VB.png'), array(15, 'Ngân hàng TMCP Xuất Nhập khẩu Việt Nam', 'Eximbank', 'EIB', '970431', 'https://img.mservice.com.vn/momo_app_v2/img/EIB.png'), array(16, 'VNPT Money', 'VNPTMoney', 'VNPTMONEY', '971011', 'https://img.mservice.com.vn/app/img/payment/VNPTMONEY.png'), array(17, 'Ngân hàng TMCP Sài Gòn Công Thương', 'SaigonBank', 'SGB', '970400', 'https://img.mservice.com.vn/momo_app_v2/img/SGB.png'), array(18, 'TMCP Việt Nam Thịnh Vượng - Ngân hàng số CAKE by VPBank', 'CAKE', 'CAKE', '546034', 'https://img.mservice.io/momo_app_v2/new_version/All_team_/new_logo_bank/ic_cake.png'), array(19, 'Ngân hàng TMCP Xăng dầu Petrolimex', 'PGBank', 'PGB', '970430', 'https://img.mservice.com.vn/momo_app_v2/img/PGB.png'), array(20, 'Ngân hàng TMCP Quốc Dân', 'NCB', 'NVB', '970419', 'https://img.mservice.com.vn/momo_app_v2/img/NVB.png'), array(21, 'Ngân hàng TNHH MTV HSBC array(Việt Nam)', 'HSBC', 'HSBC', '458761', 'https://img.mservice.io/momo_app_v2/new_version/All_team_/new_logo_bank/ic_hsbc.png'), array(22, 'Ngân hàng TNHH MTV Standard Chartered Bank Việt Nam', 'StandardChartered', 'STANDARD', '970410', 'https://img.mservice.io/momo_app_v2/new_version/All_team_/new_logo_bank/ic_standard_chartered.png'), array(23, 'Ngân hàng TMCP Kỹ thương Việt Nam', 'Techcombank', 'TCB', '970407', 'https://img.mservice.com.vn/momo_app_v2/img/TCB.png'), array(24, 'Ngân hàng TNHH Indovina', 'IndovinaBank', 'IVB', '970434', 'https://img.mservice.com.vn/momo_app_v2/img/IVB.png'), array(25, 'Ngân hàng TMCP Ngoại Thương Việt Nam', 'VietcomBank', 'VCB', '970436', 'https://img.mservice.com.vn/momo_app_v2/img/VCB.png'), array(26, 'Ngân hàng KEB Hana – Chi nhánh Hà Nội', 'KebHanaHN', 'KEBHANAHN', '970467', 'https://img.mservice.com.vn/app/img/payment/KEBHANAHCM.png'), array(27, 'Ngân hàng TNHH MTV Shinhan Việt Nam', 'ShinhanBank', 'SVB', '970424', 'https://img.mservice.com.vn/momo_app_v2/img/SVB.png'), array(28, 'Ngân hàng Kookmin - Chi nhánh Hà Nội', 'KookminHN', 'KBHN', '970462', 'https://img.mservice.io/momo_app_v2/new_version/All_team_/new_logo_bank/ic_kookmin_hn.png'), array(29, 'Ngân hàng TMCP Bưu Điện Liên Việt', 'LienVietPostBank', 'LPB', '970449', 'https://img.mservice.com.vn/momo_app_v2/img/LPB.png'), array(30, 'Ngân hàng TMCP Đại Chúng Việt Nam', 'PVcomBank', 'PVCB', '970412', 'https://img.mservice.com.vn/momo_app_v2/img/PVCB.png'), array(31, 'Ngân hàng TMCP An Bình', 'ABBANK', 'ABB', '970425', 'https://img.mservice.com.vn/momo_app_v2/img/ABB.png'), array(32, 'Ngân hàng Thương mại TNHH MTV Xây dựng Việt Nam', 'CBBank', 'CBB', '970444', 'https://img.mservice.io/momo_app_v2/new_version/All_team_/new_logo_bank/ic_cbbank.png'), array(33, 'Ngân hàng Kookmin - Chi nhánh Thành phố Hồ Chí Minh', 'KookminHCM', 'KBHCM', '970463', 'https://img.mservice.io/momo_app_v2/new_version/All_team_/new_logo_bank/ic_kookmin_hcm.png'), array(34, 'Ngân hàng TMCP Phát triển Thành phố Hồ Chí Minh', 'HDBank', 'HDB', '970437, 970420', 'https://img.mservice.com.vn/momo_app_v2/img/HDB.png'), array(35, 'Ngân hàng TMCP Tiên Phong', 'TPBank', 'TPB', '970423', 'https://img.mservice.com.vn/momo_app_v2/img/TPB.png'), array(36, 'Ngân hàng TMCP Việt Nam Thịnh Vượng', 'VPBank', 'VPB', '970432', 'https://img.mservice.com.vn/momo_app_v2/img/VPB.png'), array(37, 'TMCP Việt Nam Thịnh Vượng - Ngân hàng số Ubank by VPBank', 'Ubank', 'Ubank', '546035', 'https://img.mservice.io/momo_app_v2/new_version/All_team_/new_logo_bank/ic_ubank.png'), array(38, 'Ngân hàng TNHH MTV Woori Việt Nam', 'Woori', 'WOO', '970457', 'https://img.mservice.com.vn/momo_app_v2/img/WOO.png'), array(39, 'Ngân hàng Thương mại TNHH MTV Đại Dương', 'Oceanbank', 'OJB', '970414', 'https://img.mservice.com.vn/momo_app_v2/img/OJB.png'), array(40, 'Viettel Money', 'ViettelMoney', 'VTLMONEY', '971005', 'https://img.mservice.com.vn/app/img/payment/VIETTELMONEY.png'), array(41, 'Ngân hàng TMCP Đông Nam Á', 'SeABank', 'SEAB', '970440', 'https://img.mservice.com.vn/momo_app_v2/img/Seab.png'), array(42, 'Ngân hàng Công nghiệp Hàn Quốc - Chi nhánh TP. Hồ Chí Minh', 'IBKHCM', 'IBKHCM', '970456', 'https://img.mservice.com.vn/app/img/payment/IBK.png'), array(43, 'Ngân hàng Hợp tác xã Việt Nam', 'COOPBANK', 'COB', '970446', 'https://img.mservice.io/momo_app_v2/new_version/All_team_/new_logo_bank/ic_coop_bank.png'), array(44, 'Ngân hàng TMCP Hàng Hải', 'MSB', 'MSB', '970426', 'https://img.mservice.com.vn/momo_app_v2/img/MSB.png'), array(45, 'Ngân hàng TMCP Á Châu', 'ACB', 'ACB', '970416', 'https://img.mservice.com.vn/momo_app_v2/img/ACB.png'), array(46, 'Ngân hàng TMCP Bắc Á', 'BacABank', 'NASB', '970409', 'https://img.mservice.com.vn/momo_app_v2/img/NASB.png'), array(47, 'Ngân hàng TNHH MTV CIMB Việt Nam', 'CIMB', 'CIMB', '422589', 'https://img.mservice.io/momo_app_v2/new_version/All_team_/new_logo_bank/ic_cimb.png'), array(48, 'Ngân hàng TMCP Bản Việt', 'VietCapitalBank', 'VCCB', '970454', 'https://img.mservice.com.vn/momo_app_v2/img/VCCB.png'), array(49, 'Ngân hàng Đại chúng TNHH Kasikornbank', 'KBank', 'KBankHCM', '668888', 'https://img.mservice.io/momo_app_v2/new_version/All_team_/new_logo_bank/ic_kbank.png'), array(50, 'Ngân hàng TMCP Công thương Việt Nam', 'VietinBank', 'CTG', '970415', 'https://img.mservice.com.vn/momo_app_v2/img/CTG.png'), array(51, 'Ngân hàng United Overseas - Chi nhánh TP. Hồ Chí Minh', 'UnitedOverseas', 'UOB', '970458', 'https://img.mservice.com.vn/momo_app_v2/img/UOB.png'), array(52, 'Ngân hàng TNHH MTV Hong Leong Việt Nam', 'HongLeong', 'HLB', '970442', 'https://img.mservice.io/momo_app_v2/new_version/All_team_/new_logo_bank/ic_hong_leon_bank.png'), array(53, 'Ngân hàng TMCP Nam Á', 'NamABank', 'NAB', '970428', 'https://img.mservice.com.vn/momo_app_v2/img/NAB.png'), array(54, 'Ngân hàng TMCP Quốc tế Việt Nam', 'VIB', 'VIB', '970441', 'https://img.mservice.com.vn/momo_app_v2/img/VIB.png'), array(55, 'Ngân hàng TMCP Bảo Việt', 'BaoVietBank', 'BVB', '970438', 'https://img.mservice.com.vn/momo_app_v2/img/BVB.png'), array(56, 'Ngân hàng TMCP Phương Đông', 'OCB', 'OCB', '970448', 'https://img.mservice.com.vn/momo_app_v2/img/OCB.png'), array(57, 'Ngân hàng số Timo by Ban Viet Bank array(Timo by Ban Viet Bank)', 'Timo', 'TIMO', '963388', 'https://img.mservice.com.vn/app/img/payment/TIMO.png'), array(58, 'Ngân hàng Nonghyup - Chi nhánh Hà Nội', 'Nonghyup', 'NonghyupBankHN', '801011', 'https://img.mservice.io/momo_app_v2/new_version/All_team_/new_logo_bank/ic_nonghyu.png'), array(59, 'Công ty Tài chính TNHH MTV Mirae Asset array(Việt Nam)', 'MiraeAsset', 'MAFC', '970468', 'https://img.mservice.com.vn/app/img/payment/MAFC.png'), array(60, 'Ngân hàng TMCP Sài Gòn', 'SCB', 'SCB', '970429', 'https://img.mservice.com.vn/momo_app_v2/img/SCB.png'), array(61, 'Ngân hàng TMCP Việt Á', 'VietABank', 'VAB', '970427', 'https://img.mservice.com.vn/momo_app_v2/img/VAB.png'), array(62, 'Ngân hàng Thương mại TNHH MTV Dầu Khí Toàn Cầu', 'GPBank', 'GPB', '970408', 'https://img.mservice.com.vn/momo_app_v2/img/GPB.png'));

        foreach ($bank_data as $record) {
            Bank::create(
                [
                    'id' => $record[0],
                    'name' => $record[1],
                    'short_name' => $record[2],
                    'symbol' => $record[3],
                    'bin' => $record[4],
                    'logo_url' => $record[5],
                ]
            );
        }
        // User::factory(10)->create();
        Role::insert(
            [
                ['name' => 'User', 'description' => 'User role'],
                ['name' => 'Admin', 'description' => 'Admin role'],
                ['name' => 'Seller', 'description' => 'Seller role'],
                ['name' => 'Supper Admin', 'description' => 'Supper admin role'],
            ]
        );
        User::insert([
            ['uuid' => Str::uuid(), 'email' => 'user@gmail.com', 'username' => 'user@gmail.com', 'full_name' => 'Test User', 'password' => Hash::make('123456'), 'avatar_url' => 'https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg'],
            ['uuid' => Str::uuid(), 'email' => 'admin@gmail.com', 'username' => 'admin@gmail.com', 'full_name' => 'Test Admin', 'password' => Hash::make('123456'), 'avatar_url' => 'https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg'],
            ['uuid' => Str::uuid(), 'email' => 'seller@gmail.com', 'username' => 'seller@gmail.com', 'full_name' => 'Test Seller', 'password' => Hash::make('123456'), 'avatar_url' => 'https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg'],
            ['uuid' => Str::uuid(), 'email' => 'supperadmin@gmail.com', 'username' => 'supperadmin@gmail.com', 'full_name' => 'Test Supper Admin', 'password' => Hash::make('123456'), 'avatar_url' => 'https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg'],
        ]);
        UserRole::insert([
            ['user_id' => 1, 'role_id' => 1],
            ['user_id' => 2, 'role_id' => 1],
            ['user_id' => 3, 'role_id' => 1],
            ['user_id' => 4, 'role_id' => 1],
            ['user_id' => 2, 'role_id' => 2],
            ['user_id' => 3, 'role_id' => 3],
            ['user_id' => 4, 'role_id' => 4],
        ]);
        Category::insert([
            ['name' => 'Thời trang cho nữ', 'slug' => Str::slug('Thời trang cho nữ'), 'path' => 1, 'is_show' => true,'commission_fee'=>5],
            ['name' => 'Thời trang cho nam', 'slug' => Str::slug('Thời trang cho nam'), 'path' => 2, 'is_show' => true,'commission_fee'=>5],
            ['name' => 'Thời trang trẻ em', 'slug' => Str::slug('Thời trang trẻ em'), 'path' => 3, 'is_show' => true,'commission_fee'=>5],
            ['name' => 'Phụ kiện & Trang sức', 'slug' => Str::slug('Phụ kiện & Trang sức'), 'path' => 4, 'is_show' => true,'commission_fee'=>5],
            ['name' => 'Laptop & Máy tính', 'slug' => Str::slug('Laptop & Máy tính'), 'path' => 5, 'is_show' => true,'commission_fee'=>5],
            ['name' => 'Máy ảnh & Quay phim', 'slug' => Str::slug('Máy ảnh & Quay phim'), 'path' => 6, 'is_show' => true,'commission_fee'=>5],
            ['name' => 'Điện thoại & Phụ kiện', 'slug' => Str::slug('Điện thoại & Phụ kiện'), 'path' => 7, 'is_show' => true,'commission_fee'=>5],
            ['name' => 'Du lịch & Thể thao', 'slug' => Str::slug('Du lịch & Thể thao'), 'path' => 8, 'is_show' => true,'commission_fee'=>5],
            ['name' => 'Chăm sóc nhà cửa', 'slug' => Str::slug('Chăm sóc nhà cửa'), 'path' => 9, 'is_show' => true,'commission_fee'=>5],
            ['name' => 'Làm đẹp & Sức khỏe', 'slug' => Str::slug('Làm đẹp & Sức khỏe'), 'path' => 10, 'is_show' => true,'commission_fee'=>5],
            ['name' => 'Chăm sóc thú cưng', 'slug' => Str::slug('Chăm sóc thú cưng'), 'path' => 11, 'is_show' => true,'commission_fee'=>5],
            ['name' => 'Chăm sóc mẹ & Bé', 'slug' => Str::slug('Chăm sóc mẹ & Bé'), 'path' => 12, 'is_show' => true,'commission_fee'=>5],
            ['name' => 'Chưa phân loại', 'slug' => Str::slug('Chưa phân loại'), 'path' => 13, 'is_show' => false,'commission_fee'=>5],
        ]);
        Shop::create([
            'name'=>'Quin Ecommerce',
            'slug'=>Str::slug('Quin Ecommerce'),
            'logo'=>'',
            'email'=>'quynh232000@gmail.com',
            'bio'=>'Admin Quin Ecommerce',
            'phone_number'=>'0358723520',
            'address_detail'=>'Quận 12, Tp. Hồ Chí Minh, Việt Nam',
            'user_id'=>'3',
            'shop_code'=>5506575
        ]);
        PostTypes::insert([
            ['name'=>'BLOG','slug'=>Str::slug('blog')],
            ['name'=>'EDU','slug'=>Str::slug('edu')],
            ['name'=>'QA','slug'=>Str::slug('qa')],
        ]);
        CoinRule::insert([
            ['id'=>1,'rule_name'=>'Đăng ký tài khoản mới','coin_amount'=>'100','description'=>'Thưởng 100 coin cho người dùng khi họ đăng ký tài khoản mới.'],
            ['id'=>2,'rule_name'=>'Đăng nhập hàng ngày','coin_amount'=>'100','description'=>'Thưởng 100 coin mỗi khi người dùng đăng nhập vào hệ thống mỗi ngày.'],
            ['id'=>3,'rule_name'=>'Mua hàng lần đầu tiên','coin_amount'=>'200','description'=>'Thưởng 200 coin cho lần mua hàng đầu tiên của người dùng.'],
            ['id'=>4,'rule_name'=>'Viết đánh giá sản phẩm','coin_amount'=>'200','description'=>'Thưởng 50 coin mỗi lần người dùng viết đánh giá cho một sản phẩm.'],
            ['id'=>5,'rule_name'=>'Giới thiệu bạn bè','coin_amount'=>'200','description'=>'Thưởng 200 coin khi người dùng giới thiệu bạn bè đăng ký và mua hàng.'],
            ['id'=>6,'rule_name'=>'Thăng cấp VIP','coin_amount'=>'500','description'=>'Thưởng 500 coin khi người dùng đạt cấp độ VIP mới'],
            ['id'=>7,'rule_name'=>'Thưởng sinh nhật','coin_amount'=>'100','description'=>'Thưởng 100 coin cho người dùng vào ngày sinh nhật của họ'],
        ]);
        Setting::insert([
            ['type'=>'BANK','key'=>'BANK_NAME','value'=>'NGUYEN VAN QUYNH','description'=>'Tên chủ tài khoản.'],
            ['type'=>'BANK','key'=>'BANK_NUMBER','value'=>'0358723520','description'=>'Số tài khoản ngân hàng.'],
            ['type'=>'BANK','key'=>'BANK_CODE','value'=>'MB','description'=>'Tên ghi tắt ngân hàng.'],
            ['type'=>'PAYMENT','key'=>'COIN_PERCENT_ORDER','value'=>'10','description'=>'Phần trăm số lượng Xu có thể áp dụng cho đơn hàng.'],
        ]);
        PaymentMethod::insert([
            ['id'=>1,'code'=>'cod','name'=>'Thanh toán khi nhận hàng','description'=>'Thanh toán khi bạn nhận được hàng'],
            ['id'=>2,'code'=>'vnp','name'=>'Thanh toán ví VNPAY','description'=>'Thanh toán qua ví điện tử VNPAY'],
            ['id'=>3,'code'=>'banking','name'=>'Chuyển khoản ngân hàng (Quét mã QR)','description'=>'Chuyển khoản vào tài khoản của chúng tôi (Có thể quét mã QR). Đơn hàng sẽ được xác nhận ngay sau khi chuyển khoản thành công.'],
        ]);

    }
}
