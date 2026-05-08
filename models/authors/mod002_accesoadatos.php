 <?php
	// mod002_accesoadatos.php
	require "models/mod002_accesoadatos_execute_query.php";

	function mod002_getAuthorsPagination($firstItem, $itemsPerPage) {
		$attributes = [
			[ "author_id", "author_id", "int"],
			[ "full_name","full_name"],
			[ "ISO3","ISO3"],
			[ "summary", "summary"]
		];
		$strSQL = "SELECT 
					`author_id`, 
					`full_name`, 
					`ISO3`, 
					`summary` 
					FROM `authors` 
					LIMIT $firstItem, $itemsPerPage
					";
		return mod002_executeQuery($strSQL, $attributes);
	} 
	
	function mod002_getTotalAuthors() {
		$attributes = [
			[ "totalAuthors", "totalAuthors", "int"]
		];
		$strSQL = "SELECT COUNT( * ) AS totalAuthors
				   FROM `authors`";
		return mod002_executeQuery($strSQL, $attributes);
	}


	function mod002_getAuthorsByID($author_id) {
		$attributes = [
            [ "author_id", "author_id", "int"],
            [ "full_name","full_name"],
            [ "ISO3","ISO3"],
            [ "summary", "summary"]
        ];
		$strSQL = "SELECT 
					`author_id`, 
					`full_name`, 
					`ISO3`, 
					`summary` 
					FROM `authors` 
					WHERE `author_id` = $author_id";
		return mod002_executeQuery($strSQL, $attributes);
	}

	function mod002_getBooksByAuthorID($author_id) {
		$attributes = [
            [ "book_id", "book_id", "int"],
            [ "book_name","book_name"],
            [ "isbn13","isbn13"],
            [ "first_publication_date", "first_publication_date"],
			[ "url_file", "url_file"],
			[ "cover_image", "cover_image"],
			[ "summary", "summary"]
        ];
		$strSQL = "SELECT 
					`books`.`book_id`, 
					`books`.`book_name`, 
					`books`.`isbn13`, 
					`books`.`first_publication_date`, 
					`books`.`url_file`, 
					`books`.`cover_image`, 
					`books`.`summary` 
					FROM `books`
					JOIN `books_authors` 
						ON `books`.`book_id` = `books_authors`.`book_id` 
					JOIN `authors` 
						ON `books_authors`.`author_id` = `authors`.`author_id`
					WHERE `authors`.`author_id` = $author_id";
		return mod002_executeQuery($strSQL, $attributes);
	}

	?>