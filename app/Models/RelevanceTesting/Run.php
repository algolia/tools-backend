<?php

namespace App\Models\RelevanceTesting;
use Illuminate\Database\Eloquent\Model;

class Run extends Model
{
    protected $table = 'relevance_testing_runs';
    protected $fillable = [];

    public function isWritableBy($userId, $userEmail)
    {
        return $this->suite->isWritableBy($userId, $userEmail);
    }

    public function suite()
    {
        return $this->belongsTo('\App\Models\RelevanceTesting\Suite');
    }
}
