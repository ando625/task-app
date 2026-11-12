<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use App\Models\Category;
use App\Models\Task;
use App\Models\User;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function ユーザーはタスク一覧を取得できる(): void
    {
        $user = User::factory()->create();
        Task::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('tasks.index'));

        $response->assertStatus(200);
        $response->assertViewHas('tasks');
    }

    #[Test]
    public function ユーザーはタスク詳細を取得できる(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('tasks.show',$task));

        $response->assertStatus(200);
        $response->assertViewHas('task');
    }

    #[Test]
    public function ユーザーはタスク作成画面を取得できる(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('tasks.create'));

        $response->assertStatus(200);
    }

    #[Test]
    public function ユーザーはタスクを作成できる(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
         
        $response = $this->actingAs($user)->post(route('tasks.store'),[
            'title' => 'テストタスク',
            'content' => 'テストの説明',
            'priority' => 2,
            'status' => 'todo',
            'category_id' =>  $category->id,
        ]);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks',[
            'title' => 'テストタスク',
            'user_id' => $user->id,
        ]);

    }

    #[Test]
    public function タスクタイトルが空だとバリデーションエラーになる(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->post(route('tasks.store'), [
            'title' => '',
            'priority' => 2,
            'status' => 'todo',
            'category_id' =>  $category->id,
        ]);

        $response->assertSessionHasErrors('title');
    }

    #[Test]
    public function 無効な優先度だとバリデーションエラーになる(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->post(route('tasks.store'), [
            'title' => 'テストタスク',
            'priority' => 99,
            'status' => 'todo',
            'category_id' =>  $category->id,
        ]);

        $response->assertSessionHasErrors('priority');
    }

    #[Test]
    public function 無効な進捗度だとバリデーションエラーになる(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->post(route('tasks.store'), [
            'title' => 'テストタスク',
            'priority' => 3,
            'status' => 'test',
            'category_id' =>  $category->id,
        ]);

        $response->assertSessionHasErrors('status');
    }

    #[Test]
    public function タイトルは255文字まで入力できる(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->post(route('tasks.store'), [
            'title' => str_repeat('あ',255),
            'content' => 'テストの説明',
            'priority' => 2,
            'status' => 'todo',
            'category_id' =>  $category->id,
        ]);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'title' => str_repeat('あ', 255),
            'user_id' => $user->id,
        ]);
    }

    #[Test]
    public function タイトルが256文字以上だとバリデーションエラーになる(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->post(route('tasks.store'), [
            'title' => str_repeat('あ', 256),
            'priority' => 2,
            'status' => 'todo',
            'category_id' =>  $category->id,
        ]);

        $response->assertSessionHasErrors('title');
    }

    #[Test]
    public function ユーザーはタスク編集画面を表示できる(): void
    {
        $user =User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('tasks.edit',$task));

        $response->assertStatus(200);
        $response->assertViewHas('task');
    }

    #[Test]
    public function ユーザーはタスクを更新できる(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->put(route('tasks.update',$task),[
            'title' => '更新後のタイトル',
            'priority' => 3,
            'status' => 'completed',
            'category_id' => $category->id,
        ]);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks',[
            'title' => '更新後のタイトル',
            'priority' => 3,
            'status' => 'completed',
            'id' => $task->id,
        ]);


    }

    #[Test]
    public function ユーザーはタスクを削除できる(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('tasks.destroy',$task));

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseMissing('tasks',['id' => $task->id]);
    }
}
