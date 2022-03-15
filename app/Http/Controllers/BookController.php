<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    //greet user
    public function bookAuth(){
        $data = "Welcome " . Auth::user()->name;
        return response()->json($data,200);
    }
    //greet user end

    //create data start
    public function store(Request $request){
        $validator = Validator::make($request->all(),
        [
            'book_name' => 'required',
            'author' => 'required',
            'desc' => 'required'
        ]);

        if($validator -> fails()){
            return Response() -> json($validator -> errors());
        }

        $store = Book::create([
            'book_name' =>$request->book_name,
            'author' => $request->author,
            'desc' => $request->desc
        ]);

        $data = Book::where('book_name', '=', $request->book_name)->get();
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
        return Book::all();
    }

    public function detail($id){
        if(DB::table('book')->where('id_book', $id)->exists()){
            $detail_book = DB::table('book')
            ->select('book.*')
            ->where('id_book', '=', $id)
            ->get();
            return Response() -> json($detail_book);
        }
        else{
            return Response() -> json(['message' => 'Could not find the data']);
        }
    }
    //read data end

    //update data start
    public function update($id, Request $request){
        $validator = Validator::make($request->all(),[
            'book_name' => 'required',
            'author' => 'required',
            'desc' => 'required'
        ]);

        if($validator -> fails()){
            return Response()-> json($validator->errors());
        }

        $update=DB::table('book')
        ->where('id_book', '=', $id)
        ->update(
            [
            'book_name' =>$request->book_name,
            'author' => $request->author,
            'desc' => $request->desc
        ]);

        $data=Book::where('id_book', '=', $id) ->get();
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
        $delete = DB::table('book')
        ->where('id_book', '=', $id)
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
