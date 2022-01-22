<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Student;
use DB;
class StudentController extends Controller
{
    public function index(){
        $students= Student::orderBy('id','DESC')->get();
        if($students){
            return response()->json([
                'message'=>"Data Found",
                'code'=>200,
                'data'=>$students
            ]);
        }
        else{
            return response()->json([
                'message'=>"Internal Server Error",
                'code'=>500
            ]);
        }
    }
    // public function index(){
    //     $students= Student::orderBy('id','DESC')->get();
    //     return view('admin/student',compact('students'));
    // }
    public function addStudent(Request $request){
        $student= new Student();
        $student->firstname=$request->firstname;
        $student->lastname=$request->lastname;
        $student->email=$request->email;
        $student->phone=$request->phone;
        $student->save();
        if($student){
            return response()->json([
                'message'=>"Data Inserted Successfully",
                'code'=>200
            ]);
        }
        else{
            return response()->json([
                'message'=>"Internal Server Error",
                'code'=>500
            ]);
        }
    }
    public function getStudentById(Request $request){
        $student=Student::where('id',$request->id)->first();
        if($student){
            return response()->json([
                'message'=>"Data Inserted Successfully",
                'code'=>200,
                'data'=>$student
            ]);
        }
        else{
            return response()->json([
                'message'=>"Internal Server Error",
                'code'=>500,
            
            ]);
        }
    }
    public function updateStudent(Request $request){
        $student=Student::find($request->id);
        $student->firstname=$request->firstname;
        $student->lastname=$request->lastname;
        $student->email=$request->email;
        $student->phone=$request->phone;
        $student->save();
        if($student){
            return response()->json([
                'message'=>"Data Update Successfully",
                'code'=>200,
            ]);
        }
        else{
            return response()->json([
                'message'=>"Internal Server Error",
                'code'=>500,
            
            ]);
        }
    }
    public function deleteStudent($id){
        $student=Student::find($id);
        $student->delete();
        if($student){
            return response()->json([
                'message'=>"Data Delete Successfully",
                'code'=>200,
            ]);
        }
        else{
            return response()->json([
                'message'=>"Internal Server Error",
                'code'=>500,
            
            ]);
        }
    }
    public function searchStudent(Request $request){
        if($request->ajax()){
                  $students=DB::table('students')->where('firstName','like','%'.$request->search.'%')
                                            ->orWhere('lastName','like','%'.$request->search.'%')
                                            ->orWhere('email','like','%'.$request->search.'%')
                                            ->orWhere('phone','like','%'.$request->search.'%')
                                            ->orderBy('id','desc')
                                            ->get();
            return response()->json(['data' => $students]);
        }

    }
}
