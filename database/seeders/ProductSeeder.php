<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create( [
            'id'=>5,
            'name'=>'Nước giặt Ariel Matic cửa trước tươi mát rực rỡ 1.8 lít',
            'slug'=>'nuoc-giat-ariel-matic-cua-truoc-tuoi-mat-ruc-ro-18-lit',
            'category_id'=>1,
            'description'=>'Với công thức tiên tiến hàng đầu, nước giặt Ariel đánh bay vết bẩn cứng đầu cực nhanh, xài cực bền cho máy giặt của bạn nên là loại nước giặt được các chị em nội trợ ưa chuộng hàng đầu. Nước giặt Ariel Matic cửa trước tươi mát rực rỡ 1.8 lít dành cho cửa trước, hương thơm tươi mát dễ chịu',
            'price'=>97000,
            'quantity'=>'4',
            'image'=>'upload/xhPSR9UyQjgmwWaP2IG5Occlr74FzUoJYCv8doa6.jpg',
            'created_at'=>'2022-03-25 23:38:13',
            'updated_at'=>'2022-03-27 02:15:52'
        ] );

        Product::create( [
            'id'=>6,
            'name'=>'Nước giặt Ariel Matic cửa trước bung toả đam mê túi 2 lít',
            'slug'=>'nuoc-giat-ariel-matic-cua-truoc-bung-toa-dam-me-tui-2-lit',
            'category_id'=>1,
            'description'=>'Với công thức tiên tiến hàng đầu, nước giặt Ariel đánh bay vết bẩn cứng đầu cực nhanh, xài cực bền cho máy giặt của bạn nên là loại nước giặt được các chị em nội trợ ưa chuộng hàng đầu. Nước giặt Ariel Matic cửa trước bung toả đam mê túi 2 lít giặt sạch nhanh, hương thơm dễ chịu',
            'price'=>50000,
            'quantity'=>'24',
            'image'=>'upload/pSkGOVjcxvMx02YhBK3glrL8Wb3lFYQTnjm8KHoG.jpg',
            'created_at'=>'2022-03-26 18:43:49',
            'updated_at'=>'2022-03-26 18:43:49'
        ] );

        Product::create( [
            'id'=>7,
            'name'=>'Bột giặt Tide trắng đột phá 2.7kg',
            'slug'=>'bot-giat-tide-trang-dot-pha-27kg',
            'category_id'=>1,
            'description'=>'Với công thức cải tiến giúp đánh bật mọi vết bẩn cứng đầu, giúp quần áo sạch tinh tươm cả quần áo trắng và màu. Bột giặt Tide là bột giặt được sản xuất theo công nghệ tiên tiến của Mỹ nên an toàn và dịu nhẹ với da tay. Bột giặt Tide trắng đột phá 2.7kg giúp quần áo trắng sạch như mới',
            'price'=>77000,
            'quantity'=>'24',
            'image'=>'upload/uqfcWGkee0Tz5deSrinop2ry99C3tx9G6YuBE3Bh.jpg',
            'created_at'=>'2022-03-26 18:45:44',
            'updated_at'=>'2022-03-26 18:45:44'
        ] );

        Product::create( [
            'id'=>8,
            'name'=>'Bột giặt Ariel hương nắng mai 360g',
            'slug'=>'bot-giat-ariel-huong-nang-mai-360g',
            'category_id'=>1,
            'description'=>'Là dòng bột giặt giúp loại bỏ các vết bẩn cứng đầu chỉ trong 1 bước ngay cả những vết bẩn khó giặt như dầu xe, vết dính trái cây, vết bẩn ở cổ áo, cổ tay áo... Bột giặt Ariel bổ sung thêm hương nắng mai cho quần áo luôn thơm mát. Ariel hương nắng mai 360g bột giặt tin dùng của mọi nhà',
            'price'=>16000,
            'quantity'=>'2',
            'image'=>'upload/xJitmL1kJ9nOVkuWdMzbwhEot7DRr0djAOljLmLx.jpg',
            'created_at'=>'2022-03-26 19:38:54',
            'updated_at'=>'2022-03-26 19:38:54'
        ] );

        Product::create( [
            'id'=>9,
            'name'=>'Bột giặt Ariel hương nắng mai 360g',
            'slug'=>'bot-giat-ariel-huong-nang-mai-360g',
            'category_id'=>1,
            'description'=>'Là dòng bột giặt giúp loại bỏ các vết bẩn cứng đầu chỉ trong 1 bước ngay cả những vết bẩn khó giặt như dầu xe, vết dính trái cây, vết bẩn ở cổ áo, cổ tay áo... Bột giặt Ariel bổ sung thêm hương nắng mai cho quần áo luôn thơm mát. Ariel hương nắng mai 360g bột giặt tin dùng của mọi nhà',
            'price'=>160000,
            'quantity'=>'24',
            'image'=>'upload/AP3z2YbBJ9linx4Z7qWcIU1ItuoheEma7aUDx6iC.jpg',
            'created_at'=>'2022-03-26 19:39:21',
            'updated_at'=>'2022-03-28 18:41:00'
        ] );

        Product::create( [
            'id'=>10,
            'name'=>'Bột giặt Ariel hương nắng mai 360g',
            'slug'=>'bot-giat-ariel-huong-nang-mai-360g',
            'category_id'=>1,
            'description'=>'Là dòng bột giặt giúp loại bỏ các vết bẩn cứng đầu chỉ trong 1 bước ngay cả những vết bẩn khó giặt như dầu xe, vết dính trái cây, vết bẩn ở cổ áo, cổ tay áo... Bột giặt Ariel bổ sung thêm hương nắng mai cho quần áo luôn thơm mát. Ariel hương nắng mai 360g bột giặt tin dùng của mọi nhà',
            'price'=>16000,
            'quantity'=>'2',
            'image'=>'upload/UKheUiHb9yeQxA0H53SWQuvU6fCH722JuI1tbHeF.jpg',
            'created_at'=>'2022-03-26 19:39:22',
            'updated_at'=>'2022-03-26 19:39:22'
        ] );

        Product::create( [
            'id'=>11,
            'name'=>'Bột giặt Ariel hương nắng mai 360g',
            'slug'=>'bot-giat-ariel-huong-nang-mai-360g',
            'category_id'=>1,
            'description'=>'Là dòng bột giặt giúp loại bỏ các vết bẩn cứng đầu chỉ trong 1 bước ngay cả những vết bẩn khó giặt như dầu xe, vết dính trái cây, vết bẩn ở cổ áo, cổ tay áo... Bột giặt Ariel bổ sung thêm hương nắng mai cho quần áo luôn thơm mát. Ariel hương nắng mai 360g bột giặt tin dùng của mọi nhà',
            'price'=>16000,
            'quantity'=>'2',
            'image'=>'upload/trd6GHTo2xvIMyWjnr3wP1bE5YONOEYdWDwoxca6.jpg',
            'created_at'=>'2022-03-26 19:39:22',
            'updated_at'=>'2022-03-26 19:39:22'
        ] );

        Product::create( [
            'id'=>12,
            'name'=>'Nước giặt Surf sương mai dịu mát trắng sạch ngát hương can 3.6 lít',
            'slug'=>'nuoc-giat-surf-suong-mai-diu-mat-trang-sach-ngat-huong-can-36-lit',
            'category_id'=>1,
            'description'=>'Surf là sản phẩm nước giặt thương hiệu đến từ Hà Lan và Anh, nước giặt Surf giúp sạch nhanh hiệu quả, đưa hương thơm lan toả dù ngày nắng hay mưa, giúp bạn tự tin với quần áo luôn thơm tho, sạch sẽ. Nước giặt Surf hương sương mai dịu mát 3.6 lít hương hoa dịu nhẹ, thơm lâu cả ngày',
            'price'=>107000,
            'quantity'=>'2',
            'image'=>'upload/Cac1DKcn6qgtuzYEvxUWDnmbIrfrkiPqn9KD2zet.jpg',
            'created_at'=>'2022-03-26 19:41:30',
            'updated_at'=>'2022-03-26 19:41:30'
        ] );

        Product::create( [
            'id'=>13,
            'name'=>'Bột giặt Attack hương hạnh phúc ngọt ngào 3.8kg',
            'slug'=>'bot-giat-attack-huong-hanh-phuc-ngot-ngao-38kg',
            'category_id'=>1,
            'description'=>'Là bột giặt giúp loại sạch các vết bẩn cứng đầu như vết dầu mỡ, vết mực, vết dầu xe, vết bẩn trên cổ áo, tay áo, vết bẩn từ thức ăn, đồ uống... Bột giặt Attack với công nghệ chuyên biệt từ Nhật Bản khử mùi, hương hạnh phúc ngọt ngào. Bột giặt Attack hương hạnh phúc ngọt ngào 3.8kg cho ngày dài thơm ...',
            'price'=>168000,
            'quantity'=>'5',
            'image'=>'upload/OAi4WPkPTkS37pqcZL7FkTpHoQR8dAyRRHLAnkwf.jpg',
            'created_at'=>'2022-03-27 06:40:27',
            'updated_at'=>'2022-03-27 06:40:27'
        ] );

        Product::create( [
            'id'=>14,
            'name'=>'Nước giặt Surf hương nước hoa túi 3 lít',
            'slug'=>'nuoc-giat-surf-huong-nuoc-hoa-tui-3-lit',
            'category_id'=>1,
            'description'=>'Surf là sản phẩm nước giặt thương hiệu đến từ Hà Lan và Anh, nước giặt Surf giúp sạch nhanh hiệu quả, đưa hương thơm lan toả dù ngày nắng hay mưa, giúp bạn tự tin với quần áo luôn thơm tho, sạch sẽ. Nước giặt Surf hương nước hoa túi 3 lít với hương cỏ hoa thơm mát dễ chịu',
            'price'=>105000,
            'quantity'=>'60',
            'image'=>'upload/njbHIczTyFBLsIbCSo6ci8EC4lvzfh3K86pECCSk.jpg',
            'created_at'=>'2022-03-27 06:46:31',
            'updated_at'=>'2022-03-27 06:46:31'
        ] );

        Product::create( [
            'id'=>15,
            'name'=>'Bột giặt OMO công nghệ giặt xanh giúp xoáy bay vết bẩn loại bỏ mùi hôi 4.5kg',
            'slug'=>'bot-giat-omo-cong-nghe-giat-xanh-giup-xoay-bay-vet-ban-loai-bo-mui-hoi-45kg',
            'category_id'=>1,
            'description'=>'xoáy bay các vết bẩn cứng đầu sau 1 lần giặt cho quần áo trắng sạch tinh tươm, hương thơm tươi mới từ hạt lưu hương. Bột giặt OMO là thương hiệu bột giặt luôn được các chị em tin dùng hàng đầu vì an toàn cho da. Bột giặt OMO hệ bọt thông minh 4.5kg túi 4.5kg tiết kiệm, tiện dùng',
            'price'=>152000,
            'quantity'=>'20',
            'image'=>'upload/ndfNIFy9VwiWhljkwWx3klimx63N10sbGULieOQ6.jpg',
            'created_at'=>'2022-03-31 00:52:37',
            'updated_at'=>'2022-03-31 00:52:37'
        ] );

        Product::create( [
            'id'=>16,
            'name'=>'Nước giặt Ariel Matic hương Downy chai 2.3 lít',
            'slug'=>'nuoc-giat-ariel-matic-huong-downy-chai-23-lit',
            'category_id'=>1,
            'description'=>'Với công thức tiên tiến hàng đầu, nước giặt Ariel đánh bay vết bẩn cứng đầu cực nhanh, xài cực bền cho máy giặt của bạn nên là loại nước giặt được các chị em nội trợ ưa chuộng hàng đầu. Nước giặt Ariel Matic hương Downy 2.3 lít sạch vết bẩn, quần áo ngát hương Downy',
            'price'=>110000,
            'quantity'=>'50',
            'image'=>'upload/EACoZ4D49ioEj1REnhovn8POUTUdwNIpc3YrK7c7.jpg',
            'created_at'=>'2022-03-31 00:59:32',
            'updated_at'=>'2022-03-31 00:59:32'
        ] );

        Product::create( [
            'id'=>17,
            'name'=>'Nước giặt xả MaxKleen hương hoa nắng túi 3.8kg',
            'slug'=>'nuoc-giat-xa-maxkleen-huong-hoa-nang-tui-38kg',
            'category_id'=>2,
            'description'=>'Với công thức Ultra Kép kết hợp giặt xả trong một nắp nước giặt, nước giặt MaxKleen giúp bạn giặt đồ nhanh chóng, dễ dàng hơn, quần áo cũng thơm ngát dễ chịu cả ngày dài. Nước giặt xả MaxKleen hương hoa nắng túi 3.8kg hương thơm dễ chịu, nhẹ nhàng cho quần áo cả nhà',
            'price'=>165000,
            'quantity'=>'55',
            'image'=>'upload/ACPns8L4KBAbQbibZapw83PygL5QpmQrSzqRFa4o.jpg',
            'created_at'=>'2022-03-31 01:03:28',
            'updated_at'=>'2022-03-31 01:03:28'
        ] );

        Product::create( [
            'id'=>18,
            'name'=>'Nước xả vải IZI HOME hương sớm mai chai 1.8 lít',
            'slug'=>'nuoc-xa-vai-izi-home-huong-som-mai-chai-18-lit',
            'category_id'=>2,
            'description'=>'Nước xả quần áo IZI HOME được sản xuất tại Thái Lan, giúp làm mềm sợi vải, ngát hương thơm dễ chịu cả ngày dài, giúp cho bạn tự tin thoải mái giao tiếp với hương thơm cuốn hút. Nước xả vải IZI HOME hương sớm mai chai 1.8 lít hương thơm sớm mai dễ chịu',
            'price'=>79000,
            'quantity'=>'15',
            'image'=>'upload/GVQ1gyv5L3X9g1KctK7s7ZJRCopj4MnrgyOzihuJ.jpg',
            'created_at'=>'2022-03-31 01:05:38',
            'updated_at'=>'2022-03-31 01:05:38'
        ] );
    }
}
