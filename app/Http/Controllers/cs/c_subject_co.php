<?php

namespace App\Http\Controllers\cs;

use App\Http\Controllers\Controller;
use App\Models\cs\c_semester;
use App\Models\cs\c_subject;
use App\Models\cs\c_subject_title;
use App\Models\cs\c_subject_title_sum;
use App\Models\hrschooluser;
use App\Models\hryear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// routes/api/api_school_admin.php
// composer require doctrine/dbal

class c_subject_co extends Controller
{
    public function c_subject(Request $request)
    {
        $fun = $request->data['fun'];
        $my_id =  Auth::user()->id;
        // $model = new c_subject(); // Replace with your actual model class
        //  $request->all();



        if ($fun == 'school_list') {

            $hrschooluser = hrschooluser::where('user_id', $my_id)->with('my_school_users.my_user_data', 'my_school')->get();

            foreach ($hrschooluser as $key => $value) {
                $value['label'] = $value['my_school']['name'] . ' ' . $value['my_school']['name_ar'] . ' [' . $value['my_school_users']->count() . ']';
            }
            return  $hrschooluser;
        }





        if ($fun == 'update_val_c_subject') {
            // return [ 'update_val_c_subject',$request->data['data']['col'] ,$request->data['data']['val']] ;
            $data=$request->data['data'];
            $id=$data['id'];
            $col=$data['col'];
            $val=$data['val'];

c_subject::where('id',$id)->update([
$col=>$val
]);
                return 'c_subject updated successfully  ';

        }

        if ($fun == 'save_update') {
            //  return  $request->data['data']['my_subject_title'] ;
            // return  $request->data['data']['my_subject_title'] ;
            // semester_id
            $c_semester = c_semester::where('school_id', $request->data['data']['school_id'])->where('active', 1)->first();
            if (!$c_semester) {
                return 'no active semester  ';
            }
            $semester_id = $c_semester->id;
            $data = [
                // 'id'=> $request->data['data']['id'],
                'ar' => $request->data['data']['ar'],
                'en' => $request->data['data']['en'],
                'detail' => $request->data['data']['detail'],
            ];

            if (!$request->data['data']['id']) {
                return 'no subject selected';
            }
            c_subject::where('id', $request->data['data']['id'])->update($data);

            $titles = $request->data['data']['my_subject_title'];
            // return count($titles)>1;
            if (count($titles) < 1) {
                c_subject_title::where('school_id', $request->data['data']['school_id'])
                    ->where('subject_id', $request->data['data']['id'])
                    ->where('semester_id', $semester_id)
                    ->delete();


                return 'save_update done successfully no titles selected';
            }





            $c_subject_title_old =     c_subject_title::where('school_id', $request->data['data']['school_id'])
                ->where('subject_id', $request->data['data']['id'])
                ->where('semester_id', $semester_id)
                // ;
                ->get();

            if (count($c_subject_title_old) > 0) {

                // return count($c_subject_title_old);
                //////////////////////////////////////////////////////////////////////////////////////////
                foreach ($c_subject_title_old as $key => $title_old) {



                    $counter = 0;
                    foreach ($titles as $key => $title) {

                        if ($title['id'] != null) {
                            if ($title['id'] == $title_old['id']) {

                                $counter++;
                            }
                        }
                    }

                    // if no in new data delete it*****************************
                    if ($counter < 1) {
                        c_subject_title::where('id', $title_old['id'])
                            ->delete();
                    }
                    // if no in new data delete it*****************************

                    // return $counter;
                }
            }
            // c_subject_title::where('school_id',$request->data['data']['school_id'])
            //                ->where('subject_id',$request->data['data']['id'])
            //                ->where('semester_id',$semester_id)
            //                ;
            //    ->delete();
            // return  $request->data['data']['my_subject_title'];
            // }// if(count($c_subject_title_old)>0)
            $my_subject_titles = $request->data['data']['my_subject_title'];


            foreach ($my_subject_titles as $key => $title) {

                if ($title['id'] == null) {
                    //insert
                    //  unset($title['id']);
                    $title['admin_id'] = $request->data['data']['admin_id'];
                    $title['school_id'] = $request->data['data']['school_id'];
                    $title['subject_id'] = $request->data['data']['id'];
                    $title['semester_id'] = $semester_id;
                    $title['sequence'] = $key + 1;

                    c_subject_title::insert($title);
                } else {
                    //update


                    $title['admin_id'] = $request->data['data']['admin_id'];
                    $title['school_id'] = $request->data['data']['school_id'];
                    $title['subject_id'] = $request->data['data']['id'];
                    $title['semester_id'] = $semester_id;
                    $title['sequence'] = $key + 1;
                    c_subject_title::where('id', $title['id'])
                        ->update($title);
                }
            }
            ///sum

            // data_title_sum
            $c_subject_title_sum = c_subject_title_sum::where('school_id', $request->data['data']['school_id'])
                ->where('subject_id', $request->data['data']['id'])
                ->where('semester_id', $semester_id)->get();
            $data_title_sum = $request->data['data']['data_title_sum'];
            if (count($c_subject_title_sum) > 0) {
                //update


                // {lowest_mark: 0, highest_mark: 54}
                c_subject_title_sum::where('school_id', $request->data['data']['school_id'])
                    ->where('subject_id', $request->data['data']['id'])
                    ->where('semester_id', $semester_id)
                    ->update([
                        'highest_mark' => $data_title_sum['highest_mark'],
                        'lowest_mark' => $data_title_sum['lowest_mark'],
                    ]);
            } else {
                //create

                $data_title_sum['admin_id'] = $request->data['data']['admin_id'];
                $data_title_sum['school_id'] = $request->data['data']['school_id'];
                $data_title_sum['subject_id'] = $request->data['data']['id'];
                $data_title_sum['semester_id'] = $semester_id;

                c_subject_title_sum::insert($data_title_sum);
            }



            ///sum











            // if(!$title['id'] ){
            // $title['admin_id']=$request->data['data']['admin_id'];
            // $title['school_id']=$request->data['data']['school_id'];
            // $title['subject_id']=$request->data['data']['id'];
            // $title['semester_id']=$semester_id;
            // $title['sequence']=$key+1;
            // c_subject_title::insert($title);




            // }else{
            //     c_subject_title::where('id', $title['id'])->update($title);
            // }

            //   }

            // **********c_subject_title_sum***********************
            // **********c_subject_title_sum***********************
            // **********c_subject_title_sum***********************








            // **********c_subject_title_sum***********************
            // **********c_subject_title_sum***********************
            // **********c_subject_title_sum***********************



            return 'save_update done successfully';
            return  $request->data['data'];
            // return ['save_update', $request->all()];
        } // if ($fun == 'save_update') {

        if ($fun == 'table_col') {

            // // Get column names
            // $columns = array_keys($model->getAttributes());

            // // Check nullability for each column
            // $col=[];
            // foreach ($columns as $column) {
            //     $nullable = $model->is_fillable($column);
            //     array_push($col,$column . ($nullable ? ' (nullable)' : ''))  ;
            // }
            // return $col;



            $table = 'c_subjects'; // Replace with your actual table name

            // Get column names
            $columns = Schema::getColumnListing($table);
            $columns = c_subject::all();
            $col = [];

            // Check nullability for each column
            // foreach ($columns as $column) {

            //   c_subject::where('id', 1)->update([  'id'  => 22]);
            //   c_subject::where('id', 1)->update([  $column  => 22]);
            // try {
            //     // c_subject::insert([$column => null,]);
            // } catch (\Throwable $th) {
            //     //throw $th;
            //     // return $th;
            //     array_push($col, $th);
            // }

            // $nullable = Schema::getColumnType ($table, $column) ;
            // $nullable = Schema::getColumnType($table, $column)['nullable'];
            // echo $column . ($nullable ? ' (nullable)' : '');
            //    $data=$column .   $nullable  ;
            // array_push($col,$data) ;
            // array_push($col,$column . ($nullable ? ' (nullable)' : ''))  ;

            // }
            return $col;
            // $c_subject = c_subject::insert(['id' => 1]);
            // return $c_subject;
        }

        if ($fun == 'view') {

            $school_id = $request->data['data'];

          return $this-> view_fun($school_id);
        }
        if ($fun == 'create') {
            $school_id = $request->data['data']['school_id'];
            $data = $request->data['data']['data'];
            $data['admin_id'] = Auth::user()->admin_id;
            $data['school_id'] = $school_id;
            $year = hryear::where('admin_id', Auth::user()->admin_id)->where('active', 1)->first();
            if ($year == null) {
                return 'no active year';
            }
            $data['year_id'] = $year->id;
            $data['category_id'] = 1;
            $c_subject = c_subject::create($data);



            return ['created done ', $c_subject];
            return $request->all();
        }
        if ($fun == 'update') {

            return $this->create_new_exam($request->data);
            return $request->all();
        }
        if ($fun == 'delete') {
            $ar= $request->data['data']['data']['ar'] ;
            $id= $request->data['data']['data']['id'] ;
            $school_id= $request->data['data']['data']['school_id'] ;
           
c_subject::where('id',$id)->delete();
return $this-> view_fun($school_id);

// return response()->json(['msg' =>$ar. ' deleted successfully  .', 
 
// ], 200);
        }
    }


