<?php

namespace Tests\Feature\Feature\App\Controller\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Artisan;

class ScoreControllerTest extends TestCase
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

    public function test_index()
    {
        $response = $this->get(route('score.index'));

        $response->assertStatus(200);

        $response->assertSee('<h1>Quản lý điểm bài test</h1>', false);
    }

    public function test_create()
    {
        $response = $this->get(route('score.create'));

        $response->assertStatus(200);

        $response->assertSee('<h3 class="card-title">Thêm mới test đầu vào</h3>', false);
    }

    public function test_store_success()
    {
        $scoreData = [
            'user_id' =>          '2',
            'test_id' =>       '4',
            
        ];

        $response = $this->post(route('score.store'), $scoreData);

        $response->assertStatus(302);
        $this->assertDatabaseHas('user_tests', [
            'user_id' =>        '2',
            'test_id' =>       '4',
        ]);

    }

    public function test_dots()
    {
        $response = $this->get(route('score.dots', [
            'id' => 2,
        ]));

        $response->assertStatus(200);
        $response->assertSee('<h1>Quản lý điểm bài test</h1>', false);
    }

    public function test_point_success()
    {
        $scoreData = [
           'user_test_id' =>         '2',
           'score' =>         '2'
        ];

        $response = $this->post(route('score.point'), $scoreData);

        $response->assertStatus(302);
        

        $this->assertDatabaseHas('user_tests', [
            'status' =>         '1',
        ]);
    }
}
