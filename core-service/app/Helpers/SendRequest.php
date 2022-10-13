<?php

namespace App\Helpers;

use Egal\Core\Communication\Response;
use Error;

class SendRequest
{
    public static function send(string $microservice, string $model, string $endpoint,  array $attrs): Response
    {
        $request = new \Egal\Core\Communication\Request(
            $microservice,
            $model,
            $endpoint,
            $attrs
        );

        $request->call();

        $response = $request->getResponse();

        if ($response->getStatusCode() != 200) {
            throw new Error($response->getActionErrorMessage()->getMessage(), 405);
        }

        return $response;
    }
}
