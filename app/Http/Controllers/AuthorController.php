<?php

namespace App\Http\Controllers;

use App\Author;
use App\Services\AurhorService;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class AuthorController extends Controller
{
    use ApiResponder;

    /**
     * El servicio para consumir AuthorService
     * @var
     */
    public $authorService;

    /**
     * Create a new controller instance.
     *
     * @param AurhorService $authorService
     */
    public function __construct(AurhorService $authorService)
    {
        $this->authorService = $authorService;
    }

    /**
     * Retorna una lista de autores
     * @return JsonResponse
     */
    public function index()
    {
        return $this->successResponse($this->authorService->obtainAuthors());
    }

    /**
     * Crea una instancia de Author
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        return $this->successResponse(
            $this->authorService->createAuthor($request->all()),
            Response::HTTP_CREATED);

    }

    /**
     * Retorna un author especifico
     * @param  $author
     * @return JsonResponse
     */
    public function show($author)
    {
        return $this->successResponse($this->authorService->obtainAuthor($author));
    }

    /**
     * Modifica un authjor especifico
     * @param Request $request
     * @param  $author
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, $author)
    {
        return $this->successResponse($this->authorService->editAuthor($request->all(), $author));
    }

    /**
     * Retorna un author especifico
     * @param  $author
     * @return  Illuminate\Http\Response
     */
    public function destroy($author)
    {
        return $this->successResponse($this->authorService->deleteAuthor($author));

    }
}
