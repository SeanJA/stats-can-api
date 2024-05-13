<?php

namespace SeanJA\StatsCanAPI;

use DateInterval;
use DateTimeInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use SeanJA\Cache\CacheableTrait;
use SeanJA\StatsCanAPI\Exceptions\NotImplementedException;
use SeanJA\StatsCanAPI\Exceptions\RequestException;
use SeanJA\StatsCanAPI\Requests\GetAllCubesList;
use SeanJA\StatsCanAPI\Requests\GetAllCubesListLite;
use SeanJA\StatsCanAPI\Requests\GetBulkVectorDataByRange;
use SeanJA\StatsCanAPI\Requests\GetChangedCubeList;
use SeanJA\StatsCanAPI\Requests\GetChangedSeriesDataFromCubePidCoordinate;
use SeanJA\StatsCanAPI\Requests\GetChangedSeriesDataFromVector;
use SeanJA\StatsCanAPI\Requests\GetCodeSets;
use SeanJA\StatsCanAPI\Requests\GetCubeMetadata;
use SeanJA\StatsCanAPI\Requests\GetDataFromCubePidCoordinateAndLatestNPeriods;
use SeanJA\StatsCanAPI\Requests\GetDataFromVectorByReferencePeriodRange;
use SeanJA\StatsCanAPI\Requests\GetDataFromVectorsAndLatestNPeriods;
use SeanJA\StatsCanAPI\Requests\GetFullTableDownloadCSV;
use SeanJA\StatsCanAPI\Requests\GetFullTableDownloadSDMX;
use SeanJA\StatsCanAPI\Requests\GetSeriesInfoFromCubePidCoordinate;
use SeanJA\StatsCanAPI\Requests\GetSeriesInfoFromVector;
use SeanJA\StatsCanAPI\Requests\StatsCanAPIRequestInterface;
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

class Client
{
    use CacheableTrait;

    public function __construct(
        readonly private ClientInterface      $guzzle,
        readonly private LoggerInterface|null $logger = null,
        CacheItemPoolInterface|null           $cache = null,
    )
    {
        $this->setCache($cache);
    }

    /**
     * Override the cache ttl
     * @param string $method
     * @param array $args
     * @return DateInterval
     */
    protected function getTTL(
        string $method,
        array  $args
    ): DateInterval
    {
        $now = new \DateTimeImmutable();
        $date = new \DateTimeImmutable('tomorrow 8:30AM EST');
        return $now->diff($date);
    }

    /**
     * Does not appear to work
     * @param DateTimeInterface $date
     * @return array
     * @throws NotImplementedException
     * @deprecated
     */
    public function getChangedSeriesList(
        DateTimeInterface $date
    ): array
    {
        throw new NotImplementedException(
            'Get Changed Series List does not appear to return anything'
        );
        // todo: if this ever returns data, implement it I guess
        //  https://www150.statcan.gc.ca/t1/wds/rest/getChangedSeriesList/' . $date->format('Y-m-d');
    }

    public function getChangedCubeList(
        DateTimeInterface $date
    ): ChangedCubeList
    {
        return ChangedCubeList::fromResponse(
            $this->send(new GetChangedCubeList($date))
        );
    }

    public function getCubeMetadata(
        int $productId
    ): CubeMetadata
    {
        return CubeMetadata::fromResponse(
            $this->send(new GetCubeMetadata($productId))
        );
    }

    public function getSeriesInfoFromCubePidCoordinate(
        int    $productId,
        Coordinate $coordinate
    ): SeriesInfoFromCubePidCoordinate
    {
        return SeriesInfoFromCubePidCoordinate::fromResponse(
            $this->send(
                new GetSeriesInfoFromCubePidCoordinate(
                    $productId,
                    $coordinate
                )
            )
        );
    }

    public function getSeriesInfoFromVector(
        int $vectorId
    ): SeriesInfoFromVector
    {
        return SeriesInfoFromVector::fromResponse(
            $this->send(
                new GetSeriesInfoFromVector(
                    $vectorId
                )
            )
        );
    }

