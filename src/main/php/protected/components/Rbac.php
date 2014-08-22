<?php
	/**
	 * Rbac 
	 * 
	 * @package  
	 * @author oleksiy
	 * @copyright Tracetracker
	 * @version   $id$
	 * @uses      Controller
	 * @license   Tracetracker {@link http://www.tracetracker.com}
	 */

	class Rbac {

		/**
		 * init 
		 * @return void
		 */
		public function init() {

		}

		/**
		 *
		 * checkAccess
		 * @param string  $controller controller.id
		 * @param string  $action     action.id
		 * @param numeric $user       (optional) user ID
		 * @param array   $fakeGET    (optional) fake _GET array for evaluating businness rules
		 * @return boolean true if user has access, false otherwise
		 */

		public function checkAccess($controller, $action, $user = null, array $fakeGET = null) {
			$allow = false;

			if (!$user) {
				$user = Yii::app()->user->id;
			}

			$sql = 'SELECT DISTINCT p.* FROM permissions p, users u, roles r, users_has_roles ur, roles_has_permissions rp
			WHERE p.id=rp.permissions_id
			AND r.id=rp.roles_id
			AND ur.roles_id=r.id
			AND ur.users_id=u.userId
			AND u.userId=:uid
			AND p.controller=:controller
			AND p.action=:action
			ORDER BY p.bizrule ASC';
			$command = Yii::app()->db->createCommand($sql);
			$command->bindParam(":uid", $user, PDO::PARAM_INT);
			$command->bindParam(":controller", $controller, PDO::PARAM_STR);
			$command->bindParam(":action", $action, PDO::PARAM_STR);
			$permissions = $command->queryAll();


			if ($fakeGET) { // lets fake GET request params for evaluating business rule
			$save_GET = $_GET;
			$_GET = $fakeGET;
			}

			if (!empty($permissions)) {
				foreach ($permissions as $p) {
					if (empty($p['bizrule']) || @eval($p['bizrule'])) {
						$allow = true;
						break;
					}
				}
			}

			if ($fakeGET) { // restore original _GET
			$_GET = $save_GET;
			}

			return $allow;
		}


		/**
		 *
		 * checkAccessEx
		 * @param mixed   $searchCriteria can be a string or an array with RBAC search criterias
		 * @param numeric $user           (optional) user.id
		 * @return boolean true if user satisfies rbac criteria $searchCriteria
		 */
		public function checkAccessEx($searchCriteria, $user = null) {
			$from = array();
			$where = array();

			if (!$user) {
				$user = Yii::app()->user->id;
			}

			$from[] = 'users u';
			$where[] = 'u.userId=' . intval($user);
			$this->parseSearchCriteria($searchCriteria, $from, $where);

			$sql = 'SELECT u.userId FROM '.join($from, ', ') . ' WHERE ' . join($where, ' AND ');
			$access = Yii::app()->db->createCommand($sql)->queryScalar();
			return !empty($access);
		}


		/**
		 *
		 * parseSearchCriteria
		 * @param unknown $conditions
		 * @param unknown $from       (reference)
		 * @param unknown $where      (reference)
		 */
		private function parseSearchCriteria($conditions, &$from, &$where) {
			if (!is_array($conditions)) {
				$conditions = array($conditions);
			}
			foreach ($conditions as $c) {
				$c .= ',';
				if (preg_match('/(users|roles|permissions)=/', $c, $regs)) {
					$talias = $regs[1]{0};
					$from[] = $regs[1] . ' ' . $talias;
				}
				$or = array();
				if (preg_match_all('/(\w+):(.*?),/', $c, $regs)) {
					for ($i=0; $i<count($regs[0]); $i++) {
						if (is_numeric($regs[2][$i])) {
							$or[] = $talias . '.' . $regs[1][$i] . '=' . $regs[2][$i];
						} else {
							$value = preg_replace('[\'\"]', '', $regs[2][$i]);
							$or[] = $talias . '.' . $regs[1][$i] . ' LIKE \'' . $value . '\'';
						}
					}
				}
				if (count($or)) {
					$where[] = '(' . join($or, ' OR ') . ')';
				}
			}

			$addUsersHasRoles = false;
			$addRolesHasPermissions = false;
			if (preg_match('/users/', join($from, ' ')) && preg_match('/permissions/', join($from, ' '))) {
				$from[] = 'roles r';
				$addUsersHasRoles = true;
				$addRolesHasPermissions = true;
			} else {
				if (preg_match('/users/', join($from, ' ')) && preg_match('/roles/', join($from, ' '))) {
					$addUsersHasRoles = true;
				}
				if (preg_match('/permissions/', join($from, ' ')) && preg_match('/roles/', join($from, ' '))) {
					$addRolesHasPermissions = true;
				}
			}
			if ($addRolesHasPermissions) {
				$from[] = 'roles_has_permissions rp';
				$where[] = 'r.id=rp.roles_id';
				$where[] = 'p.id=rp.permissions_id';
			}
			if ($addUsersHasRoles) {
				$from[] = 'users_has_roles ur';
				$where[] = 'u.userId=ur.users_id';
				$where[] = 'r.id=ur.roles_id';
			}

			$from = array_unique($from);
			$where = array_unique($where);
		}


	}


?>
