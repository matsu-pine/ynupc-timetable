ynupc-timetable
===============
(a-1)xampp を C:\xampp\ にインストール
(a-2)timetables を C:\xampp\htdocs\ 下に置く
(b-1)C:\xampp\htdocs\timetables\app\Config\database.php の $default 配列(host, login, password, database)を適当に変更
(b-2)phpMyAdmin で上記 database.php を基にデータベースを作成（照合順序は utf8_unicode_ci）
(b-3)phpMyAdmin で上記 database.php を基にユーザを追加（グローバル特権はすべてチェック）
(c-1)コマンドプロンプトの場合以下を実行
(c-2)cd C:\xampp\htdocs\timetables\app\Console を実行
(c-3)cake schema -app /xampp/htdocs/timetables/app create を実行

「An Internal Error Has Occurred.」と表示される場合
(1)(b)の内容を確認
(2)作成したデータベースに必要なテーブルが無い場合(c)で作る（作れない場合(1)を確認）


C:\xampp\htdocs\timetables\app\Controller\TimetablesController.php の138行, 156行, 184行目の教室名を修正してください
