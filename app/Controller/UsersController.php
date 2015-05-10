<?php

class UsersController extends AppController {
    public $name = 'Users';
    public $uses = array("User", "Tweet");
    
    public function beforeFilter() {
        parent::beforeFilter();
    }

    //ログアウト
    public function logout() {
        $this->set('title_for_layout', 'ログアウト');
        $this->Auth->logout();
        $this->redirect('/');
    }

    public function index() {

    }

    // ユーザーマイページ用
    public function mypage() {
        // ユーザー情報（名前と画像）を取得
        $id = $this->Auth->User('id');
        $userData = $this->User->getUserProfile($id);
        $this->set("userData", $userData);
    }

    // ログイン中のユーザーのツイート一覧を取得
    public function lists() {
        $id = $this->Auth->User('id');
        $tweets = $this->Tweet->getUserAllTweet($id);
        $this->set("tweets", $tweets);
    }

    // ツイート編集用
    public function edit($id=null) {
        $this->Tweet->id = $id;
        if ($this->request->is("get")) {
            $this->request->data = $this->Tweet->read();
        } else {
            if ($this->Tweet->save($this->request->data)) {
                $this->Session->setFlash('編集できたよ！');
            } else {
                $this->Session->setFlash('編集できないよ！');
            }
        }
    }
}

?>