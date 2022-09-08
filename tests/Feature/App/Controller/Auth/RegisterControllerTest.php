<?php

namespace Tests\Feature\App\Controller\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index()
    {
        $response = $this->get(route('register.form'));

        $response->assertStatus(200);

        $response->assertSee('<p class="login-box-msg">Đăng ký thành viên mới </p>',false);
    }

    public function test_postRegister_success()
    {
        $roleData = [
            'first_name'=> 'Nguyen',
            'last_name'=> 'Hieu',
            'email' =>   'hn5308434@gmail.com',
            'password'=> '1234567@',
            'password_confirm'=> '1234567@',
        ];

        $response = $this->post(route('register.action'), $roleData)
        ->assertStatus(302)
        ->assertSessionHas('<h1 class="h3 mb-3 fw-normal">Đăng nhập</h1>',false);
    }
    /**
     * @dataProvider set_login_data_test_is_invalid
     */

    public function test_postRegister_is_invalid($datInvalid, $fieldsInvalid)
    {
        $response = $this->post(route('register.action'), $datInvalid);

        $response->assertStatus(302);
        $response->assertSessionHasErrors($fieldsInvalid);
    }


    protected function set_login_data_test_is_invalid()
    {
        return [
            [
                [
                    'first_name'=>'',
                    'last_name'=>'',
                    'email' => '',
                    'password'=>'',
                ],
                [
                    'first_name',
                    'last_name',
                    'email',
                    'password',
                ]
            ],
            [
                [
                    'first_name'=>'',
                    'last_name'=>'',
                    'email' => 'hn5308434@gmail.com',
                    'password'=>'',
                ],
                [
                    'first_name',
                    'last_name',
                    'password',
                ]
            ],
            [
                [
                    'first_name'=>'nguyen',
                    'last_name'=>'',
                    'email' => '',
                    'password'=>'',
                ],
                [
                    'last_name',
                    'email',
                    'password',
                ]
            ],
            [
                [
                    'first_name'=>'',
                    'last_name'=>'hieu',
                    'email' => '',
                    'password'=>'',
                ],
                [
                    'first_name',
                    'email',
                    'password',
                ]
            ],
        ];
    }
}
