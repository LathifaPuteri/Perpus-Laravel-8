<?php

namespace App\Http\Controllers;

use App\Models\BookBorrowDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BookBorrowDetailsController extends Controller
{
    //create data start
    public function store(Request $request){
        $validator = Validator::make($request->all(),
        [
            'id_book_borrow' => 'required',
            'id_book' => 'required',
            'qty' => 'required'
        ]);

        if($validator -> fails()){
            return Response() -> json($validator -> errors());
        }

        $store = BookBorrowDetails::create([
            'id_book_borrow' => $request->id_book_borrow,
            'id_book' => $request->id_book,
            'qty' => $request->qty
        ]);

        $data = BookBorrowDetails::where('id_book_borrow', '=', $request->id_book_borrow)->get();
        if($store){
            return Response() -> json([
                'status' => 1,
                'message' => 'Succes create new data',
                'data' => $data
            ]);
        } 
        else{
            return Response() -> json([
                'status' => 0,
                'message' => 'Failed create new data'
            ]);
        }
    }
    //create data end

    //read data start
    public function show(){
        return BookBorrowDetails::all();
    }

    public function detail($id){
        if(DB::table('book_borrow_details')->where('id_book_borrow_detail', $id)->exists()){
            $detail = DB::table('book_borrow_details')
            ->select('book_borrow_details.*')
            ->join('book_borrow', 'book_borrow.id_book_borrow', '=', 'book_borrow_details.id_book_borrow')
            ->join('book', 'id_book.book', '=', 'book_borrow_details.id_book')
            ->get();
            return Response()->json($detail);
        }
        else{
            return Response() -> json(['message' => 'Could not find the data']);
        }
    }
    //read data end

    //update data start
    public function update($id, Request $request){
        $validator = Validator::make($request->all(),[
            'id_book_borrow' => 'required',
            'id_book' => 'required',
            'qty' => 'required'
        ]);

        if($validator -> fails()){
            return Response()-> json($validator->errors());
        }

        $update=DB::table('book_borrow_details')
        ->where('id_book_borrow_detail', '=', $id)
        ->update(
            [
            'id_book_borrow' => $request->id_book_borrow,
            'id_book' => $request->id_book,
            'qty' => $request->qty
        ]);

        $data=BookBorrowDetails::where('id_book_borrow_detail', '=', $id) ->get();
        if($update){
            return Response() ->json([
                'status' => 1,
                'message' => 'Success updating data',
                'data' => $data  
            ]);
        }
        else{
            return Response() -> json([
                'status' => 0,
                'message' => 'Failed updating data'
            ]);
        }
    }
    //update data end

    //delete data start
    public function delete($id){
        $delete = DB::table('book_borrow_details')
        ->where('id_book_borrow_detail', '=', $id)
        ->delete();

        if($delete){
            return Response() -> json([
                'status' => 1,
                'message' => 'Succes delete data'
            ]);
        }
        else{
            return Response() -> json([
                'status' => 0,
                'message' => 'Failed delete data'
        ]);
        }
    }
    //delete data end
}
