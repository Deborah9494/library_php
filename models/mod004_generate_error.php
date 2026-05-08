<?php
	// mod004_generate_error.php
	function mod004_generateError($dataStatus) {
		$title = "Error";
		$html = "";
		if ( $dataStatus[ "codError" ] === "001" ) {
				$html .= "<h1>Error</h1>";
				$html .= "<p class='error'>Error <b>#{$dataStatus[ "codError" ]}</b>:<br>No hay datos</p>";
		} elseif ( $dataStatus[ "codError" ] === "002" ) {
			$html .= "<h1>Error</h1>";
			$html .= "<p class='error'>Error <b>#{$dataStatus[ "codError" ]}</b> en la query:<br>";
			$html .= "{$dataStatus[ "msgError" ]}</p>";
		}
		return [
				"title" => $title,
				"html" => $html
			];

	}


?>