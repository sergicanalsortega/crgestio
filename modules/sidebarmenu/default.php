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

$config = factory::getConfig();
$user   = factory::getUser();
$view   = factory::getApplication()->getVar('view', 'home');
?>

<div id="sidebar" class="active">
	<div class="sidebar-wrapper active">
		<div class="sidebar-header">
			<div class="d-flex justify-content-between">
				<div class="logo">
					<a href="index.html"><img src="<?= $config->site; ?>/template/<?= $config->template; ?>/dist/assets/images/logo/logo.png" alt="Logo" srcset=""></a>
				</div>
				<div class="toggler">
					<a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
				</div>
			</div>
		</div>
		<div class="sidebar-menu">
			<ul class="menu">
				<li class="sidebar-title">Menú</li>

				<li class="sidebar-item">
					<a href="index.php?view=home" class='sidebar-link'>
						<i class="bi bi-grid-fill"></i>
						<span>Dashboard</span>
					</a>
				</li>

				<li class="sidebar-item has-sub">
					<a href="#" class='sidebar-link'>
						<i class="bi bi-stack"></i>
						<span>Components</span>
					</a>
					<ul class="submenu ">
						<li class="submenu-item ">
							<a href="index.php?view=hores">Hores</a>
						</li>
					</ul>
				</li>
				<?php if($user->_level == 1) : ?>
				<li class="sidebar-item has-sub">
					<a href="#" class='sidebar-link'>
						<i class="bi bi-stack"></i>
						<span>Configuració</span>
					</a>	
					<ul class="submenu">
						<li class="submenu-item">
							<a href="index.php?view=config">Global</a>
						</li>
						<li class="submenu-item ">
							<a href="index.php?view=users">Usuaris</a>
						</li>
						<li class="submenu-item ">
							<a href="index.php?view=groups">Grups</a>
						</li>
					</ul>
				</li>
				<?php endif; ?>

				<li class="sidebar-title">Suport</li>

				<li class="sidebar-item  ">
					<a href="https://docs.aficat.com" class='sidebar-link'>
						<i class="bi bi-life-preserver"></i>
						<span>Documentació</span>
					</a>
				</li>

			</ul>
		</div>
		<button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
	</div>
</div>
