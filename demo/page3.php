<?php require_once 'header.php'; ?>

	<h3>いいね数に関する応用</h3>
	<h4>最もいいね数が多いページのURLを取得する</h4>
	<p>
		getRank関数を使うことでいいね数が多いページのURLを取得することができます。
		引数を空にすると最もいいね数が多いページのURLを返します。<br>
		最もいいね数が多いページのURLは<?php echo $goodBtn->getRank(); ?>です。<br>
	</p>
	<pre><code>最もいいね数が多いページのURLは&lt;?php echo $goodBtn-&gt;getRank(); ?&gt;です。</code></pre>

	<h4>いいね数が多いページを順位で取得する</h4>
	<p>
		getRank関数を使うことでいいね数が多いページのURLを取得することができます。
		引数に数値を入れるとその順位に対応したURLを返します<br>
	</p>
	<ul>
		【いいね数が多いページランキング】
		<li>1位:<?php echo $goodBtn->getRank(1) ?></li>
		<li>2位:<?php echo $goodBtn->getRank(2) ?></li>
		<li>3位:<?php echo $goodBtn->getRank(3) ?></li>
	</ul>

	<p>
		一度も開かれていないページ、存在しないページ、存在しない順位（5ページしか記録されていないのに10を指定をするなど）をしてしまうとundefindを返します。
	</p>

<pre><code>&lt;ul&gt;
	いいね数が多いページランキング
	&lt;li&gt;1位:&lt;?php echo $goodBtn-&gt;getRank(1) ?&gt;&lt;/li&gt;
	&lt;li&gt;2位:&lt;?php echo $goodBtn-&gt;getRank(2) ?&gt;&lt;/li&gt;
	&lt;li&gt;3位:&lt;?php echo $goodBtn-&gt;getRank(3) ?&gt;&lt;/li&gt;
&lt;/ul&gt;
</code></pre>

	<p>
		URLが返されるため、そのままリンクに使うことも可能です。<br>
		ただし、undefinedが返されたときリンクの中に入ってしまって気づきにくいので注意してください。
	</p>
	<p><a href="<?php echo $goodBtn->getRank(3); ?>">3番目にいいね数が多いページ</a></p>
<pre><code>&lt;p&gt;&lt;a href=&quot;&lt;?php echo $goodBtn-&gt;getRank(3); ?&gt;&quot;&gt;3番目にいいね数が多いページ&lt;/a&gt;&lt;/p&gt;</code></pre>


	<p>
		実用的にランキングを表示するならこんな感じにするとよいかと思います。
	</p>
	<ul>
		<?php	$url = $goodBtn->getRank(1); $count = $goodBtn->getCount($url);?>
		<li>1位:<a href="<?php echo $url;?>">作品名○○</a> <?php echo $count ?>件のいいね</li>
		<?php	$url = $goodBtn->getRank(2); $count = $goodBtn->getCount($url);?>
		<li>2位:<a href="<?php echo $url;?>">作品名○○</a> <?php echo $count ?>件のいいね</li>
		<?php	$url = $goodBtn->getRank(3); $count = $goodBtn->getCount($url);?>
		<li>3位:<a href="<?php echo $url;?>">作品名○○</a> <?php echo $count ?>件のいいね</li>
	</ul>

<pre><code>&lt;ul&gt;
	&lt;?php	$url = $goodBtn-&gt;getRank(1); $count = $goodBtn-&gt;getCount($url);?&gt;
	&lt;li&gt;1位:&lt;a href=&quot;&lt;?php echo $url;?&gt;&quot;&gt;作品名○○&lt;/a&gt; &lt;?php echo $count ?&gt;件のいいね&lt;/li&gt;
	&lt;?php	$url = $goodBtn-&gt;getRank(2); $count = $goodBtn-&gt;getCount($url);?&gt;
	&lt;li&gt;2位:&lt;a href=&quot;&lt;?php echo $url;?&gt;&quot;&gt;作品名○○&lt;/a&gt; &lt;?php echo $count ?&gt;件のいいね&lt;/li&gt;
	&lt;?php	$url = $goodBtn-&gt;getRank(3); $count = $goodBtn-&gt;getCount($url);?&gt;
	&lt;li&gt;3位:&lt;a href=&quot;&lt;?php echo $url;?&gt;&quot;&gt;作品名○○&lt;/a&gt; &lt;?php echo $count ?&gt;件のいいね&lt;/li&gt;
&lt;/ul&gt;
</code></pre>


<h4>同じページのボタンを複数設置するのは非推奨</h4>

<p>
	同じページのボタンを複数設置することはできますが、常に同じ数値を表示させることはできません。注意してください。<br>
	ボタンが押されたとき、ページが再読込されたときにのみ同期します。
</p>

<?php for($i = 0; $i < 5; $i++): ?>
<div>
	<?php $url = "{$dir}/demo/page2.php"; ?>
	ページ3
	<?php $goodBtn->viewBtn($url); ?>
</div>
<?php endfor; ?>

<?php require_once 'footer.php'; ?>