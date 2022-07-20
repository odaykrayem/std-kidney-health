<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;


/**
 * Users Types :
 * int USER_TYPE_DOCTOR = 1;
 * int USER_TYPE_PATIENT = 2;
 * //////
 * Gender :
 * int MALE = 0;
 * int FEMALE = 1;
 * /////////
 * Status Types :
 *int APPOINTMENT_PROCESSING = 1;
 * int APPOINTMENT_REJECTED = 0;
 * int APPOINTMENT_APPROVED = 2;
 */
/**login
 *
 * @param String email
 * @param String password
 * @param int type
 *
 * @return patient or doctor
 *
 */
Route::post('/login', function (Request $request) {
    $input = $request->all();

    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|min:8'
    ]);

    if ($validator->fails()) {
        return Response::json([
            'message' => 'Error Input Data',
            'data' => $validator->getMessageBag()
        ], 400);
    }

    if (auth('web')->attempt(['email' => $input['email'],
        'password' => $input['password']], false)) {


        $user = \App\Models\Patient::where([
            'email' => $input['email']
        ])->first();

        $user->type = 2;

        return Response::json([
            'message' => 'User founded!',
            'data' => $user
        ], 200);
    } elseif (auth('doctor')->attempt(['email' => $input['email'],
        'password' => $input['password']], false)) {


        $user = \App\Models\Doctor::where([
            'email' => $input['email']
        ])->first();


        $user->type = 1;

        return Response::json([
            'message' => 'User founded!',
            'data' => $user
        ], 200);
    } else {
        return Response::json([
            'message' => 'User not found!',
            'data' => ''
        ], 200);
    }
});


/**
 * register_patient
 * @param String first_name
 * @param String last_name
 * @param String email
 * @param string password
 * @param int gender
 * @param String phone
 * @param String address
 * @param int age
 *
 * @return  patient
 */


Route::post('/register_patient', function (Request $request) {

    $validator = Validator::make($request->all(), [
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|email|unique:patient,email',
        'password' => 'required|min:8',
        'gender' => 'required|numeric',
        'phone' => 'required',
        'address' => 'required',
        'age' => 'required|numeric',
    ]);

    if ($validator->fails()) {
        return Response::json([
            'message' => 'Error Input Data',
            'data' => $validator->getMessageBag()
        ], 400);
    }

    $data = new \App\Models\Patient();
    $data->first_name = $request->input('first_name');
    $data->last_name = $request->input('last_name');
    $data->email = $request->input('email');
    $data->phone = $request->input('phone');
    $data->gender = $request->input('gender');
    $data->address = $request->input('address');
    $data->age = $request->input('age');
    $data->password = bcrypt($request->password);
    $data->save();

    return Response::json([
        'message' => 'User Saved!',
        'data' => $data
    ], 200);

});

/**register_doctor
 *
 * @param String first_name
 * @param String last_name
 * @param String email
 * @param String password
 * @param String phone
 * @param String details
 *
 * @return doctor
 */

Route::post('/register_doctor', function (Request $request) {

    $validator = Validator::make($request->all(), [
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|email|unique:doctor,email',
        'password' => 'required|min:8',
        'phone' => 'required',
        'details' => 'required'
    ]);

    if ($validator->fails()) {
        return Response::json([
            'message' => 'Error Input Data',
            'data' => $validator->getMessageBag()
        ], 400);
    }

    $data = new \App\Models\Doctor();
    $data->first_name = $request->input('first_name');
    $data->last_name = $request->input('last_name');
    $data->email = $request->input('email');
    $data->phone = $request->input('phone');
    $data->details = $request->input('details');
    $data->password = bcrypt($request->password);
    $data->save();

    return Response::json([
        'message' => 'User Saved!',
        'data' => $data
    ], 200);

});

/**
 * get_doctor_cneter
 * @param int doctor_id
 * @return center
 *  * Center
 *    int id;
 *    String name;
 *    double lat;
 *    double lon;
 *    String location;
 *    String info;
 */

