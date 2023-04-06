<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Untitled Document</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
	<script>
		$(document).ready(function() {
			$("input[name=FCAMT]").change(function() {
				var a = $('input[id=CURRATE]').val();
				var b = $('input[name=FCAMT]').val();
				var totali = +b / +a;
				var total = +totali.toFixed(2);
				$("input[name=LCAMT]").val(total);
				console.log(total);
			});
		});
	</script>
	<script type="text/javascript">
		function showSubCat(str) {
			if (str == "") {
				document.getElementById("SHEAD").innerHTML = "";
				return;
			}

			if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else { // code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}


			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("showsheads").innerHTML = xmlhttp.responseText;
				}
			}

			xmlhttp.open("GET", "ajax_select_heads.php?q=" + str, true);
			xmlhttp.send();
		}
	</script>


</head>

<body>

	<select id="SHEAD" name="SHEAD" class="form-control" onChange="showSubCat(this.value);">
		<option value=""></option>
		<option value="1">1</option>

	</select>

	<div id="showsheads" class="input-group">
		<span class="input-group-addon">Cur</span>
		<input id="FCAMT" name="FCAMT" type="text" class="form-control" placeholder="Fc">
		<input id="CURRATE" name="CURRATE" type="hidden" value="250">
		<span class="input-group-addon">@ 250</span>
		<input id="LCAMT" name="LCAMT" type="text" class="form-control" placeholder="Lc">
		<span class="input-group-addon">Cur</span>
	</div>


</body>

</html>