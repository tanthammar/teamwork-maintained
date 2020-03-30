<?php 

namespace Mpociot\Teamwork;

use Mpociot\Teamwork\Traits\HasUuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Mpociot\Teamwork\Traits\TeamworkTeamInviteTrait;


class TeamInvite extends Model
{
    use TeamworkTeamInviteTrait, HasUuidTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    const UUID_PREFIX = 'tmi-';

    /**
     * Creates a new instance of the model.
     *
     * @param array $attributes
     */
    public function __construct( array $attributes = [ ] )
    {
        parent::__construct( $attributes );
        $this->table = Config::get( 'teamwork.team_invites_table' );
    }
}
