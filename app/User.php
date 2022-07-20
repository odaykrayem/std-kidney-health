<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 *
 * @package App\Models
 */
class User extends Authenticatable
{

	protected $table = 'users';
	public $timestamps = false;


}
