<?php

namespace App\Actions;

use App\Enums\RideStatus;
use App\Models\Ride;
use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\Concerns\AsAction;
use OpenApi\Annotations as OA;

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


    /**
     * @OA\Patch(
     *     path="/api/rides/{id}/cancel",
     *     operationId="cancel_ride",
     *     tags={"Rides (Corridas)"},
     *     summary="Cancelar corrida",
     *     description="Cancelar corrida existente",
     *     @OA\Parameter(
     *         name="id",
     *         description="ID da corrida",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Corrida cancelada",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Corrida não encontrada",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function asController($id): JsonResponse
    {
        $ride = Ride::findOrFail($id);

        return response()->json(
            $this->handle($ride),
            200
        );
    }
}
