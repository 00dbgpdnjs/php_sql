<?php
$conn = mysqli_connect(
    'localhost', 
    'root', 
    'gpdnjs09', 
    'opentutorials2');

settype($_POST['id'], 'integer');
// id를 입력하면 정수만 처리함. id에 5bar이라고 쓰면 5라고 읽음. 그래서 아래 $filtered에서 보안 처리 mysqli_real_escape_string 안해도 되지만 그래도 나쁠 건 없으니까
$filtered = array(
  'id'=>mysqli_real_escape_string($conn, $_POST['id']),
  'name'=>mysqli_real_escape_string($conn, $_POST['name']),
  'profile'=>mysqli_real_escape_string($conn, $_POST['profile'])
);

$sql = "
  UPDATE author
    SET
      name = '{$filtered['name']}',
      profile = '{$filtered['profile']}'
    WHERE
      id = {$filtered['id']}
";
// []는 create.php에서 name 값에 해당
// $은 내가 임의로 지정한 변수. 하지만 통상적으로 저렇게 지정
// $_POST['title']: 방문자가 입력한 제목을 그대로 적용하면 안됌. 방문자가 제목에 해킹에 관한 코딩을 작성하면 그대로 실행됨.
// die($sql);
$result = mysqli_query($conn, $sql);
if($result === false){
    echo '저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요';
    error_log(mysqli_error($conn));
} else {
  header('Location: author.php?id='.$filtered['id']);
  // ('Location: author.php)만 해도 되지만 이왕이면 author.php에서 update한 id값으로 보내서 업데이트한 내용을 바로 볼 수 있도록
}
?>