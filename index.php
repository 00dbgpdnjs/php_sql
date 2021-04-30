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
$delete_link = '';
$author = '';
if(isset($_GET['id'])) {
  $filtered_id = mysqli_real_escape_string($conn, $_GET['id']);
  // filtering보안 - mysqli_real_escape_string 함수 :url에서 id값으로 sql명령어를 문자string으로 바꿈
  $sql = "SELECT * FROM topic LEFT JOIN author ON topic.author_id = author.id WHERE topic.id={$filtered_id}";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);
  // (참고1) print_r($row); : row에 어떤 값이 들어오는지;페이지 소스 보기에서 egoing이라는 name값이 필요
  $article['title'] = htmlspecialchars($row['title']);
  $article['description'] = htmlspecialchars($row['description']);
  $article['name'] = htmlspecialchars($row['name']);
  // 참고1
  $update_link ='<a href="update.php?id='.$_GET['id'].'">update</a>';
  $delete_link ='
    <form action="process_delete.php" method="post">
      <input type="hidden" name="id" value="'.$_GET['id'].'">
      <input type="submit" value="delete">
    </form>
  ';
  $author = "<p>by {$article['name']}</p>";
  // id값 안주면 web 페이지에도 update뜸. id값 없을 땐 빈칸으로 두고 ($update_link = '';) id값이 있으면 update가 나오게끔 조건절에 넣어줌
  //delete는 update 처럼 링크를 걸어주면 안됨. 링크 보내서 누군가가 클릭하면 없어지니까 form으로 하기
  //create나 update를 누르면 GET방식으로 인해 어떤 페이지로 가고 그 페이지에서 정보를 입력하고 submit을 하면 POST 방식으로 전송 즉, 어떤 정보가 있는 페이지로 갈 때는 url에 파라미터 값을 주므로써 접근하고, 생성 수정 삭제는 POST방식으로 은밀하게 전달 (링크로 처리x)
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
    <a href="author.php">author</a>
    <ol>
      <?=$list?>
    </ol>
    <p><a href="create.php">create</a></p>
    <?=$update_link?>
    <?=$delete_link?>
    <h2><?=$article['title']?></h2>
    <?=$article['description']?>
    <?=$author?>
</body>
</html>