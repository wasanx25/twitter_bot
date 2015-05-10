<div class="well lead">
	<?php for ($i=0; $i < 12; $i++) { ?>
		<i class="fa fa-twitter"></i>
	<?php } ?>
	<p>ようこそ！Twitter Botへ！</p>
	<p>下のボタンを押せば、twitterへとリンクが飛び、ログインできるようになります！</p>
	<p>是非お使いください。</p>
	<?php for ($i=0; $i < 12; $i++) { ?>
		<i class="fa fa-twitter"></i>
	<?php } ?>
</div>


<?php echo $this->Form->create('Twitters',array('action'=>'redirect_twitter'));?>
<?php echo $this->Form->end(__('Twitter で Login'), array('class' => 'btn btn-primary'));?>

<p class="well text-danger lead">ふぉおおおおっっふぉっふぉっっふぉ！</p>