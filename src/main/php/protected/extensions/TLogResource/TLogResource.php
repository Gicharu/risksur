<?php
/**
 * TLogResource 
 * 
 * @uses CApplicationComponent
 * @package 
 * @version $id$
 * @copyright Tracetracker
 * @author Eric Thuku <eric@tracetracker.com> 
 * @license Tracetracker {@link http://www.tracetracker.com}
 */
class TLogResource extends CApplicationComponent {
	const LOG_CAT = "ext.TLogResource";

	/**
	 * See https://tracetracker.atlassian.net/wiki/display/ENV/Robustness+and+consistency#Robustnessandconsistency-Logging
	 * This will return the log level, based on how long the query took.
	 * @param integer $time Milliseconds the query took
	 * @return void 
	 */
	public static function getLogLevel( $time ) {
		if( $time >= 5000) {
			return "warning";
		}
		if( $time >= 1000) {
			return "info";
		}
		return "trace";
	}
}