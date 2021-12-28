<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = '';
?>
<section class="content">

    <div class="error-page">
        <h2 class="headline text-info"><i class="fa fa-warning text-yellow"></i></h2>

        <div class="error-content">
            <h3>Error</h3>

            <p>
                <?php //nl2br(Html::encode($message)) ?>
            </p>


              <h3>Anda Tidak Mempunyai Akses Ke Halaman ini</h3>
              <h4>Hubungi Admin Untuk Info Lebih Lanjut</h4>
        </div>
    </div>

</section>
