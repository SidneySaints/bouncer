<?php

namespace Silber\Bouncer\Database;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

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
        'only_owned' => 'boolean',
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

        $this->addToCast('entity_id', $uuidIsUsed ? 'string' : 'int');

        $this->setKeyType(config('bouncer.use_uuid') ? 'string' : 'int');

        $this->table = Models::table('abilities');

        parent::__construct($attributes);
    }

}
