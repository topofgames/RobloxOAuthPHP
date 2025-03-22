namespace Roblox;

use GuzzleHttp\Client;

class MessagingService {
    private $client;

    public function __construct() {
        $this->client = new Client();
    }

    public function sendMessage($accessToken, $universeId, $topic, $message) {
        $url = "https://apis.roblox.com/messaging-service/v1/universes/$universeId/topics/$topic";

        $response = $this->client->post($url, [
            'headers' => [
                'Authorization' => "Bearer $accessToken",
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode(['message' => $message])
        ]);

        return [
            'status' => $response->getStatusCode(),
            'body' => json_decode($response->getBody(), true)
        ];
    }
}
