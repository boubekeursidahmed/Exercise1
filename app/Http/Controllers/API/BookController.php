<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::paginate(10);
        
        return response()->json([
            'status' => 200,
            'data' => $books
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:4000',
            'author' => 'required|string|max:4000',
            'pulication_year' => 'required|date|max:4000',
            'isnb' => 'required|string|max:4000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $book = Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'pulication_year' => $request->pulication_year,
            'isnb' => $request->isnb,
        ]);

        return response()->json([
            'status' => 200,
            'state' => 'Book added'
        ]);
    }
 
    public function show($id)
    {
        $book = Book::find($id);

        if(empty($book)){
            return response()->json([
                'status' => 404,
                'state' => 'book not found'
            ]);
        };
        
        return response()->json([
            'status' => 200,
            'data' => $book
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:4000',
            'author' => 'required|string|max:4000',
            'pulication_year' => 'required|date|max:4000',
            'isnb' => 'required|string|max:4000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $book = Book::find($id);
        if(empty($book)){
            return response()->json([
                'status' => 404,
                'state' => 'book not found'
            ]);
        };

        $book->update([
            'title' => $request->title,
            'author' => $request->author,
            'pulication_year' => $request->pulication_year,
            'isnb' => $request->isnb,
        ]);

        return response()->json([
            'status' => 200,
            'data' => $book
        ]);
    }

    public function destroy($id)
    {
        $book = Book::find($id);
        if(empty($book)){
            return response()->json([
                'status' => 404,
                'state' => 'book not found'
            ]);
        };
        $book->delete();

        return response()->json([
            'status' => 200,
            'state' => 'book deleted'
        ], 200);
    }
}
