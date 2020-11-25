<?php

namespace App\Helpers;

use Symfony\Component\HttpClient\HttpClient;

class ApiRequest{

    public function getApiResponse($name)
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://trefle.io/api/v1/plants/search?token=kJqCyqUGvVLbrVzGLfA7ZbVioh4E2NtD5YfX9C0roBM&q='.$name);

        $content = $response->toArray();

        return $content['data'][0]['image_url'];
    }

}