<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::latest()->paginate(8);
        
        return response(['books' => BookResource::collection($books), 'message' => 'Berhasil'], 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'title' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'published' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Pastikan data yang anda masukkan benar!']);
        }

        $book = Book::create($data);

        return response(['book' => new BookResource($book), 'message' => 'Berhasil dibuat'], 201);
    }

    public function show(Book $book)
    {
        return response(['book' => new BookResource($book), 'message' => 'Berhasil'], 200);
    }

    public function update(Request $request, Book $book)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'title' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'published' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Pastikan data yang anda masukkan benar!']);
        }

        $book->update($data);

        return response(['book' => new BookResource($book), 'message' => 'Berhasil diupdate'], 200);
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return response(['message' => 'Buku berhasil dihapus']);
    }
}
