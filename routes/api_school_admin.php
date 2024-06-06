<?php

use App\Http\Controllers\cs\admin_semester_co;

use App\Http\Controllers\cs\c_class_co;
use App\Http\Controllers\cs\c_control_settings_co;
use App\Http\Controllers\cs\c_semester_co;
use App\Http\Controllers\cs\c_semester_report_co;
use App\Http\Controllers\cs\c_semester_report_final_co;
use App\Http\Controllers\cs\c_semester_top_co;
use App\Http\Controllers\cs\c_student_co;
use App\Http\Controllers\cs\c_student_co_block;
use App\Http\Controllers\cs\c_subject_co;
use App\Http\Controllers\cs\c_subject_marks_print_co;
use App\Http\Controllers\cs\c_teacher_co;
use App\Http\Controllers\cs\c_year_co;
use App\Http\Controllers\cs\calc_totals_ok_co;
use App\Http\Controllers\cs\data_from_old_site_to_new;
use App\Http\Controllers\cs\marks_edit_co;
use App\Http\Controllers\cs\marks_edit_dddd_co;
use App\Http\Controllers\cs\marks_letter_co;
use App\Http\Controllers\cs\semester_marks_manage_co;
use App\Http\Controllers\cs\student_data_co;
use App\Http\Controllers\Hr_student_data_xlsController;

use App\Http\Controllers\school\teacher\c_mark_class_dashboard_co;
use App\Http\Controllers\cs\marks_main_co;
use App\Http\Controllers\school_admin\add_student_co;
use App\Http\Controllers\school_admin\add_classes_co;
use App\Http\Controllers\school_admin\add_grades_co;
use App\Http\Controllers\school_admin\add_marks_xls_co;
use App\Http\Controllers\school_admin\add_school_exam_co;
use App\Http\Controllers\school_admin\add_school_exam_comp_co;
use App\Http\Controllers\school_admin\add_school_semester_co;
use App\Http\Controllers\school_admin\add_stages_co;
use App\Http\Controllers\school_admin\add_students_xls_co;
use App\Http\Controllers\school_admin\add_subjects_co;
use App\Http\Controllers\school_admin\certificate_co;
use App\Http\Controllers\school_admin\grade_subject_mark_xls_co;
use App\Http\Controllers\school_admin\join_class_subject_co;
use App\Http\Controllers\school_admin\join_class_teacher_co;
use App\Http\Controllers\school_admin\marks_input_follow_co;
use App\Http\Controllers\school_admin\marks_input_follow_co_subject;
use App\Http\Controllers\school_admin\marks_input_follow_s1_class_subject2023;
use App\Http\Controllers\school_admin\marks_input_follow_subject_s3_co;
use App\Http\Controllers\school_admin\marks_print_co;
use App\Http\Controllers\school_admin\add_school_exam_new_co;
use App\Http\Controllers\school_admin\myfun_school_admin\myfun_school_admin_co;
use App\Http\Controllers\school_admin\school_grade_suject_mark_co;

use App\Http\Controllers\school_admin\teacher_marks_print_s2_co;
use App\Http\Controllers\school_admin\teacher_marks_print_s1_co;
use App\Http\Controllers\school_admin\teacher_marks_print_s3_co;
use App\Http\Controllers\school_admin\top_ten_co;
use App\Http\Controllers\TeacherNewController;
use App\Http\Controllers\test\attendance\attendance_user\attendance_teacher_report_co;
use App\Http\Controllers\test\calendar_main_co;

use Illuminate\Support\Facades\Route;







// Route::controller(c_student_co::class)->group(function () {
//     Route::post('school_admin/c_student', 'c_student');
// })->middleware('auth:sanctum');
//// Route::group(function () {
     Route::middleware('auth:sanctum')->group(function () {
    // Route::post('school_admin/c_student', [App\Http\Controllers\cs\c_student_co::class, 'c_student']);
});







Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::post('api/school_admin/c_student', [App\Http\Controllers\cs\c_student_co::class, 'c_student']);
});







Route::controller(data_from_old_site_to_new::class)->group(function () {
    Route::post('from_old_site_to_new', 'from_old_site_to_new');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('at_permission_teacher', [App\Http\Controllers\cs\attend\at_permission_teacher_co::class, 'at_permission_teacher']);
});


