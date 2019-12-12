<?php

namespace Tests\Music;

use Music\Artist;
use Music\Album;
use Exception;


class ArtistTest extends DatabaseTest
{


    public function testCreateFromId()
    {
        $artist = Artist::createFromId(17);
        $this->assertSame('Metallica', $artist->getName());
        $this->assertSame(17, $artist->getId());
        $this->assertInstanceOf(Artist::class, $artist);
    }

    public function testCreateFromIdThrowsExceptionIfIdIsNotFound()
    {
        $this->expectException(Exception::class);
        Artist::createFromId(99999999999);
    }

    public function testGetAll()
    {
        $expectedArtistsArray = [
            ['id' => 40, 'name' => 'Joe Cocker'],
            ['id' => 89, 'name' => 'Justin Bieber'],
            ['id' => 35, 'name' => 'Machine Head'],
            ['id' => 17, 'name' => 'Metallica'],
        ];
        $all = Artist::getAll();
        $this->assertCount(4, $all);
        $this->assertContainsOnlyInstancesOf(Artist::class, $all);
        foreach ($all as $i => $artist) {
            $this->assertSame($expectedArtistsArray[$i]['id'], $artist->getId(), 'Mauvais identifiant');
            $this->assertSame($expectedArtistsArray[$i]['name'], $artist->getName(), 'Mauvais nom');
        }
    }

    public function testGetAlbums()
    {
        $mockArtist = $this->createPartialMock(Artist::class, ['getId']);
        $mockArtist->expects($this->once())->method('getId')->willReturn(17);
        $this->assertEquals(Album::getFromArtistId(17), $mockArtist->getAlbums());
    }


}

