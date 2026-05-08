<?php
	// mod004_presentacion.php
	require "models/authors/mod003_logica.php";
	require "models/mod004_generate_error.php";

	function mod004_getAuthorsPagination( $firstItem, $itemsPerPage ) {
		$data = mod003_getAuthorsPagination( $firstItem, $itemsPerPage );
		$title = "Autores";
		$html = "";
		if ($data[ "status" ][ "codError" ] === "000" ){
			$authors_data = $data["data"];
			$html .= "<h1>Listado Autores</h1>";
			$html .= "<table id='authors_table'>";
			$html .= "<thead><tr>
				<th>Full Name</th>
				<th>Country</th>
				<th>Summary</th>
			</tr></thead>";

			$html .= "<tbody>";

			foreach ( $authors_data as $author ) {
				$html .= "<tr>"
							. "<td><a href='authors.php?author_id=".$author["author_id"]."'>".$author["full_name"]."</a></td>"
							. "<td>".$author["ISO3"]."</td>"
							. "<td>".$author["summary"]."</td>"
							. "</tr>";
			}
			$html .= "</tbody></table>";
			$html .= mod004_controlsPagination( $firstItem, $itemsPerPage );
			return [
				"title" => $title,
				"html" => $html
			];
		} else {
			return mod004_generateError($data[ "status" ]);
		}
	}

	function mod004_controlsPagination( $firstItem, $itemsPerPage ) {
		$totalAuthors = mod003_getTotalAuthors(); // todo: handle error in case totalAuthors endpoint is not working, number or 0
		
		// Pagination controls
		$htmlControls = "";
		$htmlControls .= "<div class='pagination_container'>";
		
		// Showing from X to Y of Z books
		$htmlControls .= "<div class='pagination_info'>Mostrando " . ($firstItem + 1) . " a " . min($firstItem + $itemsPerPage, $totalAuthors) . " de $totalAuthors autores</div>";	

		$currentPage = floor($firstItem / $itemsPerPage) + 1;
		$totalPages = ceil($totalAuthors / $itemsPerPage);
		
		$htmlControls .= "<div class='pagination_controls'>";
		// Previous button
		if ( $currentPage > 1 ) {
			$prevPage = $firstItem - $itemsPerPage;
			$htmlControls.= "<div class='control'> <a href='authors.php?firstItem=$prevPage&itemsPerPage=$itemsPerPage'>Anterior</a> </div>";
		}else{
			$htmlControls.= "<div class='control disabled'>Anterior</div>";
		}

		// Page numbers
		for ( $i = 1; $i <= $totalPages; $i++ ) {
			$pageStartItem = ($i - 1) * $itemsPerPage;
			if ( $i == $currentPage ) {
				$htmlControls.= "<div class='control page_btn page_btn_current'>$i</div>";
			} else {
				$htmlControls.= "<div class='control page_btn'> <a href='authors.php?firstItem=$pageStartItem&itemsPerPage=$itemsPerPage'>$i</a> </div>";
			}
		}

		// Next button
		if ( $currentPage < $totalPages ) {
			$nextPage = $firstItem + $itemsPerPage;
			$htmlControls.= "<div class='control'> <a href='authors.php?firstItem=$nextPage&itemsPerPage=$itemsPerPage'>Siguiente</a> </div>";
		} else {
			$htmlControls.= "<div class='control disabled'>Siguiente</div>";
		}

		$htmlControls.= "</div>";
		$htmlControls.= "</div>";
		return $htmlControls;
	}

	function mod004_getAuthorDetail($author_id) {
		$data = mod003_getAuthorDetail($author_id);
		if ( $data["author"][ "status" ][ "codError" ] !== "000" ){
			return mod004_generateError($data["author"][ "status" ]);
		}elseif( $data["books"][ "status" ][ "codError" ] !== "000" ){
			return mod004_generateError($data["books"][ "status" ]);
		}else{
			//var_dump($data);
			$data_author = $data["author"]["data"][0];
			$data_books = $data["books"]["data"];
			$html = "<div class='main_content'>";
			$html .= "<h1 class='detail_title'>".$data_author["full_name"]."</h1>";

			$html .= "<div class='detail_meta'>";
			$html .= "<p><b>Summary: </b>".$data_author["summary"]."</p>";
			$html .= "</div>";

			$html .= "<div class='detail_footer'>";
			$html .= "<a href='authors.php' class='btn back_btn'>← Back to authors</a>";
			$html .= "</div>";

			$html .= "<h3>Books</h3>";
			
			$html .= "<div class='card_container'>";
			foreach ($data_books as $book) {
				$html.= "<div class='card'><a href='books.php?book_id=".$book["book_id"]."'>";
				$html.= "  <div class='card_inner'>";

				// FRONT (imagen completa)
				$html.= "      <div class='card_front'>";
				$html.= "          <img class='card_image_full' src='" . $book["cover_image"] . "' alt='" . $book["book_name"] . "'>";
				$html.= "          <div class='card_title_overlay'>" . $book["book_name"] . "</div>";
				$html.= "      </div>";

				// BACK (info)
				$html.= "      <div class='card_back'>";
				$html.= "          <h3>" . $book["book_name"] . "</h3>";
				$html.= "          <p class='date'>" . $book["first_publication_date"] . "</p>";
				$html.= "          <p>" . $book["summary"] . "</p>";
				$html.= "      </div>";

				$html.= "  </div>"; // card_inner
				$html.= "</a></div>"; // card
			}
			$html .= "</div>"; // card_container
			$html.= "</div>"; // main_content

			return [
				"title" => $data_author["full_name"],
				"html" => $html
			];
		}
	}

	

?>