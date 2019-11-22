<?php


function upsertParticipation(PDO $conn, $data)
{
    try {
        $participation = array();
        foreach ($data as $row) {
            $participation[] = '( SELECT e.id,ev.id, "' . $row['participation_fee'] . '", now(), now() from employee e,event ev where e.name = "' . $row['employee_name'] . '" and ev.name = "' . $row['event_name'] . '")';
        }

        $records = $conn->prepare('INSERT into participation (employee_id,event_id,fee ,created_at, updated_at) ' . implode(' UNION ALL ', $participation));
        $result['status'] = $records->execute();
    } catch (\Exception $exception) {
        $result['message'] = sprintf("Error occurred: %s", $exception->getMessage());
    }
    return $result;
}

