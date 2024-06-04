<?php

namespace App\Http\Controllers\cs;

use App\Http\Controllers\Controller;
use App\Models\cs\c_class;
use App\Models\cs\c_mark;
use App\Models\cs\c_mark_grade_letter;
use App\Models\cs\c_mark_sum;
// use App\Models\cs\c_exam;
// use App\Models\cs\c_exam_grade;
// use App\Models\cs\c_exam_mark;
use App\Models\cs\c_semester;
use App\Models\cs\c_subject;
use App\Models\cs\c_subject_category;
use App\Models\cs\c_subject_class_tea;
use App\Models\cs\c_subject_title;
use App\Models\cs\c_subject_title_sum;
use App\Models\hrschoolclass;
use App\Models\hrschoolclasssubjectteacher;
use App\Models\hrschoolexam;
use App\Models\hrschoolexammark;
use App\Models\hrschoolexammarktotal;
use App\Models\hrschoolgradesubjectmark;
use App\Models\hrschoolmarksetup;
use App\Models\hrschoolsemester;
use App\Models\hrschoolsubject;
use App\Models\hrschooluser;
use App\Models\cs\c_student;
use App\Models\hruserdata;
use App\Models\cs\my_fun\marks_main_m;
use App\Models\hryear;
use App\Models\User;
// use App\Models\Wallet;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class marks_main_co extends Controller
{






    public function marks_main(Request $request)
    {
   
        $fun = $request->fun ;
        $my_id =  Auth::user()->id;
        $admin_id =  Auth::user()->admin_id;

        if ( $fun == 'marks_pre_data_view' ) {

            $school_id = $request[ 'school_id' ];
            $year_id = hryear::where( 'admin_id', Auth::user()->admin_id )->where( 'active', 1 )->first()->id;

            $my_semesters = c_semester::where( 'year_id', $year_id )->where( 'school_id', $school_id )->get();

            foreach ( $my_semesters as $key => $semester ) {
                if($semester['active']==1){
                    $semester[ 'ar' ] = $semester[ 'ar' ].'- Active';

                }
            }

            $semester_id_active = c_semester::where( 'year_id', $year_id )->where( 'school_id', $school_id )->where( 'active', 1 )->first()->id;

            $my_classes =  c_class::where( 'school_id', $school_id )->get();
            $c_subject_class_tea =   c_subject_class_tea::where( 'school_id', $school_id )
            ->with( 'my_subject' )
            ->get()
            ->pluck( 'subject_id' )
            //   ->pluck( 'my_subject.subject_id' )
            ->unique();

            $my_teachers =   hrschooluser::where( 'school_id', $school_id )
            ->with( 'my_teacher' )
            ->get();
            foreach ( $my_teachers as $key => $teacher ) {
                if(isset($teacher[ 'my_teacher' ][ 'ar' ])){
                    $teacher[ 'ar' ] = $teacher[ 'my_teacher' ][ 'ar' ];
                }else{
                    $teacher[ 'ar' ] =null;
                }
            }

            // Loop through the array of objects with key value
            $my_subjects = [];
            foreach ( $c_subject_class_tea as $key => $subject_id ) {
                //  return $subject_id;
                $c_subject = c_subject::where( 'id', $subject_id )->first();
                $c_subject[ 'label' ] = $c_subject[ 'ar' ].' - '   .$c_subject[ 'detail' ] ;
                $c_subject[ 'label2' ] = $c_subject[ 'ar' ].' - ' .$c_subject[ 'en' ].' - ' .$c_subject[ 'detail' ] ;
                array_push( $my_subjects, $c_subject );
            }

            return response()->json( [
                'msg' => 'semester_class_subject_get successfully loaded.',
                'data' => [

                    'my_subjects' => $my_subjects,
                    'my_classes' => $my_classes,
                    // 'my_classes2' => $my_classes,
                    'my_semesters' => $my_semesters,
                    'my_teachers' => $my_teachers,
                    'semester_id_active' => $semester_id_active,

                ],

            ], 200 );
        }


        if ( $fun == 'pre_data_teacher' ) {

            $teacher_id =    Auth::user()->id;
            $school_id =    hrschooluser::where('user_id',$teacher_id)->first()->school_id;
            $semester_id =    c_semester::where('school_id',$school_id)->where('active',1)->first()->id;
            $semester  =    c_semester::where('school_id',$school_id)->where('active',1)->first() ;
// _____________________________________________________________________________
            $startTime = Carbon::parse($semester['teacher_open'])->setTimezone( 'Asia/Riyadh'  );
             $endTime   = Carbon::parse($semester['teacher_close'])->setTimezone( 'Asia/Riyadh' );
            // $startTime = Carbon::parse('2024-04-30 09:15:00');
            // $endTime   = Carbon::parse('2024-04-30 09:18:00');



            $now = Carbon::now();
            
            $isBetween = $now->between($startTime, $endTime, true); // true for inclusive
            


// =====================================================
            // Example usage:
            // $startDateStr = "2024-04-30 10:00:00"; // Assuming a future time for demonstration
            // $endDateStr = "2024-04-30 11:00:00";
            // $startTimeStr, $endTimeStr, $currentTimeStr
            $isBetween =$this-> isTimeBetween($startTime, $endTime);
            // $isBetween = isTimeBetween($startDateStr, $endDateStr);
            
            // if ($isBetween) {
            //   echo "Current time (", $currentTimeStr, ") is between $startDateStr and $endDateStr in Asia/Riyadh.";
            // } else {
            //   echo "Current time (", $currentTimeStr, ") is NOT between $startDateStr and $endDateStr in Asia/Riyadh.";
            // }
            








// _____________________________________________________________________________


                $pre_data = [
                    'semester_id'  => $semester_id   ,
                    'semester'  => $semester   ,
                    'isBetween'  => $isBetween   ,
                    // 'class_id'     => $class_id      ,
                    // 'subject_id'   => $subject_id    ,
                    'teacher_id'   => $teacher_id    ,
                    'school_id'    => $school_id     ,
                ];


    return response()->json( [
        'message' => 'pre_data_teacher success--------------',
        'data' => $pre_data
    ] );




            }//pre_data_teacher______________________










        // get_class_marks ____________________________________________________
        if ($fun == 'get_class_marks') {//get_class_marks
            //    return $request->all();
            if(!isset($request->data['school_id'])){  return 'no school_id'; }
            if(!isset($request->data['semester_id'])){  return 'no semester_id'; }
            if(!isset($request->data['class_id'])){  return 'no class_id'; }
            if(!isset($request->data['subject_id'])){  return 'no subject_id'; }
            if(!isset($request->data['school_id'])){  return 'no school_id'; }
         
                $data=[
                    'semester_id' => $request->data['semester_id'],
                    'class_id'    => $request->data['class_id'   ],
                    'subject_id'  => $request->data['subject_id' ],
                    // 'teacher_id'  => $request->data['teacher_id' ],
                    'school_id'   => $request->data['school_id'  ],
                ];
                        $my_data=marks_main_m::get_class_marks($data) ;
                        return response()->json([
                            'message' => 'get_class_marks success--------------',
                        'data' => $my_data
                ]);

        }//get_class_marks
// ____________________________________________________________





        if ($fun == 'delete_extra_marks') {

            $class_id=$request->class_id;
            $semester_id=$request->semester_id;
            $subject_id=$request->subject_id;
        $c_students= c_student::where('class_id',$class_id)->where('deleted',0)->get();
           
       foreach ($c_students as $key => $student) {
           $student_id=$student['student_id'];

          $c_subject_titles=  c_subject_title::where('semester_id',$semester_id)->
           where('subject_id',$subject_id)->get();
        //    $array=[];
      foreach ($c_subject_titles as $key3 => $subject_title) {
               $c_marks =c_mark::where('semester_id',$semester_id)->
           where('subject_id',$subject_id)->
           where('subject_title_id',$subject_title['id'])->
           where('student_id',$student_id)->get();
             foreach ($c_marks as $key11 => $mark) {
if($key11==0){
    // return '$key11==0';
}else{
    // return '$key11!=0';
    c_mark::where('id',$mark['id'])->delete();
}
             }
            
        }
        //   $c_mark =c_mark::where('semester_id',$semester_id)->
        //    where('subject_id',$subject_id)->
        //    where('subject_title_id',$subject_id)->
        //    where('student_id',$student_id)->get();
        //    return [$array,$c_mark];

        }
              return ['delete_extra_marks',$request->all()];
        }
        




// |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||\
        // get_teacher_classes_marks ____________________________________________________
        if ($fun == 'get_teacher_classes_marks') {//get_teacher_classes_marks
            //    return $request->all();
            $my_classes =[];
            $my_request=$request['data'];
            if(!isset($my_request['semester_id'])){  return 'no semester_id'; }
            // if(!isset($my_request['teacher_id'])){  return 'no teacher_id'; }
            if(!isset($my_request['mood'])){  return 'no mood'; }
         
if($my_request['mood']=='print_subject'){
    if(!isset($my_request['subject_id'])){  return 'no subject_id'; }
    $my_classes =  c_subject_class_tea::where( 'subject_id', $my_request['subject_id'] )->with(['my_class','my_subject','my_teacher'])->get();
}
 

if($my_request['mood']=='print_teacher_subject'){
    if(!isset($my_request['teacher_id'])){  return 'no teacher_id'; }
    $my_classes =  c_subject_class_tea::where( 'teacher_id', $my_request['teacher_id'] )->with(['my_class','my_subject','my_teacher'])->get();

}
if($my_request['mood']=='print_class'){
    if(!isset($my_request['class_id'])){  return 'no class_id'; }
    $my_classes =  c_subject_class_tea::where( 'class_id', $my_request['class_id'] )->with(['my_class','my_subject','my_teacher'])->get();

}
if($my_request['mood']=='print_class_subject' ||$my_request['mood']=='edit'){
    if(!isset($my_request['class_id'])){  return 'no class_id'; }
    if(!isset($my_request['subject_id'])){  return 'no subject_id'; }
    $my_classes =  c_subject_class_tea::where( 'class_id', $my_request['class_id'] )->
                                        where( 'subject_id', $my_request['subject_id'] )->
                                        with(['my_class','my_subject','my_teacher'])->get();
   
}
            //  $my_classes =  c_subject_class_tea::where( 'teacher_id', $my_data['teacher_id'] )->with(['my_class','my_subject','my_teacher'])->get();



             $my_data=[];
            $my_errors=[];

            // return $c_subject_titles = c_subject_title::where( 'subject_id', $my_classes[0]['subject_id' ] )
            // ->where( 'semester_id', $my_request['semester_id'])
            // ->get( [ 'id', 'ar', 'en', 'detail', 'highest_mark', 'is_calc', 'lowest_mark', 'notes' ] );
    
foreach ($my_classes as $key => $my_class) {
    // return $my_class;
                $data=[
                    'semester_id' => $my_request['semester_id'],
                    'class_id'    => $my_class['class_id'   ],
                    'subject_id'  => $my_class['subject_id' ],
                    // 'teacher_id'  => $my_class['teacher_id' ],
                    'school_id'   => $my_class['school_id'  ],
                ];
                try {
                   

                        $class_marks=marks_main_m::get_class_marks($data) ;
 
    
array_push($my_data,$class_marks);
                } catch (\Throwable $th) {
array_push($my_errors,$th);
                    
                }
  }






                        return response()->json([
                            'message' => 'get_teacher_classes_marks success--------------',
                        'data' => ['my_data'=>$my_data,
                        'my_classes' => $my_classes, 
                        'my_errors' => $my_errors,]

                ]);

        }//get_teacher_classes_marks
// ____________________________________________________________




// |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||\














        if ( $fun == 'get_teacher_classes' ) {
            return $request->all();
        }


if ( $fun == 'recalc_subject_sum_bad' ) {
    set_time_limit(1000);
  $admin_id=$request['semester']['admin_id'];
  $school_id=$request['semester']['school_id'];
  $semester_id=$request['semester']['id'];
$my_classes = c_class::where( 'school_id', $school_id )->with( 'my_grade' )->first(  );

// ->get( [ 'student_id', 'admin_id', 'ar', 'en', 'class_id' ] );

$c_subject_class_tea=c_subject_class_tea::where( 'school_id', $school_id )->get(  );


foreach ($c_subject_class_tea as $key1 => $subject) {
$subject_id=$subject['subject_id'];



 


    $students = c_student::where( 'school_id', $school_id )
->where( 'deleted', 0 )
// ->where( 'class_id', $class_id )
// ->with( 'my_class' )
->get();



    foreach ( $students as $key3 => $student ) {
        $student_id=$student['student_id'];




// ------------------------------------------
        $c_subject_titles = c_subject_title::where( 'school_id', $school_id )
        ->where( 'subject_id', $subject_id )
        ->where( 'semester_id', $semester_id )
        ->get(  );

$sum_mark_title_sum = 0;
foreach ( $c_subject_titles as $key1 => $title ) {
    $sum_mark_title_sum = $sum_mark_title_sum+$title[ 'highest_mark' ];
}

// ------------------------------------------








        $sum=0;
        // ________________________________
        foreach ( $c_subject_titles as $key2 => $title ) {




    $student_semester_subject_mark = c_mark::where( 'subject_id', $subject_id )
    ->where( 'semester_id', $semester_id )
    ->where( 'student_id', $subject_id )
    ->where( 'subject_title_id', $title['id'] )
    ->first();
    if(isset($student_semester_subject_mark['mark'])){

        $mark=$student_semester_subject_mark['mark'] ;
        $sum=$sum+$mark;
    }


 }



$c_subject_title_sum = c_subject_title_sum::where( 'school_id', $school_id )
->where( 'subject_id', $subject_id )
->where( 'semester_id', $semester_id )
->first();
if ( !$c_subject_title_sum ) {
    return 'no  c_subject_title_sum   found';
}





$percent =  $sum*100 / $sum_mark_title_sum;

$letter = marks_main_m::is_between( $percent, $school_id );


$matchThese = [
    'admin_id'=>  $admin_id,
    'school_id'=> $school_id,
    'subject_id'=> $subject_id,
    'semester_id'=> $semester_id,
    'student_id'=> $student_id,
    // 'mark'=> $sum,
    // 'letter'=> $letter,
    'subject_title_sum_id'=> $c_subject_title_sum[ 'id' ],
];
$data_to_db = [
    'admin_id'=>  $admin_id,
    'school_id'=> $school_id,
    'subject_id'=> $subject_id,
    'semester_id'=> $semester_id,
    'student_id'=> $student_id,
    'mark'=> $sum,
    'letter'=> $letter,
    'subject_title_sum_id'=> $c_subject_title_sum[ 'id' ],
];
c_mark_sum::updateOrCreate($matchThese, $data_to_db);

 
// $c_mark_sum = c_mark_sum::where( 'school_id', $school_id )
// ->where( 'subject_id', $subject_id )
// ->where( 'semester_id', $semester_id )
// ->where( 'student_id', $student->student_id )
// ->where( 'subject_title_sum_id', $title->id )
// ->first( [ 'id', 'attend', 'completed', 'letter', 'mark', 'notes' , 'history'] );



   



}


  }





return ['recalc_subject_sum okkkkkkkk',$request->all()];
}

        
        //save_all_______________________________________________________
        if ( $fun == 'save_all' ) {
             $pre_data = $request->data[ 'pre_data' ];
// return $request->all();
            //pre_data
            //   class_id
            //   school_id
            //   semester_id
            //   subject_id
            //   teacher_id

            $data = $request->data[ 'data' ];
            $first_save = $request->data[ 'first_save' ];
            $save_class_marks = marks_main_m::save_class_marks( $data ) ;
            $save_class_marks_sum = [];
            if ( $save_class_marks[ 0 ] == 'done' ) {
                $save_class_marks_sum = marks_main_m::save_class_marks_sum( $data, $pre_data, $first_save ) ;

            }

            //  if ( $save_class_marks_sum == 'done' ) {
            //  $save_class_marks_total = marks_main_m::save_class_marks_total( $data ) ;

            //  }

            return response()->json( [
                'message' => 'save_all success--------------',
                'data' => $save_class_marks_sum
            ] );

        }
        //save_all_______________________________________________________









        if ( $fun == 'show_my_classes_one' ) {//show_my_classes_one

            if ( !isset( $request->data[ 'school_id' ] ) ) {
                return 'no school_id';
            }
            ;
            if ( !isset( $request->data[ 'semester_id' ] ) ) {
                return 'no semester_id';
            }
            ;
            if ( !isset( $request->data[ 'class_id' ] ) ) {
                return 'no class_id';
            }
            if ( !isset( $request->data[ 'subject_id' ] ) ) {
                return 'no subject_id';
            }             

            // $request->data[ 'data' ];
            $school_id = $request->data[ 'school_id' ] ;
            $semester_id = $request->data[ 'semester_id' ];
            $class_id = $request->data[ 'class_id' ];
            $subject_id = $request->data[ 'subject_id' ];

            $class_marks_finished_percent = 0;

            $my_classes =  c_subject_class_tea::where( 'class_id', $class_id )->
                                                where( 'subject_id', $subject_id )
            ->with( [ 'my_class', 'my_subject', 'my_students' => function ( $query ) {
                $query->where( 'deleted', 0 );
                // Filter my_students with deleted = 0
            }
                    ] )->get();

            foreach ( $my_classes as $key => $value ) {//foreach ( $my_classes
            $value[ 'label' ] = $value->my_class[ 'detail' ];
            $value[ 'label2' ] = $value->my_class[ 'detail' ];
            $value[ 'label2' ] = $value->my_class[ 'detail' ] . '[' . count( $value[ 'my_students' ] ) . ']';
            $value[ 'count' ] =  count( $value[ 'my_students' ] );
            $value[ 'subject' ] =   $value[ 'my_subject' ][ 'detail' ];

            $class_marks_finished_percent = 0;
            $count_mark_all = 0;
            $count_mark_null = 0;

            foreach ( $value[ 'my_students' ] as $key2 => $student ) {//my_students
                if ( $student[ 'delete' ] == 0 ) {
                    //if not deleted

                    $student_id = $student->student_id;
                    $c_mark_all_count = c_mark::where( 'school_id', $school_id )
                    ->where( 'subject_id', $value[ 'my_subject' ]->id )
                    ->where( 'semester_id', $semester_id )
                    ->where( 'student_id', $student_id )
                    ->count();
                    if ( $c_mark_all_count > 0 ) {
                        $count_mark_all = $count_mark_all + $c_mark_all_count;
                        $c_mark_null = c_mark::where( 'school_id', $school_id )
                        ->where( 'subject_id', $value[ 'my_subject' ]->id )
                        ->where( 'semester_id', $semester_id )
                        ->where( 'student_id', $student_id )
                        ->where( 'mark', '!=', null )
                        ->where( 'attend', 1 )
                        ->count();
                        $count_mark_null = $count_mark_null + $c_mark_null;
                        $class_marks_finished_percent = ( $count_mark_null / $count_mark_all ) * 100;

                        $number_float = floatval( $class_marks_finished_percent );

                        // Round to 2 decimal places
                        $class_marks_finished_percent = round( $number_float, 2 );
                        $value[ 'class_marks_finished_percent' ] = $class_marks_finished_percent;
                        $value[ 'mark_null' ] = $count_mark_null;
                        $value[ 'count_mark_all' ] = $count_mark_all;
                    }
                }
                
            }//foreach  student 
                    }//foreach my_classes


                    $semester = c_semester::where( 'id', $semester_id )->first();
                    $teacher_data = hruserdata::where( 'user_id', Auth::user()->id )->first();

                    // mystudents
                    return response()->json( [
                        'message' => 'show  success--------------',
                        'my_semester' => $semester,
                        'school_id' => $school_id,
                        // 'school_list' => $school_list,
                        'my_classes' => $my_classes,
                        'teacher_data' => $teacher_data,
                        'class_marks_finished_percent' => $class_marks_finished_percent,

                    ] );
    }

 
 

 

        if ( $fun == 'show_my_classes' ) {

            if ( !isset( $request->data[ 'school_id' ] ) ) {
                return 'no school_id';
            }
            ;
            if ( !isset( $request->data[ 'semester_id' ] ) ) {
                return 'no semester_id';
            }
            ;
            if ( !isset( $request->data[ 'teacher_id' ] ) ) {
                return 'no teacher_id';
            }
            ;

            // $request->data[ 'data' ];
            $school_id = $request->data[ 'school_id' ] ;
            $semester_id = $request->data[ 'semester_id' ];
            $teacher_id = $request->data[ 'teacher_id' ];

            $class_marks_finished_percent = 0;

            $my_classes =  c_subject_class_tea::where( 'teacher_id', $teacher_id )->where( 'school_id', $school_id )
            ->with( [ 'my_class', 'my_subject', 'my_students' => function ( $query ) {
                $query->where( 'deleted', 0 );
                // Filter my_students with deleted = 0
            }
        ] )->get();

        foreach ( $my_classes as $key => $value ) {
            $value[ 'label' ] = $value->my_class[ 'detail' ];
            $value[ 'label2' ] = $value->my_class[ 'detail' ];
            $value[ 'label2' ] = $value->my_class[ 'detail' ] . '[' . count( $value[ 'my_students' ] ) . ']';
            $value[ 'count' ] =  count( $value[ 'my_students' ] );
            $value[ 'subject' ] =   $value[ 'my_subject' ][ 'detail' ];

            $class_marks_finished_percent = 0;
            $count_mark_all = 0;
            $count_mark_null = 0;

            foreach ( $value[ 'my_students' ] as $key2 => $student ) {
                if ( $student[ 'delete' ] == 0 ) {
                    //if not deleted

                    $student_id = $student->student_id;
                    $c_mark_all_count = c_mark::where( 'school_id', $school_id )
                    ->where( 'subject_id', $value[ 'my_subject' ]->id )
                    ->where( 'semester_id', $semester_id )
                    ->where( 'student_id', $student_id )
                    ->count();
                    if ( $c_mark_all_count > 0 ) {
                        $count_mark_all = $count_mark_all + $c_mark_all_count;
                        $c_mark_null = c_mark::where( 'school_id', $school_id )
                        ->where( 'subject_id', $value[ 'my_subject' ]->id )
                        ->where( 'semester_id', $semester_id )
                        ->where( 'student_id', $student_id )
                        ->where( 'mark', '!=', null )
                        ->where( 'attend', 1 )
                        ->count();
                        $count_mark_null = $count_mark_null + $c_mark_null;
                        $class_marks_finished_percent = ( $count_mark_null / $count_mark_all ) * 100;

                        $number_float = floatval( $class_marks_finished_percent );

                        // Round to 2 decimal places
                        $class_marks_finished_percent = round( $number_float, 2 );
                        $value[ 'class_marks_finished_percent' ] = $class_marks_finished_percent;
                        $value[ 'mark_null' ] = $count_mark_null;
                        $value[ 'count_mark_all' ] = $count_mark_all;
                    }
                }
                //if ( $student[ 'delete' ] == 0 ) {
            }
        }
        $semester = c_semester::where( 'id', $semester_id )->first();
        $teacher_data = hruserdata::where( 'user_id', Auth::user()->id )->first();

        // mystudents
        return response()->json( [
            'message' => 'show  success--------------',
            'my_semester' => $semester,
            'school_id' => $school_id,
            // 'school_list' => $school_list,
            'my_classes' => $my_classes,
            'teacher_data' => $teacher_data,
            'class_marks_finished_percent' => $class_marks_finished_percent,

        ] );
    }




            }//show_my_classes

    












 
            public function isTimeBetween($startTimeStr, $endTimeStr, $currentTimeStr = null) {
              // Set default current time if not provided
              $currentTimeStr = $currentTimeStr ?: date('Y-m-d H:i:s');
            
              // Create DateTime objects with Asia/Riyadh timezone
              $startTime = new DateTime($startTimeStr, new DateTimeZone('Asia/Riyadh'));
              $endTime = new DateTime($endTimeStr, new DateTimeZone('Asia/Riyadh'));
              $currentTime = new DateTime($currentTimeStr, new DateTimeZone('Asia/Riyadh'));
            
              // Check if current time is between start and end (inclusive)
            //   return [ $currentTime ,$startTime ,$endTime];
              return $currentTime >= $startTime && $currentTime <= $endTime;
            }
            









    

    }



