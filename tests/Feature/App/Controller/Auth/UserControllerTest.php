<?php

namespace Tests\Feature\App\Controller\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Artisan;

class UserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    private $user;

    /**
     *
     */
    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed', ['--class' => 'UserSeeder']);
        $this->user = Sentinel::findUserById(1);
        Sentinel::login($this->user, true);
    }
    
  
    public function test_index()
    {
        $response = $this->get(route('users.index'));

        $response->assertStatus(200);

        $response->assertSee('<h3 class="box-title">Quản lý user</h3>', false);
    }

    public function test_create()
    {
        $response = $this->get(route('users.create'));

        $response->assertStatus(200);

        $response->assertSee('<h3 class="card-title">Thêm mới user</h3>', false);
    }

    /**
     * @dataProvider set_user_data_test_is_invalid
     */

    public function test_store_is_invalid($datInvalid, $fieldsInvalid)
    {
        $response = $this->post(route('users.store'), $datInvalid);

        $response->assertStatus(302);
        $response->assertSessionHasErrors($fieldsInvalid);
    }
    public function test_store_success()
    {
        $userData = [
            'first_name' =>    'tes',
            'email' =>       'thin@gmail.com',
            'password' =>    'Thinat01@#',
            'phone' =>          '0906216933',
            'last_name' =>    'thin',
            'role' =>    '1',
            'password_confirmation' => 'Thinat01@#',
        ];

        $response = $this->post(route('users.store'), $userData);

        $response->assertStatus(302);

        $this->assertDatabaseHas('users', [

            'first_name' =>    'tes',
           


        ]);
    }

    public function test_edit()
    {
        $response = $this->get(route('users.edit', [
            'user' => 1,
        ]));

        $response->assertStatus(200);

        $response->assertSee('<h3 class="card-title">Sửa user</h3>', false);
    }

    public function test_update_success()
    {
        $userData = [

            'first_name' =>    'test',
            'email' =>       'thin2000@gmail.com',
            'last_name' =>    'thin',
            'phone' =>          '0906216933',
            'role' =>    '3',

        ];

        $response = $this->put(route('users.update', [
            'user' => 2,
        ]), $userData);

        $response->assertStatus(302);


        $this->assertDatabaseHas('users', [

            'first_name' =>    'test',

        ]);
    }

    /**
     * @dataProvider set_users_data_test_is_invalid
     */
    public function test_update_is_invalid($datInvalid, $fieldsInvalid)
    {
        $response = $this->put(route('users.update', [
            'user' => 4,
        ]), $datInvalid);

        $response->assertStatus(302);
        $response->assertSessionHasErrors($fieldsInvalid);
    }


    protected function set_user_data_test_is_invalid()
    {
        return [
            [
                [
                    'first_name' =>    'test',
                    'email' =>       '',
                    'phone' =>          '',
                    'password' =>    '',
                    'last_name' =>    '',
                    'role' =>    '',

                ],
                [
                    'email',
                    'phone',
                    'password',
                    'last_name',
                    'role',

                ]
            ],

            [
                [
                    'first_name' =>    '',
                    'email' =>       'thintest@gmail.com',
                    'password' =>    '',
                    'phone' =>          '',
                    'last_name' =>    '',
                    'role' =>    '',

                ],
                [
                    'first_name',
                    'password',
                    'phone',
                    'last_name',
                    'role',

                ]
            ],

            [
                [
                    'first_name' =>    '',
                    'email' =>       '',
                    'password' =>    'Thinat01@#',
                    'phone' =>          '',
                    'last_name' =>    '',
                    'role' =>    '',

                ],
                [
                    'first_name',
                    'email',
                    'phone',
                    'last_name',
                    'role',

                ]
            ],
            [
                [
                    'first_name' =>    '',
                    'email' =>       '',
                    'password' =>    '',
                    'phone' =>         '0906216933',
                    'last_name' =>    '',
                    'role' =>    '',

                ],
                [
                    'first_name',
                    'email',
                    'password',
                    'last_name',
                    'role',

                ]
            ],
            [
                [
                    'first_name' =>    '',
                    'email' =>       '',
                    'password' =>    '',
                    'phone' =>          '',
                    'last_name' =>    'thin',
                    'role' =>    '',

                ],
                [
                    'first_name',
                    'email',
                    'password',
                    'phone',
                    'role',


                ]
            ],
            [
                [
                    'first_name' =>    '',
                    'email' =>       '',
                    'password' =>    '',
                    'phone' =>          '',
                    'last_name' =>    '',
                    'role' =>    '1',

                ],
                [
                    'first_name',
                    'email',
                    'password',
                    'phone',
                    'last_name',

                ]
            ],


        ];
    }
    protected function set_users_data_test_is_invalid()
    {
        return [

            [
                [
                    'first_name' =>    'test',
                    'email' =>       '',
                    'phone' =>          '',
                    'last_name' =>    '',
                    'role' =>    '',

                ],
                [
                    'email',
                    'phone',
                    'last_name',
                    'role',

                ]
            ],


            [
                [
                    'first_name' =>    '',
                    'email' =>       'thintest@gmail.com',
                    'phone' =>          '',
                    'last_name' =>    '',
                    'role' =>    '',

                ],
                [
                    'first_name',
                    'phone',
                    'last_name',
                    'role',

                ]
            ],


            [
                [
                    'first_name' =>    '',
                    'email' =>       '',
                    'phone' =>         '0906216933',
                    'last_name' =>    '',
                    'role' =>    '',

                ],
                [
                    'first_name',
                    'email',
                    'last_name',
                    'role',

                ]
            ],
            [
                [
                    'first_name' =>    '',
                    'email' =>       '',
                    'phone' =>          '',
                    'last_name' =>    'thin',
                    'role' =>    '',

                ],
                [
                    'first_name',
                    'email',
                    'phone',
                    'role',


                ]
            ],
            [
                [
                    'first_name' =>    '',
                    'email' =>       '',
                    'phone' =>          '',
                    'last_name' =>    '',
                    'role' =>    '1',

                ],
                [
                    'first_name',
                    'email',
                    'phone',
                    'last_name',
                ]
            ],


        ];
    }

    public function test_delete()
    {
        $response = $this->delete(route('users.destroy'), [
            'user_id' => 4,
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseMissing('users', [
            'id' =>  4,
        ]);
    }
}
