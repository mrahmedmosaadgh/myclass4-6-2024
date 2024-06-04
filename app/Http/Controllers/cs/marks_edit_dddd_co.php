<?php

namespace App\Http\Controllers\cs;

use App\Http\Controllers\Controller;
use App\Models\cs\c_class;
use App\Models\cs\c_mark_grade_letter;
use App\Models\cs\c_semester;
use App\Models\cs\c_subject;
use App\Models\hrschooluser;
use App\Models\cs\c_subject_class_tea;
use App\Models\hryear;
use Illuminate\Support\Facades\Config;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
// Route::post( 'marks_edit_dddd', [ marks_edit_dddd_co::class, 'marks_edit_dddd' ] );
// php artisan route:cache
// /api/school_admin/marks_edit_dddd

class marks_edit_dddd_co extends Controller {
    public function marks_main( Request $request ) {
        $fun = $request[ 'fun' ];
        $my_id =  Auth::user()->id;
        $data = $request[ 'data' ];

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
                $teacher[ 'ar' ] = $teacher[ 'my_teacher' ][ 'ar' ];
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

        if ( $fun == 'view2' ) {

            $c_mark_grade_letter = c_mark_grade_letter::where( 'school_id', $request[ 'school_id' ] )->get();

            return response()->json( [ 'msg' => 'Data view successfully.', 'data' => $c_mark_grade_letter ], 200 );
        }

        if ( $fun == 'insert' ) {
            // $my_data = $request->data[ 'data' ];
            /////////////////////////////////////////////////////////////

            $data = [
                'admin_id'     => Auth::user()->admin_id,
                'school_id'    => $request->data[ 'school_id' ],
                'from'         => $request->data[ 'from' ],
                'to'           => $request->data[ 'to' ],
                'letter'       => $request->data[ 'letter' ],
                'notes'        => $request->data[ 'notes' ],

            ];

            c_mark_grade_letter::insert( $data );

            return 'inserted done ';
        }

        if ( $fun == 'delete' ) {
            // $data = $request->data[ 'data' ];
            $id = $data[ 'id' ];

            c_mark_grade_letter::where( 'id', $id )->delete();
            // return 'delete done';
            return response()->json( [ 'msg' => 'data deleted   successfully.', 'data' => '' ], 200 );

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
