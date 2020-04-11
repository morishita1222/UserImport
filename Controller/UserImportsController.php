<?php
class UserImportsController extends AppController {

  /**
  * クラス名
  *
  * @var string
  * @access public
  */
  public $name = 'UserImports';

  /**
  * コンポーネント
  *
  * @var array
  * @access public
  */
  /**
   * Model
   *
   * @var array
   */
  public $uses = ['SiteConfig', 'Content'];

  /**
   * コンポーネント
   *
   * @var array
   */
  public $components = ['BcAuth', 'Cookie', 'BcAuthConfigure'];

  /**
  * モデル
  *
  * @var array
  * @access public
  */

  /**
  *  一覧表示
  *
  * @param int $categoryId カテゴリID
  * @return void
  */
  public function admin_index(){
    $this->pageTitle = 'ユーザー情報CSVインポート画面';
  }

  public function admin_csv_up()
  {
    $filesPath = WWW_ROOT . 'files';
    $savePath = $filesPath . DS . 'user_import';
    $filePath = $savePath . DS . $_FILES["data"]["name"]["UserImport"]["csv"];
    if (move_uploaded_file($_FILES["data"]["tmp_name"]["UserImport"]["csv"], $filePath)) {
      chmod($filePath, 0644); // ファイルアップロード成功
    } else {
      // ファイルアップロード失敗
      $this->setMessage(__d('baser', 'アップロードに失敗しました。'), true);
      $this->redirect(['controller' => 'user_imports', 'action' => 'index']); 
    }
    $csv = file($filePath);
    unlink($filePath);
    // ヘッダーを切り取る.
    $csv_header = $csv[0];
    $csv_body = array_splice($csv, 1);
    $user_datas = [];
    $key1 = 'User';
    $userModel = ClassRegistry::init('User');
    $errors = [];
    foreach ($csv_body as $key => $row) {
      $line_count = count(str_getcsv($row));
      if ($line_count != 7) {
        CakeLog::write(LOG_USER_IMPORT, 'ヘッダー行と項目数が異なります。');
        $this->setMessage('ユーザー情報のインポートに失敗しました。ログを確認してください', true);
        $this->redirect(['controller' => 'user_imports', 'action' => 'index']);
      }
      $row_array = explode(',', $row);
      $user_data = [];
      $user_data['User']['name']          = $row_array[0];  // ユーザーアカウントID
      $user_data['User']['real_name_1']   = $row_array[1];   // 名字
      $user_data['User']['real_name_2']   = $row_array[2];   // 名前
      $user_data['User']['password']      = $row_array[3];
      $user_data['User']['nickname']      = $row_array[4];   // 名前
      $user_data['User']['email']         = $row_array[5];
      $user_data['User']['user_group_id'] = $row_array[6];
      
      $userModel->set($user_data);
      if ($userModel->validates()) {
        // 正しい場合のロジック
        $user_datas[$key] = $user_data;
      } else {
        // 正しくない場合のロジック
        $error = $userModel->validationErrors;
        $errors[$key] = $error;
      }
      CakeLog::write(LOG_USER_IMPORT, print_r($error, true));
    }
    if(!empty($errors)){
      $this->setMessage('ユーザー情報のインポートに失敗しました。ログを確認してください', true);
      $this->redirect(['controller' => 'user_imports', 'action' => 'index']);
    }
    else{
      // CakeLog::write(LOG_USER_IMPORT, print_r($user_datas, true));
      $userModel->saveAll($user_datas);
      $this->setMessage('ユーザー情報をインポートしました。');
      $this->redirect(['controller' => 'user_imports', 'action' => 'index']);
    }
  }

}
