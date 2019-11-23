<?php

namespace Music;

/**
 * Class Album.
 */
class Album extends Entity
{

    protected $year;
    protected $genreId;
    protected $artistId;
    protected $coverId;

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @return mixed
     */
    public function getGenreId()
    {
        return $this->genreId;
    }

    /**
     * @return mixed
     */
    public function getCoverId()
    {
        return $this->coverId;
    }

    /**
     * @return static
     */
    public static function createFromId(int $identifier): self
    {
        $reqAlbum = MyPDO::getInstance()->prepare('SELECT * FROM album WHERE id=?;');
        $reqAlbum->execute([$identifier]);
        $reqAlbum->setFetchMode(PDO::FETCH_CLASS, 'Album');
        if (false !== ($object = $reqAlbum->fetch())) {
            return $object;
        }
    }

    /**
     * @param int $artistId
     * @return array
     */
    public static function getFromArtistId(int $artistId): array
    {
        $reqAlbums = MyPDO::getInstance()->prepare('SELECT * FROM album WHERE artistId=? ORDER BY year;');
        $reqAlbums->execute([$artistId]);
        $reqAlbums->setFetchMode(PDO::FETCH_CLASS, 'Album');
        $table = [];
        while (false !== ($row = $reqAlbums->fetch())) {
            $table[] = $row;
        }

        return $table;
    }

    /**
     * @return array
     */
    public function getTracks(): array
    {
        $reqTrack = MyPDO::getInstance()->prepare('SELECT * FROM track WHERE albumId=? ORDER BY disknumber,number;');
        $reqTrack->execute([$this->id]);
        $reqTrack->setFetchMode(PDO::FETCH_CLASS, 'Track');
        $list = [];
        while (false !== ($object = $reqTrack->fetch())) {
            $list[] = $object;
        }

        return $list;
    }

    /**
     * @return Artist
     */
    public function getArtist(): Artist
    {
        $reqAlbum = MyPDO::getInstance()->prepare('SELECT * FROM artist WHERE id=?;');
        $reqAlbum->execute([$this->artistId]);
        $reqAlbum->setFetchMode(PDO::FETCH_CLASS, 'Artist');
        if (false !== ($object = $reqAlbum->fetch())) {
            return $object;
        }
    }

    /**
     * @return Cover
     */
    public function getCover(): Cover
    {
        $reqCover = MyPDO::getInstance()->prepare('SELECT * FROM cover WHERE id=?;');
        $reqCover > execute([$this->coverId]);
        $reqCover->setFetchMode(PDO::FETCH_CLASS, 'Cover');
        if (false !== ($object = $reqCover->fetch())) {
            return $object;
        }
    }
}
