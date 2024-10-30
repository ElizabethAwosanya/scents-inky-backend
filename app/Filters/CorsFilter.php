<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class CorsFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $response = service('response');
        $origin = 'http://localhost:3000';

        // Allow CORS for requests from specific origin
        $response->setHeader('Access-Control-Allow-Origin', $origin);
        $response->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
        $response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        $response->setHeader('Access-Control-Allow-Credentials', 'true');

        // Handle preflight (OPTIONS) request
        if ($request->getMethod() === 'options') {
            $response->setStatusCode(200);
            return $response;
        }

        // Return null to allow the request to proceed
        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Set CORS headers in response to ensure cross-origin compliance
        $response->setHeader('Access-Control-Allow-Origin', 'http://localhost:3000');
        $response->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
        $response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        $response->setHeader('Access-Control-Allow-Credentials', 'true');
    }
}
