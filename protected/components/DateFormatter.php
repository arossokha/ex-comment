<?php
/**
 * Format dates
 * @author: Artem Rossokha <artiom.rossokha@iqria.com>
 */
class DateFormatter
{
	public static $parseDateFormat = 'd/m/Y';

	public static function dateToUTC($date)
	{

//		$d = DateTime::createFromFormat(self::$parseDateFormat, $date);
//
//		if($d){
//			return $d->format('Y-m-d');
//		}

		try {
			$v = explode('/',$date);
			$k = explode('/',self::$parseDateFormat);
			$res = array();
			foreach($v as $key => $it){
				$res[$k[$key]] = $it;
			}

			if(!$res['Y'] || !$res['m'] || !$res['d']){
				return "";
			}
			return "{$res['Y']}-{$res['m']}-{$res['d']}";
		}
		catch(Exception $e){
			return "";
		}
		return "";
	}
}
