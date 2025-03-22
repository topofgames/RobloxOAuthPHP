require_once __DIR__ . '/../vendor/autoload.php';

use Roblox\RobloxOAuth;
use Roblox\MessagingService;

$clientId = 'your_client_id';
$clientSecret = 'your_client_secret';
$redirectUri = 'http://localhost/oauth/callback';

$oauth = new RobloxOAuth($clientId, $clientSecret, $redirectUri);

// Step 1: Redirect user to login
$state = bin2hex(random_bytes(8));
$nonce = bin2hex(random_bytes(8));
echo $oauth->getAuthorizationUrl($state, $nonce);

// Step 2: Exchange code after redirect
// $tokenSet = $oauth->fetchToken($_GET['code']);

// Step 3: Send message
// $msgService = new MessagingService();
// $result = $msgService->sendMessage($tokenSet['access_token'], 'universeId', 'topicName', 'Hello, Roblox!');
// print_r($result);
