<?php

namespace App\Http\Controllers\cs;

use App\Http\Controllers\Controller;
use App\Models\cs\c_class;
use App\Models\cs\c_grade;
use App\Models\cs\c_mark;
use App\Models\cs\c_mark_total;
use App\Models\cs\c_semester;
use App\Models\cs\c_student;
use App\Models\cs\c_subject;
use App\Models\cs\c_subject_class_tea;
use App\Models\cs\c_subject_title;
use App\Models\cs\my_fun\semester_marks_manage_m;
use App\Models\cs\my_fun\semester_top_ten_m;
use App\Models\hrschooluser;
use App\Models\hryear;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
// Route::post('semester_marks_manage', [semester_marks_manage_co::class, 'semester_marks_manage']);
// php artisan route:cache
class semester_marks_manage_co extends Controller
{
    public function semester_marks_manage(Request $request)
    {
        $fun = $request['fun'];
        $my_id =  Auth::user()->id;
        $data = $request['data'];


        if ($fun == 'semester_2_titles_fix') {
            set_time_limit(1000);

            // $class_id= $data['class_id'];
            $semester_id_1 = 1;
            $semester_id_2 = 8;
            $school_id = 4;
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
                            c_mark::where('student_id', $student['student_id'])->where('subject_id', $subject['subject_id'])->where('semester_id', $semester_id_2)->where('mark', null)->where('subject_title_id', $c_subject_titles_t2[$key]['id'])->delete();
                            // -------------------------------------------



                            c_mark::where('student_id', $student['student_id'])->where('subject_id', $subject['subject_id'])->where('semester_id', $semester_id_2)->where('subject_title_id', $subject_title_t1['id'])->update([
                                    'subject_title_id' => $c_subject_titles_t2[$key]['id']
                                ]);
                            usleep(100);
                        }
                    }
                }
            }










            return 'semester_2_titles_fix';
        }


        if ($fun == 'semester_class_subject_get') {

            $semester_id = $request['semester_id'];
            $c_semester = c_semester::where('id', $semester_id)->first();

            $my_classes =  c_class::where('school_id', $c_semester['school_id'])->get();
            $c_subject_class_tea =   c_subject_class_tea::where('school_id', $c_semester['school_id'])
                ->with('my_subject')
                ->get()
                ->pluck('subject_id')
                //   ->pluck('my_subject.subject_id')
                ->unique();

            // Loop through the array of objects with key value
            $my_subjects = [];
            foreach ($c_subject_class_tea as $key => $subject_id) {
                //  return $subject_id;
                $c_subject = c_subject::where('id', $subject_id)->first();
                $c_subject['label']=$c_subject['ar'].' - ' .$c_subject['en'].
                array_push($my_subjects, $c_subject);
            }

            return response()->json([
                'msg' => 'semester_class_subject_get successfully loaded.',

                'my_subjects' => $my_subjects,
                'my_classes' => $my_classes,
                'my_classes2' => $my_classes,
                'semester_id' => $semester_id,


            ], 200);
        }

        if ($fun == 'get_class_marks2') {
            $class_id = $data['class_id'];
            $semester_id = $data['semester_id'];
            $school_id = $data['school_id'];
            $subject_id = $data['subject_id'];
            $c_semester = c_semester::where('id', $semester_id)->first();

            $teacher_data = c_subject_class_tea::where('subject_id', $subject_id)->where('class_id', $class_id)->with('my_teacher')->first();
            // $hrschooluser = hrschooluser::where('user_id', $user_id)->first();

            $marks_class_get = semester_marks_manage_m::marks_class_get($class_id, $semester_id, $school_id, $subject_id);
            return response()->json([
                'msg' => '$marks_class_get successfully loaded.',
                'data' => $marks_class_get,
                'semester' => $c_semester,
                'teacher_data' => $teacher_data['my_teacher'],
                'teacher_data2' => $teacher_data['my_teacher'],

            ], 200);
        }

        if ($fun == 'year_semesters') {
            $my_id =  Auth::user()->id;
            $admin_id =  Auth::user()->admin_id;

            $school = hrschooluser::where('user_id', $my_id)->with('my_school')->first();
            // $my_first_school_id = null;
            // if (!$school) {
            //     return 'no school for this user  ';
            // }
            $my_first_school_id = $school->school_id; //['school_id']
            // $school_id=$request['data'];
            $c_semesters = c_semester::where('school_id', $my_first_school_id)->get();

            $c_semester_active = null;
            foreach ($c_semesters  as $key => $value) {
                if ($value['active'] == 1) {
                    $value['ar'] =  $value['ar'] . ' (Active)';
                    $value['en'] =  $value['en'] . ' (Active)';
                    $value['active'] = 1;
                    $c_semester_active  = $value;
                } else {
                    $value['active'] =  0;
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
    }
}
