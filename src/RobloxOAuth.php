namespace Roblox;

use GuzzleHttp\Client;

class RobloxOAuth {
    private $clientId;
    private $clientSecret;
    private $redirectUri;
    private $issuerUrl = 'https://apis.roblox.com/oauth/.well-known/openid-configuration';
    private $client;

    public function __construct($clientId, $clientSecret, $redirectUri) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->redirectUri = $redirectUri;
        $this->client = new Client();
    }

    public function getAuthorizationUrl($state, $nonce, $scope = "openid profile") {
        $config = $this->discover();

        return $config['authorization_endpoint'] . '?' . http_build_query([
            'client_id' => $this->clientId,
            'response_type' => 'code',
            'scope' => $scope,
            'redirect_uri' => $this->redirectUri,
            'state' => $state,
            'nonce' => $nonce,
        ]);
    }

    public function fetchToken($code) {
        $config = $this->discover();

        $response = $this->client->post($config['token_endpoint'], [
            'auth' => [$this->clientId, $this->clientSecret],
            'form_params' => [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => $this->redirectUri
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function refreshToken($refreshToken) {
        $config = $this->discover();

        $response = $this->client->post($config['token_endpoint'], [
            'auth' => [$this->clientId, $this->clientSecret],
            'form_params' => [
                'grant_type' => 'refresh_token',
                'refresh_token' => $refreshToken,
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    private function discover() {
        $response = $this->client->get($this->issuerUrl);
        return json_decode($response->getBody(), true);
    }
}
