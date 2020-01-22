<?php require_once 'header.php'; ?>

	<h3>ファイルの使い方</h3>
	<h4>サーバにアップ</h4>
	<p>
		解凍したgoodbtnフォルダをサーバにアップロードします。<br>
		今回の説明ではhttps://example.com/にアップロードし、「https://example.com/goodbtn」という状態になったとします。<br>
	</p>
	<h4>ソースをコピペ</h4>
	<p>
		以下の記述をページのDOCTYPE宣言よりも上にコピペします。
<pre><code>&lt;?php
$dir = &quot;/goodbtn&quot;; //フォルダのパス
require_once $_SERVER[&#039;DOCUMENT_ROOT&#039;] . $dir .&#039;/GoodBtn.php&#039;;
$goodBtn = new GoodBtn($dir);
?&gt;
</code></pre>
	</p>
	<p>
		以下の記述を必要に応じてhead内にコピペします。<br>
		jQueryのみが必要ならjQueryのみ、FontAwesomeのみ必要ならFontAwesomeのみコピペしてください。<br>
		どちらも不要ならコピペする必要はありません。<br>
		<pre><code>&lt;script src=&quot;https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js&quot;&gt;&lt;/script&gt;
&lt;link rel=&quot;stylesheet&quot; href=&quot;https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css&quot;&gt;
</code></pre>
	</p>
	<p>
		以下の記述をページのheadタグの中にコピペします。
		<pre><code>&lt;?php $goodBtn-&gt;head(); ?&gt;</code></pre>
	</p>

	<p>
		ボタンを使う準備はこれで終わりです。
	</p>


	<h3>ボタンの使い方</h3>

	<h4>ボタンを設置する</h4>

	<p>
		ボタンを設置したい箇所にこれをコピペします。
<pre><code>&lt;?php $goodBtn-&gt;viewBtn(); ?&gt;</code></pre>
</p>

	<p>こんな感じになります。押すと増えます</p>
	<?php $goodBtn->viewBtn(); ?>

	<h4>他のページのボタンを設置</h4>
	<p>
		引数に他のページのパスを入れると指定されたページのボタンを設置することができます。<br>
		ただし、一度も開かれていないページや、存在しないページのいいねボタンを設置するといいね数にundefindが入ります。
	</p>
	<p>
		ページ2のボタン
		<?php $goodBtn->viewBtn("{$dir}/demo/page1.php"); ?>
	</p>
	<p>
		ページ3のボタン
		<?php $goodBtn->viewBtn("{$dir}/demo/page3.php"); ?>
	</p>
<pre><code>&lt;p&gt;
	ページ2のボタン
	&lt;?php $goodBtn-&gt;viewBtn(&quot;/goodbtn/demo/page2.php&quot;); ?&gt;
&lt;/p&gt;
&lt;p&gt;
	ページ3のボタン
	&lt;?php $goodBtn-&gt;viewBtn(&quot;/goodbtn/demo/page3.php&quot;); ?&gt;
&lt;/p&gt;

</code></pre>
	<h4>現在開いているページのいいね数を取得する</h4>
	<p>
		getCount関数を使用することでいいね数を取得できます。<br>
		引数を空にすると今開いているページのいいね数が取得できます。例えば↑のハートマークの横に表示する数値に内部的に使っています。
		<pre><code>このページのいいね数は&lt;?php echo $goodBtn-&gt;getCount(); ?&gt;です。</code></pre>
	</p>

	<h4>他のページのいいね数を取得する</h4>
	<p>
				getCount関数の引数をURLにすればそのページのいいね数が取得できます。このとき、指定するURLはhttpやドメイン名を取り除いた絶対パスである必要があります。
		<pre><code>ページ2のいいね数は&lt;?php echo $goodBtn-&gt;getCount(&quot;/goodbtn/page2.php&quot;); ?&gt;です。</code></pre>
	</p>

	<ul>
		<li>ページ1のいいね数は<?php echo $goodBtn->getCount("{$dir}/demo/page1.php"); ?>です。</li>
		<li>ページ2のいいね数は<?php echo $goodBtn->getCount("{$dir}/demo/page2.php"); ?>です。</li>
		<li>ページ3のいいね数は<?php echo $goodBtn->getCount("{$dir}/demo/page3.php"); ?>です。</li>
		<li>ページ5555のいいね数は<?php echo $goodBtn->getCount("{$dir}/demo/page55555.php"); ?>です。</li>
	</ul>
	<p>
		存在しないページのURLを指定したり、一度も開かれていないページを指定した場合はundefinedを返します。
	</p>

	<p>
		エラーになる例
<pre><code>//http～から始めている
ページ3のいいね数は&lt;?php echo $goodBtn-&gt;getCount(&quot;https://example.com/goodbtn/page3.php&quot;); ?&gt;です。

//ドメイン名から始めている
ページ3のいいね数は&lt;?php echo $goodBtn-&gt;getCount(&quot;example.com/goodbtn/page3.php&quot;); ?&gt;です。

//頭にスラッシュをつけ忘れている
ページ3のいいね数は&lt;?php echo $goodBtn-&gt;getCount(&quot;goodbtn/page3.php&quot;); ?&gt;です。
</code></pre>
	</p>


<?php require_once 'footer.php'; ?>