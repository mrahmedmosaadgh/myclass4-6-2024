<?php

namespace App\Http\Controllers\cs;

use App\Http\Controllers\Controller;
use App\Models\cs\c_mark;
use App\Models\cs\c_mark_total;
use App\Models\cs\c_semester;
use App\Models\cs\c_student;
use App\Models\cs\my_fun\calc_totals_m;
use App\Models\hrschooluser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
// use App\MyTrait\MyTrait;
// use App\Http\Controllers\cs\calc_totals_co;

// D:\laragon\www\old\lms\app\Http\Controllers\cs\calc_totals_co.php
class admin_semester_co extends Controller
{
    //
    // use MyTrait;
    public function admin_semester(Request $request)
    {

        $fun = isset($request->data['fun']) ? $request->data['fun'] : $request->fun;
        $my_id =  Auth::user()->id;

        //   return $request->all();



        if ($fun == 'get_school_students') {
            $school      = hrschooluser::where('user_id', Auth::user()->id)->with('my_school')->first();
            $c_students =  c_student::where('school_id', $school['school_id'])->get();
            return response()->json(['msg' => 'get_school_students has been loaded successfully.', 'data' =>  $c_students], 200);
        }



        if ($fun == 'calc_totals_m') {
            $semester_id = $request->semester_id;
            $school_id   = $request->school_id;
            $student    = $request->student;
            $student_id   = $request->student['student_id'];

            // foreach ($c_students as $key => $student) {
            // $student_id=$student['student_id'];
            if ($request->type == 'totals') {
                calc_totals_m::calc_totals_save($student_id, $semester_id, $school_id);
            }
            if ($request->type == 'order_class') {
                calc_totals_m::calc_semseter_student_order_class_save($student, $semester_id, $school_id);
            }
            if ($request->type == 'order_grade') {
                calc_totals_m::calc_semseter_student_order_grade_save($student, $semester_id, $school_id);
            }


            // }



            return c_mark_total::where('student_id', $student_id)->where('semester_id', $semester_id)->get();
            // return [$request->all()];
        }



        if ($fun == 'totals_found') {
            $school_id   = $request->school_id;
            $semester_id = $request->semester_id;

            $class_students            = c_student::where('school_id', $school_id)->with('my_class')->get();

            //  check if total marks missing ---------------------------------------------------
            $semester_class_mark_total_error = [];
            foreach ($class_students as $key2 => $student) {
                $semester_student_mark_total = c_mark_total::where('student_id', $student['student_id'])->where('semester_id', $semester_id)->first('total');

                if (!isset($semester_student_mark_total['total'])) {
                    array_push($semester_class_mark_total_error, ['error in total value:', $student]);
                }
            }

            if (count($semester_class_mark_total_error) > 0) {
                return response()->json(['msg' => 'semester_class_mark_total_error has been loaded  .', 'data' =>  $semester_class_mark_total_error], 200);
            } else {
                return response()->json(['msg' => 'no erorrs .', 'data' =>  $semester_class_mark_total_error], 200);
            }
            //  check if total marks missing ---------------------------------------------------


        }

        if ($fun == 'calc_totals_m_loop_all') {
            set_time_limit(1000);
            $semester_id = $request->semester_id;
            $school_id   = $request->school_id;
            // $student    = $request->student ;
            // $student_id   = $request->student['student_id'];
            $c_students =  c_student::where('school_id', $school_id)->get();
            $res1 = [];
            $res2 = [];
            $res3 = [];
            foreach ($c_students as $key => $student) {
                $student_id = $student['student_id'];
               
                     $res =   calc_totals_m::calc_totals_save($student_id, $semester_id, $school_id);
                    array_push($res1, $res );
 

                usleep(500);
            }

            usleep(500);

            foreach ($c_students as $key => $student) {
                $student_id = $student['student_id'];
 
                     $res  =     calc_totals_m::calc_semseter_student_order_class_save($student, $semester_id, $school_id);
                    array_push($res2, $res );
                
   
                usleep(500);
            }
            usleep(500);

            foreach ($c_students as $key => $student) {
           
               
                    $res =    calc_totals_m::calc_semseter_student_order_grade_save($student, $semester_id, $school_id);
                    array_push($res3, $res );
               

                usleep(500);
            }

            $c_mark_totals = c_mark_total::where('school_id', $school_id)->where('semester_id', $semester_id)->get();

            return response()->json([
                'msg' => 'success',
                // 'res1' =>  $res1,
                // 'res2' =>  $res2,
                // 'res3' =>  $res3,
                'data' =>  $c_mark_totals,
            ], 200);

            // return [$request->all()];
        }

        if ($fun == 'calc_totals_m_loop') {
            $semester_id = $request->semester_id;
            $school_id   = $request->school_id;
            // $student    = $request->student ;
            // $student_id   = $request->student['student_id'];
            $c_students =  c_student::where('school_id', $school_id)->get();
            $res = [];
            foreach ($c_students as $key => $student) {
                $student_id = $student['student_id'];
                if ($request->type == 'totals') {
                    $res1 =   calc_totals_m::calc_totals_save($student_id, $semester_id, $school_id);
                    array_push($res, $res1);
                }
                if ($request->type == 'order_class') {
                    $res1 =     calc_totals_m::calc_semseter_student_order_class_save($student, $semester_id, $school_id);
                    array_push($res, $res1);
                }
                if ($request->type == 'order_grade') {
                    $res1 =    calc_totals_m::calc_semseter_student_order_grade_save($student, $semester_id, $school_id);
                    array_push($res, $res1);
                }

                usleep(500);
            }

            $c_mark_totals = c_mark_total::where('school_id', $school_id)->where('semester_id', $semester_id)->get();

            return response()->json([
                'msg' => 'success',
                'res' =>  $res,
                'data' =>  $c_mark_totals,
            ], 200);

            // return [$request->all()];
        }
        if ($fun == 'create') {
            return $this->create_new_exam($request->data);
            // return $request->all();
        }
    }
}
