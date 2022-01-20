<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use DB;
class StudentController extends Controller
{
    public function index(){
        $students= Student::orderBy('id','DESC')->get();
        return view('admin/student',compact('students'));
    }
    public function addStudent(Request $request){
        $student= new Student();
        $student->firstname=$request->firstname;
        $student->lastname=$request->lastname;
        $student->email=$request->email;
        $student->phone=$request->phone;
        $student->save();
        return response()->json($student);
    }
    public function getStudentById($id){
        $student=Student::find($id);
        return response()->json($student);
    }
    public function updateStudent(Request $request){
        $student=Student::find($request->id);
        $student->firstname=$request->firstname;
        $student->lastname=$request->lastname;
        $student->email=$request->email;
        $student->phone=$request->phone;
        $student->save();
        return response()->json($student);
    }
    public function deleteStudent($id){
        $student=Student::find($id);
        $student->delete();
        return response()->json(['success'=>'Record has been deleted!']);
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
