<?php

namespace App\Http\Controllers\cs;

use App\Http\Controllers\Controller;
use App\Models\c_attend_meeting;
use App\Models\cs\c_class;
use App\Models\cs\c_grade;
use App\Models\cs\c_mark;
use App\Models\cs\c_mark_grade_letter;
use App\Models\cs\c_mark_sum;
use App\Models\cs\c_mark_total;
use App\Models\cs\c_semester;
use App\Models\cs\c_student;
use App\Models\cs\c_subject;
use App\Models\cs\c_subject_class_tea;
use App\Models\cs\c_subject_title;
use App\Models\cs\c_subject_title_sum;
use App\Models\cs\my_fun\c_semester_report_m;
use App\Models\cs\my_fun\school_semester_students_marks_get_m;
use App\Models\hrschool;
use App\Models\hrschooluser;
use App\Models\hrstudentdata;
use App\Models\hruserdata;
use App\Models\hryear;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class c_semester_report_co extends Controller
{
    //

    public function c_semester_report(Request $request)
    {
        $fun = null;
        if (isset($request->data['fun'])) {
            $fun = $request->data['fun'];
        } else {
            $fun = $request['fun'];
        }
        $my_id =  Auth::user()->id;

        if ($fun == 'get_class_students') {
            $school_id = $request->school_id;
            $class_id = $request->class_id;
            //  $school_semester_students_marks_get_m=school_semester_students_marks_get_m::school_semester_students_marks_get_one_class( $student, $c_class, $subject, $semester_id, $school_id );
            $my_students = c_student::where('school_id', $school_id)->where('class_id', $class_id)->where('deleted', 0)->get();







            // $client = new Client();
            // $responseData = null;
            // try {
                
            //     $response = $client->post('http://127.0.0.1:8000/api/broadcast', [
            //         // $response = $client->post('https://examsys.cubes.academy/api/broadcast', [
            //         // $response = $client->post('https://examsys.cubes.academy/api/attend', [
            //         'json' => $my_students,
            //     ]);
    
            //     if ($response->getStatusCode() === 200) {
            //         // Data sent successfully! Handle the response here
            //     //   return  $responseData = 'json_decode($response->getBody(), true)';
            //       return  $responseData = json_decode($response->getBody(), true);
            //         // Process the response data as needed (e.g., display success message)
            //     } else {
            //         // Handle unsuccessful response
            //       return  $responseData = $response->getBody()->getContents();
            //         // $errorMessage = $response->getBody()->getContents();
            //         // Log the error or display an error message to the user
            //     }
            // } catch (Exception $e) {
            //   return  $responseData =$e;

            //     // Handle exceptions during the request
            //     // Log the error or display an error message to the user
            // }










            return response()->json(['msg' => ' get_class_students _________________________+++++++++++==========ok',
             'data' =>  $my_students,
            //  'res' =>  $responseData,
            ], 200);
        }














// __________________________________________________________________________________
        if ($fun == 'school_semester_students_marks_get_one_class') {
             $school_id = $request->school_id;
             $class_id = $request->class_id;
            //  $school_semester_students_marks_get_m=school_semester_students_marks_get_m::school_semester_students_marks_get_one_class( $student, $c_class, $subject, $semester_id, $school_id );
            //  if ($fun == 'school_semester_students_marks_get') {
            $marks = [];
            // $semester_id = $request->semester_id;
            $active_year = hryear::where('admin_id', Auth::user()->admin_id)->where('active', 1)->first();
            $year_id = $active_year['id'];

            $c_semesters = c_semester::where('school_id', $school_id)->where('year_id', $year_id)->get();
            // $number_per_time = $request->number_per_time;
            // $index = $request->index;
            // $school_id = $request->school_id;
            // $semester  = $c_semesters[0];
            // $semester_id = $c_semesters[0]['id'];
            
            // $skip_number = $request->number_per_time * ($request->index - 1);
            // school_semester_students_marks_get
            //get class id////////////////////////










            // $classes = c_class::where('school_id', $school_id)->get();
            // $index = 0;
            // $c_class = $classes[$index];
            // $class_id = $c_class['id'];




$c_class = c_class::where('school_id', $school_id)->where('id', $class_id)->first();


            $c_subject_class_tea = c_subject_class_tea::where('class_id', $class_id)->with('my_subject')->get();
            $data_to_xls = [];
            $my_data = [];

            foreach ($c_subject_class_tea as $key1 => $subject) { //subject //ok111111111111111111111111111111
                //    return $subject;
                $subject_id = $subject['subject_id'];
                $hrstudentdata =  c_student::where('school_id', $school_id)
                    ->where('class_id', $class_id)
                    ->with('my_school')
                    ->get();
                $data_to_xls = [];

                foreach ($hrstudentdata as $key2 => $student) { //student //2222
                    $data_to_xls =  school_semester_students_marks_get_m::semester_all_final_data_to_noor_one_student($student, $c_class, $subject, $c_semesters, $school_id);

                    array_push($my_data, $data_to_xls);
                } //student
            } //subject
            // $students = c_student::where('class_id', $class_id)->get();

            // $my_data[0]['students']=$students;


            $students = c_student::where('class_id', $class_id)->where('deleted', 0)->get();
           
            
            $re1_head =   c_semester_report_m::re1_head($school_id);
            $semester_id=   c_semester::where('school_id',$school_id)->where('active',1)->first()->id;
            $re2_title =   c_semester_report_m::re2_title($class_id, $semester_id);
            
            $my_data[0]['students']=$students;
            $my_data[0]['re1_head']=$re1_head;
            $my_data[0]['re2_title']=$re2_title;


            return response()->json(['msg' => ' get_final_report_settings ok____________________', 'data' =>  $my_data], 200);
        }













        if ($fun == 'del_me') {

// User::where('id',1)->delete();
$userId=57;
$user = User::find($userId);
$user->update(['admin_id'=>57 ]);


// $sql = "UPDATE users SET admin_id = 11111 WHERE id = ?"; // Prepared statement
//         $updated = DB::update($sql, [$userId]);



// $user->delete();
            return response()->json(['msg' => ' del_me ok', 'data' =>  'del_me'], 200);

        }






        if ($fun == 'save_student_nor_ar_id') {

            $data            = $request->data ;

            // $student_nor     =$data['student_nor'];
            // $nor_national_id =null;
            // $nor_ar          =null;
            if(isset($request->data['student_id'])){$student_id      = $request->data['student_id'];}else{return 'error student_id';}
            if(isset($data['new_nor_national_id'])){$nor_national_id=$data['new_nor_national_id'];}else{return 'error nor_national_id';}
            // if(isset($data['student_nor'])){$student_nor=$data['student_nor'];}else{return 'error student_nor';}
            // if(isset($student_nor['nor_national_id'])){$nor_national_id =$student_nor['nor_national_id'];}else{return 'error nor_national_id';}
            if(isset($data['new_nor_ar'])){$nor_ar=$data['new_nor_ar'];}else{return 'error nor_ar';}
            

       


           
                $data_to_db = [
                    // 'ar' => $nor_ar,
                    // 'national_id' => $nor_national_id,

                    'nor_ar'          => $nor_ar,
                    'nor_national_id' => $nor_national_id,
                ];
                c_student::where('student_id', $student_id)->update($data_to_db);




                $save_national_id =$request->save_national_id;
                $save_ar          =$request->save_ar;
                if($save_national_id){
                    $data_to_db = [
                        // 'ar' => $nor_ar,
                        'national_id' => $nor_national_id,
                    ];
                    c_student::where('student_id', $student_id)->update($data_to_db);
      
                }

                if($save_ar){
                    $data_to_db = [
                        'ar' => $nor_ar,
                        // 'national_id' => $nor_national_id,
                    ];
                    c_student::where('student_id', $student_id)->update($data_to_db);
      
                }



 
            $student = c_student::where('student_id', $student_id)->first();
            $my_data = hruserdata::where('user_id', Auth::user()->id)->first();
           
           $old =  [];
            if($my_data){
            $old =  [
                'ar' => [
                    'from' => $student['ar'],
                 'to' => $nor_ar,
                  'by' => ['ar' => $my_data['ar'],
                   'id' => Auth::user()->id]
                ],
                'national_id' => [
                    'from' => $student['national_id'], 
                    'to' => $nor_national_id,
                    'by' => ['ar' => $my_data['ar'],
                    'id' => Auth::user()->id]
                                    ],

            ];
            }else{

                $old =  [
                    'ar' => [
                        'from' => $student['ar'],
                     'to' => $nor_ar,
                      'by' => ['ar' => Auth::user()->email,
                       'id' => Auth::user()->id]
                    ],
                    'national_id' => [
                        'from' => $student['national_id'], 
                        'to' => $nor_national_id,
                        'by' => ['ar' => Auth::user()->email,
                        'id' => Auth::user()->id]
                                        ],
    
                ];
                
            }


            c_student::save_name_histiry($student_id, $student['history'], $old);

 


 
            return response()->json(['msg' => ' save_student_nor_ar_id ok', 'data' =>  '$my_data'], 200);
        }

        if ($fun == 'save_sub_nor_code') {
            if ($request->all) {



                $data = [
                    'nor_code' => $request->data['nor_code'],
                    'nor_ar' => $request->data['nor_ar'],
                ];
                c_subject_class_tea::where('subject_id', $request->data['subject_id'])->update($data);


                return response()->json(['msg' => ' save_class_nor_code  all ok', 'data' =>  $request->data], 200);
            }

            $data = [
                'nor_code' => null,
                'nor_ar' => null,
            ];  
if(isset($request->data['nor_code'])){
    $data = [
        'nor_code' => $request->data['nor_code'],
        'nor_ar' => $request->data['nor_ar'],
    ];

}

            c_subject_class_tea::where('id', $request->data['id'])->update($data);



            return response()->json(['msg' => ' save_class_nor_code ok', 'data' =>  $request->data], 200);
        }

        if ($fun == 'save_class_nor_code') {
            //  $request->data;
            foreach ($request->data as $key => $sub) {
                // return $sub['nor_code'];
                // if(isset($sub['nor_code'])&&isset($sub['nor_ar'])){
                // return $sub ;


                $data = [
                    'nor_code' => $sub['nor_code'],
                    'nor_ar' => $sub['nor_ar'],
                ];
                c_subject_class_tea::where('id', $sub['id'])->update($data);

                // }

            }



            return response()->json(['msg' => ' save_class_nor_code ok', 'data' =>  $request->data], 200);
        }


        if ($fun == 'get_school_classes') {

            $my_classes =  c_class::where('school_id', $request->school_id)->get();
            return response()->json(['msg' => ' get_school_classes ok', 'data' =>  $my_classes], 200);
        }

        if ($fun == 'get_school_class_subjects') {

            $my_classes =  c_subject_class_tea::where('class_id', $request->class_id)->with('my_class', 'my_subject', 'my_teacher')->get();

            // foreach ($my_classes as $key => $sub) {
            //     $sub['ar'] = $sub['my_subject']['ar'] . '||' . $sub['my_subject']['detail'];
            // }

            return response()->json(['msg' => ' get_school_classes ok', 'data' =>  $my_classes], 200);
        }
        if ($fun == 'get_school_classes_subjects') {

            $my_classes =  c_subject_class_tea::where('school_id', $request->school_id)->with('my_class', 'my_subject', 'my_teacher')->get();
            return response()->json(['msg' => ' get_school_classes ok', 'data' =>  $my_classes], 200);
        }



        if ($fun == 'report_all_save_nor_code') {

            return c_subject::where('id', $request->subject_id)->update(['nor_code' => $request->nor_code]);


            return response()->json(['msg' => ' report_all_save_nor_code ok', 'data' =>  $request->all()], 200);
        }


        if ($fun == 'get_final_report_subject_setting') {
            $school_id = $request->school_id;
            $c_subjects_ids = c_subject_class_tea::where('school_id', $school_id)->with('my_subject')
                //  ->get(['subject_id']);
                ->distinct()  // Ensure unique subject_id values
                ->pluck('subject_id');
            $c_subject_class_tea = c_subject::whereIn('id', $c_subjects_ids)
                ->get();
            //  ->distinct()  // Ensure unique subject_id values
            //  ->pluck('subject_id');


            foreach ($c_subject_class_tea as $sub) {
                $sub['nor_code_old'] = $sub['nor_code'];
            }

            return response()->json(['msg' => ' get_final_report_subject_setting ok', 'data' =>  $c_subject_class_tea], 200);
        }

        if ($fun == 'get_final_report_settings') {
            $school_id = $request->school_id;
            $hrschool = hrschool::where('id', $school_id)->first();
            return response()->json(['msg' => ' get_final_report_settings ok', 'data' =>  $hrschool], 200);
        }

        if ($fun == 'save_final_report_settings') {
            $data = $request->data;
            $school_id = $request->school_id;


            $hrschool1 = hrschool::where('id', $school_id)->update([
                'final_report_settings' => $data
            ]);
            $hrschool = hrschool::where('id', $school_id)->get();
            // return 'save_final_report_settings done';
            return response()->json(['msg' => ' save_final_report_settings error', 'data' =>  $hrschool], 200);
        }

        if ($fun == 'my_schools_update_my_school') {
            $hrschooluser =    hrschooluser::where('user_id', Auth::user()->id)->with('my_school')->first();
            return response()->json(['msg' => ' my_schools_update_my_school error', 'data' =>  $hrschooluser], 200);
        }
        if ($fun == 'my_school_update') {
            $data2 =  $request->data;
            $data2['updated_at'] =  null;
            // $data2['updated_at']=  Date(now());
            // $data2['created_at']=null;

            hrschool::where('id', $request->data['id'])->update($data2);
            return 'my_school_update done';
        }

        if ($fun == 'semester_2_titles_fix') {
            set_time_limit(1000);
            // $class_id= $request->all();
            // // usleep(10500);
            //             $class_id= $request->all();
            //             usleep(4000000);

            // //    return " class_id=  request['class_id']";
            // return   $class_id= $request->all();
            $semester_id_1 = $request->semester_id_1;
            $semester_id_2 = $request->semester_id_2;
            $school_id = $request->school_id;
            // $subject_id= $data['subject_id'];
            $c_class_es = c_class::where('school_id', $school_id)->with('my_subjects', 'my_students')->get();

            foreach ($c_class_es as $key1 => $class_room) {
                foreach ($class_room['my_subjects'] as $key2 => $subject) {
                    foreach ($class_room['my_students'] as $key3 => $student) {
                        // return [$class_room,$subject,$student];
                        $c_subject_titles_t1 = c_subject_title::where('subject_id', $subject['subject_id'])->where('semester_id', $semester_id_1)->get();
                        $c_subject_titles_t2 = c_subject_title::where('subject_id', $subject['subject_id'])->where('semester_id', $semester_id_2)->get();


                        //  $student['marks']=[];


                        foreach ($c_subject_titles_t1 as $key => $subject_title_t1) {

                            // ---------------delete if found before----------------------------
                            c_mark::where('student_id', $student['student_id'])->where('subject_id', $subject['subject_id'])->where('semester_id', $semester_id_2)
                                ->where('mark', null)
                                // ->where('subject_title_id', $c_subject_titles_t2[$key]['id'])
                                ->delete();
                            // -------------------------------------------

                            if (isset($subject_title_t1['id'])) {
                                if (isset($c_subject_titles_t2[$key]['id'])) {
                                    c_mark::where('student_id', $student['student_id'])->where('subject_id', $subject['subject_id'])->where('semester_id', $semester_id_2)->where('subject_title_id', $subject_title_t1['id'])->update([
                                            'subject_title_id' => $c_subject_titles_t2[$key]['id']
                                        ]);
                                }
                            }

                            usleep(100);
                        }
                    }
                }
                // return $class_room;
            } //class










            return 'semester_2_titles_fix';
        }



















        if ($fun == 'student_request_update_student_data') {


            $data = [

                "request_update_data" =>            1,

            ];
            c_student::where('student_id', Auth::user()->id)->update($data);

            return $request->all();
        }







        if ($fun == 'save_my_attend') {
            $data = [
                'user_id' => Auth::user()->id,
                'status' => 1,
                'title' => 'meeting1',
                // 'at'=>'meeting1',
            ];
            c_attend_meeting::create($data);
            return response()->json([
                'msg' => ' save_my_attend done',
                'data' =>  $data
            ], 200);
        }





        if ($fun == 'c_semester_report_pre_data_my_school') {



            // $my_school= null;

            $my_school1 =   hrschooluser::where('user_id', Auth::user()->id)->with('my_school')->first();
            // $my_student=c_student::where('student_id', Auth::user()->id )->first();

            $my_school = $my_school1['my_school'];

            $data = [
                'user_id' => Auth::user()->id,
                'status' => 1,
                'title' => 'meeting1',
                // 'at'=>'meeting1',
            ];
            $c_attend_meeting =     c_attend_meeting::where('user_id', Auth::user()->id)->first();

            //    if($c_attend_meeting){

            //    }
            $data = [

                'my_school' => $my_school,
                'c_attend_meeting' => $c_attend_meeting,


            ];


            return response()->json([
                'msg' => 'c_semester_report_pre_data_student_page  -- has been loaded successfully.',
                'data' =>  $data
            ], 200);
        }













        if ($fun == 'c_semester_report_pre_data_student_page') {


            $my_student =  c_student::where('student_id', Auth::user()->id)->with('my_school', 'my_account')->first();
            if (!$my_student) {
                return 'no  student selected';
            }
            $my_school = null;

            if ($my_student) {

                $my_school = $my_student['my_school'];
            }
            // $my_student=c_student::where('student_id', Auth::user()->id )->first();

            $school_id   = $my_student['school_id'];
            $student_id  =  $my_student['student_id'];
            $class_id    =  $my_student['class_id'];
            $semester_id = null;
            $semester    = c_semester::where('school_id', $school_id)->where('active', 1)->first();
            if (isset($semester['id'])) {
                $semester_id =  $semester['id'];
            } else {
                // return ' no Active semester  ';
                return response()->json(['msg' => ' no Active semester  ', 'data' =>  null], 500);
            }

            $data = [

                'my_student' => $my_student,
                'my_school' => $my_school,
                'school_id' => $school_id,
                'student_id' => $student_id,
                'class_id' => $class_id,
                'semester_id' => $semester_id,
                'semester' => $semester,
                'paid' => $my_student['paid'],

            ];


            return response()->json([
                'msg' => 'c_semester_report_pre_data_student_page  -- has been loaded successfully.',
                'data' =>  $data
            ], 200);
        }


        if ($fun == 'c_semester_report_pre_data') {

            // return $request->school_id;
            // return $request->semester_id;
            $my_classess = c_class::where('school_id', $request->school_id)
                // ->with('my_students')
                // ->with(['my_students' => function ($query) {
                //     $query->get(['student_id', 'ar', 'en']);
                // }])

                ->get(['id', 'ar', 'en', 'detail']);



            foreach ($my_classess as $key => $my_class) {
                $my_class['my_students'] = c_student::where('class_id', $my_class['id'])->get(['student_id', 'ar', 'en']);
            }

            //   return $my_classess;
            return response()->json([
                'msg' => 'c_semester_report_pre_data +++++ has been loaded successfully.',
                'data' =>  $my_classess
            ], 200);
        }



















        if ($fun == 'semester_student_report_data_student_page') {

            $school_id = $request['data']['school_id'];
            $student_id =  $request['data']['student_id'];
            $class_id =  $request['data']['class_id'];
            $semester_id = $request['data']['semester_id'];





            //             $my_student=c_student::where('student_id', Auth::user()->id )->first();
            //             if($my_student['paid']==0){
            //                 return 'Bloked student';
            //     return response()->json(['msg' => 'Bloked student ', 'data' =>  $my_student], 500);

            //             }
            //             $school_id =$my_student['school_id'] ;
            //             $student_id=  $my_student['student_id'];
            //             $class_id=  $my_student['class_id'];
            //             $semester_id =null;
            //             $semester =c_semester::where('school_id', $school_id )->where('active', 1 )->first();
            // if(isset($semester['id'])){
            //     $semester_id =  $semester['id'];
            // }else{
            //     return response()->json(['msg' => ' no Active semester  ', 'data' =>  null], 500);

            // }



            $re1_head =   c_semester_report_m::re1_head($school_id);





            $re2_title =   c_semester_report_m::re2_title($class_id, $semester_id);
            $student_report_data = $this->semester_student_report_data_one($re1_head, $re2_title, $student_id, $semester_id);




            return response()->json(['msg' => 'semester_student_report_data_student_page   has been loaded successfully.', 'data' =>  $student_report_data], 200);
        }

















        if ($fun == 'semester_student_report_data') {
            $mood = $request->data['mood'];
            $students = [];
            $student_id = null;
            if ($mood == 'one') {
                if (isset($request->data['student_id'])) {
                    $student_id = $request->data['student_id'];
                } else {
                    return ' no student_id selected';
                }
                $students = c_student::where('student_id', $student_id)->get();
            }


            $semester_id = $request->data['semester_id'];
            $school_id   = $request->data['school_id'  ];
            $class_id    = $request->data['class_id'   ];
            if ($mood == 'class') {
                $students = c_student::where('class_id', $class_id)->get();
            }
            if ($mood == 'grade') {
                $grade_id =  c_class::where('id', $class_id)->first()->grade_id;
                $c_classes =  c_class::where('grade_id', $grade_id)->with('my_students')->get();

                //   $students = c_student::wherein('class_id', [1, 4, 7])->get();
                $my_class_ids_array = [];
                foreach ($c_classes  as $key => $my_class) {
                    array_push($my_class_ids_array, $my_class['id']);
                }

                $students = c_student::whereIn('class_id', $my_class_ids_array)->get();
            }
            $all = [];



            $re1_head =   c_semester_report_m::re1_head($school_id);



            $class_id = null;
            // return $request->data['class_id'];
            $semester_id = $request->data['semester_id'];
            $class_id = $request->data['class_id'];
            foreach ($students as $key => $my_student) {
                $student_id =  $my_student['student_id'];
                $class_id =  $my_student['class_id'];
                $re2_title =   c_semester_report_m::re2_title($class_id, $semester_id);
                $student_report_data = $this->semester_student_report_data_one($re1_head, $re2_title, $student_id, $semester_id);

                array_push($all, $student_report_data);
            }

            //  $re1_head_en=   c_semester_report_m::re1_head_en($school_id);




            return response()->json(['msg' => 'semester_student_report_data +++++ has been loaded successfully.', 'data' =>  $all], 200);

            // return [ $data1, $data2 ];

            //         $html = '<!DOCTYPE html>
            // <html lang="en">
            // <head>
            //   <meta charset="UTF-8">
            //   <title>My Report</title>
            // </head>عربي
            // <body>
            //   <h1>This is a sample report</h1>
            //   <p>This is some content for the report body.</p>
            // </body>
            // </html>';

            //       return  Pdf::loadHTML( $html )->setPaper( 'a4', 'landscape' )->setWarnings( false )->save( 'myfile2.pdf' );

            //   return c_semester_report_m::semester_student_report_data( $class_id, $semester_id, $school_id );

        }

        if ($fun == 'student_get_my_school') {
            //   $me =  User::where( 'id', Auth::user()->id )->with( 'student_my_school' )->first();
            $me =  c_student::where('student_id', Auth::user()->id)->with('my_school', 'my_account')->first();
            $school_id = $me['school_id'];
            $semester = $this->semester_active($school_id);

            // $datetimeValue = $semester[ 'student_open' ];

            // Convert to Carbon object
            // $carbon = Carbon::parse( $datetimeValue );

            // // Check if past, present, or future
            // if ( $carbon->isPast() ) {
            //     $student_can_open = true;
            //     // echo 'The datetime value is in the past.';
            // }
            //  elseif ( $carbon->isFuture() ) {
            //     echo 'The datetime value is in the future.';
            // } else {
            //     echo 'The datetime value is in the present.';
            // }

            // $now = Carbon::now();
            // $time_now = $now->toDateTimeString();
            // Output: 2024-02-22 19:28:00

            // Get the current time in Mecca
            // $nowInMecca = Carbon::now( 'Asia/Riyadh' );
            // Or any other appropriate timezone identifier

            // // Format the time as you desire
            // $formattedTime = $nowInMecca->format( 'h:i A' );
            // Example: 08:22 PM
            // $time_now2 = $nowInMecca->toDateTimeString();
            // Output: 2024-02-22 19:28:00

            // // Display or use the formatted time
            // // echo 'The current time in Mecca, Saudi Arabia is: ' . $formattedTime;

            $student_can_open = $this->is_past($semester['student_open']);

            $datetime1_str = $semester['student_open'];
            $datetime2_str = Carbon::now('Asia/Riyadh')->toDateTimeString();
            // Convert the strings to Carbon instances
            $datetime1 = Carbon::parse($datetime1_str);
            $datetime2 = Carbon::parse($datetime2_str);

            return [
                'school' =>  $me['my_school'],
                'school_id' =>  $school_id,
                'student_data' =>  $me,
                'semester' =>  $semester,
                'student_can_open' =>  $student_can_open,
                'datetime1' =>  $datetime1,
                'datetime2' =>  $datetime2,
            ];
        }

        if ($fun == 'marks_data') {
            $student_id = $request->data['data']['student_id'];
            $school_id = $request->data['data']['school_id'];
            $semester_id = $request->data['data']['semester_id'];
            $my_id =  Auth::user()->id;
            // $school = hrschooluser::where( 'user_id', $my_id )->first();
            // $school_id = null;
            if (!$school_id) {
                return 'no school selected for this user';
            }
            // $school_id = $school->school_id;

            $semester = $this->semester_active($school_id);
            if (!$semester) {
                return 'no semester_active';
            }
            if (!$semester_id) {
                return 'no semester_active';
            }
            if (!$school_id) {
                return 'no school_id';
            }
            // $semester_id = $semester->id;
            $c_student = c_student::where('student_id', $student_id)->first();
            if (!$c_student) {
                return 'no c_student';
            }
            $class_id = $c_student['class_id'];
            return $this->marks_data($student_id, $school_id, $semester_id, $class_id);
        }

        if ($fun == 'c_student_get') {
            $student_id = $request->data['data']['student_id'];
            return $this->c_student_get($student_id);
        }

        if ($fun == 'fun_school_year_semester_get') {

            return $this->fun_school_year_semester_get();
        }
    }
    ////////////////////////////////////////////////////////////////

    public function semester_active($school_id)
    {
        return  c_semester::where('school_id', $school_id)->where('active', 1)->with('my_year', 'my_school')->first();
    }

    public function marks_data($student_id, $school_id, $semester_id, $class_id)
    {

        // $c_subjects_titles = c_subject_title::
        //     // where( 'class_id', $c_student->class_id )->
        //     where( 'semester_id', $semester_id )->get();
        // foreach ( $c_subjects_titles as $key => $subject_title ) {
        //      $subject_title[ 'subject_id' ];
        //    return $c_subject_class_tea = c_subject_class_tea::where( 'subject_id', $subject_title[ 'subject_id' ] )
        //    ->where( 'class_id', $class_id )
        //    ->get();

        // }

        // return   $my_subjects =  c_subject::where( 'admin_id', Auth::user()->admin_id )
        $my_subjects =  c_subject_class_tea::where('admin_id', Auth::user()->admin_id)
            ->where('school_id', $school_id)
            ->where('class_id', $class_id)
            ->with([
                'my_subject'

                //, 'my_class', 'my_subject', 'my_students'   => function ( $query ) {
                //     $query->where( 'deleted', 0 );
                // Filter my_students with deleted = 0
                // }
                ,
                'my_subject_titles' => function ($query) use ($semester_id) {
                    $query->where('is_calc', 1);
                    // Filter
                    $query->where('semester_id', $semester_id);
                    //
                },
                'my_subject_titles_sum' => function ($query) use ($semester_id) {
                    // $query->where( 'is_calc', 1 );
                    // Filter
                    $query->where('semester_id', $semester_id);
                    //
                    // $query->where( 'class_id', $class_id );
                    //
                },

            ])
            ->orderBy('report_sequence', 'asc')->get();

        //////////////////get marks//////////////////////////////////////////
        // $my_marks = [];
        $subject_marks = [];
        $total_marks = 0;
        $default_total = 0;
        // return $my_subjects;
        foreach ($my_subjects as $key => $subject) {
            if ($subject['my_subject_titles_sum']) {

                $default_total = $default_total + $subject['my_subject_titles_sum']['highest_mark'];
            }
            //////////////////////////////semester_final_total_mark_all_subjects_default//////////////////////////////////

            //////////////////////////////semester_final_total_mark_all_subjects_default//////////////////////////////////

            // foreach ( $subject[ 'my_subject_titles' ] as $key2 => $value_title ) {
            $c_mark = c_mark::where('school_id', $school_id)
                ->where('semester_id', $semester_id)
                ->where('student_id', $student_id)
                ->where('subject_id', $subject['subject_id'])
                // ->where( 'subject_title_id', $value_title[ 'id' ] )
                ->with('my_subject_titles')
                ->get();
            $c_mark_sum = c_mark_sum::where('school_id', $school_id)
                ->where('semester_id', $semester_id)
                ->where('student_id', $student_id)
                ->where('subject_id', $subject['subject_id'])
                // ->where( 'subject_title_id', $value_title[ 'id' ] )
                ->with('my_subject_title', 'my_subject_title_sum')
                ->get();

            /////////////////title///////////////////////////////

            ////////////////////////////////////////////////

            if (count($c_mark) > 0) {
                if (count($c_mark_sum) > 0) {
                    $total_marks = $total_marks +  $c_mark_sum->sum('mark');
                }

                $title = null;
                foreach ($subject['my_subject_titles'] as $key2 => $value2) {
                    foreach ($c_mark as $key2 => $mark) {
                        if ($mark['subject_title_id'] == $value2['id']) {
                            $title = $value2;
                            $mark['title'] = $value2;
                        }
                    }
                }

                $data = [
                    // 'title'=>$title,
                    'subject' => $subject,
                    'marks' => $c_mark,
                    'marks_sum' => $c_mark_sum,
                ];
                array_push($subject_marks, $data);
            } else {
                $data = [
                    // 'title'=>$title,
                    'subject' => $subject,
                    // 'marks' => $c_mark,
                    // 'marks_sum' => $c_mark_sum,
                ];
                array_push($subject_marks, $data);
            }

            //   }

            // array_push( $my_marks, [ 'subject'=>$subject, 'subject_marks'=>$subject_marks ] );

        }
        // c_mark_total::where( 'school_id', $school_id )
        //                 ->where( 'semester_id', $semester_id )
        //                 ->where( 'student_id', $student_id )
        //                 ->with( 'my_subject_title' )
        //                 ->get();

        $data_check = [
            'admin_id'    =>  Auth::user()->admin_id,
            'school_id'   =>  $school_id,
            'semester_id' =>  $semester_id,
            'student_id'  =>  $student_id,
        ];
        $data_update = [
            'total'    =>  $total_marks,

        ];
        $c_mark_total = c_mark_total::updateOrCreate($data_check, $data_update);

        //         school_id
        // student_id
        // semester_id
        // INSERT INTO `c_mark_totals`( `id`, `admin_id`, `school_id`,
        //  `semester_id`, `student_id`,
        //   `total`,
        //   `order_class`,
        // `order_grade`

        //, `notes`, `active`, `created_at`, `updated_at` )
        // VALUES ( '[value-1]', '[value-2]', '[value-3]', '[value-4]', '[value-5]', '[value-6]', '[value-7]', '[value-8]', '[value-9]', '[value-10]', '[value-11]', '[value-12]' )

        $my_c_mark_total = c_mark_total::where('school_id', $school_id)
            ->where('semester_id', $semester_id)
            ->where('student_id', $student_id)
            // ->with( 'my_subject_title' )
            ->first();
        //////////////////////////////////////////////////////////////////////////////////////
        // total marks for all subjects
        // my_subject_titles_sum ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  =

        // my_subject_titles_sum ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  =

        //////////////////////////////////////////////////////////////////////////////////////
        // return $all_mark_total_default = $this->semester_final_total_mark_all_subjects_default( $student_id, $school_id, $semester_id, $class_id );
        ////////++++JJJJJ_______________________________________++++++++++++++++++++++++++++++++++++++++++++++//////////////////////////////////////////////////////////////////////////////
        // array_push( $subject_marks, [ 'total_marks'=> $total_marks, 'c_mark_total'=> $my_c_mark_total ] );
        return [
            'subject_marks' => $subject_marks,
            'c_mark_total' => $my_c_mark_total,
            'default_total' => $default_total,

        ];
        //////////////////get marks//////////////////////////////////////////

        // return [
        //     'my_school'  => $c_semester[ 'my_school' ],
        //     'my_year'    => $c_semester[ 'my_year' ],
        //     'my_semester' => $c_semester,
        // ];
    }
    ////////////////////////////////////////////////////////////////

    public function fun_school_year_semester_get()
    {
        // $admin_id =  Auth::user()->admin_id;
        $my_id =  Auth::user()->id;
        $school = hrschooluser::where('user_id', $my_id)->first();
        $school_id = null;
        if (!$school) {
            $school = c_student::where('student_id', $my_id)->first();
            if (!$school) {

                return 'no school selected for this user';
            }
            $school_id = $school->school_id;
        }
        $school_id = $school->school_id;

        $c_semester = c_semester::where('school_id', $school_id)->where('active', 1)->with('my_year', 'my_school')->first();

        return [
            'my_school'  => $c_semester['my_school'],
            'my_year'    => $c_semester['my_year'],
            'my_semester' => $c_semester,
        ];
    }

    public function c_student_get($student_id)
    {
        $my_student_data = c_student::where('student_id', $student_id)->first();

        $my_student_class = 'not found';
        if (isset($my_student_data['class_id'])) {
            // $my_student_class = c_grade::where( 'id', $my_student_class[ 'grade_id' ] )->first();
            $my_student_class = c_class::where('id', $my_student_data['class_id'])->first();
        }

        $my_student_grade = 'not found';
        if (isset($my_student_class['grade_id'])) {
            $my_student_grade = c_grade::where('id', $my_student_class['grade_id'])->first();
        }
        // $my_student_grade = c_grade::where( 'id', $my_student_class->grade_id )->first();

        $my_student_account = User::where('id', $student_id)->first();

        return [
            'my_student_data' => '$my_student_data',
            'my_data'   => $my_student_data,
            'my_account' => $my_student_account,
            'my_class'  => $my_student_class,
            'my_grade'  => $my_student_grade,
        ];
    }

    public function is_past($date_time)
    {
        $datetime1_str = $date_time;
        $datetime2_str = Carbon::now('Asia/Riyadh')->toDateTimeString();
        // Convert the strings to Carbon instances
        $datetime1 = Carbon::parse($datetime1_str);
        $datetime2 = Carbon::parse($datetime2_str);
        $student_can_open = false;
        // Compare the datetime instances
        if ($datetime1->isBefore($datetime2)) {
            // echo 'datetime1 is earlier than datetime2';
            $student_can_open = true;
        }
        return  $student_can_open;
    }

    public function semester_student_report_data_one($re1_head, $re2_title, $student_id, $semester_id)
    {
        $student_data = c_student::where('student_id', $student_id)->with('my_class', 'my_class.my_grade', 'my_account')->first();

        $class_id = $student_data['class_id'];
        $school_id = $student_data['school_id'];

        $re3_student_data =     [
            're3_student_data' => '$re3_student_data',
            'my_data'   => $student_data,
            'my_account' => $student_data['my_account'],
            'my_class'  => $student_data['my_class'],
            'my_grade'  => $student_data['my_class']['my_grade'],
        ];


        $re3_student_data =   c_semester_report_m::re3_student_data($student_id);
        $re4_marks_table =   c_semester_report_m::re4_marks_table($student_data, $semester_id);

        $re5_total = c_mark_total::where('semester_id', $semester_id)
            ->where('student_id', $student_id)
            ->with('my_subject_title')
            ->first();

        $re6_grade_scale = c_mark_grade_letter::where('school_id', $school_id)
            ->get();


        return [
            're1_head' => $re1_head,
            // 're1_head_en'=>$re1_head_en,
            're2_title' => $re2_title,
            're3_student_data' => $re3_student_data,
            're4_marks_table' => $re4_marks_table,
            're5_total' => $re5_total,
            're6_grade_scale' => $re6_grade_scale,

        ];
    }
}
