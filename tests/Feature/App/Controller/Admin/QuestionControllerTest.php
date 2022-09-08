<?php

namespace Tests\Feature\App\Controller\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Artisan;

class QuestionControllerTest extends TestCase
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
        $response = $this->get(route('question.index'));

        $response->assertStatus(200);

        $response->assertSee('<h1>Quản lý Câu hỏi</h1>', false);
    }
    public function test_show_answser(){
        $response = $this->get(route('question.answer',[
            'id'=> 2,
        ]));

        $response->assertStatus(200);
        $response->assertSee('', false);
        
    }
    public function test_create()
    {
        $response = $this->get(route('question.create'));

        $response->assertStatus(200);

        $response->assertSee('<h3 class="card-title">Thêm mới câu hỏi</h3>', false);
    }

    /**
     * @dataProvider set_question_data_test_is_invalid
     */

    public function test_store_is_invalid($datInvalid, $fieldsInvalid)
    {
        $response = $this->post(route('question.store'), $datInvalid);

        $response->assertStatus(302);
        $response->assertSessionHasErrors($fieldsInvalid);
    }
    
    public function test_store_success()
    {
        $questionData = [
            'content' =>           'Teteqwsssdsdd.',
            'course_id' =>       '2',
            'category' =>    '0',
            'score' =>    '10',
        ];

        $response = $this->post(route('question.store'), $questionData);

        $response->assertStatus(302);
        //$response->assertRedirect(route('question.index'));
        $this->assertDatabaseHas('questions', [
            'course_id' =>     '2',
            'score' =>    '10.00',
        ]);

    }
    public function test_store_1_success()
    {
        $questionData = [
            'content' =>           'Teteqwsssdsdd.',
            'course_id' =>       '2',
            'category' =>    '2',
            'answer' =>    '1',
            'score' =>    '10',
        ];

        $response = $this->post(route('question.store'), $questionData);

        $response->assertStatus(302);
        //$response->assertRedirect(route('question.index'));
        $this->assertDatabaseHas('questions', [
            'course_id' =>     '2',
            'score' =>    '10.00',
        ]);

    }
    public function test_store_2_success()
    {
        $questionData = [
            'content' =>           'Teteqwsssdsdd.',
            'course_id' =>       '2',
            'category' =>    '3',
            'answer' =>    '1',
            'score' =>    '10',
        ];

        $response = $this->post(route('question.store'), $questionData);

        $response->assertStatus(302);
        //$response->assertRedirect(route('question.index'));
        $this->assertDatabaseHas('questions', [
            'course_id' =>     '2',
            'score' =>    '10.00',
        ]);

    }

    public function test_edit()
    {
        $response = $this->get(route('question.edit', [
            'id' => 90,
        ]));

        $response->assertStatus(200);

        $response->assertSee('<h3 class="card-title">Sửa câu hỏi</h3>', false);
    }

    public function test_update_success()
    {
        $questionData = [
            'content' =>   'test',
            'course_id' =>    '1',
            'score' =>     '10',
        ];

        $response = $this->post(route('question.update', [
            'id' => 6,
        ]), $questionData);

        $response->assertStatus(302);
        // $response->assertRedirect(route('students'));

        $this->assertDatabaseHas('questions', [
            'content' =>   'test',
            'course_id' =>    '1',
            'score' =>     '10',
        ]);
    }

    /**
     * @dataProvider set_question_data_test_is_invalid
     */
    public function test_update_is_invalid($datInvalid, $fieldsInvalid)
    {
        $response = $this->post(route('question.update', [
            'id' => 9,
        ]), $datInvalid);

        $response->assertStatus(302);
        $response->assertSessionHasErrors($fieldsInvalid);
    }

    
    protected function set_question_data_test_is_invalid()
    {
        return [
            [
                [
                    'course_id' => '',
                    'content' =>   '',
                    'score' =>     '',
                    
                ],
                [

                    'course_id',
                    'content',
                    'score',
                ]
            ],
            [
                [
                    'course_id' =>    '1',
                    'content' =>   '',
                    'score' =>     '',
                ],
                [
                    'content',
                    'score',
                ]
            ],
            
            
            [
                [
                    'course_id' =>    '',
                    'content' =>   'content',
                    'score' =>     '',
                ],
                [

                    'course_id',
                    'score',
                ]
            ],
            
            [
                [
                    'course_id' =>    '',
                    'content' =>   '',
                    'score' =>     '2',
                ],
                [

                    'course_id',
                    'content',
                    

                ]
            ]

        ];
    }

    public function test_delete()
    {
        $response = $this->delete(route('question.delete'),[
            'question_id'=> 24,
        ]);
       
        $response->assertStatus(302);
        $this->assertDatabaseMissing('questions', [
            'id' =>  24,
        ]);
    }
}
