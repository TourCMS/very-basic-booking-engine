<!-- Debug -->
<div id="debug">
	<form>
		<label><input type="radio" name="showdebug" value="none" checked /> Hide debug info</label>
		<label><input type="radio" name="showdebug" value="simplexml" /> Show SimpleXML object</label>
		<label><input type="radio" name="showdebug" value="rawxml" /> Show raw XML</label>
	</form>
	<div class="simplexml"><pre><?php print_r($result); ?></pre></div>
	<div class="rawxml"><pre><?php 
		// Add indentation to XML output
		$dom = new DOMDocument('1.0');
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->loadXML($result->asXML());
		echo htmlspecialchars($dom->saveXML());
	 ?></pre></div>
</div>