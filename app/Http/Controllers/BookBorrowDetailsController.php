<?php

namespace App\Http\Controllers;

use App\Models\BookBorrowDetails;
use App\Models\BookBorrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BookBorrowDetailsController extends Controller
{
    //read data start
    public function detail($id){
        $detail = BookBorrowDetails::where('id_book_borrow', $id)->with(['book'])->get();
        if($detail){
            return Response()->json($detail);
        }
        else{
            return Response()->json(['message'=>'Couldnt find the data']);
        }
    }
    //read data end
}
