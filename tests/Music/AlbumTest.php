<?php

namespace Tests\Music;

use Exception;
use Music\Album;
use Music\Cover;
use Music\Track;
use PHPUnit\DbUnit\DataSet\YamlDataSet;


class AlbumTest extends DatabaseTest
{


    public function testCreateFromId()
    {
        $album = Album::createFromId(43);
        $this->assertInstanceOf(Album::class, $album);
        $this->assertSame($album->getGenreId(), 4, 'Mauvais identifiant genre');
        $this->assertSame($album->getCoverId(), 43, 'Mauvais identifiant album');
        $this->assertSame($album->getYear(), 1988, 'Mauvaise année');
        $this->assertSame($album->getName(), '...And Justice For All', 'Mauvais nom');
        $this->assertSame($album->getId(), 43, 'Mauvais identifiant');
    }

    public function testCreateFromIdThrowsExceptionIfIdIsNotFound()
    {
        $this->expectException(Exception::class);
        Album::createFromId(1000);
    }

    public function testGetFromArtistId()
    {
        $dataset = new YamlDataSet(implode(DIRECTORY_SEPARATOR, [__DIR__, 'database', 'artist.yaml']));
        $expectedAlbums = $dataset->getTable('artist17albums');
        $albums = Album::getFromArtistId(17);
        $this->assertCount($expectedAlbums->getRowCount(), $albums, 'Mauvais nombre album');
        $this->assertContainsOnlyInstancesOf(Album::class, $albums, 'Mauvais retour type');
        foreach ($albums as $index => $album) {
            $expectedAlbum = $expectedAlbums->getRow($index);
            $this->assertSame($expectedAlbum['coverId'], $album->getCoverId());
            $this->assertSame($expectedAlbum['artistId'], $album->getArtistId());
            $this->assertSame($expectedAlbum['genreId'], $album->getGenreId());
            $this->assertSame($expectedAlbum['year'], $album->getYear());
            $this->assertSame($expectedAlbum['name'], $album->getName());
            $this->assertSame($expectedAlbum['id'], $album->getId());
        }
    }

    public function testGetTracks()
    {
        $mockAlbum = $this->createPartialMock(Album::class, ['getId']);
        $mockAlbum->expects($this->once())->method('getId')->willReturn(43);
        $this->assertEquals(Track::getFromAlbumId(43), $mockAlbum->getTracks());
    }

    public function testGetCover()
    {
        $mockAlbum = $this->createPartialMock(Album::class, ['getCoverId']);
        $mockAlbum->expects($this->once())->method('getCoverId')->willReturn(43);
        $cover = $mockAlbum->getCover();
        $this->assertSame($cover->getId(), 43);
        $this->assertInstanceOf(Cover::class, $cover);
    }


}