Route::get('/get_doctor_center', function (Request $request) {

    $data = \App\Models\Center::query();

    if ($request->has('doctor_id')) {
        $data = $data->where('doctor_id', $request->doctor_id);
    }

    $data = $data->get();

    return Response::json([
        'message' => 'Success!',
        'data' => $data
    ], 200);

});

/**
 * get_centers : get all centers from database
 * @return list of centers each object has these info:
 *      * int id;
 *      * String name;
 *      * String doctorName; // using doctor_id
 *      * double lat;
 *      * double lon;
 *      * String info;
 */
Route::get('/get_centers', function (Request $request) {

    $data = \App\Models\Center::query();

    $data = $data->get();

    return Response::json([
        'message' => 'Success!',
        'data' => $data
    ], 200);

});

//Patient update_patient(String first_name, String last_name, String address, String phone);

Route::post('/update_patient', function (Request $request) {

    $validator = Validator::make($request->all(), [
        'id' => 'required',
        'first_name' => 'required',
        'last_name' => 'required',
        'address' => 'required',
        'phone' => 'required',
    ]);

    if ($validator->fails()) {
        return Response::json([
            'message' => 'Error Input Data',
            'data' => $validator->getMessageBag()
        ], 400);
    }

    $data = \App\Models\Patient::where('id', $request->id)->first();
    $data->first_name = $request->input('first_name');
    $data->last_name = $request->input('last_name');
    $data->address = $request->input('address');
    $data->phone = $request->input('phone');
    $data->update();

    return Response::json([
        'message' => 'User Saved!',
        'data' => $data
    ], 200);

});


//    Patient update_doctor(String first_name, String last_name, String address, String phone);

Route::post('/update_doctor', function (Request $request) {

    $validator = Validator::make($request->all(), [
        'id' => 'required',
        'first_name' => 'required',
        'last_name' => 'required',
        'address' => 'required',
        'phone' => 'required',
    ]);

    if ($validator->fails()) {
        return Response::json([
            'message' => 'Error Input Data',
            'data' => $validator->getMessageBag()
        ], 400);
    }

    $data = \App\Models\Doctor::where('id', $request->id)->first();
    $data->first_name = $request->input('first_name');
    $data->last_name = $request->input('last_name');
    $data->address = $request->input('address');
    $data->phone = $request->input('phone');
    $data->address = $request->has('address') ? $request->input('address') : '';
    $data->update();

    return Response::json([
        'message' => 'User Saved!',
        'data' => $data
    ], 200);

});

//    boolean make_appointment(int patient_id, int center_id);
Route::post('/make_appointment', function (Request $request) {

    $validator = Validator::make($request->all(), [
        'patient_id' => 'required',
        'center_id' => 'required'
    ]);

    if ($validator->fails()) {
        return Response::json([
            'message' => 'Error Input Data',
            'data' => $validator->getMessageBag()
        ], 400);
    }

    $data = new \App\Models\Appointment();
    $data->patient_id = $request->input('patient_id');
    $data->center_id = $request->input('center_id');
    $data->status = 1;
    $data->save();

    return Response::json([
        'message' => 'User Saved!',
        'data' => $data
    ], 200);

});


//    boolean insert_daily_info(int patient_id, String water, String medicine);
Route::post('/insert_daily_info', function (Request $request) {

    $validator = Validator::make($request->all(), [
        'patient_id' => 'required',
        'water' => 'required',
        'medicine' => 'required',
    ]);

    if ($validator->fails()) {
        return Response::json([
            'message' => 'Error Input Data',
            'data' => $validator->getMessageBag()
        ], 400);
    }

    $data = new \App\Models\DailyInfo();
    $data->patient_id = $request->input('patient_id');
    $data->water_quntity = $request->input('water');
    $data->medicine_info = $request->input('medicine');
    $data->save();

    return Response::json([
        'message' => 'User Saved!',
        'data' => $data
    ], 200);

});

