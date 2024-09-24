<?php

// used to generate the enums, but

use GuzzleHttp\RequestOptions;
use SeanJA\StatsCanAPI\Client;
use GuzzleHttp\Client as GuzzleClient;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/functions.php';

$client = new Client(
    guzzle: new GuzzleClient([
        RequestOptions::VERIFY => false
    ]),
    cache: new FilesystemAdapter('', 0, __DIR__ . '/cache')
);

function generateArrayOfData($set, $desc, $code){
    $data = [];
    foreach($set as $item){
        $title = normalizeDescription($item->$desc);
        if(isset($data[$title])){
            for($i = 2; $i < 100; $i++){
                $tmp = $title . '_' . $i;
                if(isset($data[$tmp])){
                    continue;
                } else {
                    $title = $tmp;
                    break;
                }
            }
        }
        $data[$title] = $item->$code;
    }

    return $data;
}

function writeEnumFile($set, $filename, $desc, $code)
{
    $data = generateArrayOfData($set, $desc, $code);
    ksort($data);

    $text = '<?php' . PHP_EOL . PHP_EOL;
    $text .= 'namespace SeanJA\StatsCanAPI\ValueObjects\Enums;' . PHP_EOL;
    $text .= 'enum ' . $filename . ': int'. PHP_EOL . '{' . PHP_EOL;
    foreach ($data as $key=>$value) {
        $text .= buildCase($key, $value);
    }
    $text .= '}' . PHP_EOL;
    file_put_contents(__DIR__ . '/../src/ValueObjects/Enums/' . $filename . '.php', $text);
}

$sets = $client->getCodeSets();

writeEnumFile($sets->scalars, 'ScalarCodeEnum', 'scalarFactorDescEn', 'scalarFactorCode');
writeEnumFile($sets->frequencies, 'FrequencyCodeEnum', 'frequencyDescEn', 'frequencyCode');
writeEnumFile($sets->symbols, 'SymbolCodeEnum', 'symbolDescEn', 'symbolCode');
writeEnumFile($sets->statuses, 'StatusCodeEnum', 'statusDescEn', 'statusCode');
writeEnumFile($sets->uoms, 'UOMCodeEnum', 'memberUomEn', 'memberUomCode');
writeEnumFile($sets->surveys, 'SurveyCodeEnum', 'surveyEn', 'surveyCode');
writeEnumFile($sets->subjects, 'SubjectCodeEnum', 'subjectEn', 'subjectCode');
writeEnumFile($sets->classificationTypes, 'ClassificationTypeCodeEnum', 'classificationTypeEn', 'classificationTypeCode');
writeEnumFile($sets->securityLevels, 'SecurityLevelCodeEnum', 'securityLevelDescEn', 'securityLevelCode');
writeEnumFile($sets->terminateds, 'TerminatedCodeEnum', 'codeTextEn', 'codeId');
writeEnumFile($sets->terminateds, 'TerminatedCodeEnum', 'codeTextEn', 'codeId');
writeEnumFile($sets->wdsResponseStatuses, 'WDSResponseStatusCodeEnum', 'codeTextEn', 'codeId');

