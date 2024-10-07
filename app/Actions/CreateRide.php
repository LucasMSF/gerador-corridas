<?php

namespace App\Actions;

use App\Enums\RideStatus;
use App\Models\Ride;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use OpenApi\Annotations as OA;

class CreateRide
{
    use AsAction;

    public function handle(User $requesterUser, string $from, string $to): Ride
    {
        $ride = new Ride();
        $ride->requester_user_id = $requesterUser->id;
        $ride->from = $from;
        $ride->to = $to;
        $ride->status = $to;
        $ride->status = RideStatus::REQUESTED;
        $ride->save();

        return $ride;
    }

    public function rules(): array
    {
        return [
            'requester_user_id' => ['required', 'exists:users,id'],
            'from' => ['required'],
            'to' => ['required'],
        ];
    }


    /**
     * @OA\Post(
     *     path="/api/rides",
     *     operationId="create_ride",
     *     tags={"Rides (Corridas)"},
     *     summary="Criar nova corrida",
     *     description="Criar/Solicitar nova corrida",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="requester_user_id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="from",
     *                     type="string",
     *                     example="Rua B, 456"
     *                 ),
     *                 @OA\Property(
     *                     property="to",
     *                     type="string",
     *                     example="Rua C, 560"
     *                 ),
     *                 required={"requester_user_id", "from", "to"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *          response="201", 
     *          description="Corrida criada", 
     *          @OA\JsonContent())
     * )
     */
    public function asController(ActionRequest $request): JsonResponse
    {
        $payload = $request->validated();
        $requesterUser = User::findOrFail($payload['requester_user_id']);

        return response()->json(
            $this->handle($requesterUser, $payload['from'], $payload['to']),
            201
        );
    }
}
