(function(){ //他のjavascriptに干渉しないように無名関数で作ります。

	var jGoodBtn = $("button.good-btn");
	var rotate = 0;
	var path = goodbtn.path;

	// 外部オブジェクト変数
	// goodbtn.dir
	// goodbtn.jsonFilename
	// goodbtn.path

	jGoodBtn.on('click', function(){
		var jSelf = $(this);

		data = $(this).data("goodbtn-url");
		if(data != null){ //data属性がnullでなければpathにセット
			path = data;
			console.log(data);
		} else { //nullの場合現在のパスをセット
			path = goodbtn.path;
		}

		$.ajax({
			url: goodbtn.dir+"/good.php", //送信先
			type:'POST', //送信方法
			dataType: 'json', //受け取りデータの種類
			data:{
				'path' : path,
				'dir' : goodbtn.dir,
				'jsonFilename' : goodbtn.jsonFilename
			}
		})
		// Ajax通信が成功した時
		.done( function(data) {
//			console.log('通信成功');
			rotateBtn(jSelf);
			jSelf.find("span.good-count").text(data[path]);
//			console.log(data);
		})
		// Ajax通信が失敗した時
		.fail( function(data) {
//			console.log('通信失敗');
//			console.log(data);
		}) // ajax end

	}); // good click end

	function rotateBtn(jSelf){
		if(rotate == 360){
			rotate = 0;
		} else {
			rotate = 360;
		}
		jSelf.toggleClass('good-btn-rotate'); //クリックするたびにクラスが入れ替わる
	}

})();