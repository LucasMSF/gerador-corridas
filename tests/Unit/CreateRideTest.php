<?php

namespace Tests\Unit;

use App\Actions\CreateRide;
use App\Enums\RideStatus;
use App\Models\Ride;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateRideTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_ride()
    {
        // Criar um usuário fictício
        $requesterUser = User::factory()->create();

        // Definir os dados de "from" e "to"
        $from = 'Ponto A';
        $to = 'Ponto B';

        // Instanciar a action
        $createRideAction = new CreateRide();

        // Executar a action
        $ride = $createRideAction->handle($requesterUser, $from, $to);

        // Verificar se a ride foi criada corretamente
        $this->assertInstanceOf(Ride::class, $ride);
        $this->assertEquals($requesterUser->id, $ride->requester_user_id);
        $this->assertEquals($from, $ride->from);
        $this->assertEquals($to, $ride->to);
        $this->assertEquals(RideStatus::REQUESTED, $ride->status);
    }
}
