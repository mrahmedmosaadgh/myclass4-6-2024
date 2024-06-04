<?php

namespace App\Http\Controllers\cs;

use App\Http\Controllers\Controller;
use App\Models\cs\c_mark_grade_letter;
use Illuminate\Support\Facades\Config;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
// Route::post('marks_letter', [c_semester_report_final_co::class, 'semester_report_final']);
// php artisan route:cache
// /api/school_admin/semester_report_final
class c_semester_report_final_co extends Controller
{
    public function semester_report_final(Request $request)
    {
        $fun = $request['fun'];
        $my_id =  Auth::user()->id;
        $data = $request['data'];


        if ($fun == 'view') {
 

            $c_mark_grade_letter = c_mark_grade_letter::where('school_id',$request['school_id'])->get();

            return response()->json(['msg' => 'Data view successfully.', 'data' => $c_mark_grade_letter], 200);
        }

        if ($fun == 'insert') {
            // $my_data = $request->data['data'];
            /////////////////////////////////////////////////////////////
 

            $data = [
                'admin_id' => Auth::user()->admin_id,
                'school_id' => $request->data['school_id'],
                'from' => $request->data['from'],
                'to'       => $request->data['to'],
                'letter'       => $request->data['letter'],
                'notes'       => $request->data['notes'],
             
            ];

            c_mark_grade_letter::insert($data);

            return 'inserted done ';
        }

        if ($fun == 'delete') {
            // $data = $request->data['data'];
            $id = $data['id'];

            c_mark_grade_letter::where('id', $id)->delete();
            // return 'delete done';
            return response()->json(['msg' => 'data deleted   successfully.', 'data' => ''], 200);

        }


        if ($fun == 'update') {
            $data = $request['data'];
            //   return $data ;
            $data_to_update = [];
            $id = $data['id'];


            $data_to_update['from'] = $data['from'];
            $data_to_update['to'] = $data['to'];
            $data_to_update['notes'] = $data['notes'];
            $data_to_update['letter'] = $data['letter'];
            // $data_to_update['national_id'] = $data['national_id'];
            // $data_to_update['nationality_ar'] = $data['nationality_ar'];
            // $data_to_update['nationality_en'] = $data['nationality_en'];
            // $data_to_update['notes'] = $data['notes'];
            // $data_to_update['paid'] = $data['paid'];
            // $data_to_update['passport'] = $data['passport'];
            // $data_to_update['task1'] = $data['task1'];
            // $data_to_update['en'] = $data['en'];
            c_mark_grade_letter::where('id', $id)->update($data_to_update);
            return response()->json(['msg' => 'data updated   successfully.', 'data' =>''], 200);

            // return 'update done';
        }
    }
    
    
    public function filter_fun( $text){
        $users = User::where('name', 'like', '%' . $text . '%')->limit(10)->get();

        return response()->json(['msg' => 'Data view successfully.', 'data' => $users], 200);
    }
}
