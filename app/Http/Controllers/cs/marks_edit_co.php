<?php

namespace App\Http\Controllers\cs;
use App\Http\Controllers\Controller;
use App\Models\cs\c_class;
use App\Models\cs\c_mark;
use App\Models\cs\c_mark_grade_letter;
use App\Models\cs\c_mark_sum;
// use App\Models\cs\c_exam;
// use App\Models\cs\c_exam_grade;
// use App\Models\cs\c_exam_mark;
use App\Models\cs\c_semester;
use App\Models\cs\c_subject;
use App\Models\cs\c_subject_category;
use App\Models\cs\c_subject_class_tea;
use App\Models\cs\c_subject_title;
use App\Models\cs\c_subject_title_sum;
use App\Models\hrschoolclass;
use App\Models\hrschoolclasssubjectteacher;
use App\Models\hrschoolexam;
use App\Models\hrschoolexammark;
use App\Models\hrschoolexammarktotal;
use App\Models\hrschoolgradesubjectmark;
use App\Models\hrschoolmarksetup;
use App\Models\hrschoolsemester;
use App\Models\hrschoolsubject;
use App\Models\hrschooluser;
use App\Models\cs\c_student;
use App\Models\hruserdata;
use App\Models\User;
// use App\Models\Wallet;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// class teacher_marks_edit_co extends Controller
class marks_edit_co extends Controller
{






