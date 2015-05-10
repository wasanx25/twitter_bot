<?php
class User extends AppModel {
	public $name = 'User';
	
	//登録済みが判定
	public function getUserByTwitterId($twitter_user_id) {
		$params = array(
            'conditions' => array(
                'User.oauth_token' => $twitter_user_id
            ),
        );
        return $this->find('first', $params);
	}

	//新規ユーザー登録
	public function createUser($data) {
		$this->set($data);
		$this->data = array(
			'tw_id' => $data['user_id'],
			'username' => $data['screen_name'],
			'password' => $data['oauth_token_secret'],
			'oauth_token' => $data['oauth_token'],
			'oauth_token_secret' => $data['oauth_token_secret']
		);
		return $this->save($this->data);
	}

	//アクセストークンを取得
	public function getAccessToken($id) {
		$params = array(
			'conditions' => array(
				'User.id' => $id,
			),
			'fields' => Array(
				'User.oauth_token',
				'User.oauth_token_secret',
			),
		);
		$data = $this->find('first', $params);
		return $data['User'];
	}

	// ユーザーページ用の情報を取得
	public function getUserProfile($id) {
		$option = array(
			"conditions" => array(
				"User.id" => $id
				),
			"recursive" => 0
			);
		$data = $this->find('first', $option);
		return $data;
	}

}

?>