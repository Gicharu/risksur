<?php
$this->pageTitle = Yii::app()->name . ' - Reports';
$allReports = $dataArray['allReports'];
//$tixUrl = Yii::app()->session['tixUrl'];
if (!isset($_SESSION['pentahoReportUser']) || count($allReports) == 0) {
?>
	<div class="no-reports">You do not have access to any reports!</div>
<?php
} else {
	$postData = $_POST;
?>
	<div id="report-menu" style="width:500px;position:relative;float:left;">
		<form id="form1" method="post" name="form1" action="">
			<?php $hiddenName = $dataArray['currentReport'] != NULL ? $dataArray['currentReport']->name : ""; ?>
			<?php $reportParams = $dataArray['currentReport'] != NULL ? $dataArray['currentReport']->getParametersAsString() : ""; ?>
			<input type="hidden" name="currentReportName" value="<?php echo $hiddenName; ?>" />
			<input type="hidden" name="reportParams" value="<?php echo $reportParams; ?>" />
			<ul>
				<li class="textwarning">* Mandatory fields</li>
				<li>Select report:</li>
				<li>
					<select name="reportName" id="reportName" onchange="document.getElementById('form1').submit();">
						<option value=""></option>
<?php
	foreach ($dataArray['allReports'] as $report) {
		$selectedStr = "";
		if ($dataArray['reportName'] == $report->name) {
			$selectedStr = " SELECTED";
		}
?>
							<option value="<?php echo $report->name; ?>"<?php echo $selectedStr; ?>>
							<?php echo $report->displayName; ?>
							</option>
<?php
	}
?>
					</select>
				</li>
<?php
	$pentaho = new TPentahoResource();
	if ($dataArray['currentReport'] != NULL && $dataArray['currentReport']->hasParameters()) {
		foreach ($dataArray['currentReport']->getParameters() as $reportParameter) {
			$postValue = $dataArray['doExecute'] ? $postData[$reportParameter->name] : "";
?>
						<li><?php echo $reportParameter->label; ?>:</li>
						<li><?php echo $pentaho->pentahoGetParameterHtml($reportParameter, $postValue); ?></li>
<?php
		}
	} ?>
			</ul>
			<div><input type="submit" value="Execute report" class="buttons" name="executeReport" id="executeReport"></div>
		</form>
	</div>
<?php
	if ($dataArray['doExecute'] && $dataArray['errorMsg'] == "") {
		$reportUrl = $pentaho->pentahoGetServerUrl() . $dataArray['currentReport']->executeUrl . "&ssoObject=" . $pentaho->pentahoGetSsoObject();
		if ($dataArray['currentReport']->hasParameters()) {
			foreach ($dataArray['currentReport']->getParameters() as $urlParameter) {
				$reportUrl = $reportUrl . "&" . $urlParameter->name . "=" . $postData[$urlParameter->name];
			}
		}
?>
		<div id="report-content" style="width:825px;position:relative;float:left;">
			<iframe style="border:none;background:white;" width="100%" height="800" src="<?php echo "$reportUrl"; ?>"></iframe>
		</div>
<?php
	}
}
?>
