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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class c_teacher_co extends Controller
{
    public function c_teacher(Request $request)
    {
        $fun = $request->data['fun'];
        $my_id =  Auth::user()->id;

        $school = hrschooluser::where('user_id', $my_id)->first();
        $my_first_school_id = null;
        if ($school) {
            $my_first_school_id = $school->school_id;
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
            $email = $firstName . '_' . $lastName . $random . '@' . $url_name ;
            $email = str_replace(' ', '_', $email);
            // $password = $url_name . '2023';
            $password =  'forqan2023';

            //    $new_student =User::insert([
            //         'name' => $my_data['en'],
            //         'my_password' => $password,

            //         'email' => $email,
            //         'password' => bcrypt($password),
            //     ]);

            $new_teacher = User::create([
                'admin_id' =>Auth::user()->admin_id,
                'name' => $my_data['en'],
                'my_password' => $password,
                'email' => $email,
                'usertype' => 'teacher',
                'password' => Hash::make($password),

                // 'password' => bcrypt($password),
            ]);



            $data = [
                'user_id' => $new_teacher->id,
                'admin_id' => Auth::user()->admin_id,
                // 'school_id' => $my_first_school_id,
                // 'class_id' => $my_data['class_id'],
                'detail'   => $my_data['detail'],
                'ar'       => $my_data['ar'],
                'en'       => $my_data['en'],
            ];

            hruserdata::insert($data);

            $data = [
                'user_id' => $new_teacher->id,
                'admin_id' => Auth::user()->admin_id,
                'school_id' => $my_first_school_id,
                // 'class_id' => $my_data['class_id'],
                // 'detail'   => $my_data['detail'],
                // 'ar'       => $my_data['ar'],
                // 'en'       => $my_data['en'],
            ];

            hrschooluser::insert($data);



// teacher permission________________________________________

            $user = User::find($new_teacher->id);
            // return $user->roles;
            // ============= sync permissions=====================================================
            $permissions_ids = [18];//teacher_home id=18 from table permissions
            // foreach ($user->roles as $key => $role) {

            //     foreach ($role->permissions as $key => $permission) {
            //         array_push($permissions_ids, $permission['id']);
            //     }
            // }
            $user->permissions()->sync($permissions_ids);
            // ============= sync permissions=====================================================



// teacher permission________________________________________






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

        if ($fun == 'show') {
            // return $this->create_new_exam($request->data);
            $text = $request->data['data'];
            // return $my_first_school_id;


            //$classes Assuming 'c_class' is your model name
            // $teachers = hrschooluser::where('school_id', $my_first_school_id)->with([
            //     'my_user' => function ($query) use ($text) {
            //         $query->where('deleted', 0); // Filter my_students with deleted=1
            //         $query->where('ar', 'like', '%' . $text . '%');
            //         $query->orWhere('en', 'like', '%' . $text . '%');
            //         $query->orWhere('detail', 'like', '%' . $text . '%');
            //     }

            // ])use ($text)


            $c_classes =  c_class::where('school_id', $my_first_school_id)->orderBy('sequence', 'asc')->get();

            if ($text != null || $text != '') {


                $teachers = hruserdata::where('deleted', 0)
                    ->whereHas('my_school', function ($query) use ($my_first_school_id) {
                        $query->where('school_id', $my_first_school_id); // Use boolean expression for clarity
                        //  $query->where('en', 'like', '%' . $text . '%');
                        // // Ensure 'deleted' is a boolean attribute and is 0 for active users
                        // if (Schema::hasColumn('users', 'deleted')) {
                        //     $query->where('deleted', false); // Use boolean expression for clarity
                        // } else {
                        //     $query->where('deleted', 0); // Handle potential integer-based 'deleted'
                        // }
                    })
                    ->whereHas('my_school', function ($query) use ($text) {
                        $query->whereRaw("LOWER(en) LIKE ?", ['%' . strtolower($text) . '%']);

                        $query->orWhere('ar', 'like', '%' . $text . '%');
                        //  $query->orWhere('en', 'like', '%' . $text . '%');
                        // // Ensure 'deleted' is a boolean attribute and is 0 for active users
                        // if (Schema::hasColumn('users', 'deleted')) {
                        //     $query->where('deleted', false); // Use boolean expression for clarity
                        // } else {
                        //     $query->where('deleted', 0); // Handle potential integer-based 'deleted'
                        // }
                    })
                    ->with('my_school', 'my_user', 'my_classes.my_class')
                    // ->get();
                    ->orderBy('sequence', 'asc')->get();

                if (count($teachers) > 0) {

                    return ['c_teachers' => $teachers,  'c_classes' => $c_classes];
                }
            }




            $teachers = hruserdata::where('deleted', 0)
                ->whereHas('my_school', function ($query) use ($my_first_school_id) {
                    $query->where('school_id', $my_first_school_id); // Use boolean expression for clarity

                    // // Ensure 'deleted' is a boolean attribute and is 0 for active users
                    // if (Schema::hasColumn('users', 'deleted')) {
                    //     $query->where('deleted', false); // Use boolean expression for clarity
                    // } else {
                    //     $query->where('deleted', 0); // Handle potential integer-based 'deleted'
                    // }
                })
                ->with('my_school', 'my_user', 'my_classes.my_class')
                // ->get();
                ->orderBy('sequence', 'asc')->get();






            if (count($teachers) > 0) {


                // $c_students =  c_student::where('school_id', $my_first_school_id) ->where('deleted', 0)
                //         ->where(function ($query) use ($text,$classes) {
                //             $query->where('ar', 'like', '%' . $text . '%');
                //             $query->orWhere('en', 'like', '%' . $text . '%');
                //             $query->orWhere('class_id', 'like', $classes[0]['id']);
                //         })
                //         ->with('my_account', 'my_class')->limit(100)->orderBy('sequence', 'asc')->get();





                // $c_students =  c_student::where('school_id', $my_first_school_id)
                // ->where('deleted', 0)
                // ->where('ar', 'like', '%' . $text . '%')
                // ->orWhere('en', 'like', '%' . $text . '%')
                // ->orWhere('class_id', 'like', $classes[0]['id'])
                // ->with('my_account', 'my_class')->limit(100)->orderBy('sequence', 'asc')->get();


                return ['c_teachers' => $teachers,  'c_classes' => $c_classes];
            }

            return ['not found'];







            // if(){

            // }
            // $c_students =  c_student::where('school_id', $my_first_school_id)
            // ->where('deleted', 0)
            // ->where('ar', 'like', '%' . $text . '%')
            // ->orWhere('en', 'like', '%' . $text . '%')
            // ->orWhere('class_id', 'like', '%' . $text . '%')
            // ->with('my_account', 'my_class')->limit(100)->orderBy('sequence', 'asc')->get();
            // $c_students =  c_student::where('school_id', $my_first_school_id) ->where('deleted', 0)
            //         ->where(function ($query) use ($text,$classes) {
            //             $query->where('ar', 'like', '%' . $text . '%');
            //             $query->orWhere('en', 'like', '%' . $text . '%');
            //             // $query->orWhere('class_id', 'like', $classes[0]['id']);
            //         })
            //         ->with('my_account', 'my_class')->limit(100)->orderBy('sequence', 'asc')->get();


            // // $c_student =  c_student::where('school_id', $my_first_school_id)->with('my_user')->get();
            // // $c_subjects =  c_subject::where('school_id', $my_first_school_id)->get();

            // return ['c_students' => $c_students,  'c_classes' => $c_classes];

        }
    }
}
