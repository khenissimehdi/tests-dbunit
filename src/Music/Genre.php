<?php

namespace Music;

/**
 * Class Genre.
 */
class Genre extends Entity
{
    /**
     * @return static
     */
    public static function createFromId(int $identifier): self
    {
        $reqGenre = MyPDO::getInstance()->prepare('SELECT * FROM genre WHERE id=?;');
        $reqGenre->execute([$identifier]);
        $reqGenre->setFetchMode(PDO::FETCH_CLASS, 'Genre');
        if (false !== ($object = $reqGenre->fetch())) {
            return $object;
        }
    }

    /**
     * @return array
     */
    public static function getAll(): array
    {
        $reqGenres = MyPDO::getInstance()->prepare('SELECT * FROM genre ORDER BY name;');
        $reqGenres->execute();
        $reqGenres->setFetchMode(PDO::FETCH_CLASS, 'Genre');
        $list = [];
        while (false !== ($object = $reqGenres->fetch())) {
            $list[] = $object;
        }

        return $list;
    }

    /**
     * @return array
     */
    public function getArtists()
    {
        $reqArtists = MyPDO::getInstance()->prepare('SELECT * FROM artist where genreId=? ORDER BY name;');
        $reqArtists->execute([$this->getId()]);
        $reqArtists->setFetchMode(PDO::FETCH_CLASS, 'Artist');
        $list = [];
        while (false !== ($object = $reqArtists->fetch())) {
            $list[] = $object;
        }

        return $list;
    }
}
