<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Appointment;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookingTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_schedule_screen_can_be_rendered()
    {

        $user = User::factory()->create();

        $response = $this->actingAs($user)
                         ->get('/schedule');

        $response->assertStatus(200);

    }

    public function test_schedule_search_screen_can_be_rendered()
    {

        $user = User::factory()->create();

        $response = $this->actingAs($user)
                         ->get('/schedule?search=asd');

        $response->assertStatus(200);

    }

    public function test_history_screen_can_be_rendered()
    {

        $user = User::factory()->create();

        $response = $this->actingAs($user)
                         ->get('/history');

        $response->assertStatus(200);

    }

    public function test_history_search_screen_can_be_rendered()
    {

        $user = User::factory()->create();

        $response = $this->actingAs($user)
                         ->get('/history?search=asd');

        $response->assertStatus(200);

    }

    public function test_show_appointment_screen_can_be_rendered()
    {

        $user = User::factory()->create();

        $customer = Customer::factory()->create();

        $customer_id = $customer->id;

        $appointment_factory = Appointment::factory()->create([
            'user_id' => $customer_id,
        ]);

        $appointment_id = $appointment_factory->id;

        $appointment = Appointment::where('id', $appointment_id)->first();

        $title = $appointment->title;

        $response = $this->actingAs($user)
                         ->get('/appointment/'.$appointment_id.'/'.$title);

        $response->assertStatus(200);

    }

    public function test_edit_appointment_screen_can_be_rendered()
    {

        $user = User::factory()->create();

        $customer = Customer::factory()->create();

        $customer_id = $customer->id;

        $appointment_factory = Appointment::factory()->create([
            'user_id' => $customer_id,
        ]);

        $appointment_id = $appointment_factory->id;

        $title = $appointment_factory->title;

        $response = $this->actingAs($user)
                         ->get('/appointment/'.$appointment_id.'/'.$title.'/edit');

        $response->assertStatus(200);

    }

    public function test_update_appointment(){

        $user = User::factory()->create();

        $customer = Customer::factory()->create();

        $customer_id = $customer->id;

        $appointment_factory = Appointment::factory()->create([
            'user_id' => $customer_id,
        ]);

        $appointment_id = $appointment_factory->id;

        $title = $appointment_factory->title;

        $response = $this->actingAs($user)
                            ->from('/appointment/'.$appointment_id.'/'.$title.'/edit')
                            ->post('/appointment/'.$appointment_id.'/update', [
                                'outcome' => 'Cyber Practice Cyber Practice Cyber Practice Cyber Practice Cyber Practice',
                            ])
                            ->assertRedirect('/appointment/'.$appointment_id.'/'.$title.'/edit');

        
        
    }

}
