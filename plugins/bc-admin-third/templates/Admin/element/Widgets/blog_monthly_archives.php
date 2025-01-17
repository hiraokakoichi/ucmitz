<?php
/**
 * baserCMS :  Based Website Development Project <https://basercms.net>
 * Copyright (c) baserCMS Users Community <https://basercms.net/community/>
 *
 * @copyright       Copyright (c) baserCMS Users Community
 * @link            https://basercms.net baserCMS Project
 * @package            Blog.View
 * @since           baserCMS v 0.1.0
 * @license         https://basercms.net/license/index.html
 */

/**
 * [ADMIN] ブログ月別アーカイブー一覧ウィジェット設定
 */
$title = __d('baser', '月別アーカイブ一覧');
$description = __d('baser', 'ブログの月別アーカイブー一覧を表示します。');
?>


<?php echo $this->BcAdminForm->label($key . '.limit', __d('baser', '表示数')) ?>&nbsp;
<?php echo $this->BcAdminForm->control($key . '.limit', ['type' => 'text', 'size' => 6, 'default' => 12]) ?>&nbsp;件<br/>
<?php echo $this->BcAdminForm->label($key . '.view_count', __d('baser', '記事数表示')) ?>&nbsp;
<?php echo $this->BcAdminForm->control($key . '.view_count', ['type' => 'radio', 'options' => $this->BcText->booleanDoList(''), 'legend' => false, 'default' => 0]) ?>
<br/>
<?php echo $this->BcAdminForm->label($key . '.blog_content_id', __d('baser', 'ブログ')) ?>&nbsp;
<?php echo $this->BcAdminForm->control($key . '.blog_content_id', ['type' => 'select', 'options' => $this->BcAdminForm->getControlSource('Blog.BlogContent.id')]) ?>
<br/>
<small><?php echo __d('baser', 'ブログページを表示している場合は、上記の設定に関係なく、対象ブログの月別アーカイブ一覧を表示します。') ?></small>
