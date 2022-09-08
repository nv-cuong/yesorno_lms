<?php

namespace Tests\Feature\App\Controller\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class IndexControllerTest extends TestCase
{
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
        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);

        $response->assertSee('<h1 class="m-0">Dashboard</h1>', false);
    }
}
