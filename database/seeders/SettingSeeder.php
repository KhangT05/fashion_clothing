<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
   /**
    * Run the database seeds.
    */
   public function run(): void
   {
      DB::table('settings')->insert([
         // Thông tin cơ bản
         'name' => 'Công ty TNHH Thương mại TH23WebC',
         'address' => '123 Nguyễn Văn Linh, Phường Tân Phú, Quận 7, TP. Hồ Chí Minh',
         'phone' => '0838212360',
         'description' => 'Chuyên cung cấp các sản phẩm chất lượng cao, dịch vụ tận tâm, giao hàng nhanh chóng trên toàn quốc.',
         'logo' => 'images/logo.png',
         'email' => 'cdth23webc@gmail.com',
         // Social Media
         'facebook_url' => 'https://www.facebook.com/TH23WebC',
         'youtube_url' => 'https://www.youtube.com/@TH23WebC',
         'instagram_url' => 'https://www.instagram.com/TH23WebC/',
         'linkedin_url' => 'https://linkedin.com/company/TH23WebC',
         'copyright' => '© 2026 CĐ TH 23WebC Company. All rights reserved.',

         // Thông tin bán hàng
         'sales_info' => 'THÔNG TIN BÁN HÀNG

Công ty TNHH TH23WebC cam kết mang đến cho quý khách hàng những sản phẩm chính hãng, chất lượng cao với giá cả cạnh tranh nhất thị trường.

THÔNG TIN DOANH NGHIỆP
- Tên công ty: Công ty TNHH TH23WebC
- Mã số thuế: 0838212360

- Địa chỉ: 123 Nguyễn Văn Linh, Phường Tân Phú, Quận 7, TP. Hồ Chí Minh
- Hotline: 0838212360

- Email: support@TH23WebC.com

CAM KẾT CỦA CHÚNG TÔI
- 100% sản phẩm chính hãng
- Giá cả cạnh tranh, minh bạch
- Hỗ trợ khách hàng 24/7
- Giao hàng nhanh chóng, uy tín

GIỜ LÀM VIỆC
- Thứ 2 - Thứ 6: 8:00 - 18:00
- Thứ 7 - Chủ nhật: 8:00 - 17:00
- Lễ, Tết: Liên hệ hotline',

         // Dịch vụ bán hàng
         'sales_services' => 'DỊCH VỤ BÁN HÀNG

Chúng tôi cung cấp đa dạng các dịch vụ nhằm mang lại trải nghiệm mua sắm tuyệt vời nhất cho quý khách hàng.

CÁC DỊCH VỤ NỔI BẬT

1. Tư vấn sản phẩm miễn phí
   - Đội ngũ tư vấn viên chuyên nghiệp
   - Hỗ trợ tận tình, nhiệt tình
   - Giải đáp mọi thắc mắc 24/7

2. Đặt hàng dễ dàng
   - Đặt hàng online qua website
   - Đặt hàng qua điện thoại
   - Đặt hàng tại cửa hàng

3. Thanh toán linh hoạt
   - Thanh toán khi nhận hàng (COD)
   - Chuyển khoản ngân hàng
   - Thanh toán qua ví điện tử
   - Thanh toán bằng thẻ tín dụng

4. Giao hàng tận nơi
   - Giao hàng toàn quốc
   - Giao hàng nhanh trong nội thành
   - Đóng gói cẩn thận, chuyên nghiệp

5. Chăm sóc sau bán hàng
   - Hỗ trợ kỹ thuật
   - Bảo hành sản phẩm
   - Đổi trả dễ dàng

Liên hệ: 0838212360
 để được phục vụ tt nhất!',

         // Chính sách vận chuyển
         'shipping_policy' => 'CHÍNH SÁCH VẬN CHUYỂN

TH23WebC cam kết giao hàng nhanh chóng, an toàn và đúng hẹn.

PHẠM VI GIAO HÀNG
- Giao hàng toàn quốc (63 tỉnh thành)
- Ưu tiên giao hàng nhanh tại TP.HCM và các tỉnh lân cận

THỜI GIAN GIAO HÀNG

Nội thành TP.HCM:
- Giao hàng nhanh: 2-4 giờ
- Giao hàng tiêu chuẩn: 1-2 ngày

Các tỉnh thành khác:
- Miền Nam: 2-3 ngày
- Miền Trung: 3-4 ngày
- Miền Bắc: 3-5 ngày

PHÍ VẬN CHUYỂN

- Đơn hàng từ 500.000đ: MIỄN PHÍ vận chuyển
- Đơn hàng dưới 500.000đ: 
  + Nội thành TP.HCM: 20.000đ
  + Ngoại thành: 30.000đ
  + Tỉnh khác: 35.000đ - 50.000đ

QUY TRÌNH VẬN CHUYỂN

1. Xác nhận đơn hàng qua điện thoại
2. Đóng gói cẩn thận, chuyên nghiệp
3. Bàn giao cho đơn vị vận chuyển
4. Cập nhật mã vận đơn cho khách hàng
5. Giao hàng và thu tiền COD (nếu có)

LƯU Ý
- Kiểm tra kỹ sản phẩm trước khi nhận hàng
- Quý khách có quyền từ chối nhận hàng nếu sản phẩm không đúng mô tả
- Liên hệ hotline ngay nếu có vấn đề phát sinh',

         // Giới thiệu
         'about_us' => 'Công ty TNHH TH23WebC là nền tảng bán lẻ đa ngành nghề số 1 Việt Nam. 

Với chiến lược omni-channel, Công ty vận hành mạng lưới hàng ngàn cửa hàng trên toàn quốc song song với việc tận dụng 
hiểu biết sâu rộng về khách hàng thông qua nền tảng dữ liệu lớn, 
năng lực chủ động triển khai các hoạt động hỗ trợ bán lẻ được xây dựng nội bộ và liên tục đổi mới công nghệ nhằm tạo ra trải nghiệm khách hàng vượt trội 
và thống nhất ở mọi kênh cũng như nâng cao sự gắn kết của người tiêu dùng với các thương hiệu của TH23WebC. 

Liên hệ với chúng tôi:
Hotline: 0838212360

Email: info@TH23WebC.com',

         // Chính sách đổi trả
         'return_policy' => 'CHÍNH SÁCH ĐỔI TRẢ

TH23WebC cam kết quyền lợi tốt nhất cho khách hàng với chính sách đổi trả linh hoạt và minh bạch.

ĐIỀU KIỆN ĐỔI TRẢ

Sản phẩm được đổi trả khi:
- Sản phẩm lỗi do nhà sản xuất
- Giao sai sản phẩm, sai màu sắc, kích thước
- Sản phẩm không đúng mô tả
- Sản phẩm bị hư hỏng trong quá trình vận chuyển
- Sản phẩm còn nguyên tem, mác, chưa qua sử dụng

THỜI GIAN ĐỔI TRẢ

- Đổi trả trong vòng 7 ngày kể từ ngày nhận hàng
- Đối với sản phẩm lỗi: Đổi trả trong vòng 30 ngày

QUY TRÌNH ĐỔI TRẢ

Bước 1: Liên hệ hotline 0838212360
 hoặc email support@TH23WebC.om
Bước 2: Cung cấp thông tin đơn hàng và lý do đổi trả
Bước 3: Gửi sản phẩm về công ty (chúng tôi hỗ trợ phí ship)
Bước 4: Kiểm tra sản phẩm
Bước 5: Đổi sản phẩm mới hoặc hoàn tiền trong 3-5 ngày làm việc

HOÀN TIỀN

- Hoàn tiền qua chuyển khoản ngân hàng
- Hoàn tiền vào ví điện tử
- Hoàn tiền mặt tại cửa hàng
- Thời gian hoàn tiền: 3-5 ngày làm việc

TRƯỜNG HỢP KHÔNG ĐỔI TRẢ

- Sản phẩm đã qua sử dụng
- Sản phẩm không còn nguyên vẹn, tem mác
- Sản phẩm đã quá thời hạn đổi trả
- Không có hóa đơn, chứng từ mua hàng

Mọi thắc mắc vui lòng liên hệ: 0838212360',

         // Chính sách bảo hành
         'warranty_policy' => 'CHÍNH SÁCH BẢO HÀNH

TH23WebC cam kết bảo hành chính hãng cho tất cả sản phẩm được mua tại hệ thống.

CAM KẾT BẢO HÀNH

- Bảo hành chính hãng từ nhà sản xuất
- Quy trình bảo hành nhanh chóng, minh bạch
- Hỗ trợ kỹ thuật nhiệt tình

THỜI GIAN BẢO HÀNH

Tùy theo từng loại sản phẩm:
- Điện tử, điện máy: 12-24 tháng
- Thời trang, phụ kiện: 3-6 tháng
- Mỹ phẩm: Theo quy định nhà sản xuất

ĐIỀU KIỆN BẢO HÀNH

Sản phẩm được bảo hành khi:
- Còn trong thời gian bảo hành
- Có tem bảo hành, phiếu bảo hành hợp lệ
- Lỗi do nhà sản xuất
- Không có dấu hiệu va đập, rơi vỡ

QUY TRÌNH BẢO HÀNH

Bước 1: Mang sản phẩm và phiếu bảo hành đến trung tâm bảo hành
Bước 2: Kiểm tra tình trạng sản phẩm
Bước 3: Tiếp nhận và cấp phiếu tiếp nhận
Bước 4: Sửa chữa hoặc thay thế linh kiện
Bước 5: Trả sản phẩm cho khách hàng

TRƯỜNG HỢP KHÔNG BẢO HÀNH

- Sản phẩm hết thời gian bảo hành
- Sản phẩm bị rơi, vỡ, vào nước
- Sản phẩm tự ý sửa chữa bởi bên thứ ba
- Tem bảo hành bị rách, mờ không đọc được

TRUNG TÂM BẢO HÀNH
Địa chỉ: 123 Nguyễn Văn Linh, Quận 7, TP.HCM
Hotline: 0838212360

Giờ làm việc: 8:00 - 18:00 (Thứ 2 - Thứ 7)',

         // Chính sách bảo mật thông tin
         'privacy_policy' => 'CHÍNH SÁCH BẢO MẬT THÔNG TIN

TH23WebC cam kết bảo vệ thông tin cá nhân của khách hàng một cách tối đa.

CAM KẾT BẢO MẬT

Chúng tôi cam kết:
- Thu thập thông tin hợp pháp, minh bạch
- Bảo mật tuyệt đối thông tin khách hàng
- Không chia sẻ với bên thứ ba khi chưa có sự đồng ý
- Sử dụng công nghệ bảo mật hiện đại

THÔNG TIN CHÚNG TÔI THU THẬP

Thông tin cá nhân:
- Họ tên
- Số điện thoại
- Email
- Địa chỉ giao hàng

Thông tin giao dịch:
- Lịch sử mua hàng
- Phương thức thanh toán
- Giá trị đơn hàng

Thông tin kỹ thuật:
- Địa chỉ IP
- Loại trình duyệt
- Hệ điều hành

MỤC ĐÍCH SỬ DỤNG

Chúng tôi sử dụng thông tin để:
- Xử lý đơn hàng
- Giao hàng chính xác
- Chăm sóc khách hàng
- Gửi thông tin khuyến mãi (nếu đồng ý)
- Cải thiện dịch vụ

BIỆN PHÁP BẢO MẬT

- Mã hóa SSL cho mọi giao dịch
- Tường lửa bảo vệ hệ thống
- Backup dữ liệu định kỳ
- Đào tạo nhân viên về bảo mật
- Kiểm tra an ninh thường xuyên

QUYỀN CỦA KHÁCH HÀNG

Khách hàng có quyền:
- Truy cập thông tin cá nhân
- Yêu cầu chỉnh sửa thông tin
- Yêu cầu xóa thông tin
- Từ chối nhận email marketing
- Khiếu nại về việc lộ thông tin

CHIA SẺ THÔNG TIN

Chúng tôi chỉ chia sẻ thông tin với:
- Đối tác vận chuyển (để giao hàng)
- Cổng thanh toán (để xử lý giao dịch)
- Cơ quan pháp luật (khi có yêu cầu hợp pháp)

THỜI GIAN LƯU TRỮ

- Lưu trữ trong thời gian cần thiết
- Tối thiểu theo quy định pháp luật
- Xóa khi không còn mục đích sử dụng
LIÊN HỆ

Thắc mắc về chính sách bảo mật:
Email: privacy@TH23WebC.com
Hotline: 0838212360


Cập nhật lần cuối: 15/01/2026',

         'created_at' => now(),
         'updated_at' => now(),
      ]);
      $this->command->info('✅ Đã tạo thông tin cài đặt website thành công!');
   }
}
