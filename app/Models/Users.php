<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model{

	protected $table="user";

	protected $primaryKey='user_id';

	protected $fillable=[
		'username',
		'password',
		'id_user_group',
		'updated_at',
		'created_at'
	];
}