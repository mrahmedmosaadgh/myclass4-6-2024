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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class c_student_co extends Controller
{
    public function c_student(Request $request)
    {
        $fun = null;
// return $request->all();
        if(isset($request->data['fun'])){
          $fun = $request->data['fun'];
      }
        if(isset($request['fun'])){
          $fun = $request['fun'];
      }



    //   return Inertia::share('classview/admin/data/control_admin_data', ['uuuu_________________'=>Auth::user()]);
    //   return Inertia::render('classview/admin/data/control_admin_data', ['uuuu_________________'=>Auth::user()]);
    //   Inertia::share('postData___________', Auth::user());

    //   return response()->json();


    //  return Inertia ::share('admin.data', ['uuuu_________________'=>Auth::user()]);
       response()->json([['ok',Auth::user()]  
        // Additional response data (optional)
    ]);
      return ['ok',Auth::user()]  ;
      return Auth::guest() ;
    //   return  $my_id =  Auth::user()->id;

        $school = hrschooluser::where('user_id', $my_id)->first();
        $my_first_school_id = null;
        if ($school) {
            $my_first_school_id = $school->school_id;
        }






        if ($fun == 'my_classes') {

                      return   c_class::where('school_id', $my_first_school_id)->orderBy('sequence', 'asc')->get();
 // Loop through the array of objects with key value
//  foreach ( $c_class as $key => $value) {

//    }
            // return    $my_data = $request->all();
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

            $c_student= c_student::where('id', $data)->first();
           $student_id=$c_student['student_id'];
            c_student::where('id', $data)->update(['deleted' => 1]);
            User::where('id', $student_id)->update(['deleted' => 1]);
            return ['delete done',$request->data];
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
            // $data_to_update['paid'] = $data['paid'];
            // $data_to_update['ar'] = $data['ar'];
            // $data_to_update['en'] = $data['en'];
            // $data_to_update['detail'] = $data['detail'];
            try {
    $data_to_update['class_id'] = $data['class_id'];
    $data_to_update['en'] = $data['en'];
    $data_to_update['ar'] = $data['ar'];
    $data_to_update['birth_date'] = $data['birth_date'];
    $data_to_update['national_id'] = $data['national_id'];
    $data_to_update['nationality_ar'] = $data['nationality_ar'];
    $data_to_update['nationality_en'] = $data['nationality_en'];
    $data_to_update['notes'] = $data['notes'];
    $data_to_update['paid'] = $data['paid'];
    $data_to_update['passport'] = $data['passport'];
    $data_to_update['task1'] = $data['task1'];
    // $data_to_update['en'] = $data['en'];
                c_student::where('student_id', $student_id)->update($data_to_update);

            return 'update done';
} catch (\Throwable $th) {
    return ['update error',$th];
   
}


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

        if ($fun == 'show_no_class') {
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
                        // $query->where('ar', 'like', '%' . $text . '%');
                        // $query->orWhere('en', 'like', '%' . $text . '%');
                        $query->orWhere('class_id', null);
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
}
