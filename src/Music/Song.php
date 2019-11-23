<?php

namespace Music;

/**
 * Class Song.
 */
class Song extends Entity
{
    /**
     * @param int $identifier
     * @return static
     */
    public static function createFromId(int $identifier): self
    {
        $reqSong = MyPDO::getInstance()->prepare('SELECT * FROM song WHERE id=?;');
        $reqSong->execute([$identifier]);
        $reqSong->setFetchMode(PDO::FETCH_CLASS, 'Song');
        if (false !== ($object = $reqSong->fetch())) {
            return $object;
        }
    }
}
