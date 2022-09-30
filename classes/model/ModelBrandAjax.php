<?php
// DB Connexion Utility
require_once('DBUtils.php');


// Action Switcher
$action = isset($_POST['action']) ? $_POST['action'] : 'list';
switch( $action ) {
  case 'list'  : return getAllBrands( $_POST['options'] ); break;
  case 'sheet' : return getBrand(  $_POST['options'] ); break;
  case 'allstats' : return getAllBrandsStats( $_POST['options'] ); break;
  case 'stats' : return getBrandStats( $_POST['options'] ); break;
}



/**
 * @function  getAllBrands()
 * @summary   Function to get a list of Brands
 * @param     options Query options
 * @return    Json data
 */
function getAllBrands( $options ) {
  // can not Call ModelBrand::getBrands()
  // Must return json !!! for datatables !
}


/**
 * @function  getBrand()
 * @summary   Function to get a specific Brand
 * @param     options Query options
 * @return    Json data
 */
function getBrand( $options ) {

}


/**
 * @function  getAllBrandsStats()
 * @summary   Function to get a specific Brand
 * @param     options Query options
 * @return    Json data
 */
function getAllBrandsStats( $options ) {

}


/**
 * @function  getBrandStats()
 * @summary   Function to get a specific Brand
 * @param     options Query options
 * @return    Json data
 */
function getBrandStats( $options ) {

}


