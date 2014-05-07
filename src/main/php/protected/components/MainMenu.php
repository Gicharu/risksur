<?php
class MainMenu extends CWidget {
	public $parentId = 0;

	public function run() {

		$parentId = 0;
		$programPages = Yii::app()->db->createCommand()
			->select('p.pageId, p.pageName, p.path, p.parentId, p.menuOrder, c.pageId as childId, c.pageName as childName, c.menuOrder as childOrder')
			->from('programpages p')
			//->join('tbl_profile p', 'u.id=p.user_id')
			->leftJoin('programpages c', 'c.pageId = p.parentId')
			//->where('p.parentId=:parentId', array(':parentId'=>$parentId))
			//->where('c.pageName <> "noMenu"')
			->order('p.menuOrder, c.menuOrder asc') 
			->queryAll();
			//print_r($programPages);
		$menuParams['menuArray'] = array();
		foreach ($programPages as $menuPages) {
			// default values
			if (empty($menuPages['childId']) && $menuPages['pageName'] != "noMenu") {
				$menuParams['menuArray'][$menuPages['pageId']]['label'] = "Empty Link";
				$menuParams['menuArray'][$menuPages['pageId']]['url'] = "";
				if (!empty($menuPages['pageName'])) {
					$menuParams['menuArray'][$menuPages['pageId']]['label'] = $menuPages['pageName'];
				}
				if (!empty($menuPages['path'])) {
					$menuParams['menuArray'][$menuPages['pageId']]['url'] = $menuPages['pageName'];
				}
			} else {
				if($menuPages['childName'] != "noMenu" && isset($menuParams['menuArray'][$menuPages['childId']])) {
					$menuParams['menuArray'][$menuPages['childId']]['items'][] = array(
						'label' => $menuPages['pageName'],
						'url' => $menuPages['path']
					);
				}
			}
		}
		//print_r($menuParams['menuArray']);
		//die("here");
		$this->render('mainMenuView', array(
				'menuParams' => $menuParams
			)
		);
	}
}
