<?php

namespace Music;

use DB\MyPDO;
use Exception;
use PDO;

/**
 * Class Artist.
 */
class Artist extends Entity
{


    public static function createFromId(int $artistId): self
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
            SELECT id, name
            FROM artist
            WHERE id = ?
SQL
        );
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        $stmt->execute([$artistId]);
        if (false !== ($object = $stmt->fetch())) {
            return $object;
        }
        throw new Exception('Artist not found');
    }


    public static function getAll(): array
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
            SELECT *
            FROM artist
            ORDER BY name
SQL
        );
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        $stmt->execute();

        return $stmt->fetchAll();
    }


    public function getAlbums(): array
    {
        return Album::getFromArtistId($this->getId());
    }


    public static function getFromGenreId(int $genreId): array
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
            SELECT DISTINCT *
            FROM artist
            WHERE id IN (
                SELECT artistId
                FROM album
                WHERE genreId = ?
            )
            ORDER BY name
SQL
        );
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        $stmt->execute([$genreId]);

        return $stmt->fetchAll();
    }


}