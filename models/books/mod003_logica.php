 <?php
	// mod003_logica.php
	require "models/books/mod002_accesoadatos.php";

	function mod003_getBooksPagination( $firstItem, $itemsPerPage ) {
		$books = mod002_getBooksPagination( $firstItem, $itemsPerPage );
		if ($books[ "status" ][ "codError" ] === "000" ){
			foreach ($books["data"] as &$book) {
				// Shorten summary to 80 chars
				if (strlen($book["summary"]) > 80) {
					$book["summary"] = substr($book["summary"], 0, 80) . "...";
				}
				// Format date
				if (!empty($book["first_publication_date"])) {
					$book["first_publication_date"] = date(
						"d F Y",
						strtotime($book["first_publication_date"])
					);
				}
				
			}
		}
		return $books;
	}

	function mod003_getTotalBooks() {
		$totalBooks = mod002_getTotalBooks();
		// todo: return full array, handle error in presentation layer
 		return $totalBooks[ "data" ][ 0 ][ "totalBooks" ];
	}

	function mod003_getBookDetail($book_id) {
		$book = mod002_getBookByID($book_id);
		$authors = mod002_getBookAuthors($book_id);

		// Format date
		if ($authors[ "status" ][ "codError" ] === "000" ){
			if (!empty($book["data"][0]["first_publication_date"])) {
				$book["data"][0]["first_publication_date"] = date(
					"d F Y",
					strtotime($book["data"][0]["first_publication_date"])
				);
			}
		}
		return [
			"authors" => $authors,
			"book" => $book
		];
	}


?>
