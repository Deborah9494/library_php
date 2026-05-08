 <?php
	// mod003_logica.php
	require "models/authors/mod002_accesoadatos.php";

	function mod003_getAuthorsPagination( $firstItem, $itemsPerPage ) {
		$arDataAuthors = mod002_getAuthorsPagination( $firstItem, $itemsPerPage );
		if ($arDataAuthors[ "status" ][ "codError" ] === "000" ){
			$authors = $arDataAuthors["data"];
			// var_dump($authors);
			foreach ($authors as &$author) {
				// Shorten summary to 60 chars
				if (strlen($author["summary"]) > 60) {
					$author["summary"] = substr($author["summary"], 0, 60) . "...";
				}
			}
		}
		return $arDataAuthors;
	}
	
	function mod003_getTotalAuthors() {
		$totalAuthors = mod002_getTotalAuthors();
		// todo: return full array, handle error in presentation layer
		return $totalAuthors["data"][0]["totalAuthors"];
	}

	function mod003_getAuthorDetail($author_id) {
		$author = mod002_getAuthorsByID($author_id);
		$books = mod002_getBooksByAuthorID($author_id);

		if ($books[ "status" ][ "codError" ] === "000" ){
			foreach ($books["data"] as &$book) {
				// Shorten summary
				if (strlen($book["summary"]) > 230) {
					$book["summary"] = substr($book["summary"], 0, 226) . "...";
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

		return [
			"author" => $author,
			"books" => $books
		];
	}
?>
