<?php

namespace Tests\SeanJA\StatsCanAPI;

use SeanJA\StatsCanAPI\Client;
use SeanJA\StatsCanAPI\Exceptions\NotImplementedException;
use SeanJA\StatsCanAPI\Exceptions\RequestException;
use SeanJA\StatsCanAPI\Responses\GetAllCubesList\AllCubesList;
use SeanJA\StatsCanAPI\Responses\GetAllCubesListLite\AllCubesListLite;
use SeanJA\StatsCanAPI\Responses\GetBulkVectorDataByRange\BulkVectorDataByRange;
use SeanJA\StatsCanAPI\Responses\GetChangedCubeList\ChangedCubeList;
use SeanJA\StatsCanAPI\Responses\GetChangedSeriesDataFromCubePidCoordinate\SeriesDataFromCubePidCoordinate;
use SeanJA\StatsCanAPI\Responses\GetChangedSeriesDataFromVector\SeriesDataFromVector;
use SeanJA\StatsCanAPI\Responses\GetCodeSets\CodeSets;
use SeanJA\StatsCanAPI\Responses\GetCubeMetadata\CubeMetadata;
use SeanJA\StatsCanAPI\Responses\GetDataFromCubePidCoordinateAndLatestNPeriods\DataFromCubePidCoordinateAndLatestNPeriods;
use SeanJA\StatsCanAPI\Responses\GetDataFromVectorByReferencePeriodRange\DataFromVectorByReferencePeriodRange;
use SeanJA\StatsCanAPI\Responses\GetDataFromVectorsAndLatestNPeriods\DataFromVectorsAndLatestNPeriods;
use SeanJA\StatsCanAPI\Responses\GetFullTableDownloadCSV\FullTableDownloadCSV;
use SeanJA\StatsCanAPI\Responses\GetFullTableDownloadSDMX\FullTableDownloadSDMX;
use SeanJA\StatsCanAPI\Responses\GetSeriesInfoFromCubePidCoordinate\SeriesInfoFromCubePidCoordinate;
use SeanJA\StatsCanAPI\Responses\GetSeriesInfoFromVector\SeriesInfoFromVector;
use SeanJA\StatsCanAPI\ValueObjects\Coordinate;

class ClientTest extends TestCase
{
    public function testConstruct()
    {
        $client = new Client(
            new \GuzzleHttp\Client()
        );

        $this->assertInstanceOf(Client::class, $client);
    }

    public function testRequestFails()
    {
        $guzzle = $this->mockGuzzleClient('', 404);
        $client = new Client($guzzle);
        $this->expectException(RequestException::class);
        $client->getAllCubesList();
    }

    public function testGetDataFromVectorsAndLatestNPeriods()
    {
        $guzzle = $this->mockGuzzleClient(
            file_get_contents(__DIR__ . '/samples/getDataFromVectorsAndLatestNPeriods.json')
        );
        $client = new Client($guzzle);
        $result = $client->getDataFromVectorsAndLatestNPeriods(
            32164132,
            3
        );
        $this->assertInstanceOf(DataFromVectorsAndLatestNPeriods::class, $result);
    }

    public function testGetFullTableDownloadCSV()
    {
        $guzzle = $this->mockGuzzleClient(
            file_get_contents(__DIR__ . '/samples/getFullTableDownloadCSV.json')
        );
        $client = new Client($guzzle);
        $result = $client->getFullTableDownloadCSV(
            33100302
        );
        $this->assertInstanceOf(FullTableDownloadCSV::class, $result);
    }

    public function testGetAllCubesList()
    {
        $guzzle = $this->mockGuzzleClient(
            file_get_contents(__DIR__ . '/samples/getAllCubesList.json')
        );
        $client = new Client($guzzle);
        $result = $client->getAllCubesList();
        $this->assertinstanceOf(AllCubesList::class, $result);
    }

    public function testGetCubeMetadata()
    {
        $guzzle = $this->mockGuzzleClient(
            file_get_contents(__DIR__ . '/samples/getCubeMetadata.json')
        );
        $client = new Client($guzzle);
        $result = $client->getCubeMetadata(
            33100302
        );
        $this->assertInstanceOf(CubeMetadata::class, $result);
    }

    public function testGetSeriesInfoFromVector()
    {
        $guzzle = $this->mockGuzzleClient(
            file_get_contents(__DIR__ . '/samples/getSeriesInfoFromVector.json')
        );
        $client = new Client($guzzle);
        $result = $client->getSeriesInfoFromVector(
            32164132
        );
        $this->assertInstanceOf(SeriesInfoFromVector::class, $result);
    }

