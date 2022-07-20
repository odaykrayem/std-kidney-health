<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Center
 * 
 * @property int $id
 * @property string $name
 * @property string $info
 * @property float $lat
 * @property float $lon
 * @property int $doctor_id
 * @property string $location
 * 
 * @property Collection|Appointment[] $appointments
 * @property Doctor $doctor
 *
 * @package App\Models
 */
class Center extends Model
{
	protected $table = 'center';
	public $timestamps = false;

	protected $casts = [
		'lat' => 'float',
		'lon' => 'float',
		'doctor_id' => 'int'
	];

	protected $fillable = [
		'name',
		'info',
		'lat',
		'lon',
		'doctor_id',
		'location'
	];

    protected $appends = ['doctor'];


    public function getDoctorAttribute()
    {
        return $this->belongsTo(Doctor::class)->first();
    }
}
