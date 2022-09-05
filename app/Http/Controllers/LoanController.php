<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;


class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loans = Loan::with('peminjam')->with('book')->get();

        return response()->json([
            'status' => 'success',
            'message' => "all of loans",
            'data' => $loans,
        ]);
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
        ]);

        $today = date("Y-m-d");

        $loanstoday = Loan::where('created_at', 'like', $today."%")->get();

        // id integer dari today, + incerement (urutan peminjaman keberapa di hari itu) get all loan di tgl peminjaman yang sama
        $validatedLoans["id"] = date("Ymd").Count($loanstoday)+1;
        // $validatedLoans["tgl_pengembalian"] = today+7 hari;
        $validatedLoans["tgl_pengembalian"] = date('Y-m-d', strtotime($today. ' + 7 days'));

        $validatedLoans["denda"] = 0;
        $validatedLoans["status_pengembalian"] = "belum";
        $validatedLoans["status_kesiapan_pinjam"] = "belum";    

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

        return response()->json($validatedLoans, 200);
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

    public function updateStatusPeminjaman(Request $request, $id)
    {
        $loan = Loan::find($id);

        if (is_null($loan)) {
            return response()->json([
                'status' => 'success',
                'message' => "$id loan not found"
            ], 404);
        }

        switch ($request->status) {
            case 1:
                $statusText = "Belum dipinjam";
                break;
            case 2:
                $statusText = "Dipinjam";
                break;
            case 3:
                $statusText = "Hilang";
                break;
            default:
                $statusText = false;
          }

        if (!$statusText) {
            return response()->json([
                'status' => 'failed',
                'message' => "status unrecogized"
            ], 400);
        }

        $loan->status_pengembalian = $statusText;

        $loan->save();

        return response()->json($loan, 200);
    }

    public function updateKesiapanPinjam(Request $request, $id)
    {
        $loan = Loan::find($id);

        if (is_null($loan)) {
            return response()->json([
                'status' => 'success',
                'message' => "$id loan not found"
            ], 404);
        }

        switch ($request->status) {
            case 1:
                $statusText = "Belum siap diambil";
                break;
            case 2:
                $statusText = "Siap diambil";
                break;
            case 3:
                $statusText = "Sudah diambil";
                break;
            default:
                $statusText = false;
          }

        if (!$statusText) {
            return response()->json([
                'status' => 'failed',
                'message' => "status unrecogized"
            ], 400);
        }

        $loan->status_kesiapan_pinjam = $statusText;

        $loan->save();

        return response()->json($loan, 200);
    }
}
