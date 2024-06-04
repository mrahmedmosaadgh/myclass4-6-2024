<?php

namespace App\Http\Controllers\cs;

use App\Http\Controllers\Controller;
use App\Models\cs\c_mark_grade_letter;
use App\Models\cs\c_semester;
use App\Models\hrschool;
use App\Models\hryear;
use Illuminate\Support\Facades\Config;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
// Route::post( 'control_settings', [ c_control_settings_co::class, 'control_settings' ] );
// php artisan route:cache
// /api/school_admin/control_settings

class c_control_settings_co extends Controller {
    public function control_settings( Request $request ) {
        $fun = $request[ 'fun' ];
        $my_id =  Auth::user()->id;
        $data = $request[ 'data' ];





        if ( $fun == 'student_msg' ) {
            $data = [
                'student_msg'=>$request[ 'data' ] ,
 
            ];
            c_semester::where( 'id', $request[ 'semester_id' ]  )->update( $data );
            return response()->json( [ 'msg' => 'Data update_semester successfully.', 'data' =>  $data ], 200 );

        } 

        if ( $fun == 'teacher_msg' ) {
            $data = [
                'teacher_msg'=>$request[ 'data' ] ,
 
            ];
            c_semester::where( 'id', $request[ 'semester_id' ]  )->update( $data );
            return response()->json( [ 'msg' => 'Data update_semester successfully.', 'data' =>  $data ], 200 );

        } 


        
        if ( $fun == 'update_semester' ) {
            $data = [
                'ar'=>$request[ 'data' ][ 'ar' ],
                'en'=>$request[ 'data' ][ 'en' ],
                'detail'=>$request[ 'data' ][ 'detail' ],
            ];
            c_semester::where( 'id', $request[ 'data' ][ 'id' ] )->update( $data );
            return response()->json( [ 'msg' => 'Data update_semester successfully.', 'data' =>  $data ], 200 );

        }

        if ( $fun == 'create_semester' ) {

            c_semester::where( 'school_id', $request[ 'data' ][ 'school_id' ] )->update( [ 'active'=>0 ] );

            c_semester::create( $request[ 'data' ] );
            return response()->json( [ 'msg' => 'Data create_semester successfully.', 'data' =>  $data ], 200 );

        }
        if ( $fun == 'set_semester_active' ) {

            c_semester::where( 'school_id', $request[ 'data' ][ 'school_id' ] )->update( [ 'active'=>0 ] );

            c_semester::where( 'id', $request[ 'data' ][ 'id' ] )->update( [ 'active'=>1 ] );

            return response()->json( [ 'msg' => '  set_semester_active successfully.', 'data' =>  $data ], 200 );

        }

        if ( $fun == 'date_student' ) {

            $js_date_string = $request[ 'data' ][ 0 ]  ;
            $semester_id = $request[ 'semester_id' ] ;
            // $js_date_string = '2024-04-09T09:00:33.753Z';

            // Parse the JavaScript string as a Carbon datetime object in UTC
            $dateTime = Carbon::parse( $js_date_string )->setTimezone( 'Asia/Riyadh' );

            // Format the Carbon object in Laravel MySQL datetime format ( YYYY-MM-DD HH:MM:SS )
            $laravel_datetime_format = $dateTime->format( 'Y-m-d H:i' );

            $js_date_string_close = $request[ 'data' ][ 1 ]  ;
            $dateTime_close = Carbon::parse( $js_date_string_close )->setTimezone( 'Asia/Riyadh' );
            $laravel_datetime_format_close = $dateTime_close->format( 'Y-m-d H:i' );

            c_semester::where( 'id', $semester_id )->update( [
                'student_open'=>$laravel_datetime_format,
                'student_close'=>$laravel_datetime_format_close,
            ] );
            return  $laravel_datetime_format;
            // Output: 2024-04-09 09:00:33

        }

        if ( $fun == 'date_teacher' ) {

            $js_date_string = $request[ 'data' ][ 0 ]  ;
            $semester_id = $request[ 'semester_id' ] ;
            // $js_date_string = '2024-04-09T09:00:33.753Z';

            // Parse the JavaScript string as a Carbon datetime object in UTC
            $dateTime = Carbon::parse( $js_date_string )->setTimezone( 'Asia/Riyadh' );
            // $dateTimeMecca = $dateTimeUtc->setTimezone( 'Asia/Riyadh' );
            // Format the Carbon object in Laravel MySQL datetime format ( YYYY-MM-DD HH:MM:SS )
            $laravel_datetime_format = $dateTime->format( 'Y-m-d H:i' );

            $js_date_string_close = $request[ 'data' ][ 1 ]  ;
            $dateTime_close = Carbon::parse( $js_date_string_close )->setTimezone( 'Asia/Riyadh' );
            $laravel_datetime_format_close = $dateTime_close->format( 'Y-m-d H:i' );

            c_semester::where( 'id', $semester_id )->update( [
                'teacher_open'=>$laravel_datetime_format,
                'teacher_close'=>$laravel_datetime_format_close,
            ] );
            return  $laravel_datetime_format;
            // Output: 2024-04-09 09:00:33

        }

        if ( $fun == 'view' ) {

            $hrschool                     = hrschool::where( 'id', $request[ 'school_id' ] )->first();
            $hryears                       = hryear::where( 'admin_id', $hrschool[ 'admin_id' ] )->get();
            $active_year                  = hryear::where( 'admin_id', $hrschool[ 'admin_id' ] )->where( 'active', 1 )->first();
            $active_year_semesters       = c_semester::where( 'school_id', $request[ 'school_id' ] )->where( 'year_id', $active_year[ 'id' ] )->get();
            foreach ( $active_year_semesters as $key => $semester ) {
                if ( $semester[ 'active' ] == 1 ) {

                    $semester[ 'label' ] = $semester[ 'ar' ].' - '.$semester[ 'en' ].' [Active]';
                } else {
                    $semester[ 'label' ] = $semester[ 'ar' ].' - '.$semester[ 'en' ] ;

                }
            }

            $active_year_semester_active = c_semester::where( 'school_id', $request[ 'school_id' ] )->where( 'year_id', $active_year[ 'id' ] )->where( 'active', 1 )->first();
            if ( !$active_year_semester_active ) {
                $active_year_semester_active_all = c_semester::where( 'school_id', $request[ 'school_id' ] )  ->get() ;
                $count = count( $active_year_semester_active_all );
                $active_year_semester_active = $active_year_semester_active_all[ $count-1 ];
            }
if($hrschool['report_settings']==null){
    $report_settings=[
       'part1'  =>'part1',
       'part2'  =>'',
       'part3'  =>'',
       'part4'  =>'',
       'part1_font'  =>8,
       'part2_font'  =>8,
       'part3_font'  =>8,
       'part4_font'  =>8,
    ];
    $hrschool                     = hrschool::where( 'id', $request[ 'school_id' ] )->update(
        [
            'report_settings'=>$report_settings
        ]
    );
        
      
      }
 

            $data = [
                'my_school'                     =>$hrschool                    ,
                'hrschool'                     =>$hrschool                    ,
                'hryears'                       =>$hryears                      ,
                'active_year'                  =>$active_year                 ,
                'active_year_semesters'       =>$active_year_semesters      ,
                'selected_semester'       =>$active_year_semester_active      ,

                'active_year_semester_active' =>$active_year_semester_active,
            ];
            return response()->json( [ 'msg' => 'Data view successfully.', 'data' =>  $data ], 200 );
        }

        if ( $fun == 'insert' ) {
            // $my_data = $request->data[ 'data' ];
            /////////////////////////////////////////////////////////////

            $data = [
                'admin_id' => Auth::user()->admin_id,
                'school_id' => $request->data[ 'school_id' ],
                'from' => $request->data[ 'from' ],
                'to'       => $request->data[ 'to' ],
                'letter'       => $request->data[ 'letter' ],
                'notes'       => $request->data[ 'notes' ],

            ];

            c_mark_grade_letter::insert( $data );

            return 'inserted done ';
        }


        if ( $fun == 'report_settings' ) {
 $data =  $request->data  ;
$hrschool                     = hrschool::where( 'id', $request[ 'school_id' ] )->update(
    [
        'report_settings'=>$data
    ]
);

return 'part1 updated';

        }

        
        if ( $fun == 'delete' ) {
            // $data = $request->data[ 'data' ];
            //    return  $id = $request->all();
            //      $id = $request[ 'data' ] ;
            $id = $request[ 'semester' ][ 'id' ];
            try {
                c_semester::where( 'id', $id )->delete();
                return response()->json( [ 'msg' => 'data deleted   successfully.', 'data' => $id ], 200 );

            } catch ( \Throwable $th ) {
                return response()->json( [ 'msg' => 'data deleted   error.', 'data' => $th ], 200 );

            }

        }

        if ( $fun == 'update' ) {
            $data = $request[ 'data' ];
            //   return $data ;
            $data_to_update = [];
            $id = $data[ 'id' ];

            $data_to_update[ 'from' ] = $data[ 'from' ];
            $data_to_update[ 'to' ] = $data[ 'to' ];
            $data_to_update[ 'notes' ] = $data[ 'notes' ];
            $data_to_update[ 'letter' ] = $data[ 'letter' ];
            // $data_to_update[ 'national_id' ] = $data[ 'national_id' ];
            // $data_to_update[ 'nationality_ar' ] = $data[ 'nationality_ar' ];
            // $data_to_update[ 'nationality_en' ] = $data[ 'nationality_en' ];
            // $data_to_update[ 'notes' ] = $data[ 'notes' ];
            // $data_to_update[ 'paid' ] = $data[ 'paid' ];
            // $data_to_update[ 'passport' ] = $data[ 'passport' ];
            // $data_to_update[ 'task1' ] = $data[ 'task1' ];
            // $data_to_update[ 'en' ] = $data[ 'en' ];
            c_mark_grade_letter::where( 'id', $id )->update( $data_to_update );
            return response()->json( [ 'msg' => 'data updated   successfully.', 'data' =>'' ], 200 );

            // return 'update done';
        }
    }

    public function filter_fun( $text ) {
        $users = User::where( 'name', 'like', '%' . $text . '%' )->limit( 10 )->get();

        return response()->json( [ 'msg' => 'Data view successfully.', 'data' => $users ], 200 );
    }
}
