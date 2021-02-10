<?php

namespace App\Http\Controllers;

class ApplicationController {
    private function internalApiGet($path)
    {
        $baseUrl = 'https://www.algolia.com/api/internal/1';

        $guzzleClient = new \GuzzleHttp\Client();
        $res = $guzzleClient->get($baseUrl.$path, [
            'headers' => [
                'Authorization' => 'Basic ' . env('DASHBOARD_INTERNAL_API_KEY')
            ],
        ]);

        return $res->getBody()->getContents();
    }

    public function getApps($appIds)
    {
        return $this->internalApiGet('/applications/?application_ids='.$appIds.'&fields=name,user,current_plan,application_id,log_region');
    }
}
