Implementation of the [Web Data Service (WDS)](https://www.statcan.gc.ca/en/developers/wds/user-guide) api

Example of usage to retrieve the latest average price of gas for all of Canada:
===

```php

$client = new Client(
    guzzle: new GuzzleClient([
        RequestOptions::VERIFY => false
    ]),
    cache: new FilesystemAdapter('', 0, __DIR__ . '/cache')
);

$productId = ProductIdEnum::MONTHLY_AVERAGE_RETAIL_PRICES_FOR_GASOLINE_AND_FUEL_OIL_BY_GEOGRAPHY;

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