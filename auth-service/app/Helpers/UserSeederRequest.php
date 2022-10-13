<?php

namespace App\Helpers;

use Exception;

class UserSeederRequest
{
    public static function send(string $microservice, string $model, string $endpoint,  array $attrs): void
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
            throw new Exception($response->getActionErrorMessage()->getMessage(), 400);
        }
    }
}
