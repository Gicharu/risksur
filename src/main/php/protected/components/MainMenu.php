<?php
/**
 * MainMenu 
 * 
 * @uses CWidget
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Chirag Doshi <chirag@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 * @SuppressWarnings checkUnusedVariables
 */
class MainMenu extends CWidget {
	public $parentId = 0;

	/**
	 * run 
	 * 
	 * @access public
	 * @return void
	 */
	public function run() {
		$parentId = 0;
		$user = Yii::app()->user->id;
		$programPages = Yii::app()->db->createCommand()
			->select('p.pageId, p.pageName, p.path, p.parentId, p.menuOrder, p.target, c.pageId as childId, c.pageName as childName, c.menuOrder as childOrder')
			->from('programpages p')
			//->join('tbl_profile p', 'u.id=p.user_id')
			->leftJoin('programpages c', 'c.pageId = p.parentId')
			->join('pages_has_roles pr', 'pr.pageId = p.pageId')
			->join('users_has_roles ur', 'ur.roles_id = pr.roleID')
			//INNER JOIN pages_has_roles pr ON pr.`pageId` = p.`pageId`
			//INNER JOIN users_has_roles ur ON ur.`roles_id` = pr.`roleId`
			//->where('p.parentId=:parentId', array(':parentId'=>$parentId))
			->where('p.active = 1 and ur.users_id = :userId', array(':userId' => $user))
			->order('p.menuOrder, c.menuOrder asc') 
			->queryAll();
			//print_r($programPages);
		$menuParams['menuArray'] = array();
		foreach ($programPages as $menuPages) {
			// default values
			if (empty($menuPages['childId']) && $menuPages['pageName'] != "noMenu") {
				$menuParams['menuArray'][$menuPages['pageId']]['label'] = "Empty Link";
				$menuParams['menuArray'][$menuPages['pageId']]['url'] = "";
					if (empty($menuPages['target'])) {
						$url = Yii::app()->controller->createUrl($menuPages['path']);
					} else {
						$url = "//" . $menuPages['path']; 
					}

					//$classSet = '';
					//if (strstr($menuPages['path'], Yii::app()->controller->id)) {
						//$classSet = 'ui-active';
					//}
					$menuParams['menuArray'][$menuPages['pageId']] = array(
						'label' => $menuPages['pageName'],
						'url' => $url,
						'linkOptions' => array('target' => $menuPages['target']),
						'active' => strstr($menuPages['path'], Yii::app()->controller->id)
					);
			} else {
				$pathArray = $this->arrayKeyPath((int)$menuPages['childId'], $menuParams['menuArray']);
				if($menuPages['childName'] != "noMenu" && $pathArray !== FALSE) {
					$fullMenuPath = &$this->arrayPath($menuParams['menuArray'], $pathArray);
					if (empty($menuPages['target'])) {
						$url = Yii::app()->controller->createUrl($menuPages['path']);
					} else {
						$url = "//" . $menuPages['path']; 
					}
					$fullMenuPath['items'][$menuPages['pageId']] = array(
						'label' => $menuPages['pageName'],
						'url' => $url,
						'linkOptions' => array('target' => $menuPages['target']),
						'active' => strstr($menuPages['path'], Yii::app()->controller->id)
					);
				}
			}
		}
		$this->render('mainMenuView', array(
				'menuParams' => $menuParams
			)
		);
	}

	/**
	 * arrayKeyPath 
	 *
	 * Search for a key in an array, returning a path to the entry.
	 *
	 * @param $needle
	 *   A key to look for.
	 * @param $haystack
	 *   A keyed array.
	 * @param $forbidden
	 *   A list of keys to ignore.
	 * @param $path
	 *   The intermediate path. Internal use only.
	 * @return mixed
	 *   The path to the parent of the first occurrence of the key, represented as an array where entries are consecutive keys.
	 */
	function arrayKeyPath($needle, $haystack, $forbidden = array(), $path = array()) {
		foreach ($haystack as $key => $val) {
			if (in_array($key, $forbidden)) {
				continue;
			}
			if (is_array($val) && is_array($sub = $this->arrayKeyPath($needle, $val, $forbidden, array_merge($path, (array)$key)))) {
				return $sub;
			} elseif ($key === $needle) {
				return array_merge($path, (array)$key);
			}
		}
		return FALSE;
	}

	/**
	 * &arrayPath 
	 *
	 * Given a path, return a reference to the array entry.
	 *
	 * @param $array
	 *   A keyed array.
	 * @param $path
	 *   An array path, represented as an array where entries are consecutive keys.
	 * @return array
	 *   A reference to the entry that corresponds to the given path.
	 **/
	function &arrayPath(&$array, $path) {
		$offset = &$array;
		if ($path) {
			foreach ($path as $index) {
				$offset = &$offset[$index];
			}
		}
		return $offset;
	}

}
