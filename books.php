<?php
	// books.php
	require "models/books/mod004_presentacion.php";

	if (isset($_GET["book_id"])) {
		// show detail of the books
		$book_id = $_GET["book_id"];
		$html = mod004_getBookDetail($book_id);
	} else {
		// show list of books
		if ( isset( $_GET[ "firstItem" ], $_GET[ "itemsPerPage" ]  ) ) {
			$firstItem = $_GET[ "firstItem" ];
			$itemsPerPage = $_GET[ "itemsPerPage" ];
		}else{
			$firstItem = "0";
			$itemsPerPage = "10";
			//header("Location: teams_Pagination.php?start=$offset&itemsPerPage=$itemsPerPage");
		}
		$html = mod004_getBooksPagination( $firstItem, $itemsPerPage );
	}

	require "views/view_books.php";


	



?>
