<?php
$list_table = new Ai_Robot_Log_List_Table();
$list_table->prepare_items();
$base_url = admin_url( 'admin.php?page=ai-robot-logs' );
?>
<div class="wrap">
    <form method="get" action="<?php echo esc_url( $base_url ); ?>">
        <div class="robot-row-with-sidenav">
            <input type="hidden" name="page" value="ai-robot-logs"/>
            <?php $list_table->views() ?>
            <?php $list_table->display() ?>
        </div>
    </form>
</div>
