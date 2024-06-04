<?php

namespace App\Http\Controllers\cs;

use App\Http\Controllers\Controller;
use App\Models\c_course;
use App\Models\c_course_teacher;
use App\Models\c_teacher;
use App\Models\cs\c_semester;
use App\Models\cs\c_subject;
use App\Models\cs\c_subject_class_tea;
use App\Models\cs\c_subject_title;
use App\Models\cs\c_subject_title_sum;
use App\Models\hrschooluser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class c_semester_co extends Controller
{
    public function c_semester(Request $request)
    {
        $user = Auth::user();
        $fun = $request->fun;
        $data = $request->data;

           $hrschooluser = hrschooluser::where('user_id', Auth::user()->id)->first();
            $school_id = null;
            if ($hrschooluser) {
                $school_id = $hrschooluser->school_id;
            }
            if ($school_id == null) {
                return 'no school_selected';
            }
        if ($fun == 'view') {
 


            $c_semester = c_semester::where('school_id', $school_id)->get();



            //             $c_courses = c_course::where('admin_id', $user->admin_id)->get();
            //             // $teachers_del=c_teacher::where('national_id',534543534534)->get();
            // foreach ($c_courses as $key => $course) {
            //     $c_course_teachers = c_course_teacher::where('course_id', $course->id)->get();
            //     $course_teachers=[];

            //   if(count($c_course_teachers) > 0) {

            //       foreach ($c_course_teachers as $key2 => $value2) {
            //         //   return  [ $value['teachers'],$value2['user_id']];
            //          array_push($course_teachers, $value2['user_id']) ;
            //       }
            //       $course['teachers']= $course_teachers;

            //   }
            // }
            return response()->json(['msg' => 'Data has been loaded successfully.', 'data' =>  $c_semester], 200);
        }

        // return $request->all();


        //subject_title_sum

        if ($fun == 'set_active') { 
            $semester_id = $request->data['data']['id'];
           $year_id= c_semester::where('id', $semester_id)->first( )->year_id;
           $c_semester_active= c_semester::where('year_id', $year_id)->update(['active'=>0] ) ;
 
       c_semester::where('id', $semester_id)->update(['active'=>1]);
    return response()->json(['msg'=> 'current semester set active done' ]) ; 
 
          }

/////////////////////////////////////////////////////////////////////////////////////////
if ($fun == 'subject_title_sum') {
    //   return  $data = $request->data;
    $semester_id = $request->data['data']['id'];
    $semester_id_copy_from = $request->data['semester_id'];
    //old data redy to copy from //return
     $c_subject_title_sum = c_subject_title_sum::where('semester_id', $semester_id_copy_from)->get();

    //   "created_at": null,
    //   "updated_at": null
    $found = [];
    foreach ($c_subject_title_sum as $key => $value) {

        //   "school_id": 8,
        //   "class_id": 29,
        //   "subject_id": 29,
        //   "semester_id": 8,

        // check new data found or not found so copy from old data;
        $c_subject_title_sum = c_subject_title_sum::where('school_id', $value['school_id'])->
                                            where('subject_id', $value['subject_id'])->
                                            where('semester_id', $semester_id)->first();

        if ($c_subject_title_sum) {
            array_push($found, 'found');
                //  return 'found';
        } else {
            // INSERT INTO `c_subject_title_sums`(`id`, 
            // ` `, ` `, ` `,
            //  ` `, ` `, ` `,
            //  `report_title`, `report_sequence`, `notes`, `active`, `created_at`, `updated_at`)
            // `c_subject_title_sums`(`id`, 
            // `admin_id`,
            //  `school_id`,
            //  `semester_id`,
            //  `subject_id`,

            // `highest_mark`,
            //  `lowest_mark`,
            //  `completed`,
            //  `notes`,

            //  `created_at`,
            //  `updated_at`)

            // INSERT INTO `c_subject_title_sums`(`id`, ` `, ` `, ` `, ` `, ` `, 
            // `detail`, ``, ``, ` `, ``, ` `, `is_final`, `notes`, `created_at`, `updated_at`)

           
           
            //   `semester_id`,
            //    `subject_id`,
            // //  `highest_mark`,
            //  `lowest_mark`, 
            //  `completed`, 
            //  `notes`,
            //   `created_at`, `updated_at`




            $db = [
                'admin_id'  => $value['admin_id'],
                'school_id'  => $value['school_id'],
                // 'class_id'   => $value['class_id'],
                'subject_id' => $value['subject_id'],
                // 'teacher_id' => $value['teacher_id'],
                // 'sequence' => $value['sequence'],
                'semester_id' => $semester_id,


                // 'detail' => $value['detail'],
                // 'ar' => $value['ar'],
                // 'en' => $value['en'],
                'highest_mark' => $value['highest_mark'],
                'lowest_mark' => $value['lowest_mark'],
                // 'is_calc' => $value['is_calc'],
                // 'is_final' => $value['is_final'],
                'notes' => $value['notes'],//


            ];



            $c_subject_title_sum = c_subject_title_sum  ::create($db);
            array_push($found, ['not found: created', $c_subject_title_sum]);


            // return 'not found';

        }
    }
    return $found;
}
/////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////
        if ($fun == 'subject_title') {
            //   return  $data = $request->data;
            $semester_id = $request->data['data']['id'];
            $semester_id_copy_from = $request->data['semester_id'];
            //old data redy to copy from //return
             $c_subjecs = c_subject::where('school_id', $school_id )->get();

            //   "created_at": null,
            //   "updated_at": null
            $found = [];
            foreach ($c_subjecs as $key => $c_subjec) {

                //   "school_id": 8,
                //   "class_id": 29,
                //   "subject_id": 29,
                //   "semester_id": 8,

                // check new data found or not found so copy from old data;
                $c_subject_titles_old_to_copy = c_subject_title::where('school_id', $school_id)->
                                                    where('subject_id', $c_subjec['id'])->
                                                    where('semester_id', $semester_id_copy_from)->get();
                                                    $c_subject_titles_new = c_subject_title::where('school_id', $school_id)->
                                                    where('subject_id', $c_subjec['id'])->
                                                    where('semester_id', $semester_id)->get();
                                                    ///////////////delete old data if found///////////////////////////////////////////////////////////
                                                    $c_subject_titles_new = c_subject_title::where('school_id', $school_id)->
                                                    where('subject_id', $c_subjec['id'])->
                                                    where('semester_id', $semester_id)->delete();
                                                    ///////////////delete old data if found///////////////////////////////////////////////////////////

                                                    // Loop through the array of objects with key value
                                                    // if (count($c_subject_titles_old_to_copy) == count($c_subject_titles_new)  ) {
                                                    //     array_push($found, 'found');
                                                    // } else {
                                                    foreach ($c_subject_titles_old_to_copy as $key1 => $subject_title) {
                                                        // Print the key and the name and price properties of the object
                                                        // echo $key . ": " . $value['name'] . " - " . $value['price'] . "\n";
                                                        
                                                      

                        //  return 'found';
                    // INSERT INTO `c_subject_titles`(`id`, 
                    // ` `, ` `, ` `,
                    //  ` `, ` `, ` `,
                    //  `report_title`, `report_sequence`, `notes`, `active`, `created_at`, `updated_at`)


                    // INSERT INTO `c_subject_titles`(`id`, ` `, ` `, ` `, ` `, ` `, 
                    // `detail`, ``, ``, ` `, ``, ` `, `is_final`, `notes`, `created_at`, `updated_at`)
                    $db = [
                        'admin_id'  => $subject_title['admin_id'],
                        // 'class_id'   => $subject_title['class_id'],
                        // 'teacher_id' => $subject_title['teacher_id'],
                        'sequence' => $subject_title['sequence'],
                        'detail' => $subject_title['detail'],
                        'ar' => $subject_title['ar'],
                        'en' => $subject_title['en'],
                        'highest_mark' => $subject_title['highest_mark'],
                        'lowest_mark' => $subject_title['lowest_mark'],
                        'is_calc' => $subject_title['is_calc'],
                        'is_final' => $subject_title['is_final'],
                        'notes' => $subject_title['notes'],
                        
                        'subject_id' => $subject_title['subject_id'],
                        'school_id'  => $subject_title['school_id'],
                        'semester_id' => $semester_id,
                        
                    ];

 

                    $c_subject_title = c_subject_title::create($db);
                    array_push($found, ['not found: created', $c_subject_title]);


                    // return 'not found';

                // }
            }
            }
            return $found;
        }
        /////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////
        if ($fun == 'subject_class_tea') {
            //   return  $data = $request->data;
            $semester_id = $request->data['data']['id'];
            $semester_id_copy_from = $request->data['semester_id'];
            //old data redy to copy from //return
            $c_subject_class_tea = c_subject_class_tea::where('semester_id', $semester_id_copy_from)->get();

            //   "created_at": null,
            //   "updated_at": null
            $found = [];
            foreach ($c_subject_class_tea as $key => $value) {

                //   "school_id": 8,
                //   "class_id": 29,
                //   "subject_id": 29,
                //   "semester_id": 8,

                // check new data found or not found so copy from old data;
                $c_subject_class_tea = c_subject_class_tea::where('school_id', $value['school_id'])->where('class_id', $value['class_id'])->where('subject_id', $value['subject_id'])->where('semester_id', $semester_id)->first();

                if ($c_subject_class_tea) {
                    array_push($found, 'found');
                    // $c_subject_class_tea = c_subject_class_tea::where('id', $value['id'])->update([ 'teacher_id' => $value['teacher_id']]);

                    //    return 'found';
                } else {
                    // INSERT INTO `c_subject_class_teas`(`id`, 
                    // ` `, ` `, ` `,
                    //  ` `, ` `, ` `,
                    //  `report_title`, `report_sequence`, `notes`, `active`, `created_at`, `updated_at`)
                    $db = [
                        'admin_id'  => $value['admin_id'],
                        'school_id'  => $value['school_id'],
                        'class_id'   => $value['class_id'],
                        'subject_id' => $value['subject_id'],
                        'teacher_id' => $value['teacher_id'],
                        'report_sequence' => $value['report_sequence'],
                        'semester_id' => $semester_id,
                    ];
                    $c_subject_class_tea = c_subject_class_tea::create($db);
                    array_push($found, ['not found: created', $c_subject_class_tea]);


                    // return 'not found';

                }
            }
            return $found;
        }
        /////////////////////////////////////////////////////////////////////////////////////////


        if ($fun == 'create') {
            $data = $request->data;



            $db = [
                'admin_id' => $user->admin_id,
                'en'       => $data['en'],
                'ar'       =>  $data['ar'],
                'detail'   =>  $data['ar'],
                'notes'    =>  $data['notes'],

            ];
            // $created_course = c_course::create($db);



            return response()->json(['msg' => 'Data has been created successfully.', 'data' => '$created_course'], 200);
        }


        if ($fun == 'update_teacher_join') {
            $data = $request->data;
            // $c_course_teachers_old_delete = c_course_teacher::where('course_id', $data['id'])->delete();
            // $teachers_del=c_teacher::where('national_id',534543534534)->get();
            foreach ($data['teachers'] as $key => $user_id) {
                // c_course_teacher::insert([
                //     'admin_id' => $user->admin_id,
                //     'course_id'  => $data['id'],
                //     'user_id'  => $user_id,

                // ]);



            }
            // This method deletes the records matching the filtered criteria.
            // $deleteIds = array_diff($db_ids, $new_ids);

            // YourModel::whereIn('id', $deleteIds)->delete();
            ///////////////////////////////////////////////////////////////////
            //             $objectsToInsert = [];
            // foreach ($new_ids as $id) {
            //     $objectsToInsert[] = new YourModel(['id' => $id, /* other attributes */]);
            // }

            // YourModel::insert($objectsToInsert);


            // c_course::where('id', $data['id'])->update([
            //     // 'admin_id' =>$user->admin_id  ,
            //     // 'user_id' =>$created_user->id  ,
            //     'en' => $data['en'],
            //     'ar' => $data['ar'],
            //     'notes' => $data['notes'],


            //     // 'national_id' =>'12345678' ,
            // ]);
            return response()->json(['msg' => 'Data has been updated successfully.', 'data' => ''], 200);

            // return $data;
        }
        if ($fun == 'update') {
            $data = $request->data;
            //    $data= $request->data['data'];
            // return response()->json(['msg' => 'Data has been updated successfully.','data' => $data], 200);

            // c_course::where('id', $data['id'])->update([


            //     // 'admin_id' =>$user->admin_id  ,
            //     // 'user_id' =>$created_user->id  ,
            //     'en' => $data['en'],
            //     'ar' => $data['ar'],
            //     'notes' => $data['notes'],


            //     // 'national_id' =>'12345678' ,
            // ]);
            return response()->json(['msg' => 'Data has been updated successfully.', 'data' => ''], 200);

            // return $data;
        }

        if ($fun == 'delete') {
            $data = $request->data;

            // $db= c_course::where('id',  $data['id']);
            // if ($db) {
            //     $db->delete();
            // }


            return response()->json(['msg' => 'Data has been deleted successfully.', 'data' => ''], 200);
        }
        if ($fun == 'join_teacher_to_course') {
            return $data = $request->data;
            // c_course_teacher::where('id', $data['id'])->update([])    
            // $db= c_course::where('id',  $data['id']);
            // if ($db) {
            //     $db->delete();
            // }


            // return response()->json(['msg' => 'Data has been deleted successfully.', 'data' => ''], 200);
        }

        return  $user;
    }
}
