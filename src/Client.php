<?php

namespace SeanJA\StatsCanAPI;

use DateInterval;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;
use GuzzleHttp\RequestOptions;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use SeanJA\Cache\CacheableTrait;
use SeanJA\StatsCanAPI\Exceptions\RequestException;
use SeanJA\StatsCanAPI\Responses\GetAllCubesList\AllCubesList;
use SeanJA\StatsCanAPI\Responses\GetAllCubesList\Cube;
use SeanJA\StatsCanAPI\Responses\GetChangedCubeList\ChangedCube;
use SeanJA\StatsCanAPI\Responses\GetChangedCubeList\ChangedCubeList;

class Client
{
    use CacheableTrait;

    public function __construct(
        readonly private ClientInterface             $guzzle,
        readonly private LoggerInterface|null        $logger = null,
        CacheItemPoolInterface|null                  $cache = null,
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
    protected function getTTL(string $method, array $args): DateInterval
    {
        $now = new \DateTimeImmutable();
        $date = new \DateTimeImmutable('tomorrow 8:30AM EST');
        return $now->diff($date);
    }

    /**
     * Does not appear to work
     * @param \DateTimeInterface $date
     * @return array
     * @deprecated
     */
    public function getChangedSeriesList(\DateTimeInterface $date): array
    {
        return $this->get('https://www150.statcan.gc.ca/t1/wds/rest/getChangedSeriesList/' . $date->format('Y-m-d'));
        return [];
    }

    /**
     * @param \DateTimeInterface $date
     * @return ChangedCubeList
     * @throws \Exception
     */
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
        return $this->post('https://www150.statcan.gc.ca/t1/wds/rest/getCubeMetadata', [[
            'productId' => $productId
        ]]);
    }

    public function getSeriesInfoFromCubePidCoord(int $productId, string $coordinate): array
    {
        return $this->post('https://www150.statcan.gc.ca/t1/wds/rest/getSeriesInfoFromCubePidCoord', [[
            'productId' => $productId,
            'coordinate' => $coordinate
        ]]);
    }

    public function getSeriesInfoFromVector(int $vectorId): array
    {
        return $this->post('https://www150.statcan.gc.ca/t1/wds/rest/getSeriesInfoFromVector', [[
            'vectorId' => $vectorId
        ]]);
    }

    /**
     * @return AllCubesList
     * @throws \Exception
     */
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
        $result = $this->post('https://www150.statcan.gc.ca/t1/wds/rest/getChangedSeriesDataFromCubePidCoord', [[
            'productId' => $productId,
            'coordinate' => $coordinate
        ]]);

        return (array)$result;
    }

    public function getChangedSeriesDataFromVector(int $vectorId): array
    {
        return $this->post('https://www150.statcan.gc.ca/t1/wds/rest/getChangedSeriesDataFromVector', [[
            'vectorId' => $vectorId
        ]]);
    }

    public function getDataFromCubePidCoordAndLatestNPeriods(int $productId, string $coordinate, int $latestN): array
    {
        return $this->post('https://www150.statcan.gc.ca/t1/wds/rest/getDataFromCubePidCoordAndLatestNPeriods', [[
            'productId' => $productId,
            'coordinate' => $coordinate,
            'latestN' => $latestN
        ]]);
    }

    public function getDataFromVectorsAndLatestNPeriods(int $vectorId, int $latestN): array
    {
        return $this->post('https://www150.statcan.gc.ca/t1/wds/rest/getDataFromVectorsAndLatestNPeriods', [[
            'vectorId' => $vectorId,
            'latestN' => $latestN
        ]]);
    }

    public function getBulkVectorDataByRange(
        array              $vectorIds,
        \DateTimeInterface $startDataPointReleaseDate,
        \DateTimeInterface $endDataPointReleaseDate): array
    {
        return $this->post('https://www150.statcan.gc.ca/t1/wds/rest/getBulkVectorDataByRange', [
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

    private function post($url, $data): array|null
    {
        return $this->request('POST', $url, $data);
    }

    private function get($url): array|null
    {
        return $this->request('GET', $url);
    }

    private function request(
        string $method,
        string $url,
        array  $data = []
    ): array|null
    {
        return $this->remember(function () use ($method, $url, $data) {
            try {
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
                $contents = $result->getBody()->getContents();
                return json_decode($contents, true);
            } catch (GuzzleRequestException|ClientException $e) {
                throw new RequestException($e->getMessage(), $e->getCode(), $e);
            }
        });
    }
}