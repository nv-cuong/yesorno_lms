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
        $this->user = Sentinel::findUserById(1);
        Sentinel::login($this->user, true);
    }
    public function test_doTest()
    {
        $response = $this->get(route('doTest', [
            'id' => 2,
        ]));

        $response->assertStatus(200);

        $response->assertSee('<h1>Quản lý Câu hỏi</h1>', false);
    }
    
}
