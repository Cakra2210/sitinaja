<?php use yii\helpers\Url; ?>
<?php use yii\helpers\Html;
  $helper=Yii::$app->myHelper;
?>

<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?= Html::img('@web/image/logobps.png', ['width' => '5%'])?>
            </div>
            <div class="pull-left info">
                <small>Badan Pusat Statistik<br><?=$helper->config()->kabupaten?></small>
            </div>
        </div>


        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    [
                      'label'=>'Home',
                      'icon' => 'fa fa-home',
                      'url' => Url::toRoute('/'),
                    ],
                    [
                      'label'=>'Pegawai',
                      'icon' => 'fa fa-smile-o',
                      'url' => '#',
                      'items'=>[
                        ['label' => 'List Pegawai', 'icon' => 'fa fa-square-o', 'url' => Url::toRoute('/pegawai')],
                        [
                          'label' => 'Tambah Pegawai',
                          'icon' => 'fa fa-clone',
                          'visible' => (Yii::$app->user->identity->id_jabatan==1||Yii::$app->user->identity->id_jabatan =='3'||Yii::$app->user->identity->id_jabatan =='21')?true:false,
                          'url' => Url::toRoute('/pegawai/create')],
                          ['label' => 'CKP Pegawai', 'icon' => 'fa fa-vcard-o', 'url' => Url::toRoute('/ckp')],
                          ['label' => 'Jurnal Harian', 'icon' => 'fa fa-book', 'url' => Url::toRoute('tugas/createjurnal?iduser='.Yii::$app->user->identity->id)],
                      ]
                    ],
                    [
                        'label' => 'Tugas',
                        'icon' => 'fa fa-file-o',
                        'url' => '#',
                        'items' => [
                            [
                              'label' => 'List Surat Tugas',
                              'icon' => 'fa fa-file-code-o',
                              'url' => '#',
                              'items' => [
                                ['label' => 'Surat Tugas Pribadi','icon' => 'fa fa-square-o', 'url' => Url::toRoute('tugas/listtugas')],
                                ['label' => 'Surat Tugas Kolektif', 'icon' => 'fa fa-clone', 'url' => Url::toRoute('tugas/listtugaskolektif')],
                              ],
                            ],
                            [
                                'label' => 'Buat Surat Tugas',
                                'icon' => 'fa fa-square-o',
                                'url' => '#',
                                'visible' =>(Yii::$app->myHelper->isKepalaseksi(Yii::$app->user->identity->id_jabatan)||Yii::$app->user->identity->id_jabatan==1),
                                'items' => [
                                    ['label' => 'Pribadi', 'icon' => 'fa fa-square-o', 'url' => Url::toRoute('tugas/create')],
                                    ['label' => 'Kolektif', 'icon' => 'fa fa-clone', 'url' => Url::toRoute('tugas/createkolektif')],
                                ],
                            ],
                        ],
                    ],
                    [
                      'label' => 'Memo',
                      'icon' => 'fa fa-sticky-note',
                      'url' => '#',
                      'items' => [
                          [
                            'label' => 'List Memo',
                            'icon' => 'fa fa-file-code-o',
                            'url' => Url::toRoute('memo/index'),
                          ],
                          [
                              'label' => 'Buat Memo',
                              'icon' => 'fa fa-square-o',
                              'url' => Url::toRoute('memo/create'),
                          ],
                      ],
                    ],
                    [
                      'label' => 'Surat Ijin/Cuti',
                      'icon' => 'fa fa-map-o',
                      'url' => '#',
                      'items' => [
                          [
                            'label' => 'List Surat Ijin/Cuti',
                            'icon' => 'fa fa-file-code-o',
                            'url' => Url::toRoute('ijincuti/index'),
                          ],
                          [
                              'label' => 'Buat Surat Ijin/Cuti',
                              'icon' => 'fa fa-square-o',
                              'url' => Url::toRoute('ijincuti/create'),
                          ],
                      ],
                    ],

                    [
                        'label' => 'Rekap Absen',
                        'icon' => 'fa fa-calendar-check-o',
                        'url' => '#',
                        'visible' => Yii::$app->user->id==1?true:false,
                        'url' => Url::toRoute('/pegawai/listrekap'),
                    ],
                    [
                        'label' => 'Admin Menu',
                        'icon' => 'fa fa-file-o',
                        'url' => '#',
                        'visible' => Yii::$app->user->id==1?true:false,
                        'items' => [
                            [
                              'label' => 'Jabatan',
                              'icon' => 'fa fa-file-code-o',
                              'url' => Url::toRoute('/jabatan/index'),
                            ],
                            [
                                'label' => 'Seksi',
                                'icon' => 'fa fa-square-o',
                                'url' => Url::toRoute('/seksi/index'),
                            ],
                            [
                              'label'=>'Shift',
                              'icon'=>'fa fa-clock-o',
                              'url'=>Url::toRoute('/shift/index'),
                            ],
                            [
                              'label'=>'Hari Libur',
                              'icon'=>'fa fa-flag',
                              'url'=>Url::toRoute('/holiday/index'),
                            ]
                        ],
                    ],
                    [
                      'label'=>'Config',
                      'icon' => 'fa fa-gear',
                      'url' => Url::toRoute('/config/update?id=1'),
                      'visible' => Yii::$app->user->id==1?true:false,
                    ],
                    [
                      'label'=>'Logout',
                      'icon' => 'fa fa-gear',
                      'url' => Url::toRoute('/site/logout'),
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
