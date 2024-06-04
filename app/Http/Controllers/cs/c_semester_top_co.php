<?php

namespace App\Http\Controllers\cs;

use App\Http\Controllers\Controller;
use App\Models\cs\c_class;
use App\Models\cs\c_grade;
use App\Models\cs\c_mark_total;
use App\Models\cs\c_student;
use App\Models\cs\c_subject_class_tea;
use App\Models\cs\my_fun\semester_top_ten_m;
use App\Models\hrschooluser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
// Route::post('c_semester_top', [c_semester_top_co::class, 'c_semester_top']);
// php artisan route:cache
class c_semester_top_co extends Controller
{
    public function c_semester_top(Request $request)
    {
        $fun = $request['fun'];
        $my_id =  Auth::user()->id;
        $data = $request['data'];
        // $school = hrschooluser::where('user_id', $my_id)->first();
        // $my_first_school_id = null;
        // if ($school) {
        //     $my_first_school_id = $school->school_id;
        // }



        $school_id = null;
        if (isset($request->school_id)) {
            $school_id = $request->school_id;
        } else {
            $school_id = hrschooluser::where('admin_id', Auth::user()->admin_id)->where('user_id', Auth::user()->id)->first()->school_id;
        }


        if ($fun == 'get_school_grades') {//
            $school_id = $request->school_id;
            return    c_grade::where('school_id', $school_id)->get();
        }





        if ($fun == 'get_class_top') {//get_class_top
            $school_id = $request->school_id;
            $class_id = $request->class_id;
            $semester_id = $request->semester_id;
            $type        = $request->type;

            $order_class=  semester_top_ten_m::semester_top_ten_class($class_id, $semester_id, $school_id);
          
          return response()->json([
            'message'   => 'get_class_top success',
            'data'      => $order_class,


        ]);
          
          

        }//get_class_top




        if ($fun == 'get_grade_top') {//get_grade_top
            $school_id = $request->school_id;
            $class_id = $request->class_id;
            $semester_id = $request->semester_id;
            $type        = $request->type;

            $order_class=  semester_top_ten_m::semester_top_ten_grade($class_id, $semester_id, $school_id);
          
          return response()->json([
            'message'   => 'get_grade_top success',
            'data'      => $order_class,


        ]);
          
          

        }//get_grade_top

        if ($fun == 'get_school_classes') {
            $school_classes = c_class::where('admin_id', Auth::user()->admin_id)->where('school_id', $school_id)->get();
            return response()->json([
                'message' => 'get_school_classes success',
                'data' => $request->all(),
                'school_classes' => $school_classes,
                'school_id' => $school_id,
                // 'year_semesters' => $year_semesters,
            ]);
        }














        if ($fun == 'table_col') {
            if (isset($request['table'])) {

                //  $col=DB::table($request['table'])->where('',$my_id)->first();
                $col = DB::getSchemaBuilder()->getColumnListing($request['table']);

                $my_col = [];
                $my_db = [];
                foreach ($col as $key => $value) {
                    $my_col[$value] = ['val' => null, 'col' => $value, 'en' => $value, 'ar' => $value, 'type' => 'text', 'required' => true, 'required_message' => $value . ' is required'];
                    $my_db[$value] = null;
                    //  array_push($my_db,[$value=> null]);

                }
                return response()->json(['msg' => 'table_col successfully.', 'data' => $my_col, 'db' => $my_db], 200);
            }
            return 'no table selected';
        }

        if ($fun == 'view') {
            if (isset($request['text'])) {
                return $this->filter_fun($request['text']);
            }
            // return $this->create_new_exam($request->data);

            // return $my_first_school_id;


            // Assuming 'c_class' is your model name
            // $classes = c_class::where('school_id', $my_first_school_id)
            //     ->where(function ($query) use ($text) {
            //         $query->where('ar', 'like', '%' . $text . '%');
            //         $query->orWhere('en', 'like', '%' . $text . '%');
            //         $query->orWhere('detail', 'like', '%' . $text . '%');
            //     })
            //     ->get();
            // $c_classes =  c_class::where('school_id', $my_first_school_id)->orderBy('sequence', 'asc')->get();






            // $c_students =  c_student::where('school_id', $my_first_school_id)->where('deleted', 0)
            //     ->where(function ($query) use ($text, $classes) {
            //         $query->where('ar', 'like', '%' . $text . '%');
            //         $query->orWhere('en', 'like', '%' . $text . '%');
            //     })
            //     ->with('my_account', 'my_class')->limit(100)->orderBy('sequence', 'asc')->get();
            // $users = User::paginate(10);
            $users = User::limit(10)->get();

            return response()->json(['msg' => 'Data view successfully.', 'data' => $users], 200);
        }

        if ($fun == 'insert') {
            $my_data = $request->data['data'];
            /////////////////////////////////////////////////////////////


            //    $new_student =User::insert([
            //         'name' => $my_data['en'],
            //         'my_password' => $password,

            //         'email' => $email,
            //         'password' => bcrypt($password),
            //     ]);

            // $new_student = User::create([
            //     'name' => $my_data['en'],
            //     'my_password' => $password,
            //     'usertype' => 'student',
            //     'email' => $email,
            //     'password' => bcrypt($password),
            // ]);



            // $data = [
            //     'student_id' => $new_student->id,
            //     'admin_id' => Auth::user()->admin_id,
            //     'school_id' => $my_first_school_id,
            //     'class_id' => $my_data['class_id'],
            //     // 'detail'   => $my_data['detail'],
            //     'ar'       => $my_data['ar'],
            //     'en'       => $my_data['en'],
            // ];

            // c_student::insert($data);

            return 'inserted done ';
        }

        if ($fun == 'delete') {
            $data = $request->data['data'];

            // c_student::where('id', $data)->update(['deleted' => 1]);
            return 'delete done';
        }


        if ($fun == 'update') {
            $data = $request->data['data'];
            // return $data ;
            $data_to_update = [];
            // $student_id = $data['student_id'];


            // $data_to_update['en'] = $data['en'];
            // $data_to_update['ar'] = $data['ar'];
            // $data_to_update['birth_date'] = $data['birth_date'];
            // $data_to_update['national_id'] = $data['national_id'];
            // $data_to_update['nationality_ar'] = $data['nationality_ar'];
            // $data_to_update['nationality_en'] = $data['nationality_en'];
            // $data_to_update['notes'] = $data['notes'];
            // $data_to_update['paid'] = $data['paid'];
            // $data_to_update['passport'] = $data['passport'];
            // $data_to_update['task1'] = $data['task1'];
            // $data_to_update['en'] = $data['en'];
            // c_student::where('student_id', $student_id)->update($data_to_update);

            return 'update done';
        }
    }


