<?php
/**
 * ModelToArray
 *
 * @copyright Tracetracker
 * @version   $id$
 * @uses      Controller
 * @license   Tracetracker {@link http://www.tracetracker.com}
 * @author    James Njoroge <james@tracetracker.com>
 * @package
 */


class ModelToArray {

	/**
	 * convertModelToArray
	 *
	 * @param object  $models
	 * @return array
	 */

	/**
	 * Converting a Yii model with all relations to a an array.
	 * 'comment'=>'*') to filter attributes. Also can use alias for column names by using AS with the column name just
	 * like in SQL.
	 *
	 * @param mixed   $models           A single model or an array of models for converting to array.
	 * @param array   $filterAttributes (optional) should be like array('table name'=>'column names','user'=>'id,firstname,lastname'
	 * @param array   $ignoreRelations  (optional) an array contains the model names in relations that will not be converted to array
	 * @return array array of converted model with all related relations.
	 */
	public static function convertModelToArray($models, array $filterAttributes = null, array $ignoreRelations = array()) {
		if ((!is_array($models)) && (is_null($models))) {
			return null;
		} 

		if (is_array($models)) {
			$arrayMode = TRUE;
		} else {
			$models = array($models);
			$arrayMode = FALSE;
		}

		$result = array();
		foreach ($models as $model) {
			$attributes = $model->getAttributes();

			if (isset($filterAttributes) && is_array($filterAttributes)) {
				foreach ($filterAttributes as $key => $value) {

					if (strtolower($key) == strtolower($model->tableName())) {
						$arrColumn = explode(",", $value);

						if (strpos($value, '*') === FALSE) {
							$attributes = array();
						}

						foreach ($arrColumn as $column) {
							$columnNameAlias = array_map('trim', preg_split("/[aA][sS]/", $column));

							$columnName = '';
							$columnAlias = '';

							if (count($columnNameAlias) === 2) {
								$columnName = $columnNameAlias[0];
								$columnAlias = $columnNameAlias[1];
							} else {
								$columnName = $columnNameAlias[0];
							}

							if (($columnName != '') && ($column != '*')) {
								if ($columnAlias !== '') {
									$attributes[$columnAlias] = $model->$columnName;
								} else {
									$attributes[$columnName] = $model->$columnName;
								}
							}
						}
					}
				}
			}

			$relations = array();
			$key_ignores = array();

			if ($modelClass = get_class($model)) {
				if (array_key_exists($modelClass, $ignoreRelations)) {
					$key_ignores = explode(',', $ignoreRelations[$modelClass]);
				}
			}

			foreach ($model->relations() as $key => $related) {

				if ($model->hasRelated($key)) {
					if (!in_array($key, $key_ignores)) {
						$relations[$key] = self::convertModelToArray($model->$key, $filterAttributes, $ignoreRelations);
					}
				}
			}
			$all = array_merge($attributes, $relations);

			if ($arrayMode) {
				array_push($result, $all);
			} else {
				$result = $all;
			}
		}
		return $result;
	}


}
