<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Doctor
 * 
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property string $details
 * 
 * @property Center $center
 * @property Collection|Instruction[] $instructions
 *
 * @package App\Models
 */
class Doctor extends Authenticatable
{
	protected $table = 'doctor';
	public $timestamps = false;

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'first_name',
		'last_name',
		'email',
		'password',
		'phone',
		'address',
		'details'
	];

	public function center()
	{
		return $this->belongsTo(Center::class, 'id', 'doctor_id');
	}

	public function instructions()
	{
		return $this->hasMany(Instruction::class);
	}
}
