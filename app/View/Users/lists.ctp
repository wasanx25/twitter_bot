<h2>ツイート一覧</h2>
<table class="table">
<tr style="font-weight: bold;">
	<td></td>
	<td>ツイート内容</td>
	<td>曜日指定ありか</td>
	<td>年月日</td>
	<td>時刻</td>
	<td>繰り返し曜日</td>
	<td></td>
</tr>
<?php foreach ($tweets as $tweet) : ?>
<tr>
<?php $data = $tweet["Tweet"]; ?>
<td><?php echo $data["id"]; ?></td>
<td><?php echo $data["body"]; ?></td>
<td><?php echo $data["roop_flag"]; ?></td>
<td><?php echo $data["date"]; ?></td>
<td><?php echo $data["time"]; ?></td>
<td>
<?php if ($tweet["Youbi"]): ?>
	<?php foreach ($tweet["Youbi"] as $youbi) : ?>
	<?php switch ($youbi["youbi"]) {
		case 0:
			echo "Sunday";
			break;
		case 1:
			echo "Monday";
			break;
		case 2:
			echo "Tuesday";
			break;
		case 3:
			echo "Wednesday";
			break;
		case 4:
			echo "Thursday";
			break;
		case 5:
			echo "Friday";
			break;
		case 6:
			echo "Saturday";
			break;
		default:
			echo "";
			break;
	} ?>
	<?php echo "/"; ?>
	<?php endforeach; ?>
<?php endif; ?>
</td>
<td><?php echo $this->Html->link("編集", "/users/edit/".$data["id"]); ?></td>
</tr>
<?php endforeach; ?>
</table>