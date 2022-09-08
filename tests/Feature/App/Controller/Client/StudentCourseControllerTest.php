<?php

namespace Tests\Feature\App\Controller\Client;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Artisan;
class StudentCourseControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed', ['--class'=>'DatabaseSeeder']);
        $this->user = Sentinel::findUserById(4);
        Sentinel::login($this->user, true);
    }

    public function test_personalCourse()
    {
        $response = $this->get(route('personal.course',[
            'slug'=> 'lap-trinh-html-css',
        ]));
        $response->assertStatus(200);

        $response->assertSee('<h2 class="breadcrumb-title">Chi tiết khóa học</h2>', false);
    }

    public function test_personalLesson()
    {
        $response = $this->get(route('personal.lesson',[
            'slug'=> 'cau-truc-cua-mot-file-html',
        ]));
        $response->assertStatus(200);

        $response->assertSee('<h2 class="breadcrumb-title">Danh sách khóa học</h2>', false);
    }

    public function test_lessonProgress()
    {
        $response = $this->post(route('lessonProgress',[
            'slug'=> 'cau-truc-cua-mot-file-html',
        ]));
        
        $response->assertStatus(200);
        $this->assertDatabaseHas('user_lessons', [
            'lesson_id' =>   1,
            'status' =>    1,
        ]);
    }
}
