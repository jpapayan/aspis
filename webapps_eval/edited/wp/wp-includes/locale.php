<?php require_once('AspisMain.php'); ?><?php
class WP_Locale{var $weekday;
var $weekday_initial;
var $weekday_abbrev;
var $month;
var $month_abbrev;
var $meridiem;
var $text_direction = array('ltr',false);
var $locale_vars = array(array(array('text_direction',false)),false);
function init (  ) {
{arrayAssign($this->weekday[0],deAspis(registerTaint(array(0,false))),addTaint(__(array('Sunday',false))));
arrayAssign($this->weekday[0],deAspis(registerTaint(array(1,false))),addTaint(__(array('Monday',false))));
arrayAssign($this->weekday[0],deAspis(registerTaint(array(2,false))),addTaint(__(array('Tuesday',false))));
arrayAssign($this->weekday[0],deAspis(registerTaint(array(3,false))),addTaint(__(array('Wednesday',false))));
arrayAssign($this->weekday[0],deAspis(registerTaint(array(4,false))),addTaint(__(array('Thursday',false))));
arrayAssign($this->weekday[0],deAspis(registerTaint(array(5,false))),addTaint(__(array('Friday',false))));
arrayAssign($this->weekday[0],deAspis(registerTaint(array(6,false))),addTaint(__(array('Saturday',false))));
arrayAssign($this->weekday_initial[0],deAspis(registerTaint(__(array('Sunday',false)))),addTaint(__(array('S_Sunday_initial',false))));
arrayAssign($this->weekday_initial[0],deAspis(registerTaint(__(array('Monday',false)))),addTaint(__(array('M_Monday_initial',false))));
arrayAssign($this->weekday_initial[0],deAspis(registerTaint(__(array('Tuesday',false)))),addTaint(__(array('T_Tuesday_initial',false))));
arrayAssign($this->weekday_initial[0],deAspis(registerTaint(__(array('Wednesday',false)))),addTaint(__(array('W_Wednesday_initial',false))));
arrayAssign($this->weekday_initial[0],deAspis(registerTaint(__(array('Thursday',false)))),addTaint(__(array('T_Thursday_initial',false))));
arrayAssign($this->weekday_initial[0],deAspis(registerTaint(__(array('Friday',false)))),addTaint(__(array('F_Friday_initial',false))));
arrayAssign($this->weekday_initial[0],deAspis(registerTaint(__(array('Saturday',false)))),addTaint(__(array('S_Saturday_initial',false))));
foreach ( $this->weekday_initial[0] as $weekday_ =>$weekday_initial_ )
{restoreTaint($weekday_,$weekday_initial_);
{arrayAssign($this->weekday_initial[0],deAspis(registerTaint($weekday_)),addTaint(Aspis_preg_replace(array('/_.+_initial$/',false),array('',false),$weekday_initial_)));
}}arrayAssign($this->weekday_abbrev[0],deAspis(registerTaint(__(array('Sunday',false)))),addTaint(__(array('Sun',false))));
arrayAssign($this->weekday_abbrev[0],deAspis(registerTaint(__(array('Monday',false)))),addTaint(__(array('Mon',false))));
arrayAssign($this->weekday_abbrev[0],deAspis(registerTaint(__(array('Tuesday',false)))),addTaint(__(array('Tue',false))));
arrayAssign($this->weekday_abbrev[0],deAspis(registerTaint(__(array('Wednesday',false)))),addTaint(__(array('Wed',false))));
arrayAssign($this->weekday_abbrev[0],deAspis(registerTaint(__(array('Thursday',false)))),addTaint(__(array('Thu',false))));
arrayAssign($this->weekday_abbrev[0],deAspis(registerTaint(__(array('Friday',false)))),addTaint(__(array('Fri',false))));
arrayAssign($this->weekday_abbrev[0],deAspis(registerTaint(__(array('Saturday',false)))),addTaint(__(array('Sat',false))));
arrayAssign($this->month[0],deAspis(registerTaint(array('01',false))),addTaint(__(array('January',false))));
arrayAssign($this->month[0],deAspis(registerTaint(array('02',false))),addTaint(__(array('February',false))));
arrayAssign($this->month[0],deAspis(registerTaint(array('03',false))),addTaint(__(array('March',false))));
arrayAssign($this->month[0],deAspis(registerTaint(array('04',false))),addTaint(__(array('April',false))));
arrayAssign($this->month[0],deAspis(registerTaint(array('05',false))),addTaint(__(array('May',false))));
arrayAssign($this->month[0],deAspis(registerTaint(array('06',false))),addTaint(__(array('June',false))));
arrayAssign($this->month[0],deAspis(registerTaint(array('07',false))),addTaint(__(array('July',false))));
arrayAssign($this->month[0],deAspis(registerTaint(array('08',false))),addTaint(__(array('August',false))));
arrayAssign($this->month[0],deAspis(registerTaint(array('09',false))),addTaint(__(array('September',false))));
arrayAssign($this->month[0],deAspis(registerTaint(array('10',false))),addTaint(__(array('October',false))));
arrayAssign($this->month[0],deAspis(registerTaint(array('11',false))),addTaint(__(array('November',false))));
arrayAssign($this->month[0],deAspis(registerTaint(array('12',false))),addTaint(__(array('December',false))));
arrayAssign($this->month_abbrev[0],deAspis(registerTaint(__(array('January',false)))),addTaint(__(array('Jan_January_abbreviation',false))));
arrayAssign($this->month_abbrev[0],deAspis(registerTaint(__(array('February',false)))),addTaint(__(array('Feb_February_abbreviation',false))));
arrayAssign($this->month_abbrev[0],deAspis(registerTaint(__(array('March',false)))),addTaint(__(array('Mar_March_abbreviation',false))));
arrayAssign($this->month_abbrev[0],deAspis(registerTaint(__(array('April',false)))),addTaint(__(array('Apr_April_abbreviation',false))));
arrayAssign($this->month_abbrev[0],deAspis(registerTaint(__(array('May',false)))),addTaint(__(array('May_May_abbreviation',false))));
arrayAssign($this->month_abbrev[0],deAspis(registerTaint(__(array('June',false)))),addTaint(__(array('Jun_June_abbreviation',false))));
arrayAssign($this->month_abbrev[0],deAspis(registerTaint(__(array('July',false)))),addTaint(__(array('Jul_July_abbreviation',false))));
arrayAssign($this->month_abbrev[0],deAspis(registerTaint(__(array('August',false)))),addTaint(__(array('Aug_August_abbreviation',false))));
arrayAssign($this->month_abbrev[0],deAspis(registerTaint(__(array('September',false)))),addTaint(__(array('Sep_September_abbreviation',false))));
arrayAssign($this->month_abbrev[0],deAspis(registerTaint(__(array('October',false)))),addTaint(__(array('Oct_October_abbreviation',false))));
arrayAssign($this->month_abbrev[0],deAspis(registerTaint(__(array('November',false)))),addTaint(__(array('Nov_November_abbreviation',false))));
arrayAssign($this->month_abbrev[0],deAspis(registerTaint(__(array('December',false)))),addTaint(__(array('Dec_December_abbreviation',false))));
foreach ( $this->month_abbrev[0] as $month_ =>$month_abbrev_ )
{restoreTaint($month_,$month_abbrev_);
{arrayAssign($this->month_abbrev[0],deAspis(registerTaint($month_)),addTaint(Aspis_preg_replace(array('/_.+_abbreviation$/',false),array('',false),$month_abbrev_)));
}}arrayAssign($this->meridiem[0],deAspis(registerTaint(array('am',false))),addTaint(__(array('am',false))));
arrayAssign($this->meridiem[0],deAspis(registerTaint(array('pm',false))),addTaint(__(array('pm',false))));
arrayAssign($this->meridiem[0],deAspis(registerTaint(array('AM',false))),addTaint(__(array('AM',false))));
arrayAssign($this->meridiem[0],deAspis(registerTaint(array('PM',false))),addTaint(__(array('PM',false))));
$trans = __(array('number_format_decimals',false));
arrayAssign($this->number_format[0],deAspis(registerTaint(array('decimals',false))),addTaint((('number_format_decimals') == $trans[0]) ? array(0,false) : $trans));
$trans = __(array('number_format_decimal_point',false));
arrayAssign($this->number_format[0],deAspis(registerTaint(array('decimal_point',false))),addTaint((('number_format_decimal_point') == $trans[0]) ? array('.',false) : $trans));
$trans = __(array('number_format_thousands_sep',false));
arrayAssign($this->number_format[0],deAspis(registerTaint(array('thousands_sep',false))),addTaint((('number_format_thousands_sep') == $trans[0]) ? array(',',false) : $trans));
foreach ( deAspis(array_cast($this->locale_vars)) as $var  )
{if ( ((isset($GLOBALS[0][$var[0]]) && Aspis_isset( $GLOBALS [0][$var[0]]))))
 $this->$var[0] = attachAspis($GLOBALS,$var[0]);
}} }
function get_weekday ( $weekday_number ) {
{return $this->weekday[0][$weekday_number[0]];
} }
function get_weekday_initial ( $weekday_name ) {
{return $this->weekday_initial[0][$weekday_name[0]];
} }
function get_weekday_abbrev ( $weekday_name ) {
{return $this->weekday_abbrev[0][$weekday_name[0]];
} }
function get_month ( $month_number ) {
{return $this->month[0][deAspis(zeroise($month_number,array(2,false)))];
} }
function get_month_abbrev ( $month_name ) {
{return $this->month_abbrev[0][$month_name[0]];
} }
function get_meridiem ( $meridiem ) {
{return $this->meridiem[0][$meridiem[0]];
} }
function register_globals (  ) {
{arrayAssign($GLOBALS[0],deAspis(registerTaint(array('weekday',false))),addTaint($this->weekday));
arrayAssign($GLOBALS[0],deAspis(registerTaint(array('weekday_initial',false))),addTaint($this->weekday_initial));
arrayAssign($GLOBALS[0],deAspis(registerTaint(array('weekday_abbrev',false))),addTaint($this->weekday_abbrev));
arrayAssign($GLOBALS[0],deAspis(registerTaint(array('month',false))),addTaint($this->month));
arrayAssign($GLOBALS[0],deAspis(registerTaint(array('month_abbrev',false))),addTaint($this->month_abbrev));
} }
function WP_Locale (  ) {
{$this->init();
$this->register_globals();
} }
};
?>
<?php 