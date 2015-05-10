<?php foreach ($userData as $data) : ?>
<h2>よう！きたな！<?php echo $data["name"]; ?></h2>
<img src="<?php echo $data["img"] ?>" alt="<?php echo $data["name"]; ?>">
<?php endforeach; ?>

<?php echo $this->Html->link('ログアウト', '/users/logout', array('class' => 'btn btn-warning')); ?>

<?php echo $this->Form->create('Twitter', array('action' => 'saveTweet')); ?>
<?php echo $this->Form->input("text"); ?>

<!-- 繰り返し判定 -->
<div class="flag">
	<input type="hidden" name="data[Twitter][roop]" id="TwitterRoop_" value=""/>
		<input type="radio" name="data[Twitter][roop]" id="TwitterRoopON" value="ON" onclick="check();"/>
		<label for="TwitterRoopON" class="switch-on">曜日指定あり</label>
		<input type="radio" name="data[Twitter][roop]" id="TwitterRoopOFF" value="OFF" onclick="check();"/>
		<label for="TwitterRoopOFF" class="switch-off">曜日指定なし</label>
</div>

<?php echo $this->Form->input('noRoopField', array(
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


<?php echo $this->Form->input('roopField', array(
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

<div id="youbiCheck" class="flag">
	<input type="checkbox" name="data[Twitter][youbi][]" value="0" id="TwitterYoubi0" />
	<label for="TwitterYoubi0" class="switch-on">Sunday</label>
	<input type="checkbox" name="data[Twitter][youbi][]" value="1" id="TwitterYoubi1" />
	<label for="TwitterYoubi1" class="switch-on">Monday</label>
	<input type="checkbox" name="data[Twitter][youbi][]" value="2" id="TwitterYoubi2" />
	<label for="TwitterYoubi2" class="switch-on">Tuesday</label>
	<input type="checkbox" name="data[Twitter][youbi][]" value="3" id="TwitterYoubi3" />
	<label for="TwitterYoubi3" class="switch-on">Wednesday</label>
	<input type="checkbox" name="data[Twitter][youbi][]" value="4" id="TwitterYoubi4" />
	<label for="TwitterYoubi4" class="switch-on">Thursday</label>
	<input type="checkbox" name="data[Twitter][youbi][]" value="5" id="TwitterYoubi5" />
	<label for="TwitterYoubi5" class="switch-on">Friday</label>
	<input type="checkbox" name="data[Twitter][youbi][]" value="6" id="TwitterYoubi6" />
	<label for="TwitterYoubi6" class="switch-on">Saturday</label>
</div>

<div class="submit">
	<input type="submit" value="ツイートを予約！" class="btn btn-primary">
</div>

<?php echo $this->Html->link('ツイートを一覧', '/users/lists', array('class' => 'btn btn-primary')); ?>