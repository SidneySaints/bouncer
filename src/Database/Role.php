<?php

namespace Silber\Bouncer\Database;

use Illuminate\Database\Eloquent\Model;

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
        'id' => 'int',
        'level' => 'int',
    ];

    /**
     * Constructor.
     *
     * @param array  $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setIncrementing(!config('bouncer.use_uuid'));
        $this->setKeyType(config('bouncer.use_uuid') ? 'string' : 'int');;
        $this->table = Models::table('roles');

        parent::__construct($attributes);
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
