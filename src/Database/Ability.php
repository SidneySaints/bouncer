<?php

namespace Silber\Bouncer\Database;

use Illuminate\Database\Eloquent\Model;

class Ability extends Model
{
    use Concerns\IsAbility;
    use Concerns\CanUseUUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'title'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'int',
        'entity_id' => 'int',
        'only_owned' => 'boolean',
    ];

    /**
     * Constructor.
     *
     * @param  array  $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setIncrementing(!config('bouncer.use_uuid'));
        $this->setKeyType(config('bouncer.use_uuid') ? 'string' : 'int');
        $this->table = Models::table('abilities');

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
