<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_create_customer()
    {
        $user = User::factory()->create();

        $this->actingAs($user,'api');

        $formData = [
            'id' => '1',
            'first_name' => 'Chamod',
            'last_name' => 'Ravi',
            'age' => '29',
            'dob' => '1993-08-06',
            'email' => 'chamodtcr2@gmail.com'
        ];

        $this->json('POST',route('customer.store'),$formData)
            ->assertStatus(201);

    }

    public function test_can_update_customer()
    {
        $user = User::factory()->create();

        $this->actingAs($user,'api');

        $customer = Customer::factory()->create();

        $formData = [
            'first_name' => 'Chamod',
            'last_name' => 'Test',
            'age' => '30',
            'dob' => '1993-08-06',
            'email' => 'chamodtcr2@gmail.com'
        ];

        $this->json('PUT',route('customer.update',$customer->id),$formData)
            ->assertStatus(200);
    }

    public function test_can_show_customer()
    {
        $user = User::factory()->create();

        $this->actingAs($user,'api');

        $customer = Customer::factory()->create();

        $this->get(route('customer.show',$customer->id))->assertStatus(200);
    }

    public function test_can_delete_customer()
    {
        $user = User::factory()->create();

        $this->actingAs($user,'api');

        $customer = Customer::factory()->create();

        $this->delete(route('customer.destroy',$customer->id))->assertStatus(200);
    }

    public function test_can_list_customer()
    {
        $user = User::factory()->create();

        $this->actingAs($user,'api');

        $customer = Customer::factory(5)->create();

        $this->get(route('customer.index'))->assertStatus(200);
    }
}
