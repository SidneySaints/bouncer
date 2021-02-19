<?php


namespace Silber\Bouncer\Database\Concerns;

use Ramsey\Uuid\Uuid;

trait CanUseUUID
{
    /**
     * Indicates if the IDs are UUIDs.
     *
     * @return bool
     */
    protected function keyIsUuid(): bool
    {
        return config('bouncer.use_uuid');
    }

    /**
     * The UUID version to use.
     *
     * @return int
     */
    protected function uuidVersion(): int
    {
        return config('bouncer.uuid_version', 4);
    }

    /**
     * The "booting" method of the model.
     */
    public static function bootCanUseUUID(): void
    {
        static::creating(function (self $model): void {
            // Automatically generate a UUID if using them, and not provided.
            if ($model->keyIsUuid() && empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = $model->generateUuid();
            }
        });
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function generateUuid(): string
    {
        switch ($this->uuidVersion()) {
            case 1:
                return Uuid::uuid1()->toString();
            case 4:
                return Uuid::uuid4()->toString();
        }

        throw new Exception("UUID version [{$this->uuidVersion()}] not supported.");
    }

    protected function addToCast(string $name, string $cast)
    {
        $this->casts = array_merge($this->casts, [$name => $cast]);
    }
}
