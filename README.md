Implementation of the [Web Data Service (WDS)](https://www.statcan.gc.ca/en/developers/wds/user-guide) api

Example of usage to retrieve the latest average price of gas for all of Canada:
===

```php

use SeanJA\StatsCanAPI\ValueObjects\Enums\ProductIdEnum;
use SeanJA\StatsCanAPI\ValueObjects\Enums\GeographyEnum;
use SeanJA\StatsCanAPI\Client;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\RequestOptions;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use SeanJA\StatsCanAPI\ValueObjects\Coordinate;
use SeanJA\StatsCanAPI\ValueObjects\Dimensions\Member;

$client = new Client(
    guzzle: new GuzzleClient([
        //this might be a windows issue, unclear
        RequestOptions::VERIFY => false
    ]),
    cache: new FilesystemAdapter('', 0, __DIR__ . '/cache')
);

$productId = ProductIdEnum::MONTHLY_AVERAGE_RETAIL_PRICES_FOR_GASOLINE_AND_FUEL_OIL_BY_GEOGRAPHY;
$geography = GeographyEnum::CANADA;

$areaMember = null;

// get the area that was specified
// assumes the data comes back in the same order
/** @var Member $member */
foreach($data->dimension[0]->member as $member){
    if($member->memberId === $geography->value){
        $areaMember = $member->memberId;
        break;
    }
}

$coordinate = new Coordinate();
$coordinate->setDimension(1, $areaMember);
$coordinate->setDimension(2, 2); // unleaded self-serve

$data2 = $client->getDataFromCubePidCoordinateAndLatestNPeriods(
    $productId->value,
    $coordinate,
    1
);

// the latest data point for the canada wide average price of gas 
echo $data2->vectorDataPoints[0]->value;


```

todo:
===
- more tests
- figure out some of the ambiguous data in the enums (hundredweight shows up so many times, product id names are repeated)