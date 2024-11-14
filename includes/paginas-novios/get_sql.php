<?php
/* SQL Novies */
$sql = 'SELECT * FROM admin_bodas.data_novie WHERE id_novie = ? AND id_idioma = ?;';
$stmt = $con->prepare($sql);
$stmt->bind_param("ii", $id_novie, $id_idioma);
$stmt->execute();
$result = $stmt->get_result();
$array_novie = array();
while ($req = $result->fetch_array(MYSQLI_ASSOC)) {
    $array_novie = $req;
}
$stmt->close();
/* SQL Mesa de regalos */
$sql = 'SELECT titulo, descripcion, enlace FROM admin_bodas.mesa_regalos WHERE id_novie = ? AND id_idioma = ? AND activo = 1;';
$stmt = $con->prepare($sql);
$stmt->bind_param("ii", $id_novie, $id_idioma);
$stmt->execute();
$result = $stmt->get_result();
$array_mesa = array();
while ($req = $result->fetch_array(MYSQLI_ASSOC)) {
	$array_mesa[] = $req;
}
$stmt->close();
/* SQL Ceremonias */
$sql = 'SELECT * FROM admin_bodas.data_ceremonia WHERE id_novie = ? AND id_idioma = ?;';
$stmt = $con->prepare($sql);
$stmt->bind_param("ii", $id_novie, $id_idioma);
$stmt->execute();
$result = $stmt->get_result();
$array_ceremonia = array();
while ($req = $result->fetch_array(MYSQLI_ASSOC)) {
	$array_ceremonia[] = $req;
}
$stmt->close();
/* SQL Tarifas */
$sql = 'SELECT * FROM admin_bodas.data_habitacion WHERE id_novie = ? AND id_idioma = ?';
$stmt = $con->prepare($sql);
$stmt->bind_param("ii", $id_novie, $id_idioma);
$stmt->execute();
$result = $stmt->get_result();
$array_habitacion = array();
while ($req = $result->fetch_array(MYSQLI_ASSOC)) {
	$array_habitacion[] = $req;
}
$stmt->close();
/* SQL Comentarios */
$sql = 'SELECT * FROM admin_bodas.comentarios WHERE id_novie = ? AND activo = 1';
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id_novie);
$stmt->execute();
$result = $stmt->get_result();
$array_data = array();
while ($req = $result->fetch_array(MYSQLI_ASSOC)) {
	$array_data[] = $req;
}
$stmt->close();
$comentarios = array();
for ($i = 0; $i < count($array_data); $i++) {
	$comentarios[] = [$array_data[$i]['nombre'],$array_data[$i]['mensaje']];
}
?>