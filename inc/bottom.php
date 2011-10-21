<!-- JQuery -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>
	<script>
		$(function() {
			$(".rawxml").hide();
			$(".simplexml").hide();
			
			$("input[name='showdebug']").change(function() {
				var sel = $(this).val();
				
				switch (sel) {
				   case "rawxml":
				      $(".simplexml").slideUp('fast', function() {
				          $(".rawxml").slideDown("slow");
				        });				      
				     break;
				   case "simplexml":
				      $(".rawxml").slideUp('fast', function() {
				          $(".simplexml").slideDown("slow");
				        });
				      break;
				   default:
				      $(".rawxml").slideUp('fast');
				      $(".simplexml").slideUp('fast');
				      break;
				}
			});
		});
	</script>
	</body>
</html>