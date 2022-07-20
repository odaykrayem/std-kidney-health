<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DailyInfo
 * 
 * @property int $id
 * @property int $patient_id
 * @property int $water_quntity
 * @property string $medicine_info
 * 
 * @property Patient $patient
 *
 * @package App\Models
 */
class DailyInfo extends Model
{
	protected $table = 'daily_info';
	public $timestamps = false;

	protected $casts = [
		'patient_id' => 'int',
		'water_quntity' => 'int'
	];

	protected $fillable = [
		'patient_id',
		'water_quntity',
		'medicine_info'
	];

    protected $appends = ['patient'];


    public function getPatientAttribute()
    {
        return $this->belongsTo(Patient::class)->first();
    }
}
