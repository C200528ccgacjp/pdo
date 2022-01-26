<?php
require('functions.php');
session_start();
if($_SERVER['REQUEST_METHOD'] === 'POST'){
   if (!empty($_POST)) {
	 // エラー項目の確認
	    if ($_POST['name'] === '') {
 		     $error['name'] = 'blank';
	    }
	    if ($_POST['email'] === '') {
		     $error['email'] = 'blank';
	    }
	    if (strlen($_POST['password']) < 4) {
		     $error['password'] = 'length';
	    }
	    if ($_POST['password'] === '') {
		     $error['password'] = 'blank';
	    }
	    $fileName = $_FILES['image']['name'];
	    if (!empty($fileName)) {
		     $ext = substr($fileName, -3);
		     if ($ext != 'jpg' && $ext != 'gif') {
			      $error['image'] = 'type';
		     }
	    }
   }
	 // 入力エラーがなければ、次に重複アカウントのチェック
	 if (empty($error)) {
      $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
      $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
      $pasword = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
      $picture = htmlspecialchars($_POST['picture'], ENT_QUOTES, 'UTF-8');
      $dbh = db_conn();
      try{
/* (1) 実行するSQL文を用意する            */
		  $sql = "SELECT * FROM members WHERE email = '$email'";
          $stmt = $dbh->prepare($sql);
          $stmt->bindValue(':email', $email, PDO::PARAM_STR);
          $stmt->execute();
		  $record = $stmt->fetch();
/* (2) 条件判定を記述            */
              if($record > 0){
			  $error['email'] = 'duplicate';   // eメール重複エラー
		  }
      }catch (PDOException $e){
          echo($e->getMessage());
          die();
      }
	 }
	 if (empty($error)) {          // 何もエラーが無ければ画像をアップロードして次の画面に遷移
      // 画像をアップロードする
		  $image = date('YmdHis') . $_FILES['image']['name'];
		  move_uploaded_file($_FILES['image']['tmp_name'], './member_picture/' .$image);
		  $_SESSION['join'] = $_POST;
		  $_SESSION['join']['image'] = $image;
/* (3) 画面遷移の命令を記述        */
          header('Location: entry.php');
		  exit();
   }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
   if ($_GET['action'] === 'rewrite') {              // 修正（書き直し）
      $_POST = $_SESSION['join'];
      $error['rewrite'] = true;
   }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
   <meta charset="UTF-8">
	 <meta name="viewport" content="width=device-width, initial-scale=1.0">
	 <meta http-equiv="X-UA-Compatible" content="ie=edge">
	 <title>lesson</title>
	 <link rel="stylesheet" href="style.css" />
</head>
<body>
<div id="wrap">
   <div id="head">
        <h1>会員登録</h1>
   </div>
   <div id="content">
		  <p>次のフォームに必要事項をご記入ください。</p>
		  <form action="" method="POST" enctype="multipart/form-data">
		  <dl>
		     <dt>ニックネーム<span class="required">必須</span></dt>
		     <dd><input type="text" name="name" size="35" maxlength="255" value="<?php echo htmlspecialchars($_POST['name'], ENT_QUOTES); ?>"/>
			      <?php if ($error['name'] === 'blank'): ?>
			      <p class="error">* ニックネームを入力してください</p>
			      <?php endif; ?>
		     </dd>
         <dt>メールアドレス<span class="required">必須</span></dt>
		     <dd>
			      <input type="text" name="email" size="35" maxlength="255" value="<?php echo htmlspecialchars($_POST['email'], ENT_QUOTES); ?>"/>
            <?php if ($error['email'] === 'blank'): ?>
            <p class="error">* メールアドレスを入力してください</p>
            <?php endif; ?>
			      <?php if ($error['email'] === 'duplicate'): ?>
				    <p class="error">* 指定されたメールアドレスはすでに登録されています</p>
			      <?php endif; ?>
		     </dd>
		     <dt>パスワード<span class="required">必須</span></dt>
		     <dd>
			      <input type="password" name="password" size="10" maxlength="20" value="<?php echo htmlspecialchars($_POST['password'], ENT_QUOTES); ?>"/>
            <?php if ($error['password'] === 'blank'): ?>
				    <p class="error">* パスワードを入力してください</p>
			      <?php endif; ?>
			      <?php if ($error['password'] === 'length'): ?>
				    <p class="error">* パスワードは4文字以上で入力してください</p>
			      <?php endif; ?>
		     </dd>
		     <dt>写真など</dt>
		     <dd><input type="file" name="image" size="35" />
			      <?php if ($error['image'] === 'type'): ?>
			      <p class="error">* 写真などは「.gif」または「.jpg」の画像を指定してください
			      </p>
			      <?php endif; ?>
			      <?php if (!empty($error)): ?>
			      <p class="error">* 恐れ入りますが、画像を改めて指定してください</p>
			      <?php endif; ?>
		     </dd>
		  </dl>
		  <div><input type="submit" value="確認する" /></div>
		  </form>
   </div>
</div>
</body>
</html>
