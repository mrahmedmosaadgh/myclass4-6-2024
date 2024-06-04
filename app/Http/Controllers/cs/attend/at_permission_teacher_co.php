<?php

namespace App\Http\Controllers\cs\attend;

use App\Http\Controllers\Controller;
use App\Models\attendance_teachers_permission;
use App\Models\cs\c_calendar;
use App\Models\hrschooluser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// Route::post('at_permission_teacher', [at_permission_teacher_co::class, 'at_permission_teacher']);
// php artisan route:cache
class at_permission_teacher_co extends Controller
{
    public function at_permission_teacher(Request $request)
    {
        $fun = $request['fun'];
        $my_id =  Auth::user()->id;
        $data = $request['data'];
        $school = hrschooluser::where('user_id', $my_id)->first();
        $school_id= $school->school_id;
        // $my_first_school_id = null;
        // if ($school) {
        //     $my_first_school_id = $school->school_id;
        // }



        if ($fun == 'view') {

            if(isset( $request['text'])) {
return $this->filter_fun($request['text']);
            }
            // Loop through the array of objects with key value ->orderedByDateDesc()
            $attendance_teachers_permission = attendance_teachers_permission::where('user_id', $my_id)->with('my_calendar') ->get();
            foreach ($attendance_teachers_permission as $key => $value) {
                if ($value['my_calendar']) {
                    $value['calendar_id'] = $value['my_calendar']['id'];
                    $value['date'] = $value['my_calendar']['date'];
                }
            }
             $result=[];
            $result['dates']=$this->get_date_to_choose();//
            // Loop through the array of objects with key value
            // foreach ( $result['dates'] as $key => $value) {
            //     $value['value'] = $value['id'];
            //     $value['label'] = $value['date'];
            //   }
            // array_push($result, ['permissions' => $attendance_teachers_permission]);
            // array_push($result, ['msg' => 'Data loaded successfully.']);->orderBy('date', 'desc')

            // $result['permissions']=$attendance_teachers_permission;
            $per=$attendance_teachers_permission->sortByDesc(function ($attendance) {
                return $attendance['my_calendar'] ? $attendance['my_calendar']['date'] : null;
            })->toArray();
            // Loop through the array of objects with key value

             $per2=[];
            foreach ($per as $key => $value) {
                // Print the key and the name and price properties of the object
                // echo $key . ": " . $value['name'] . " - " . $value['price'] . "\n";
                array_push($per2,$value );
              }
            $result['permissions']=$per2;


            $result['school']=hrschooluser::where('user_id',$my_id)->first();
 


            
            $result['msg']='Data loaded successfully.';

            return response()->json(['msg' => 'Data view successfully.', 'data' => $result], 200);
        }

        if ($fun == 'insert') {
             $my_data = $request->data ;
            /////////////////////////////////////////////////////////////
$db=[];
$db["admin_id"        ]             =  Auth::user()->admin_id;
$db["user_id"         ]             = $my_id;
$db["school_id"         ]             = $school_id;

$db["calendar_id"     ]             = $my_data["calendar_id"     ];
$db["type"            ]             = $my_data["type"            ];
$db["details"         ]             = $my_data["details"         ];
$db["category"        ]             = $my_data["category"        ];
$db["sugestion_leave" ]             = $my_data["sugestion_leave" ];
$db["sugestion_return"]             = $my_data["sugestion_return"];
 
$attendance_teachers_permission=attendance_teachers_permission::where("user_id",$my_id)->
                                where("calendar_id",$my_data["calendar_id"     ])->
                                get();
if(count($attendance_teachers_permission)> 0){
    return response()->json(["msg"=> "found before","data"=> $db] ,200); 
}
$attendance_teachers_permission=attendance_teachers_permission::insert($db);
 return response()->json(["msg"=> "insert done","data"=> $attendance_teachers_permission] ,200);
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
             
            $attendance_teachers_permission=attendance_teachers_permission::where("id",$request->data['id'])->delete();

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

            $my_data = $request->data ;
            /////////////////////////////////////////////////////////////
$db=[];
$db["admin_id"        ]             =  Auth::user()->admin_id;
$db["user_id"         ]             = $my_id;
$db["school_id"         ]             = $school_id;

$db["calendar_id"     ]             = $my_data["calendar_id"     ];
$db["type"            ]             = $my_data["type"            ];
$db["details"         ]             = $my_data["details"         ];
$db["category"        ]             = $my_data["category"        ];
$db["sugestion_leave" ]             = $my_data["sugestion_leave" ];
$db["sugestion_return"]             = $my_data["sugestion_return"];
 
$attendance_teachers_permission=attendance_teachers_permission::where("user_id",$my_id)->
                                where("calendar_id",$my_data["calendar_id"     ])->
                                get();
if(count($attendance_teachers_permission)> 1){
    return response()->json(["msg"=> "found before","data"=> $db] ,200); 
}
$attendance_teachers_permission=attendance_teachers_permission::where("user_id",$my_id)->where("calendar_id",$my_data["calendar_id"     ])->update($db);
 return response()->json(["msg"=> "update done","data"=> $attendance_teachers_permission] ,200);





            // return 'update done';
        }
    }
    
    
    public function filter_fun( $text){
        $users = User::where('name', 'like', '%' . $text . '%')->limit(10)->get();

        return response()->json(['msg' => 'Data view successfully.', 'data' => $users], 200);
    }

    public function get_date_to_choose()
    {
        $today = Carbon::today();
        $startDate = $today->toDateTimeString();;
        $endDate = $today->addDays(2)->toDateTimeString();

        $c_calendar_dates = c_calendar::where('day_off', 0)->whereBetween('date', [$startDate, $endDate])
            ->with('my_permission')
            ->get();
        $permissions = attendance_teachers_permission::where('user_id', Auth::user()->id)->get();

$dates=[] ;
$ok=0 ;
        //remove date have permission_____________________
        foreach ($c_calendar_dates as $key1 => $calendar_item) {
        foreach ($permissions as $key => $value) {
                if ($value['calendar_id'] == $calendar_item['id']) {
 
unset($c_calendar_dates[$key1]);
                } 
 
            }

 


//  array_push($dates, ['value'=>$calendar_item['id'],'label'=>$calendar_item['date'] ]);



        }



        // Loop through the array of objects with key value
        foreach ($c_calendar_dates as $key => $value) {
 
            array_push($dates, ['value'=>$value['id'],'label'=>$value['date'] ]);
            // array_push($dates, ['value'=>$calendar_item['id'],'label'=>$calendar_item['date'] ]);
          }

        return  $dates ;
    }
}
