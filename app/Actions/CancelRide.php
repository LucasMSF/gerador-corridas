<?php

namespace App\Actions;

use App\Enums\RideStatus;
use App\Models\Ride;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use OpenApi\Attributes as OA;

class CancelRide
{
    use AsAction;

    public function handle(Ride $ride): Ride
    {
        $ride->status = RideStatus::CANCELED;
        $ride->canceled_at = now();
        $ride->save();

        return $ride;
    }


    #[OA\Patch(
        path: "/api/rides/{id}/cancel",
        operationId: "cancel_ride",
        tags: ["Rides (Corridas)"],
        summary: "Cancelar corrida",
        description: "Cancelar corrida existente",
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID da corrida",
                required: true,
                in: "path",
                schema: new OA\Schema(
                    type: "integer"
                )
            )
        ],
        responses: [
            new OA\Response(response: "200", description: "Corrida cancelada", content: new OA\JsonContent()),
            new OA\Response(response: "404", description: "Corrida não encontrada", content: new OA\JsonContent()),
        ]
    )]
    public function asController($id): mixed
    {
        $ride = Ride::findOrFail($id);

        return response()->json(
            $this->handle($ride),
            200
        );
    }
}
