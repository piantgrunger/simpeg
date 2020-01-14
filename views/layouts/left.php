<?php
    $menuItems =
        [
                    ['label' => 'Dashboard', 'icon' => 'view-dashboard', 'url' => ['/'], 'visible' => !Yii::$app->user->isGuest],

                     [
                        'visible' => !Yii::$app->user->isGuest,
                        'label' => 'User / Group',
                        'icon' => 'users',
                        'url' => '#',
                        'items' => [
                    ['label' => 'App. Route', 'icon' => 'routes', 'url' => ['/route/'], 'visible' => !Yii::$app->user->isGuest],
                    ['label' => 'Role', 'icon' => 'account-multiple', 'url' => ['/role/'], 'visible' => !Yii::$app->user->isGuest],
                    ['label' => 'User', 'icon' => 'account-plus', 'url' => ['/user/'], 'visible' => !Yii::$app->user->isGuest],
                   ], ],

                ];


if (!Yii::$app->user->isGuest) {
    if (Yii::$app->user->identity->username !== 'admin') {
        $menuItems = Mimin::filterMenu($menuItems);
    }
}
?>
<aside class="left-sidebar" data-sidebarbg="skin5">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav" class="p-t-30">
       <?php echo app\widgets\Menu::widget(
    [
                'items' => $menuItems,
            ]

            //Menus::menuItems()
); ?>

                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
