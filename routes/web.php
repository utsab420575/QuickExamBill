<?php

use App\Http\Controllers\CommitteeInputController;
use App\Http\Controllers\CommitteeInputReviewController;
use App\Http\Controllers\ImportExportController;
use App\Http\Controllers\ProfileController;
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
        Route::post('/regular/conducted/central/oral/exam/store', 'storeConductedCentralOralExam')->name('conducted.central.oral.exam.store');

        Route::post('/regular/stencil/cutting/committee/store', 'storeStencilCuttingCommittee')->name('committee.input.stencil.cutting.committee.store');
        Route::post('/regular/printing/question/committee/store', 'storePrintingQuestion')->name('committee.input.printing.question.committee.store');
        Route::post('/regular/comparison/committee/store', 'storeComparisonCommittee')->name('committee.input.comparison.committee.store');
        Route::post('/regular/advisor/student/store', 'storeAdvisorStudent')->name('committee.input.advisor.student.store');
        Route::post('/regular/verified/final/graduation/result/store', 'storeVerifiedFinalGraduationResult')->name('verified.final.graduation.result.store');
        Route::post('/regular/conducted/central/oral/exam/store', 'storeConductedCentralOralExam')->name('conducted.central.oral.exam.store');

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
    });


    //Regular SubForm



/*
    Route::post('/scrutinizers/sessional/grade/sheet/store', [StaffController::class, 'storeScrutinizersSessionalGradeSheet'])->name('scrutinizers.sessional.grade.sheet.store');
    Route::post('/prepare/computerized/result/store', [StaffController::class, 'storePreparedComputerizedResult'])->name('prepare.computerized.result.store');
    Route::post('/verified/computerized/result/store', [StaffController::class, 'storeVerifiedComputerizedResult'])->name('verified.computerized.result.store');
    Route::post('/supervision/under/chairman/exam/committee/store', [StaffController::class, 'storeSupervisionUnderChairmanExamCommittee'])->name('supervision.under.chairman.exam.committee.store');
    Route::post('/advisor/student/store', [StaffController::class, 'storeAdvisorStudent'])->name('advisor.student.store');
    Route::post('/verified/final/graduation/result/store', [StaffController::class, 'storeVerifiedFinalGraduationResult'])->name('verified.final.graduation.result.store');*/

    Route::post('/involved/survey/store', [StaffController::class, 'storeInvolvedSurvey'])->name('involved.survey.store');
    Route::post('/conducted/preliminary/viva/store', [StaffController::class, 'storeConductedPreliminaryViva'])->name('conducted.preliminary.viva.store');
    Route::post('/conducted/oral/examination/store', [StaffController::class, 'storeConductedOralExamination'])->name('conducted.oral.examination.store');
    Route::post('/supervised/thesis/project/store', [StaffController::class, 'storeSupervisedThesisProject'])->name('supervised.thesis.project.store');
    Route::post('/examined/thesis/project/store', [StaffController::class, 'storeExaminedThesisProject'])->name('examined.thesis.project.store');
    Route::post('/honorarium/coordinator/committee/store', [StaffController::class, 'storeHonorariumCoordinatorCommittee'])->name('honorarium.coordinator.committee.store');
    Route::post('/honorarium/chairman/committee/store', [StaffController::class, 'storeHonorariumChairmanCommittee'])->name('honorarium.chairman.committee.store');







});

require __DIR__.'/auth.php';