Route::middleware('auth:sanctum')->prefix('school_admin')->group(function () {
    //  php artisan route:cache
    // prefix('school_admin')-
    Route::post('calc_totals_ok', [calc_totals_ok_co::class, 'calc_totals_ok']);
    Route::post('marks_main', [marks_main_co::class, 'marks_main']);
    Route::post('control_settings', [c_control_settings_co::class, 'control_settings']);
    // php artisan route:cache
    Route::post('semester_report_final', [c_semester_report_final_co::class, 'semester_report_final']);
    // php artisan route:cache
    // /api/school_admin/semester_report_final

    Route::post('c_year', [c_year_co::class, 'c_year']);
    Route::post('semester_marks_manage', [semester_marks_manage_co::class, 'semester_marks_manage']);
    Route::post('c_semester_top', [c_semester_top_co::class, 'c_semester_top']);
    Route::post('marks_letter', [marks_letter_co::class, 'marks_letter']);
    Route::controller(c_semester_co::class)->group(function () {
        Route::post('c_semester', 'c_semester');
    });

    Route::controller(student_data_co::class)->group(function () {
        Route::post('student_data', 'student_data');
    });
    Route::controller(marks_edit_co::class)->group(function () {
        Route::post('marks_edit', 'marks_edit');
    });


    Route::controller(c_semester_report_co::class)->group(function () {
        Route::post('c_semester_report', 'c_semester_report');
    });



    // Route::controller(c_mark_class_dashboard_co::class)->group(function () {
    //     Route::post('c_mark_class_dashboard', 'c_mark_class_dashboard');
    // });

    Route::controller(c_subject_marks_print_co::class)->group(function () {
        Route::post('c_subject_marks_print', 'c_subject_marks_print');
    });


    Route::controller(c_subject_co::class)->group(function () {
        Route::post('c_subject', 'c_subject');
    });

    Route::controller(c_student_co_block::class)->group(function () {
        Route::post('c_student_block', 'c_student_block');
    });

    // Route::controller(c_student_co::class)->group(function () {
    //     Route::post('c_student', 'c_student');
    // });
    Route::controller(c_teacher_co::class)->group(function () {
        Route::post('c_teacher', 'c_teacher');
    });
    Route::controller(c_class_co::class)->group(function () {
        Route::post('c_class', 'c_class');
    });

    Route::controller(admin_semester_co::class)->group(function () {
        Route::post('admin_semester', 'admin_semester');
    });



    // ================================school_admin/add_teacher_new/index

    // Route::prefix('add_teacher_new')->group(function () {
    //     // app\Http\Controllers\TeacherNewController.php
    //     Route::controller(TeacherNewController::class)->group(function () {
    //         Route::post('index', 'index');
    //         Route::post('create', 'create');
    //         Route::post('update', 'update');
    //         Route::post('delete', 'delete');
    //     });
    // });

    // Route::prefix('attendance_teacher')->group(function () {
    //     // route '/api/school_admin/attendance_teacher/attendance_teacher_report'
    //     // app\Http\Controllers\TeacherNewController.php
    //     Route::controller(attendance_teacher_report_co::class)->group(function () {
    //         Route::post('attendance_teacher_report', 'attendance_teacher_report');
    //         // Route::post('create', 'create');
    //         // Route::post('update', 'update');
    //         // Route::post('delete', 'delete');
    //     });
    // });


    // ================================





    // Route::prefix('add_student')->group(function () {

    //     Route::controller(add_student_co::class)->group(function () {
    //         Route::post('db', 'db');
    //     });
    // });



    // Route::prefix('add_marks_xls')->group(function () {

    //     Route::controller(add_marks_xls_co::class)->group(function () {
    //         Route::post('update_first_trimester', 'update_first_trimester');
    //         Route::post('show_all', 'show_all');
    //     });
    // });

    // Route::prefix('top_ten')->group(function () {

    //     Route::controller(top_ten_co::class)->group(function () {
    //         Route::post('create', 'create');
    //         Route::post('update', 'update');
    //         Route::post('delete', 'delete');
    //         Route::post('show_all', 'show_all');
    //         Route::post('show_all_weak', 'show_all_weak');


    //         Route::post('show', 'show');
    //         // Route::post('get_student_marks'     , 'get_student_marks'     );

    //         // Route::post('get_school_classes'     , 'get_school_classes'     );
    //         // Route::post('get_class_students'     , 'get_class_students'     );

    //         //  Route::post('calc_totals'     , 'calc_totals'       );
    //         //  Route::post('average'         , 'average'           );
    //         //  Route::post('order_class'     , 'order_class'       );
    //         //  Route::post('order_grade'     , 'order_grade'       );

    //         //  Route::post('update_student_block'     , 'update_student_block'       );
    //         //  Route::post('get_student_data'     , 'get_student_data'       );



    //     });
    // });




    // // school_admin/certificate/get_student_marks
    // Route::prefix('certificate')->group(function () {

    //     Route::controller(certificate_co::class)->group(function () {
    //         Route::post('create', 'create');
    //         Route::post('update', 'update');
    //         Route::post('delete', 'delete');
    //         Route::post('show_all', 'show_all');
    //         Route::post('show', 'show');
    //         Route::post('get_student_marks', 'get_student_marks');
    //         Route::post('get_class_marks', 'get_class_marks');

    //         Route::post('get_school_classes', 'get_school_classes');
    //         Route::post('get_class_students', 'get_class_students');

    //         Route::post('calc_totals', 'calc_totals');
    //         Route::post('average', 'average');
    //         Route::post('order_class', 'order_class');
    //         Route::post('order_grade', 'order_grade');

    //         Route::post('update_student_block', 'update_student_block');
    //         Route::post('get_student_data', 'get_student_data');
    //     });
    // });




    // Route::prefix('teacher_marks_print_s2')->group(function () {

    //     Route::controller(teacher_marks_print_s2_co::class)->group(function () {
    //         Route::post('create', 'create');
    //         Route::post('update', 'update');
    //         Route::post('delete', 'delete');
    //         Route::post('show_all', 'show_all');
    //         Route::post('show', 'show');
    //         Route::post('get_class_marks', 'get_class_marks');
    //         Route::post('update_marks', 'update_marks');
    //     });
    // });





    // Route::prefix('teacher_marks_print_s1')->group(function () {

    //     Route::controller(teacher_marks_print_s1_co::class)->group(function () {
    //         Route::post('create', 'create');
    //         Route::post('update', 'update');
    //         Route::post('delete', 'delete');
    //         Route::post('show_all', 'show_all');
    //         Route::post('show', 'show');
    //         Route::post('get_class_marks', 'get_class_marks');
    //         Route::post('update_marks', 'update_marks');
    //         Route::post('get_class_marks_all', 'get_class_marks_all');
    //     });
    // });

    // Route::prefix('marks_print_co')->group(function () {

    //     Route::controller(marks_print_co::class)->group(function () {
    //         Route::post('fun', 'fun');
    //     });
    // });



    // Route::prefix('teacher_marks_print_s3')->group(function () {

    //     Route::controller(teacher_marks_print_s3_co::class)->group(function () {
    //         Route::post('create', 'create');
    //         Route::post('update', 'update');
    //         Route::post('delete', 'delete');
    //         Route::post('show_all', 'show_all');
    //         Route::post('show', 'show');
    //         Route::post('get_class_marks', 'get_class_marks');
    //         Route::post('update_marks', 'update_marks');
    //         Route::post('get_class_marks_all', 'get_class_marks_all');
    //     });
    // });


    // Route::prefix('add_school_semester')->group(function () {
    //     // add_school_semester_co
    //     Route::controller(add_school_semester_co::class)->group(function () {
    //         Route::post('create', 'create');
    //         Route::post('update', 'update');
    //         Route::post('delete', 'delete');
    //         Route::post('show_all', 'show_all');
    //         Route::post('show', 'show');
    //     });
    // });




    // // marks_input_follow_co

    // Route::prefix('myfun_school_admin')->group(function () {
    //     Route::controller(myfun_school_admin_co::class)->group(function () {
    //         Route::post('myfun', 'myfun');
    //     });
    // });


    // Route::prefix('marks_input_follow_subject_s3')->group(function () {
    //     Route::controller(marks_input_follow_subject_s3_co::class)->group(function () {
    //         Route::post('create', 'create');
    //         Route::post('update', 'update');
    //         Route::post('delete', 'delete');
    //         Route::post('show_all', 'show_all');
    //         Route::post('show_all_sec', 'show_all_sec');

    //         Route::post('show', 'show');
    //         Route::post('chech_data', 'chech_data');
    //         Route::post('get_subject_totals', 'get_subject_totals');


    //         // Route::post('create_exam_data'     , 'create_exam_data'     );


    //     });
    // });



    // Route::prefix('marks_input_follow_subject')->group(function () {
    //     Route::controller(marks_input_follow_co_subject::class)->group(function () {
    //         Route::post('create', 'create');
    //         Route::post('update', 'update');
    //         Route::post('delete', 'delete');
    //         Route::post('show_all', 'show_all');
    //         Route::post('show_all_sec', 'show_all_sec');
    //         Route::post('all_subject_data_test', 'all_subject_data_test');

    //         Route::post('show', 'show');
    //         Route::post('chech_data', 'chech_data');
    //         Route::post('get_subject_totals', 'get_subject_totals');
    //         Route::post('all_subject_data_test', 'all_subject_data_test');


    //         // Route::post('create_exam_data'     , 'create_exam_data'     );


    //     });
    // });


    // Route::prefix('marks_input_follow_s1_class_subject2023')->group(function () {
    //     Route::controller(marks_input_follow_s1_class_subject2023::class)->group(function () {

    //         Route::post('all_subject_data_test', 'all_subject_data_test');
    //         Route::post('allsubjects', 'allsubjects');



    //         // Route::post('create_exam_data'     , 'create_exam_data'     );


    //     });
    // });






    // Route::prefix('marks_input_follow')->group(function () {
    //     Route::controller(marks_input_follow_co::class)->group(function () {
    //         Route::post('create', 'create');
    //         Route::post('update', 'update');
    //         Route::post('delete', 'delete');
    //         Route::post('show_all', 'show_all');
    //         Route::post('show_all_sec', 'show_all_sec');

    //         Route::post('show', 'show');
    //         Route::post('chech_data', 'chech_data');


    //         // Route::post('create_exam_data'     , 'create_exam_data'     );


    //     });
    // });
    // Route::prefix('grade_subject_mark_xls')->group(function () {
    //     Route::controller(grade_subject_mark_xls_co::class)->group(function () {
    //         Route::post('create', 'create');
    //         Route::post('update', 'update');
    //         Route::post('create_or_update', 'create_or_update');
    //         Route::post('delete', 'delete');
    //         Route::post('show_all', 'show_all');
    //         Route::post('show', 'show');
    //         Route::post('chech_data', 'chech_data');


    //         // Route::post('create_exam_data'     , 'create_exam_data'     );


    //     });
    // });


    // Route::prefix('school_grade_suject_mark')->group(function () {
    //     Route::controller(school_grade_suject_mark_co::class)->group(function () {
    //         Route::post('create', 'create');
    //         Route::post('update', 'update');
    //         Route::post('delete', 'delete');
    //         Route::post('show_all', 'show_all');
    //         Route::post('show', 'show');
    //         // Route::post('create_exam_data'     , 'create_exam_data'     );


    //     });
    // });

    // // /api/school_admin/add_school_exam_new
    // // Route::prefix('add_school_exam_new')->group(function () {
    // // Route::group(function () {
    // Route::controller(add_school_exam_new_co::class)->group(function () {
    //     Route::post('add_school_exam_new', 'add_school_exam_new');
    // });
    // // });
    // // Route::post('add_school_exam_new', 'add_school_exam_new_co@add_school_exam_new')->name('addSchoolExamNew');


    // Route::prefix('add_school_exam')->group(function () {
    //     Route::controller(add_school_exam_co::class)->group(function () {
    //         Route::post('create', 'create');
    //         Route::post('update', 'update');
    //         Route::post('delete', 'delete');
    //         Route::post('show_all', 'show_all');
    //         Route::post('show', 'show');
    //         Route::post('view', 'view');
    //         Route::post('create_exam_data', 'create_exam_data');
    //         Route::post('grade_subject_mark_xls_update', 'grade_subject_mark_xls_update');
    //         Route::post('update_teacher_id_exam_data', 'update_teacher_id_exam_data');
    //     });
    // });

    // Route::prefix('add_school_exam_comp')->group(function () {
    //     Route::controller(add_school_exam_comp_co::class)->group(function () {
    //         Route::post('get_grade3', 'get_grade3');
    //         //   Route::post('update'     , 'update'     );
    //         //   Route::post('delete'     , 'delete'     );
    //         //   Route::post('show_all'     , 'show_all'     );
    //         //   Route::post('show'     , 'show'     );
    //         //   Route::post('view'     , 'view'     );
    //         //   Route::post('create_exam_data'     , 'create_exam_data'     );
    //         //   Route::post('grade_subject_mark_xls_update'     , 'grade_subject_mark_xls_update'     );


    //     });
    // });












    // Route::prefix('add_students_xls')->group(function () {
    //     Route::controller(add_students_xls_co::class)->group(function () {
    //         Route::post('create', 'create');
    //         Route::post('update', 'update');
    //         Route::post('delete', 'delete');
    //         Route::post('show_all', 'show_all');
    //         Route::post('show', 'show');
    //         Route::post('add_students_xls', 'add_students_xls');
    //         Route::post('update_students_order2', 'update_students_order2'); //
    //         Route::post('update_students_block', 'update_students_block'); //
    //         Route::post('update_students_birth_date', 'update_students_birth_date'); //






    //     });
    // });


    // Route::prefix('add_stages')->group(function () {
    //     Route::controller(add_stages_co::class)->group(function () {
    //         Route::post('create', 'create');
    //         Route::post('update', 'update');
    //         Route::post('delete', 'delete');
    //         Route::post('show_all', 'show_all');
    //         Route::post('show', 'show');
    //     });
    // });



    // Route::prefix('add_grades')->group(function () {
    //     Route::controller(add_grades_co::class)->group(function () {
    //         Route::post('create', 'create');
    //         Route::post('update', 'update');
    //         Route::post('delete', 'delete');
    //         Route::post('show_all', 'show_all');
    //         Route::post('show', 'show');
    //     });
    // });

    // Route::prefix('add_classes')->group(function () {
    //     Route::controller(add_classes_co::class)->group(function () {
    //         Route::post('create', 'create');
    //         Route::post('update', 'update');
    //         Route::post('delete', 'delete');
    //         Route::post('show_all', 'show_all');
    //         Route::post('show', 'show');
    //     });
    // });





    // Route::prefix('add_subjects')->group(function () {
    //     Route::controller(add_subjects_co::class)->group(function () {
    //         Route::post('create', 'create');
    //         Route::post('update', 'update');
    //         Route::post('delete', 'delete');
    //         Route::post('show_all', 'show_all');
    //         Route::post('show', 'show');
    //     });
    // });





    // Route::prefix('join_class_subject')->group(function () {
    //     Route::controller(join_class_subject_co::class)->group(function () {
    //         Route::post('create', 'create');
    //         Route::post('update', 'update');
    //         Route::post('delete', 'delete');
    //         Route::post('show_all', 'show_all');
    //         Route::post('show', 'show');
    //     });
    // });


    // Route::prefix('join_class_teacher')->group(function () {
    //     Route::controller(join_class_teacher_co::class)->group(function () {
    //         Route::post('create', 'create');
    //         Route::post('update', 'update');
    //         Route::post('delete', 'delete');
    //         Route::post('show_all', 'show_all');
    //         Route::post('show', 'show');
    //         Route::post('get_filtered_data', 'get_filtered_data');
    //     });
    // });




    // // /api/hr/user_data_xls/user_data_xls

    // Route::prefix('student_data_from_xls')->group(function () {
    //     Route::controller(Hr_student_data_xlsController::class)->group(function () {
    //         Route::post('create', 'create');
    //         Route::post('update', 'update');
    //         // Route::post('permission_to_user_update'     , 'permission_to_user_update'     );
    //         Route::post('delete', 'delete');
    //         Route::post('show_all', 'show_all');
    //         Route::post('show', 'show');
    //         Route::post('students_from_xls', 'students_from_xls');
    //         // Route::post('export_user_data_to_xls'     , 'export_user_data_to_xls'     );


    //     });
    // });



    // // Route::prefix('calendar_main')->group(function () {
    // Route::controller(calendar_main_co::class)->group(function () {
    //     Route::post('calendar_main', 'calendar_main');
    // });
    // // });



});

  // ====== school_admin ====================================================================================
