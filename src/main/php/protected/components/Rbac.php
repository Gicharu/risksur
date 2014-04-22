<?php
/**
 * Description of Rbac
 *
 * @author oleksiy
 */
class Rbac {
	const LOG_CAT = "comp.Rbac";
	public function init() {
	}
	/**
	 *
	 * @param string $controller controller.id
	 * @param string $action action.id
	 * @param numeric $user user ID
	 * @param array $fakeGET fake _GET array for evaluating businness rules
	 * @return boolean true if user has access, false otherwise
	 */
	public function checkAccess($controller, $action, $user = null, $msg = 1, array $fakeGET = null) {
		$allow = false;
		if (!$user) {
			$user = Yii::app()->user->id;
		}
		$permissions = Yii::app()->session['roleManage'];
		$userGroups = Yii::app()->session['userGroups'];
		$controllerAction = $controller . ":" . $action;
		if ($fakeGET) { // lets fake GET request params for evaluating business rule
			$save_GET = $_GET;
			$_GET = $fakeGET;
		}
		//echo $controller . "/" . $action;
		if (!empty($permissions)) {
			if (isset($permissions[$controllerAction]) ) {
				$rolesAllowed = explode(",", $permissions[$controllerAction]);
				//print_r($userGroups);
				//print_r($rolesAllowed); die();
				foreach ($rolesAllowed as $allowed) {
					//echo "here" . $allowed;
					//die();
					if(in_array($allowed, $userGroups)) {
						//print_r($p);
						//echo "found it" . "<br>";
						$allow = true;
						break;
					}
				}
			} else {
				Yii::log("No role access declaration found for:" . $controllerAction, "warning", 'rbac');
			}
		} else {
			Yii::log("Roles management data is empty", "error", 'rbac');
		}
		if ($fakeGET) { // restore original _GET
			$_GET = $save_GET;
		}
		if (!$allow) {
			if(empty($userGroups)) {
				if ($msg == 1 ){
					Yii::app()->user->setFlash('error', "You do not have the rights to access this page, please contact your administrator.");
				}
				Yii::log("No user roles in the session for user " . $user . " therefore access is denied to " . $controllerAction , "warning", self::LOG_CAT);

			} else {
				if ($msg == 1 ){
					Yii::app()->user->setFlash('error', "You do not have the rights to access this page, please contact your administrator.");
				}
				Yii::log("User roles-" . implode(",", $userGroups) . " for user " . $user . " is not allowed to see page " . $controllerAction , "warning", self::LOG_CAT);
			}
		}
		return $allow;
	}

	public function checkRules($rules, $user = null) {
		$allow = false;
		if (!$user) {
			$user = Yii::app()->user->id;
		}
		$permissions = Yii::app()->session['businessRules'];
		$userGroups = Yii::app()->session['userGroups'];
		if (!empty($permissions)) {
			if (isset($permissions[$rules]) ) {
				$rolesAllowed = explode(",", $permissions[$rules]);
				//print_r($userGroups);
				//print_r($rolesAllowed); die();
				foreach ($rolesAllowed as $allowed) {
					//echo "here" . $allowed;
					//die();
					if(in_array($allowed, $userGroups)) {
						//print_r($p);
						//echo "found it" . "<br>";
						$allow = true;
						break;
					}
				}
			} else {
				Yii::log("No business rule declaration found for:" . $rules, "warning", 'rbac');
			}
		} else {
			Yii::log("Business rules data is empty", "error", 'rbac');
		}
		return $allow;
	}
}
?>
