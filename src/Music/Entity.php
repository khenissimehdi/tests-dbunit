<?php

namespace Music;

/**
 * Class Entity.
 */
abstract class Entity
{

    protected $identifier;
    protected $name;

    /**
     * Entity constructor.
     */
    private function __construct()
    {
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->identifier;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    abstract public static function createFromId(int $identifier);
}