/**
 * int id;
 * String doctorName;
 * String centerName;
 * int patientId;
 * String date;
 * int status;
 * String resultInfo;
 * String patientStatus;
 */
//    ArrayList<Appointment> get_my_appointments(int patient_id);

Route::get('/get_my_appointments', function (Request $request) {

    $data = \App\Models\Appointment::query();

    if ($request->has('patient_id')) {
        $data = $data->where('patient_id', $request->patient_id);
    }

    $data = $data->get();

    return Response::json([
        'message' => 'Success!',
        'data' => $data
    ], 200);

});


/**
 *     int id;
 *     String date;
 *     String instruction;
 */
//    ArrayList<Instruction> get_instructions(int patient_id, int doctor_id);
Route::get('/get_instructions', function (Request $request) {

    $data = \App\Models\Instruction::query();

    if ($request->has('patient_id')) {
        $data = $data->where('patient_id', $request->patient_id);
    }

    if ($request->has('doctor_id')) {
        $data = $data->where('doctor_id', $request->doctor_id);
    }

    $data = $data->get();

    return Response::json([
        'message' => 'Success!',
        'data' => $data
    ], 200);

});

Route::post('/insert_instructions', function (Request $request) {

    $validator = Validator::make($request->all(), [
        'patient_id' => 'required',
        'doctor_id' => 'required',
        'content' => 'required',
    ]);

    if ($validator->fails()) {
        return Response::json([
            'message' => 'Error Input Data',
            'data' => $validator->getMessageBag()
        ], 400);
    }

    $data = new \App\Models\Instruction();
    $data->doctor_id = $request->input('doctor_id');
    $data->patient_id = $request->input('patient_id');
    $data->content = $request->input('content');
    $data->save();

    return Response::json([
        'message' => 'User Saved!',
        'data' => $data
    ], 200);

});


/**
 * Center:
 *     int id;
 *     String name;
 *     String doctorName;
 *     double lat;
 *     double lon;
 *     String info;
 *     double distance;
 */

Route::get('/get_centers', function (Request $request) {

    $data = \App\Models\Center::query();

    if ($request->has('doctor_id')) {
        $data = $data->where('doctor_id', $request->doctor_id);
    }

    $data = $data->get();

    return Response::json([
        'message' => 'Success!',
        'data' => $data
    ], 200);

});

Route::post('/insert_center', function (Request $request) {

    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'info' => 'required',
        'lat' => 'required',
        'lon' => 'required',
        'location' => 'required',
    ]);

    if ($validator->fails()) {
        return Response::json([
            'message' => 'Error Input Data',
            'data' => $validator->getMessageBag()
        ], 400);
    }

    $data = new \App\Models\Center();
    $data->doctor_id = $request->has('doctor_id') ? $request->input('doctor_id') : null;
    $data->name = $request->input('name');
    $data->info = $request->input('info');
    $data->lat = $request->input('lat');
    $data->lon = $request->input('lon');
    $data->location = $request->input('location');
    $data->save();

    return Response::json([
        'message' => 'User Saved!',
        'data' => $data
    ], 200);

});


/**get_instructions
 * @param patient_id
 * @param doctor_id
 *
 *     int id;
 *     String date;
 *     String instruction;
 */

Route::get('/get_instructions', function (Request $request) {

    $data = \App\Models\Instruction::query();

    if ($request->has('doctor_id')) {
        $data = $data->where('doctor_id', $request->doctor_id);
    }

    if ($request->has('patient_id')) {
        $data = $data->where('patient_id', $request->patient_id);
    }

    $data = $data->get();

    return Response::json([
        'message' => 'Success!',
        'data' => $data
    ], 200);

});