    public function filter_fun($text)
    {
        $users = User::where('name', 'like', '%' . $text . '%')->limit(10)->get();

        return response()->json(['msg' => 'Data view successfully.', 'data' => $users], 200);
    }



    public function order_class($school_id, $class_id, $semester_id, $type)
    {
        // return 'uuuuuuu';
      $c_mark_total= c_mark_total::where('semester_id',$semester_id)->with('my_student') 
        ->whereHas('my_student', function ($query) use ($class_id) {
            $query->where('class_id', $class_id); // Use boolean expression for clarity
            //  $query->where('en', 'like', '%' . $text . '%');
            // // Ensure 'deleted' is a boolean attribute and is 0 for active users
            // if (Schema::hasColumn('users', 'deleted')) {
            //     $query->where('deleted', false); // Use boolean expression for clarity
            // } else {
            //     $query->where('deleted', 0); // Handle potential integer-based 'deleted'
            // }
        })
        ->get()->toArray();
// return $c_mark_total;

        // ==============================================my_mark_total current semester
 

        $c_subject_class_tea = c_subject_class_tea::where('class_id', $class_id)->with(['my_subject', 'my_subject_titles'])->get();
        $sum = 0; //مجموع الدرجات لكل المواد
        // Loop through the array of objects with key value
        foreach ($c_subject_class_tea as $key => $value) {
            foreach ($value['my_subject_titles'] as $key2 => $sub_tit) {
                if($sub_tit['semester_id']==$semester_id){

                    $sum = $sum + $sub_tit['highest_mark'];
                }
            }
        }

        // return  $sum;
         $c_students_class  = c_student::where('class_id', $class_id) ->get() ; //my_mark_total
 
foreach ($c_students_class as $key => $student) {
 $my_mark_total=c_mark_total::where('student_id',  $student['student_id'])->where('semester_id',  $semester_id)->first();
 $student['my_mark_total']=$my_mark_total;
 $student['total']=$my_mark_total['total'];

}


$c_students_class_sorted=$c_students_class->toArray();
        usort($c_students_class_sorted, function ($user1, $user2) {
            if (isset($user2['total'])) {
                return $user2['total'] <=> $nullsafeComparison = $user1['total'] ?? PHP_INT_MAX; // Handle potential null ages
            }
            // return $user2->total <=> $nullsafeComparison = $user1->total ?? PHP_INT_MAX; // Handle potential null ages
        });

// return $c_students_class_sorted;
        // return $c_student;//ooooooooooooooooooooooooooooooooooooooooooooo

        // order--------------------------------------------------------------------------

        $counter = 1;
        $last_total = null;

        $data2 = [];
        $data_full = [];

        // return $data2[0];
        foreach ($c_students_class_sorted  as $key => $student_data1) {
            // array_push($data2,  $student_data1 );


            if (isset($student_data1['my_mark_total']['total'])) { //mmmmmmmmmmmm
                if ($student_data1['my_mark_total']['semester_id'] == $semester_id) { //hhhhhhhhhhhhhh



                    if ($last_total != $student_data1['my_mark_total']['total']) {
                        if ($key != 0) {
                            $counter++;
                        }
                        // $counter++;
                    }
                    // ----------------------------------------------------------------
                    // $student_data1['order']= $counter;
                    //    return $student_data1['order'];
                    // $counter = $counter + 1;
                    // ------- ---------------------------------------------------------
                    // array_push($data2, $student_data1);




                    $total =   $student_data1['my_mark_total']['total'];
                    $student =   $student_data1['ar'];
                    // $student =   $student_data1['ar'];
                    $percent = $total  / $sum * 100;
                    $percent = round($percent, 2);
                    $data_one = [
                        'ar' => $student,
                        'en' =>  $student_data1['en'],
                    'data' => $student_data1,
                    'semester_id1' => $student_data1['my_mark_total']['semester_id'],
                    'semester_id2' => $semester_id,
                    'semester_id3' => $semester_id==$student_data1['my_mark_total']['semester_id'],
                    
                    'total' => $total,
                        'total_h' => $sum,
                        'order' => $counter,
                        'percent' => $percent,
                        'order_in_list' => $key + 1,
                    ];
                    array_push($data2, $data_one);


                    $last_total = $student_data1['my_mark_total']['total'];
                }else{
                $data_one = [
                    'ar' => $student_data1['ar'].'  errror____total',
                    'data' => $student_data1,
                    // 'semester_id' => $semester_id,
                    'semester_id1' => $student_data1['my_mark_total']['semester_id'],
                    'semester_id2' => $semester_id,
                    'semester_id3' => $semester_id==$student_data1['my_mark_total']['semester_id'],
                    
                    'en' =>  $student_data1['en'],
                    // 'total' => $total,
                    'total_h' => $sum,
                    'order' => $counter,
                    // 'percent' => $percent,
                    'order_in_list' => $key + 1,
                ];
                array_push($data2, $data_one);

            }




                // array_push($data2, '1');



            }
            // array_push($data2, [$student_data1['my_mark_total']['total'],]);


        } //foreach



        // $users = User::where('name', 'like', '%' . $class_id . '%')->limit(10)->get();

        return $data2;
        // return response()->json(['msg' => 'Data view successfully.', 'data' => $data2], 200);
    }
}
