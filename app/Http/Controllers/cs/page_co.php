<?php

namespace App\Http\Controllers\cs;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
// Route::post('page', [page_co::class, 'page']);
// php artisan route:cache
class page_co extends Controller
{
    public function page(Request $request)
    {
        $fun = $request['fun'];
        $my_id =  Auth::user()->id;
        $data = $request['data'];
        // $school = hrschooluser::where('user_id', $my_id)->first();
        // $my_first_school_id = null;
        // if ($school) {
        //     $my_first_school_id = $school->school_id;
        // }



if ($fun == 'tables') {
    $database = Config::get('database.connections.mysql.database');

    //   $tables = DB::select("SELECT table_name FROM information_schema.tables WHERE table_schema = '{$database_name}'");
      $tables = DB::select("SELECT table_name FROM information_schema.tables WHERE table_schema = '{$database}'");

// $result = "SHOW TABLES FROM ".$database;
// $rows = DB::select("SELECT table_name FROM information_schema.tables WHERE table_schema = '{$db_name}' AND table_name like '%{$search}%'");
// return response()->json(['msg' => 'table_col successfully.', 'data' => $tables], 200);

$table_names = [];
foreach($tables as $row)
{
      
    
                               
    array_push($table_names,['label'=> $row->TABLE_NAME ,'value'=> $row->TABLE_NAME] );
    // $table_names[] = $row->table_name;
}
return response()->json(['msg' => 'table_col successfully.', 'data' => $table_names], 200);

}




        
if ($fun == 'table_col') {
if(isset( $request['table'])) {

        //  $col=DB::table($request['table'])->where('',$my_id)->first();
         $col=DB::getSchemaBuilder()->getColumnListing($request['table']);

  $my_col=[];
  $my_db=[];
foreach ($col as $key => $value) {
    $my_col[$value] = ['val'=> null,'col'=> $value,'en'=> $value,'ar'=> $value,'type'=> 'text','required'=> true,'required_message'=> $value.' is required'];
  $my_db[$value]=null;
//  array_push($my_db,[$value=> null]);
     
  }
  return response()->json(['msg' => 'table_col successfully.', 'data' => $my_col, 'db' => $my_db], 200);


                    }
                  return 'no table selected';  
}

        if ($fun == 'view') {
            if(isset( $request['text'])) {
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
    
    
    public function filter_fun( $text){
        $users = User::where('name', 'like', '%' . $text . '%')->limit(10)->get();

        return response()->json(['msg' => 'Data view successfully.', 'data' => $users], 200);
    }
}
