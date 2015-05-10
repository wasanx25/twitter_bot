<h2>編集用ページ</h2>

<?php

echo $this->Form->create("Tweet", array("action" => "edit"));
echo $this->Form->input("body");?>

<?php echo $this->Form->input('time', array(
			'type' => 'time',
			'timeFormat' => '24',
			'interval' => 10,
			'label' => false,
			'div' => array(
				'id' => 'roopTime'
			),
			'class' => 'custom-select'
        )
	);
?>

<?php echo $this->Form->input('date', array(
			'type' => 'datetime',
			'timeFormat' => '24',
			'interval' => 10,
			'dateFormat' => 'YMD',
			'label' => false,
			'monthNames' => false,
			'minYear' => date('Y'),
			'maxYear' => date('Y')+1,
			'div' => array(
				'id' => 'dateTime'
			),
			'class' => 'custom-select'
        )
	);
?>
<div class="flag">
	<input type="radio" name="data[Tweet][delete_flag]" id="TweetDeleteFlagON" value="ON"/>
	<label for="TweetDeleteFlagON" class="switch-on">削除する</label>
	<input type="radio" name="data[Tweet][delete_flag]" id="TweetDeleteFlagOFF" value="OFF"/>
	<label for="TweetDeleteFlagOFF" class="switch-off">削除しない</label>
</div>
<div class="flag">
	<input type="radio" name="data[Twitter][roop]" id="TweetRoopFlagON" value="ON" onclick="check();"/>
	<label for="TweetRoopFlagON" class="switch-on">曜日指定あり</label>
	<input type="radio" name="data[Twitter][roop]" id="TweetRoopFlagOFF" value="OFF" onclick="check();"/>
	<label for="TweetRoopFlagOFF" class="switch-off">曜日指定なし</label>
</div>

<div id="youbiCheck" class="flag">
	<input type="checkbox" name="data[Tweet][youbi][]" value="0" id="TweetYoubi0" />
	<label for="TweetYoubi0" class="switch-on">Sunday</label>
	<input type="checkbox" name="data[Tweet][youbi][]" value="1" id="TweetYoubi1" />
	<label for="TweetYoubi1" class="switch-on">Monday</label>
	<input type="checkbox" name="data[Tweet][youbi][]" value="2" id="TweetYoubi2" />
	<label for="TweetYoubi2" class="switch-on">Tuesday</label>
	<input type="checkbox" name="data[Tweet][youbi][]" value="3" id="TweetYoubi3" />
	<label for="TweetYoubi3" class="switch-on">Wednesday</label>
	<input type="checkbox" name="data[Tweet][youbi][]" value="4" id="TweetYoubi4" />
	<label for="TweetYoubi4" class="switch-on">Thursday</label>
	<input type="checkbox" name="data[Tweet][youbi][]" value="5" id="TweetYoubi5" />
	<label for="TweetYoubi5" class="switch-on">Friday</label>
	<input type="checkbox" name="data[Tweet][youbi][]" value="6" id="TwitterYoubi6" />
	<label for="TwitterYoubi6" class="switch-on">Saturday</label>
</div>

<?php
echo $this->Form->end("予約！");
?>

