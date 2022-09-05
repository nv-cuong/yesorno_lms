<?php

namespace Tests\Feature\App\Controller\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Artisan;

class StudentControllerTest extends TestCase
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
        Artisan::call('db:seed', ['--class'=>'DatabaseSeeder']);
        $this->user = Sentinel::findUserById(1);
        Sentinel::login($this->user, true);
    }

    public function test_index()
    {
        $response = $this->get(route('students'));

        $response->assertStatus(200);

        $response->assertSee('<h2>Danh sách học viên</h2>', false);
    }

    public function test_showClass(){
        $response = $this->get(route('student.class',[
            'id'=> 4,
        ]));

        $response->assertStatus(200);

        $response->assertSee('<h3 class="page-title d-inline mb-0">Thông tin lớp học của học viên</h3>', false);
    }

    public function test_showCourse(){
        $response = $this->get(route('student.course',[
            'id'=> 4,
        ]));

        $response->assertStatus(200);

        $response->assertSee('<span class="badge badge-danger navbar-badge">3</span>', false);
    }

    public function test_edit(){
        $response = $this->get(route('student.edit',[
            'id'=> 4,
        ]));

        $response->assertStatus(200);

        $response->assertSee('<h3 class="page-title d-inline">Sửa thông tin học viên</h3>', false);
    }

    public function test_update_success()
    {
        $studentData = [
            'first_name' =>   'Nguyen',
            'last_name' =>    'Hieu',
            'gender' =>       'male',
            'phone' =>        '0123456789',
            'birthday' =>     '20/09/2000',
        ];

        $response = $this->post(route('student.update',[
            'id'=> 4,
        ]), $studentData);

        $response->assertStatus(302);
        // $response->assertRedirect(route('students'));

        $this->assertDatabaseHas('users', [
            'first_name' =>   'Nguyen',
            'last_name' =>    'Hieu',
            'gender' =>       'male',
        ]);

    }

    /**
     * @dataProvider set_student_data_test_is_invalid
     */

    public function test_update_is_invalid($datInvalid, $fieldsInvalid)
    {
        $response = $this->post(route('student.update',[
            'id'=> 4,
        ]), $datInvalid);

        $response->assertStatus(302);
        $response->assertSessionHasErrors($fieldsInvalid);
    }
    protected function set_student_data_test_is_invalid()
    {
        return [
            [
                [
                    'first_name' =>   '',
                    'last_name' =>    '',
                    'gender' =>       '',
                    'phone' =>        '',
                    'birthday' =>     '',
                ],
                [

                    'first_name',
                    'last_name',
                    'gender',
                    'phone',
                    'birthday',
                ]
            ],
            [
                [
                    'first_name' =>   'Nguyen',
                    'last_name' =>    '',
                    'gender' =>       '',
                    'phone' =>        '',
                    'birthday' =>     '',
                ],
                [

                    'last_name',
                    'gender',
                    'phone',
                    'birthday',
                ]
            ],
            [
                [
                    'first_name' =>   '',
                    'last_name' =>    'Hieu',
                    'gender' =>       '',
                    'phone' =>        '',
                    'birthday' =>     '',
                ],
                [

                    'first_name',
                    'gender',
                    'phone',
                    'birthday',
                ]
            ],
            [
                [
                    'first_name' =>   '',
                    'last_name' =>    '',
                    'gender' =>       'male',
                    'phone' =>        '',
                    'birthday' =>     '',
                ],
                [

                    'first_name',
                    'last_name',
                    'phone',
                    'birthday',
                ]
            ],
            [
                [
                    'first_name' =>   '',
                    'last_name' =>    '',
                    'gender' =>       '',
                    'phone' =>        '',
                    'birthday' =>     '20/04/2000',
                ],
                [

                    'first_name',
                    'last_name',
                    'gender',
                    'phone',
                ]
            ]
        ];
    }
}

