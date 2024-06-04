<?php

namespace App\Http\Controllers\cs;

use App\Http\Controllers\Controller;
use App\Models\cs\c_class;
use App\Models\cs\c_mark;
use App\Models\cs\c_mark_sum;
use App\Models\cs\c_mark_total;
use App\Models\cs\c_semester;
use App\Models\cs\c_student;
use App\Models\cs\c_subject_class_tea;
use App\Models\cs\c_subject_title;
use App\Models\cs\c_subject_title_sum;
use App\Models\cs\my_fun\calc_totals_m;
use App\Models\hrschool;
use App\Models\hrschooluser;
use Illuminate\Support\Facades\Config;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
// Route::post( 'calc_totals_ok', [ calc_totals_ok_co::class, 'calc_totals_ok' ] );
// php artisan route:cache

class calc_totals_ok_co extends Controller {
 
    public function calc_totals_ok( Request $request ) {
        $fun = $request[ 'fun' ];
        $my_id =  Auth::user()->id;
        $data = $request[ 'data' ];
        // $school = hrschooluser::where( 'user_id', $my_id )->first();
        // $my_first_school_id = null;
        // if ( $school ) {
        //     $my_first_school_id = $school->school_id;
        // }









        // calc_totals_order_class_grade_one_class
        // __________________________________________________

        if ( $fun == 'calc_totals_order_class_grade_one_class' ) {
            // $student_id = $request->student_id;
            $class_id = $request->class_id;
            $semester_id = $request->semester_id;
            $school_id   = $request->school_id;


            $c_students =  c_student::where( 'class_id', $class_id )->get();
            $res1 = [];
            $res2 = [];
            $res3 = [];


            foreach ( $c_students as $key => $student ) {
                $student_id = $student[ 'student_id' ];
                $res =   calc_totals_m::calc_totals_save( $student_id, $semester_id, $school_id );
                array_push( $res1, $res );
                usleep( 500 );
            }





            foreach ( $c_students as $key => $student ) {
                $student_id = $student[ 'student_id' ];

                $res  =     calc_totals_m::calc_semseter_student_order_class_save( $student, $semester_id, $school_id );
                array_push( $res2, $res );

                usleep( 500 );
            }
            usleep( 500 );

            foreach ( $c_students as $key => $student ) {

                $res =    calc_totals_m::calc_semseter_student_order_grade_save( $student, $semester_id, $school_id );
                array_push( $res3, $res );

                usleep( 500 );
            }

            // $c_mark_totals = c_mark_total::where( 'school_id', $school_id )->where( 'semester_id', $semester_id )->get();

            return response()->json( [
                'msg' => 'calc_totals_order_class_grade_one_class success',
                'msg2' =>  $class_id,
                'res1' =>  $res1,
                'res2' =>  $res2,
                'res3' =>  $res3,
                // 'data' =>  $c_mark_totals,
            ], 200 );







 
            // return response()->json( [ 'msg' => 'Data calc_totals_order_class_grade_one_class successfully.', 'data' => $data ], 200 );

        }


        // calc_totals_order_class_grade_one_class
        // __________________________________________________

        
        if ( $fun == 'calc_totals_ok_get_schools' ) {

            $schools = hrschool::where( 'admin_id', Auth::user()->admin_id )->where( 'active', 1 )->with( 'my_classes' )->get();

            return response()->json( [ 'msg' => 'Data calc_totals_ok_get_schools successfully.', 'data' => $schools ], 200 );

        }

        if ( $fun == 'calc_totals_ok_get_school_classes' ) {

            // $my_school =  hrschooluser::where( 'user_id', Auth::user()->id )-> first();
            $school_id = $request[ 'school_id' ];

            $school_classes = c_class::where( 'school_id', $school_id )
            ->with( [ 'my_students', 'my_subjects.my_subject' ] )
            ->get();

            foreach ( $school_classes as $key => $my_class ) {

                foreach ( $my_class[ 'my_subjects' ]  as $key => $my_subject ) {
                    $my_subject[ 'ar' ] = $my_subject[ 'my_subject' ][ 'ar' ] ;

                }
            }
            $semesters = c_semester::where( 'school_id', $school_id ) ->get();

            return response()->json( [ 'msg' => 'Data calc_totals_ok_get_school_classes successfully.', 'data' => $school_classes, 'semesters' => $semesters ], 200 );
        }

        if ( $fun == 'calc_totals_ok' ) {//$fun == 'calc_totals_ok' 
            set_time_limit( 1000 );

            $semester_id = $request->semester_id;
            $school_id   = $request->school_id;
            $mood   = $request->mood;
            if ( $mood == 'one' ) {

                $student_id = $request->student_id;
                $subject_id = $request->subject_id;
                $data =$this->calc_totals_ok_get_student_marks($school_id,$semester_id,$student_id,$subject_id);
                return response()->json( [
                    'msg'  => 'success',
                    'data' =>  $data,
                ], 200 );
            }


            


            return response()->json( [
                'msg'  => 'success',
                // 'data' =>  $data,
            ], 200 );
            
        }//$fun == 'calc_totals_ok' 
        
        if ( $fun == 'calc_totals_ok_fix_title_id' ) {//calc_totals_ok_fix_title_id
            
            // return $request->all();
            $semester_id = $request->semester_id;
            $school_id   = $request->school_id;
            
            $semester_1  = $request->semester_1 ;
            $semester_2  = $request->semester_2 ;
            $mood  = $request->mood ;

                if ( $mood == 2 ) {//one class

                // $student_id = $request->student_id;
                // $subject_id = $request->subject_id;
                 $class_id = $request->class_id;
                
                $data=[];
                $data1 =$this->fix_title_id_one_class($class_id,$semester_1,$semester_2 );
                array_push($data,$data1 );
                return response()->json( [
                    'msg'  => 'success mood == 1 class',
                      'data' =>  $data,
                ], 200 );
            }//one class


 

            if ( $mood == 1 ) {//one student


            $subject_id  = $request->subject_id ;
            $student_id  = $request->student_id ;
            $c_subject_title_s2 =   c_subject_title::where( 'semester_id', $semester_2 )->
                                                    where( 'subject_id', $subject_id )->
                                                    with( 'my_subject', 'my_semester' )->
                                                    get();
            $c_subject_title_s1 =   c_subject_title::where( 'semester_id', $semester_1 )->
                                                    where( 'subject_id', $subject_id )->
                                                    with( 'my_subject', 'my_semester' )->
                                                    get();
            
            $c_mark  = c_mark::where( 'semester_id', $semester_1 )->
            where( 'subject_id', $subject_id )->with( 'my_subject', 'my_semester' )->
            where( 'student_id', $student_id )->
            get();
            
            foreach ($c_subject_title_s2 as $key => $title) {
                $c_mark  = c_mark::where( 'semester_id', $semester_1 )->
                where( 'subject_id', $subject_id )->
                where( 'student_id', $student_id )->
                where( 'subject_title_id', $title['id'] )->
                update(['subject_title_id'=>$c_subject_title_s1[$key]['id']]);


              }
            
            
            
            $c_subject_title_sum_s1 =  c_subject_title_sum::where( 'semester_id', $semester_1 )->
            where( 'subject_id', $subject_id )->first();
            $c_subject_title_sum_s2 =  c_subject_title_sum::where( 'semester_id', $semester_2 )->
            where( 'subject_id', $subject_id )->first();
            $c_mark_sum = c_mark_sum::where( 'semester_id', $semester_1 )->
            where( 'subject_id', $subject_id )->
            where( 'student_id', $student_id )->
            where( 'subject_title_sum_id', $c_subject_title_sum_s2['id'] )->
            
            update(['subject_title_sum_id'=> $c_subject_title_sum_s1['id']]);
            return 'done mood =1 student';
        }

 return 'nothing';


        }
        
        
        
        //calc_totals_ok_fix_title_id
        //calc_totals_ok_fix_title_id
        // ______________________________________________________________________

        if ( $fun == 'calc_totals_ok_2' ) {
            set_time_limit( 1000 );

            $semester_id = $request->semester_id;
            $school_id   = $request->school_id;
            $mood   = $request->mood;
            if ( $mood == 'one' ) {

                $student_id = $request->student_id;
                $subject_id = $request->subject_id;

            }
            return  $request->all();
            // $student    = $request->student ;
            // $student_id   = $request->student[ 'student_id' ];
            $c_students =  c_student::where( 'school_id', $school_id )->get();
            $res1 = [];
            $res2 = [];
            $res3 = [];
            foreach ( $c_students as $key => $student ) {
                $student_id = $student[ 'student_id' ];

                $res =   calc_totals_m::calc_totals_save( $student_id, $semester_id, $school_id );
                array_push( $res1, $res );

                usleep( 500 );
            }

            usleep( 500 );

            foreach ( $c_students as $key => $student ) {
                $student_id = $student[ 'student_id' ];

                $res  =     calc_totals_m::calc_semseter_student_order_class_save( $student, $semester_id, $school_id );
                array_push( $res2, $res );

                usleep( 500 );
            }
            usleep( 500 );

            foreach ( $c_students as $key => $student ) {

                $res =    calc_totals_m::calc_semseter_student_order_grade_save( $student, $semester_id, $school_id );
                array_push( $res3, $res );

                usleep( 500 );
            }

            $c_mark_totals = c_mark_total::where( 'school_id', $school_id )->where( 'semester_id', $semester_id )->get();

            return response()->json( [
                'msg' => 'success',
                // 'res1' =>  $res1,
                // 'res2' =>  $res2,
                // 'res3' =>  $res3,
                'data' =>  $c_mark_totals,
            ], 200 );

            // return [ $request->all() ];
        }

        if ( $fun == 'tables' ) {
            $database = Config::get( 'database.connections.mysql.database' );

            //   $tables = DB::select( "SELECT table_name FROM information_schema.tables WHERE table_schema = '{$database_name}'" );
            $tables = DB::select( "SELECT table_name FROM information_schema.tables WHERE table_schema = '{$database}'" );

            // $result = 'SHOW TABLES FROM '.$database;
            // $rows = DB::select( "SELECT table_name FROM information_schema.tables WHERE table_schema = '{$db_name}' AND table_name like '%{$search}%'" );
            // return response()->json( [ 'msg' => 'table_col successfully.', 'data' => $tables ], 200 );

            $table_names = [];
            foreach ( $tables as $row ) {

                array_push( $table_names, [ 'label'=> $row->TABLE_NAME, 'value'=> $row->TABLE_NAME ] );
                // $table_names[] = $row->table_name;
            }
            return response()->json( [ 'msg' => 'table_col successfully.', 'data' => $table_names ], 200 );

        }

        if ( $fun == 'table_col' ) {
            if ( isset( $request[ 'table' ] ) ) {

                //  $col = DB::table( $request[ 'table' ] )->where( '', $my_id )->first();
                $col = DB::getSchemaBuilder()->getColumnListing( $request[ 'table' ] );

                $my_col = [];
                $my_db = [];
                foreach ( $col as $key => $value ) {
                    $my_col[ $value ] = [ 'val'=> null, 'col'=> $value, 'en'=> $value, 'ar'=> $value, 'type'=> 'text', 'required'=> true, 'required_message'=> $value.' is required' ];
                    $my_db[ $value ] = null;
                    //  array_push( $my_db, [ $value=> null ] );

                }
                return response()->json( [ 'msg' => 'table_col successfully.', 'data' => $my_col, 'db' => $my_db ], 200 );

            }
            return 'no table selected';

        }

    }
     public function calc_totals_ok_get_student_marks($school_id,$semester_id,$student_id,$subject_id) {


        $c_subject_title =   c_subject_title::where( 'semester_id', $semester_id )->
        where( 'subject_id', $subject_id )->with( 'my_subject', 'my_semester' )->get();

        $c_subject_title_sum =  c_subject_title_sum::where( 'semester_id', $semester_id )->
        where( 'subject_id', $subject_id )->with( 'my_subject', 'my_semester' )->get();

        $c_mark  = c_mark::where( 'semester_id', $semester_id )->
        where( 'subject_id', $subject_id )->with( 'my_subject', 'my_semester' )->
        where( 'student_id', $student_id )->
        get();
        $c_mark_all  = c_mark::where( 'semester_id', $semester_id )->with( 'my_subject', 'my_semester' )->
        where( 'student_id', $student_id )->
        get();
        $c_mark_all_sum  = c_mark::where( 'semester_id', $semester_id )->with( 'my_subject', 'my_semester' )->
        where( 'student_id', $student_id )->
        sum( 'mark' );

        foreach ( $c_mark as $key => $mark ) {
            $mark[ 'subject'  ] = $mark[ 'my_subject'  ][ 'ar' ];
            $mark[ 'semester' ] = $mark[ 'my_semester' ][ 'ar' ];
            unset( $mark[ 'my_subject'  ] );
            unset( $mark[ 'my_semester' ] );
        }

        $c_mark_sum = c_mark_sum::where( 'semester_id', $semester_id )->
        where( 'subject_id', $subject_id )->
        where( 'student_id', $student_id )->with( 'my_semester' )->
        get();

        $c_mark_total = c_mark_total::where( 'semester_id', $semester_id )->
        //  where( 'subject_id', $subject_id )->
        where( 'student_id', $student_id )->with( 'my_semester' )->
        get();

        return [
            'c_subject_title'    =>$c_subject_title    ,
            'c_mark'             =>$c_mark             ,
            'c_mark_sum'         =>$c_mark_sum         ,
            'c_mark_total'       =>$c_mark_total       ,
            'c_subject_title_sum'=>$c_subject_title_sum,
            'c_mark_all'         =>$c_mark_all         ,
            'c_mark_all_sum'     =>$c_mark_all_sum     ,

        ];
     }

 
     public function  fix_title_id_one_class($class_id,$semester_1,$semester_2 ){//fix_title_id_one_class
      $my_subjects =  c_class::where('id',$class_id )->with('my_subjects','my_students')->first();
      $stu=[];
$err=[];
foreach ($my_subjects['my_subjects'] as $key1 => $subject) {//my_subjects
    // $subject['id'];
    $subject_id= $subject['subject_id'];

$c_subject_title_s2 =   c_subject_title::where( 'semester_id', $semester_2 )->
                                        where( 'subject_id', $subject_id )->
                                        with( 'my_subject', 'my_semester' )->
                                        get();
$c_subject_title_s1 =   c_subject_title::where( 'semester_id', $semester_1 )->
                                        where( 'subject_id', $subject_id )->
                                        with( 'my_subject', 'my_semester' )->
                                        get();



                                        $c_subject_title_sum_s1 =  c_subject_title_sum::where( 'semester_id', $semester_1 )->
                                        where( 'subject_id', $subject_id )->first();
                                        $c_subject_title_sum_s2 =  c_subject_title_sum::where( 'semester_id', $semester_2 )->
                                        where( 'subject_id', $subject_id )->first();
                                        
                                        if(!$c_subject_title_sum_s1){
                                            array_push($err,'c_subject_title_sum_s1 not found : '.$subject['ar'] );
                                            
                                        
                                        }
                                        
                                        if(!$c_subject_title_sum_s2){
                                            array_push($err,'c_subject_title_sum_s2 not found '.$subject['ar'] );
                                        }






    foreach ($my_subjects['my_students'] as $key2 => $student) {
//    return $student ;
   $student_id= $student['student_id'];
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 array_push($stu,[$student_id,$student['ar'] ,$subject['ar']] );


// $c_mark  = c_mark::where( 'semester_id', $semester_1 )->
// where( 'subject_id', $subject_id )->with( 'my_subject', 'my_semester' )->
// where( 'student_id', $student_id )->
// get();

foreach ($c_subject_title_s2 as $key3 => $title) {
     c_mark::where( 'semester_id', $semester_1 )->
    where( 'subject_id', $subject_id )->
    where( 'student_id', $student_id )->
    where( 'subject_title_id', $title['id'] )->
    update(['subject_title_id'=>$c_subject_title_s1[$key3]['id']]);


  }




if($c_subject_title_sum_s1&&$c_subject_title_sum_s1){
 

 c_mark_sum::where( 'semester_id', $semester_1 )->
where( 'subject_id', $subject_id )->
where( 'student_id', $student_id )->
where( 'subject_title_sum_id', $c_subject_title_sum_s2['id'] )->

update(['subject_title_sum_id'=> $c_subject_title_sum_s1['id']]);
}

// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

}//my_students



}//my_subjects


return ['done mood =1 student',$err];


     }//fix_title_id_one_class

}
