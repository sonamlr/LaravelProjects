<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
class StudentController extends Controller
{
    function index(){
        return Student::all();
    }
    function get_student(Request $request, $id){
        return Student::find($id);
    }
    function student_save(Request $request){
        $request->validate([
            'name'=> 'required',
            'city' => 'required',
            'fees' => 'required',
        ]);
        $student =  Student::create($request->all());
        return response()->json([
            'message' => 'Student created successfully!',
            'data'    => $student
        ], 201);
    }
    function update_student(Request $request, $id){
        $request->validate([
            'name'=> 'required',
            'city' => 'required',
            'fees' => 'required',
        ]);

        $student = Student::find($id);
        if (!$student){
            return response()->json([
                'error'=> 'Student not Found',
            ], 404);
        }
        $student->update([
            'name' => $request->name,
            'city' => $request->city,
            'fees' => $request->fees,
        ]);
        return response()->json([
            'message' => 'Student Update Successfully',
            'data' => $student,
        ]);
    }
    function delete_student(Request $request, $id){
        $student = Student::find($id);
        if (!$student){
            return response()->json([
                'error'=> 'Student not Found',
            ], 404);
        }
        $student->delete();
        return response()->json([
            'message' => 'Student Deleted Successfully',
            'data' => $student,
        ], 200);
    }

}