<?php

namespace Music;

/**
 * Class Artist.
 */
class Artist extends Entity
{
    /**
     * @return static
     */
    public static function createFromId(int $identifier): self
    {
        $reqArtist = MyPDO::getInstance()->prepare('SELECT * FROM artist WHERE id=?;');
        $reqArtist->execute([$identifier]);
        $reqArtist->setFetchMode(PDO::FETCH_CLASS, 'Artist');
        if (false !== ($object = $reqArtist->fetch())) {
            return $object;
        }
    }

    /**
     * @return array
     */
    public static function getAll(): array
    {
        $reqArtists = MyPDO::getInstance()->prepare('SELECT * FROM artist ORDER BY name;');
        $reqArtists->execute();
        $reqArtists->setFetchMode(PDO::FETCH_CLASS, 'Artist');
        $list = [];
        while (false !== ($object = $reqArtists->fetch())) {
            $list[] = $object;
        }

        return $list;
    }

    /**
     * @return array
     */
    public function getAlbums(): array
    {
        $reqAlbums = MyPDO::getInstance()->prepare('SELECT * FROM album WHERE artistId=? ORDER BY year;');
        $reqAlbums->execute([$this->id]);
        $reqAlbums->setFetchMode(PDO::FETCH_CLASS, 'Album');
        $table = [];
        while (false !== ($row = $reqAlbums->fetch())) {
            $table[] = $row;
        }

        return $table;
    }

    /**
     * @param int $genreId
     * @return array
     */
    public function getFromGenreId(int $genreId): array
    {
        $reqArtists = MyPDO::getInstance()->prepare('SELECT * FROM artist a,album al where a.id=al.artistId and al.genreId=? ORDER BY name;');
        $reqArtists->execute([$genreId]);
        $reqArtists->setFetchMode(PDO::FETCH_CLASS, 'Artist');
        $list = [];
        while (false !== ($object = $reqArtists->fetch())) {
            $list[] = $object;
        }

        return $list;
    }
}
