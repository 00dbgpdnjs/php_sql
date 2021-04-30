<?php
$conn = mysqli_connect(
    'localhost', 
    'root', 
    'gpdnjs09', 
    'opentutorials2');

$sql = "SELECT * FROM topic";
$result = mysqli_query($conn, $sql);
$list = '';
while($row = mysqli_fetch_array($result)){
  $escaped_title = htmlspecialchars($row['title']);
  $list = $list."<li><a href=\"index.php?id={$row['id']}\">{$escaped_title}</a></li>";
} 
//fetch 가져오다 array 배열로
// id는 자동설정되니까 escaping안해도 되지만 titile은 사용자가 입력하니까 보안처리 해야됨
// 원래는 {$row['id']}\">{$row['title']}</a></li>"; 였음

$article = array(
  'title'=>'Welcome',
  'description'=>'Hello, web'
);
$update_link = '';
if(isset($_GET['id'])) {
  $filtered_id = mysqli_real_escape_string($conn, $_GET['id']);
  // filtering보안 - mysqli_real_escape_string 함수 :url에서 id값으로 sql명령어를 문자string으로 바꿈
  $sql = "SELECT * FROM topic WHERE id={$filtered_id}";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);
  $article['title'] = htmlspecialchars($row['title']);
  $article['description'] = htmlspecialchars($row['description']);

  $update_link ='<a href="update.php?id='.$_GET['id'].'">update</a>';
  // id값 안주면 web 페이지에도 update뜸. id값 없을 땐 빈칸으로 두고 ($update_link = '';) id값이 있으면 update가 나오게끔 조건절에 넣어줌
}
// isset라인: web링크는 아이디 값이 없어서 에러남. 아이디 값이 있는 경우에만 다음꺼 실행해라
// print_r($article);
// htmlspecialchars(): php escaping 보안 처리
// 사용자가 입력한 title과 desciptiton 값이 문법적인 못하게
// 웹에서 create해도 description에 자바스크립트 코드가 문자 자체로 출력됨. 직접 desciption에 자바스크립트 코드 넣어서 create 해보기
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>WEB</title>
</head>
<body>
    <h1><a href="index.php">WEB</a></h1>
    <ol>
      <?=$list?>
    </ol>
    <form action="process_update.php" method="POST">
      <input type="hidden" name="id" value="<?=$_GET['id']?>">
      <!-- 무엇을 업데이트 할지 -->
      <p><input type="text" name='title' placeholder="title" value="<?=$article['title']?>"></p>
      <p><textarea name="description" placeholder="description"><?=$article['description']?></textarea></p>
      <!-- update는 원래 글이 있어야 하니까 제목에 value값을 넣어주고 본문에도 -->
      <p><input type="submit"></p>
    </form>
</body>
</html>