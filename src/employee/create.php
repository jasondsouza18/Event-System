<?php

/**
 * @param PDO $conn
 * @param $data
 * @return array
 */
function insertEmployee(PDO $conn, $data)
{
    $employees = array();
    $events = array();
    foreach ($data as $row) {
        $employees[] = '("' . $row['employee_name'] . '", "' . $row['employee_mail'] . '",now(),now())';
        $events[$row['event_id']] = [$row['event_name'], $row['event_date']];
    }

    //creates a set of 50 records and flushes
    $result = ['status' => false, 'message' => "", "event" => $events];
    try {
        $records = $conn->prepare('REPLACE INTO employee (name, email, created_at, updated_at) VALUES ' . implode(',', $employees));
        $result['status'] = $records->execute();
    } catch (\Exception $exception) {
        $result['message'] = sprintf("Error occurred: %s", $exception->getMessage());
    }
    return $result;
}

