<?php

namespace App\Traits;

trait InteractsWithApiServiceResponses
{

    public function decodeResponse($response)
    {

        $decodedResponse = json_decode($response);

        return $decodedResponse->data ?? $decodedResponse;
    }

    public function checkIfErrorResponse($response)
    {

        if (isset($response->error)) {
            throw new \Exception("Algo falló: { $response->error}");
        }
    }
}
