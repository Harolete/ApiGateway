<?php

namespace App\Http\Controllers;

use App\Book;
use App\Services\AurhorService;
use App\Services\BookService;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class BookController extends Controller
{
    use ApiResponder;

    /**
     * El servicio para consumir AuthorService
     * @var
     */
    public $bookService;

    /**
     * El servicio para consumir AuthorService
     * @var
     */
    public $authorService;

    /**
     * Create a new controller instance.
     * @param BookService $bookService
     * @param AurhorService $authorService
     */
    public function __construct(BookService $bookService, AurhorService $authorService)
    {
        $this->bookService = $bookService;
        $this->authorService = $authorService;
    }

    /**
     * Retorna una lista de autores
     * @return JsonResponse
     */
    public function index()
    {
        return $this->successResponse($this->bookService->obtainBooks());
    }

    /**
     * Crea una instancia de Author
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->authorService->obtainAuthor($request->author_id);
        return $this->successResponse(
            $this->bookService->createBook($request->all()),
            Response::HTTP_CREATED);

    }

    /**
     * Retorna un author especifico
     * @param  $author
     * @return JsonResponse
     */
    public function show($author)
    {
        return $this->successResponse($this->bookService->obtainBook($author));
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
        return $this->successResponse($this->bookService->editBook($request->all(), $author));
    }

    /**
     * Retorna un author especifico
     * @param  $author
     * @return  Illuminate\Http\Response
     */
    public function destroy($author)
    {
        return $this->successResponse($this->bookService->deleteBook($author));

    }
}
