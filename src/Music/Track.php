<?php

namespace Music;

use DB\MyPDO;
use PDO;
use Exception;

/**
 * Class Track.
 */
class Track
{


    protected $albumId = null;
    protected $songId = null;
    protected $number = null;
    protected $disknumber = null;
    protected $duration = null;


    public function getDuration(): int
    {
        return (int) $this->duration;
    }

    public function getFormattedDuration(): string
    {
        $min = floor($this->getDuration() / 60);
        $sec = $this->getDuration() % 60;
        if ($min < 10) {
            $min = "0$min";
        }
        if ($sec < 10) {
            $sec = "0$sec";
        }

        return "$min:$sec";
    }


    public function getNumber(): int
    {
        return (int) $this->number;
    }


    public function getDiskNumber(): int
    {
        return (int) $this->disknumber;
    }

    public function getFormattedNumber(): string
    {
        $number = $this->getNumber() + 100 * $this->disknumber;

        return $number < 10 ? "0{$number}" : $number;
    }

    public function getAlbumId(): int
    {
        return (int) $this->albumId;
    }

    public function getSongId(): int
    {
        return (int) $this->songId;
    }

    public function getAlbum(): Album
    {
        return Album::createFromId($this->getAlbumId());
    }

    public function getSong(): Song
    {
        return Song::createFromId($this->getSongId());
    }

    public static function getFromAlbumId(int $albumId): array
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
            SELECT *
            FROM track
            WHERE albumId = ?
            ORDER BY disknumber, number
SQL
        );
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        $stmt->execute([$albumId]);

        return $stmt->fetchAll();
    }


}