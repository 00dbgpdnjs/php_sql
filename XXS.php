<!-- 오염된 데이터가 들어왔을 때(Cross-site scripting) 다른 사용자에게 노출되지 않게 하기 -->
<html>
    <body>
        <?php
        eho htmlspecialchars('<script>alert</script>');
        // 보안-escape: (임무로 부터 해제 시킨다) php에서 꺽새가 문법적인 역할을 못하게 하고 문자 그래도 나타내기 
        ?>
    </body>
</html>