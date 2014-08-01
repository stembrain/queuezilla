<?php
require_once("../../app/vendors/OAuth/netflix_consumer.php");
class NetflixShell extends Shell{
    function main(){
        echo "starting shell" . PHP_EOL;
        $this->authorizeNetflix();
        echo "ending shell" . PHP_EOL;


    }

    function authorizeNetflix(){ 
        echo "authorizeNetflix entry" . PHP_EOL;
        $netflix = new NetflixConsumer();
        echo "consumer created" . PHP_EOL;
        $callbackURL = "callbackURL";
        $requestToken = $netflix->getRequestToken('http://api-public.netflix.com/oauth/request_token', $callbackURL);
        print_r($requestToken);
        $this->log("Request token is $requestToken", LOG_DEBUG);
        //$this->Session->write('netflixRequestToken', $requestToken);
        $auth_url = "https://api-user.netflix.com/oauth/login" . 
            "?oauth_token=" . $requestToken->key . 
            "&application_name=" . $netflix->getConsumerName() . 
            "&oauth_consumer_key=" . $netflix->getConsumerKey();
        echo "auth url is $auth_url" . PHP_EOL;
    }

}
