<?php

App::import('Vendor', 'twitteroauth/OAuth');
App::import('Vendor', 'twitteroauth/twitteroauth');

class ActionTweetsShell extends AppShell {

    public $uses = array("User","Tweet");

    public function index() {
        $roopTweets = $this->Tweet->getTimeNowRoopTweet();
        $noRoopTweets = $this->Tweet->getDateTimeNowTweet();
        $tweets = array_merge($noRoopTweets, $roopTweets);

        foreach ($tweets as $tweet) {
	        //ユーザーDBからアクセストークン取得
	        $accessToken = $this->User->getAccessToken($tweet["Tweet"]["user_id"]);

	        // ツイート本文を変数に格納
	        $status = $tweet["Tweet"]["body"];

	        //TwitterOAuthオブジェクト生成
	        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $accessToken['oauth_token'], $accessToken['oauth_token_secret']);

	        // ツイートを行う！
	        $tweetAction = $connection->post("statuses/update", array("status" => $status));

	        $delete = $tweet["Tweet"]["delete_flag"];
	        $roop = $tweet["Tweet"]["roop_flag"];

	        if ($roop == "off") {
	        	if ($delete == "off") {
	        		$data = array(
	        			"Tweet" => array(
	        				"Tweet.id" => $tweet["Tweet"]["id"],
	        				"Tweet.delete_flag" => "on"
	        			)
	        		);
	        		$this->Tweet->save($data);
	        	}
	        }

	        // 変数をリセット
        	$accessToken = null;
        }
    }
}

?>