<?php

namespace Music;

/**
 * Class Track.
 */
class Track
{
    private $albumId;
    private $songId;
    private $number;
    private $diskNumber;
    private $duration;

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @return mixed
     */
    public function getAlbumId()
    {
        return $this->albumId;
    }

    /**
     * @return string
     */
    public function getFormattedDuration()
    {
        $seconds = $this->duration % 60;
        $minutes = (int) ($this->duration / 60);
        $seconds < 10 ? $calcSeconds = '0'.$seconds : $calcSeconds = $seconds;
        $minutes < 10 ? $calcMinutes = '0'.$minutes : $calcMinutes = $minutes;

        return $calcMinutes.':'.$calcSeconds;
    }

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
    }

    public function getFormattedNumber(): string
    {
        return $this->number + 100 * $this->diskNumber;
    }

    /**
     * @return Song
     */
    public function getSong(): Song
    {
        $reqSong = MyPDO::getInstance()->prepare('SELECT * FROM song WHERE id=?;');
        $reqSong->execute([$this->songId]);
        $reqSong->setFetchMode(PDO::FETCH_CLASS, 'Song');
        if (false !== ($object = $reqSong->fetch())) {
            return $object;
        }
    }

    /**
     * @return Album
     */
    public function getAlbum(): Album
    {
        $reqAlbum = MyPDO::getInstance()->prepare('SELECT * FROM album WHERE id=?;');
        $reqAlbum->execute([$this->albumId]);
        $reqAlbum->setFetchMode(PDO::FETCH_CLASS, 'Album');
        if (false !== ($object = $reqAlbum->fetch())) {
            return $object;
        }
    }

    /**
     * @param int $albumId
     * @return array
     */
    public static function getFromAlbumId(int $albumId): array
    {
        $reqTrack = MyPDO::getInstance()->prepare('SELECT * FROM track WHERE albumId=? ORDER BY diskNumber,number;');
        $reqTrack->execute([$albumId]);
        $reqTrack->setFetchMode(PDO::FETCH_CLASS, 'Track');
        $list = [];
        while (false !== ($object = $reqTrack->fetch())) {
            $list[] = $object;
        }

        return $list;
    }
}
