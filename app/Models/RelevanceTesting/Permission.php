<?php

namespace App\Models\RelevanceTesting;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'relevance_testing_permissions';
    protected $fillable = ['suite_id', 'email'];
    protected $visible = ['email'];
}
