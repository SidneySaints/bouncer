<?php

namespace Silber\Bouncer\Database;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Role extends Model
{
    use Concerns\IsRole;
    use Concerns\CanUseUUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'title', 'level'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'level' => 'int',
    ];

    /**
     * Constructor.
     *
     * @param  array  $attributes
     */
    public function __construct(array $attributes = [])
    {
        $uuidIsUsed = Config::get('bouncer.use_uuid');

        $this->setIncrementing(!$uuidIsUsed);

        $this->addToCast('id', $uuidIsUsed ? 'string' : 'int');

        $this->setKeyType($uuidIsUsed ? 'string' : 'int');;

        $this->table = Models::table('roles');

        parent::__construct($attributes);
    }

}
