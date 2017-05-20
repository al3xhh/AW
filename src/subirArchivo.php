<?php
			//atributo name
/*if ($_FILES['archivo']["error"] > 0){
	echo "Error: " . $_FILES['archivo']['error'] . "<br>";
}
else{
	echo "Nombre: " . $_FILES['archivo']['name'] . "<br>";
	echo "Tipo: " . $_FILES['archivo']['type'] . "<br>";
	echo "Tamaño: " . ($_FILES["archivo"]["size"] / 1024) . " kB<br>";
	echo "Carpeta temporal: " . $_FILES['archivo']['tmp_name'];
											//tmp_name -> carpeta temporal
	move_uploaded_file($_FILES['archivo']['tmp_name'],"songs/" . $_FILES['archivo']['name']);
}*/

$dir_subida = "../songs";

$fichero_subido = $dir_subida . basename($_FILES['archivo']['name']);
echo '<pre>';
if (move_uploaded_file($_FILES['archivo']['tmp_name'], $fichero_subido)) {
    echo "El fichero es válido y se subió con éxito.\n";
} else {
    echo "¡Posible ataque de subida de ficheros!\n";
}

echo 'Más información de depuración:';
print_r($_FILES);

print "</pre>";
?>