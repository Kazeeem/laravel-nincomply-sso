<?php

namespace Eximius\Nincomply;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Nincomply
{
    protected string $baseUrl = 'https://verification.ninprofile.ng';

    protected ?string $clientId = null;

    protected ?string $clientSecret = null;

    protected ?string $redirectUri = null;

    protected ?string $accessToken = null;

    public function __construct()
    {
        if (! config('nincomply-sso.client_id') || ! config('nincomply-sso.client_secret') || ! config('nincomply-sso.redirect_uri')) {
            throw new \InvalidArgumentException('The required NINComply SSO configuration values are missing or invalid.');
        }

        $this->clientId = config('nincomply-sso.client_id');
        $this->clientSecret = config('nincomply-sso.client_secret');
        $this->redirectUri = config('nincomply-sso.redirect_uri');
    }

    /**
     * Generates the authorization URL for the OAuth flow.
     *
     * @param  string  $scope  The requested permissions (basic or full), defaults to 'basic'.
     * @param  string|null  $state  Optional state parameter for CSRF protection. A random string is generated if not provided.
     * @return string The generated authorization URL.
     */
    public function ssoUrl(string $scope = 'basic', ?string $state = null): string
    {
        if (! $state) {
            $state = Str::random(8);
        }

        $queryparameters = http_build_query([
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'response_type' => 'code',
            'state' => $state,
        ]);

        return $this->baseUrl.'/oauth/authorize?'.$queryparameters;
    }

    /**
     * Exchanges an authorization code for an access token.
     *
     * @param  string  $code  The authorization code received from the authorization server.
     * @return object The response containing the access token and other associated information.
     *
     * @throws \Exception If an error occurs during the HTTP request.
     */
    public function getAccessToken(string $code): object
    {
        $payload = [
            'grant_type' => 'authorization_code',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri' => $this->redirectUri,
            'code' => $code,
        ];

        return $this->handle('oauth/token', 'post', $payload);
    }

    /**
     * Retrieves the user information associated with the given token.
     *
     * @param  string  $token  The access token used to authenticate the request.
     * @return null|object The user information obtained from the OAuth provider.
     *
     * @throws \Exception If an error occurs during the HTTP request.
     */
    public function getUser(string $token): ?object
    {
        $this->accessToken = $token;
        return $this->handle('oauth/user');
    }

    /**
     * Sends an HTTP request to the specified URL using the provided method and payload.
     *
     * @param  string  $url  The specific endpoint to which the request is sent.
     * @param  string  $method  The HTTP method to use, either 'get' or 'post'. Defaults to 'get'.
     * @param  array  $payload  The payload data to include with the request, used for 'post' method.
     * @return object The response object returned from the request.
     *
     * @throws \Exception If an error occurs during the HTTP request.
     */
    private function handle(string $url, string $method = 'get', array $payload = [])
    {
        try {
            if ($method === 'get') {
                $response = Http::withToken($this->accessToken)->get($this->baseUrl.'/'.$url);
            } else {
                $response = Http::post($this->baseUrl.'/'.$url, $payload);
            }

            return $response->object();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
