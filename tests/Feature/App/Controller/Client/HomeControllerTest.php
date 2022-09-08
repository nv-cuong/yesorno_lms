<?php

namespace Tests\Feature\App\Controller\Client;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Artisan;

class HomeControllerTest extends TestCase
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
        Artisan::call('db:seed', ['--class' => 'DatabaseSeeder']);
        $this->user = Sentinel::findUserById(4);
        Sentinel::login($this->user, true);
    }
    public function test_index()
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);

        $response->assertSee('<span class="sub-2">Khóa học mới</span>', false); 
    }
    
    public function test_courses()
    {
        $response = $this->get(route('courses'));

        $response->assertStatus(200);

        $response->assertSee('<h2>Các khóa học tuyệt vời của chúng tôi</h2>', false); 
    }

    public function test_personal()
    {
        $response = $this->get(route('personal'));

        $response->assertStatus(200);

        $response->assertSee('<span class="sub-2">Find Perfect one</span>', false); 
    }

    public function test_contact()
    {
        $response = $this->get(route('contact'));

        $response->assertStatus(200);

        $response->assertSee('<span class="sub-2">Có gì mới</span>', false); 
    }
}
