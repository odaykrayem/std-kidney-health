<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Instruction
 *
 * @property int $id
 * @property int $doctor_id
 * @property int $patient_id
 * @property string $content
 *
 * @property Patient $patient
 * @property Doctor $doctor
 *
 * @package App\Models
 */
class Instruction extends Model
{
    protected $table = 'instructions';
    public $timestamps = false;

    protected $casts = [
        'doctor_id' => 'int',
        'patient_id' => 'int'
    ];

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'content'
    ];

    protected $appends = ['patient', 'doctor'];


    public function getPatientAttribute()
    {
        return $this->belongsTo(Patient::class)->first();
    }

    public function getDoctorAttribute()
    {
        return $this->belongsTo(Doctor::class)->first();
    }
}
