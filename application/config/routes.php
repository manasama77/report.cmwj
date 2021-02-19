<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'ExportController/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['wwt01']       = 'LoginController/wwt01';
$route['get_ph102']   = 'LoginController/get_ph102';
$route['get_ph103']   = 'LoginController/get_ph103';
$route['get_ph302']   = 'LoginController/get_ph302';
$route['get_ph307']   = 'LoginController/get_ph307';
$route['get_fiq101a'] = 'LoginController/get_fiq101a';
$route['get_cia1']    = 'LoginController/get_cia1';
$route['get_ciaa']    = 'LoginController/get_ciaa';
$route['get_ciab']    = 'LoginController/get_ciab';

$route['export_pdf']              = 'ExportController/index';
$route['alarmhistory/show']       = 'ExportController/show_alarm';
$route['chart/show_chart_wwt1']   = 'ExportController/show_chart_wwt1';
$route['chart/show_chart_wwt2']   = 'ExportController/show_chart_wwt2';
$route['chart/show_chart_mixbed'] = 'ExportController/show_chart_mixbed';
$route['chart/show_chart_diro']   = 'ExportController/show_chart_diro';

$route['export_pdf_alarm_history/(:any)/(:any)/(:any)'] = 'ExportController/export_pdf_alarm_history/$1/$2/$3';
$route['export_pdf_chart_history'] = 'ExportController/export_pdf_chart_history';
