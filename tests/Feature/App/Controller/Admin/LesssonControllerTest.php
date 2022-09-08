<?php

namespace Tests\Feature\App\Controller\Admin;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class LesssonControllerTest extends TestCase
{
    private $user;

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
    public function test_showLesson()
    {
        $response = $this->get(route('lesson.detail', [
            'id' => 1,
        ]));

        $response->assertStatus(200);

        $response->assertSee('<h6>Nội dung bài học</h6>', false);
    }

    public function test_create()
    {
        $response = $this->get(route('lesson.create', [
            'unit_id' => 2
        ]));

        $response->assertStatus(200);

        $response->assertSee('<h2 class="card-title" style="font-weight:bold">Thêm bài học mới</h2>', false);
    }

    public function test_edit()
    {
        $response = $this->get(route('lesson.edit', [
            'id' => 5,
        ]));

        $response->assertStatus(200);

        $response->assertSee('<h2 class="card-title" style="font-weight:bold">Chỉnh sửa bài học</h2>', false);
    }

    public function test_update_if_success()
    {
        $courseData = [
            'title' =>      'Program',
            'unit_id' =>     '2',
            'published' =>   '2022-2-2',
            'content'=> 'test test test test test test test '
        ];

        $response = $this->post(route('lesson.update', [
            'id' => 5,
        ]), $courseData);

        $response->assertStatus(302);

        $this->assertDatabaseHas('lessons', [
            'title' =>      'Program',
            'unit_id' =>    '2',
        ]);
    }

    /**
     * @dataProvider set_lesson_data_test_is_invalid
     */
    public function test_update_is_invalid($dataInvalid, $fieldsInvalid)
    {
        $response = $this->post(route('lesson.update',[
            'id'=> 5,
        ]), $dataInvalid);

        $response->assertStatus(302);
        $response->assertSessionHasErrors($fieldsInvalid);
    }

    public function set_lesson_data_test_is_invalid()
    {
        return [
            [
                [
                    'title' =>      '',
                    'unit_id' =>     '',
                    'published' =>   '',
                    'content'=> ''
                ],
                [
                    'title',
                    'unit_id',
                    'published',
                    'content'
                ]
            ],
            [
                [
                    'title' =>      'Program',
                    'unit_id' =>     'asd',
                    'published' =>   '',
                    'content'=> ''
                ],
                [
                    'unit_id',
                    'published',
                    'content'
                ]
            ],
            [
                [
                    'title' =>      'Program',
                    'unit_id' =>     'asd',
                    'published' =>   'asd',
                    'content'=> 'test test test test test test test '
                ],
                [
                    'unit_id',
                    'published',
                ]
            ],
            [
                [
                    'title' =>      '',
                    'unit_id' =>     '2',
                    'published' =>   '2022-2-2',
                    'content'=> 'test'
                ],
                [
                    'title',
                    'content'
                ]
            ],
            [
                [
                    'title' =>      '',
                    'unit_id' =>     '2kk',
                    'published' =>   '20a',
                    'content'=> 'test'
                ],
                [
                    'title',
                    'unit_id',
                    'published',
                    'content'
                ]
            ],
        ];
    }
    
    public function test_delete()
    {
        $response = $this->delete(route('lesson.delete', [
            'unit_id' => 2
        ]),[
            'lesson_id'=> 6,
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('lessons', [
            'id' =>  6,
        ]);
    }
}
