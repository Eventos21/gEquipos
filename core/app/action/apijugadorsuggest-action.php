<?php
header('Content-Type: application/json');
$database = Database::getInstance();
$mysqli   = $database->getConnection();

if (!isset($_GET['term']) || strlen(trim($_GET['term']))<2) {
  echo json_encode([]);
  exit;
}
$term = $mysqli->real_escape_string(trim($_GET['term']));

$sql = "
  SELECT 
    id,
    CONCAT_WS(' ', nombre, apellido1, apellido2) AS label
  FROM jugador
  WHERE LOWER(CONCAT_WS(' ', nombre, apellido1, apellido2))
        LIKE LOWER('%{$term}%')
  LIMIT 10
";
$rs = $mysqli->query($sql);
$out = [];
while ($r = $rs->fetch_assoc()) {
  $out[] = [
    'label' => $r['label'],
    'value' => $r['id']
  ];
}
echo json_encode($out);
