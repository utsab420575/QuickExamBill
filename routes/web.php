<?php

use App\Http\Controllers\CommitteeInputController;
use App\Http\Controllers\CommitteeInputReviewController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ImportExportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportReviewController;
use App\Http\Controllers\RoleAssignmentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/user/logout', 'UserDestroy')->name('user.logout');
        Route::get('/user/profile', 'UserProfile')->name('user.profile');
        Route::post('/user/profile/store', 'UserProfileStore')->name('user.profile.store');
        Route::get('/user/password/change','UserPasswordChange')->name('user.password.change');
        Route::post('/user/password/update','UserPasswordUpdate')->name('user.password.update');
    });

    Route::controller(ImportExportController::class)->group(function(){
        Route::get('import/table/all','ImportAllTable')->name('import.table.all');
        Route::post('import/table/users','ImportUserTable')->name('import.table.users');
        Route::post('import/table/faculties','ImportFacultyTable')->name('import.table.faculties');
        Route::post('import/table/departments','ImportDepartmentTable')->name('import.table.departments');
        Route::post('import/table/designations','ImportDesignationTable')->name('import.table.designations');
        Route::post('import/table/teachers','ImportTeacherTable')->name('import.table.teachers');
    });




    //For Regular Session
    Route::prefix('committee/input')->controller(CommitteeInputController::class)->group(function () {
        //show regular session list form
        Route::get('/regular/session', 'regularSessionShow')->name('committee.input.regular.session');
        //show full form
        Route::post('/regular/session/form', 'regularSessionForm')->name('committee.input.regular.session.form');
        //now store committee wise data to database ;
        Route::post('/regular/examination/moderation/committee/store', 'storeExaminationModerationCommittee')->name('committee.input.regular.examination.moderation.committee.store');
        Route::post('/regular/examiner/paper/setter/store','storeExaminerPaperSetter')->name('committee.input.regular.examiner.paper.setter.store');
        Route::post('/regular/class/test/teacher/store', 'storeClassTestTeacherStore')->name('committee.input.regular.class.test.teacher.store');
        Route::post('/regular/sessional/course/teacher/store', 'storeSessionalCourseTeacher')->name('committee.input.regular.sessional.course.teacher.store');
        Route::post('/regular/list/scrutinizers/store', 'storeScrutinizers')->name('committee.input.regular.scrutinizers.store');
        Route::post('/regular/theory/grade/sheet/store', 'storeTheoryGradeSheet')->name('committee.input.regular.theory.grade.sheet.store');
        Route::post('/regular/sessional/grade/sheet/store', 'storeSessionalGradeSheet')->name('committee.input.sessional.grade.sheet.store');
        Route::post('/regular/scrutinizers/theory/grade/sheet/store', 'storeScrutinizersTheoryGradeSheet')->name('committee.input.scrutinizers.theory.grade.sheet.store');
        Route::post('/regular/scrutinizers/sessional/grade/sheet/store','storeScrutinizersSessionalGradeSheet')->name('committee.input.scrutinizers.sessional.grade.sheet.store');
        Route::post('/regular/prepare/computerized/result/store','storePreparedComputerizedResult')->name('committee.input.prepare.computerized.result.store');
        Route::post('/regular/verified/computerized/grade/sheet/store', 'storeVerifiedComputerizedGradeSheet')->name('committee.input.verified.computerized.grade.sheet.store');
        Route::post('/regular/conducted/central/oral/exam/store', 'storeConductedCentralOralExam')->name('committee.input.conducted.central.oral.exam.store');

        Route::post('/regular/stencil/cutting/committee/store', 'storeStencilCuttingCommittee')->name('committee.input.stencil.cutting.committee.store');
        Route::post('/regular/printing/question/committee/store', 'storePrintingQuestion')->name('committee.input.printing.question.committee.store');
        Route::post('/regular/comparison/committee/store', 'storeComparisonCommittee')->name('committee.input.comparison.committee.store');
        Route::post('/regular/advisor/student/store', 'storeAdvisorStudent')->name('committee.input.advisor.student.store');
        Route::post('/regular/verified/final/graduation/result/store', 'storeVerifiedFinalGraduationResult')->name('committee.input.verified.final.graduation.result.store');
        Route::post('/regular/conducted/central/oral/exam/store', 'storeConductedCentralOralExam')->name('committee.input.conducted.central.oral.exam.store');
        Route::post('/regular/involved/survey/store', 'storeInvolvedSurvey')->name('committee.input.involved.survey.store');
        Route::post('/regular/conducted/preliminary/viva/store', 'storeConductedPreliminaryViva')->name('committee.input.conducted.preliminary.viva.store');
        Route::post('/regular/examined/thesis/project/store', 'storeExaminedThesisProject')->name('committee.input.examined.thesis.project.store');
        Route::post('/regular/conducted/oral/examination/store','storeConductedOralExamination')->name('committee.input.conducted.oral.examination.store');
        Route::post('/regular/supervised/thesis/project/store', 'storeSupervisedThesisProject')->name('committee.input.supervised.thesis.project.store');
        Route::post('/regular/honorarium/coordinator/store', 'storeHonorariumCoordinator')->name('committee.input.honorarium.coordinator.store');
        Route::post('/regular/honorarium/chairman/store', 'storeHonorariumChairman')->name('committee.input.honorarium.chairman.store');
    });

    //For Review Session
    Route::prefix('committee/input')->controller(CommitteeInputReviewController::class)->group(function () {
        //show review session list form
        Route::get('review/session', 'reviewSessionShow')->name('committee.input.review.session');
        //show full form
        Route::post('review/session/form', 'reviewSessionForm')->name('committee.input.review.session.form');
        //now store committee wise data to database ;
        Route::post('/review/examination/moderation/committee/store', 'storeExaminationModerationCommittee')->name('committee.input.review.examination.moderation.committee.store');
        Route::post('/review/examiner/paper/setter/store','storeExaminerPaperSetter')->name('committee.input.review.examiner.paper.setter.store');
        Route::post('/review/list/scrutinizers/store', 'storeScrutinizers')->name('committee.input.review.scrutinizers.store');
        Route::post('/review/theory/grade/sheet/store', 'storeReviewTheoryGradeSheet')->name('committee.input.review.theory.grade.sheet.store');
        Route::post('/review/scrutinizers/theory/grade/sheet/store',  'storeReviewScrutinizersTheoryGradeSheet')->name('committee.input.review.scrutinizers.theory.grade.sheet.store');

        Route::post('/review/stencil/cutting/committee/store', 'storeStencilCuttingCommittee')->name('committee.input.review.stencil.cutting.committee.store');
        Route::post('/review/printing/question/committee/store', 'storePrintingQuestion')->name('committee.input.review.printing.question.committee.store');
        Route::post('/review/comparison/committee/store', 'storeComparisonCommittee')->name('committee.input.review.comparison.committee.store');
        Route::post('/review/chairman/coordinator/store', 'storeHonorariumChairman')->name('committee.input.review.chairman.coordinator.store');
    });


    //For Report
    //For Regular Session
    Route::prefix('report')->controller(ReportController::class)->group(function () {
        //show review session list form
        Route::get('/regular/session', 'regularSessionShow')->name('report.regular.session');
        Route::post('/regular/generate', 'regularReportGenerate')->name('report.regular.generate');
    });

    //For Regular Session
    Route::prefix('report')->controller(ReportReviewController::class)->group(function () {
        Route::get('/review/session', 'reviewSessionShow')->name('report.review.session');
        Route::post('/review/generate', 'reviewReportGenerate')->name('report.review.generate');
    });

    Route::controller(TeacherController::class)->group(function () {
        Route::get('/teacher/all', 'AllTeacher')->name('teacher.all');
        Route::get('/teacher/add', 'AddTeacher')->name('teacher.add');
        Route::post('/teacher/store', 'StoreTeacher')->name('teacher.store');
        Route::get('/teacher/edit/{id}', 'EditTeacher')->name('teacher.edit');
        Route::post('/teacher/update', 'UpdateTeacher')->name('teacher.update');
        Route::get('/teacher/delete/{id}', 'DeleteTeacher')->name('teacher.delete');
    });

    Route::controller(EmployeeController::class)->group(function () {
        Route::get('/employee/all', 'AllEmployee')->name('employee.all');
        Route::get('/employee/add', 'AddEmployee')->name('employee.add');
        Route::post('/employee/store', 'StoreEmployee')->name('employee.store');
        Route::get('/employee/edit/{id}', 'EditEmployee')->name('employee.edit');
        Route::post('/employee/update', 'UpdateEmployee')->name('employee.update');
        Route::get('/employee/delete/{id}', 'DeleteEmployee')->name('employee.delete');
    });


    ///Permission All Route More actions
    // Roles/Permissions
    Route::controller(RoleController::class)->group(function () {
        //Permission
        Route::get('/permission/all', 'AllPermission')->name('permission.all');
        Route::get('/permission/add', 'AddPermission')->name('permission.add');
        Route::post('/permission/store', 'StorePermission')->name('permission.store');
        Route::get('/permission/edit/{id}', 'EditPermission')->name('permission.edit');
        Route::post('/permission/update', 'UpdatePermission')->name('permission.update');
        Route::get('/permission/delete/{id}', 'DeletePermission')->name('permission.delete');

        //Role
        Route::get('/roles/all', 'AllRoles')->name('roles.all');
        Route::get('/roles/add', 'AddRoles')->name('roles.add');
        Route::post('/roles/store', 'StoreRoles')->name('roles.store');
        Route::get('/roles/edit/{id}', 'EditRoles')->name('roles.edit');
        Route::post('/roles/update', 'UpdateRoles')->name('roles.update');
        Route::get('/roles/delete/{id}', 'DeleteRoles')->name('roles.delete');



        ///Add Roles in Permission All Route (Assign Permission(Route) In Roles)
        /// Here We select Which Role Can Access Which Permission
        Route::get('/roles/permissions/add', 'AddRolesPermission')->name('roles.permissions.add');
        //Role and related permission store into database
        Route::post('/role/permission/store','StoreRolesPermission')->name('role.permission.store');
        Route::get('roles/permission/all','AllRolesPermission')->name('roles.permission.all');
        Route::get('roles/permission/edit/{id}','EditRolePermissions')->name('role.permission.edit');
        Route::post('/role/permission/update','UpdateRolePermission')->name('role.permission.update');
        Route::get('/role/permission/delete/{id}','DeleteRolesPermission')->name('role.permission.delete');
    });

    // User Add/Edit/Delete
    Route::controller(RoleAssignmentController::class)->group(function(){
        Route::get('/role/assignments', 'AllRoleAssignments')->name('role.assignments.all');
        Route::get('/role/assignments/add','AddRoleAssignments')->name('role.assignments.add');
        Route::post('/role/assignments/store','StoreRoleAssignments')->name('role.assignments.store');


        Route::get('/role/assignments/edit/{id}','EditRoleAssignments')->name('role.assignments.edit');
        Route::post('/role/assignments/update','UpdateRoleAssignments')->name('role.assignments.update');
        Route::get('/role/assignments/delete/{id}','DeleteRoleAssignments')->name('role.assignments.delete');
    });







});

require __DIR__.'/auth.php';
