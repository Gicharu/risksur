<?php
//error_reporting(E_ALL);
/*
/**
 * ReportsController 
 * 
 * @uses Controller
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 */
/*
class ReportsController extends Controller {
	public $page;
	/**
	 * @return array action filters
	 
	public function filters() {
		return array(
			'accessControl', // perform access control

		);
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	/*
	public function accessRules() {
		return array(
			array(
				'allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions' => array(
					'reports'
				),
				'users' => array(
					'administrator',
					'admin',
					'TraciiUser',
					'karen'
				),
			),
			array(
				'deny', // deny all users
				'users' => array(
					'*'
				),
			),
		);
	}
	/**
	 * actionReports 
	 * 
	 * @access public
	 * @return void
	 */
	/*
	public function actionReports() {
		$dataArray = array();
		$currentReport = NULL;
		$errorMsg = "";
		$reportName = "";
		$doExecute = false;
		$reportChanged = false;
		$dataArray['currentReport'] = NULL;
		$dataArray['errorMsg'] = "";
		$dataArray['reportChanged'] = false;
		$dataArray['doExecute'] = false;
		$dataArray['reportName'] = "";
		$dataArray['currentReportParam'] = "";
		$dataArray['hasParameters'] = "";
		$dataArray['getParameters'] = "";
		$pentaho = new TPentahoResource();
		try {
			$reports = $pentaho->pentahoGetReportsServer();
			//print_r($reports);
			Yii::app()->session->add('pentahoReports', serialize($reports));
			//echo Yii::app()->session['pentahoReports'];
			$allReports = $pentaho->pentahoGetReportsSession();
			$dataArray['allReports'] = $allReports;
			//print_r($allReports);

		}
		catch(Exception $e) {
			$errorMsg = "Failed to load reports : " . $e->getMessage();
		}
		if ($_POST) {
			$doExecute = isset($_POST['executeReport']); // User has clicked execute button!
			$reportName = $_POST['reportName'];
			$currentReportName = $_POST['currentReportName'];
			if ($reportName != "") {
				// A valid report is selected, get report object.
				try {
					$currentReport = $pentaho->pentahoGetReportAndParameters($reportName);
				}
				catch(Exception $e) {
					$errorMsg = "Failed to load report parameters: " . $e->getMessage();
				}
				$reportChanged = $currentReportName != "" && $currentReportName != $currentReport->name;
			}
			if ($doExecute && $currentReport != NULL && $currentReport->hasParameters()) {
				// Validate params
				foreach ($currentReport->getParameters() as $validateParameter) {
					$errorMsg .= $pentaho->pentahoValidateParameter($validateParameter, $_POST[$validateParameter->name]);
				}
			}
			$pentahoReportsParams = new TPentahoReportAndParameters($currentReport);
			$dataArray['currentReport'] = $currentReport;
			$dataArray['errorMsg'] = $errorMsg;
			$dataArray['reportChanged'] = $reportChanged;
			$dataArray['doExecute'] = $doExecute;
			$dataArray['reportName'] = $reportName;
			$dataArray['currentReportParam'] = $pentahoReportsParams->getParametersAsString();
			$dataArray['hasParameters'] = $pentahoReportsParams->hasParameters();
			$dataArray['getParameters'] = $pentahoReportsParams->getParameters();
		}
		/*try {
				  $allReports = pentahoGetReportsSession();
			  } catch(Exception $e) {
				  $errorMsg = "Failed to load reports : ".$e->getMessage();
		}
		$this->render('reports', array(
			'dataArray' => $dataArray
		));
	}
}
*/
?>
