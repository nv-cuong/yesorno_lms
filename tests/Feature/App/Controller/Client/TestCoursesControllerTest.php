<?php

namespace Tests\Feature\App\Controller\Client;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
class TestCoursesControllerTest extends TestCase
{
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed', ['--class'=>'DatabaseSeeder']);
        $this->user = Sentinel::findUserById(4);
        Sentinel::login($this->user, true);
    }

    public function test_index_make_test(){
        
        $response = $this->get(route('index_make',4));

        $response->assertStatus(200);

        $response->assertSee('<h2> BÀi TEST CUỐI KHÓA </h2>', false);
    }
    public function test_save_maked(){
        $testData = [
            'q1'=>'abcdefgh',
        ];

        $response = $this->get(route('save_maked',[4,4]), $testData);
        $response->assertStatus(302);

        $this->assertDatabaseHas('user_test_answers', [
            'answer' =>   NULL,
        ]);
    }
}
