<?php

namespace Tests\Feature\App\Controller\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class TestControllerTest extends TestCase
{
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
        $response = $this->get(route('test.index'));

        $response->assertStatus(200);

        $response->assertSee('<h2>Quản lí bài test</h2>', false);
    }
    public function test_show_questions()
    {
        $response = $this->get(route('test.view',[4]));

        $response->assertStatus(200);

        $response->assertSee('<h2>Quản lí câu hỏi</h2>', false);
    }
    public function test_edit(){
        $response = $this->get(route('test.edit',[
            'id'=> 4,
        ]));

        $response->assertStatus(200);

        $response->assertSee('<h2>Update Test</h2>', false);
    }

    public function test_update_success()
    {
        $testData = [
            'title' =>   'abc',
            'time' =>    '60',
            'description' =>     'abcdefgh',
        ];

        $response = $this->post(route('test.update',[
            'id'=> 4,
        ]), $testData);

        $response->assertStatus(302);

        $this->assertDatabaseHas('tests', [
            'title' =>   'abc',
            'time' =>    '60',
            'description' =>     'abcdefgh',
        ]);

    }
    // public function test_delete()
    // {
    //     $response = $this->delete(route('test.delete'),[
    //         'test_id'=> 4,
    //     ]);
    //     $response->assertStatus(302);
    //     $this->assertDatabaseMissing('tests', [
    //         'id' =>  4,
    //     ]);
    // }
    public function test_create(){
        $response = $this->get(route('test.create'));

        $response->assertStatus(200);

        $response->assertSee('<h2>Tạo bài Test</h2>', false);
    }
    public function test_create_question(){
        $response = $this->get(route('test.create_question',[
            1,4,2
        ]));

        $response->assertStatus(200);

        $response->assertSee('<h2>Thêm câu hỏi trong test:</h2>', false);
    }
    public function update_category_test()
    {

        $response = $this->post(route('test.update_category_test',[
            4,
        ]));

        $response->assertStatus(302);

        $this->assertDatabaseHas('tests', [
            'category' =>   'Trắc nhiệm nhiều lựa chọn',
        ]);

    }
    protected function set_test_data_test_is_invalid()
    {
        return [
            [
                [
                    'title' =>   '',
                    'time' =>    '',
                    'description' =>       '',
                ],
                [

                    'title',
                    'time',
                    'description',
                ]
            ],
            [
                [
                    'title' =>   'Sponsors',
                    'time' =>    '',
                    'description' =>       '',
                ],
                [

                    'title',
                    'time',
                    'description',
                ]
            ],
            [
                [
                    'title' =>   '',
                    'time' =>    '60',
                    'description' =>       '',
                ],
                [

                    'title',
                    'time',
                    'description',
                ]
            ],
            [
                ['title' =>   '',
                'time' =>    '',
                'description' =>       'sdfcxvxcvxc',
                ],
                [

                    'title',
                    'time',
                    'description',
                ]
                
            ],
           
        ];
    }
    public function test_store_success()
    {
    $testData = [
        'title' =>   'Sponsors',
        'question'=>[
            1,2
        ],
        'time'=>'60',
        'description'=>'abcdefgh',
        'course'=>  1,
    ];

    $response = $this->post(route('test.store'), $testData);

    $response->assertStatus(302);

    $this->assertDatabaseHas('tests', [
        'title' =>   'Sponsors',
        'category'=>'Tự luận',
        'time'=>'60',
        'description'=>'abcdefgh',
    ]);
}

public function test_store_question(){
    $testData = [
        'question'=>[
            3,4
        ],
    ];

    $response = $this->post(route('test.store_question',[4]), $testData);

    $response->assertStatus(302);

    $this->assertDatabaseHas('test_questions', [
        'question_id'=>3,
    ]);
}
public function test_question_edit(){
    $response = $this->get(route('test.question.edit',[
        2,4,1
    ]));

    //$response->assertStatus(200);

    $response->assertSee('<h2>Đổi câu hỏi</h2>', false);
}
public function test_question_update(){
    $testData = [
            'question'=>
                6
            
        ];

        $response = $this->post(route('test.question.update',[
            4,2
        ]), $testData);

        $response->assertStatus(302);

        $this->assertDatabaseHas('test_questions', [
            'question_id'=>6,
        ]);
}
public function test_delete_question()
    {
        $response = $this->delete(route('test.question.delete',4),[
            'question_id'=> 4,
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('test_questions', [
            'question_id' =>  4,
        ]);
    }
    
}
