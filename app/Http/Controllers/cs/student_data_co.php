<?php

namespace App\Http\Controllers\cs;

use App\Http\Controllers\Controller;
use App\Models\cs\c_student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class student_data_co extends Controller
{
    //

    public function student_data(Request $request)
    {
        $fun = $request->data['fun'];
        $my_id =  Auth::user()->id;
        $admin_id =  Auth::user()->admin_id;



        if ($fun == 'get_student_data') {
            return c_student::where('student_id', $my_id)->first();
        }


    

        
        if ($fun == 'save_student_data') {
            $db = $request->data['data'];

// return $db['birth_date'];
            $data = [
                "national_id" =>      $db['id'],
                "ar" =>               $db['name_arabic'],
                "en" =>               $db['name_english'],
                "nationality_ar" =>   $db['nationality_arabic'],
                "nationality_en" =>   $db['nationality_english'],
                "passport" =>         $db['passport_no'],
                "birth_date" =>       $db['birth_date'],
                "task1" =>            1,
                // "gmail" =>            $db['id'],
                // "history" =>          $db['id'],
            ];
            c_student::where('student_id', $my_id)->update($data);
            return $request->all();
            // return $this->create_new_exam($request->data);
        }
    }
}