/**get_my_daily_info
 * @param patient_id
 * @return list of daily_ifo
 * each item has these info
 * int id
 * String water
 * String medicine
 * date created_at
 *
 */

Route::get('/get_my_daily_info', function (Request $request) {

    $data = \App\Models\DailyInfo::query();

    if ($request->has('patient_id')) {
        $data = $data->where('patient_id', $request->patient_id);
    }

    $data = $data->get();

    return Response::json([
        'message' => 'Success!',
        'data' => $data
    ], 200);

});


/**delete_daily_info
 * @param patient_id
 * @param daily_id // record id
 *
 * @return status of api request
 */

Route::post('/delete_daily_info', function (Request $request) {

    $validator = Validator::make($request->all(), [
        'patient_id' => 'required',
        'daily_id' => 'required'
    ]);

    if ($validator->fails()) {
        return Response::json([
            'message' => 'Error Input Data',
            'data' => $validator->getMessageBag()
        ], 400);
    }

    $data = \App\Models\DailyInfo::where([
        'id' => $request->daily_id,
        'patient_id' => $request->patient_id
    ])->delete();

    return Response::json([
        'message' => 'Deleted!',
        'data' => $data
    ], 200);

});


/**get_doctors_list
 *
 * @return list of doctors
 * each item has these info
 *  int id;
 *  String firstName;
 *  String lastName;
 *  String email;
 *  String phone;
 *  String details;
 */

Route::get('/get_doctors_list', function (Request $request) {

    $data = \App\Models\Doctor::query();

    $data = $data->get();

    return Response::json([
        'message' => 'Success!',
        'data' => $data
    ], 200);

});


/**get_patients
 * @reurn lst of patients
 * each item has these info
 * int id;
 * String firstName;
 * String lastName;
 * String email;
 * String phone;
 * String address;
 * int age;
 * int gender
 */

Route::get('/get_patients', function (Request $request) {

    $data = \App\Models\Patient::query();

    $data = $data->get();

    return Response::json([
        'message' => 'Success!',
        'data' => $data
    ], 200);

});


/**get_patient_daily_info
 * @param patient_id
 *
 * @return list of daily_info
 * each item has these info
 *  int id
 *  String water
 *  String medicine
 *  date created_at
 *
 */

Route::get('/get_patient_daily_info', function (Request $request) {

    $data = \App\Models\DailyInfo::query();

    if ($request->has('patient_id')) {
        $data = $data->where('patient_id', $request->patient_id);
    }

    $data = $data->get();

    return Response::json([
        'message' => 'Success!',
        'data' => $data
    ], 200);

});


/**get_appointment_requests
 * @param int center_id
 *
 * @return list of appointments for this center
 * each item has these info
 * int id
 * int patient_id
 * int status
 * int created_at
 * String patient_status
 * String resultInfo
 * Object patient
 */


Route::get('/get_appointment_requests', function (Request $request) {

    $data = \App\Models\Appointment::query();

    if ($request->has('center_id')) {
        $data = $data->where('center_id', $request->center_id);
    }

    $data = $data->get();

    return Response::json([
        'message' => 'Success!',
        'data' => $data
    ], 200);

});


/**change_appointment_status
 * int appointment_id
 * int status
 *
 */


Route::get('/change_appointment_status', function (Request $request) {

    $validator = Validator::make($request->all(), [
        'appointment_id' => 'required',
        'status' => 'required'
    ]);

    if ($validator->fails()) {
        return Response::json([
            'message' => 'Error Input Data',
            'data' => $validator->getMessageBag()
        ], 400);
    }


    $data = \App\Models\Appointment::where([
        'id' => $request->appointment_id
    ])->update([
        'status' => $request->status
    ]);

    return Response::json([
        'message' => 'Success!',
        'data' => $data
    ], 200);

});


/**update_appointment
 * int appointment_id
 *String resultInfo
 *String patientStatus
 *
 */
