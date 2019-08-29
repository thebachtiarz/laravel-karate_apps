<?php

use Illuminate\Routing\RouteGroup;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['preventBackHistory']], function () {
    Route::get('/', 'AuthController@login')->name('login');
    Route::get('/OAuth/signout', 'AuthController@signout')->name('logout');
    Route::get('/daftar', 'AuthController@daftar')->name('register');
    Route::get('/lupa_password', 'AuthController@lupa_password')->name('forget.password');
    Route::post('/', 'AuthController@signin');
    Route::post('/daftar', 'AuthController@register');
    Route::post('/lupa_password', 'AuthController@forget_password');
});

// Status bestnimda
Route::group(['middleware' => ['preventBackHistory', 'auth', 'checkRole:bestnimda']], function () {
    // settings
    Route::get('/setting/apps', 'AdminsController@setting')->name('admin.setting');
    Route::get('/ajaxgettable/user', function () {
        return getUsersExceptAdminInTable();
    });
    Route::get('/ajaxgettable/class', function () {
        return getAllClassForAdminManagementInTable();
    });
    Route::get('/ajaxgettable/new_register', function () {
        return getAllNewRegisterInTable();
    });
    Route::get('/setting/apps/users/{id}/edit', 'AdminsController@edituser')->name('admin.setting.user.edit');
    Route::post('/setting/apps/users/{id}/edit', 'AdminsController@usereditsave'); // simpan perubahan pada user
    Route::get('/setting/apps/users/{id}/delete', 'AdminsController@hapususer')->name('admin.setting.user.delete');

    Route::get('/setting/apps/class/{id}/edit', 'AdminsController@editkelas')->name('admin.setting.class.edit');
    Route::get('/setting/apps/class/{id}/delete', 'AdminsController@hapuskelas')->name('admin.setting.class.delete');
    //
    Route::get('/nimda/auth/terminal', 'AdminsController@terminal')->name('admin.menu.terminal');
    Route::post('/nimda/auth/query', 'AdminsController@terminalPost');
    //
});

// Status moderator
Route::group(['middleware' => ['preventBackHistory', 'auth', 'checkRole:moderator']], function () {
    Route::post('/kelas', 'KelasController@addKelas'); // tambah kelas
    Route::get('/pengaturan', 'ModeratorController@pengaturan')->name('moderator.pengaturan');
    Route::get('/ajaxgettable/kelas', function () {
        return getAllAccessClassModeratorByCodeInTable();
    });
    Route::get('/ajaxgettable/reqott', function () {
        return getAllModReqOttInTable();
    });
    Route::get('/ajaxgettable/getdatapeserta', 'ModeratorController@getdatapeserta');
    Route::get('/ajaxgettable/getdatapelatih', 'ModeratorController@getdatapelatih');
    Route::get('/ajaxgettable/getdatabendahara', 'ModeratorController@getdatabendahara');
    Route::get('/ajaxgettable/newpelatih', 'ModeratorController@caripelatihbaru');
    Route::get('/ajaxgettable/pesertakelas/{kelas}/{peserta}', 'ModeratorController@searchPesertaKelas');
    Route::get('/pengaturan/class/{kelas}/edit', 'ModeratorController@editkelas');
    Route::post('/pengaturan/class/{kelas}/edit', 'ModeratorController@editkelassave');
    Route::get('/pengaturan/class/{kelas}/hapus', 'ModeratorController@deleteKelas');
    Route::get('/pengaturan/peserta/profile/{kelas}/{peserta}', 'ModeratorController@profilePesertaTraining'); // lihat profil peserta
    Route::get('/pengaturan/peserta/delete/{kelas}/{peserta}', 'ModeratorController@deletePesertaTraining'); // hapus profil peserta
    Route::post('/pengaturan/persyaratan/budget/refunds_all', 'KelasController@pesertaBudgetRefundsAll'); // kembalikan seluruh simpanan biaya peserta
    Route::get('/pengaturan/otentifikasi/confirm/{id}', 'ModeratorController@otentifikasi');
    Route::post('/pengaturan/otentifikasi/confirm/{id}', 'ModeratorController@otentifikasi_save');
    Route::get('/pengaturan/otentifikasi/delete/{id}', 'ModeratorController@otentifikasi_delete');
    // 
});


