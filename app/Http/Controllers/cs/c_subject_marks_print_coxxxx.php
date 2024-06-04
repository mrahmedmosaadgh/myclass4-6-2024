<?php

namespace App\Http\Controllers\cs;

use App\Http\Controllers\Controller;
use App\Models\cs\c_class;
use App\Models\cs\c_mark;
use App\Models\cs\c_mark_grade_letter;
use App\Models\cs\c_mark_sum;
use App\Models\cs\c_semester;
use App\Models\cs\c_student;
use App\Models\cs\c_subject;
use App\Models\cs\c_subject_class_tea;
use App\Models\cs\c_subject_title;
use App\Models\cs\c_subject_title_sum;
use App\Models\hrschool;
use App\Models\hrschooluser;

use App\Models\hruserdata;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// c_subject_marks_print_co.php
class c_subject_marks_print_co extends Controller
{
    public function c_subject_marks_print(Request $request)
    {
        $fun = null;

        if (isset($request->data['fun'])) {
            $fun = $request->data['fun'];
        }
        if (isset($request['fun'])) {
            $fun = $request['fun'];
        }

        $my_id =  Auth::user()->id;
        $admin_id =  Auth::user()->admin_id;

        $school = hrschooluser::where('user_id', $my_id)->first();
        $my_first_school_id = null;
        if (!$school) {
            return 'no school for this user  ';
        }
        $my_first_school_id = $school->school_id;
        $c_semester = c_semester::where('school_id', $my_first_school_id)->where('active', 1)->first();

        $semester_id = null;
        if (!$c_semester) {
            return 'no active semester  ';
        }
        $semester_id = $c_semester->id;


        if ($fun == 'year_semesters') {
            $my_id =  Auth::user()->id;
            $admin_id =  Auth::user()->admin_id;

            $school = hrschooluser::where('user_id', $my_id)->with('my_school')->first();
            $my_first_school_id = null;
            if (!$school) {
                return 'no school for this user  ';
            }
            $my_first_school_id = $school->school_id;
            $c_semesters = c_semester::where('school_id', $my_first_school_id)->get();

            $c_semester_active = null;
            foreach ($c_semesters  as $key => $value) {
                if ($value['active'] == 1) {
                    $value['ar'] =  $value['ar'] . ' (Active)';
                    $value['en'] =  $value['en'] . ' (Active)';
                    $c_semester_active  = $value;
                }
            }
            return response()->json([
                'msg' => 'year_semesters successfully loaded.',
                'semesters' => $c_semesters,
                'school' => $school['my_school'],
                'c_semester_active' => $c_semester_active,
            ], 200);

            // return 'year_semesters ok';
        }

        if ($fun == 'admin_delete_mark') {
            // return $request->data['item_mark'];

            // Loop through the array of objects with key value
            foreach ($request->data['item_mark'] as $key1 => $student) {
                foreach ($student['marks'] as $key2 => $mark) {
                    if ($mark['del']) {
                        c_mark::where('id', $mark['id'])->delete();
                    }
                }
            }
            return 'done';
        }


        if ($fun == 'admin_save_mark') {
            $data = $request->data['item_mark'];
            if ($data['attend'] == 0 || $data['completed'] == 0) {
                $data['mark'] == null;
            }
            c_mark::where('id', $data['id'])->update([

                "attend" => 1,
                // "attend"=>$data['attend'],
                "completed" => 1,
                // "completed"=>$data['completed'],
                "mark" => $data['mark'],
            ]);


            $sum = c_mark::where('school_id', $data['school_id'])->where('semester_id', $data['semester_id'])->where('student_id', $data['student_id'])->where('subject_id', $data['subject_id'])
                ->sum('mark');
            $letter =  $this->is_between($sum);
            $c_mark_sum = c_mark_sum::where('school_id', $data['school_id'])->where('semester_id', $data['semester_id'])->where('student_id', $data['student_id'])->where('subject_id', $data['subject_id'])->update([
                    "mark" => $sum,
                    "letter" => $letter,
                ]);
            return  c_mark_sum::where('school_id', $data['school_id'])->where('semester_id', $data['semester_id'])->where('student_id', $data['student_id'])->where('subject_id', $data['subject_id'])->first();
            // letter
            // :
            // "A"
            // mark
            // :
            // 95
            // return 'admin_save_mark done' ;

            // return c_subject_class_tea::where('school_id', $my_first_school_id)->where('subject_id', $subject_id)->get(['class_id','school_id']);
            // return c_subject_class_tea::where('school_id', $my_first_school_id)->where('subject_id', $subject_id)->with('my_class')->get('class_id');
        }
        if ($fun == 'get_subject_class_list') {
            $subject_id = $request->data['data']['subject_id'];

            return c_subject_class_tea::where('school_id', $my_first_school_id)->where('subject_id', $subject_id)->get(['class_id', 'school_id']);
            // return c_subject_class_tea::where('school_id', $my_first_school_id)->where('subject_id', $subject_id)->with('my_class')->get('class_id');
        }




        if ($fun == 'insert') {
            $my_data = $request->data['data'];
            /////////////////////////////////////////////////////////////
            $fullName = trim($my_data['en']);
            $fullName = strtolower($fullName);
            $names = explode(" ", $fullName);
            $count = count($names);
            $firstName = $names[0];
            $lastName = $names[$count - 1];

            $random = random_int(1000, 9999);
            /////////////////////////////////////////////////////////////

            $en = str_replace(" ", "_", $my_data['en']);

            $url_name = hrschool::where('id', $my_first_school_id)->first(['url_name']);
            $email = $firstName . '_' . $lastName . $random . '@' . $url_name . '.com';
            $email = str_replace(' ', '_', $email);
            $password = $url_name . '2023';

            //    $new_student =User::insert([
            //         'name' => $my_data['en'],
            //         'my_password' => $password,

            //         'email' => $email,
            //         'password' => bcrypt($password),
            //     ]);

            $new_student = User::create([
                'name' => $my_data['en'],
                'my_password' => $password,
                'email' => $email,
                'usertype' => 'teacher',
                'password' => bcrypt($password),
            ]);



            $data = [
                'user_id' => $new_student->id,
                'admin_id' => Auth::user()->admin_id,
                // 'school_id' => $my_first_school_id,
                // 'class_id' => $my_data['class_id'],
                'detail'   => $my_data['detail'],
                'ar'       => $my_data['ar'],
                'en'       => $my_data['en'],
            ];

            hruserdata::insert($data);

            $data = [
                'user_id' => $new_student->id,
                'admin_id' => Auth::user()->admin_id,
                'school_id' => $my_first_school_id,
                // 'class_id' => $my_data['class_id'],
                // 'detail'   => $my_data['detail'],
                // 'ar'       => $my_data['ar'],
                // 'en'       => $my_data['en'],
            ];

            hrschooluser::insert($data);




            return 'inserted done ';
        }

        if ($fun == 'delete') {
            $data = $request->data['data'];

            hruserdata::where('id', $data)->update(['deleted' => 1]);
            return 'delete done';
        }

        if ($fun == 'update_col') {
            //    return  $data = $request->data['data']['id'];
            $data = $request->data['data'];

            $id = $data['id'];
            $val = $data['val'];
            $col = $data['col'];

            //  $student_id = $request->data['data']['student_id'];
            if ($col == 'sequence') {

                hruserdata::where('id', $id)->update([$col => $val]);
                return 'update_col done';
            }
            return 'nothing from update_col  ';
        }

        if ($fun == 'update') {
            $data = $request->data['data'];
            $data_to_update = [];
            $user_id = $data['user_id'];
            // $data_to_update['class_id'] = $data['class_id'];
            // $data_to_update['paid'] = $data['paid'];
            $data_to_update['ar'] = $data['ar'];
            // $data_to_update['ar'] = $data['ar'];
            // $data_to_update['ar'] = $data['ar'];


            hruserdata::where('user_id', $user_id)->update($data_to_update);

            return 'update done';
        }
        if ($fun == 'show_all') {

            $school_id = $request->data['data']['school_id'];
            $class_id = $request->data['data']['class_id'];
            $subject_id = $request->data['data']['subject_id'];
            $semester = c_semester::where('school_id', $school_id)
                ->where('active', 1)
                ->with('my_school')
                ->with('my_year')
                ->first();
            if (!$semester) {
                return 'no active semester';
            }
            $semester_id = $semester->id;
            $teacher_id =  Auth::user()->id;



            //****** subject title found************ */
            $c_student = c_student::where('school_id', $school_id)
                ->where('deleted', 0)
                // ->where('class_id', $class_id)
                // ->with('my_class')
                ->get();

            $c_subject_title = c_subject_title::where('school_id', $school_id)
                ->where('subject_id', $subject_id)
                ->where('semester_id', $semester_id) //back
                // ->where('semester_id', 222)
                // ->where('semester_id', $semester_id)//back
                ->get();

            if (!$c_subject_title || count($c_subject_title) < 1) {
                return 'no subject title found';
            }
            //****** subject title found************ */
            ///////////////////////////////////////////////////




            //****** marks  get or create************ */


            foreach ($c_student as $key => $student) {



                //1- no   marks -> create all marks
                // if (!$c_mark ||count($c_mark)<1) {

                $err = [];

                foreach ($c_subject_title as $key => $title) {
                    $c_mark = c_mark::where('school_id', $school_id)
                        ->where('subject_id', $subject_id)
                        // ->where('semester_id', 222)
                        ->where('semester_id', $semester_id)
                        ->where('student_id', $student->student_id)
                        ->where('subject_title_id', $title->id)
                        //  ;
                        ->get();
                    //  return $c_mark->get();

                    if (count($c_mark) > 1) {
                        $c_mark_extra = c_mark::where('school_id', $school_id)
                            ->where('subject_id', $subject_id)
                            // ->where('semester_id', 222)
                            ->where('semester_id', $semester_id)
                            ->where('student_id', $student->student_id)
                            ->where('subject_title_id', $title->id);
                        array_push($err, ['count($c_mark)>1', $c_mark]);
                        $c_mark_extra->where('created_at', '!=', $c_mark_extra->latest('created_at')->first()->created_at)->delete();

                        $c_mark = c_mark::where('school_id', $school_id)
                            ->where('subject_id', $subject_id)
                            // ->where('semester_id', 222)
                            ->where('semester_id', $semester_id)
                            ->where('student_id', $student->student_id)
                            ->where('subject_title_id', $title->id)
                            // ->with('my_subject_title_sum')
                            // ->with('my_subject_title')
                            //  ;
                            ->get();
                    }



                    if (count($c_mark) < 1) {




                        // $c_mark_data = [
                        //     'admin_id' => $admin_id,
                        //     'school_id' => $school_id,
                        //     'subject_id' => $subject_id,
                        //     'semester_id' => $semester_id,
                        //     'student_id' =>  $student->student_id,
                        //     'school_id' => $school_id,
                        //     'subject_title_id' => $title->id,

                        // ];

                        // $c_mark_new = c_mark::create($c_mark_data);
                        array_push($err, ['count($c_mark)<1 not found -> created']);
                    }
                }



                $c_mark = c_mark::where('school_id', $school_id)
                    ->where('subject_id', $subject_id)
                    // ->where('semester_id', 222)
                    ->where('semester_id', $semester_id)
                    ->where('student_id', $student->student_id)
                    ->get();
                $c_mark_sum = c_mark_sum::where('school_id', $school_id)
                    ->where('subject_id', $subject_id)
                    // ->where('semester_id', 222)
                    ->where('semester_id', $semester_id)
                    ->where('student_id', $student->student_id)
                    ->first();
                $student['mark_sum'] = $c_mark_sum;

                ////////////////my_teacher/////////////////////////////////////////
                $c_subject_class_tea = c_subject_class_tea::where('school_id', $school_id)
                    ->where('subject_id', $subject_id)
                    ->where('class_id', $student->class_id)
                    ->with('my_subject')
                    ->first();

                $student['my_teacher'] = 'not found';
                if ($c_subject_class_tea) {
                    $teacher_id = $c_subject_class_tea->teacher_id;
                    $my_teacher = hruserdata::where('user_id', $teacher_id)->first();
                    if ($my_teacher) {
                        $student['my_teacher'] = $my_teacher;
                    }
                }
                /////////////////////////////////////////////////////////

                foreach ($c_mark as $key => $mark) {

                    $c_subject_title_sum = c_subject_title_sum::where('school_id', $school_id)
                        ->where('subject_id', $subject_id)
                        // ->where('semester_id', 222)
                        ->where('semester_id', $semester_id)
                        // ->where('student_id', $student->student_id)
                        ->with('my_subject_titles')
                        ->first();


                    // Loop through the array of objects with key value
                    // foreach ($c_subject_title_sum as $key => $value) {

                    //     if($value['my_subject_titles']){

                    //     }

                    //   }

                    //remove dublicat my_subject_titles



                    // ->with('my_subject_title')
                    // ->where('semester_id', $semester_id)


                    $mark['c_subject_title_sum'] = $c_subject_title_sum;
                    $mark['my_subject_titles'] = $c_subject_title_sum['my_subject_titles'];
                }


                $student['marks'] = $c_mark;
            }




            // }

            $c_class = c_class::where('school_id', $school_id)

                ->where('id', $class_id)
                ->with('my_grade')
                ->first();

            return  [
                'head' => [

                    'semester' => $semester,
                    'school' => $semester['my_school'],
                    'classroom' =>  $c_class,
                    'grade' =>  $c_class['my_grade'],
                    'subject' =>   $c_subject_class_tea['my_subject'],
                    'teacher' =>    $c_student[0]['my_teacher'],
                ],
                'data' => $c_student,
                'msg' => $err,

            ];
        }

        if ($fun == 'show') {

            $school_id = $request->data['data']['school_id'];
            $class_id = $request->data['data']['class_id'];
            $subject_id = $request->data['data']['subject_id'];
            $semester_id = $request->data['data']['semester_id'];
            $semester = c_semester::where('school_id', $school_id)
                ->where('active', 1)
                ->with('my_school')
                ->with('my_year')
                ->first();
            // if (!$semester) {
            //     return 'no active semester';
            // }
            // $semester_id = $semester->id;
            $teacher_id =  Auth::user()->id;



            //****** subject title found************ */
            $c_student = c_student::where('school_id', $school_id)
                ->where('deleted', 0)
                ->where('class_id', $class_id)
                // ->with('my_class')
                ->get();

            $c_subject_title = c_subject_title::where('school_id', $school_id)
                ->where('subject_id', $subject_id)
                // ->where('semester_id', 222)
                ->where('semester_id', $semester_id) //back
                // ->where('semester_id', $semester_id)
                ->get();

            if (!$c_subject_title || count($c_subject_title) < 1) {
                return 'no subject title found';
            }
            //****** subject title found************ */
            ///////////////////////////////////////////////////




            //****** marks  get or create************ */


            foreach ($c_student as $key => $student) {



                //1- no   marks -> create all marks
                // if (!$c_mark ||count($c_mark)<1) {

                $err = [];

                foreach ($c_subject_title as $key => $title) {
                    $c_mark = c_mark::where('school_id', $school_id)
                        ->where('subject_id', $subject_id)
                        // ->where('semester_id', 222)
                        ->where('semester_id', $semester_id)
                        ->where('student_id', $student->student_id)
                        ->where('subject_title_id', $title->id)
                        //  ;
                        ->get();
                    //  return $c_mark->get();

                    if (count($c_mark) > 1) {
                        $c_mark_extra = c_mark::where('school_id', $school_id)
                            ->where('subject_id', $subject_id)
                            // ->where('semester_id', 222)
                            ->where('semester_id', $semester_id)
                            ->where('student_id', $student->student_id)
                            ->where('subject_title_id', $title->id);
                        array_push($err, ['count($c_mark)>1', $c_mark]);
                        $c_mark_extra->where('created_at', '!=', $c_mark_extra->latest('created_at')->first()->created_at)->delete();

                        $c_mark = c_mark::where('school_id', $school_id)
                            ->where('subject_id', $subject_id)
                            // ->where('semester_id', 222)
                            ->where('semester_id', $semester_id)
                            ->where('student_id', $student->student_id)
                            ->where('subject_title_id', $title->id)
                            // ->with('my_subject_title_sum')
                            // ->with('my_subject_title')
                            //  ;
                            ->get();
                    }



                    if (count($c_mark) < 1) {




                        // $c_mark_data = [
                        //     'admin_id' => $admin_id,
                        //     'school_id' => $school_id,
                        //     'subject_id' => $subject_id,
                        //     'semester_id' => $semester_id,
                        //     'student_id' =>  $student->student_id,
                        //     'school_id' => $school_id,
                        //     'subject_title_id' => $title->id,

                        // ];

                        // $c_mark_new = c_mark::create($c_mark_data);
                        array_push($err, ['count($c_mark)<1 not found -> created']);
                    }
                }



                $c_mark = c_mark::where('school_id', $school_id)
                    ->where('subject_id', $subject_id)
                    // ->where('semester_id', 222)
                    ->where('semester_id', $semester_id)
                    ->where('student_id', $student->student_id)
                    ->get();
                $c_mark_sum = c_mark_sum::where('school_id', $school_id)
                    ->where('subject_id', $subject_id)
                    // ->where('semester_id', 222)
                    ->where('semester_id', $semester_id)
                    ->where('student_id', $student->student_id)
                    ->first();
                $student['mark_sum'] = $c_mark_sum;

                ////////////////my_teacher/////////////////////////////////////////
                $c_subject_class_tea = c_subject_class_tea::where('school_id', $school_id)
                    ->where('subject_id', $subject_id)
                    ->where('class_id', $student->class_id)
                    ->with('my_subject')
                    ->first();

                $student['my_teacher'] = 'not found';
                if ($c_subject_class_tea) {
                    $teacher_id = $c_subject_class_tea->teacher_id;
                    $my_teacher = hruserdata::where('user_id', $teacher_id)->first();
                    if ($my_teacher) {
                        $student['my_teacher'] = $my_teacher;
                    }
                }
                /////////////////////////////////////////////////////////

                foreach ($c_mark as $key => $mark) {

                    $c_subject_title_sum = c_subject_title_sum::where('school_id', $school_id)
                        ->where('subject_id', $subject_id)
                        ->where('semester_id', $semester_id) //back
                        // ->where('semester_id', 222)
                        // ->where('semester_id', $semester_id)//back
                        // ->where('student_id', $student->student_id)
                        ->with('my_subject_titles')->first();
                    // ->with('my_subject_title')
                    // ->where('semester_id', $semester_id)

                    //remove d
                    $arra_titles = [];
                    foreach ($c_subject_title_sum['my_subject_titles'] as $key => $value2) {
                        if ($value2['semester_id'] == $semester_id) {
                            array_push($arra_titles, $value2);
                            // unset($value2 );
                        }
                    }

                    // return [$arra_titles,$semester_id];

                    $mark['c_subject_title_sum'] = $c_subject_title_sum;
                    $mark['my_subject_titles'] = $arra_titles;
                }


                $student['marks'] = $c_mark;
            }




            // }

            $c_class = c_class::where('school_id', $school_id)

                ->where('id', $class_id)
                ->with('my_grade')
                ->first();

            return  [
                'head' => [

                    'semester' => $semester,
                    'school' => $semester['my_school'],
                    'classroom' =>  $c_class,
                    'grade' =>  $c_class['my_grade'],
                    'subject' =>   $c_subject_class_tea['my_subject'],
                    'teacher' =>    $c_student[0]['my_teacher'],
                ],
                'data' => $c_student,
                'msg' => $err,

            ];
        }




        ///////////////////////////////////////////////////////////
        if ($fun == 'class_marks') {
            //   return $request->data ;
            //   return $request->all();
            $school_id = $request->data['data']['school_id'];
            // $school_id = $request->data['data']['school_id'];
            $semester = c_semester::where('school_id', $school_id)->where('active', 1)->first();
            if (!$semester) {
                return 'no active semester';
            }
            $semester_id = $semester->id;
            $class_id = $request->data['data']['class_id'];
            $subject_id = $request->data['data']['subject_id'];
            $teacher_id =  Auth::user()->id;




            //****** subject title found************ */
            $c_student = c_student::where('school_id', $school_id)
                ->where('deleted', 0)
                ->where('class_id', $class_id)
                ->get();

            $c_subject_title = c_subject_title::where('school_id', $school_id)
                ->where('semester_id', $semester_id) //back
                ->where('subject_id', $subject_id)
                // ->where('semester_id', 222)
                // ->where('semester_id', $semester_id)//back
                // ->where('semester_id', $semester_id)
                ->get();

            if (!$c_subject_title || count($c_subject_title) < 1) {
                return 'no subject title found';
            }
            //****** subject title found************ */
            ///////////////////////////////////////////////////




            //****** marks  get or create************ */


            foreach ($c_student as $key => $student) {



                //1- no   marks -> create all marks
                // if (!$c_mark ||count($c_mark)<1) {

                $err = [];

                foreach ($c_subject_title as $key => $title) {
                    $c_mark = c_mark::where('school_id', $school_id)
                        ->where('subject_id', $subject_id)
                        // ->where('semester_id', 222)
                        ->where('semester_id', $semester_id)
                        ->where('student_id', $student->student_id)
                        ->where('subject_title_id', $title->id)
                        //  ;
                        ->get();
                    //  return $c_mark->get();

                    if (count($c_mark) > 1) {
                        $c_mark_extra = c_mark::where('school_id', $school_id)
                            ->where('subject_id', $subject_id)
                            // ->where('semester_id', 222)
                            ->where('semester_id', $semester_id)
                            ->where('student_id', $student->student_id)
                            ->where('subject_title_id', $title->id);
                        array_push($err, ['count($c_mark)>1', $c_mark]);
                        $c_mark_extra->where('created_at', '!=', $c_mark_extra->latest('created_at')->first()->created_at)->delete();

                        $c_mark = c_mark::where('school_id', $school_id)
                            ->where('subject_id', $subject_id)
                            // ->where('semester_id', 222)
                            ->where('semester_id', $semester_id)
                            ->where('student_id', $student->student_id)
                            ->where('subject_title_id', $title->id)
                            // ->with('my_subject_title_sum')
                            // ->with('my_subject_title')
                            //  ;
                            ->get();
                    }



                    if (count($c_mark) < 1) {




                        // $c_mark_data = [
                        //     'admin_id' => $admin_id,
                        //     'school_id' => $school_id,
                        //     'subject_id' => $subject_id,
                        //     'semester_id' => $semester_id,
                        //     'student_id' =>  $student->student_id,
                        //     'school_id' => $school_id,
                        //     'subject_title_id' => $title->id,

                        // ];

                        // $c_mark_new = c_mark::create($c_mark_data);
                        array_push($err, ['count($c_mark)<1 not found -> created']);
                    }
                }



                $c_mark = c_mark::where('school_id', $school_id)
                    ->where('subject_id', $subject_id)
                    // ->where('semester_id', 222)
                    ->where('semester_id', $semester_id)
                    ->where('student_id', $student->student_id)
                    ->get();
                $c_mark_sum = c_mark_sum::where('school_id', $school_id)
                    ->where('subject_id', $subject_id)
                    // ->where('semester_id', 222)
                    ->where('semester_id', $semester_id)
                    ->where('student_id', $student->student_id)
                    ->first();
                $student['mark_sum'] = $c_mark_sum;

                ////////////////my_teacher/////////////////////////////////////////
                $c_subject_class_tea = c_subject_class_tea::where('school_id', $school_id)
                    ->where('subject_id', $subject_id)
                    ->where('class_id', $student->class_id)
                    ->first();

                $student['my_teacher'] = 'not found';
                if ($c_subject_class_tea) {
                    $teacher_id = $c_subject_class_tea->teacher_id;
                    $my_teacher = hruserdata::where('user_id', $teacher_id)->first();
                    if ($my_teacher) {
                        $student['my_teacher'] = $my_teacher;
                    }
                }
                /////////////////////////////////////////////////////////

                foreach ($c_mark as $key => $mark) {

                    $c_subject_title_sum = c_subject_title_sum::where('school_id', $school_id)
                        ->where('subject_id', $subject_id)
                        // ->where('semester_id', 222)
                        ->where('semester_id', $semester_id)
                        // ->where('student_id', $student->student_id)
                        ->with('my_subject_titles')->first();
                    // ->with('my_subject_title')
                    // ->where('semester_id', $semester_id)


                    $mark['c_subject_title_sum'] = $c_subject_title_sum;
                    $mark['my_subject_titles'] = $c_subject_title_sum['my_subject_titles'];
                }


                $student['marks'] = $c_mark;
            }




            // }



            return  [
                'aaa' => ' $c_student',
                'data' => $c_student,
                'msg' => $err,

            ];
        }
    }

    public function show_subject_class_fun($data)
    {
    }

    public function is_between($number)
    {
        $c_mark_grade_letter = c_mark_grade_letter::where('admin_id', Auth::user()->admin_id)->get();

        foreach ($c_mark_grade_letter  as $key => $value) {
            if ($number >= $value->from && $number <  $value->to) {
                // if($number >= $value->from && $number <=  $value->to ){
                return $value->letter;
            }
        }
        return 'no value';
        // $is_between = $number >= $lower_bound && $number <= $upper_bound;

    }
}
