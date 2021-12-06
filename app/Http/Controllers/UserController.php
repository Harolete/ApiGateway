<?php
namespace App\Http\Controllers;

use App\User;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    use ApiResponder;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Retorna una lista de libros
     * @return JsonResponse
     */
    public function index()
    {
        return $this->validResponse(User::all());
    }

    /**
     * Crea una instancia de User
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $rules = [
            'name'      =>'required|max:255',
            'email'     =>'required|email|unique:users,email',
            'password'  =>'required|min:8|confirmed'
        ];
        $this->validate($request, $rules);

        $fields = $request->all();
        $fields['password']= Hash::make($request->password);
    var_dump($fields);
        $user = User::create($fields);

        return $this->successResponse($user, Response::HTTP_CREATED);

    }

    /**
     * Retorna un author especifico
     * @param  $author
     * @return JsonResponse
     */
    public function show($user)
    {
        $user = User::findOrFail($user);

        return $this->successResponse($user, Response::HTTP_OK);
    }

    /**
     * Modifica un authjor especifico
     * @param Request $request
     * @param  $author
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, $user)
    {
        $rules = [
            'name'      =>'max:255',
            'email'     =>'email|unique:users,email,'.$user,
            'password'  =>'min:8|confirmed'
        ];

        $this->validate($request, $rules);

        $user = User::findOrFail($user);

        $user->fill($request->all());

        if($request->has('password')){
            $user->password = Hash::make($request->password);

        }

        if($user->isclean()){
            return $this->errorResponse('al menos un dato debe cambiar',
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->save();

        return $this->successResponse($user, Response::HTTP_OK);

    }

    /**
     * Retorna un author especifico
     * @param  $author
     * @return JsonResponse
     */
    public function destroy($user)
    {
        $user = User::findOrFail($user);

        $user ->delete();

        return $this->successResponse($user, Response::HTTP_OK);

    }

    /**
     * Retorna un author especifico
     * @param  $author
     * @return JsonResponse
     */
    public function me(Request $request)
    {
        return $this->validResponse($request->user());
    }
}
