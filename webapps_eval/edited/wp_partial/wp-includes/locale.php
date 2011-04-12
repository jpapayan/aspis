<?php require_once('AspisMain.php'); ?><?php
class WP_Locale{var $weekday;
var $weekday_initial;
var $weekday_abbrev;
var $month;
var $month_abbrev;
var $meridiem;
var $text_direction = 'ltr';
var $locale_vars = array('text_direction');
function init (  ) {
{$this->weekday[0] = __('Sunday');
$this->weekday[1] = __('Monday');
$this->weekday[2] = __('Tuesday');
$this->weekday[3] = __('Wednesday');
$this->weekday[4] = __('Thursday');
$this->weekday[5] = __('Friday');
$this->weekday[6] = __('Saturday');
$this->weekday_initial[__('Sunday')] = __('S_Sunday_initial');
$this->weekday_initial[__('Monday')] = __('M_Monday_initial');
$this->weekday_initial[__('Tuesday')] = __('T_Tuesday_initial');
$this->weekday_initial[__('Wednesday')] = __('W_Wednesday_initial');
$this->weekday_initial[__('Thursday')] = __('T_Thursday_initial');
$this->weekday_initial[__('Friday')] = __('F_Friday_initial');
$this->weekday_initial[__('Saturday')] = __('S_Saturday_initial');
foreach ( $this->weekday_initial as $weekday_ =>$weekday_initial_ )
{$this->weekday_initial[$weekday_] = preg_replace('/_.+_initial$/','',$weekday_initial_);
}$this->weekday_abbrev[__('Sunday')] = __('Sun');
$this->weekday_abbrev[__('Monday')] = __('Mon');
$this->weekday_abbrev[__('Tuesday')] = __('Tue');
$this->weekday_abbrev[__('Wednesday')] = __('Wed');
$this->weekday_abbrev[__('Thursday')] = __('Thu');
$this->weekday_abbrev[__('Friday')] = __('Fri');
$this->weekday_abbrev[__('Saturday')] = __('Sat');
$this->month['01'] = __('January');
$this->month['02'] = __('February');
$this->month['03'] = __('March');
$this->month['04'] = __('April');
$this->month['05'] = __('May');
$this->month['06'] = __('June');
$this->month['07'] = __('July');
$this->month['08'] = __('August');
$this->month['09'] = __('September');
$this->month['10'] = __('October');
$this->month['11'] = __('November');
$this->month['12'] = __('December');
$this->month_abbrev[__('January')] = __('Jan_January_abbreviation');
$this->month_abbrev[__('February')] = __('Feb_February_abbreviation');
$this->month_abbrev[__('March')] = __('Mar_March_abbreviation');
$this->month_abbrev[__('April')] = __('Apr_April_abbreviation');
$this->month_abbrev[__('May')] = __('May_May_abbreviation');
$this->month_abbrev[__('June')] = __('Jun_June_abbreviation');
$this->month_abbrev[__('July')] = __('Jul_July_abbreviation');
$this->month_abbrev[__('August')] = __('Aug_August_abbreviation');
$this->month_abbrev[__('September')] = __('Sep_September_abbreviation');
$this->month_abbrev[__('October')] = __('Oct_October_abbreviation');
$this->month_abbrev[__('November')] = __('Nov_November_abbreviation');
$this->month_abbrev[__('December')] = __('Dec_December_abbreviation');
foreach ( $this->month_abbrev as $month_ =>$month_abbrev_ )
{$this->month_abbrev[$month_] = preg_replace('/_.+_abbreviation$/','',$month_abbrev_);
}$this->meridiem['am'] = __('am');
$this->meridiem['pm'] = __('pm');
$this->meridiem['AM'] = __('AM');
$this->meridiem['PM'] = __('PM');
$trans = __('number_format_decimals');
$this->number_format['decimals'] = ('number_format_decimals' == $trans) ? 0 : $trans;
$trans = __('number_format_decimal_point');
$this->number_format['decimal_point'] = ('number_format_decimal_point' == $trans) ? '.' : $trans;
$trans = __('number_format_thousands_sep');
$this->number_format['thousands_sep'] = ('number_format_thousands_sep' == $trans) ? ',' : $trans;
foreach ( (array)$this->locale_vars as $var  )
{if ( isset($GLOBALS[0][$var]))
 $this->$var = $GLOBALS[0][$var];
}} }
function get_weekday ( $weekday_number ) {
{{$AspisRetTemp = $this->weekday[$weekday_number];
return $AspisRetTemp;
}} }
function get_weekday_initial ( $weekday_name ) {
{{$AspisRetTemp = $this->weekday_initial[$weekday_name];
return $AspisRetTemp;
}} }
function get_weekday_abbrev ( $weekday_name ) {
{{$AspisRetTemp = $this->weekday_abbrev[$weekday_name];
return $AspisRetTemp;
}} }
function get_month ( $month_number ) {
{{$AspisRetTemp = $this->month[zeroise($month_number,2)];
return $AspisRetTemp;
}} }
function get_month_abbrev ( $month_name ) {
{{$AspisRetTemp = $this->month_abbrev[$month_name];
return $AspisRetTemp;
}} }
function get_meridiem ( $meridiem ) {
{{$AspisRetTemp = $this->meridiem[$meridiem];
return $AspisRetTemp;
}} }
function register_globals (  ) {
{$GLOBALS[0]['weekday'] = $this->weekday;
$GLOBALS[0]['weekday_initial'] = $this->weekday_initial;
$GLOBALS[0]['weekday_abbrev'] = $this->weekday_abbrev;
$GLOBALS[0]['month'] = $this->month;
$GLOBALS[0]['month_abbrev'] = $this->month_abbrev;
} }
function WP_Locale (  ) {
{$this->init();
$this->register_globals();
} }
};
?>
<?php 