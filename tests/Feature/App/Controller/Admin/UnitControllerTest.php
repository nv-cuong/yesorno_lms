<?php

namespace Tests\Feature\App\Controller\Admin;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class UnitControllerTest extends TestCase
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
    public function test_showUnit()
    {
        $response = $this->get(route('unit.detail', [
            'id' => 1,
        ]));

        $response->assertStatus(200);

        $response->assertSee('<h4>Danh sách bài học</h4>', false);
    }

    public function test_create()
    {
        $response = $this->get(route('unit.create', [
            'course_id' => 1,
        ]));

        $response->assertStatus(200);

        $response->assertSee('<h2 class="card-title" style="font-weight:bold">Thêm chương mới</h2>', false);
    }

    public function test_edit()
    {
        $response = $this->get(route('unit.edit', [
            'id' => 1,
        ]));

        $response->assertStatus(200);

        $response->assertSee('<h2 class="card-title" style="font-weight:bold">Chỉnh sửa chương</h2>', false);
    }

    public function test_update_if_success()
    {
        $unitData = [
            'title' =>      'Program',
            'course_id' =>  '1'
        ];

        $response = $this->post(route('unit.update', [
            'id' => 1,
        ]), $unitData);

        $response->assertStatus(302);

        $this->assertDatabaseHas('units', [
            'title' =>      'Program',
        ]);
    }

    /**
     * @dataProvider set_unit_data_test_is_invalid
     */
    public function test_update_is_invalid($dataInvalid, $fieldsInvalid)
    {
        $response = $this->post(route('unit.update', [
            'id' => 1,
        ]), $dataInvalid);

        $response->assertStatus(302);
        $response->assertSessionHasErrors($fieldsInvalid);
    }

    public function set_unit_data_test_is_invalid()
    {
        return [
            [
                [
                    'title' =>      '',
                    'course_id' =>      '',
                ],
                [
                    'title',
                    'course_id'
                ]
            ],
            [
                [
                    'title' =>      'Program',
                    'course_id' =>      'asd',
                ],
                [
                    'course_id',
                ]
            ],
        ];
    }

    public function test_delete()
    {
        $response = $this->delete(route('unit.delete', [
            'course_id' => 1
        ]), [
            'unit_id' => 1,
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('units', [
            'id' =>  1,
        ]);
    }
}
