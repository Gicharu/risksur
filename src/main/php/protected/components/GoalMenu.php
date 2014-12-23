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
class GoalMenu extends CWidget {
	public $parentId = 0;
	public $menuId = "goalMenu";
	public $title = "Surveillance goal";

	/**
	 * run 
	 * 
	 * @access public
	 * @return void
	 */
	public function run() {
		//$parentId = 0;

		$programPages = Yii::app()->db->createCommand()
			->select('p.pageId, p.pageName, p.path, p.parentId, p.menuOrder')
			->from('goalMenu p')
			//->join('tbl_profile p', 'u.id=p.user_id')
			//->leftJoin('programpages c', 'c.pageId = p.parentId')
			//->where('p.parentId=:parentId', array(':parentId'=>$parentId))
			->where('p.parentId =' . $this->parentId)
			->andWhere('p.active = 1')
			->order('p.menuOrder') 
			->queryAll();
			//print_r($programPages);
			//die();
			$goalParams['goalArray'] = array();
		foreach ($programPages as $menuPages) {
			// default values
			if ($menuPages['pageName'] != "noMenu") {
				$goalParams['goalArray'][$menuPages['pageId']] = $menuPages['pageName'];
				//$goalParams['goalArray'][$menuPages['pageId']]['url'] = ""; 
				//$goalParams['goalArray'][$menuPages['pageId']] = array( 'label' => $menuPages['pageName'],
				//'url' => $menuPages['path']
				//);
			//} else {
				//$pathArray = $this->arrayKeyPath((int)$menuPages['childId'], $goalParams['goalArray']);
				//if($menuPages['childName'] != "noMenu" && $pathArray !== FALSE) {
					//$fullMenuPath =& $this->arrayPath($goalParams['goalArray'], $pathArray);
					//$fullMenuPath['items'][$menuPages['pageId']] = array(
						//'label' => $menuPages['pageName'],
						//'url' => $menuPages['path']
					//);
				//}
			}
		}
		$this->render('goalMenuView', array(
				'goalParams' => $goalParams
			)
		);
	}

}
