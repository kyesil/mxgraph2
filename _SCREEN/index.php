<?php
require  '_boot.php';
?>


<!DOCTYPE html>
<html>

<head>
	<title>Screen Editor</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<script type="text/javascript">
		// Parses URL parameters. Supported parameters are:
		// - lang=xy: Specifies the language of the user interface.
		// - touch=1: Enables a touch-style user interface.
		// - storage=local: Enables HTML5 local storage.
		// - chrome=0: Chromeless mode.
		var urlParams = (function(url) {
			var result = new Object();
			var idx = url.lastIndexOf('?');

			if (idx > 0) {
				var params = url.substring(idx + 1).split('&');

				for (var i = 0; i < params.length; i++) {
					idx = params[i].indexOf('=');

					if (idx > 0) {
						result[params[i].substring(0, idx)] = params[i].substring(idx + 1);
					}
				}
			}

			return result;
		})(window.location.href);
	</script>
	<style>
	</style>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="/R/css/shared.css" rel="stylesheet" type="text/css">
	<link href="r/main.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div id="app">
		<div class="header">
			<div class="menu" onclick="backClick(0);" v-if="vpage!=='screens'">
				<p>Back</p>
				<div class="icon fa fa-arrow-alt-circle-left"></div>
			</div>
			<div class="menu" onclick="addClick(0);" v-if="vpage==='screens'||vpage==='pages'">
				<p>Add</p>
				<div class="icon fa fa-folder-plus"></div>
			</div>
			<div class="menu" onclick="refreshClick(0);" v-if="vpage==='screens'||vpage==='pages'">
				<p>Refresh</p>
				<div class="icon fa fa-sync"></div>
			</div>
			<span v-html="vtitle"></span>
		</div>

		<div class="cards_wrap" id="screens_wrap" v-if="vpage==='screens'">
			<div v-for="sc in screens" v-bind:id="sc.id" class="card">
				<h4>{{sc.name}}</h4>
				<p class="pcount"><b>{{sc.spcount}}</b> pages</p>
				<p class="lcount"><b></b> linked nodes</p>
				<div class="icon fa fa-edit" v-on:click="scEditClick(sc.id,sc.name);"></div>
				<div class="icon fa fa-folder-open" v-on:click="scOpenClick(sc.id,sc.name);"></div>
			</div>
		</div>

		<div class="cards_wrap" id="pages_wrap" v-if="vpage==='pages'">
			<div v-for="pg in pages" v-bind:id="pg.id" class="card">
				<h4>{{pg.name}}</h4>
				<div class="icon fa fa-edit" v-on:click="pgEditClick(pg.id);"></div>
				<div class="icon fa fa-folder-open" v-on:click="pgOpenClick(pg.id);"></div>
			</div>
			<h1 v-if="pages.length===0">No pages</h1>
		</div>

		<div class="dialog" v-if="vpage==='addsc'||vpage==='addpg'">
			<h1 v-html="dtitle"></h1>
			<form>
				<div class="field"> <label >ID: </label> <input name=id type="text" disabled> </div>
				<div class="field"> <label >Screen ID: </label> <input name=sid type="text" disabled> </div>
				<div class="field"> <label >Name: </label> <input name=id type="text" > </div>
				<div class="field"> <label >Author Path: </label> <input name=authpath type="text" > </div>
				<div class="field"> <label >Type: </label> <input name=type type="text" > </div>
			</form>
		</div>

	</div>
	<script src="https://unpkg.com/vue/dist/vue.js"></script>
	<script type="text/javascript" src="r/main.js"></script>

</body>

</html>