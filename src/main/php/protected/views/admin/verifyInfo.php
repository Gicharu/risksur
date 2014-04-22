<?php
/*
 * verifyinfo.php
 *
 * This page is used by the superadmin to check/verify for installed or missing modules that are required by the application
 * It can also be used to clear the MDS cache
 */

$this->pageTitle = Yii::app()->name . Yii::t('translation', ' - Verify Configuration Settings');
$yiiVersion = Yii::getVersion();
$localeSession = isset(Yii::app()->session['locale']) ? Yii::app()->session['locale'] : 'en';
Yii::app()->setLanguage($localeSession);
?>

<div id="main_section">
	<div class="ui-widget-header ui-corner-all widgetTitle" style="margin-bottom:5px;">
		<span><?php echo Yii::t('translation', 'Configuration Details');?></span>
	</div>
	 <table id="dataTable-" class="dataTable-simple" width="100%" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr align="left">
				<th width="35%"><?php echo Yii::t('translation', 'MODULE');?></th>
				<th width="65%"><?php echo Yii::t('translation', 'STATUS');?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>mcrypt</td>
				<td><?php if( extension_loaded("mcrypt") ) {
					echo Yii::t('translation', 'OK');
				} else {
					echo "<b>" . Yii::t('translation', 'Missing') . "</b>";
				}?>
				</td>
			</tr>
			<tr>
				<td>apc</td>
				<td><?php if( extension_loaded("apc") ) {
					echo Yii::t('translation', 'OK');
				} else {
					echo "<b>" . Yii::t('translation', 'Missing') . "</b>";
				}?>
				</td>
			</tr>
			<tr>
				<td>ldap</td>
				<td><?php if( extension_loaded("ldap") ) {
					echo Yii::t('translation', 'OK');
				} else {
					echo "<b>" . Yii::t('translation', 'Missing') . "</b>";
				}?>
				</td>
			</tr>
			<tr>
				<td>Phar</td>
				<td><?php if( extension_loaded("phar") ) {
					echo Yii::t('translation', 'OK');
				} else {
					echo "<b>" . Yii::t('translation', 'Missing') . "</b>";
				}?>
				</td>
			</tr>
			<tr>
				<td>gettext</td>
				<td><?php if( extension_loaded("gettext") ) {
					echo Yii::t('translation', 'OK');
				} else {
					echo "<b>" . Yii::t('translation', 'Missing') . "</b>";
				}?>
				</td>
			</tr>
			<tr>
				<td>bcMath</td>
				<td><?php if( extension_loaded("bcMath") ) {
					echo Yii::t('translation', 'OK');
				} else {
					echo "<b>" . Yii::t('translation', 'Missing') . "</b>";
				}?>
				</td>
			</tr>
			<tr>
				<td>calendar</td>
				<td><?php if( extension_loaded("calendar") ) {
					echo Yii::t('translation', 'OK');
				} else {
					echo "<b>" . Yii::t('translation', 'Missing') . "</b>";
				}?>
				</td>
			</tr>
			<tr>
				<td>hash</td>
				<td><?php if( extension_loaded("hash") ) {
					echo Yii::t('translation', 'OK');
				} else {
					echo "<b>" . Yii::t('translation', 'Missing') . "</b>";
				}?>
				</td>
			</tr>
			<tr>
				<td>SimpleXML</td>
				<td><?php if( extension_loaded("SimpleXML") ) {
					echo Yii::t('translation', 'OK');
				} else {
					echo "<b>" . Yii::t('translation', 'Missing') . "</b>";
				}?>
				</td>
			</tr>
			<tr>
				<td>session</td>
				<td><?php if( extension_loaded("session") ) {
					echo Yii::t('translation', 'OK');
				} else {
					echo "<b>" . Yii::t('translation', 'Missing') . "</b>";
				}?>
				</td>
			</tr>
			<tr>
				<td>curl</td>
				<td><?php if( extension_loaded("curl") ) {
					echo Yii::t('translation', 'OK');
				} else {
					echo "<b>" . Yii::t('translation', 'Missing') . "</b>";
				}?>
				</td>
			</tr>
			<tr>
				<td><?php echo Yii::t('translation', 'Yii Version');?></td>
				<td><?php if(!empty($yiiVersion)) {
					echo $yiiVersion;
				} else {
					echo "<b>" . Yii::t('translation', 'Unknown') . "</b>";
				}?>
				</td>
			</tr>
		</tbody>
	</table>
	<table id="dataTable-" class="dataTable-simple" width="100%" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr align="left">
				<th width="35%"><?php echo Yii::t('translation', 'CONFIG PARAMETER');?></th>
				<th width="65%"><?php echo Yii::t('translation', 'VALUE');?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?php echo Yii::t('translation', 'MDS Url');?></td>
				<td><?php echo $configDetails["mdsUrl"];?></td>
			</tr>
			<tr>
				<td><?php echo Yii::t('translation', 'TIX Url');?></td>
				<td><?php echo $configDetails["tixUrl"]; ?></td>
			</tr>
			<tr>
				<td><?php echo Yii::t('translation', 'TIX Node ID');?></td>
				<td><?php echo $configDetails["nodeId"]?></td>
				</td>
			</tr>
			<tr>
				<td><?php echo Yii::t('translation', 'LDAP Url');?></td>
				<td><?php echo $configDetails["ldapUrl"];?></td>
			</tr>
			<tr>
				<td><?php echo Yii::t('translation', 'LDAP Username');?></td>
				<td><?php echo $configDetails["ldapAdminUser"];?>
				</td>
			</tr>
			<tr>
				<td><?php echo Yii::t('translation', 'LDAP Port');?></td>
				<td><?php echo $configDetails["ldapPort"];?></td>
			</tr>
			<tr>
				<td><?php echo Yii::t('translation', 'LDAP OU');?></td>
				<td><?php echo $configDetails["ldapOu"];?>
				</td>
			</tr>
			<tr>
				<td><?php echo Yii::t('translation', 'Application Name');?></td>
				<td><?php echo $configDetails["appName"];?>
				</td>
			</tr>
			<tr>
				<td><?php echo Yii::t('translation', 'Version');?></td>
				<td><?php echo $configDetails["appVersion"];?>
				</td>
			</tr>
			<tr>
				<td><?php echo Yii::t('translation', 'Pentaho Server');?></td>
				<td><?php echo $configDetails['pentahoServer'];?>
				</td>
			</tr>
		</tbody>
	</table>

	<form action="" method="POST" name="frmModules">

	<?php echo CHtml::htmlButton(Yii::t('translation', 'Clear MDS Cache'), array(
		'id' => 'clearMDScache',
		'name' => 'clearMDScache',
		'type' => 'submit'
	)); ?>

	<?php echo CHtml::htmlButton(Yii::t('translation', 'Clear TRD Cache'), array(
		'id' => 'clearTRDcache',
		'name' => 'clearTRDcache',
		'type' => 'submit'
	)); ?>

	<?php echo CHtml::htmlButton(Yii::t('translation', 'Clear TradingPartner Cache'), array(
		'id' => 'clearTPcache',
		'name' => 'clearTPcache',
		'type' => 'submit'
	)); ?>

	<?php echo CHtml::htmlButton(Yii::t('translation', 'Clear ENV Cache'), array(
		'id' => 'clearENVcache',
		'name' => 'clearENVcache',
		'type' => 'submit'
	)); ?>
	</form>
</div>	

