<?php

if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
//php5.5以下兼容
if (!function_exists('array_column')) {
	function array_column($array, $column_name)
	{
		return array_map(function ($element) use ($column_name) {
			return $element[$column_name];
		}, $array);
	}
}
class csubase
{
	public static function json_file($file, $content = '')
	{
		if ($content) {
			return file_put_contents($file, self::json_encode($content));
		}

		return self::json_decode(file_get_contents($file));
	}

	public static function json_decode($file)
	{
		return self::iconv(json_decode($file, true), 'UTF-8', CHARSET);
	}

	public static function json_encode($content, $rule = '')
	{
		if (!$rule) {
			$rule = JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT;
		}

		return json_encode(self::iconv($content, CHARSET, 'UTF-8'), $rule);
	}

	public static function showmessage($data = [])
	{
		header('content-type:application/json;');

		exit(self::json_encode($data));
	}

	public static function showsuccess($msg, $url)
	{
		showmessage($msg, $url, [], ['alert' => 'right', 'locationtime' => true, 'msgtype' => 2, 'showdialog' => true, 'showmsg' => true]);
	}

	public static function iconv($data, $in_charset, $out_charset)
	{
		if ($in_charset == $out_charset) {
			return $data;
		}

		if (is_array($data)) {
			foreach ($data as $key => $value) {
				$data[$key] = self::iconv($value, $in_charset, $out_charset);
			}

			return $data;
		}

		return diconv($data, $in_charset, $out_charset);
	}

	public static function getMod($value)
	{
		return str_replace(['.', '..'], [], daddslashes($value));
	}

	public static function mktime($date)
	{
		list($date, $time) = explode(' ', $date);
		$date = explode('-', $date);
		$time = explode(':', $time);

		return mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]);
	}

	public static function isAjax()
	{
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 'xmlhttprequest' == strtolower($_SERVER['HTTP_X_REQUESTED_WITH']);
	}

	public static function system_notice($uid, $subject, $message = '')
	{
		notification_add($uid, 'system', 'system_notice', [
			'subject' => $subject,
			'message' => $message,
			'from_id' => 0,
			'from_idtype' => 'sendnotice',
		], 1);
	}
}
