<?php
/**
 * LogFilter 
 * 
 * @package  
 * @author    Chirag Doshi <chirag@tracetracker.com> 
 * @copyright Tracetracker
 * @version   $id$
 * @uses      CLogFilter
 * @license   Tracetracker {@link http://www.tracetracker.com}
 */
class LogFilter extends CLogFilter {
	/**
	 * format 
	 * 
	 * @param mixed $logs 
	 * @access protected
	 * @return void
	 */
	protected function format(&$logs) {
		//extended the log filter 
		//print_r($_SESSION); die();
		$prefix = '';
		if ($this->prefixSession && ($id = session_id()) !== '') {
			$prefix .= "[$id]";
		}
		// if the prefixUser is selected only prefix with the user name, ignore the user id
		if ($this->prefixUser && ($user = Yii::app()->getComponent('user', false)) !== null) {
				$prefix .= '[' . $user->getName() . ']';
		}
		if ($prefix !== '') {
			foreach ($logs as & $log) {
				$log[0] = $prefix . ' ' . $log[0];
			}
		}
	}
}
