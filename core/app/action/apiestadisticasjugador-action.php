<?php
header('Content-Type: application/json');

// 1) Reusa la conexión ya existente
$database = Database::getInstance();
$mysqli = $database->getConnection();

// 2) Validar entrada
if (isset($_POST['id_jugador']) && ctype_digit($_POST['id_jugador'])) {
  $idjug = (int)$_POST['id_jugador'];
} else {
  if (!isset($_POST['criterio'])|| !trim($_POST['criterio'])) {
    echo json_encode([ "success"=>false,"message"=>"Criterio vacío" ]);
    exit;
  }
$crit = $mysqli->real_escape_string(strtolower(trim($_POST['criterio'])));

// 3) Buscar jugador
$sql_j = "
    SELECT id, nombre, apellido1, apellido2, numlicencia, elo, equipo
      FROM jugador
     WHERE LOWER(CONCAT_WS(' ', nombre, apellido1, apellido2)) LIKE '%{$crit}%'
        OR LOWER(numlicencia) = '{$crit}'
     LIMIT 1
";
$rj = $mysqli->query($sql_j);
if (!$rj) {
    echo json_encode([
        "success" => false,
        "message" => "Error en consulta de jugador",
        "sql"     => $sql_j
    ]);
    exit;
}
if ($rj->num_rows === 0) {
    echo json_encode([
        "success" => false,
        "message" => "Jugador no encontrado",
        "sql"     => $sql_j
    ]);
    exit;
}
$jug   = $rj->fetch_assoc();
$idjug = (int)$jug['id'];

// 4) Obtener partidas (oficiales + personalizadas)
$sql_p = "
SELECT
  a.id AS acta_id,

  -- Fecha: oficial o de sala personalizada
  COALESCE(
    DATE_FORMAT(e.fecha_encuentro,  '%d-%m-%Y'),
    DATE_FORMAT(ep.fecha_programada, '%d-%m-%Y'),
    CONCAT('Sala ', a.sala_personalizada)
  ) AS fecha,

  -- Mesa: tablero oficial o el número de mesa de la sala personalizada
  COALESCE(a.tablero, ep.mesa) AS mesa,

  a.resultado AS my_result,

  -- Color calculado según oficial o personalizada
  CASE
    -- Oficial: usamos e.equipo_local / e.equipo_visitante
    WHEN a.sala_personalizada IS NULL THEN
      CASE
        WHEN MOD(a.tablero,2)=1 AND a.equipo = e.equipo_local     THEN 'Blancas'
        WHEN MOD(a.tablero,2)=0 AND a.equipo = e.equipo_local     THEN 'Negras'
        WHEN MOD(a.tablero,2)=1 AND a.equipo = e.equipo_visitante THEN 'Negras'
        ELSE                                                    'Blancas'
      END
    -- Personalizada: usamos ep.equipo_local / ep.equipo_visitante
    ELSE
      CASE
        WHEN MOD(a.tablero,2)=1 AND a.equipo = ep.equipo_local     THEN 'Blancas'
        WHEN MOD(a.tablero,2)=0 AND a.equipo = ep.equipo_local     THEN 'Negras'
        WHEN MOD(a.tablero,2)=1 AND a.equipo = ep.equipo_visitante THEN 'Negras'
        ELSE                                                    'Blancas'
      END
  END AS color,

  a.rival_acta AS rival_acta_id,

  jr.id AS rival_id,
  CONCAT_WS(' ', jr.nombre, jr.apellido1, jr.apellido2) AS rival_nombre,
  er.nombre AS rival_team,
  jr.elo    AS rival_elo

FROM acta AS a

  -- Encuentros oficiales
  LEFT JOIN encuentros               AS e  ON a.encuentro_id      = e.id
  -- Encuentros personalizados
  LEFT JOIN encuentros_personalizados AS ep ON a.encuentro_pers_id = ep.id

  LEFT JOIN acta    AS opp ON opp.id      = a.rival_acta
  LEFT JOIN jugador AS jr  ON jr.id       = opp.jugador
  LEFT JOIN equipo  AS er  ON er.id       = opp.equipo

WHERE a.jugador     = {$idjug}
  AND a.resultado  NOT IN ('', '+')

ORDER BY
  -- Primero oficiales por fecha, luego salas
  CASE WHEN a.sala_personalizada IS NULL THEN 0 ELSE 1 END,
  COALESCE(e.fecha_encuentro, ep.fecha_programada, a.sala_personalizada),
  COALESCE(a.tablero, ep.mesa)
";
$rp = $mysqli->query($sql_p);
if (!$rp) {
    echo json_encode([
        "success" => false,
        "message" => "Error en consulta de partidas",
        "sql"     => $sql_p
    ]);
    exit;
}

// 5) Calcular porcentajes y armar array de rivales
$puntos  = $total = $blancas = $bl_pts = $negras = $neg_pts = 0;
$det     = [];

while ($f = $rp->fetch_assoc()) {
    // 5.1) Puntos obtenidos (1, 1/2 o 0)
    $pts = ($f['my_result'] === '1'
          ? 1
          : (($f['my_result'] === '1/2' || $f['my_result'] === '½')
              ? 0.5
              : 0)
    );

    $puntos += $pts;
    $total++;

    // 5.2) Contabilizar por color
    if ($f['color'] === 'Blancas') {
        $blancas++; $bl_pts += $pts;
    } else {
        $negras++;  $neg_pts += $pts;
    }

    $det[] = [
      "acta_id"      => (int) $f['acta_id'],
      "fecha"        => $f['fecha'],
      "mesa"         => (int) $f['mesa'],
      "resultado"    => $f['my_result'],
      "color"        => $f['color'],
      "rival_id"     => (int) $f['rival_id'],
      "rival_nombre" => $f['rival_nombre'],
      "rival_team"   => $f['rival_team'],
      "rival_elo"    => (int) $f['rival_elo']
    ];
}

// 6) Devolver JSON
echo json_encode([
  "success"      => true,
  "jugador"      => trim("{$jug['nombre']} {$jug['apellido1']} {$jug['apellido2']}"),
  "licencia"     => $jug['numlicencia'],
  "elo"          => $jug['elo'],
  "total"        => $total   ? round($puntos  / $total   * 100, 1) : 0,
  "blancas"      => $blancas ? round($bl_pts  / $blancas * 100, 1) : 0,
  "negras"       => $negras  ? round($neg_pts / $negras  * 100, 1) : 0,
  "rivales"      => $det,
  "sql_jugador"  => $sql_j,
  "sql_partidas" => $sql_p
]);
