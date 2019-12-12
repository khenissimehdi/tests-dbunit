<?php

namespace Music;

use DB\MyPDO;
use Exception;
use PDO;

/**
 * Class Album.
 */
class Album extends Entity
{


    protected $year = NULL;
    protected $genreId = NULL;
    protected $artistId = NULL;
    protected $coverId = NULL;


    public static function createFromId(int $albumId): self
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
            SELECT id, name, year, genreId, artistId, coverId
            FROM album
            WHERE id = ?
SQL
        );
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        $stmt->execute([$albumId]);
        if (false !== ($obj = $stmt->fetch())) {
            return $obj;
        }
        throw new Exception('Album introuvable');
    }


    public function getYear(): int
    {
        return (int) $this->year;
    }


    public function getArtistId(): int
    {
        return (int) $this->artistId;
    }


    public function getArtist(): Artist
    {
        return Artist::createFromId($this->getArtistId());
    }


    public function getCoverId(): int
    {
        return (int) $this->coverId;
    }


    public static function getFromArtistId(int $artistId): array
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
            SELECT *
            FROM album
            WHERE artistId = ?
            ORDER BY year, name
SQL
        );
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        $stmt->execute([$artistId]);

        return $stmt->fetchAll();
    }


    public function getTracks(): array
    {
        return Track::getFromAlbumId($this->getId());
    }


    public function getCover(): Cover
    {
        return Cover::createFromId($this->getCoverId());
    }


    public function getGenreId(): int
    {
        return (int) $this->genreId;
    }


}

