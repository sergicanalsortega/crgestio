<?php
/**
 * @version     1.0.0 Afi framework $
 * @package     Afi framework
 * @copyright   Copyright © 2016 - All rights reserved.
 * @license	    GNU/GPL
 * @author	    kim
 * @author mail kim@afi.cat
 * @website	    http://www.afi.cat
 *
*/

defined('_Afi') or die ('restricted access');

?>

<?php if(isset($_SESSION['message'])) : ?>
<script>
jQuery(function () {
	<?php if($_SESSION['messageType'] == 'success') : ?>
	Messenger().post({message: "<?= $_SESSION['message']; ?>", type: 'success', hideAfter: 10});
	<?php endif; ?>
	<?php if($_SESSION['messageType'] == 'danger') : ?>
	Messenger().post({message: "<?= $_SESSION['message']; ?>", type: 'error', hideAfter: 10});
	<?php endif; ?>
	jQuery.post('<?= $config->site; ?>/index.php?view=home&task=unsetSession');
});
</script>
<?php endif; ?>