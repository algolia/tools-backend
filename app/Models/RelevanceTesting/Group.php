<?php

namespace App\Models\RelevanceTesting;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'relevance_testing_groups';
    protected $fillable = [];

    public function isWritableBy($userId, $userEmail)
    {
        return $this->suite->isWritableBy($userId, $userEmail);
    }

    public function suite()
    {
        return $this->belongsTo('\App\Models\RelevanceTesting\Suite');
    }

    public function tests()
    {
        return $this->hasMany('\App\Models\RelevanceTesting\Test');
    }

    public function delete()
    {
        $this->tests()->delete();
        return parent::delete();
    }
}
