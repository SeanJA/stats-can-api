<?php

namespace SeanJA\StatsCanApi;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use Psr\Cache\CacheItemPoolInterface;
use SeanJA\Cache\CacheableTrait;
use SeanJA\StatsCanApi\Responses\GetAllCubesList\AllCubesList;
use SeanJA\StatsCanApi\Responses\GetAllCubesList\Cube;
use SeanJA\StatsCanApi\Responses\GetChangedCubeList\ChangedCube;
use SeanJA\StatsCanApi\Responses\GetChangedCubeList\ChangedCubeList;
use SeanJA\StatsCanApi\Responses\GetChangedSeriesList\ChangedSeriesList;

class Client
{
    use CacheableTrait;

    public function __construct(
        readonly private ClientInterface             $guzzle,
        readonly private CacheItemPoolInterface|null $cacheItemPool = null
    )
    {
        $this->setCache($cacheItemPool);
    }

    public function getChangedSeriesList(\DateTimeInterface $date): array
    {
        $result = $this->get('https://www150.statcan.gc.ca/t1/wds/rest/getChangedSeriesList/' . $date->format('Y-m-d'));
        var_dump($result);
        die();
    }

    public function getChangedCubeList(\DateTimeInterface $date): ChangedCubeList
    {
        $result = $this->get(
            'https://www150.statcan.gc.ca/t1/wds/rest/getChangedCubeList/' . $date->format('Y-m-d')
        );
        return new ChangedCubeList(
            array_map(function ($data) {
                return ChangedCube::deserialize($data);
            }, $result['object'])
        );
    }

    public function getCubeMetadata(int $productId): array
    {
        return $this->post('https://www150.statcan.gc.ca/t1/wds/rest/getCubeMetadata', [
            'productId' => $productId
        ]);
    }

    public function getSeriesInfoFromCubePidCoord(int $productId, string $coordinate): array
    {
        return $this->post('https://www150.statcan.gc.ca/t1/wds/rest/getSeriesInfoFromCubePidCoord', [
            'productId' => $productId,
            'coordinate' => $coordinate
        ]);
    }

    public function getSeriesInfoFromVector(int $vectorId): array
    {
        return $this->post('https://www150.statcan.gc.ca/t1/wds/rest/getSeriesInfoFromVector', [
            'vectorId' => $vectorId
        ]);
    }

    public function getAllCubesList(): AllCubesList
    {
        $result = $this->get('https://www150.statcan.gc.ca/t1/wds/rest/getAllCubesList');
        return new AllCubesList(
            array_map(function ($data) {
                return Cube::deserialize($data);
            }, $result)
        );
    }

    public function getAllCubesListLite(): array
    {
        return $this->get('https://www150.statcan.gc.ca/t1/wds/rest/getAllCubesListLite');
    }

    public function getChangedSeriesDataFromCubePidCoord(int $productId, string $coordinate): array
    {
        return $this->post('https://www150.statcan.gc.ca/t1/wds/rest/getChangedSeriesDataFromCubePidCoord', [
            'productId' => $productId,
            'coordinate' => $coordinate
        ]);
    }

    public function getChangedSeriesDataFromVector(int $vectorId): array
    {
        return $this->post('https://www150.statcan.gc.ca/t1/wds/rest/getChangedSeriesDataFromVector', [
            'vectorId' => $vectorId
        ]);
    }

    public function getDataFromCubePidCoordAndLatestNPeriods(int $productId, string $coordinate, int $latestN): array
    {
        return $this->post('https://www150.statcan.gc.ca/t1/wds/rest/getDataFromCubePidCoordAndLatestNPeriods', [
            'productId' => $productId,
            'coordinate' => $coordinate,
            'latestN' => $latestN
        ]);
    }

    public function getDataFromVectorsAndLatestNPeriods(int $vectorId, int $latestN): array
    {
        return $this->post('https://www150.statcan.gc.ca/t1/wds/rest/getDataFromVectorsAndLatestNPeriods', [
            'vectorId' => $vectorId,
            'latestN' => $latestN
        ]);
    }

    public function getBulkVectorDataByRange(
        array              $vectorIds,
        \DateTimeInterface $startDataPointReleaseDate,
        \DateTimeInterface $endDataPointReleaseDate): array
    {
        return $this->post(' https://www150.statcan.gc.ca/t1/wds/rest/getBulkVectorDataByRange', [
            'vectorIds' => $vectorIds,
            'startDataPointReleaseDate' => $startDataPointReleaseDate->format('Y-m-d\TH:i'),
            'endDataPointReleaseDate' => $endDataPointReleaseDate->format('Y-m-d\TH:i')
        ]);
    }

    public function getDataFromVectorByReferencePeriodRange(
        array              $vectorIds,
        \DateTimeImmutable $startRefPeriod,
        \DateTimeInterface $endDataPointReleaseDate
    ): array
    {
        $vectorIds = array_map(function ($id) {
            return '"' . $id . '"';
        }, $vectorIds);

        $vectorIds = implode(',', $vectorIds);
        return $this->get(
            'https://www150.statcan.gc.ca/t1/wds/rest/getDataFromVectorByReferencePeriodRange?vectorIds=' . $vectorIds . '&startRefPeriod=' . $startRefPeriod->format('Y-m-d') . '&endReferencePeriod=' . $endDataPointReleaseDate->format('Y-m-d')
        );
    }

    public function getFullTableDownloadCSV(int $productId): array
    {
        return $this->get('https://www150.statcan.gc.ca/t1/wds/rest/getFullTableDownloadCSV/' . $productId . '/en');
    }

    public function getFullTableDownloadSDMX(int $productId): array
    {
        return $this->get('https://www150.statcan.gc.ca/t1/wds/rest/getFullTableDownloadSDMX/' . $productId);
    }

    public function getCodeSets(): array
    {
        return $this->get('https://www150.statcan.gc.ca/t1/wds/rest/getCodeSets');
    }

    private function post($url, $data): array
    {
        return $this->request('POST', $url, $data);
    }

    private function get($url): array
    {
        return $this->request('GET', $url);
    }

    private function request(
        string $method,
        string $url,
        array  $data = []
    ): array
    {
        return $this->remember(function () use ($method, $url, $data) {
            $options = [];
            if ($data) {
                $options[RequestOptions::JSON] = $data;
            }

            $result = $this->guzzle->request(
                $method,
                $url,
                $options
            );
            $result->getBody()->rewind();
            return json_decode($result->getBody()->getContents(), true);
        });
    }
}