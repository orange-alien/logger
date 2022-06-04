## 動作確認の方法
* 現状、登録・編集・削除などを実行できる画面は用意していないので、tinker にて動作確認する

### 以下の流れで新規登録・更新・論理削除・リストア・物理削除を確認可能(ログに変更前後の値が出力される)

```
# tinker 起動
$ php artisan tinker

# 新規作成
>>> use \App\Models\User;
>>> $user = new User();
>>> $user->name = "tarou";
>>> $user->email = "tarou@example.com";
>>> $user->password = "passowrd";
>>> $user->save();

# 更新
>>> $user->email = "tarou_2@example.net";
>>> $user->name = "yamada tarou";
>>> $user->save();

# 論理削除
>>> $user->delete();

# リストア
>>> $user->restore();

# 物理削除
>>> $user->forceDelete();


>>> exit

```
