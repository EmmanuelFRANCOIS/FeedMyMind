<?php

/**
 * @class   Lclz
 * @summary Class to provide localization functions
 */
class Lclz {

  /**
   * @function fmtMoney()
   * @summary Function to format money numbers
   */
  public static function fmtMoney( $number ) {
    include "../../../utils/config.php";
    $MoneyFormater = new \NumberFormatter( $config['locale'], \NumberFormatter::CURRENCY );
    return $MoneyFormater->format( $number );
  }

  
  /**
   * @function fmtCustomerId()
   * @summary Function to format money numbers
   */
  public static function fmtCustomerId( $id ) {
    include "../../../utils/config.php";
    $CustomerIdFormater = new \NumberFormatter( $config['locale'], NumberFormatter::DECIMAL );
    $CustomerIdFormater->setAttribute(\NumberFormatter::INTEGER_DIGITS, 8);
    $CustomerIdFormater->setAttribute(\NumberFormatter::FRACTION_DIGITS, 0);
    $CustomerIdFormater->setAttribute(\NumberFormatter::GROUPING_USED, true);
    $CustomerIdFormater->setSymbol(\NumberFormatter::GROUPING_SEPARATOR_SYMBOL, '-');
    return 'CST-' . $CustomerIdFormater->format( $id );
  }

  
  /**
   * @function fmtDate()
   * @summary  Function to format Date & Time
   * @param    fmtDate Date format tp apply
   * @param    fmtTime Date format tp apply
   * @return   Formatted Date/Time
   */
  public static function fmtDateTime( $datetime, $fmtDate, $fmtTime ) {
    include "../../../utils/config.php";
    switch ($fmtDate) {
      case 'LONG'   : $dateFmtr = IntlDateFormatter::LONG;   break;
      case 'MEDIUM' : $dateFmtr = IntlDateFormatter::MEDIUM; break;
      case 'SHORT'  : $dateFmtr = IntlDateFormatter::SHORT;  break;
      case 'NONE'   : $dateFmtr = IntlDateFormatter::NONE;   break;
      default       : $dateFmtr = IntlDateFormatter::LONG;   break;
    }
    switch ($fmtTime) {
      case 'LONG'   : $timeFmtr = IntlDateFormatter::LONG;   break;
      case 'MEDIUM' : $timeFmtr = IntlDateFormatter::MEDIUM; break;
      case 'SHORT'  : $timeFmtr = IntlDateFormatter::SHORT;  break;
      case 'NONE'   : $timeFmtr = IntlDateFormatter::NONE;   break;
      default       : $timeFmtr = IntlDateFormatter::LONG;   break;
    }
    $DateFormater = datefmt_create(
      str_replace( '-', '_', $config['locale'] ),
      $dateFmtr,
      $timeFmtr,
      'Europe/Paris',
      IntlDateFormatter::GREGORIAN
    );
    return datefmt_format( $DateFormater, $datetime );
  }

  
}
?>