// prefix status
// admin, moderator
Route::group(['middleware' => ['preventBackHistory', 'auth', 'checkRole:bestnimda,moderator']], function () {
    //
});
// moderator, treasurer
Route::group(['middleware' => ['preventBackHistory', 'auth', 'checkRole:moderator,treasurer']], function () {
    Route::get('/kelas/record/spp', 'ModeratorController@bayarspp')->name('moderator.payment.spp');
    Route::get('/kelas/record/spp/{class_code}/{pst_code}', 'ModeratorController@getRecordSppPesertaByCode'); // ajax request cari record spp peserta
    Route::post('/kelas/record/spp/push_record', 'ModeratorController@pushRecordSppPesertaSave'); // ajax push new data spp peserta
    Route::post('/kelas/record/persyaratan', 'KelasController@save_record_requirement'); //simpan persyaratan peserta
    //
    Route::get('/kelas/record/persyaratan/cashback', 'KelasController@cashback_payment_examn'); // kembalikan kelebihan biaya ujian peserta
});
// moderator, treasurer, instructor
Route::group(['middleware' => ['preventBackHistory', 'auth', 'checkRole:moderator,treasurer,instructor']], function () {
    Route::post('/kelas/add_peserta', 'PesertaController@add_peserta'); // tambah peserta
    Route::post('/kelas/record/latihan', 'KelasController@save_record_training'); // simpan record latihan
});
// bestnimda, moderator, treasurer, instructor
Route::group(['middleware' => ['preventBackHistory', 'auth', 'checkRole:bestnimda,moderator,treasurer,instructor']], function () {
    Route::get('/kelas', 'KelasController@home')->name('kelas.home');
    Route::get('/kelas/record/latihan', 'KelasController@rec_latihan')->name('kelas.record.latihan');
    Route::get('/kelas/record/persyaratan', 'KelasController@rec_persyaratan')->name('kelas.record.persyaratan');
});


Route::group(['middleware' => ['preventBackHistory', 'auth', 'checkRole:bestnimda,moderator']], function () { });
Route::group(['middleware' => ['preventBackHistory', 'auth', 'checkRole:bestnimda,moderator']], function () { });
Route::group(['middleware' => ['preventBackHistory', 'auth', 'checkRole:bestnimda,moderator']], function () { });



// bestnimda, moderator, treasurer, instructor, participants
Route::group(['middleware' => ['preventBackHistory', 'auth', 'checkRole:bestnimda,moderator,treasurer,instructor,participants']], function () {
    Route::get('/materi', 'PesertaController@training_material');
    Route::post('/materi/get', 'PesertaController@getJuklakUjianAuth'); // ajax get materi
});

// participants, parents
Route::group(['middleware' => ['preventBackHistory', 'auth', 'checkOtentification', 'checkRole:participants,parents']], function () {
    Route::get('/latihan', 'PesertaParentController@time_training');
    Route::get('/persyaratan', 'PesertaParentController@exam_requirements');
    Route::get('/spp_peserta', 'PesertaParentController@monthly_fee');
    Route::get('/rapor', 'PesertaParentController@view_report_book');
});

// guests
Route::group(['middleware' => ['preventBackHistory', 'auth', 'checkRole:guests']], function () {
    //
});

// otentification method, and if participants or parents need otentification again
Route::group(['middleware' => ['preventBackHistory', 'auth', 'needOtentification']], function () {
    Route::get('/otentifikasi', 'UserController@otentifikasi');
    Route::get('/otentifikasi/hapus/{id}', 'UserController@otentifikasi_delete');
    Route::post('/otentifikasi', 'UserController@otentifikasi_save');
    Route::post('/guestajax/search/otentifikasi/{srcRes}', 'UserController@searchDataResult');
});

// bestnimda, moderator, treasurer, instructor, participants, parents
Route::group(['middleware' => ['preventBackHistory', 'auth', 'checkRole:bestnimda,moderator,treasurer,instructor,participants,parents']], function () {
    Route::get('/profile/account/{slugname}', 'UserController@viewprofile');
});

// all status
Route::group(['middleware' => ['preventBackHistory', 'auth', 'checkRole:bestnimda,moderator,treasurer,instructor,participants,parents,guests']], function () {
    Route::get('/home', 'HomeController@home')->name('home');
    Route::get('/profile', 'UserController@profile')->name('user.profile');
    Route::post('/profile', 'UserController@profilesave')->name('user.profile');
});
