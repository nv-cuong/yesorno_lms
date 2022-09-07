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

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed', ['--class' => 'DatabaseSeeder']);
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
            'first_name' =>    'doan',
            'email' =>       'thintest@gmail.com',
            'password' =>    't12345678@',
            'phone' =>          '0906216933',
            'last_name' =>    'thin',
        ];

        $response = $this->post(route('users.store'), $userData);

        $response->assertStatus(302);
        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', [
            'first_name' =>    'doan',
            'email' =>       'thintest@gmail.com',
            'password' =>    't12345678@',
            'phone' =>          '0906216933',
            'last_name' =>    'thin',
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
            'first_name' =>    'doan',
            'email' =>       'thintest@gmail.com',
            'password' =>    't12345678@',
            'phone' =>          '0906216933',
            'last_name' =>    'thin',
        ];

        $response = $this->post(route('users.update', [
            'user' => 1,
        ]), $userData);

        $response->assertStatus(302);
       

        $this->assertDatabaseHas('users', [
            'first_name' =>    'doan',
            'email' =>       'thintest@gmail.com',
            'password' =>    't12345678@',
            'phone' =>          '0906216933',
            'last_name' =>    'thin',
        ]);
    }

    /**
     * @dataProvider set_user_data_test_is_invalid
     */
    public function test_update_is_invalid($datInvalid, $fieldsInvalid)
    {
        $response = $this->post(route('users.update', [
            'user' => 1,
        ]), $datInvalid);

        $response->assertStatus(302);
        $response->assertSessionHasErrors($fieldsInvalid);
    }

    /**
     * @dataProvider set_user_data_test_is_invalid
     */
    protected function set_user_data_test_is_invalid()
    {
        return [
            [
                [
                    'first_name' =>    '',
                    'email' =>       '',
                    'password' =>    '',
                    'phone' =>          '',
                    'last_name' =>    '',
                ],
                [

                    'first_name' ,
                    'email' ,
                    'password',
                    'phone' ,
                    'last_name',
                ]
            ],
            [
                [
                    'first_name' =>    'thin',
                    'email' =>       '',
                    'password' =>    '',
                    'phone' =>          '',
                    'last_name' =>    '',
                ],
                [
                    'email' ,
                    'password',
                    'phone' ,
                    'last_name',
                ]
            ],


            [
                [
                    'first_name' =>    '',
                    'email' =>       'thintest@gmail.com',
                    'password' =>    '',
                    'phone' =>          '',
                    'last_name' =>    '',
                ],
                [
                    'first_name' ,
                    'password',
                    'phone' ,
                    'last_name',
                ]
            ],

            [
                [
                    'first_name' =>    '',
                    'email' =>       '',
                    'password' =>    't1234567@',
                    'phone' =>          '',
                    'last_name' =>    '',
                ],
                [
                    'first_name' ,
                    'email',
                    'phone' ,
                    'last_name',

                ]
                ],
                [
                    [
                        'first_name' =>    '',
                        'email' =>       '',
                        'password' =>    '',
                        'phone' =>         '0906216933',
                        'last_name' =>    '',
                    ],
                    [
                        'first_name' ,
                        'email',
                        'password' ,
                        'last_name',
    
                    ]
                    ],
                [
                    [
                        'first_name' =>    '',
                        'email' =>       '',
                        'password' =>    '',
                        'phone' =>          '',
                        'last_name' =>    'thin',
                    ],
                    [
                        'first_name' ,
                        'email',
                        'password',
                        'phone' ,
                        
    
                    ]
                ]

        ];
    }

    // public function test_delete()
    // {
    //     $response = $this->delete(route('question.delete'),[
    //         'question_id'=> 11,
    //     ]);

    //     $response->assertStatus(302);
    //     $this->assertDatabaseMissing('questions', [
    //         'id' =>  7,
    //     ]);
    // }
}