Route::get('/update_appointment', function (Request $request) {

    $validator = Validator::make($request->all(), [
        'appointment_id' => 'required',
        'resultInfo' => 'required',
        'patientStatus' => 'required'
    ]);

    if ($validator->fails()) {
        return Response::json([
            'message' => 'Error Input Data',
            'data' => $validator->getMessageBag()
        ], 400);
    }


    $data = \App\Models\Appointment::where([
        'id' => $request->appointment_id
    ])->update([
        'result_info' => $request->result_info,
        'patientStatus' => $request->patientStatus
    ]);

    return Response::json([
        'message' => 'Success!',
        'data' => $data
    ], 200);

});

/**get_Center_patients
 * @param center_id
 * @return list of patients who made an appointmt to this center
 */

Route::get('/get_Center_patients', function (Request $request) {

    $data = \App\Models\Patient::select('patient.*')->
    join('appointments', 'appointments.patient_id', '=', 'patient.id')->
    join('center', 'center.id', '=', 'appointments.center_id');

    if ($request->has('center_id')) {
        $data = $data->where('appointments.center_id', $request->center_id);
    }

    $data = $data->get();

    return Response::json([
        'message' => 'Success!',
        'data' => $data
    ], 200);

});

//Admin//
/**delete_center
 * @param center_id
 */

Route::post('/delete_center', function (Request $request) {

    $validator = Validator::make($request->all(), [
        'center_id' => 'required'
    ]);

    if ($validator->fails()) {
        return Response::json([
            'message' => 'Error Input Data',
            'data' => $validator->getMessageBag()
        ], 400);
    }

    $data = \App\Models\Center::where([
        'id' => $request->center_id
    ])->delete();

    return Response::json([
        'message' => 'Deleted!',
        'data' => $data
    ], 200);

});


/**link_doctor_to_center
 * note: add doctor_id to center record
 * int center_id
 * int doctor_id
 *
 */

Route::post('/link_doctor_to_center', function (Request $request) {

    $validator = Validator::make($request->all(), [
        'center_id' => 'required',
        'doctor_id' => 'required'
    ]);

    if ($validator->fails()) {
        return Response::json([
            'message' => 'Error Input Data',
            'data' => $validator->getMessageBag()
        ], 400);
    }

    $data = \App\Models\Center::where('id', $request->center_id)->first();
    if ($data) {
        $data->doctor_id = $request->doctor_id;
        $data->update();
    }

    return Response::json([
        'message' => 'Updated!',
        'data' => $data
    ], 200);

});

/**delete_doctor
 * int doctor_id
 *
 */


Route::post('/delete_doctor', function (Request $request) {

    $validator = Validator::make($request->all(), [
        'doctor_id' => 'required'
    ]);

    if ($validator->fails()) {
        return Response::json([
            'message' => 'Error Input Data',
            'data' => $validator->getMessageBag()
        ], 400);
    }

    $data = \App\Models\Doctor::where([
        'id' => $request->doctor_id
    ])->delete();

    return Response::json([
        'message' => 'Deleted!',
        'data' => $data
    ], 200);

});


/**delete_patient
 * int patient_id
 *
 */


Route::post('/delete_patient', function (Request $request) {

    $validator = Validator::make($request->all(), [
        'patient_id' => 'required'
    ]);

    if ($validator->fails()) {
        return Response::json([
            'message' => 'Error Input Data',
            'data' => $validator->getMessageBag()
        ], 400);
    }

    $data = \App\Models\Patient::where([
        'id' => $request->patient_id
    ])->delete();

    return Response::json([
        'message' => 'Deleted!',
        'data' => $data
    ], 200);

});


/**update_center
 * @param int center_id
 * @param String name
 * @param String info
 * @param String location
 * @param double lat
 * @param double lon
 *
 */

