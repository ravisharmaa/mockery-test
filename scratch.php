<?php

$conn = new mysqli('localhost','root','','todo');

/*$sql = 'select note from tasks where id = ?';

$stmt = $conn->prepare($sql);

if(!$stmt) {
    throw new Exception($conn->getError());
}

$stmt->bind_param('i', $id);

$id = 2;

if(!$stmt->execute()) {
    return false;
}

$result = $stmt->get_result();

$tasks = [];
while ($data = $result->fetch_assoc()) {
    $tasks[] =  $data['note'];
}

$result->free();


*/

$sql = 'DELETE from tasks where id = ?';
$stmt = $conn->prepare($sql);
if(!$stmt) {
    throw new Exception($conn->getError());
}
$stmt->bind_param('i',$id);
$id = 2;

if(!$stmt->execute()){
    return false;
}
return true;

