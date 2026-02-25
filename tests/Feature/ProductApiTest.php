<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->token = $this->user->createToken('test-token')->plainTextToken;
    }

    public function test_can_list_products()
    {
        Product::factory()->count(5)->create();

        $response = $this->getJson('/api/products', [
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200)
            ->assertJsonCount(5, 'data');
    }

    public function test_can_filter_products_by_category()
    {
        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();

        Product::factory()->create(['category_id' => $category1->id]);
        Product::factory()->create(['category_id' => $category2->id]);

        $response = $this->getJson("/api/products?category_id={$category1->id}", [
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_can_create_product()
    {
        $category = Category::factory()->create();
        $data = [
            'name' => 'New Product',
            'category_id' => $category->id,
            'description' => 'Test Description',
            'price' => 99.99,
            'stock' => 10,
            'enabled' => true,
        ];

        $response = $this->postJson('/api/products', $data, [
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('product.name', 'New Product');

        $this->assertDatabaseHas('products', ['name' => 'New Product']);
    }

    public function test_can_show_product()
    {
        $product = Product::factory()->create();

        $response = $this->getJson("/api/products/{$product->id}", [
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('id', $product->id);
    }

    public function test_can_update_product()
    {
        $product = Product::factory()->create(['name' => 'Old Name']);
        $data = ['name' => 'Updated Name'];

        $response = $this->putJson("/api/products/{$product->id}", $data, [
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('product.name', 'Updated Name');

        $this->assertDatabaseHas('products', ['name' => 'Updated Name']);
    }

    public function test_can_delete_product_softly()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/products/{$product->id}", [], [
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200);
        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }

    public function test_can_bulk_delete_products()
    {
        $products = Product::factory()->count(3)->create();
        $ids = $products->pluck('id')->toArray();

        $response = $this->deleteJson('/api/products/bulk-delete', ['ids' => $ids], [
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200);
        foreach ($ids as $id) {
            $this->assertSoftDeleted('products', ['id' => $id]);
        }
    }
}
