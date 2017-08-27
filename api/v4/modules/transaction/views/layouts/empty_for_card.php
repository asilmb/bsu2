<?php


/* @var $this Controller */
/* @var $content string */

use api\v4\modules\bank\assets\CardAsset;
use yii2lab\helpers\Page;

CardAsset::register($this);

?>

<?php Page::beginDraw(['class' => 'content-wrapper--index-tr']) ?>

<div class="content-wrapper">
	<?php echo $content; ?>
</div>

<?php Page::endDraw() ?>
