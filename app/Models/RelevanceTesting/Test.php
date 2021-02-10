<?php

namespace App\Models\RelevanceTesting;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table = 'relevance_testing_tests';
    protected $fillable = [];

    public function isWritableBy($userId, $emailId)
    {
        return $this->group->isWritableBy($userId, $emailId);
    }

    public function group()
    {
        return $this->belongsTo('\App\Models\RelevanceTesting\Group');
    }
}
