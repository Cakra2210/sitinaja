<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use app\models\Posts;
/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class TesController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionInsert()
    {
      	$post = new Posts;
      	$post->author_id = 1;
      	$post->title = "Insert dari console";
      	$post->description = "Saya mencoba insert data ke database melalui console";
      	$post->content = "Mragus.com";
      	$post->date = date('Y-m-d');
      	if($post->save()){
      		echo "data berhasil disimpan";
      	}else{
      		echo "data gagal disimpan";
      	}
    }

    public function actionView($id){
    	$post = Posts::findOne($id);
    	echo $post->description;
    }
}
