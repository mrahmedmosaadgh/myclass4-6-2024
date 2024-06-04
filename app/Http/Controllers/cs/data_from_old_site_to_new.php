<?php

namespace App\Http\Controllers\cs;

use App\Http\Controllers\Controller;

use App\Models\cs\c_mark;
use App\Models\cs\c_mark_sum;
use App\Models\cs\c_semester;
use App\Models\cs\c_student;
use App\Models\cs\c_subject;
use App\Models\cs\c_subject_class_tea;
use App\Models\cs\c_subject_title_sum;
use App\Models\hrschool;
use App\Models\hrschoolexammark;
use App\Models\hrschooluser;
use App\Models\hruserdata;
use App\Models\hryear;
use App\Models\Permission;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class data_from_old_site_to_new extends Controller
{
    //
    public function from_old_site_to_new(Request $request)
    {

        $new_data = [];
        // $school_id = hrschooluser::where('user_id', Auth::user()->id)->first()->school_id;
        $fun = $request->fun;


        if ($fun == "get_all_subjects") {
            $school_id = $request->data['school_id'];
            $subjects = c_subject::where("school_id", $school_id)->get();
            // return response()->json([   
            return response()->json([
                'message' => 'show  success--------------',
                'data' => $subjects,
            ]);
        }

        if ($fun == "get_school_semesters") {
            $school_id = $request->data["school_id"];

            $active_year  = hryear::where("active", 1)->first();
            if ($active_year) {
                $active_year_id = $active_year->id;
            } else {
                return response()->json(['msg' => 'no active year']);
            }
            $c_semesters = c_semester::where("school_id", $school_id)->where("year_id", $active_year_id)->get();
            return response()->json([
                'semesters' =>  $c_semesters,

            ], 200);
        }


        if ($fun == "get_all_admin_schools") {

            $hrschool = hrschool::where("admin_id", Auth::user()->admin_id)->get();
            // return response()->json(['hrschools' =>  $hrschool],200);



            $hrschoolIds = hrschool::where('admin_id', Auth::user()->admin_id)
                ->pluck('id');

            //   $hrschoolIds = hrschool::where('admin_id', Auth::user()->admin_id)
            // ->pluck('id','name_ar');  
            //   $hrschoolIds = hrschool::where('admin_id', Auth::user()->admin_id)
            // ->get();  


            $filteredHrschoolIds = $hrschoolIds->filter(function ($id) {
                // Check if a corresponding record exists in hrschoolusers table
                return hrschooluser::where('school_id', $id)->exists();
            });

            $hrschool = hrschool::whereIn("id", $filteredHrschoolIds)->get();
            return response()->json([
                'hrschools' =>  $hrschool,
                'hrschoolIds' =>  $hrschoolIds,
                'filteredHrschoolIds' =>  $filteredHrschoolIds,
            ], 200);
        }




        if ($fun == "app_timer") {
            $app_timer = DB::table('app_timer')->where('url',$request->data['url'])->first(); 
            // $app_timer = DB::table('app_timer')->all();
            if(!$app_timer){
            $app_timer = DB::table('app_timer')->insert([
                'url' => $request->data['url'],
                'enter_counter' => 1 
                
            ]);
            }else{
            // $app_timer = DB::table('app_timer')->where('url',$request->data['url'])->first(); 

              DB::table('app_timer')->where('id',$app_timer->id )->update([
                'url' => $request->data['url'],
                'enter_counter' =>$app_timer->enter_counter + 1 
            ]);              
            }
            $app_timer = DB::table('app_timer')->where('url',$request->data['url'])->first(); 



 
$currentTime = Carbon::now('Asia/Riyadh'); // Consider using 'Asia/Jeddah' if more precise



$providedTime = Carbon::parse($app_timer->time_to_close);
// $providedTime = Carbon::parse('2024-05-20 22:16:36');
$isInThePast=false;
if($app_timer->time_to_close){

    $isInThePast = $providedTime->isBefore($currentTime);
}






            return response()->json([
                'msg' => '  app_timer okkkkkkkkkkkkkkkkkkk    ',
                'data' => [
                 'app_timer'  => $app_timer,
                 'data'  => $request->all(),
                 'done'  => $isInThePast,
                 'providedTime'  => $providedTime,
        
                ],

            ], 200);
        }

        if ($fun == "save_me9") {
            $c_semesters = c_semester::all();

            return response()->json([
                'msg' => '  save_me9 okkkkkkkkkkkkkkkkkkk    ',
                'data' => [
                 'c_semester'  => $c_semesters,
        
                ],

            ], 200);
        }



        
        if ($fun == "save_me_get_sem") {
          
              $c_semester =  c_semester::all();
   
 
            return response()->json([
                'msg' => 'from_old_site_to_new save_me update  ',
                'data' => [
                 'c_semester'  => $c_semester,
        
                ],

            ], 200);
        }

        if ($fun == "save_me_get_class") {
          
              $class =  c_subject_class_tea::all();
   
 
            return response()->json([
                'msg' => 'from_old_site_to_new class    ',
                'data' => [
                 'class'  => $class,
        
                ],

            ], 200);
        }
        
        if ($fun == "save_me_perm") {
          
            // $class =  c_subject_class_tea::all();
            $permissionsAll=Permission::all();


          return response()->json([
              'msg' => 'from_old_site_to_new class    ',
              'data' =>  $permissionsAll,
      
               

          ], 200);
      }
         
        if ($fun == "save_me_perm_user") {
          
            // $class =  c_subject_class_tea::all();
            $permissionsAll=DB::table('permission_user')->get()->toArray();
            // Loop through the array of objects with key value
            foreach ($permissionsAll as $key => $value) {
    //   $value['my_user']  =  hruserdata::where('user_id',$value['user_id'])->first();
    //   $value['my_per']  =  Permission::where('id',$value['permission_id'])->first();
                
    $value->my_user_data   =  hruserdata::where('user_id',$value->user_id )->first();
    $value->my_user   =  User::where('id',$value->user_id )->first();
    $value->my_per   =  Permission::where('id',$value->permission_id )->first();
             


              }
 
            

          return response()->json([
              'msg' => 'from_old_site_to_new class    ',
           
                'data' => $permissionsAll,
               
              
      
               

          ], 200);
      }       
        if ($fun == "save_me_update") {
            $model=$request->data['model'];
            $id=$request->data['data']['id'];            
            $col=$request->data['col'];            
            $col_data=$request->data['data'][$col];            
            // $user =  $model::where('id',$id)->first();
            $user_update =  $model::where('id',$id)->update([
                $col=>$col_data
            ]);

            // $c_mark_sum =  c_mark_sum::all();
            // $c_subject_class_tea =  c_subject_class_tea::all();
            return response()->json([
                'msg' => 'from_old_site_to_new save_me update  ',
                'data' => [
                 'id'  => $id,
                 'col'  => $col,
                     'user_update' => $user_update,
                //     'techer_sub' => $c_subject_class_tea,
                ],

            ], 200);
        }


        // if ($fun == "save_me_update_active_all") {
        //     $model=$request->data['model'];
        //     $id=$request->data['data']['id'];            
        //     $col=$request->data['col'];            
        //     $col_data=$request->data['data'][$col];            
        //     // $user =  $model::where('id',$id)->first();
        //     $user_update =  User::where('id',$id)->update([
        //         'active'=>0
        //     ]);

        //     // $c_mark_sum =  c_mark_sum::all();
        //     // $c_subject_class_tea =  c_subject_class_tea::all();
        //     return response()->json([
        //         'msg' => 'from_old_site_to_new save_me update  ',
        //         'data' => [
        //          'id'  => $id,
        //          'col'  => $col,
        //              'user_update' => $user_update,
        //         //     'techer_sub' => $c_subject_class_tea,
        //         ],

        //     ], 200);
        // }










        if ($fun == "save_me_update_pass") {
            $model=$request->data['model'];
            $id=$request->data['data']['id'];            
            $col=$request->data['col'];            
            $col_data=$request->data['data'][$col];            
            // $user =  $model::where('id',$id)->first();
            $user_update =  $model::where('id',$id)->update([
                $col=>Hash::make($col_data) 
            ]);

            // $c_mark_sum =  c_mark_sum::all();
            // $c_subject_class_tea =  c_subject_class_tea::all();
            return response()->json([
                'msg' => 'from_old_site_to_new save_me update  ',
                'data' => [
                 'id'  => $id,
                 'col'  => $col,
                     'user_update' => $user_update,
                //     'techer_sub' => $c_subject_class_tea,
                ],

            ], 200);
        }

        




        if ($fun == "save_me") {
            if ($request->type == "users") {

                $users =  User::all();
                return response()->json([
                    'msg' => 'from_old_site_to_new save_me $hrschool',
                    'data' => [
                        'users' => $users,

                    ],

                ], 200);
            }

 

            if ($request->type == "users") {
                $c_mark_sum =  c_mark_sum::all();
                $c_subject_class_tea =  c_subject_class_tea::all();
                return response()->json([
                    'msg' => 'from_old_site_to_new save_me $hrschool',
                    'data' => [
                        // 'users' => $users,
                        'marks_sum' => $c_mark_sum,
                        'techer_sub' => $c_subject_class_tea,
                    ],

                ], 200);
            }

            return response()->json([
                'msg' => 'from_old_site_to_new save_me  no type',


            ], 200);
        }

        if ($fun == "save_errors_to_excel") {




            // $json = json_decode('[{"name":"John Doe", "age":30}, {"name":"Jane Doe", "age":25}]', true);

            // Excel::store($json, 'data.xlsx', 'public'); // Stores data in public/data.xlsx

            // return response()->download( public_path('\uploads\data.xlsx'), 'data.xlsx');


            // return response()->download(public_path('\data.xlsx'), 'data.xlsx');
            // return response()->download( '/data.xlsx' , 'data.xlsx');
            // return response()->download( '/public/data.xlsx' , 'data.xlsx');
            // return response()->download(storage_path('app/public/data.xlsx'), 'data.xlsx');






            // $json = json_decode('[{"name":"John Doe", "age":30},{"name":"Jane Doe", "age":25}]', true);

            // if (empty($json)) {
            //     // Handle empty data scenario (optional)
            //     return response()->json(['message' => 'No data to export']);
            // }

            // Excel::store($json, 'data.xlsx', 'public'); // Stores data in public/data.xlsx

            // return response()->download(public_path('uploads/data.xlsx'), 'data.xlsx');





            $json = json_decode('[{"name":"John Doe", "age":30}, {"name":"Jane Doe", "age":25}]', true);

            if (empty($json)) {
                return response()->json(['message' => 'No data to export'], 400);
            }






            $filename = 'data.xlsx';
            Excel::store($json, $filename, 'public');

            // $downloadUrl = asset('storage/' . $filename); // Adjust path if needed

            return response()->json(['downloadUrl' => public_path('uploads' . DIRECTORY_SEPARATOR . $filename)], 200);
        }
        //     return response()->json([
        //         'message'=> 'save_errors_to_excel done',
        //     ]);

        //  }


        if ($fun == "fun_delete_marks_s1") {
            $school_id = $request->data['school_id'];
            $semester_id_s1 = $request->data['semester_id_s1'];
            $semester_id_s2 = $request->data['semester_id_s2'];
            // $subject_id = $request->data['subject_id'];


            // delete____________________________________________________

            $c_marks_s2 = c_mark::
                // where("subject_id", $subject_id)->
                where("semester_id", $semester_id_s1)

                ->delete();
            c_mark_sum::
                // where("subject_id", $subject_id)->
                where("semester_id", $semester_id_s1)
                ->delete();

            // delete____________________________________________________
            return response()->json([
                'message' => 'fun_delete_marks_s1  success--------------',
                // 'data' => $subjects,
            ]);
        }
        ///fun_copy_student_marks_s1_____________________________________________________________________________________
        if ($fun == "fun_copy_student_marks_s1") {
            $school_id = $request->data['school_id'];
            $semester_id_s1 = $request->data['semester_id_s1'];
            $semester_id_s2 = $request->data['semester_id_s2'];
            $subject_id = $request->data['subject_id'];

            $students = c_student::where("school_id", $school_id)->get();
            $error_array = [];
            $done_array = [];
            $col_marks = [
                "mark1",
                "mark2",
                "mark3",
                "mark4",
                "mark5",
                "mark6",
                "mark7",
                "mark8",
                "mark9",
                "mark10",
                "mark11",
                "mark12",
                "final_exam",

            ];

            foreach ($students as $student) {
                $hrschoolexammark = hrschoolexammark::where("student_id", $student['student_id'])->where("subject_id", $subject_id)->get();
                if (count($hrschoolexammark) == 0) {
                    array_push($error_array, [$student["student_id"], $subject_id, 'no marks']);
                }
                if (count($hrschoolexammark) > 1) {
                    array_push($error_array, [$student["student_id"], $subject_id, 'more  marks']);
                }

                // -------------------------------------


                $c_marks_s2 = c_mark::where("subject_id", $subject_id)
                    ->where("student_id", $student['student_id'])
                    ->where("semester_id", $semester_id_s2)
                    ->get();

                $hrschoolexammark = hrschoolexammark::where("student_id", $student['student_id'])->where("subject_id", $subject_id)->first();

                if ($c_marks_s2 && count($c_marks_s2) > 0) {
                    foreach ($c_marks_s2 as $key => $c_mark_s2) {
                        if (!isset($col_marks[$key])) {
                            array_push($error_array, [$student["student_id"], $subject_id, '!$col_marks[$key]', [$c_marks_s2, $key]]);

                            ['!$col_marks[$key]', [$c_marks_s2, $key]];
                            $mark = null;
                        } else {
                            if ($key == count($c_marks_s2) - 1) {
                                // $mark = $hrschoolexammark['final_exam'];

                                if (isset($hrschoolexammark['final_exam'])) {
                                    $mark = $hrschoolexammark['final_exam'];
                                } else {
                                    $mark = null;
                                    array_push($error_array, [$student["student_id"], $subject_id, "no hrschoolexammark['final_exam']", [$c_marks_s2, $key]]);
                                }
                            } else {
                                if (isset($hrschoolexammark[$col_marks[$key]])) {
                                    $mark = $hrschoolexammark[$col_marks[$key]];
                                } else {
                                    $mark = null;
                                    array_push($error_array, [$student["student_id"], $subject_id, "no hrschoolexammark[$ col_marks[$ key]", [$c_marks_s2, $key]]);
                                }
                            }
                        }


                        // ---------------------------------------------


                        //copy data 

                        $data_from_old_to_new = [
                            "admin_id"        => $c_mark_s2["admin_id"],
                            "school_id"       => $c_mark_s2["school_id"],
                            "semester_id"     => $semester_id_s1,
                            "student_id"      => $c_mark_s2["student_id"],
                            "subject_id"      => $c_mark_s2["subject_id"],
                            "subject_title_id" => $c_mark_s2["subject_title_id"],
                            "attend"          => $c_mark_s2["attend"],
                            "completed"       => $c_mark_s2["completed"],
                            "mark"            => $mark,
                            "created_at"      => $c_mark_s2["created_at"],
                            "updated_at"      => $c_mark_s2["updated_at"],
                            // "key"             => $key,
                            // "c_marks_s2"             => count($c_marks_s2) - 1,




                        ];


                        $c_mark = c_mark::updateOrCreate($data_from_old_to_new, $data_from_old_to_new);
                        $c_mark_sum =  c_subject_title_sum::where('semester_id', $semester_id_s2)->where('subject_id', $c_mark_s2["subject_id"])->first();
                        $total = null;
                        if (isset($hrschoolexammark['total'])) {
                            $total =  $hrschoolexammark['total'];
                        }
                        $letter = null;
                        if (isset($hrschoolexammark['total_grade'])) {
                            $letter =  $hrschoolexammark['total_grade'];
                        }

                        $c_mark_sum_data = [
                            'admin_id'                             => $c_mark_s2["admin_id"],
                            'school_id'                            => $c_mark_s2["school_id"],
                            'semester_id'                          => $semester_id_s1,
                            'student_id'                           => $c_mark_s2["student_id"],
                            'subject_id'                           => $c_mark_s2["subject_id"],

                            'subject_title_sum_id' => $c_mark_sum['id'],
                            'mark' => $total,
                            'letter' => $letter,
                            'completed' => 1,
                        ];

                        $c_mark_sum =  c_mark_sum::updateOrCreate($c_mark_sum_data, $c_mark_sum_data);
                        array_push($done_array, [$c_mark, $c_mark_sum]);

                        // ---------------------------------------------

                    } //foreach ($c_marks_s2 as $key => $c_mark_s2) {


                } else {
                    array_push($error_array, [$student["student_id"], $subject_id, '$c_marks_s2 = c_mark not found']);
                }
            }









            return response()->json([$semester_id_s1, $semester_id_s2, $subject_id, $error_array, $done_array]);
        }
        ///fun_copy_student_marks_s1_____________________________________________________________________________________



        if ($fun == "get_student_marks_s1") {

            $semester_id_s1 = $request->data['semester_id_s1'];
            return    $c_marks_s2 = c_mark::where("semester_id", $semester_id_s1)->limit(100)
                // ->where("student_id", $student['student_id'])
                // ->where("semester_id", $semester_id_s2)
                ->with('my_mark_sum', 'my_mark_total')->limit(100)->get();;
            //  return 'get_student_marks_s1';
        }

        if ($fun == "get_student_marks_s2") {

            $semester_id_s2 = $request->data['semester_id_s2'];
            return    $c_marks_s2 = c_mark::where("semester_id", $semester_id_s2)
                // ->where("student_id", $student['student_id'])
                // ->where("semester_id", $semester_id_s2)
                ->get();
            //  return 'get_student_marks_s2';
        }

        return 'from_old_site_to_new';
    }
}
