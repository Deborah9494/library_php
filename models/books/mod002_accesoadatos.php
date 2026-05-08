 <?php
	// mod002_accesoadatos.php
	require "models/mod002_accesoadatos_execute_query.php";

	function mod002_getBooksPagination( $firstItem, $itemsPerPage ) {
		$attributes = [
			[ "book_id", "book_id", "int"],
			[ "book_name","book_name"],
			[ "shortsummary","summary"],
			[ "first_publication_date", "first_publication_date"],
			[ "isbn13", "isbn13"],
			[ "cover_image", "cover_image"]
		];
		$strSQL = "SELECT 
					`books`.`book_id`, 
					`books`.`book_name`, 
					`books`.`shortsummary`, 
					`books`.`first_publication_date`, 
					`books`.`isbn13`, 
					`books`.`cover_image`
		FROM `books`
		LIMIT $firstItem, $itemsPerPage
		";
		return mod002_executeQuery($strSQL, $attributes);
	}

	function mod002_getTotalBooks() {
		$attributes = [
			[ "totalBooks", "totalBooks", "int"]
		];
		$strSQL = "SELECT COUNT( * ) AS totalBooks
				   FROM `books`";
		return mod002_executeQuery($strSQL, $attributes);
	}

	function mod002_getBookByID($book_id) {
		$attributes = [
            [ "book_id", "book_id", "int"],
            [ "book_name","book_name"],
            [ "summary","summary"],
            [ "first_publication_date", "first_publication_date"],
			[ "isbn13", "isbn13"],
			[ "cover_image", "cover_image"]
        ];
		$strSQL = "SELECT 
					`books`.`book_id`, 
					`books`.`book_name`, 
					`books`.`summary`, 
					`books`.`first_publication_date`, 
					`books`.`isbn13`, 
					`books`.`cover_image`
					FROM `books`
					WHERE `books`.`book_id` = $book_id ";
		return mod002_executeQuery($strSQL, $attributes);
	}

	function mod002_getBookAuthors($book_id) {
		$attributes = [
            [ "author_id", "author_id", "int"],
            [ "full_name","full_name"]
        ];
		$strSQL = "SELECT 
					`authors`.`author_id`, 
					`authors`.`full_name`
				FROM `books`
				INNER JOIN `books_authors` 
					ON `books`.`book_id` = `books_authors`.`book_id`
				INNER JOIN `authors` 
					ON `authors`.`author_id` = `books_authors`.`author_id`
				WHERE `books`.`book_id` = $book_id ";
		
		return mod002_executeQuery($strSQL, $attributes);
	}
?>