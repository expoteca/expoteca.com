<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Artisan;

class SysadminController extends Controller
{
    /**
     * Exec a deployment action.
     *
     * @param  string  $secretKey
     * @return Response
     */
    function deploy($secretKey) {
        // Branch reference
        $branchHostMap = [
            'master' => 'expoteca.com',
            'develop' => 'dev.expoteca.com',
        ];
        // Check the secret key
        if (env('DEPLOY_SECRET_KEY', str_random(32)) !== $secretKey) {
            abort(403, 'Unauthorized action.');
        }
        // Check other params
        if (!isset($_SERVER['HTTP_X_GITHUB_EVENT']) ||
            $_SERVER['HTTP_X_GITHUB_EVENT'] !== 'push' ||
            !isset($_POST['payload'])) {
            abort(500, 'Unexpected request.');
        }
        // Check branch
        $payload = json_decode($_POST['payload'], true);
        $branch = explode('/', $payload['ref'])[2];
        if (!array_key_exists($branch, $branchHostMap)) {
            return;
        }

        if ($branchHostMap[$branch] === $_SERVER['SERVER_NAME'] ||
            $branchHostMap[$branch] === $_SERVER['HTTP_HOST']) {
            Artisan::call('down');
            Artisan::call('code:pull');
            Artisan::call('optimize');
            Artisan::call('migrate');
            Artisan::call('up');
            return 'OK';
        } else {
            // Reply the POST request against the correct host
            $client = new Client();
            $res = $client->post('//' . $branchHostMap[$branch] . "/_/deploy/$secretKey", [
                'headers' => array_map(function ($key) {
                    return substr($key, 5);
                }, array_filter($_SERVER, function ($key) {
                    return strpos($key, 'HTTP_') === 0;
                })),
                'form_params' => $_POST
            ]);
            return (string) $res->getReasonPhrase();
        }
    }

}
