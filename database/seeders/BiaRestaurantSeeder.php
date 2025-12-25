<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Category;
use App\Models\Menu;
use App\Models\MenuOption;
use App\Models\Table;
use App\Models\TemporaryOrder;
use App\Models\Transaction;
use App\Models\Reservation;
use App\Models\Role;
use Faker\Factory as Faker;

class BiaRestaurantSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('vi_VN');

        // Clear existing data (optional - comment out if you want to keep existing data)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('transactions')->truncate();
        DB::table('temporary_orders')->truncate();
        DB::table('reservations')->truncate();
        DB::table('menu_options')->truncate();
        DB::table('menus')->truncate();
        DB::table('categories')->truncate();
        DB::table('tables')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. CREATE CATEGORIES
        $categories = [
            ['name' => 'Bia'],
            ['name' => 'Món khai vị'],
            ['name' => 'Các món nộm'],
            ['name' => 'Món đậu'],
            ['name' => 'Món rau'],
            ['name' => 'Các món gà'],
            ['name' => 'Chim câu'],
            ['name' => 'Các món lợn'],
            ['name' => 'Món chó'],
            ['name' => 'Món lươn'],
            ['name' => 'Dê tươi'],
            ['name' => 'Trâu'],
            ['name' => 'Bê'],
            ['name' => 'Các món bò'],
            ['name' => 'Cá quả'],
            ['name' => 'Cá chép'],
            ['name' => 'Cá trình, cá trứng'],
            ['name' => 'Tôm'],
            ['name' => 'Cá tầm'],
            ['name' => 'Cá song, cá chim'],
            ['name' => 'Cá lăng'],
            ['name' => 'Hải sản'],
            ['name' => 'Ba ba'],
            ['name' => 'Ếch'],
            ['name' => 'Lẩu'],
            ['name' => 'Cơm rang, mỳ xào'],
            ['name' => 'Các món cơm canh'],
            ['name' => 'Đồ uống'],
            ['name' => 'Rượu ngâm'],
            ['name' => 'Rượu'],
        ];

        $categoryIds = [];
        foreach ($categories as $cat) {
            $id = DB::table('categories')->insertGetId($cat);
            $categoryIds[$cat['name']] = $id;
        }

        // 2. CREATE MENU ITEMS WITH PRICES
        $menuData = [
            // BIA
            'Bia' => [
                ['name' => 'Bia hơi Hà Nội (Cốc)', 'price' => 15000],
                ['name' => 'Bia hơi Hà Nội (Lít)', 'price' => 45000],
                ['name' => 'Bia Hà Nội chai', 'price' => 26000],
                ['name' => 'Bia Hà Nội Light', 'price' => 26000],
                ['name' => 'Bia Hà Nội Bold', 'price' => 26000],
                ['name' => 'Bia Sài Gòn Xanh', 'price' => 30000],
                ['name' => 'Bia Sài Gòn Chill', 'price' => 30000],
                ['name' => 'Bia Trúc Bạch', 'price' => 35000],
                ['name' => 'Bia Heniken', 'price' => 35000],
                ['name' => 'Bia Tiger bạc', 'price' => 32000],
            ],
            // MÓN KHAI VỊ
            'Món khai vị' => [
                ['name' => 'Lạc rang', 'price' => 15000],
                ['name' => 'Lạc luộc', 'price' => 20000],
                ['name' => 'Nem bùi', 'price' => 50000],
                ['name' => 'Mực khô nướng', 'price' => 0], // Giá theo con
            ],
            // CÁC MÓN NỘM
            'Các món nộm' => [
                ['name' => 'Nộm sứa', 'price' => 100000],
                ['name' => 'Nộm hoa chuối tai', 'price' => 100000],
                ['name' => 'Nộm hoa chuối gà', 'price' => 130000],
                ['name' => 'Nộm xoài cá cơm', 'price' => 140000],
                ['name' => 'Nộm gà xé phay', 'price' => 200000],
                ['name' => 'Nộm bò bóp thấu', 'price' => 270000],
                ['name' => 'Dưa chuột chẻ', 'price' => 35000],
                ['name' => 'Xa lát cà chua dưa chuột', 'price' => 90000],
                ['name' => 'Mướp đắng ruốc', 'price' => 90000],
            ],
            // MÓN ĐẬU
            'Món đậu' => [
                ['name' => 'Đậu rán', 'price' => 60000],
                ['name' => 'Đậu lướt', 'price' => 50000],
                ['name' => 'Đậu luộc', 'price' => 50000],
                ['name' => 'Đậu tẩm hành', 'price' => 70000],
                ['name' => 'Đậu chiên xù', 'price' => 90000],
                ['name' => 'Đậu chiên trứng muối', 'price' => 120000],
                ['name' => 'Đậu sốt cà chua', 'price' => 90000],
                ['name' => 'Đậu sốt tóp mỡ cà chua', 'price' => 120000],
                ['name' => 'Đậu tứ xuyên', 'price' => 120000],
                ['name' => 'Khoai tây chiên', 'price' => 70000],
                ['name' => 'Khoai lang kén', 'price' => 70000],
                ['name' => 'Ngô chiên', 'price' => 70000],
            ],
            // MÓN RAU
            'Món rau' => [
                ['name' => 'Ngọn Su luộc', 'price' => 60000],
                ['name' => 'Ngọn Su xào', 'price' => 70000],
                ['name' => 'Rau muống luộc', 'price' => 50000],
                ['name' => 'Rau muống xào tỏi', 'price' => 60000],
                ['name' => 'Cải ngồng xào', 'price' => 70000],
                ['name' => 'Cải xanh trần', 'price' => 60000],
                ['name' => 'Cải xanh luộc trứng', 'price' => 80000],
                ['name' => 'Cải xanh xào nấm', 'price' => 90000],
                ['name' => 'Ngồng cải luộc trứng', 'price' => 90000],
                ['name' => 'Rau lang luộc', 'price' => 50000],
                ['name' => 'Rau lang xào', 'price' => 60000],
                ['name' => 'Mồng tơi luộc', 'price' => 70000],
                ['name' => 'Mồng tơi xào', 'price' => 80000],
                ['name' => 'Rau cần xào tỏi', 'price' => 70000],
                ['name' => 'Lặc lè luộc', 'price' => 70000],
                ['name' => 'Củ quả luộc muối vừng', 'price' => 80000],
                ['name' => 'Củ quả luộc kho quẹt', 'price' => 100000],
                ['name' => 'Mướp đắng xào trứng', 'price' => 90000],
                ['name' => 'Măng tây xào tỏi', 'price' => 100000],
            ],
            // CÁC MÓN GÀ
            'Các món gà' => [
                ['name' => 'Gà chiên mắm', 'price' => 280000],
                ['name' => 'Gà rang gừng', 'price' => 250000],
                ['name' => 'Gà rang muối', 'price' => 280000],
                ['name' => 'Gà hấp lá chanh', 'price' => 480000],
                ['name' => 'Gà không lối thoát', 'price' => 590000],
                ['name' => 'Gà nướng dân tộc', 'price' => 480000],
                ['name' => 'Lẩu gà ngải cứu', 'price' => 570000],
                ['name' => 'Lẩu gà nấm', 'price' => 690000],
                ['name' => 'Phượng hoàng tái sinh', 'price' => 880000],
                ['name' => 'Chân gà rút xương chiên sả ớt', 'price' => 240000],
                ['name' => 'Chân gà rút xương rang muối', 'price' => 240000],
                ['name' => 'Nộm chân gà rút xương', 'price' => 220000],
                ['name' => 'Lòng mề gà xào giá hẹ', 'price' => 220000],
            ],
            // CHIM CÂU
            'Chim câu' => [
                ['name' => 'Chim câu quay', 'price' => 270000],
                ['name' => 'Chim câu xúc phồng tôm', 'price' => 290000],
                ['name' => 'Chim câu xào cà', 'price' => 290000],
                ['name' => 'Chim câu xào hành răm', 'price' => 280000],
                ['name' => 'Lẩu chim câu', 'price' => 700000],
            ],
            // CÁC MÓN LỢN
            'Các món lợn' => [
                ['name' => 'Lợn Quay', 'price' => 260000],
                ['name' => 'Tóp mỡ Hải Xồm dưa chua', 'price' => 260000],
                ['name' => 'Má đào lợn nướng', 'price' => 260000],
                ['name' => 'Má đào lợn chiên', 'price' => 260000],
                ['name' => 'Dải lợn nướng', 'price' => 260000],
                ['name' => 'Lòng sụn nướng', 'price' => 240000],
                ['name' => 'Sụn rang muối', 'price' => 240000],
                ['name' => 'Sụn chiên cay', 'price' => 240000],
                ['name' => 'Sụn om sấu (Nồi)', 'price' => 520000],
                ['name' => 'Cuống tim xào lá hẹ', 'price' => 260000],
                ['name' => 'Tim cật xào bông hẹ', 'price' => 240000],
                ['name' => 'Tim cật xào lá hẹ', 'price' => 240000],
                ['name' => 'Ba chỉ cuộn măng tây nướng', 'price' => 250000],
                ['name' => 'Ba chỉ hun khói xào măng tây', 'price' => 250000],
                ['name' => 'Khấu đuôi xào cay', 'price' => 260000],
                ['name' => 'Khấu đuôi chiên giòn', 'price' => 260000],
            ],
            // MÓN CHÓ
            'Món chó' => [
                ['name' => 'Chó hấp', 'price' => 270000],
                ['name' => 'Chả chó', 'price' => 260000],
            ],
            // MÓN LƯƠN
            'Món lươn' => [
                ['name' => 'Lươn om cà pháo (Bát)', 'price' => 280000],
                ['name' => 'Lươn om cà pháo (Nồi)', 'price' => 490000],
            ],
            // DÊ TƯƠI
            'Dê tươi' => [
                ['name' => 'Tiết canh dê', 'price' => 50000],
                ['name' => 'Dê quay tùng xẻo', 'price' => 280000],
                ['name' => 'Dê tái chanh', 'price' => 280000],
                ['name' => 'Xách dê xào dứa', 'price' => 260000],
                ['name' => 'Dê xào lăn', 'price' => 280000],
                ['name' => 'Dê chao dầu', 'price' => 300000],
                ['name' => 'Dê nướng tảng', 'price' => 300000],
                ['name' => 'Dê hấp', 'price' => 300000],
                ['name' => 'Dê nhúng mẻ (Bát)', 'price' => 340000],
                ['name' => 'Dê nhúng mẻ (Nồi)', 'price' => 760000],
                ['name' => 'Dê tay cầm', 'price' => 850000],
                ['name' => 'Lẩu dê thuốc bắc', 'price' => 780000],
                ['name' => 'Cà dê tiềm thuốc bắc bát', 'price' => 480000],
                ['name' => 'Cà dê tiềm thuốc bắc nồi', 'price' => 850000],
            ],
            // TRÂU
            'Trâu' => [
                ['name' => 'Tiết trâu luộc', 'price' => 50000],
                ['name' => 'Bắp trâu xào măng trúc', 'price' => 270000],
                ['name' => 'Bắp trâu xào hành dăm', 'price' => 260000],
                ['name' => 'Bắp trâu xào ngồng tỏi', 'price' => 270000],
                ['name' => 'Bắp trâu xào rau cần', 'price' => 260000],
                ['name' => 'Bắp trâu trần', 'price' => 280000],
                ['name' => 'Trâu nướng lá lốt', 'price' => 260000],
                ['name' => 'Trâu nhúng mẻ (Bát)', 'price' => 280000],
                ['name' => 'Trâu nhúng mẻ (Nồi)', 'price' => 580000],
                ['name' => 'Lẩu trâu (Nồi)', 'price' => 570000],
                ['name' => 'Trâu xào bông hẹ', 'price' => 260000],
                ['name' => 'Trâu xé tay đặc biệt', 'price' => 270000],
                ['name' => 'Trâu bóp thấu', 'price' => 270000],
                ['name' => 'Trâu xào các loại rau', 'price' => 240000],
                ['name' => 'Trâu tái chanh', 'price' => 250000],
                ['name' => 'Trâu cháy tỏi Hải Xồm', 'price' => 280000],
                ['name' => 'Trâu cháy tiêu xanh', 'price' => 280000],
                ['name' => 'Trâu cuốn cải', 'price' => 270000],
                ['name' => 'Trâu nhúng mẻ bát', 'price' => 280000],
                ['name' => 'Trâu nướng lá lốt', 'price' => 260000],
                ['name' => 'Trâu om lá nồm bát', 'price' => 280000],
                ['name' => 'Trâu om lá nồm (Nồi)', 'price' => 550000],
            ],
            // BÊ
            'Bê' => [
                ['name' => 'Bê xào măng trúc', 'price' => 260000],
                ['name' => 'Bê tái chanh', 'price' => 260000],
                ['name' => 'Bê xào xả ớt', 'price' => 260000],
                ['name' => 'Bê xào lăn', 'price' => 260000],
                ['name' => 'Bê xào ngồng tỏi', 'price' => 270000],
                ['name' => 'Bê hấp tương', 'price' => 270000],
                ['name' => 'Bê chao dầu', 'price' => 270000],
                ['name' => 'Bê nhúng mẻ bát', 'price' => 280000],
                ['name' => 'Bê quay', 'price' => 260000],
                ['name' => 'Lẩu Bê (Nồi)', 'price' => 520000],
                ['name' => 'Bê nhúng dấm (Nồi)', 'price' => 520000],
                ['name' => 'Bê sống (Đĩa)', 'price' => 260000],
            ],
            // CÁC MÓN BÒ
            'Các món bò' => [
                ['name' => 'Bò xào bông hẹ', 'price' => 270000],
                ['name' => 'Nộm bò bóp thấu', 'price' => 270000],
                ['name' => 'Bò xào cần tỏi', 'price' => 240000],
                ['name' => 'Bò xào các loại rau', 'price' => 270000],
                ['name' => 'Bò cải cuốn', 'price' => 260000],
                ['name' => 'Bò nướng lá lốt', 'price' => 280000],
                ['name' => 'Bắp bò trần', 'price' => 260000],
                ['name' => 'Bắp bò xào', 'price' => 290000],
                ['name' => 'Bò sốt tiêu đen', 'price' => 260000],
                ['name' => 'Lẩu bắp bò riêu cua', 'price' => 590000],
                ['name' => 'Lẩu bò nhúng dấm', 'price' => 560000],
                ['name' => 'Lẩu bò nhúng mẻ', 'price' => 560000],
                ['name' => 'Lẩu bắp bò sườn sụn riêu cua', 'price' => 590000],
            ],
            // CÁ QUẢ
            'Cá quả' => [
                ['name' => 'Cá quả nướng mọi', 'price' => 400000],
                ['name' => 'Cá quả nướng muối ớt', 'price' => 400000],
                ['name' => 'Cá quả om măng cay', 'price' => 490000],
                ['name' => 'Lẩu cá quả', 'price' => 490000],
                ['name' => 'Cá quả nấu rau cải', 'price' => 490000],
                ['name' => 'Cá quả nấu dọc mùng', 'price' => 550000],
                ['name' => 'Cá quả nấu bầu', 'price' => 550000],
            ],
            // CÁ CHÉP
            'Cá chép' => [
                ['name' => 'Cá chép chiên xù', 'price' => 420000],
                ['name' => 'Cá chép chiên giòn', 'price' => 420000],
                ['name' => 'Cá chép hấp xì dầu (Nồi)', 'price' => 420000],
                ['name' => 'Cá chép om dưa (Nồi)', 'price' => 420000],
                ['name' => 'Lẩu cá chép', 'price' => 420000],
            ],
            // CÁ TRÌNH, CÁ TRỨNG
            'Cá trình, cá trứng' => [
                ['name' => 'Cá trứng nướng', 'price' => 220000],
                ['name' => 'Cá trứng chiên', 'price' => 220000],
                ['name' => 'Cá trạch chiên lá lốt', 'price' => 250000],
                ['name' => 'Cá trình nướng', 'price' => 0], // Theo thời giá
                ['name' => 'Cá trình rang muối', 'price' => 0], // Theo thời giá
                ['name' => 'Lẩu cá trình', 'price' => 0], // Theo thời giá
                ['name' => 'Cá trình om chuối đậu', 'price' => 0], // Theo thời giá
                ['name' => 'Cá trình nấu canh chua', 'price' => 0], // Theo thời giá
                ['name' => 'Cá trình om măng cay', 'price' => 0], // Theo thời giá
            ],
            // TÔM
            'Tôm' => [
                ['name' => 'Tôm sú nướng (đĩa)', 'price' => 0], // Theo thời giá
                ['name' => 'Tôm sú hấp (đĩa)', 'price' => 0], // Theo thời giá
                ['name' => 'Tôm sú chiên trứng muối', 'price' => 380000],
                ['name' => 'Tôm sú chiên xù', 'price' => 380000],
                ['name' => 'Gỏi tôm', 'price' => 0], // Theo thời giá
                ['name' => 'Tôm đồng chiên', 'price' => 230000],
                ['name' => 'Tôm đồng nướng', 'price' => 230000],
            ],
            // CÁ TẦM
            'Cá tầm' => [
                ['name' => 'Cá tầm nướng', 'price' => 620000], // Đơn giá/kg
                ['name' => 'Cá tầm rang muối', 'price' => 620000],
                ['name' => 'Cá tầm trộn', 'price' => 620000],
                ['name' => 'Lẩu cá tầm', 'price' => 620000],
                ['name' => 'Cá tầm om chuối đậu', 'price' => 620000],
                ['name' => 'Cá tầm om riềng mẻ', 'price' => 620000],
                ['name' => 'Cá tầm om măng cay', 'price' => 620000],
            ],
            // CÁ SONG, CÁ CHIM
            'Cá song, cá chim' => [
                ['name' => 'Gỏi cá hồi', 'price' => 0], // Theo thời giá
                ['name' => 'Ốc hương nướng', 'price' => 0], // Theo thời giá
                ['name' => 'Ốc hương hấp', 'price' => 0], // Theo thời giá
                ['name' => 'Lẩu cá song', 'price' => 0], // Theo thời giá
                ['name' => 'Cá song hấp xì dầu', 'price' => 0], // Theo thời giá
                ['name' => 'Gỏi cá song', 'price' => 0], // Theo thời giá
                ['name' => 'Cháo cá song', 'price' => 0], // Theo thời giá
                ['name' => 'Cá chim nướng muối ớt', 'price' => 0], // Theo thời giá
            ],
            // CÁ LĂNG
            'Cá lăng' => [
                ['name' => 'Cá lăng nướng', 'price' => 450000], // Đơn giá/kg
                ['name' => 'Cá lăng rang muối', 'price' => 450000],
                ['name' => 'Cá lăng trộn', 'price' => 450000],
                ['name' => 'Lẩu cá lăng', 'price' => 450000],
                ['name' => 'Cá lăng om chuối đậu', 'price' => 450000],
                ['name' => 'Cá lăng om riềng mẻ', 'price' => 450000],
                ['name' => 'Cá lăng om măng cay', 'price' => 450000],
            ],
            // HẢI SẢN
            'Hải sản' => [
                ['name' => 'Mực sữa chiên mắm', 'price' => 250000],
                ['name' => 'Mực sữa chiên bơ', 'price' => 250000],
                ['name' => 'Mực ghim hấp', 'price' => 250000],
                ['name' => 'Mực ghim nướng', 'price' => 250000],
                ['name' => 'Mực trứng chiên', 'price' => 300000],
                ['name' => 'Mực trứng nháy', 'price' => 300000],
                ['name' => 'Mực nháy đặc biệt', 'price' => 380000],
                ['name' => 'Tôm nõn xào măng tây', 'price' => 280000],
                ['name' => 'Cùi sò điệp xào măng tây', 'price' => 280000],
                ['name' => 'Mực tươi xào măng tây', 'price' => 280000],
                ['name' => 'Gỏi hàu', 'price' => 0], // Theo thời giá
                ['name' => 'Sò huyết hấp', 'price' => 25000],
                ['name' => 'Ngao hoa hấp', 'price' => 0], // Theo thời giá
                ['name' => 'Sò huyết nướng', 'price' => 0], // Theo thời giá
                ['name' => 'Ngao thường hấp', 'price' => 0], // Theo thời giá
                ['name' => 'Hàu nướng mỡ hành', 'price' => 30000],
            ],
            // BA BA
            'Ba ba' => [
                ['name' => 'Ba ba om chuối đậu', 'price' => 850000], // 1,2-1,8kg
                ['name' => 'Ba ba rang muối', 'price' => 950000], // 1,8-2,2kg
                ['name' => 'Lẩu rượu vang', 'price' => 950000], // Trên 2,2kg (giảm xuống để phù hợp DB)
                ['name' => 'Hồng Xíu', 'price' => 0], // Theo từng loại
            ],
            // ẾCH
            'Ếch' => [
                ['name' => 'Ếch rang muối', 'price' => 250000],
                ['name' => 'Ếch xào măng', 'price' => 250000],
                ['name' => 'Ếch xào xả ớt', 'price' => 250000],
                ['name' => 'Lẩu ếch (Nồi)', 'price' => 490000],
                ['name' => 'Ếch om chuối đậu (Nồi)', 'price' => 540000],
            ],
            // LẨU
            'Lẩu' => [
                ['name' => 'Lẩu bê', 'price' => 520000],
                ['name' => 'Lẩu trâu', 'price' => 570000],
                ['name' => 'Lẩu gà ngải cứu', 'price' => 570000],
                ['name' => 'Lẩu gà nấm', 'price' => 690000],
                ['name' => 'Lẩu ếch', 'price' => 490000],
                ['name' => 'Lẩu cá quả', 'price' => 490000],
                ['name' => 'Lẩu cá chép', 'price' => 420000],
                ['name' => 'Lẩu bắp bò riêu cua', 'price' => 590000],
                ['name' => 'Lẩu hải sản', 'price' => 920000],
                ['name' => 'Lẩu thập cẩm', 'price' => 690000],
                ['name' => 'Lẩu thái hải sản', 'price' => 920000],
                ['name' => 'Lẩu gạch tôm sông giã tay', 'price' => 690000],
                ['name' => 'Lẩu bắp bò sườn sụn riêu cua', 'price' => 590000],
            ],
            // CƠM RANG, MỲ XÀO
            'Cơm rang, mỳ xào' => [
                ['name' => 'Cơm rang mắm tép', 'price' => 80000],
                ['name' => 'Cơm rang muối', 'price' => 170000],
                ['name' => 'Cơm rang thập cẩm', 'price' => 150000],
                ['name' => 'Cơm rang trứng', 'price' => 150000],
                ['name' => 'Cơm rang dưa bò', 'price' => 100000],
                ['name' => 'Cơm rang hải sản', 'price' => 100000],
                ['name' => 'Mỳ xào rau cải', 'price' => 150000],
                ['name' => 'Mỳ xào hải sản', 'price' => 100000],
                ['name' => 'Mỳ xào bò nấm', 'price' => 150000],
                ['name' => 'Miến xào bò nấm', 'price' => 100000],
                ['name' => 'Mỳ nấu bò hành mùi bát', 'price' => 120000],
                ['name' => 'Mỳ nấu bò rau cải bát', 'price' => 160000],
            ],
            // CÁC MÓN CƠM CANH
            'Các món cơm canh' => [
                ['name' => 'Cơm tám', 'price' => 30000],
                ['name' => 'Cà muối', 'price' => 20000],
                ['name' => 'Ba chỉ rang', 'price' => 150000],
                ['name' => 'Ba chỉ luộc', 'price' => 240000],
                ['name' => 'Trứng đúc thịt', 'price' => 100000],
                ['name' => 'Trứng tráng', 'price' => 80000],
                ['name' => 'Canh ngao chua', 'price' => 120000],
                ['name' => 'Canh cải thịt', 'price' => 100000],
                ['name' => 'Canh cua mùng tơi', 'price' => 80000],
                ['name' => 'Canh thịt nấu chua', 'price' => 100000],
                ['name' => 'Canh cải gừng', 'price' => 70000],
            ],
            // ĐỒ UỐNG
            'Đồ uống' => [
                ['name' => 'Nước suối', 'price' => 10000],
                ['name' => 'Fanta', 'price' => 20000],
                ['name' => 'Coca Cola', 'price' => 20000],
                ['name' => 'Bò húc', 'price' => 30000],
                ['name' => 'Putinka', 'price' => 280000],
                ['name' => 'Rượu Vodka Men', 'price' => 80000],
                ['name' => 'Rượu Vodka SHERIFF', 'price' => 240000],
                ['name' => 'Cá sấu xanh', 'price' => 180000],
                ['name' => 'Cá sấu đen', 'price' => 290000],
                ['name' => 'Rượu Vodka Amunden', 'price' => 300000],
            ],
            // RƯỢU NGÂM
            'Rượu ngâm' => [
                ['name' => 'Vua táo mèo', 'price' => 220000],
                ['name' => 'Khởi Dương Ba Kích', 'price' => 240000],
                ['name' => 'Vua mơ rừng', 'price' => 220000],
                ['name' => 'Vua chuối hột', 'price' => 220000],
                ['name' => 'Táo mèo Lương Sơn Tra', 'price' => 200000],
                ['name' => 'Táo mèo Đình Làng', 'price' => 200000],
            ],
            // RƯỢU
            'Rượu' => [
                ['name' => 'Rượu quê', 'price' => 50000],
                ['name' => 'Rượu thuốc', 'price' => 50000],
                ['name' => 'Rượu Vodka nội', 'price' => 50000],
                ['name' => 'Rượu Vodka ngoại', 'price' => 70000],
                ['name' => 'Vang nội', 'price' => 50000],
                ['name' => 'Vang ngoại', 'price' => 100000],
                ['name' => 'Rượu dòng Whisky', 'price' => 300000],
            ],
        ];

        // Create menus and menu options
        $allMenus = collect();
        foreach ($menuData as $categoryName => $items) {
            $categoryId = $categoryIds[$categoryName] ?? null;
            if (!$categoryId) continue;

            foreach ($items as $item) {
                // Skip items with price 0 (theo thời giá)
                if ($item['price'] == 0) {
                    // Use average price for "theo thời giá" items
                    $item['price'] = $faker->numberBetween(200000, 500000);
                }

                $menu = Menu::create([
                    'name' => $item['name'],
                    'category_id' => $categoryId,
                    'disable' => $faker->randomElement(['no', 'yes']), // 90% active
                    'thumbnail' => null,
                    'pre_order' => $faker->randomElement([0, 1]), // 0 = no, 1 = yes
                ]);

                // Create menu option with price
                MenuOption::create([
                    'menu_id' => $menu->id,
                    'name' => 'Phần thường',
                    'cost' => (float)$item['price'],
                ]);

                // Some items have multiple sizes/options (only for items < 500k)
                if ($faker->boolean(30) && $item['price'] < 500000) { // 30% chance, only for cheaper items
                    $largePrice = min($item['price'] * 1.5, 999999); // Cap at 999999
                    MenuOption::create([
                        'menu_id' => $menu->id,
                        'name' => 'Phần lớn',
                        'cost' => (float)$largePrice,
                    ]);
                }

                $allMenus->push($menu);
            }
        }

        // 3. CREATE USERS (50-100 customers + some staff)
        $customerRole = Role::where('name', 'customer')->first();
        $staffRole = Role::where('name', 'staff')->first();
        
        if (!$customerRole) {
            $customerRole = Role::create(['name' => 'customer']);
        }
        if (!$staffRole) {
            $staffRole = Role::create(['name' => 'staff']);
        }

        $users = collect();
        
        // Create 80 customers
        for ($i = 0; $i < 80; $i++) {
            $users->push(User::create([
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => $faker->unique()->safeEmail(),
                'password' => bcrypt('password'),
                'role_id' => $customerRole->id,
            ]));
        }

        // Create 10 staff
        for ($i = 0; $i < 10; $i++) {
            $users->push(User::create([
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => $faker->unique()->safeEmail(),
                'password' => bcrypt('password'),
                'role_id' => $staffRole->id,
            ]));
        }

        // 4. CREATE TABLES (20-30 tables)
        $zones = ['Ban công', 'Trong nhà', 'Sân vườn', 'Khu VIP', 'Gần cửa', 'Góc yên tĩnh', 'Khu trung tâm'];
        $tables = collect();
        for ($i = 1; $i <= 25; $i++) {
            $tables->push(Table::create([
                'table_number' => 'T' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'zone' => $faker->randomElement($zones),
                'seats' => $faker->randomElement([2, 4, 6, 8, 10]),
                'status' => $faker->randomElement(['available', 'occupied', 'reserved']),
            ]));
        }

        // 5. CREATE TRANSACTIONS (Orders) - 200-300 transactions
        $transactions = collect();
        $customers = $users->where('role_id', $customerRole->id);
        
        for ($i = 0; $i < 250; $i++) {
            $customer = $customers->random();
            $menu = $allMenus->random();
            $option = MenuOption::where('menu_id', $menu->id)->inRandomOrder()->first();
            $table = $tables->random();
            
            $createdAt = $faker->dateTimeBetween('-3 months', 'now');
            
            $completionStatus = $faker->randomElement(['yes', 'no']);
            $paymentStatus = $completionStatus === 'yes' ? $faker->randomElement(['yes', 'no']) : 'no';
            
            $transactions->push(Transaction::create([
                'user_id' => $customer->id,
                'table_id' => $table->id,
                'menu_id' => $menu->id,
                'menu_option_id' => $option->id,
                'quantity' => $faker->numberBetween(1, 5),
                'remarks' => $faker->optional(0.3)->sentence() ?? '',
                'completion_status' => $completionStatus,
                'payment_status' => $paymentStatus,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]));
        }

        // 6. CREATE TEMPORARY ORDERS (Cart items) - 50-100
        for ($i = 0; $i < 80; $i++) {
            $customer = $customers->random();
            $menu = $allMenus->random();
            $option = MenuOption::where('menu_id', $menu->id)->inRandomOrder()->first();
            
            TemporaryOrder::create([
                'user_id' => $customer->id,
                'menu_id' => $menu->id,
                'menu_option_id' => $option->id,
                'quantity' => $faker->numberBetween(1, 3),
                'remarks' => $faker->optional(0.2)->sentence() ?? '',
            ]);
        }

        // 7. CREATE RESERVATIONS - 30-50
        for ($i = 0; $i < 40; $i++) {
            $customer = $customers->random();
            $table = $tables->random();
            $menu = $allMenus->random();
            $option = MenuOption::where('menu_id', $menu->id)->inRandomOrder()->first();
            
            Reservation::create([
                'user_id' => $customer->id,
                'table_id' => $table->id,
                'menu_id' => $menu->id,
                'menu_option_id' => $option->id,
                'reservation_time' => $faker->dateTimeBetween('+1 days', '+30 days'),
                'status' => $faker->randomElement(['pending', 'confirmed', 'canceled']),
            ]);
        }

        $this->command->info('✅ Seeder hoàn thành!');
        $this->command->info('📊 Thống kê:');
        $this->command->info('   - Categories: ' . count($categories));
        $this->command->info('   - Menu items: ' . $allMenus->count());
        $this->command->info('   - Users: ' . $users->count() . ' (80 customers + 10 staff)');
        $this->command->info('   - Tables: ' . $tables->count());
        $this->command->info('   - Transactions: ' . $transactions->count());
        $this->command->info('   - Temporary Orders: 80');
        $this->command->info('   - Reservations: 40');
    }
}

