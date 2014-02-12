<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function zerofill ($num, $zerofill = 5)
{
	return str_pad($num, $zerofill, '0', STR_PAD_LEFT);
}

function date_select($inname, $date = 0)
{
	/* create array so we can name months */
	$monthname = array(1=> "January", "February", "March",
	"April", "May", "June", "July", "August",
	"September", "October", "November", "December");

	/* if date invalid or not supplied, use current time */
	if ($date === 0) {
		$date = new DateTime();
		$now = new DateTime();
	} else {
		$date = new DateTime($date);
		$now = new DateTime();
	}

	/* make month selector */
	$date_select = "<select name=\"" . $inname . "_month\" id=\"" . $inname . "_month\">\n";
	$date_select .= "<option value=''> </option>";
	for ($currentMonth = 1; $currentMonth <= 12; $currentMonth++) {
		$date_select .= "<option value=\"";
		$date_select .= intval($currentMonth);
		$date_select .= "\"";
		if (intval($date->format('m')) == $currentMonth) {
			$date_select .= " selected='selected'";
		}
		$date_select .= ">" . $monthname[$currentMonth] . "</option>\n";
	}
	$date_select .= "</select>";

	/* make day selector */
	$date_select .= "<select name=\"" . $inname . "_day\" id=\"" . $inname . "_day\">\n";
	$date_select .= "<option value=''> </option>";
	for ($currentDay=1; $currentDay <= 31; $currentDay++) {
		$date_select .= "<option value=\"$currentDay\"";
		if (intval($date->format('d')) == $currentDay) {
			$date_select .= " selected='selected'";
		}
		$date_select .= ">$currentDay</option>\n";
	}
	$date_select .= "</select>";

	/* make year selector */
	$date_select .= "<select name=\"" . $inname . "_year\" id=\"" . $inname . "_year\">\n";
	$startYear = intval($now->format('Y'));
	$date_select .= "<option value=''> </option>";
	for ($currentYear = $startYear - 120; $currentYear <= $startYear; $currentYear++) {
		$date_select .= "<option value=\"$currentYear\"";
		if ($date->format('Y') == $currentYear) {
			$date_select .= " selected='selected'";
		}
		$date_select .= ">$currentYear</option>\n";
	}
	$date_select .= "</select>";

	return $date_select;
}