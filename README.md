Implementation of the [Web Data Service (WDS)](https://www.statcan.gc.ca/en/developers/wds/user-guide) api

Example of usage to retrieve the latest average price of gas for all of Canada:
===

```php
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\RequestOptions;
use SeanJA\StatsCanAPI\Client;
use SeanJA\StatsCanAPI\ValueObjects\Coordinate;
use SeanJA\StatsCanAPI\ValueObjects\Dimensions\Member;
use SeanJA\StatsCanAPI\ValueObjects\Enums\GeographyEnum;
use SeanJA\StatsCanAPI\ValueObjects\Enums\ProductIdEnum;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

require __DIR__ . '/vendor/autoload.php';

// setup the client
$client = new Client(
    guzzle: new GuzzleClient([
        // unclear if this is an issue with windows or the api endpoints
        RequestOptions::VERIFY => false
    ]),
    cache: new FilesystemAdapter('', 0, __DIR__ . '/cache')
);

class StatsCanLatestAverageGasPriceService
{
    public function __construct(
        readonly private Client $client
    )
    {
    }

    public function getLatestGasPriceForArea(GeographyEnum $geography): int
    {
        $productId = ProductIdEnum::MONTHLY_AVERAGE_RETAIL_PRICES_FOR_GASOLINE_AND_FUEL_OIL_BY_GEOGRAPHY;
        // get the data for this specific product
        $data = $this->client->getCubeMetadata($productId->value);

        // get the area that was specified
        $areaMemberDimensionPosition = $data->dimension[0]->dimensionPositionId;
        $areaMember = null;
        /** @var Member $member */
        foreach($data->dimension[0]->member as $member){
            if($member->memberId === $geography->value){
                $areaMember = $member->memberId;
                break;
            }
        }

        // get the second coordinate, which is fuel type:
        $fuelTypeDimensionPosition = $data->dimension[1]->dimensionPositionId;
        $fuelTypeMember = null;
        foreach($data->dimension[1]->member as $member){
            if($member->memberNameEn === 'Regular unleaded gasoline at self service filling stations'){
                $fuelTypeMember = $member->memberId;
                break;
            }
        }

        //setup the coordinate you want to query for
        $coordinate = new Coordinate();
        // the first dimension is the area
        $coordinate->setDimension($areaMemberDimensionPosition, $areaMember);

        $coordinate->setDimension($fuelTypeDimensionPosition, $fuelTypeMember);

        $data2 = $this->client->getDataFromCubePidCoordinateAndLatestNPeriods(
            $productId->value,
            $coordinate,
            // only get the latest row
            1
        );

        return $data2->vectorDataPoints[0]->value;
    }
}

$service = new StatsCanLatestAverageGasPriceService($client);

echo $service->getLatestGasPriceForArea(GeographyEnum::CANADA);
```

todo:
===
- more tests
- figure out some of the ambiguous data in the enums (hundredweight shows up so many times, but it is different in french, product id names are repeated)