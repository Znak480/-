<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/bx_root.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/start.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/classes/general/virtual_io.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/classes/general/virtual_file.php');

$managerDB = new CBitrixTrialManagerDatabase();
$managerSite = new CBitrixTrialManagerSite();

$errors = '';
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_REQUEST['expire_save'])) {
	$expireDay = intval($_REQUEST['expire_date_day']);
	$expireMonth = intval($_REQUEST['expire_date_month']);
	$expireYear = intval($_REQUEST['expire_date_year']);
	
	$expireDate = mktime(0, 0, 0, $expireMonth, $expireDay, $expireYear);
	if (!$managerDB->setExpireDate($expireDate)) {
		$errors .= 'Can\'t save DB expire date!<br>';
	} elseif (!$managerSite->setExpireDate($expireDate)) {
		$errors .= 'Can\'t save Site expire date!<br>';
	} else {
		$message = 'Expire date updated!';
	}
}

$expireDateDB = $managerDB->getExpireDate();
$expireDaysDB = floor(($expireDateDB - time()) / (60*60*24));

$expireDateSite = $managerSite->getExpireDate();
$expireDaysSite = floor(($expireDateSite - time()) / (60*60*24));
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Bitrix trial manager</title>
	
	<style type="text/css">
		.layout{width: 400px;padding: 10px;border: 1px dashed #aaa;margin: 0 auto;font: 14px/1 Arial;}
		.main{border-collapse: collapse;width: 100%;color: #777;}
		.main tr{width: 100%;}
		.main tr td{padding: 3px 2px;}
		.center{text-align: center;}
		.right{text-align: right;}
		.bt{border-top: 1px solid #aaa;}
		.br{border-right: 1px solid #aaa;}
		.bb{border-bottom: 1px solid #aaa;}
		.bl{border-left: 1px solid #aaa;}
	</style>
</head>
<body>
	<div class="layout">
		<form name="form_expire" method="post" action="">
		<table class="main">
			<tr>
				<td colspan="3" class="center" style="padding-bottom: 7px;">
					<img src="data:image/gif;base64,R0lGODlhFAAVAPcAAPXt7vmxvP49WuI5UvWHmPz///r//+5JYvUuS/Y1Uv02VO/K0PnDyu1WbeEiPt0ZNuIaOPcqSf76+/X9/O9ne/VfduRkd9wRL90XNO0uSvvc4PXY3PjR1+IeO+w3UuEmQuVKYfRBXO3EyuUhP+0oRvevuv00Uulgdeldct0OLetyhOgiP+gfPetTaf8/XPo8WdwWM90UMvc5VdwTMdsMK/EoRu4hQN0NLPj///7//90YNe4qSOsjQfiwu/79/egnRPDL0NsKKesqR/rT2eZsff9AXepmefDe4OiZpfXP1fv29++wufOJmfGxu+I2UN8fO+ZUafnS2frw8dsOLN4aN/X//u2HlvsvT/a5wfBacd8TMfWNne7Jz/vQ1/eGmN4PLvqtufuXpvZZcelMY/js7vd6jfEiQvhtgvHM0e1leulwg+ZHX+9ofPf//+Y8VeEUM+JWa+ebpvJvg/s4VvosS/nv8PSqtfrByflSa94bOPGbqO+Vo+VWa+/x8PLz8+zJzuodPP5BXvnx8uy/xuQQMOYqRvrm6OYvS9wNK/Lk5/T+/Pb9/eWIluy1ve+Mm/qGmPErSfTX2/IvTO7s7Omqs+6jru53ifJkevNpfv729+5FXu9ZcOvN0fW2wOJLYeBPZe+6w+ertOtqfeE9VvhDX/syUfs0UuAYNfVOaPIxT/ClsOZ6iuUaOPjZ3uUdO+tNZPrr7vQuTfF1iPpIY+mXpOt6i+h+jex+j+ktSfG8xPCqtPn///GSoPzq7OJAWOk4U+tsf/ewu+u1vfOCk+QPL/zt8Pw/XN8ZNt4tR942TuIRMO/d4OYVNPs/XNwKKfve4u+8xPng5Pni5vrg5e2osvGgrP0vTuhjd+hfc+pec/lgePn9/d0PLu/N0vRUbOJneudne90fPPvt8Pr3+P45WPMnRvScqei1veqRnuyVovzz9P7y9OZWa+c1UO/y8vU6V/jJ0PXo6/fp6/P5+N4VM/Dz8/OLm/auufGXpfNedfFcc/9CX/hNaOsmRPSrt////yH/C1hNUCBEYXRhWE1QPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS4wLWMwNjAgNjEuMTM0Nzc3LCAyMDEwLzAyLzEyLTE3OjMyOjAwICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M1IFdpbmRvd3MiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6QkI2NzhCOTQwNTM0MTFFMkFEQUNGNDQ2RkUxMEVFNUUiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6QkI2NzhCOTUwNTM0MTFFMkFEQUNGNDQ2RkUxMEVFNUUiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpCQjY3OEI5MjA1MzQxMUUyQURBQ0Y0NDZGRTEwRUU1RSIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpCQjY3OEI5MzA1MzQxMUUyQURBQ0Y0NDZGRTEwRUU1RSIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PgH//v38+/r5+Pf29fTz8vHw7+7t7Ovq6ejn5uXk4+Lh4N/e3dzb2tnY19bV1NPS0dDPzs3My8rJyMfGxcTDwsHAv769vLu6ubi3trW0s7KxsK+urayrqqmop6alpKOioaCfnp2cm5qZmJeWlZSTkpGQj46NjIuKiYiHhoWEg4KBgH9+fXx7enl4d3Z1dHNycXBvbm1sa2ppaGdmZWRjYmFgX15dXFtaWVhXVlVUU1JRUE9OTUxLSklIR0ZFRENCQUA/Pj08Ozo5ODc2NTQzMjEwLy4tLCsqKSgnJiUkIyIhIB8eHRwbGhkYFxYVFBMSERAPDg0MCwoJCAcGBQQDAgEAACH5BAAAAAAALAAAAAAUABUAAAj/AP8JFOhDQpcy2s54CaBhoEOHXlqBseZCADkTsx71evhPQpR/YoAEUBDIRZF9AhTgGeIwRxhMuyqgCVCqGakXCgQYU8CPpcA7Vyi0yQekBx1UInLJkjHnhSlvdf5lqhCBDQ59C3pECGHv2bZ77xLIQMArBwMECCjgyAKkRLkQlloQ+BdMUoJYB+QNqwEpDY5NQO6Z0bRM0KUtOeTUSLUDVIMdJE7gaADEn40MrzisOxANC4kMNtJ5EMIDG44WXOywEAJozDgmlQx56MdDDa4fLCRn69aJ2Y8VhxKZoyXl1woW4NqNcLUGhwpqsNwQI0RkgqhGSQqNYGULBYQOHyIxvPClbhq6OH2agKi3580IZUj0fOmgBdi/WyDgKSFTbYCweAOcAoEDImjwAT1UxKDKP7p4ggIUFnCyiBHc5MHNJ378U0sQD9DzgBXiFAAAABNswM4FOmAAwzkG/FPMKIg8gAENTqiAjyPXOMBNiimsMs9AHAxAgw4PzBDEBVPQAMMDMKRgwSQFOCQNHzMgMgMGOugAwwU3hMOIO1E+5MMScCBzjDMpPJHMN38okgNHAxWwATSUhDLIEVWEOVBAADs=" alt="" />
					<span class="logo" style="font-size: 18px; line-height: 20px; vertical-align: top; color: #333; padding-bottom: 3px">
						Bitrix trial manager. Version 0.1 private.
					</span>
				</td>
			</tr>
			<tr>
				<td colspan="3" style="text-align: center; color: #333;">
					Trial expiration information
				</td>
			</tr>
			<tr class="bt">
				<td>DB expire date:</td>
				<td colspan="2" class="right"><?php echo date('d/m/Y', $expireDateDB); ?> (<?php echo $expireDaysDB;?> days left)</td>
			</tr>
			<tr class="bb">
				<td>Site expire date:</td>
				<td colspan="2" class="right"><?php echo date('d/m/Y', $expireDateSite); ?>  (<?php echo $expireDaysSite;?> days left)</td>
			</tr>
			<tr>
				<td colspan="3" style="text-align: center; color: #333; padding-top: 10px;">
					Set new expire date for DB and Site
				</td>
			</tr>
			<?php if (!empty($errors)) : ?>
			<tr>
				<td colspan="3" style="text-align: center; color: #f00;">
					<?php echo $errors; ?>
				</td>
			</tr>
			<?php endif; ?>
			<?php if (!empty($message)) : ?>
			<tr>
				<td colspan="3" style="text-align: center; color: #0f0;">
					<?php echo $message; ?>
				</td>
			</tr>
			<?php endif; ?>
			<tr>
				<td>Expire date (d/m/yyyy):</td>
				<td style="white-space: nowrap;">
					<?php $expireDayDB = intval(date('d', $expireDateDB)); ?>
					<select name="expire_date_day">
					<?php for($i = 1; $i < 32; $i++) : ?>
					<option value="<?php echo $i;?>"<?php echo ($expireDayDB == $i ? " selected" : "")?>><?php printf('%02u', $i);?>
					<?php endfor;?>
					</select>
					/
					<?php $expireMonthDB = intval(date('m', $expireDateDB)); ?>
					<select name="expire_date_month">
					<?php for($i = 1; $i < 13; $i++) : ?>
					<option value="<?php echo $i;?>"<?php echo ($expireMonthDB == $i ? " selected" : "")?>><?php printf('%02u', $i);?>
					<?php endfor;?>
					</select>
					/
					<?php $curYear = date('Y', time()); ?>
					<select name="expire_date_year">
					<?php for($i = $curYear; $i < $curYear + 11; $i++) : ?>
					<option value="<?php echo $i;?>"<?php echo ($curYear + 10 == $i ? " selected" : "")?>><?php echo $i;?>
					<?php endfor;?>
					</select>
				</td>
				<td>
					<input type="submit" name="expire_save" value="Save" />
				</td>
			</tr>
		</table>
		</form>
	</div>
</body>
</html>
<?php
abstract class CBitrixTrialManagerAbstract
{
	public function getExpireDate(){
		$siteExpireDate = $this->getTrialDateDefault();
		
		$trialBase64 = $this->getTrialDateBase64();
		if (empty($trialBase64)) {
			return $siteExpireDate;
		}

		$gamma = $this->getCryptGamma();
		$gammaLen = strlen($gamma);
		
		$trialEncoded = base64_decode($trialBase64);
		$trialDecoded = '';
		
		$j = 0;
		for($i = 0; $i < strlen($trialEncoded); $i++){
			$trialDecoded .= chr(ord($trialEncoded[$i]) ^ ord($gamma[$j]));
			if ($j == $gammaLen - 1)
				$j = 0;
			else
				$j = $j + 1;
		}

		$siteExpireDate = mktime(
			0,
			0,
			0,
			intval($this->getTrialDateMonth($trialDecoded)),
			intval($this->getTrialDateDay($trialDecoded)),
			intval($this->getTrialDateYear($trialDecoded))
		);
		return $siteExpireDate;
	}
	
	public function setExpireDate($timeStamp){
		
		$trialHash = '';
		for ($i = 0; $i < 22; $i++) {
			$trialHash .= chr(mt_rand(30, 90));
		}
		$trialHash = $this->setTrialDateDay($trialHash, date('d', $timeStamp));
		$trialHash = $this->setTrialDateMonth($trialHash, date('m', $timeStamp));
		$trialHash = $this->setTrialDateYear($trialHash, date('Y', $timeStamp));
		
		$gamma = $this->getCryptGamma();
		$gammaLen = strlen($gamma);
		$trialEncoded = '';
		
		$j = 0;
		for($i = 0; $i < strlen($trialHash); $i++){
			$trialEncoded .= chr(ord($trialHash[$i]) ^ ord($gamma[$j]));
			if ($j == $gammaLen - 1)
				$j = 0;
			else
				$j = $j + 1;
		}
		$trialBase64 = base64_encode($trialEncoded);
		
		return $this->setTrialDateBase64($trialBase64);
	}
	
	abstract protected function getTrialDateDefault();
	abstract protected function getTrialDateBase64();
	abstract protected function setTrialDateBase64($date);
	abstract protected function getCryptGamma();
	abstract protected function getTrialDateDay($trialHash);
	abstract protected function setTrialDateDay($trialHash, $day);
	abstract protected function getTrialDateMonth($trialHash);
	abstract protected function setTrialDateMonth($trialHash, $month);
	abstract protected function getTrialDateYear($trialHash);
	abstract protected function setTrialDateYear($trialHash, $year);
}

class CBitrixTrialManagerDatabase extends CBitrixTrialManagerAbstract
{
	protected function getTrialDateDefault() {
		return 1;
	}
	protected function getTrialDateBase64() {
		return COption::GetOptionString('main', 'admin_passwordh');
	}
	protected function setTrialDateBase64($date) {
		return COption::SetOptionString('main', 'admin_passwordh', $date);
	}
	protected function getCryptGamma() {
		return 'thRH4u67fhw87V7Hyr12Hwy0rFr';
	}
	protected function getTrialDateDay($trialHash) {
		return ($trialHash[1] . $trialHash[14]);
	}
	protected function setTrialDateDay($trialHash, $day) {
		$trialHash[1] = $day[0];
		$trialHash[14] = $day[1];
		return $trialHash;
	}
	protected function getTrialDateMonth($trialHash) {
		return ($trialHash[6] . $trialHash[3]);
	}
	protected function setTrialDateMonth($trialHash, $month) {
		$trialHash[6] = $month[0];
		$trialHash[3] = $month[1];
		return $trialHash;
	}
	protected function getTrialDateYear($trialHash) {
		return ($trialHash[10] . $trialHash[18] . $trialHash[7] . $trialHash[12]);
	}
	protected function setTrialDateYear($trialHash, $year) {
		$trialHash[10] = $year[0];
		$trialHash[18] = $year[1];
		$trialHash[7] = $year[2];
		$trialHash[12] = $year[3];
		return $trialHash;
	}
}

class CBitrixTrialManagerSite extends CBitrixTrialManagerAbstract
{

	protected $_fileName = '/bitrix/modules/main/admin/define.php';
	
	protected function getTrialDateDefault() {
		return 2;
	}
	protected function getTrialDateBase64() {
		@include_once($_SERVER['DOCUMENT_ROOT'] . $this->_fileName);
		if (defined('TEMPORARY_CACHE')){
			return constant('TEMPORARY_CACHE');
		}
		return '';
	}
	protected function setTrialDateBase64($date) {
		$data = '<?define("TEMPORARY_CACHE", "' . $date . '");?>';
		return (file_put_contents($_SERVER['DOCUMENT_ROOT'] . $this->_fileName, $data) !== false);
	}
	protected function getCryptGamma() {
		return 'DO_NOT_STEAL_OUR_BUS';
	}
	protected function getTrialDateDay($trialHash) {
		return ($trialHash[9] . $trialHash[2]);
	}
	protected function setTrialDateDay($trialHash, $day) {
		$trialHash[9] = $day[0];
		$trialHash[2] = $day[1];
		return $trialHash;
	}
	protected function getTrialDateMonth($trialHash) {
		return ($trialHash[6] . $trialHash[16]);
	}
	protected function setTrialDateMonth($trialHash, $month) {
		$trialHash[6] = $month[0];
		$trialHash[16] = $month[1];
		return $trialHash;
	}
	protected function getTrialDateYear($trialHash) {
		return ($trialHash[12] . $trialHash[7] . $trialHash[14] . $trialHash[3]);
	}
	protected function setTrialDateYear($trialHash, $year) {
		$trialHash[12] = $year[0];
		$trialHash[7] = $year[1];
		$trialHash[14] = $year[2];
		$trialHash[3] = $year[3];
		return $trialHash;
	}
}
?>