Route::post('/update_center', function (Request $request) {

    $validator = Validator::make($request->all(), [
        'center_id' => 'required',
        'name' => 'required',
        'location' => 'required',
        'lat' => 'required',
        'lon' => 'required',
    ]);

    if ($validator->fails()) {
        return Response::json([
            'message' => 'Error Input Data',
            'data' => $validator->getMessageBag()
        ], 400);
    }

    $data = \App\Models\Center::where('id', $request->center_id)->first();
    $data->name = $request->name;
    $data->lat = $request->lat;
    $data->lon = $request->lon;
    $data->location = $request->location;
    $data->update();


    return Response::json([
        'message' => 'Done!',
        'data' => $data
    ], 200);

});


/**start_chat
 * //this will start a chat by creating a new chat record only if it is not created yet
 * if chat is already created return chat info
 *
 * @param patient_id
 * @param doctor_id
 *
 * @return status of api request //or chat info
 *
 */
Route::post('/start_chat', function (Request $request) {

    $validator = Validator::make($request->all(), [
        'patient_id' => 'required',
        'doctor_id' => 'required',
    ]);

    if ($validator->fails()) {
        return Response::json([
            'message' => 'Error Input Data',
            'data' => $validator->getMessageBag()
        ], 400);
    }

    $data = \App\Models\ChatList::where([
        'patient_id' => $request->patient_id,
        'doctor_id' => $request->doctor_id,
    ])->first();

    if (is_null($data)) {
        $data = new \App\Models\ChatList();
        $data->patient_id = $request->patient_id;
        $data->doctor_id = $request->doctor_id;
        $data->save();
    }

    return Response::json([
        'message' => 'Done!',
        'data' => $data
    ], 200);

});


/**patient_get_chat_list
 * @param patient_id
 *
 * @return list of chats which has this patient as a member
 * each item has these info
 *
 * int id
 * object doctor
 */

Route::get('/patient_get_chat_list', function (Request $request) {


    $data = \App\Models\ChatList::query();

    if ($request->has('patient_id')) {
        $data = $data->where('patient_id', $request->patient_id);
    }

    $data = $data->get();

    return Response::json([
        'message' => 'Done!',
        'data' => $data
    ], 200);

});


/**doctor_get_chat_list
 * @param doctor_id
 *
 * @return list of chats which has this doctor as a member
 * each item has these info
 *
 * int id
 * object patient
 */

Route::get('/doctor_get_chat_list', function (Request $request) {


    $data = \App\Models\ChatList::query();

    if ($request->has('doctor_id')) {
        $data = $data->where('doctor_id', $request->doctor_id);
    }

    $data = $data->get();

    return Response::json([
        'message' => 'Done!',
        'data' => $data
    ], 200);

});

/**get_chat_content
 *
 * @param chat_id
 *
 * @return list of chat content "conversation"
 * each item has these info:
 *
 * int id
 * int sender_type //TODO add sender type to database  we need it in because id is coming from two different table
 * String content
 * date created_at
 *
 */

Route::get('/get_chat_content', function (Request $request) {


    $data = \App\Models\ChatContent::query();

    if ($request->has('chat_id')) {
        $data = $data->where('chat_id', $request->chat_id);
    }

    $data = $data->get();

    return Response::json([
        'message' => 'Done!',
        'data' => $data
    ], 200);

});


/**send_massage
 *int chat_id
 *int sender_type
 *String content
 *
 */

Route::post('/send_massage', function (Request $request) {

    $validator = Validator::make($request->all(), [
        'chat_id' => 'required',
        'sender_type' => 'required',
        'content' => 'required',
    ]);

    if ($validator->fails()) {
        return Response::json([
            'message' => 'Error Input Data',
            'data' => $validator->getMessageBag()
        ], 400);
    }

    $data = new \App\Models\ChatContent();
    $data->chat_id = $request->chat_id;
    $data->sender_type = $request->sender_type;
    $data->content = $request->input('content');
    $data->save();

    return Response::json([
        'message' => 'Done!',
        'data' => $data
    ], 200);

});



