 <?php
 	require "mod001_kernel.php";
 	// Función generalista que ejecuta una query y obtiene y 
    // transforma los datos de la query con el array $arAttributes.
    function mod002_executeQuery( $strSQL, $attributes ) {
        $link = mod001_conectoBD();
 		try {
			if ( $result = $link->query( $strSQL ) ) {
				if ( $result->num_rows !== 0) {
					$arRetorno[ "status" ][ "codError" ] = "000"; // Con datos.
					$arRetorno[ "status" ][ "numRows" ] = $result->num_rows;
					/* $arRetorno = [ 
						"status" => [
							"codError" 	=> "OK",
							"numRows"	=> 4
						],
                        "data" => [
							[...], [...], [...]
						]
					]; */
					$i = 0;
					while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
						foreach ( $attributes as $element) {
							if (isset($element[2])) {
								if ($element[2] === "bool") {
									$arRetorno["data"][$i][$element[1]] = (bool)$row[$element[0]];
								} else if ($element[2] === "int") {
									if ($row[$element[0]] !== null) {
										$arRetorno["data"][$i][$element[1]] = intval( $row[ $element[ 0 ] ] );
									} else {
										$arRetorno["data"][$i][$element[1]] = null;
									}
								}
							} else {
								$arRetorno["data"][$i][$element[1]] = $row[$element[0]];
							}
						}
						$i++;
					}
				} else {
					$arRetorno["status"]["codError"]    = "001"; // Sin datos.
					$arRetorno["status"]["strSQL"]      = $strSQL;
				}
			}
		} catch (mysqli_sql_exception $e) {
			// Guardar error en log
			error_log($e->getMessage());
			// Mostrar mensaje genérico
			//echo "Ha ocurrido un error. Inténtalo más tarde.";
			$arRetorno["status"]["codError"]        = "002"; // Error Query.
			$arRetorno["status"]["strSQL"]          = $strSQL;
			$arRetorno["status"]["msgError"]        = $e -> getMessage();
		}
        mod001_desconectoBD($link);
        return $arRetorno;
    }
?>