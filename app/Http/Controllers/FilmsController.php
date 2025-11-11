<?php

namespace App\Http\Controllers;

use App\Models\Films;
use Illuminate\Http\Request;
use App\Http\Requests\FilmsRequest;

/**
 * @OA\Info(
 *     title="Films API",
 *     version="1.0",
 *     description="API dokumentáció a filmek kezeléséhez"
 * )
 */
class FilmsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/films",
     *     summary="Listázza az összes filmet",
     *     tags={"Films"},
     *     @OA\Response(
     *         response=200,
     *         description="Sikeres lekérés",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="films",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Film")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $films = Films::all();
        return response()->json([
            'films' => $films,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/films",
     *     summary="Új film létrehozása",
     *     tags={"Films"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/FilmInput")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Sikeresen létrehozva",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="film", ref="#/components/schemas/Film")
     *         )
     *     )
     * )
     */
    public function store(FilmsRequest $request)
    {
        $film = Films::create($request->all());

        return response()->json([
            'film' => $film,
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/films/{id}",
     *     summary="Film módosítása",
     *     tags={"Films"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="A film azonosítója",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/FilmInput")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sikeres frissítés",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="film", ref="#/components/schemas/Film")
     *         )
     *     )
     * )
     */
    public function update(FilmsRequest $request, $id)
    {
        $film = Films::findOrFail($id);
        $film->update($request->all());

        return response()->json([
            'film' => $film,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/films/{id}",
     *     summary="Film törlése",
     *     tags={"Films"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="A film azonosítója",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sikeres törlés",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Film deleted successfully"),
     *             @OA\Property(property="id", type="integer")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $film = Films::findOrFail($id);
        $film->delete();
        return response()->json([
            'message' => 'Film deleted successfully',
            'id' => $id
        ]);
    }
}

/**
 * @OA\Schema(
 *     schema="Film",
 *     type="object",
 *     title="Film adatai",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Inception"),
 *     @OA\Property(property="release_year", type="integer", example=2010),
 *     @OA\Property(property="director_id", type="integer", example=2)
 * )
 *
 * @OA\Schema(
 *     schema="FilmInput",
 *     type="object",
 *     required={"title", "director_id"},
 *     @OA\Property(property="title", type="string", example="Interstellar"),
 *     @OA\Property(property="release_year", type="integer", example=2014),
 *     @OA\Property(property="director_id", type="integer", example=1)
 * )
 */
