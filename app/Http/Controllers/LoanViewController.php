<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;


class LoanViewController extends Controller
{

    public function index()
    {
        $loans = Loan::with('peminjam')->with('book')->get();

        return view('loans', ["loans"=>$loans]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
     {
        $validatedLoans = $request->validate([
            "peminjam_id"       =>  "required|string",
            "book_id"           =>  "required|string",
            "tgl_pengembalian"    => "required",
        ]);

        // id integer dari today, + incerement (urutan peminjaman keberapa di hari itu) get all loan di tgl peminjaman yang sama
        // tambahin kolom tgl_peminjaman 

        // $validatedLoans["tgl_pengembalian"] = today+7 hari;
        $validatedLoans["denda"] = 0;
        $validatedLoans["status_pengembalian"] = "belum";
        $validatedLoans["status_kesiapan_pinjam"] = "belum";    

        //tanggl pengembalian itu otomatis apa diatur sendiri?

        Loan::Create($validatedLoans);

        return response()->json($validatedLoans, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $loan = $this->isValidLoan($id); //bug
        
        $loan = Loan::find($id);

        if (is_null($loan)) {
            return response()->json([
                'status' => 'success',
                'message' => "$id loan not found"
            ], 404);
        }

        $user = User::find($loan->peminjam_id)->first();

        $book = Book::find($loan->book_id)->first();

        $loan->user = $user;
        $loan->book = $book;

        return response()->json([
            'status' => 'success',
            'message' => "$loan->id loan detail",
            'data' => $loan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //     $table->bigInteger('peminjam_id');
        //     $table->bigInteger('book_id');
        //     $table->date('tgl_pengembalian');
        //     $table->integer('denda');
        //     $table->string('status_pengembalian');
        //     $table->string('status_kesiapan_pinjam');

        $loan = $this->isValidLoan($id);

        $validatedLoans = $request->validate([
            "peminjam_id"       =>  "nullable|string",
            "book_id"           =>  "nullable|string",
            "tgl_pengembalian"  =>  "nullable",
        ]);

        if ($validatedLoans["peminjam_id"]) {
            $loan->peminjam_id = $validatedLoans["peminjam_id"];
        }
        if ($validatedLoans["book_id"]) {
            $loan->book_id = $validatedLoans["book_id"];
        }
        if ($validatedLoans["tgl_pengembalian"]) {
            $loan->tgl_pengembalian = $validatedLoans["tgl_pengembalian"];
        }

        $loan->save();

        return response()->json($validatedLoans, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $loan = $this->isValidLoan($id);

        $loan->delete();

        return response()->json([
            'status' => 'success',
            'message' => "$loan->id has been deleted"
        ]);
    }
}
