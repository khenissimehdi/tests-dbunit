<?php

namespace Tests\Music;

use Music\Track;
use Music\Song;
use PHPUnit\DbUnit\DataSet\CsvDataSet;


class TestTrack extends DatabaseTest
{


    public function testGetFromAlbumId()
    {
        $data = new CsvDataSet();
        $data->addTable('tracksOfAlbum43', implode(DIRECTORY_SEPARATOR, [__DIR__, 'database', 'tracksOfAlbum43.csv']));
        $res = $data->getTable('tracksOfAlbum43');
        $tracks = Track::getFromAlbumId(43);
        $this->assertContainsOnlyInstancesOf(Track::class, $tracks, 'Mauvais type de retour');
        $this->assertCount($res->getRowCount(), $tracks, 'Mauvais nombre');
        foreach ($tracks as $index => $track) {
            $albums = $res->getRow($index);
            $this->assertEquals($albums['disknumber'], $track->getDiskNumber());
            $this->assertEquals($albums['number'], $track->getNumber());
            $this->assertEquals($albums['duration'], $track->getDuration());
            $this->assertEquals($albums['albumId'], $track->getAlbumId());
            $this->assertEquals($albums['songId'], $track->getSongId());
        }
    }

    public function testGetDurationAndGetFormattedDuration()
    {
        $duration = [
            ['duration' => 302, 'formatted' => '05:02'],
            ['duration' => 256, 'formatted' => '04:16'],
            ['duration' => 301, 'formatted' => '05:01'],
            ['duration' => 300, 'formatted' => '05:00'],
            ['duration' => 331, 'formatted' => '05:31'],
            ['duration' => 305, 'formatted' => '05:05'],
            ['duration' => 383, 'formatted' => '06:23'],
            ['duration' => 437, 'formatted' => '07:17'],
            ['duration' => 310, 'formatted' => '05:10'],
            ['duration' => 214, 'formatted' => '03:34'],
            ['duration' => 334, 'formatted' => '05:34'],
            ['duration' => 370, 'formatted' => '06:10'],
            ['duration' => 361, 'formatted' => '06:01'],
            ['duration' => 453, 'formatted' => '07:33'],
        ];
        $tracks = Track::getFromAlbumId(58);
        $this->assertCount(count($duration), $tracks);
        $this->assertContainsOnlyInstancesOf(Track::class, $tracks);
        foreach ($tracks as $index => $track) {
            $this->assertSame($duration[$index]['duration'], $track->getDuration());
            $this->assertSame($duration[$index]['formatted'], $track->getFormattedDuration());
        }
    }

    public function testGetNumber()
    {
        $expectedNumber = [
            ['number' => 1, 'formatted' => '01'],
            ['number' => 2, 'formatted' => '02'],
            ['number' => 3, 'formatted' => '03'],
            ['number' => 4, 'formatted' => '04'],
            ['number' => 5, 'formatted' => '05'],
            ['number' => 6, 'formatted' => '06'],
            ['number' => 7, 'formatted' => '07'],
            ['number' => 8, 'formatted' => '08'],
            ['number' => 9, 'formatted' => '09'],
            ['number' => 10, 'formatted' => '10'],
            ['number' => 11, 'formatted' => '11'],
            ['number' => 12, 'formatted' => '12'],
            ['number' => 13, 'formatted' => '13'],
            ['number' => 14, 'formatted' => '14'],
        ];
        $tracks = Track::getFromAlbumId(58);
        $this->assertCount(count($expectedNumber), $tracks);
        foreach ($tracks as $index => $track) {
            $this->assertSame($expectedNumber[$index]['formatted'], $track->getFormattedNumber());
            $this->assertSame($expectedNumber[$index]['number'], $track->getNumber(), 'Nombre de pistes non correspondantes');
        }
    }

    public function testGetNumberWithDisks()
    {
        $number = ['101', '102', '103', '104', '105', '106', '107', '108', '109', '201', '202', '203', '204', '205', '206'];
        $tracks = Track::getFromAlbumId(407);
        foreach ($tracks as $index => $track) {
            $this->assertSame($number[$index], $track->getFormattedNumber());
        }
    }

    public function testGetSong()
    {
        $expectedSong = [
            ['id' => 42, 'name' => 'Blackened'],
            ['id' => 381, 'name' => '...And Justice for All'],
            ['id' => 837, 'name' => 'Eye of the Beholder'],
            ['id' => 972, 'name' => 'One'],
            ['id' => 1779, 'name' => 'The Shortest Straw'],
            ['id' => 1591, 'name' => 'Harvester Of Sorrow'],
            ['id' => 2448, 'name' => 'The Frayed Ends of Sanity'],
            ['id' => 2797, 'name' => 'To Live Is to Die'],
            ['id' => 2917, 'name' => 'Dyers Eve'],
        ];
        $tracks = Track::getFromAlbumId(43);
        foreach ($tracks as $index => $track) {
            $song = $track->getSong();
            $this->assertInstanceOf(Song::class, $song);
            $this->assertSame($expectedSong[$index]['id'], $track->getSongId());
            $this->assertSame($expectedSong[$index]['id'], $song->getId());
            $this->assertSame($expectedSong[$index]['name'], $song->getName());
        }
    }


}

