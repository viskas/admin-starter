<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Agent\Agent;

/**
 * Class Session
 * @package App\Models
 */
class Session extends Model
{
    protected $table = 'sessions';

    public $incrementing = false;

    public function getAgentObjectAttribute()
    {
        if (is_null($this->user_agent)) {
            return "{$this->user_agent}";
        }

        $agent = new Agent();
        $agent->setUserAgent($this->user_agent);

        return $agent;
    }
}
