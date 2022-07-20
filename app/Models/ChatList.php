<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ChatList
 *
 * @property int $id
 * @property int $patient_id
 * @property int $doctor_id
 *
 * @property Patient $patient
 * @property Collection|ChatContent[] $chat_contents
 *
 * @package App\Models
 */
class ChatList extends Model
{
    protected $table = 'chat_list';
    public $timestamps = false;

    protected $casts = [
        'patient_id' => 'int',
        'doctor_id' => 'int'
    ];

    protected $fillable = [
        'patient_id',
        'doctor_id'
    ];

    protected $appends = ['patient', 'doctor'];


    public function getPatientAttribute()
    {
        return $this->belongsTo(Patient::class,'patient_id')->first();
    }

    public function getDoctorAttribute()
    {
        return $this->belongsTo(Doctor::class,'doctor_id')->first();
    }
}
