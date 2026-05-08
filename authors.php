<?php
	// authors.php
	require "models/authors/mod004_presentacion.php";

	if (isset($_GET["author_id"])) {
		// show detail of the author
		$author_id = $_GET["author_id"];
		$html = mod004_getAuthorDetail($author_id);
	} else {
		// show list of authors
		$firstItem = isset($_GET["firstItem"]) ? (int)$_GET["firstItem"] : 0;
		$itemsPerPage = isset($_GET["itemsPerPage"]) ? (int)$_GET["itemsPerPage"] : 10;
		$html = mod004_getAuthorsPagination($firstItem, $itemsPerPage);
	}


	require "views/view_authors.php";
?>
