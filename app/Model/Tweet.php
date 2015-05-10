<?php

class Tweet extends AppModel {
	public $name = "Tweet";
	public $hasMany = array("Youbi");

	// 同じ日付、時刻のツイートを取得
	public function getDateTimeNowTweet() {
		$date = date("Y-m-d");
		$time = date("H:i:u");

		$option = array(
			"conditions" => array(
				"Tweet.delete_flag" => "off",
				"Tweet.date" => $date,
				"Tweet.time" => $time,
				"Tweet.roop_flag" =>"off"
				)
			);

		$tweets = $this->find("all",$option);
		return $tweets;
	}

	// 同じ時刻、曜日のツイートを取得
	public function getTimeNowRoopTweet() {
		$time = date("H:i:u");
		$youbi = date("w");

		// アソシエーションで、tweetテーブルの情報も取得
		$option = array(
			"conditions" => array(
				"Youbi.youbi" => $youbi
				),
				array(
					"Tweet.time" => $time
				)
			);
		$tweets = $this->Youbi->find("all",$option);
		return $tweets;
	}

	// ユーザーのツイート一覧を取得
	public function getUserAllTweet($id) {
		$option = array(
			"conditions" => array(
				"Tweet.user_id" => $id,
				"Tweet.delete_flag" => "off"
				)
			);
		$tweets = $this->find("all", $option);
		return $tweets;
	}
}

 ?>