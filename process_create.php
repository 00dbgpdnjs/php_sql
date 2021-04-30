<?php
$conn = mysqli_connect(
    'localhost', 
    'root', 
    'gpdnjs09', 
    'opentutorials2');

$filtered = array(
  'title'=>mysqli_real_escape_string($conn, $_POST['title']),
  'description'=>mysqli_real_escape_string($conn, $_POST['description']),
  'author_id'=>mysqli_real_escape_string($conn, $_POST['author_id'])
);

$sql = "
  INSERT INTO topic
    (title, description, created, author_id)
    VALUES(
        '{$_POST['title']}',
        '{$_POST['description']}',
        NOW(),
        {$filtered['author_id']}
    )
";
// []는 create.php에서 name 값에 해당
// $은 내가 임의로 지정한 변수. 하지만 통상적으로 저렇게 지정
// $_POST['title']: 방문자가 입력한 제목을 그대로 적용하면 안됌. 방문자가 제목에 해킹에 관한 코딩을 작성하면 그대로 실행됨.
// die($sql); : 실행하기 전에 실행한다면 어떤 코드가 실행되는지 코드로만 확인할 수 있는 웹페이지 나옴
$result = mysqli_query($conn, $sql);
if($result === false){
    echo '저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요';
    error_log(mysqli_error($conn));
} else {
  echo '성공했습니다. <a href="index.php">돌아가기</a>';
}
?>