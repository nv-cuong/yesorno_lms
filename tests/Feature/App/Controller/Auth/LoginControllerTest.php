<?php

namespace Tests\Feature\App\Controller\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
class LoginControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index()
    {
        $response = $this->get(route('login.form'));

        $response->assertStatus(200);

        $response->assertSee('<h1 class="h3 mb-3 fw-normal">Đăng nhập</h1>',false);
    }

    public function test_postLogin_success()
    {
        $roleData = [
            'email' =>   'student@example.com',
            'password'=> '1234567@',
        ];

        $response = $this->post(route('login.post'), $roleData)
        ->assertStatus(302)
        ->assertSessionHas('<span class="sub-2">Khóa học mới</span>',false);
    }
    /**
     * @dataProvider set_login_data_test_is_invalid
     */

    public function test_postLogin_is_invalid($datInvalid, $fieldsInvalid)
    {
        $response = $this->post(route('login.post'), $datInvalid);

        $response->assertStatus(302);
        $response->assertSessionHasErrors($fieldsInvalid);
    }


    protected function set_login_data_test_is_invalid()
    {
        return [
            [
                [
                    'email' => '',
                    'password'=>''
                ],
                [
                    'email',
                    'password'
                ]
            ],
            [
                [
                    'email' => 'student@example.com',
                    'password'=>''
                ],
                [
                    'password'
                ]
            ],
            [
                [
                    'email' => '',
                    'password'=>'1234567@'
                ],
                [
                    'email',
                ]
            ],
            [
                [
                    'email' => 'student@example.com',
                    'password'=>'1234567'
                ],
                [
                    'email',
                ]
            ],
        ];
    }
}
