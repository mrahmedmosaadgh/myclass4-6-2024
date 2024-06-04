<?php

namespace App\Http\Controllers\cs;

use App\Http\Controllers\Controller;
use App\Models\cs\c_class;
use App\Models\cs\c_grade;
use App\Models\cs\c_subject;
use App\Models\cs\c_subject_class_tea;
use App\Models\hrschooluser;
use App\Models\hruserdata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class c_class_co extends Controller
{
    public function c_class(Request $request)
    {
        $fun = $request->data['fun'];
        $my_id =  Auth::user()->id;

        $school = hrschooluser::where('user_id', $my_id)->first();
        $my_first_school_id = null;
        if (!$school) {
            return response()->json([
                'message' => 'no school selected',
                'errors' => [
                    // Field name => error message
                    'user' => $my_id,
                ],
            ], 422);
        }

        $my_first_school_id = $school->school_id;




        if ($fun == 'update_report_sequence') {
            $my_data = $request->data['data'];
            $report_sequence = $my_data['report_sequence'];
            $id = $my_data['id'];
            c_subject_class_tea::where('id', $id)->update(['report_sequence' => $report_sequence]);
            return 'report_sequence updated successfully';
        }

        if ($fun == 'insert_classroom') {
            $my_data = $request->data['data'];
            // admin_id
            // school_id
            // grade_id
            // detail
            // ar
            // en


            //             $school = hrschooluser::where('user_id', $my_id)->first();
            // $my_first_school_id = null;
            // if ($school) {
            //     $my_first_school_id = $school->school_id;
            // }
            $data = [
                'admin_id' => Auth::user()->admin_id,
                'school_id' => $my_first_school_id,
                'grade_id' => $my_data['grade_id'],
                'detail'   => $my_data['detail'],
                'ar'       => $my_data['ar'],
                'en'       => $my_data['en'],
            ];

            c_class::insert($data);

            return 'inserted done ';
        }

        if ($fun == 'delete_classroom') {
            // admin_id
            // school_id
            // grade_id
            // detail
            // ar
            // en

        }
        if ($fun == 'delete') {
            // admin_id
            $school_id = $request->data['data']['data']['school_id'];
            $id = $request->data['data']['data']['id'];
            // grade_id
            // detail
            // ar
            // en


            try {
                c_class::where('id', $id)->delete();
                return response()->json(['msg' => 'delete success', 'data' => '$c_class'], 200);
                   } catch (\Throwable $th) {
                return response()->json(['msg' => 'delete error.' , 'data' => ''       ], 500);
                // return response()->json(['msg' => 'delete error.' , 'data' => $th       ], 500);
                   }
        }
        if ($fun == 'update_join_class_teacher_subject') {
            $data = $request->data['data']['my_subjects'];
            $school_id = $request->data['data']['school_id'];
            // return $class_id = $request->data['data'];
            $class_id = $request->data['data']['id'];
            foreach ($data as $key => $value) {

                if (isset($value['id'])  && $value['deleted'] == 1) {
                    c_subject_class_tea::where('id', $value['id'])->delete();
                }

                if (!isset($value['id']) || $value['id'] == null) {
                    $data = [
                        'school_id' =>  $my_first_school_id,
                        'admin_id' => Auth::user()->admin_id,


                        'class_id' => $class_id,
                        'teacher_id' => $value['teacher_id'],
                        'subject_id' => $value['subject_id'],
                    ];
                    c_subject_class_tea::insert($data);
                } else {
                    c_subject_class_tea::where('id', $value['id'])->update([
                        'subject_id' => $value['subject_id'],
                        'teacher_id' => $value['teacher_id'],
                    ]);
                }
            }


            return ['update_join_class_teacher_subject success', $request->all()];
        }
        //   return $request->all();
        if ($fun == 'update_class_grade') {
            // return $request->data['data'];

            $id = $request->data['data']['id'];
            $grade_id = $request->data['data']['grade_id'];

            $c_class = c_class::where('id', $id)->update(['grade_id' => $grade_id]);

            return ['done successfully update_class_grade', $c_class];
        }
        if ($fun == 'show') {
            // return $this->create_new_exam($request->data);
            // return $request->all();
            $c_classes =  c_class::where('school_id', $my_first_school_id)->with([
                'my_grade', 'my_subjects.my_subject', 'my_subjects'
                => function ($query) {
                    //  => function ($query) use ($my_first_school_id) {
                    // Ensure relationship is loaded properly (if needed)
                    // $query->where('school_id', $my_first_school_id);

                    // Order by report_sequence within the relationship
                    $query->orderBy('report_sequence');
                    // $query->orderBy('my_subject.report_sequence');
                    // $query->orderBy('my_subject.report_sequence');
                }


            ])->get();

            foreach ($c_classes as $key => $classroom) {
                // return $classroom['my_subjects'][0];
                foreach ($classroom['my_subjects'] as $key2 => $subject) {
                    // return[ $subject['teacher_id'], $subject['my_subject']];
                    $hruserdata = hruserdata::where('user_id', $subject['teacher_id'])->where('deleted', 0)->first(['id', 'ar', 'en']);
                    $subject['my_teacher'] = $hruserdata;
                }
            }


            $c_grades =  c_grade::where('school_id', $my_first_school_id)->orderBy('sequence', 'asc')->get();
            $hrschooluser =  hrschooluser::where('school_id', $my_first_school_id)->with('my_user')->get();
            // Loop through the array of objects with key value
            foreach ($hrschooluser  as $key => $value) {
                if ($value['my_user']) {
                    if ($value['my_user']['deleted'] == 1) {
                        unset($hrschooluser[$key]);
                    } else {

                        $value['ar'] = $value['my_user']['ar'];
                        $value['en'] = $value['my_user']['en'];
                    }
                } else {
                    $value['ar'] = 'no hrschooluser set:' . $value;
                    $value['en'] = 'no hrschooluser set:' . $value;
                    //   $value['ar'] = 'no hrschooluser set:'.$value['user_id'];
                    $value['en'] = 'no hrschooluser set:' . $value['user_id'];
                }
            }
            $c_subjects =  c_subject::where('school_id', $my_first_school_id)->get();
            return ['c_classes' => $c_classes, 'c_grades' => $c_grades, 'hrschooluser' => $hrschooluser, 'c_subjects' => $c_subjects];
        }
    }
}
