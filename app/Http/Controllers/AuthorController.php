<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthorController extends Controller
{
    use ApiResponser;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Return the list of Authors
     * @return Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $authors = Author::all();

        if( $authors->isEmpty()){
            return $this->errorResponse('Not found', Response::HTTP_NOT_FOUND);
        }

        return $this->successResponse($authors);
    }

    /**
     * Create one new Author
     * @return Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $rules = [
            'name' => 'required|max:255',
            'gender' => 'required|max:255',
            'country' => 'required|min:1'
        ];

        $this->validate($request, $rules);

        $author = Author::create($request->all());

        return $this->successResponse($author, Response::HTTP_CREATED);

    }

    /**
     * Obtains and show one Author
     * @return Illuminate\Http\JsonResponse
     */
    public function show($author): JsonResponse
    {
        try {
            $author = Author::findOrFail($author);
            return $this->successResponse($author);
        }catch( ModelNotFoundException $e ){
            return $this->errorResponse('Author not found', Response::HTTP_NOT_FOUND);
        }

    }
    /**
     * Update an existing Author
     * @return Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $author): JsonResponse
    {
        $rules = [
            'name' => 'required|max:255',
            'gender' => 'required|max:255',
            'country' => 'required|min:1'
        ];

        $this->validate($request, $rules);

        try{

            $author = Author::findOrFail($author);

            $author->fill($request->all());

            if ($author->isClean()) {              
                return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $author->save();

            return $this->successResponse($author);

        }catch( ModelNotFoundException $e ){
            return $this->errorResponse('Author not found', Response::HTTP_NOT_FOUND);
        }
                
    }
    /**
     * Remove an existing Author
     * @return Illuminate\Http\JsonResponse
     */
    public function destroy($author): JsonResponse
    {

        try {    
            $author = Author::findOrFail($author);

            $author->delete();

            return $this->successResponse($author);

        }catch( ModelNotFoundException $e ){
            return $this->errorResponse('Author not found', Response::HTTP_NOT_FOUND);
        }            

    }

}