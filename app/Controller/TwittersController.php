<?php

App::import('Vendor', 'twitteroauth/OAuth');
App::import('Vendor', 'twitteroauth/twitteroauth');

class TwittersController extends AppController {
    public $name = 'Twitters';
    public $autoRender = false;
    public $uses = array("User", "Tweet", "Youbi");
    public $component = 'Auth';

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('redirect_twitter','callback'));
    }

    // twitter API からリクエストトークンを取得
    public function redirect_twitter() {
        //セッション開始
        CakeSession::start();
        //TwitterOAuthオブジェクト生成
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
        //リクエストトークンを取得しセッションに保存
        $request_token = $connection->getRequestToken(OAUTH_CALLBACK);
        $this->Session->write('oauth_token', $request_token['oauth_token']);
        $this->Session->write('oauth_token_secret', $request_token['oauth_token_secret']);
        //エラー処理
        if ($connection->http_code) {
            $url = $connection->getAuthorizeURL($request_token['oauth_token']);
            $this->redirect($url);
        } else {
            $this->redirect('/');
        }
    }

    // アクセストークンを取得
    public function callback() {
        //セッション開始
        CakeSession::start();
        //TwitterOAuthオブジェクト生成
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $this->Session->read('oauth_token'), $this->Session->read('oauth_token_secret'));
        //セッションからリクエストトークンを削除
        $this->Session->delete('oauth_token');
        $this->Session->delete('oauth_token_secret');
        //アクセストークンを取得
        $access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

        //未登録ユーザーなら新規登録
        if (!$this->User->getUserByTwitterId($access_token['oauth_token'])) {
            $this->User->createUser($access_token);
        }
        //ログイン
        $this->request->data['User'] = array(
            'oauth_token' => $access_token['oauth_token'],
            'oauth_token_secret' => $access_token['oauth_token_secret']
        );
        if ($this->Auth->login()) {
            $id = $this->Auth->User('id');
            //プロフィールを更新
            $this->getProfile($id);
            $this->redirect('/users/mypage');
        } else {
            $this->Session->setFlash('あかんで！');
            $this->redirect('/');
        }
    }

     //[OAuth]プロフィール(ユーザー名、プロフィール画像URL)を最新に更新

    public function getProfile($id) {
        //ユーザーDBからアクセストークン取得
        $access_token = $this->User->getAccessToken($id);
        //TwitterOAuthオブジェクト生成
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
        //ユーザー情報を取得し、連想配列にする
        $content = $connection->get('account/verify_credentials');
        $content = (array)$content;

        $data = array(
            "User" => array(
                "id" => $id,
                "name" => $content["name"],
                "img" => $content["profile_image_url"]
                )
            );
        // ここで更新
        $this->User->save($data);
        // $content = (array)$content;
        $this->set("content",$content);
    }
    
    // postしたテキストを、ツイートテーブルに保存
    public function saveTweet() {
        if ($this->request->is('post')) {
            $post_data = array();
            $post_data = $this->request->data['Twitter'];

            // 繰り返しでツイートする場合
            if ($post_data["roop"] == "ON") {
                $data = array(
                    "Tweet" => array(
                        "user_id" => $this->Auth->User('id'),
                        "body" => $post_data["text"],
                        "delete_flag" => "off",
                        "roop_flag" => "on",
                        "date" => null,
                        "time" => $post_data["roopField"]["hour"].":".$post_data["roopField"]["min"]
                        )
                    );
                if ($result = $this->Tweet->save($data)) {
                    $tweet_id = $result["Tweet"]["id"];
                    foreach ($post_data["youbi"] as $youbi) {
                        $data = array(
                            "Youbi" => array(
                                "tweet_id" => $tweet_id,
                                "youbi" => $youbi
                                )
                            );
                        $this->Youbi->create();
                        $this->Youbi->save($data);
                    }
                    $this->Session->setFlash('ツイートを予約しました！');
                    $this->redirect("/users/mypage");
                } else {
                    $this->Session->setFlash('予約できないね！');
                }
            // 繰り返ししない場合
            } else {
                $data = array(
                    "Tweet" => array(
                        "user_id" => $this->Auth->User('id'),
                        "body" => $post_data["text"],
                        "delete_flag" => "off",
                        "roop_flag" => "off",
                        "date" => $post_data["noRoopField"]["year"]."-".$post_data["noRoopField"]["month"]."-".$post_data["noRoopField"]["day"],
                        "time" => $post_data["noRoopField"]["hour"].":".$post_data["noRoopField"]["min"]
                        )
                    );
                if ($this->Tweet->save($data)) {
                    $this->Session->setFlash('ツイートを予約しました！');
                    $this->redirect("/users/mypage");
                } else {
                    $this->Session->setFlash('予約できないね！');
                }
            }
        } else {
            $this->Session->setFlash('これじゃうまくいかないよ！');
            $this->redirect("/users/mypage");
        }
    }

}