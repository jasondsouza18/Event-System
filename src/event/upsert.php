<?php

/**
 * @param PDO $conn
 * @param $data
 * @return array
 */
function upsertEvent(PDO $conn, $data)
{
    $events = array();
    foreach ($data as $row) {
        $eventDate = explode(" ", $row[1]);
        $events[] = '("' . $row['0'] . '","' . $eventDate[0] . '",now(),now())';
    }

    //upserts every set of 50 records
    $result = ['status' => false, 'message' => ""];
    try {
        $records = $conn->prepare('REPLACE INTO event (name, event_date, created_at, updated_at) VALUES ' . implode(',', $events));
        $result['status'] = $records->execute();
    } catch (\Exception $exception) {
        $result['message'] = sprintf("Error occurred: %s", $exception->getMessage());
    }
    return $result;
}

