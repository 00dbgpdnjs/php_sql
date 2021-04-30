<?php
$conn = mysqli_connect(
    'localhost', 
    'root', 
    'gpdnjs09', 
    'opentutorials2');
echo "<h1>single row</h1>";
$sql = "SELECT * FROM topic WHERE id = 10";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
echo '<h2>'.$row['title'].'</h2>';
echo $row['description'];

echo "<h1>multi row</h1>";
$sql = "SELECT * FROM topic";
$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_array($result)){
    echo '<h2>'.$row['title'].'</h2>';
    echo $row['description'];
}
// 반복적으로 실행되다가 가져올 데이터가 없으면 mysqli_fetch_array 은 null을 리턴하는데 php에서 null은 false로 치기 때문에 반복문이 끝나게됨. 
// var_dump(NULL == false) 해보면 알 수 있음. true가 나옴. ==는 비교 연산자. 양쪽이 같다면 참이됨