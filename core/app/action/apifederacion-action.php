<?php
if ($_GET['action'] == 'apifederacion') {
    // Start, length, and search for DataTables
    $start  = isset($_REQUEST['start'])  ? intval($_REQUEST['start'])  : 0;
    $length = isset($_REQUEST['length']) ? intval($_REQUEST['length']) : 10;
    $search = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';

    // 1) Count total (for pagination):
    //    We only want equipos WHERE estado IN (2,4) => (2=Enviado, 4=Rechazado).
    $sqlCount = "
        SELECT COUNT(*) AS total
          FROM equipo e
          JOIN club c ON e.club = c.id
          JOIN liga l ON e.liga = l.id
         WHERE e.estado IN (2, 4)
    ";

    // If DataTables search is non-empty, add a condition
    if (!empty($search)) {
        // Adjust as needed: searching by e.nombre or c.nombre, etc.
        $sqlCount .= " AND (e.nombre LIKE '%$search%' OR c.nombre LIKE '%$search%')";
    }

    // Execute the count query
    $countQuery   = Executor::doit($sqlCount);
    $countResult  = Model::one($countQuery[0], new EquipoData());
    $totalRecords = $countResult->total ?? 0; // Fallback if null

    // 2) Actual data query, returning only Enviado or Rechazado
    //    We'll SELECT e.nacimiento1, e.nacimiento2, plus do LEFT JOIN on usuario for capitan/subcapitan
    $sqlData = "
        SELECT
            e.id,
            e.nombre AS nombre,           -- 'Equipo'
            l.nombre AS ligas,           -- 'Liga'
            c.nombre AS clubes,          -- 'Club'
            e.estado,                    -- 'Estado'

            -- If 'capitan' is numeric, try to retrieve from 'usuario' table
            CASE 
                WHEN e.capitan REGEXP '^[0-9]+$' 
                     THEN CONCAT(u.nombre, ' ', u.apellido)
                     ELSE e.capitan
            END AS capitanes,

            e.nacimiento1,  -- This is the date-of-birth for the capitan
            
            CASE
                WHEN e.subcapitan REGEXP '^[0-9]+$' 
                     THEN CONCAT(us.nombre, ' ', us.apellido)
                     ELSE e.subcapitan
            END AS subcapitanes,

            e.nacimiento2   -- This is the date-of-birth for the subcapitan

        FROM equipo e
        JOIN club c      ON e.club = c.id
        JOIN liga l      ON e.liga = l.id
        LEFT JOIN usuario u  ON e.capitan    = u.id
        LEFT JOIN usuario us ON e.subcapitan = us.id
        WHERE e.estado IN (2, 4)
    ";

    // Add search conditions if needed
    if (!empty($search)) {
        $sqlData .= " AND (e.nombre LIKE '%$search%' OR c.nombre LIKE '%$search%')";
    }

    // Sort & paginate
    $sqlData .= " ORDER BY e.id DESC 
                  LIMIT $start, $length";

    // Execute
    $dataQuery = Executor::doit($sqlData);
    $rows = Model::many($dataQuery[0], new EquipoData());

    // If you want exact "filtered" count vs. "total", you can replicate the logic with a second query;
    // or just use $totalRecords for both.
    $recordsFiltered = $totalRecords;

    // 3) Prepare JSON for DataTables
    $response = array(
        "draw"            => intval($_REQUEST['draw'] ?? 0),
        "recordsTotal"    => $totalRecords,
        "recordsFiltered" => $recordsFiltered,
        "data"            => $rows
    );

    // Return JSON
    echo json_encode($response);
    exit;
}
?>
