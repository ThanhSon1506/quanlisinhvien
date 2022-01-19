<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
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
}