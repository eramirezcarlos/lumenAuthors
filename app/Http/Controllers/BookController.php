<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BookController extends Controller
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
     * Return the list of Books
     * @return Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $books = Book::all();

        if( $books->isEmpty()){
            return $this->errorResponse('Not found', Response::HTTP_NOT_FOUND);
        }

        return $this->successResponse($books);
    }

    /**
     * Create one new Book
     * @return Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $rules = [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'price' => 'required|min:1',
            'author_id' => 'required|min:1',
        ];

        $this->validate($request, $rules);

        $book = Book::create($request->all());

        return $this->successResponse($book, Response::HTTP_CREATED);

    }

    /**
     * Obtains and show one Book
     * @return Illuminate\Http\JsonResponse
     */
    public function show($book): JsonResponse
    {
        try {
            $book = Book::findOrFail($book);
            return $this->successResponse($book);
        }catch( ModelNotFoundException $e ){
            return $this->errorResponse('Book not found', Response::HTTP_NOT_FOUND);
        }

    }
    /**
     * Update an existing Book
     * @return Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $book): JsonResponse
    {
        $rules = [
            'title' => 'max:255',
            'description' => 'max:255',
            'price' => 'min:1',
            'author_id' => 'min:1',
        ];

        $this->validate($request, $rules);

        try{

            $book = Book::findOrFail($book);

            $book->fill($request->all());

            if ($book->isClean()) {              
                return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $book->save();

            return $this->successResponse($book);

        }catch( ModelNotFoundException $e ){
            return $this->errorResponse('Book not found', Response::HTTP_NOT_FOUND);
        }
                
    }
    /**
     * Remove an existing Book
     * @return Illuminate\Http\JsonResponse
     */
    public function destroy($book): JsonResponse
    {

        try {    
            $book = Book::findOrFail($book);

            $book->delete();

            return $this->successResponse($book);

        }catch( ModelNotFoundException $e ){
            return $this->errorResponse('Book not found', Response::HTTP_NOT_FOUND);
        }            

    }

}