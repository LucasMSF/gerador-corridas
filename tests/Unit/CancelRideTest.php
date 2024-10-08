<?php

namespace Tests\Unit;

use App\Actions\CancelRide;
use App\Enums\RideStatus;
use App\Models\Ride;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CancelRideTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_cancels_a_ride()
    {
        // Criar uma instância de Ride no banco de dados
        $ride = Ride::factory()
            ->for(User::factory(), 'requesterUser')
            ->create([
                'status' => RideStatus::REQUESTED,
                'canceled_at' => null,
            ]);

        // Instanciar a action
        $cancelRideAction = new CancelRide();

        // Executar a action
        $ride = $cancelRideAction->handle($ride);

        // Verificar se o status foi alterado para "CANCELED"
        $this->assertEquals(RideStatus::CANCELED, $ride->status);
        // Verificar se o campo "canceled_at" foi preenchido com a data atual
        $this->assertNotNull($ride->canceled_at);
    }
}