    public function getAllCubesList(): AllCubesList
    {
        return AllCubesList::fromResponse(
            $this->send(new GetAllCubesList())
        );
    }

    public function getAllCubesListLite(): AllCubesListLite
    {
        return AllCubesListLite::fromResponse(
            $this->send(
                new GetAllCubesListLite()
            )
        );
    }

    public function getChangedSeriesDataFromCubePidCoordinate(
        int    $productId,
        Coordinate $coordinate
    ): SeriesDataFromCubePidCoordinate
    {
        return SeriesDataFromCubePidCoordinate::fromResponse(
            $this->send(
                new GetChangedSeriesDataFromCubePidCoordinate(
                    $productId,
                    $coordinate
                )
            )
        );
    }

    public function getChangedSeriesDataFromVector(
        int $vectorId
    ): SeriesDataFromVector
    {
        return SeriesDataFromVector::fromResponse(
            $this->send(
                new GetChangedSeriesDataFromVector(
                    $vectorId
                )
            )
        );
    }

    public function getDataFromCubePidCoordinateAndLatestNPeriods(
        int    $productId,
        Coordinate $coordinate,
        int    $latestN): DataFromCubePidCoordinateAndLatestNPeriods
    {
        return DataFromCubePidCoordinateAndLatestNPeriods::fromResponse(
            $this->send(
                new GetDataFromCubePidCoordinateAndLatestNPeriods(
                    $productId,
                    $coordinate,
                    $latestN
                )
            )
        );
    }

    public function getDataFromVectorsAndLatestNPeriods(
        int $vectorId,
        int $latestN): DataFromVectorsAndLatestNPeriods
    {
        return DataFromVectorsAndLatestNPeriods::fromResponse(
            $this->send(
                new GetDataFromVectorsAndLatestNPeriods(
                    $vectorId,
                    $latestN
                )
            )
        );
    }

    public function getBulkVectorDataByRange(
        array             $vectorIds,
        DateTimeInterface $startDataPointReleaseDate,
        DateTimeInterface $endDataPointReleaseDate): BulkVectorDataByRange
    {
        return BulkVectorDataByRange::fromResponse(
            $this->send(new GetBulkVectorDataByRange(
                $vectorIds,
                $startDataPointReleaseDate,
                $endDataPointReleaseDate
            ))
        );
    }

    public function getDataFromVectorByReferencePeriodRange(
        array             $vectorIds,
        DateTimeInterface $startRefPeriod,
        DateTimeInterface $endDataPointReleaseDate
    ): DataFromVectorByReferencePeriodRange
    {
        return DataFromVectorByReferencePeriodRange::fromResponse(
            $this->send(
                new GetDataFromVectorByReferencePeriodRange(
                    $vectorIds,
                    $startRefPeriod,
                    $endDataPointReleaseDate
                )
            )
        );
    }

    public function getFullTableDownloadCSV(int $productId): FullTableDownloadCSV
    {
        return FullTableDownloadCSV::fromResponse(
            $this->send(
                new GetFullTableDownloadCSV(
                    $productId
                )
            )
        );
    }

    public function getFullTableDownloadSDMX(int $productId): FullTableDownloadSDMX
    {
        return FullTableDownloadSDMX::fromResponse(
            $this->send(
                new GetFullTableDownloadSDMX(
                    $productId
                )
            )
        );
    }

    public function getCodeSets(): CodeSets
    {
        return CodeSets::fromResponse(
            $this->send(
                new GetCodeSets()
            )
        );
    }

    /**
     * @param StatsCanAPIRequestInterface $request
     * @return array
     * @throws RequestException
     */
    public function send(StatsCanAPIRequestInterface $request): array
    {
        return $this->remember(function () use ($request) {
            try {
                $result = $this->guzzle->send($request());
                $result->getBody()->rewind();
                $contents = $result->getBody()->getContents();
                return json_decode($contents, true);
            } catch (GuzzleRequestException|ClientException|GuzzleException $e) {
                throw new RequestException($e->getMessage(), $e->getCode(), $e);
            }
        });
    }
}