<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'created_at', 'updated_at'];

   

    public function  modules(){
        return $this->belongsToMany('App\Models\Module', 'role_modules');
    }
    public function  roleModules(){
        return $this->belongsToMany('App\Models\Module', 'role_modules');
    }
    function  permissions(){
        return $this->belongsToMany('App\Models\Permission', 'role_permissions');
    }


}
