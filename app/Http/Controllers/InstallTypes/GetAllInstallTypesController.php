<?php

namespace App\Http\Controllers\InstallTypes;

use App\Http\Controllers\Controller;
use App\Models\TipoInstalacao;
use Illuminate\Http\Response;

/**
 * @OA\Get(
 *     path="/api/tipos-instalacao",
 *     summary="Listar todos os tipos de instalação",
 *     description="Retorna uma lista de todos os tipos de instalação disponíveis",
 *     tags={"Tipos de Instalação"},
 *     @OA\Response(
 *         response=200,
 *         description="Lista de tipos de instalação",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=1, description="ID do tipo de instalação"),
 *                 @OA\Property(property="nome", type="string", example="Fibrocimento (Madeira)", description="Nome do tipo de instalação")
 *             )
 *         )
 *     )
 * )
 */
class GetAllInstallTypesController extends Controller
{
    public function __invoke()
    {
        return response()->json(TipoInstalacao::all(), Response::HTTP_OK);
    }
}
