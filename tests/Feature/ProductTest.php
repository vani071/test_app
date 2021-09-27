<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_product_list()
    {
        $response = $this->json('GET', '/api/product/list');

        $response->assertStatus(200);
    }

    public function test_add_to_cart()
    {
        $response = $this->json('POST', '/api/cart/addProduct',['sku'=>'mos-01','qty'=>1]);

        $response->assertStatus(200);
    }
}
