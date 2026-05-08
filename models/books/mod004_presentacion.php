<?php
	// mod004_presentacion.php
	require "models/books/mod003_logica.php";
	require "models/mod004_generate_error.php";

	function mod004_getBooksPagination( $firstItem, $itemsPerPage ) {
		$data = mod003_getBooksPagination( $firstItem, $itemsPerPage );
		$title = "Libros";
		$html = "";
		if ($data[ "status" ][ "codError" ] === "000" ){
			$books_data = $data["data"];
			$html .= "<h1>Listado Libros</h1>";
			$html .= mod004_itemsPerPageOptions( $itemsPerPage, $firstItem );
			$html .= "<table id='books_table'>";
			$html .= "<thead><tr>
				<th>Name</th>
				<th>Short Summary</th>
				<th>Date</th>
			</tr></thead>";

			$html .= "<tbody>";

			foreach ( $books_data as $book ) {
				$html .= "<tr>"
							. "<td><a href='books.php?book_id=".$book["book_id"]."'>".$book["book_name"]."</a></td>"
							. "<td>".$book["summary"]."</td>"
							. "<td>".$book["first_publication_date"]."</td>"
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

	function mod004_itemsPerPageOptions( $currentItemsPerPage, $firstItem) {
		$options = [5, 10, 20, 50];
		$html = "<div class='itemsPerPageControl'><span>Mostrar: </span>";
		$html .= "<form method='GET' id='itemsPerPageForm'>";
		$html .= "<select id='itemsPerPageSelect' name='itemsPerPage' onchange='this.form.firstItem.value=0; this.form.submit();'>";
		foreach ( $options as $option ) {
			$selected = ($option == $currentItemsPerPage) ? "selected" : "";
			$html .= "<option value='$option' $selected>$option</option>";
		}
		$html .= "</select>";
		// Reset firstItem to 0 when changing items per page
		$html .= "<input type='hidden' name='firstItem' value='0'>";
		$html .= "</form><span>libros</span></div>";
		return $html;
	}

	function mod004_controlsPagination( $firstItem, $itemsPerPage ) {
		$totalBooks = mod003_getTotalBooks(); // todo: handle error in case totalBooks endpoint is not working, number or 0
		
		// Pagination controls
		$htmlControls = "";
		$htmlControls .= "<div class='pagination_container'>";
		
		// Showing from X to Y of Z books
		$htmlControls .= "<div class='pagination_info'>Mostrando " . ($firstItem + 1) . " a " . min($firstItem + $itemsPerPage, $totalBooks) . " de $totalBooks libros</div>";	

		$currentPage = floor($firstItem / $itemsPerPage) + 1;
		$totalPages = ceil($totalBooks / $itemsPerPage);
		
		$htmlControls .= "<div class='pagination_controls'>";
		// Previous button
		if ( $currentPage > 1 ) {
			$prevPage = $firstItem - $itemsPerPage;
			$htmlControls.= "<div class='control'> <a href='books.php?firstItem=$prevPage&itemsPerPage=$itemsPerPage'>Anterior</a> </div>";
		}else{
			$htmlControls.= "<div class='control disabled'>Anterior</div>";
		}

		// Page numbers
		for ( $i = 1; $i <= $totalPages; $i++ ) {
			$pageStartItem = ($i - 1) * $itemsPerPage;
			if ( $i == $currentPage ) {
				$htmlControls.= "<div class='control page_btn page_btn_current'>$i</div>";
			} else {
				$htmlControls.= "<div class='control page_btn'> <a href='books.php?firstItem=$pageStartItem&itemsPerPage=$itemsPerPage'>$i</a> </div>";
			}
		}

		// Next button
		if ( $currentPage < $totalPages ) {
			$nextPage = $firstItem + $itemsPerPage;
			$htmlControls.= "<div class='control'> <a href='books.php?firstItem=$nextPage&itemsPerPage=$itemsPerPage'>Siguiente</a> </div>";
		} else {
			$htmlControls.= "<div class='control disabled'>Siguiente</div>";
		}

		$htmlControls.= "</div>";
		$htmlControls.= "</div>";
		return $htmlControls;
	}

	function mod004_getBookDetail($book_id) {
		$data = mod003_getBookDetail($book_id);
		//var_dump($data);
		if ( $data["book"][ "status" ][ "codError" ] !== "000" ){
			return mod004_generateError($data["book"][ "status" ]);
		}elseif( $data["authors"][ "status" ][ "codError" ] !== "000" ){
			return mod004_generateError($data["authors"][ "status" ]);
		}else{
			$book =  $data["book"]["data"][0]; 
			$authors = $data["authors"]["data"];
			$html = "<div class='main_content'>";

			$html .= "<h1 class='detail_title'>" . $book["book_name"] . "</h1>";

			$html .= "<div class='detail_meta'>";
			$html .= "<span>" . $book["first_publication_date"] . "</span>";

			if (!empty($authors)) {
				$html .= " | <span>Author(s): ";

				$links = [];

				foreach ($authors as $a) {
					$links[] = "<a href='authors.php?author_id=".$a["author_id"]."'>"
								.$a["full_name"].
							"</a>";
				}

				$html .= implode(", ", $links);
				$html .= "</span>";
			}

			$html .= "</div>";

			$html .= "<div class='detail_image'>";
			$html .= "<img src='" . $book["cover_image"] . "' alt='" . $book["book_name"] . "'>";
			$html .= "</div>";

			$html .= "<div class='detail_body'>";
			$html .= "<p>" . $book["summary"] . "</p>";
			$html .= "</div>";

			$html .= "<div class='detail_footer'>";
			$html .= "<a href='books.php' class='btn back_btn'>← Back to books</a>";
			$html .= "</div>";

			$html .= "</div>";

			return [
				"title" => $book["book_name"],
				"html" => $html
			];
		}
	}

?>