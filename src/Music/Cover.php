<?php

namespace Music;

/**
 * Class Cover.
 */
class Cover
{

    private $identifier;
    private $jpeg;

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
    public function getJPEG(): string
    {
        return $this->jpeg;
    }

    /**
     * @param int $identifier
     * @return static
     */
    public static function createFromId(int $identifier): self
    {
        $reqCover = MyPDO::getInstance()->prepare('SELECT * FROM cover WHERE id=?;');
        $reqCover->execute([$identifier]);
        $reqCover->setFetchMode(PDO::FETCH_CLASS, 'Cover');
        if (false !== ($object = $reqCover->fetch())) {
            return $object;
        }
    }
}
