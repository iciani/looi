<?php

namespace App\Helpers;

use Illuminate\Testing\TestResponse;
use SimpleXMLElement;
use Symfony\Component\HttpFoundation\Response;

final class TestsHelper
{
    /**
     * Array To Xml
     *
     * @param  array $array
     * @param  string $rootElement
     * @param  SimpleXMLElement $xml
     * @return void
     */
    public static function arrayToXml(array $array, string $rootElement = null, SimpleXMLElement $xml = null): string
    {
        $xml2 = $xml;

        // If there is no Root Element then insert root
        if ($xml2 === null) {
            $xml2 = new SimpleXMLElement($rootElement !== null ? $rootElement : '<root/>');
        }

        // Visit all key value pair
        foreach ($array as $k => $v) {
            // If there is nested array then
            if (is_array($v)) {
                // Call function for nested array
                self::arrayToXml($v, $k, $xml2->addChild($k));
            } else {
                // Simply add child element.
                $xml2->addChild($k, $v);
            }
        }

        return $xml2->asXML();
    }

    public static function dumpApiResponsesWithErrors(TestResponse $response, int $status = Response::HTTP_OK)
    {
        if ($response->getStatusCode() != $status) {
            echo "Failed test method: " . debug_backtrace()[1]['function'] . " | Status response: {$response->getStatusCode()} \n";
            $response->dump();
        }
    }

    public static function getJsonResponse(TestResponse $response): mixed
    {
        return json_decode($response->getContent(), true);
    }
}
