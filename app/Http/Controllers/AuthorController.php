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
     * @return void
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
        return $this->successResponse(Author::all());
    }

    /**
     * Crea una instancia de Author
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $rules = [
            'name'=>'required|max:255',
            'gender'=>'required|max:255|in:male,female',
            'country'=>'required|max:255'
        ];

        $this->validate($request, $rules);

        $author = Author::create($request->all());

        return $this->successResponse($author, Response::HTTP_CREATED);

    }

    /**
     * Retorna un author especifico
     * @param  $author
     * @return JsonResponse
     */
    public function show($author)
    {
        $author = Author::findOrFail($author);

        return $this->successResponse($author, Response::HTTP_OK);
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
        $rules = [
            'name'=>'max:255',
            'gender'=>'max:255|in:male,female',
            'country'=>'max:255'
        ];

        $this->validate($request, $rules);

        $author = Author::findOrFail($author);

        $author->fill($request->all());

        if($author->isclean()){
            return $this->errorResponse('al menos un dato debe cambiar',
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $author->save();

        return $this->successResponse($author, Response::HTTP_OK);

    }

    /**
     * Retorna un author especifico
     * @param  $author
     * @return  Illuminate\Http\Response
     */
    public function destroy($author)
    {
        $author = Author::findOrFail($author);

        $author ->delete();

        return $this->successResponse($author, Response::HTTP_OK);

    }
}
