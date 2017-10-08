<?php
// Since we're not using Composer, Facebook library is copied into the code
// Ideally, you should use Composer!

require_once 'application/libraries/Facebook/autoload.php';

/**
 * Extends the BaseFacebook class with the intent of using
 * PHP sessions to store user ids and access tokens.
 */
class Facebook
{
    public $instance;
    public $accessToken;

    public function __construct($config) {
        $this->instance = new Facebook\Facebook([
            'app_id' => $config['appId'],
            'app_secret' => $config['secret'],
            'default_graph_version' => 'v2.2',
        ]);
    }

    public function getUser() {
        // You might want to handle the exceptions better

        try {
            $response = $this->instance->get('/me?fields=id,name,email', $this->accessToken);

            if (empty($response)) {
                return false;
            } else {
                return $response->getGraphUser();
            }
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            return false;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            return false;;
        }
    }
}
