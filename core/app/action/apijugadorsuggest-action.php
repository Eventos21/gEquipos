<?php
// core/app/action/apijugadorsuggest-action.php
header('Content-Type: application/json');

$mysqli = new mysqli("127.0.0.1", "root", "", "u362265027_chessmaster");
if ($mysqli->connect_errno) {
    echo json_encode([]);
    exit;
}

$term = isset($_GET['term']) ? strtolower(trim($_GET['term'])) : "";
if ($term === "") {
    echo json_encode([]);
    exit;
}
$esc = $mysqli->real_escape_string($term);

$sql = "
  SELECT id,
         CONCAT_WS(' ',
           nombre,
           IFNULL(apellido1,''), 
           IFNULL(apellido2,'')
         ) AS label
  FROM jugador
  WHERE LOWER(nombre)   LIKE '%{$esc}%'
     OR LOWER(apellido1) LIKE '%{$esc}%'
     OR LOWER(apellido2) LIKE '%{$esc}%'
     OR LOWER(numlicencia) LIKE '%{$esc}%'
  ORDER BY nombre ASC
  LIMIT 10
";
$res = $mysqli->query($sql);
$out = [];
while ($r = $res->fetch_assoc()) {
    $out[] = [
      "id"    => (int)$r['id'],
      "label" => $r['label'],
      "value" => $r['label']
    ];
}
echo json_encode($out);
