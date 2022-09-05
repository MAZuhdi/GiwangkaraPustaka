<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookViewController extends Controller
{

    public function index()
    {
        $books = Book::all();

        return view('books', compact("books"));
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBookRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedBook = $request->validate([
            'kode' => 'required|unique:books',
            'judul' => 'required',
            'penulis' => 'required|string',
            'penulis_tambahan' => 'string',
            'penerbit' => 'string',
            'kelas' => 'string',
            'rak' => 'required',
            'jurusan' => 'string',
            'tags' => 'string',
            'abstrak' => 'string',
            'tahun_terbit' => 'integer',
            'cover' => 'file|image|mimes:jpeg,png,jpg|max:2048',
            'kategori' => 'string',
        ]);

        $validatedBook['kode_panggil'] = $validatedBook['rak'].'.'.$validatedBook['kode'];        

        if ($files = $request->file('cover')) {
            $destinationPath = 'image/bookcover/'; // upload path
            $coverImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $validatedBook['cover'] = $destinationPath."".$coverImage;
            $files->move($destinationPath, $coverImage);
        } else {
            $validatedBook['cover']= "https://dummyimage.com/852x480/15748f/ffffff&text=".$validatedBook['judul'];
        }

        Book::create($validatedBook);

        return response()->json($validatedBook, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::find($id);

        if (is_null($book)) {
            return response()->json([
                'status' => 'success',
                'message' => "$id book not found"
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => "$book->kode book detail",
            'data' => $book
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBookRequest  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if (is_null($book)) {
            return response()->json([
                'status' => 'success',
                'message' => "$id book not found",
                'data' => null
            ], 404);
        }

        $validatedBook = $request->validate([
            'kode' => 'required|unique:books,kode,'.$book->id,
            'judul' => 'required',
            'penulis' => 'required|string',
            'penulis_tambahan' => 'string',
            'penerbit' => 'string',
            'kelas' => 'string',
            'rak' => 'required',
            'jurusan' => 'string',
            'tags' => 'string',
            'abstrak' => 'string',
            'tahun_terbit' => 'integer',
            'cover' => 'file|image|mimes:jpeg,png,jpg|max:2048',
            'kategori' => 'string',
        ]);

        $validatedBook['kode_panggil'] = $validatedBook['rak'].'.'.$validatedBook['kode'];        

        if (!$book->cover) {
            if ($files = $request->file('cover')) {
                $destinationPath = 'image/bookcover/'; // upload path
                $coverImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
                $validatedBook['cover'] = $destinationPath."".$coverImage;
                $files->move($destinationPath, $coverImage);
            } else {
                $validatedBook['cover']= "https://dummyimage.com/852x480/15748f/ffffff&text=".$validatedBook['judul'];
            }
        }
    
        Book::where('kode',$book->kode)->update($validatedBook);

        return response()->json($validatedBook, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);

        if (is_null($book)) {
            return response()->json([
                'status' => 'success',
                'message' => "$id book not found",
            ], 404);
        }

        $book->delete();

        return response()->json([
            'status' => 'success',
            'message' => "$book->kode has been deleted"
        ]);
    }
}
