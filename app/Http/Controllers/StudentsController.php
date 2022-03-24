<?php

namespace App\Http\Controllers;

use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class StudentsController extends Controller
{
    //create data start
    public function store(Request $request){
        $validator = Validator::make($request->all(),
        [
            'student_name' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'id_class' => 'required' 
        ]);

        if($validator -> fails()){
            return Response() -> json($validator -> errors());
        }

        $store = Students::create([
            'student_name' => $request->student_name,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'address' => $request->address,
            'id_class' => $request->id_class
        ]);

        $data = Students::where('student_name', '=', $request->student_name)->get();
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

    //student profile
    public function UploadProfile(Request $request, $id){
        $validator = Validator::make($request->all(),
        [
            'student_profile' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        //define nama file yang akan di upload
        $imageName = time () .'.'. $request->student_profile->extension();

        //proses upload
        $request->student_profile->move(public_path('images'), $imageName);

        $update=Students::where('id_student',$id)->update([
            'image' => $imageName
        ]);

        $data = Students::where('id_student', '=', $id)-> get();

        if($update){
            return Response() -> json([
                'status' => 1,
                'message' => 'Succes upload student profile!',
                'data' => $data
            ]);
        } else 
        {
            return Response() -> json([
                'status' => 0,
                'message' => 'Failed upload student profile!'
            ]);
        }
    }
    //student profile

    //read data start
    public function show(){
        return Students::all();
    }

    public function detail($id){
        if(DB::table('students')->where('id_student', $id)->exists()){
            $detail_student = DB::table('students')
            ->select('students.*')
            ->where('id_student', '=', $id)
            ->get();
            return Response() -> json($detail_student);
        }
        else{
            return Response() -> json(['message' => 'Could not find the data']);
        }
    }
    //read data end

    //update data start
    public function update($id, Request $request){
        $validator = Validator::make($request->all(),[
            'student_name' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'id_class' => 'required'   
        ]);

        if($validator -> fails()){
            return Response()-> json($validator->errors());
        }

        $update=DB::table('students')
        ->where('id_student', '=', $id)
        ->update(
            [
            'student_name' => $request->student_name,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'address' => $request->address,
            'id_class' => $request->id_class
        ]);

        $data=Students::where('id_student', '=', $id) ->get();
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
        $delete = DB::table('students')
        ->where('id_student', '=', $id)
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
