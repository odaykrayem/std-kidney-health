<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ChatContent
 * 
 * @property int $id
 * @property int $chat_id
 * @property string $content
 * @property int $sender_id
 * @property int $sender_type
 *
 * @property ChatList $chat_list
 *
 * @package App\Models
 */
class ChatContent extends Model
{
	protected $table = 'chat_content';
	public $timestamps = false;

	protected $casts = [
		'chat_id' => 'int',
		'sender_id' => 'int'
	];

	protected $fillable = [
		'chat_id',
		'content',
		'sender_id'
	];

	public function chat_list()
	{
		return $this->belongsTo(ChatList::class, 'chat_id');
	}
}
