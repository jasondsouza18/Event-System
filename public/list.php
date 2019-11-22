<?php

require __DIR__ . '/../src/dbConnection.php';
require __DIR__ . '/../src/twig.php';

try {
    //listing the requirement
    $result = getData($conn, $_GET);
    $result = array_merge($_GET, ['data' => $result['data']]);
    echo $twig->render('list.twig', $result);
} catch (\Exception $exception) {
    die(sprintf("Error occurred: %s", $exception->getMessage()));
}

/**
 * @param PDO $conn
 * @return array
 */
function getData(PDO $conn, $data)
{
    $query = "";
    $result = ['status' => false, 'message' => ""];
    try {
        $query = getSearchQuery($_GET, $query);
        $records = $conn->prepare('SELECT e.name as name, ev.name as evname, p.fee,ev.event_date from employee e, event ev, participation p where p.event_id = ev.id and p.employee_id = e.id' . $query);
        $records->execute();
        $data = $records->fetchAll(PDO::FETCH_ASSOC);
        if (($data !== false) && (count($data) > 0)) {
            $result['status'] = true;
            $result['data'] = $data;
        }
    } catch (\Exception $exception) {
        $result['message'] = sprintf("Error occurred: %s", $exception->getMessage());
    }
    return $result;
}

/**
 * @param $data
 * @param $query
 * @return string
 */
function getSearchQuery($data)
{
    $sql_where = [];
    $data['ename'] != "" ? array_push($sql_where, " AND e.name like '%" . $data['ename'] . "%'") : null;
    $data['evname'] != "" ? array_push($sql_where, " AND ev.name like '%" . $data['evname'] . "%'") : null;
    $data['evdate'] != "" ? array_push($sql_where, " AND ev.event_date='" . $data['evdate'] . "'") : null;
    return implode(" ", $sql_where);
}
