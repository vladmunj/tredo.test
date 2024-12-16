<?php namespace App\Services;

use Illuminate\Support\Facades\Storage;
use App\Models\Device;
use App\Models\FirebaseNotification;
use Google\Client as GoogleClient;
use Illuminate\Support\Facades\Http;

final class FirebaseService{
    # Google api client instance
    private GoogleClient $googleClient;
    # Firebase notification title & message
    private string $title = '',$message = '';
    # User device object that will receive notifications
    private Device $device;

    /**
     * Initialize firebase service
     * @param string $credentials - firebase api credentials for send notifications
     * @return void
     */
    public function __construct(private string $credentials = ''){
        $this->credentials = Storage::path('firebase-creds.json');
    }

    /**
     * Initialize new google api client, set credentials & scopes for api requests
     * @return void
     */
    private function clientInit() : void{
        $this->googleClient = new GoogleClient();
        $this->googleClient->setAuthConfig($this->credentials);
        foreach(config('firebase.scopes') as $scope){
            $this->googleClient->addScope($scope);
        }
        $this->googleClient->refreshTokenWithAssertion();
    }

    /**
     * Get new access token for google api requests
     * @return array - firebase access token data
     */
    private function getFirebaseToken() : array{
        $tokenData = $this->googleClient->getAccessToken();
        if(empty($tokenData['access_token'])){
            $this->storeNotification(__('errors.firebase.access_token'));
            throw new \Exception(__('errors.firebase.access_token'));
        }
        return $tokenData;
    }

    /**
     * Send new firebase notification via api
     * @param string $deviceToken - firebase user device token
     * @return mixed - firebase api response
     */
    private function sendNotification(string $deviceToken) : mixed{
        $this->clientInit();
        $accessTokenData = $this->getFirebaseToken();
        return Http::withHeaders([
            'Authorization' => 'Bearer '.$accessTokenData['access_token'],
            'Content-Type' => 'application/json'
        ])->timeout(30)->post(env('FIREBASE_NOTIFY_URL'),[
            'message' => [
                'token' => $deviceToken,
                'notification' => [
                    'title' => $this->title,
                    'body' => $this->message
                ]
            ]
        ]);
    }

    /**
     * Store notification data & google api response to database
     * @param string $status - is notification sended status
     * @param array $httpResponse - firebase api response
     * @return void
     */
    private function storeNotification(string $status, array $httpResponse = []) : void{
        FirebaseNotification::create([
            'device_id' => $this->device->id,
            'title' => $this->title,
            'message' => $this->message,
            'status' => $status,
            'http_response' => $httpResponse
        ]);
    }

    /**
     * Send notification via firebase api and store result to database
     * @param Device $device - device that will receive notification
     * @param string $title - notification title
     * @param string $message - notification message
     * @return mixed - firebase api response
     */
    public function notify(Device $device, string $title, string $message) : mixed{
        list($this->title,$this->message,$this->device) = [$title,$message,$device];
        $firebaseApiResponse = $this->sendNotification($this->device->token);
        $this->storeNotification(
            (__('errors.firebase.notification.statuses.'.$firebaseApiResponse->status()) ?? 'unknown status: '.$firebaseApiResponse->status()),
            $firebaseApiResponse->json()
        );
        return $firebaseApiResponse;
    }
}