<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductsControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if(!User::first()) {
            $this->artisan('db:seed');
        }
    }

    /**
     * User can access the GET route for Products.
     *
     * @return void
     */
    public function testAccessGetRoute()
    {
        $product = Product::factory()->create();

        $response = $this->json('GET', '/api/products/'. $product->id);

        $response->assertStatus(200);

        $content = json_decode($response->getContent(), true);

        $this->assertEquals($product->toArray(), $content);
    }

    /**
     * User needs to be logged in order to create a product.
     *
     * @return void
     */
    public function testNeedToBeLoggedInToCreateProduct()
    {
        $response = $this->json('POST', '/api/products', ['name' => 'name', 'description' => 'description', 'price' => 10]);

        $response->assertStatus(401);
    }

    /**
     * User needs to have products:create ability in order to create product.
     *
     * @return void
     */
    public function testNeedToHaveCorrectAbilityToCreateProduct()
    {
        Sanctum::actingAs(User::first(), ['products:update']); // User has incorrect ability.

        $response = $this->json('POST', '/api/products', ['name' => 'name', 'description' => 'description', 'price' => 10]);

        $response->assertStatus(403); // Can not create product.
    }

    /**
     * User can create a product.
     *
     * @return void
     */
    public function testCanCreateProduct()
    {
        Sanctum::actingAs(User::first(), ['products:create']); // User has correct ability.

        $productsCount = Product::count();

        $response = $this->json('POST', '/api/products', ['name' => 'name', 'description' => 'description', 'price' => 10]);

        $response->assertStatus(200); // User can create a product.

        $this->assertEquals($productsCount + 1, Product::count()); // New product has been created.
    }

    /**
     * User needs to be logged in order to update a product.
     *
     * @return void
     */
    public function testNeedToBeLoggedInToUpdateProduct()
    {
        $response = $this->json('PUT', '/api/products/1', ['name' => 'new name', 'description' => 'new description', 'price' => 20]);

        $response->assertStatus(401);
    }

    /**
     * User needs to have products:update ability in order to update product.
     *
     * @return void
     */
    public function testNeedToHaveCorrectAbilityToUpdateProduct()
    {
        Sanctum::actingAs(User::first(), ['products:create']); // User has incorrect ability.

        $response = $this->json('PUT', '/api/products/1', ['name' => 'new name', 'description' => 'new description', 'price' => 20]);

        $response->assertStatus(403); // User can not update product.
    }

    /**
     * User can update a product.
     *
     * @return void
     */
    public function testCanUpdateProduct()
    {
        Sanctum::actingAs(User::first(), ['products:update']); // User has correct ability.
        $product = Product::factory()->create();

        $response = $this->json('PUT', '/api/products/'.$product->id, ['name' => 'new name', 'description' => 'new description', 'price' => 20]);

        $response->assertStatus(200); // User can update the product.

        $this->assertEquals('new name', $product->refresh()->name);
        $this->assertEquals('new description', $product->description);
        $this->assertEquals(20, $product->price);
    }

    /**
     * User needs to be logged in order to delete a product.
     *
     * @return void
     */
    public function testNeedToBeLoggedInToDeleteProduct()
    {
        $response = $this->json('DELETE', '/api/products/1', ['name' => 'new name', 'description' => 'new description', 'price' => 20]);

        $response->assertStatus(401);
    }

    /**
     * User needs to have products:delete ability in order to delete product.
     *
     * @return void
     */
    public function testNeedToHaveCorrectAbilityToDeleteProduct()
    {
        Sanctum::actingAs(User::first(), ['products:update']); // User has incorrect ability.

        $response = $this->json('DELETE', '/api/products/1', ['name' => 'new name', 'description' => 'new description', 'price' => 20]);

        $response->assertStatus(403); // User can not update product.
    }

    /**
     * User needs to be logged in order to delete a product.
     *
     * @return void
     */
    public function testCanDeleteProduct()
    {
        Sanctum::actingAs(User::first(), ['products:delete']); // User has correct ability.
        $product = Product::factory()->create();

        $response = $this->json('DELETE', '/api/products/'.$product->id);

        $response->assertStatus(200); // User can delete the product.
        $this->assertNull($product->fresh()); // Product has been deleted.
    }
}
