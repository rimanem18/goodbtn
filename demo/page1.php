<?php require_once 'header.php'; ?>

<h3>概要</h3>

<p>
	このソースは簡単にいいねボタンが設置できるプログラムです。
</p>
<p>
	いいね数はボタンが押されるたびにjsonファイルに記録されていくため、データベースを必要としません。<br>
	いいね数はURLに対して増加していきます。そのため、同一のページにある複数のコンテンツに対していいねをつけることはできません。
</p>

<p>
	<?php $goodBtn->viewBtn("{$dir}/demo/page1.php"); ?>
	<?php $goodBtn->viewBtn("{$dir}/demo/page2.php"); ?>
	<?php $goodBtn->viewBtn("{$dir}/demo/page3.php"); ?>
</p>

<?php require_once 'footer.php'; ?>