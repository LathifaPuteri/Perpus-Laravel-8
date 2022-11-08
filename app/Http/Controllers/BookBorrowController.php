<?php

namespace App\Http\Controllers;

use App\Models\BookBorrow;
use App\Models\BookBorrowDetails;
use App\Models\BookReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class BookBorrowController extends Controller
{
    //add item for bookborrowdetails
    public function addItem(Request $request, $id_book_borrow)
    {
        $validator = Validator::make($request->all(),[
            'id_book' => 'required',
            'qty' => 'required'
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $save = BookBorrowDetails::create([
            'id_book_borrow' => $id_book_borrow,
            'id_book' => $request->id_book,
            'qty' => $request->qty
        ]);
        if($save){
            return Response() -> json([
                'status' => 1,
                'message' => 'Success add item!',
            ]);
        }else {
            return Response() -> json([
                'status' => 0,
                'message' => 'Failed add item!'
            ]);
        }
    }
    //addItem end

    //create data start
    public function store(Request $request){
        $validator = Validator::make($request->all(),
        [
            'id_student' => 'required',
            'date_of_returning'  => 'required',
            'detail' =>'required'
        ]);

        if($validator -> fails()){
            return Response() -> json($validator -> errors());
        }

        //input transaksi dulu
        $borrow = new BookBorrow();
        $borrow->id_student = $request->id_student;
        $borrow->date_of_borrowing = date("Y-m-d");
        $borrow->date_of_returning = $request->date_of_returning;
        $borrow->save();

        //$book->id_book_borrow

        //insert detail peminjaman
        for($i = 0; $i < count($request->detail); $i++){
            $borrow_detail = new BookBorrowDetails();
            $borrow_detail->id_book_borrow = $borrow->id_book_borrow;
            $borrow_detail->id_book = $request->detail[$i]['id_book'];
            $borrow_detail->qty = $request->detail[$i]['qty'];
            $borrow_detail->save();
        }

        if($borrow && $borrow_detail){
            return Response() -> json([
                'status' => 1,
                'message' => 'Success!'
            ]);
        } 
        else{
            return Response() -> json([
                'status' => 0,
                'message' => 'Failed!'
            ]);
        }

        // $store = BookBorrow::create([
        //     'id_student' => $request->id_student,
        //     'date_of_borrowing' => $request->date_of_borrowing,
        //     'date_of_returning' => $request->date_of_returning
        // ]);

        // $data = BookBorrow::where('id_student', '=', $request->id_student)->get();
        // if($store){
        //     return Response() -> json([
        //         'status' => 1,
        //         'message' => 'Succes create new data',
        //         'data' => $data
        //     ]);
        // } 
        // else{
        //     return Response() -> json([
        //         'status' => 0,
        //         'message' => 'Failed create new data'
        //     ]);
        // }
    }
    //create data end

    //read data start
    public function show(){
        $data = DB::table('book_borrow')
            ->join('students', 'students.id_student', '=' , 'book_borrow.id_student')
            ->join('grade', 'grade.id_class', '=' , 'students.id_class')
            ->select('book_borrow.id_book_borrow', 'book_borrow.id_student', 'students.student_name', 'book_borrow.date_of_borrowing', 'book_borrow.date_of_returning', 'grade.class_name', 'grade.group')
            ->whereNotIn('id_book_borrow', function($query){
                $query -> select('id_book_borrow')
                ->from('book_return');
            })
            ->orderBy('id_book_borrow')
            ->get();

            $result = [];
            for($i = 0; $i <count($data); $i++){
                $result[$i]['id_book_borrow'] = $data[$i] -> id_book_borrow;
                $result[$i]['student_name'] = $data[$i] -> student_name;
                $result[$i]['class_name'] = $data[$i] -> class_name;
                $result[$i]['group'] = $data[$i] -> group;
                $result[$i]['date_of_borrowing'] = $data[$i] -> date_of_borrowing;
                $result[$i]['date_of_returning'] = $data[$i] -> date_of_returning;

                $status = '';
                $current_date = Carbon::parse(date('Y-m-d'));
                $return_date = $data[$i] -> date_of_returning;
                if(strtotime($current_date) > strtotime($return_date)){
                    $status = 'Late';
                } else {
                    $status = 'On Schedule';
                }
                $result[$i]['status'] = $status;
            }
        return Response()->json($result);
    }

    public function detail($id){
        if(DB::table('book_borrow')->where('id_book_borrow', $id)->exists()){
            $detail_book_borrow = DB::table('book_borrow')
            ->select('book_borrow.id_book_borrow', 'book_borrow.id_student', 'students.student_name', 'book_borrow.date_of_borrowing', 'book_borrow.date_of_returning')
            ->join('students', 'students.id_student', '=', 'book_borrow.id_student')
            ->where('id_book_borrow', $id)
            ->get();
            return Response()->json($detail_book_borrow);
        }
        else{
            return Response() -> json(['message' => 'Could not find the data']);
        }
    }
    //read data end

    //update data start
    public function update($id, Request $request){
        $validator = Validator::make($request->all(),[
            'id_student' => 'required',
            'date_of_borrowing' => 'required',
            'date_of_returning'  => 'required'
        ]);

        if($validator -> fails()){
            return Response()-> json($validator->errors());
        }

        $update=DB::table('book_borrow')
        ->where('id_book_borrow', '=', $id)
        ->update(
            [
            'id_student' => $request->id_student,
            'date_of_borrowing' => $request->date_of_borrowing,
            'date_of_returning' => $request->date_of_returning
        ]);

        $data=BookBorrow::where('id_book_borrow', '=', $id) ->get();
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
        $delete = DB::table('book_borrow')
        ->where('id_book_borrow', '=', $id)
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
