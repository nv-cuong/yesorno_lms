<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('courses')->truncate();
        DB::table('units')->truncate();
        DB::table('lessons')->truncate();
        DB::table('files')->truncate();
        DB::table('questions')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('courses')->insert([
            [
                'title' => 'Lập trình HTML CSS',
                'slug' => 'lap-trinh-html-css',
                'description' => '
                <ul>
                    <li>Biết c&aacute;ch x&acirc;y dựng giao diện web với HTML, CSS</li>
                    <li>Biết c&aacute;ch ph&acirc;n t&iacute;ch giao diện website</li>
                    <li>Biết c&aacute;ch đặt t&ecirc;n class CSS theo chuẩn BEM</li>
                    <li>Biết c&aacute;ch l&agrave;m giao diện web responsive</li>
                    <li>L&agrave;m chủ Flexbox khi dựng bố cục website</li>
                    <li>Sở hữu 2 giao diện web khi học xong kh&oacute;a học</li>
                    <li>Học được c&aacute;ch l&agrave;m UI chỉn chu, kỹ t&iacute;nh</li>
                </ul>',
                'status' => fake()->boolean(),
                'begin_date' => fake()->date(),
                'end_date' => fake()->date(),
                'image' => fake()->imageUrl(),
            ],
            [
                'title' => 'Kiến thức nhập môn IT',
                'slug' => 'kien-thuc-nhap-mon-it',
                'description' => '
                    <ul>
                        <li>C&aacute;c kiến thức cơ bản, nền m&oacute;ng của ng&agrave;nh IT</li>
                        <li>C&aacute;c m&ocirc; h&igrave;nh, kiến tr&uacute;c cơ bản khi triển khai ứng dụng</li>
                        <li>C&aacute;c kh&aacute;i niệm, thuật ngữ cốt l&otilde;i khi triển khai ứng dụng</li>
                        <li>Hiểu hơn về c&aacute;ch internet v&agrave; m&aacute;y vi t&iacute;nh hoạt động</li>
                    </ul>',
                'status' => fake()->boolean(),
                'begin_date' => fake()->date(),
                'end_date' => fake()->date(),
                'image' => fake()->imageUrl(),
            ],
            [
                'title' => 'Lập trình JavaScripts',
                'slug' => 'lap-trinh-javascript',
                'description' => '
                    <ul>
                        <li>Hiểu chi tiết về c&aacute;c kh&aacute;i niệm cơ bản trong JS</li>
                        <li>X&acirc;y dựng được website đầu ti&ecirc;n kết hợp với JS</li>
                        <li>Tự tin khi phỏng vấn với kiến thức vững chắc</li>
                        <li>C&oacute; nền tảng để học c&aacute;c thư viện v&agrave; framework JS</li>
                        <li>Nắm chắc c&aacute;c t&iacute;nh năng trong phi&ecirc;n bản ES6</li>
                        <li>Th&agrave;nh thạo DOM APIs để tương t&aacute;c với trang web</li>
                    </ul>',
                'status' => fake()->boolean(),
                'begin_date' => fake()->date(),
                'end_date' => fake()->date(),
                'image' => fake()->imageUrl(),
            ],
            [
                'title' => 'Xây dựng Web với ReactJS',
                'slug' => 'xay-dung-web-voi-reactjs',
                'description' => '
                    <ul>
                        <li>Hiểu về kh&aacute;i niệm SPA/MPA</li>
                        <li>Hiểu về kh&aacute;i niệm hooks</li>
                        <li>Hiểu c&aacute;ch ReactJS hoạt động</li>
                        <li>Hiểu về function/class component</li>
                        <li>Biết c&aacute;ch tối ưu hiệu năng ứng dụng</li>
                        <li>Th&agrave;nh thạo l&agrave;m việc với RESTful API</li>
                        <li>Biết sử dụng redux-thunk middleware</li>
                        <li>Triển khai dự &aacute;n React ra Internet</li>
                        <li>Biết c&aacute;ch Deploy l&ecirc;n Github/Gitlab page</li>
                    </ul>',
                'status' => fake()->boolean(),
                'begin_date' => fake()->date(),
                'end_date' => fake()->date(),
                'image' => fake()->imageUrl(),
            ],
            [
                'title' => 'Lập trình PHP',
                'slug' => 'lap-trinh-php',
                'description' => '
                    <ul>
                        <li>C&oacute; tư duy lập tr&igrave;nh cốt l&otilde;i của một lập tr&igrave;nh vi&ecirc;n Backend</li>
                        <li>Đọc hiểu m&atilde; nguồn c&aacute;c website được x&acirc;y dựng với ng&ocirc;n ngữ&nbsp;PHP</li>
                        <li>Tự x&acirc;y dựng ho&agrave;n chỉnh một PHP Framework ri&ecirc;ng với nhiều module, nhiều template&nbsp;(kết hợp MVC, OOP v&agrave; nhiều kỹ thuật xử l&yacute;&nbsp;mới, &hellip;)</li>
                        <li>X&acirc;y dựng ho&agrave;n chỉnh Website b&aacute;n s&aacute;ch trực tuyến với m&ocirc; h&igrave;nh PHP framework</li>
                        <li>Kiến thức vũng chắc về MVC, OOP, dễ d&agrave;ng học n&acirc;ng cao c&aacute;c Framework: Laravel, Code Igniter, Phalcon, Zend, ..</li>
                    </ul>',
                'status' => fake()->boolean(),
                'begin_date' => fake()->date(),
                'end_date' => fake()->date(),
                'image' => fake()->imageUrl(),
            ],
        ]);

        DB::table('units')->insert([
            [
                'course_id' => '1',
                'title' => 'Làm quen với HTML',
                'slug' => 'lam-quen-voi-html',
            ],
            [
                'course_id' => '1',
                'title' => 'Làm quen với CSS',
                'slug' => 'lam-quen-voi-css',
            ],
            [
                'course_id' => '1',
                'title' => 'Một số tricks và tips',
                'slug' => 'mot-so-tricks-va-tips',
            ],
            [
                'course_id' => '1',
                'title' => 'Dựng bố cục web với Flexbox',
                'slug' => 'dung-bo-cuc-web-voi-flexbox',
            ],
            [
                'course_id' => '2',
                'title' => 'Khái niệm kỹ thuật cần biết',
                'slug' => 'khai-niem-ky-thuat-can-biet',
            ],
            [
                'course_id' => '2',
                'title' => 'Môi trường, con người IT',
                'slug' => 'moi-truong-con-nguoi-it',
            ],
            [
                'course_id' => '2',
                'title' => 'Phương pháp, định hướng',
                'slug' => 'phương-phap-dinh-hương',
            ],
            [
                'course_id' => '3',
                'title' => 'Giới thiệu',
                'slug' => 'gioi-thieu',
            ],
            [
                'course_id' => '3',
                'title' => 'Toán tử, kiểu dữ liệu',
                'slug' => 'toan-tu-kieu-du-lieu',
            ],
            [
                'course_id' => '3',
                'title' => 'Hàm, chuỗi, số',
                'slug' => 'ham-chuoi-so',
            ],
            [
                'course_id' => '3',
                'title' => 'Vòng lặp',
                'slug' => 'vong-lap',
            ],
            [
                'course_id' => '3',
                'title' => 'HTML DOM',
                'slug' => 'html-dom',
            ],
            [
                'course_id' => '3',
                'title' => 'Làm việc với form',
                'slug' => 'lam-viec-voi-form',
            ],
        ]);

        DB::table('lessons')->insert([
            [
                'unit_id' => '1',
                'title' => 'Cấu trúc của một file HTML',
                'slug' => 'cau-truc-cua-mot-file-html',
                'content' => fake()->text(200),
                'published' => fake()->date(),
            ],
            [
                'unit_id' => '1',
                'title' => 'Comments trong HTML',
                'slug' => 'comments-trong-html',
                'content' => fake()->text(200),
                'published' => fake()->date(),
            ],
            [
                'unit_id' => '1',
                'title' => 'Các thẻ HTML thông dụng',
                'slug' => 'cac-the-html-thong-dung',
                'content' => fake()->text(200),
                'published' => fake()->date(),
            ],
            [
                'unit_id' => '1',
                'title' => 'Attribute trong HTML',
                'slug' => 'attribute-trong-html',
                'content' => fake()->text(200),
                'published' => fake()->date(),
            ],
            [
                'unit_id' => '2',
                'title' => 'Sử dụng CSS trong HTML',
                'slug' => 'su-dung-css-trong-html',
                'content' => fake()->text(200),
                'published' => fake()->date(),
            ],
            [
                'unit_id' => '2',
                'title' => 'ID và Class',
                'slug' => 'id-va-class',
                'content' => fake()->text(200),
                'published' => fake()->date(),
            ],
            [
                'unit_id' => '2',
                'title' => 'CSS selectors cơ bản',
                'slug' => 'css-selectors-co-ban',
                'content' => fake()->text(200),
                'published' => fake()->date(),
            ],
            [
                'unit_id' => '2',
                'title' => 'Sử dụng biến trong CSS',
                'slug' => 'su-dung-bien-trong-css',
                'content' => fake()->text(200),
                'published' => fake()->date(),
            ],
            [
                'unit_id' => '2',
                'title' => 'Các đơn vị trong CSS',
                'slug' => 'cac-don-vi-trong-css',
                'content' => fake()->text(200),
                'published' => fake()->date(),
            ],
            [
                'unit_id' => '3',
                'title' => 'Các cách căn giữa trong CSS',
                'slug' => 'cac-cach-can-giua-trong-css',
                'content' => fake()->text(200),
                'published' => fake()->date(),
            ],
            [
                'unit_id' => '3',
                'title' => 'Hiển thị ảnh dự phòng khi ảnh chính lỗi',
                'slug' => 'hien-thi-anh-du-phong-khi-anh-chinh-loi',
                'content' => fake()->text(200),
                'published' => fake()->date(),
            ],
            [
                'unit_id' => '4',
                'title' => 'Giới thiệu Flexbox',
                'slug' => 'gioi-thieu-flexbox',
                'content' => fake()->text(200),
                'published' => fake()->date(),
            ],
            [
                'unit_id' => '4',
                'title' => 'Ôn tập Flexbox',
                'slug' => 'ong-tap-flexbox',
                'content' => fake()->text(200),
                'published' => fake()->date(),
            ],
            [
                'unit_id' => '4',
                'title' => 'Thuộc tính CSS trong Flexbox',
                'slug' => 'thuoc-tinh-css-trong-flexbox',
                'content' => fake()->text(200),
                'published' => fake()->date(),
            ],
            [
                'unit_id' => '4',
                'title' => 'Học Flexbox qua ví dụ',
                'slug' => 'hoc-flexbox-qua-vi-du',
                'content' => fake()->text(200),
                'published' => fake()->date(),
            ],
        ]);

        DB::table('files')->insert([
            [
                'lesson_id' => '1',
                'type' => 'link',
                'path' => 'https://www.youtube.com/watch?v=LYnrFSGLCl8&list=PL_-VfJajZj0U9nEXa4qyfB4U5ZIYCMPlz&index=5',
            ],
            [
                'lesson_id' => '2',
                'type' => 'link',
                'path' => 'https://www.youtube.com/watch?v=JG0pdfdKjgQ&list=PL_-VfJajZj0U9nEXa4qyfB4U5ZIYCMPlz&index=6',
            ],
            [
                'lesson_id' => '3',
                'type' => 'link',
                'path' => 'https://www.youtube.com/watch?v=AzmdwZ6e_aM&list=PL_-VfJajZj0U9nEXa4qyfB4U5ZIYCMPlz&index=7',
            ],
            [
                'lesson_id' => '4',
                'type' => 'link',
                'path' => 'https://www.youtube.com/watch?v=UYpIh5pIkSA&list=PL_-VfJajZj0U9nEXa4qyfB4U5ZIYCMPlz&index=8',
            ],
            [
                'lesson_id' => '5',
                'type' => 'link',
                'path' => 'https://www.youtube.com/watch?v=NsSsJTg29oE&list=PL_-VfJajZj0U9nEXa4qyfB4U5ZIYCMPlz&index=9',
            ],
            [
                'lesson_id' => '6',
                'type' => 'link',
                'path' => 'https://www.youtube.com/watch?v=4J6d8cr0X48&list=PL_-VfJajZj0U9nEXa4qyfB4U5ZIYCMPlz&index=10',
            ],
            [
                'lesson_id' => '7',
                'type' => 'link',
                'path' => 'https://www.youtube.com/watch?v=AgZ0PX28bnA&list=PL_-VfJajZj0U9nEXa4qyfB4U5ZIYCMPlz&index=11',
            ],
            [
                'lesson_id' => '8',
                'type' => 'link',
                'path' => 'https://www.youtube.com/watch?v=x9fnxVTkpP4&list=PL_-VfJajZj0U9nEXa4qyfB4U5ZIYCMPlz&index=12',
            ],
            [
                'lesson_id' => '9',
                'type' => 'link',
                'path' => 'https://www.youtube.com/watch?v=pcUiTt6eBk0&list=PL_-VfJajZj0U9nEXa4qyfB4U5ZIYCMPlz&index=13',
            ],
            [
                'lesson_id' => '10',
                'type' => 'link',
                'path' => 'https://www.youtube.com/watch?v=bv16wjxgV4U&list=PL_-VfJajZj0U9nEXa4qyfB4U5ZIYCMPlz&index=17',
            ],
            [
                'lesson_id' => '11',
                'type' => 'link',
                'path' => 'https://www.youtube.com/watch?v=4hf8kMSRUJI&list=PL_-VfJajZj0U9nEXa4qyfB4U5ZIYCMPlz&index=23',
            ],
            [
                'lesson_id' => '12',
                'type' => 'link',
                'path' => 'https://www.youtube.com/watch?v=bVUN6nS82k8&list=PL_-VfJajZj0U9nEXa4qyfB4U5ZIYCMPlz&index=31',
            ],
            [
                'lesson_id' => '13',
                'type' => 'link',
                'path' => 'https://www.youtube.com/watch?v=bVUN6nS82k8&list=PL_-VfJajZj0U9nEXa4qyfB4U5ZIYCMPlz&index=31',
            ],
            [
                'lesson_id' => '14',
                'type' => 'link',
                'path' => 'https://www.youtube.com/watch?v=jX9KFgugpl4&list=PL_-VfJajZj0U9nEXa4qyfB4U5ZIYCMPlz&index=32',
            ],
            [
                'lesson_id' => '15',
                'type' => 'link',
                'path' => 'https://www.youtube.com/watch?v=G19jZzK5FWI&list=PL_-VfJajZj0U9nEXa4qyfB4U5ZIYCMPlz&index=33',
            ],
        ]);
        
        Course::factory()
        ->count(10)
        ->hasQuestions(10)
        ->has(
            Unit::factory()
            ->count(2)
            ->has(
                Lesson::factory()
                ->count(3)
            )
        )
        ->create();
    }
}