    public function testGetDataFromVectorByReferencePeriodRange()
    {
        $guzzle = $this->mockGuzzleClient(
            file_get_contents(__DIR__ . '/samples/getDataFromVectorByReferencePeriodRange.json')
        );
        $client = new Client($guzzle);
        $result = $client->getDataFromVectorByReferencePeriodRange(
            [32164132],
            new \DateTimeImmutable('2016-01-01'),
            new \DateTimeImmutable('2017-01-01'),
        );
        $this->assertInstanceOf(DataFromVectorByReferencePeriodRange::class, $result);
    }

    public function testGetCodeSets()
    {
        $guzzle = $this->mockGuzzleClient(
            file_get_contents(__DIR__ . '/samples/getCodeSets.json')
        );
        $client = new Client($guzzle);
        $result = $client->getCodeSets();
        $this->assertInstanceOf(CodeSets::class, $result);
    }

    public function testGetSeriesInfoFromCubePidCoord()
    {
        $guzzle = $this->mockGuzzleClient(
            file_get_contents(__DIR__ . '/samples/getSeriesInfoFromCubePidCoord.json')
        );
        $client = new Client($guzzle);
        $result = $client->getSeriesInfoFromCubePidCoordinate(
            35100003,
            new Coordinate(1,12)
        );
        $this->assertInstanceOf(SeriesInfoFromCubePidCoordinate::class, $result);
    }

    public function testGetChangedCubeList()
    {
        $guzzle = $this->mockGuzzleClient(
            file_get_contents(__DIR__ . '/samples/getChangedCubeList.json')
        );
        $client = new Client($guzzle);
        $result = $client->getChangedCubeList(new \DateTimeImmutable('3 days ago'));
        $this->assertinstanceOf(ChangedCubeList::class, $result);
    }

    public function testGetDataFromCubePidCoordAndLatestNPeriods()
    {
        $guzzle = $this->mockGuzzleClient(
            file_get_contents(__DIR__ . '/samples/getDataFromCubePidCoordAndLatestNPeriods.json')
        );
        $client = new Client($guzzle);
        $result = $client->getDataFromCubePidCoordinateAndLatestNPeriods(
            35100003,
            new Coordinate(1,12),
            3
        );
        $this->assertInstanceOf(DataFromCubePidCoordinateAndLatestNPeriods::class, $result);
    }

    public function testGetBulkVectorDataByRange()
    {
        $guzzle = $this->mockGuzzleClient(
            file_get_contents(__DIR__ . '/samples/getBulkVectorDataByRange.json')
        );
        $client = new Client($guzzle);
        $result = $client->getBulkVectorDataByRange(
            ["74804", "1"],
            new \DateTimeImmutable('2015-12-01T08:30'),
            new \DateTimeImmutable("2018-03-31T19:00")
        );
        $this->assertInstanceOf(BulkVectorDataByRange::class, $result);
    }

    public function testGetFullTableDownloadSDMX()
    {
        $guzzle = $this->mockGuzzleClient(
            file_get_contents(__DIR__ . '/samples/getFullTableDownloadSDMX.json')
        );
        $client = new Client($guzzle);
        $result = $client->getFullTableDownloadSDMX(
            14100287
        );
        $this->assertInstanceOf(FullTableDownloadSDMX::class, $result);
    }

    public function testGetChangedSeriesDataFromCubePidCoordinate()
    {
        $guzzle = $this->mockGuzzleClient(
            file_get_contents(__DIR__ . '/samples/getChangedSeriesDataFromCubePidCoord.json')
        );
        $client = new Client($guzzle);
        $result = $client->getChangedSeriesDataFromCubePidCoordinate(
            35100003,
            new Coordinate(1,12)
        );
        $this->assertInstanceOf(SeriesDataFromCubePidCoordinate::class, $result);
    }

    public function testGetChangedSeriesDataFromVector()
    {
        $guzzle = $this->mockGuzzleClient(
            file_get_contents(__DIR__ . '/samples/getChangedSeriesDataFromVector.json')
        );
        $client = new Client($guzzle);
        $result = $client->getChangedSeriesDataFromVector(
            80691319
        );
        $this->assertInstanceOf(SeriesDataFromVector::class, $result);
    }


    public function testGetAllCubesListLite()
    {
        $guzzle = $this->mockGuzzleClient(
            file_get_contents(__DIR__ . '/samples/getAllCubesListLite.json')
        );
        $client = new Client($guzzle);
        $result = $client->getAllCubesListLite();
        $this->assertInstanceOf(AllCubesListLite::class, $result);
    }

    public function testGetChangedSeriesList()
    {
        $guzzle = $this->mockGuzzleClient(
            file_get_contents(__DIR__ . '/samples/getChangedSeriesList.json')
        );
        $client = new Client($guzzle);
        $this->expectException(NotImplementedException::class);
        $client->getChangedSeriesList(
            new \DateTimeImmutable('yesterday')
        );
    }
}
