<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Patient
 * 
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property int $age
 * @property string $address
 * @property string $details
 * @property int $gender
 * 
 * @property Appointment $appointment
 * @property Collection|ChatList[] $chat_lists
 * @property Collection|DailyInfo[] $daily_infos
 * @property Collection|Instruction[] $instructions
 *
 * @package App\Models
 */
class Patient extends Authenticatable
{
	protected $table = 'patient';
	public $timestamps = false;

	protected $casts = [
		'age' => 'int',
		'gender' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'first_name',
		'last_name',
		'email',
		'password',
		'phone',
		'age',
		'address',
		'details',
		'gender'
	];

	public function appointment()
	{
		return $this->belongsTo(Appointment::class, 'id', 'patient_id');
	}

	public function chat_lists()
	{
		return $this->hasMany(ChatList::class);
	}

	public function daily_infos()
	{
		return $this->hasMany(DailyInfo::class);
	}

	public function instructions()
	{
		return $this->hasMany(Instruction::class);
	}
}
