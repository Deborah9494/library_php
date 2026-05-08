
<?php
	// mod001_kernel.php
	function mod001_conectoBD () {
		$direccion  = "localhost";
		$usuario    = "root";
		$contrasena = "";
		$database   = "books_v2";
		
		$link = mysqli_connect( $direccion, $usuario, $contrasena, $database );
		if ( !$link ) {
			echo "conexion fallida";
		} 
		
		return $link;
	}

	function mod001_desconectoBD ( $link ) {
		// Realizar la query de desconexión.
        mysqli_close( $link );
	}
?>
