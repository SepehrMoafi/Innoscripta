<?php

namespace Tests\Feature;

use App\Models\User;
use Features\Articles\Article;
use Features\Categories\Category;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAuthenticationNeeded(): void
    {
        $response = $this->get(route('articles.store'));
        $response->assertRedirect(route('login'));
    }

    public function testUserLoggedIn(): void
    {
//      login user
        $this->LoginAsUser();
        //store article
        $storePost = $this->storeArticle();
        $storePost->assertJson(['status'=>'success','message'=>'article created successfully']);
        $storePost->assertStatus(200);
    }


    public function LoginAsUser(): void
    {
        $user = new User();
        $this->actingAs($user);
    }

    public function storeArticle(): \Illuminate\Testing\TestResponse
    {
        $category=Category::query()->first();
        $data = [
            'name' => 'sepehr moafi',
            'client' => 'android',
            'image' => 'image',
            'tags' => 'tags',
            'category_id' => $category->id,
            'description' => 'description2',
        ];
        $storePost = $this->post(route('articles.store'), $data);
        return $storePost;
    }

}
