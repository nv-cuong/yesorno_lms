<?php

namespace Tests\Feature\App\Controller\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class ClassControllerTest extends TestCase
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
     * 
     */
    public function test_index()
    {
        $response = $this->get(route('class.index'));

        $response->assertStatus(200);

        $response->assertSee('<h1>Danh sách lớp học</h1>', false);
    }
    /**
     * 
     */
    public function test_showDetail()
    {
        $response = $this->get(route('class.show',[
            'class' => 'html-css',
        ]));

        $response->assertStatus(200);

        $response->assertSee('<label for="">Danh sách sinh viên trong lớp</label>', false);
    }

    public function test_create(){
        $response = $this->get(route('class.create'));

        $response->assertStatus(200);

        $response->assertSee('<h3 class="card-title" style="font-weight:bold">Tạo lớp học mới</h3>', false);
    }

    public function test_edit(){
        $response = $this->get(route('class.edit',[
            'class' => 1,
        ]));

        $response->assertStatus(200);

        $response->assertSee('<h3 class="card-title" style="font-weight:bold">Chỉnh sửa lớp học</h3>', false);
    }

    public function test_update_if_success()
    {
        $classData = [
            'name'          => 'Ex ab qui inventore dolores.',
            'description'   => 'test test test test test test test ',
            'course_id' => [1,2,3],
            'schedule'      => '0'
        ];

        $response = $this->put(route('class.update', [
            'class' => 1,
        ]), $classData);

        $response->assertStatus(302);

        $this->assertDatabaseHas('class_studies', [
            'name'          => 'Ex ab qui inventore dolores.',
            'slug'          => 'ex-ab-qui-inventore-dolores',
            'schedule'      => '0'
        ]);
    }

    /**
     * @dataProvider set_class_data_test_is_invalid
     */
    public function test_update_is_invalid($dataInvalid, $fieldsInvalid)
    {
        $response = $this->put(route('class.update',[
            'class'=> 1,
        ]), $dataInvalid);

        $response->assertStatus(302);
        $response->assertSessionHasErrors($fieldsInvalid);
    }

    protected function set_class_data_test_is_invalid()
    {
        return [
            [
                [
                    'name' =>   '',
                    'description' =>    '',
                    'schedule' =>     '',
                ],
                [
                    'name',
                    'description',
                    'schedule',
                ]
            ],
            [
                [
                    'name' =>   'html and css',
                    'description' =>    '',
                    'schedule' =>     '',
                ],
                [
                    'description',
                    'schedule',
                ]
            ],
            [
                [
                    'name' =>   '',
                    'description' =>    'html css tu co ban den nang cao',
                    'schedule' =>     '',
                ],
                [
                    'name',
                    'schedule',
                ]
            ],
            [
                [
                    'name' =>   '',
                    'description' =>    '',
                    'schedule' =>     '0',
                ],
                [
                    'name',
                    'description',
                ]
            ]
        ];
    }

    public function test_delete()
    {
        $response = $this->delete(route('class.delete'),[
            'class_id'=> 15,
        ]);
        // $response = $this->call('DELETE', 'student.delete',$studentData);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('class_studies', [
            'id' =>  15,
        ]);
    }
}
