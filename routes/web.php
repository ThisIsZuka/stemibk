<?php
//login page

use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('login', 'LoginController@index');
//check_login




Route::post('check_login','LoginController@check_login');

Route::get('patient', 'PatientController@index');

Route::get('patient_create', 'PatientController@create');
Route::get('patient_waiting_for_response', 'PatientController@waiting_for_response');
Route::get('patient_check_accept', 'PatientController@check_accept');
Route::get('patientmap', 'PatientController@load_map');
Route::get('patientmaphospital', 'PatientController@load_map_hospital');
Route::get('patient_check_request', 'PatientController@check_request');
Route::get('load_location_map_ios','PatientController@load_location_map_ios');
Route::get('load_location_map','PatientController@load_location_map');
Route::get('update_traveling_status','PatientController@update_traveling_status');

Route::get('get_edititem','PatientController@get_edititem');


Route::get('patient_edit/{id}', 'PatientController@patient_edit');
Route::post('update_patient','PatientController@update_patient');
Route::post('send_patient','PatientController@send_patient');
Route::post('save_setting','SettingController@save_setting');

Route::any('updateedit_patient', 'PatientController@updateedit_patient');

Route::any('update_accept','PatientController@update_accept');
Route::post('update_fail','PatientController@update_fail');
Route::post('update_reject','PatientController@update_reject');
Route::post('update_cancel','PatientController@update_cancel');
Route::post('update_getsend','PatientController@update_getsend');
Route::post('update_navigator','PatientController@update_navigator');
Route::post('update_sendalong','PatientController@update_sendalong');
Route::post('update_send_patient','PatientController@update_send_patient');
Route::post('update_reverse_status','PatientController@update_reverse_status');

// listambulance
Route::post('list_ambulance','PatientController@list_ambulance');
Route::post('sendpt_ambulance','PatientController@sendpt_ambulance');
Route::get('ambulan_schedule','PatientController@ambulan_schedule');



Route::get('load_location','PatientController@load_location');
Route::get('update_location','PatientController@update_location');
Route::post('update_distance_matrix','PatientController@update_distance_matrix');

Route::post('update_traveling_10_m_status','PatientController@update_traveling_10_m_status');

// Route::any('dashboard','DashboardController@didoprocess');

Route::any('dashboard', function(){
    return view('patient.dashboard');    
});


// ลงทะเบียนหน้าแอป
Route::any('regisuser',function(){
    return response()->json(['data'=>"success"]);
});
// logout
Route::get('logout','LoginController@logout');
// google map
Route::get('map_google','MapController@index');

Route::get('patient_load','PatientController@patient_load');
//

Route::get('chat_stemi','StemiChatController@index');


Route::get('chat_stemi_hospital','StemiChatController@hospital');

Route::get('stemi_hospital','StemiHospitalController@index');
Route::get('loading_hos','StemiHospitalController@loading_hos');
// chat
Route::get('patient_profile/{id}','PatientProfileController@get_profile');
Route::get('view_ekg/{id}','EkgController@view_ekg');
Route::any('ekg_view','EkgController@ekg_view');
Route::get('get_setting','SettingController@get_setting');
Route::any('doctor_view','PatientController@doctor_view');
Route::post('senddoctorekg','EkgController@send_doctorview');

// ลบผู้ป่วย
Route::any('delete_item','PatientController@delete_partien');
// ปิดลบผู้ป่วย

Route::get('/',function(){
   return  view('auth/intro');
});

Route::any('register', function () {
    return view('auth/register');
});

Route::get('signin', 'LoginController@index');

Route::resource('wb','WebboardController');


Route::any('wbdel','WebboardController@wbdel');





Route::resource('user','UsernewController');
// Route::resource('useredit','MemberController');
// Route::any('useradd','MemberController@useradd');
// Route::any('useraddnew','MemberController@useraddnew');

// admin //





Route::any('cancel', 'PatientController@cancel');





Route::post('Register', 'Auth\RegisterController@store');







Route::resource('hospital', 'HospitalController');

Route::resource('setting', 'WebsettingController');
Route::resource('chat', 'ChatController');
Route::resource('alert', 'AlertController');
Route::view('noti','1page.noti');
Route::view('move','move_data');
Route::view('show_ekg','show_ekg');
Route::view('step02','accept.step02');
Route::view('mapmap','search_map');
Route::view('mapdirection','client.mapdirection');
Route::view('update_point','patient.update_point');




Route::resource('clientmap','ClientmapController');
Route::resource('updatelocation','UpdatelocationController');






