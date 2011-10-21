<!-- JQuery -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>
	<script>
		$(function() {
			$(".rawxml").hide();
			$(".simplexml").hide();
			
			$("input[name='showdebug']").change(function() {
				var sel = $(this).val();
				
				switch (self) {
				   case "rawxml":
				      $(".simplexml").hide();
				      $(".rawxml").show();
				      break;
				   case "simplexml":
				      $(".rawxml").hide();
				      $(".simplexml").show();
				      break;
				   default:
				      $(".rawxml").hide();
				      $(".simplexml").hide();
				      break;
				}
				
				if( sel == "none") {
				} else {
					$("." + sel).show();
					$("." + sel).show();
				}
			});
		});
	</script>
	</body>
</html>