    public function teacher_marks_edit(Request $request)
    {
        $fun = $request->data['fun'];
        $my_id =  Auth::user()->id;
        $admin_id =  Auth::user()->admin_id;



        if ($fun == 'create') {
            return $this->create_new_exam($request->data);
            return $request->all();
        }



        if ($fun == 'show') {
            // $request->data['data'];
            $school_id = $request->data['data'];
            $class_marks_finished_percent = 0;

            //  return $request->school_id==null;
            $school_list = null;
            if ($school_id == null || $school_id == '') {
                $school_list = hrschooluser::where('user_id', Auth::user()->id)->with('my_school')->get();

                $school_id =   $school_list[0]['school_id'];
            }

            $my_classes =  c_subject_class_tea::where('admin_id', Auth::user()->admin_id)->where('school_id', $school_id)->where('teacher_id', Auth::user()->id)

                // ->with('my_class', 'my_subject', 'my_students')->get();
                ->with(['my_class', 'my_subject', 'my_students' => function ($query) {
                    $query->where('deleted', 0); // Filter my_students with deleted=1
                }])->get();




            // ->with('my_class', 'my_subject', 'my_students')->get();
            $semester = c_semester::where('school_id', $school_id)->where('active', 1)->first();
            if (!$semester) {
                return 'no active semester';
            }
            $semester_id = $semester->id;
            foreach ($my_classes as $key => $value) {
                $value['label'] = $value->my_class['detail'];
                $value['label2'] = $value->my_class['detail'];
                $value['label2'] = $value->my_class['detail'] . '[' . count($value['my_students']) . ']';
                $value['count'] =  count($value['my_students']);
                $value['subject'] =   $value['my_subject']['detail'];

                $class_marks_finished_percent = 0;
                $count_mark_all = 0;
                $count_mark_null = 0;


                foreach ($value['my_students'] as $key2 => $student) {
                    if ($student['delete'] == 0) { //if not deleted

                        $student_id = $student->student_id;
                        $c_mark_all_count = c_mark::where('school_id', $school_id)
                            ->where('subject_id', $value['my_subject']->id)
                            ->where('semester_id', $semester_id)
                            ->where('student_id', $student_id)
                            ->count();
                        if ($c_mark_all_count > 0) {
                            $count_mark_all = $count_mark_all + $c_mark_all_count;
                            $c_mark_null = c_mark::where('school_id', $school_id)
                                ->where('subject_id', $value['my_subject']->id)
                                ->where('semester_id', $semester_id)
                                ->where('student_id', $student_id)
                                ->where('mark', '!=', null)
                                ->where('attend', 1)
                                ->count();
                            $count_mark_null = $count_mark_null + $c_mark_null;
                            $class_marks_finished_percent = ($count_mark_null / $count_mark_all) * 100;

                            $number_float = floatval($class_marks_finished_percent);

                            // Round to 2 decimal places
                            $class_marks_finished_percent = round($number_float, 2);
                            $value['class_marks_finished_percent'] = $class_marks_finished_percent;
                            $value['mark_null'] = $count_mark_null;
                            $value['count_mark_all'] = $count_mark_all;
                        }
                    } //if($student['delete']==0){
                }
            }



            $semester  = c_semester::where('admin_id', Auth::user()->admin_id)->where('school_id', $school_id)->where('active', 1)->first();
            if (!$semester) {
                return 'no active semester ';
            }
            $semester_id = $semester->id;

            $teacher_data = hruserdata::where('user_id', Auth::user()->id)->first();











            // mystudents
            return response()->json([
                'message' => 'show  success--------------',
                'semester' => $semester,
                'school_id' => $school_id,
                'school_list' => $school_list,
                'my_classes' => $my_classes,
                'teacher_data' => $teacher_data,
                'class_marks_finished_percent' => $class_marks_finished_percent,

            ]);
        } //$fun == 'show'







        if ($fun == 'save_all') {
            // return $request->data['data'][0]['marks'][0]['mark'];
            // return $request->data['data'];
            // return $request->all();
            $data = $request->data['data'];

            // return $c_mark_grade_letter = c_mark_grade_letter::all();
            // return $c_mark_grade_letter=c_mark_grade_letter::where('admin_id',$admin_id)->get();


            // is betwwen **********************************
            // $number = 5.99999;
            // $lower_bound = 4;
            // $upper_bound = 6;

            // // $is_between = $number >= $lower_bound && $number <= $upper_bound;
            // $is_between = $this->is_between( $number,$lower_bound,$upper_bound);

            // if ($is_between) {
            //     return "5.12 is between 4 and 6";
            // } else {
            //     return "5.12 is not between 4 and 6";
            // }

            // is betwwen **********************************
            $err1 = [];
            foreach ($data as $key => $value) {

                $marks_sum = 0;
                $marks_not_completed = 0;
                foreach ($value['marks'] as $key => $val) {
                    // return $val['id'];
                    // return $val['mark'];
                    c_mark::where('id', $val['id'])->update(
                        [
                            'mark' => $val['mark'],
                            'completed' => $val['completed'],
                            'attend' => $val['attend'],

                        ]
                    );
                    $marks_sum = $marks_sum + $val['mark'];
                    if ($val['completed'] == 0 || $val['attend'] == 0 || $val['mark'] == null || $val['mark'] == '') {
                        $marks_not_completed = $marks_not_completed + 1;
                    }
                }
                // mars sum ********************************************
                // $marks_sum = 75.99999999999;
                // return [$value['marks'][0]['school_id'], $marks_sum, $this->is_between($marks_sum)];
                // return [$marks_sum, $this->is_between($marks_sum)];
                // return $marks_sum;
                $school_id = $value['marks'][0]['school_id'];
                $semester_id = $value['marks'][0]['semester_id'];
                $subject_id = $value['marks'][0]['subject_id'];
                $student_id = $value['student_id'];


                //////////////////////////////// marks sum ///////////////////////////////////////////////////////
                //1- find all marks titles is_calc
                $c_subject_titles = c_subject_title::where('admin_id', $admin_id)
                    ->where('school_id', $school_id)
                    ->where('semester_id', $semester_id)
                    ->where('subject_id', $subject_id)
                    ->where('is_calc', 1)
                    ->get();

                //2- sum of all marks titles is_calc
                $marks_titles_sum = 0;
                foreach ($c_subject_titles as $key => $value) {
                    $marks_titles_sum = $marks_titles_sum + $value['highest_mark'];
                }
if( !$marks_titles_sum ||$marks_titles_sum==null){
                return response()->json([
                    'message'    => '$marks_titles_sum==null',
                    'errors'     => [
                    'field_name' => '$marks_titles_sum==null',
                    ],
                ], 422);
};

// i don't find the sum from table c_subject_title_sum /////////
                $c_subject_title_sum = c_subject_title_sum::where('admin_id', $admin_id)
                    ->where('school_id', $school_id)
                    ->where('semester_id', $semester_id)
                    ->where('subject_id', $subject_id)
                    ->first();

                if ($c_subject_title_sum['highest_mark'] == 0) {
                    c_subject_title_sum::where('admin_id', $admin_id)
                    ->where('school_id', $school_id)
                    ->where('semester_id', $semester_id)
                    ->where('subject_id', $subject_id)
                    ->update([
                       'highest_mark' =>  $marks_titles_sum
                    ]);
                    // $c_subject_title_sum['highest_mark']==1;
                    // return response()->json([
                    //     'message' => '$c_subject_title_sum[ highest_mark ] == 0',
                    //     'error_code' => 'MY_ERROR_CODE', // Optional
                    // ], 400);
                    //////////////////////////////////eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee
                }





                $percent = ($marks_sum / $marks_titles_sum) * 100;
                $letter = $this->is_between($percent);



                $c_mark_sum = c_mark_sum::where('admin_id', $admin_id)
                    ->where('school_id', $school_id)
                    ->where('semester_id', $semester_id)
                    ->where('student_id', $student_id)
                    ->where('subject_id', $subject_id)
                    // ->where('subject_id', $subject_id)
                    ->where('subject_title_sum_id', $c_subject_title_sum->id)->first();






                array_push($err1, $c_subject_title_sum);

                if ($c_subject_title_sum) {
                    $completed = 1;

                    if ($marks_not_completed > 0) {
                        $completed = 0;
                    }
                    if ($c_mark_sum) {


                        c_mark_sum::where('admin_id', $admin_id)
                            ->where('school_id', $school_id)
                            ->where('semester_id', $semester_id)
                            ->where('student_id', $student_id)
                            ->where('subject_id', $subject_id)
                            // ->where('subject_id', $subject_id)
                            ->where('subject_title_sum_id', $c_subject_title_sum->id)
                            //    ->where('mark',$mark)
                            ->update([
                                'mark' => $marks_sum,
                                'letter' => $letter,
                                'completed' => $completed,
                            ]);
                    } else {

                        c_mark_sum::create([
                            'admin_id'                             => $admin_id,
                            'school_id'                            => $school_id,
                            'semester_id'                          => $semester_id,
                            'student_id'                           => $student_id,
                            'subject_id'                           => $subject_id,

                            'subject_title_sum_id' => $c_subject_title_sum->id,
                            'mark' => $marks_sum,
                            'letter' => $letter,
                            'completed' => $completed,
                        ]);
                    }






                    // return $c_subject_title_sum['highest_mark'];

                } else {


                    array_push($err1, ['not found $c_subject_title_sum', $value]);


                    // return 'not found $c_subject_title_sum';
                }

                //  c_mark_sum::where('admin_id',$admin_id)
                //            ->where('school_id',$school_id)
                //            ->where('semester_id',$semester_id)
                //            ->where('student_id',$student_id)
                //            ->where('subject_id',$subject_id)
                //            ->where('subject_title_sum_id',$subject_title_sum_id)
                //            ->where('mark',$mark)
                //            ->get();
                // mars sum ********************************************

                // INSERT INTO `c_mark_sums`(`id`, `admin_id`, `school_id`, `semester_id`,
                //  `student_id`, `subject_id`, `subject_title_sum_id`,
                //  `attend`, `mark`, `history`, `notes`, `created_at`, `updated_at`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]'
                // ,'[value-10]','[value-11]','[value-12]','[value-13]')
            }
            // mars sum ********************************************


            return [$err1, c_mark_sum::all()];

            // $c_mark_sum = c_mark_sum::where('school_id' => $school_id)
            //     ->where('subject_id', $subject_id)
            //     // ->where('semester_id', 222)
            //     ->where('semester_id', $semester_id)
            //     ->where('student_id', $student->student_id)
            //     ->where('subject_title_id', $title->id)
            //     //  ;
            //     ->get();
            // Model::whereNotIn('column_name', [1, 2, 5, 7])->delete();

            // mars sum ********************************************
            return 'All marks updated successfully';
        }






        if ($fun == 'class_marks') {
            // return $request->all();
            $school_id = $request->data['data']['school_id'];
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
                ->where('subject_id', $subject_id)
                // ->where('semester_id', 222)
                ->where('semester_id', $semester_id)
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
                            //  ;
                            ->get();
                    }



                    if (count($c_mark) < 1) {




                        $c_mark_data = [
                            'admin_id' => $admin_id,
                            'school_id' => $school_id,
                            'subject_id' => $subject_id,
                            'semester_id' => $semester_id,
                            'student_id' =>  $student->student_id,
                            'school_id' => $school_id,
                            'subject_title_id' => $title->id,

                        ];

                        $c_mark_new = c_mark::create($c_mark_data);
                        // array_push( ['count($c_mark)<1 not found -> created', $c_mark_new]);
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
                foreach ($c_mark as $key => $mark) {

                    $my_subject_title = c_subject_title::where('school_id', $school_id)
                        ->where('subject_id', $subject_id)
                        // ->where('semester_id', 222)
                        ->where('semester_id', $semester_id)->get();


                    $mark['my_subject_title'] = $my_subject_title;
                }


                $student['marks'] = $c_mark;
            }




            // }



            return  [
                'aaa' => ' $c_student',
                'data' => $c_student,
                'semester' => $semester,

            ];
        }
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
