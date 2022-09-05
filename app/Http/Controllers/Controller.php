<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function isValidLoan($id)    
    {
        $loan = Loan::find($id);
        if (is_null($loan)) {
            return response()->json([
                'status' => 'success',
                'message' => "$id loan not found"
            ], 404);
        }

        return $loan;

    }
}
