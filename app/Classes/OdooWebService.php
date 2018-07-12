<?php

namespace App\Classes;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\t_log;
use App\User;
use Ripcord\Ripcord;




class OdooWebService {

  private $url;
  private $clientModels;
  private $db;
  private $uid;
  private $password;

  /**
   * Init webservice
   *
   * @param String $str_username
   * @param String $str_password
   * @return
   *
   * Bargoin Lukas - 25/04/2018
   */
  public function __construct(){
    $this->url = "http://192.168.1.99:99";
    $this->db = "db";
    $username = "stage@yopmail.com";
    $this->password = "stage2018";

    /*
    if(Route::getEnvironment() == 'dev' && $_SERVER['SERVER_NAME'] == '192.168.0.99'){
      $this->url = "http://".$_SERVER['SERVER_NAME'].":99";
      $this->db = "db";
      $username = "lukas@octipas.com";
      $this->password = "admin";
      //$username = "lukas@bonnegueule.fr";
      //$this->password = "lukas";
    }
    */

    try {
      $clientCommon = new Ripcord->client('https://demo.odoo.com/start')->start();
list($url, $db, $username, $password) =
  array($info['host'], $info['database'], $info['user'], $info['password']);
      //$clientCommon = new Ripcord->client("$this->url/xmlrpc/2/common");
    } catch(Exception $e){
      var_dump($e);
      exit;
    }

    try {
      $this->uid = $clientCommon->call('authenticate', array($this->db, $username, $this->password, array()));
    } catch(SoapFault $sf) {
      error_log('sf = '.json_encode($sf));
      exit;
    }

    //var_dump($this->uid); exit;
  }

  /**
   * call to Odoo external api
   *
   * @param String
   * @param Array
   * @param Array
   * @return The response of the call
   *
   * Bargoin Lukas
   */
  function odooCall($str_model, $str_method, $array_params, $array_params_mapping = null){
    try {
      $clientModels = new ZendClient("$this->url/xmlrpc/2/object");
    } catch(Exception $e){
      var_dump($e);
      exit;
    }

    $return_odoo = $clientModels->call("execute_kw",
      array($this->db, $this->uid, $this->password, $str_model, $str_method, $array_params, $array_params_mapping));

    return $return_odoo;
  }


}
