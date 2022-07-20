<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Appointment
 *
 * @property int $id
 * @property int $patient_id
 * @property int $center_id
 * @property Carbon $create_at
 * @property int $status
 *
 * @property Center $center
 * @property Patient $patient
 *
 * @package App\Models
 */
class Appointment extends Model
{
    protected $table = 'appointments';
    public $timestamps = false;

    protected $casts = [
        'patient_id' => 'int',
        'center_id' => 'int',
        'status' => 'int'
    ];

    protected $dates = [
        'create_at'
    ];

    protected $appends = ['patient', 'center'];


    public function getCenterAttribute()
    {
        return $this->belongsTo(Center::class, 'center_id')->first();
    }

    public function getPatientAttribute()
    {
        return $this->belongsTo(Patient::class, 'patient_id')->first();
    }
}