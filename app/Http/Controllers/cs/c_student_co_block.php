<?php

namespace App\Http\Controllers\cs;

use App\Http\Controllers\Controller;
use App\Models\cs\c_class;

use App\Models\cs\c_student;
use App\Models\cs\c_subject;
use App\Models\cs\c_subject_class_tea;
use App\Models\hrschool;
use App\Models\hrschooluser;

use App\Models\hruserdata;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class c_student_co_block extends Controller
{
    public function c_student_block(Request $request)
    {
        $fun = $request->data['fun'];
        $my_id =  Auth::user()->id;

        $school = hrschooluser::where('user_id', $my_id)->first();
        $my_first_school_id = null;
        if ($school) {
            $my_first_school_id = $school->school_id;
        }


        if ($fun == 'update_block_fun') {
                 $paid = $request->data['data'];
                 $id = $request->data['id'];
                 $filter_text = $request->data['filter_text'];
   $history=c_student::where('id',$id)->first(['paid_history']);
$paid_history=[];
if($history['paid_history']){
//   $paid_history=json_decode($history)->toArray();

  $data = json_decode($history, true);

}
  $status='Block';
if($paid==1){
$status='open';

}
$time=  Carbon::now('Asia/Riyadh')->format('h:i A');
// $time=  Carbon::now('Asia/Riyadh')->toDateTimeString();
$data_history=[
    'name'=>Auth::user()->name,
    'status'=>$status,
    'time'=>$time,

];
array_push($paid_history,$data_history);
$paid_history=json_encode($paid_history);
            c_student::where('id',$id)->update([
                'paid'        =>  $paid,
                'paid_history'=>  $paid_history
            ]);
            
return $this->show_student_filter($filter_text ,$my_first_school_id);
        }


        if ($fun == 'my_classes') {

            return  c_class::where('school_id', $my_first_school_id)->orderBy('sequence', 'asc')->get();

            return    $my_data = $request->all();
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
                'usertype' => 'student',
                'email' => $email,
                'password' => bcrypt($password),
            ]);



            $data = [
                'student_id' => $new_student->id,
                'admin_id' => Auth::user()->admin_id,
                'school_id' => $my_first_school_id,
                'class_id' => $my_data['class_id'],
                // 'detail'   => $my_data['detail'],
                'ar'       => $my_data['ar'],
                'en'       => $my_data['en'],
            ];

            c_student::insert($data);

            return 'inserted done ';
        }

        if ($fun == 'delete') {
            $data = $request->data['data'];

            c_student::where('id', $data)->update(['deleted' => 1]);
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

                c_student::where('id', $id)->update([$col => $val]);
                return 'update_col done';
            }
            return 'nothing from update_col  ';
        }

        if ($fun == 'update') {
            $data = $request->data['data'];
            // return $data ;
            $data_to_update = [];
            $student_id = $data['student_id'];
            $data_to_update['class_id'] = $data['class_id'];
            $data_to_update['paid'] = $data['paid'];
            $data_to_update['ar'] = $data['ar'];
            $data_to_update['en'] = $data['en'];
            // $data_to_update['detail'] = $data['detail'];


            c_student::where('student_id', $student_id)->update($data_to_update);

            return 'update done';
        }

        if ($fun == 'show') {
            // return $this->create_new_exam($request->data);
            $text = $request->data['data'];
            // return $my_first_school_id;


            // Assuming 'c_class' is your model name
            $classes = c_class::where('school_id', $my_first_school_id)
                ->where(function ($query) use ($text) {
                    $query->where('ar', 'like', '%' . $text . '%');
                    $query->orWhere('en', 'like', '%' . $text . '%');
                    $query->orWhere('detail', 'like', '%' . $text . '%');
                })
                ->get();
            $c_classes =  c_class::where('school_id', $my_first_school_id)->orderBy('sequence', 'asc')->get();

            if (count($classes) > 0) {


                $c_students =  c_student::where('school_id', $my_first_school_id)->where('deleted', 0)
                    ->where(function ($query) use ($text, $classes) {
                        $query->where('ar', 'like', '%' . $text . '%');
                        $query->orWhere('en', 'like', '%' . $text . '%');
                        $query->orWhere('class_id', 'like', $classes[0]['id']);
                    })
                    ->with('my_account', 'my_class')->limit(100)->orderBy('sequence', 'asc')->get();





                // $c_students =  c_student::where('school_id', $my_first_school_id)
                // ->where('deleted', 0)
                // ->where('ar', 'like', '%' . $text . '%')
                // ->orWhere('en', 'like', '%' . $text . '%')
                // ->orWhere('class_id', 'like', $classes[0]['id'])
                // ->with('my_account', 'my_class')->limit(100)->orderBy('sequence', 'asc')->get();

                return ['c_students' => $c_students,  'c_classes' => $c_classes];
            }








            // if(){

            // }
            // $c_students =  c_student::where('school_id', $my_first_school_id)
            // ->where('deleted', 0)
            // ->where('ar', 'like', '%' . $text . '%')
            // ->orWhere('en', 'like', '%' . $text . '%')
            // ->orWhere('class_id', 'like', '%' . $text . '%')
            // ->with('my_account', 'my_class')->limit(100)->orderBy('sequence', 'asc')->get();
            $c_students =  c_student::where('school_id', $my_first_school_id)->where('deleted', 0)
                ->where(function ($query) use ($text, $classes) {
                    $query->where('ar', 'like', '%' . $text . '%');
                    $query->orWhere('en', 'like', '%' . $text . '%');
                    // $query->orWhere('class_id', 'like', $classes[0]['id']);
                })
                ->with('my_account', 'my_class')->limit(100)->orderBy('sequence', 'asc')->get();


            // $c_student =  c_student::where('school_id', $my_first_school_id)->with('my_user')->get();
            // $c_subjects =  c_subject::where('school_id', $my_first_school_id)->get();

            return ['c_students' => $c_students,  'c_classes' => $c_classes];
        }
    }


    public function show_student_filter($text ,$my_first_school_id){


            // return $this->create_new_exam($request->data);
            // $text = $request->data['data'];
            // return $my_first_school_id;


            // Assuming 'c_class' is your model name
            $classes = c_class::where('school_id', $my_first_school_id)
                ->where(function ($query) use ($text) {
                    $query->where('ar', 'like', '%' . $text . '%');
                    $query->orWhere('en', 'like', '%' . $text . '%');
                    $query->orWhere('detail', 'like', '%' . $text . '%');
                })
                ->get();
            $c_classes =  c_class::where('school_id', $my_first_school_id)->orderBy('sequence', 'asc')->get();

            if (count($classes) > 0) {


                $c_students =  c_student::where('school_id', $my_first_school_id)->where('deleted', 0)
                    ->where(function ($query) use ($text, $classes) {
                        $query->where('ar', 'like', '%' . $text . '%');
                        $query->orWhere('en', 'like', '%' . $text . '%');
                        $query->orWhere('class_id', 'like', $classes[0]['id']);
                    })
                    ->with('my_account', 'my_class')->limit(100)->orderBy('sequence', 'asc')->get();




                return ['c_students' => $c_students,  'c_classes' => $c_classes];
            }






            $c_students =  c_student::where('school_id', $my_first_school_id)->where('deleted', 0)
                ->where(function ($query) use ($text, $classes) {
                    $query->where('ar', 'like', '%' . $text . '%');
                    $query->orWhere('en', 'like', '%' . $text . '%');
                    // $query->orWhere('class_id', 'like', $classes[0]['id']);
                })
                ->with('my_account', 'my_class')->limit(100)->orderBy('sequence', 'asc')->get();

            return ['c_students' => $c_students,  'c_classes' => $c_classes];

    }


}
