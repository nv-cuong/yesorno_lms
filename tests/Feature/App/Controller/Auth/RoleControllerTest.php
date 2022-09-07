<?php

namespace Tests\Feature\App\Controller\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Artisan;

class RoleControllerTest extends TestCase
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
        //Artisan::call('db:seed', ['--class'=>'DatabaseSeeder']);
        $this->user = Sentinel::findUserById(1);
        Sentinel::login($this->user, true);
    }

    public function test_index()
    {
        $response = $this->get(route('roles.index'));

        $response->assertStatus(200);

        $response->assertSee('<td>class-manager</td>',false);
    }

    public function test_create()
    {
        $response = $this->get(route('roles.create'));

        $response->assertStatus(200);

        $response->assertSee('<h3 class="card-title">Thêm mới role</h3>',false);
    }

    public function test_store_success()
    {
        $roleData = [
            'name' =>   'Sponsors',
        ];

        $response = $this->post(route('roles.store'), $roleData);

        $response->assertStatus(302);

        $this->assertDatabaseHas('roles', [
            'name' =>   'Sponsors',
        ]);
    }
    /**
     * @dataProvider set_role_data_test_is_invalid
     */

    public function test_store_is_invalid($datInvalid, $fieldsInvalid)
    {
        $response = $this->post(route('roles.store'), $datInvalid);

        $response->assertStatus(302);
        $response->assertSessionHasErrors($fieldsInvalid);
    }

    public function test_edit()
    {
        $response = $this->get(route('roles.edit',[
            'role'=>6
        ]));

        $response->assertStatus(200);

        $response->assertSee('<h3 class="card-title">Sửa role</h3>',false);
    }

    public function test_update_success()
    {
        $roleData = [
            'name' =>   'Sponsors',
        ];

        $response = $this->put(route('roles.update',[
            'role'=>6,
        ]), $roleData);

        $response->assertStatus(302);

        $this->assertDatabaseHas('roles', [
            'name' =>   'Sponsors',
        ]);
    }

    /**
     * @dataProvider set_role_data_test_is_invalid
     */
    public function test_update_is_invalid($datInvalid, $fieldsInvalid)
    {
        $response = $this->put(route('roles.update',[
            'role'=>6,
        ]), $datInvalid);

        $response->assertStatus(302);
        $response->assertSessionHasErrors($fieldsInvalid);
    }

    protected function set_role_data_test_is_invalid()
    {
        return [
            [
                [
                    'name' => '',
                ],
                [
                    'name',
                ]
            ],
            [
                [
                    'name' => '123????',
                ],
                [
                    'name',
                ]
            ],
        ];
    }

    public function test_duplicate()
    {
        $response = $this->get(route('roles.duplicate',[
            'role'=> 6,
            ]));
        // $response = $this->call('DELETE', 'student.delete',$studentData);
        $response->assertStatus(200);
        $response->assertSee('<h3 class="card-title">Tạo role</h3>',false);
    }

    public function test_destroy()
    {
        $response = $this->delete(route('roles.destroy'),[
            'role_id'=> 6,
        ]);
        // $response = $this->call('DELETE', 'student.delete',$studentData);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('roles', [
            'id' => 6,
        ]);
    }
 }
