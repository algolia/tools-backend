<?php

namespace App\Models\RelevanceTesting;
use Illuminate\Database\Eloquent\Model;

class Suite extends Model
{
    protected $table = 'relevance_testing_suites';
    protected $fillable = [];

    public function isReadableBy($userId, $email)
    {
        if ($userId === $this->user_id) return true;

        foreach ($this->permissions as $permission) {
            if ($permission->email === $email) {
                return true;
            }
        }

        return false;
    }

    public function isWritableBy($userId, $email)
    {
        return $this->isReadableBy($userId, $email);
    }

    public function permissions()
    {
        return $this->hasMany('\App\Models\RelevanceTesting\Permission');
    }

    public function groups()
    {
        return $this->hasMany('\App\Models\RelevanceTesting\Group');
    }

    public function runs()
    {
        return $this->hasMany('\App\Models\RelevanceTesting\Run');
    }

    public function delete()
    {
        foreach ($this->groups as $group) {
            $group->delete();
        }

        $this->permissions()->delete();
        $this->runs()->delete();

        parent::delete();
    }
}
