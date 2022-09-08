<?php

namespace Tests\Feature\App\Controller\Admin;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CourseControllerTest extends TestCase
{
    private $user;

    /**
     * {@inheritDoc}
     * @see \Illuminate\Foundation\Testing\TestCase::setUp()
     */
    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed', ['--class' => 'DatabaseSeeder']);
        $this->user = Sentinel::findUserById(1);
        Sentinel::login($this->user, true);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index()
    {
        $response = $this->get(route('course.index'));

        $response->assertStatus(200);

        $response->assertSee('<h1>Quản lý khóa học</h1>', false);
    }

    public function test_showStudent()
    {
        $response = $this->get(route('course.student', [
            'id' => 1,
        ]));

        $response->assertStatus(200);

        $response->assertSee('<h1>Quản lý khóa học</h1>', false);
    }

    public function test_showTest()
    {
        $response = $this->get(route('course.test', [
            'id' => 1,
        ]));

        $response->assertStatus(200);

        $response->assertSee('<h1>Quản lý khóa học</h1>', false);
    }

    public function test_showCourse()
    {
        $response = $this->get(route('course.detail', [
            'id' => 1,
        ]));

        $response->assertStatus(200);

        $response->assertSee('<h4>Danh sách chương</h4>', false);
    }

    public function test_create()
    {
        $response = $this->get(route('course.create'));

        $response->assertStatus(200);

        $response->assertSee('<h2 class="card-title" style="font-weight:bold">Tạo khóa học mới</h2>', false);
    }

    public function test_edit()
    {
        $response = $this->get(route('course.edit', [
            'id' => 4,
        ]));

        $response->assertStatus(200);

        $response->assertSee('<h2 class="card-title" style="font-weight:bold">Chỉnh sửa khóa học</h2>', false);
    }

    public function test_update_if_success()
    {
        $courseData = [
            'title' =>      'Program',
            'status' =>     '0',
            'begin_date' => '2022-1-1',
            'end_date' =>   '2022-2-2',
            'image' =>      'test.png',
            'description'=> 'test test test test test test test '
        ];

        $response = $this->post(route('course.update', [
            'id' => 4,
        ]), $courseData);

        $response->assertStatus(302);

        $this->assertDatabaseHas('courses', [
            'title' =>      'Program',
            'slug' =>       'program',
            'status' =>     '0',
        ]);
    }

    /**
     * @dataProvider set_course_data_test_is_invalid
     */
    public function test_update_is_invalid($dataInvalid, $fieldsInvalid)
    {
        $response = $this->post(route('course.update',[
            'id'=> 4,
        ]), $dataInvalid);

        $response->assertStatus(302);
        $response->assertSessionHasErrors($fieldsInvalid);
    }

    public function set_course_data_test_is_invalid()
    {
        return [
            [
                [
                    'title' =>      '',
                    'status' =>     '',
                    'begin_date' => '',
                    'end_date' =>   '',
                    'image' =>      '',
                    'description'=> ''
                ],
                [
                    'title',
                    'status',
                    'begin_date',
                    'end_date',
                    'description'
                ]
            ],
            [
                [
                    'title' =>      'Program',
                    'status' =>     '',
                    'begin_date' => '',
                    'end_date' =>   '',
                    'image' =>      '',
                    'description'=> 'test test test test test test test '
                ],
                [
                    'status',
                    'begin_date',
                    'end_date',
                ]
            ],
            [
                [
                    'title' =>      'Program',
                    'status' =>     '0',
                    'begin_date' => 'rr',
                    'end_date' =>   'aa',
                    'image' =>      '',
                    'description'=> ''
                ],
                [
                    'begin_date',
                    'end_date',
                ]
            ],
            [
                [
                    'title' =>      '',
                    'status' =>     '0',
                    'begin_date' => '2022-1-1',
                    'end_date' =>   '2022-2-2',
                    'image' =>      '',
                    'description'=> 'test'
                ],
                [
                    'title',
                    'description',
                ]
            ],
            [
                [
                    'title' =>      '',
                    'status' =>     'asd',
                    'begin_date' => '2022-1-1',
                    'end_date' =>   '2022-2-2',
                    'image' =>      '',
                    'description'=> 'test test test test test test test'
                ],
                [
                    'title',
                    'status',
                ]
            ],
        ];
    }
    
    public function test_delete()
    {
        $response = $this->delete(route('course.delete'),[
            'course_id'=> 5,
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('courses', [
            'id' =>  5,
        ]);
    }
}