    public function view($data)
    {
        return $data;
    }

    public function view_fun($school_id)
    {
        // if ($fun == 'view') {
            // $school_id = $request->data['data'];
            $hryear = hryear::where('admin_id', Auth::user()->admin_id)->where('active', 1)->first();
            if (!$hryear) {
                return 'no hryear';
            }
            $c_subject = c_subject::where('school_id', $school_id)->where('year_id', $hryear->id)->with('my_grade' )->get();


            $c_subject_title_unique = c_subject_title::distinct('ar')
                // ->pluck('ar')
                ->get()
                ->toArray();
            // $uniqueTypes2 = c_subject_title::distinct('en')
            // ->pluck('en')

            // ->get()
            // ->toArray();
            // $uniqueTypes3 = c_subject_title::distinct('detail')
            // ->pluck('detail')

            // ->get()
            // ->toArray();
            // $uniqueTypes = DB::table('c_subject_titles')
            //     ->distinct('ar')
            //     ->select('ar')
            //     ->get() // Fetch as an array of objects
            //     // ->pluck('ar') // Extract only the 'types' values
            //     ->toArray(); // Convert to a simple array

            // add c_subject_title and c_subject_title_sum

                       $c_semester = c_semester::where('school_id', $school_id)->where('active', 1)->first();
            if (!$c_semester) {
                return 'no active semester  ';
            }
            $semester_id = $c_semester->id;

            foreach ($c_subject as $key => $value) {
             $my_subject_title=   c_subject_title::where('school_id', $school_id)->
                                 where('subject_id', $value->id)->
                                 where('semester_id', $semester_id)->
                                 get();

             $c_subject_title_sum=   c_subject_title_sum::where('school_id', $school_id)->
                                 where('subject_id', $value->id)->
                                 where('semester_id', $semester_id)->
                                 first();

                // Print the key and the name and price properties of the object
                // echo $key . ": " . $value['name'] . " - " . $value['price'] . "\n";
                if ($value->my_grade) {
                    $value['grade'] = $value->my_grade['ar'];
                    $value['grade_ar'] = $value->my_grade['ar'];
                    $value['grade_en'] = $value->my_grade['ar'];
                }
                // $value['aaaaa_titles'] = '$uniqueTypes';
                $value['titles'] =   $c_subject_title_unique;
                $value['my_subject_title'] =   $my_subject_title;
                $value['c_subject_title_sum'] =   $c_subject_title_sum;
                // $value['titles_en'] = $uniqueTypes2;
                // $value['titles_detail'] = $uniqueTypes3;


            }
            return  $c_subject;
            // return $this->view($request->all());
        
    }

    
}
