<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    
	// Atributos que se pueden asignar de manera masiva.
	protected $fillable = array('name','date','text','user_id');
	
	// Aquí ponemos los campos que no queremos que se devuelvan en las consultas.
	protected $hidden = ['user_id','created_at','updated_at']; 
}
