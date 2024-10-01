<?php

namespace App\Http\Controllers\Equipment;

use App\Http\Controllers\Controller;
use App\Models\Equipamento;
use Illuminate\Http\Response;

/**
 * @OA\Get(
 *     path="/api/equipamentos",
 *     summary="Listar todos os equipamentos",
 *     description="Retorna uma lista de todos os equipamentos disponíveis",
 *     tags={"Equipamentos"},
 *     @OA\Response(
 *         response=200,
 *         description="Lista de equipamentos",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1, description="ID do equipamento"),
 *                 @OA\Property(property="nome", type="string", example="Módulo", description="Nome do equipamento")
 *             )
 *         )
 *     )
 * )
 */
class GetAllEquipmentsController extends Controller
{
    public function __invoke()
    {
        return response()->json(Equipamento::all(), Response::HTTP_OK);
    }
}
