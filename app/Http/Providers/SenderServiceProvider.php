<?php

namespace App\Http\Providers;

use Exception;

use App\Classes\PrestaShopWebservice;
use Illuminate\Support\ServiceProvider;
//use Zend\XmlRpc\Client as ZendClient;
//require_once __DIR__ . '/../../Classes/ripcord.php';

use PhpXmlRpc\Client;
use PhpXmlRpc\Request;
use PhpXmlRpc\Value;

/**
 * @author FAIZA Mohamed Iheb & LEE San Wei
 *
 * Send HTTP Requests to Prestashop, Odoo or any other API.
 *
 * Undocumented class
 */
class SenderServiceProvider extends ServiceProvider
{

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        // Within the register method, you should only bind things into the service container.
    }

    public function boot()
    {
        // This method is called after all other service providers have been registered.
    }

    /**
     * @author FAIZA Mohamed Iheb
     * 
     * Send data to any destination.
     * 
     * @param string $url Url to send data to.
     * @param array $data Array of data to send
     * @param string $method Http method (GET, POST, PUT, DELETE)
     * 
     */
    public static function send($url, $data, $method)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        // Send array
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        // Send Json
        //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);

        // Fixes the infinite response waiting
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 1000);
        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);

        // Executes request
        $server_output = curl_exec($ch);

        curl_close($ch);
    }

    /**
     * @author LEE San Wei
     * 
     * Send data to Odoo
     * 
     * @param string $resource APIResource (customer, product, ...)
     * @param array $data Data array to send
     * @param string $method method that will be used(create, write,unlink, search )
     * 
     */
    public static function sendToOdoo($url, $db, $username, $password, $data, $method, $resource)
    {
        $common = new Client("$url/xmlrpc/2/common");

        $uid = $common->send(new Request('authenticate', array(new Value($db), new Value($username), new Value($password), new Value(array(), 'array'))));

        $uid = $uid->val->me['int'];

        $models = new Client("$url/xmlrpc/2/object");

        //Need to add column 'idPresta' at Odoo
        if($method == 'write'|| $method == 'unlink'){
            $getId[] = new Value(array(new Value($data['condition']),new Value('='),new Value($data['condition1'])),'array');

            $testId[] = new Value($getId, 'array');

            $id = $models->send(new Request('execute_kw', array(new Value($db), new Value($uid, 'int'), new Value($password), new Value($resource), new Value('search'), new Value($testId, 'array'))));
           

            $id = $id->val->me['array'][0]->me['int'];
            

            $testdata[] = new Value(array(new Value($id, 'int')), 'array');

        }
        
        
        if($method == 'read'){

            $dataRPC = new Value(array(new Value($data['filter'])),'array');
            $dataTest['fields'] = $dataRPC;


            $result = $models->send(new Request('execute_kw', array(new Value($db), new Value($uid, 'int'), new Value($password), new Value($resource), new Value($method), new Value(array(new Value($data['id'],'int')),'array'),new Value($dataTest,'struct'))));
            

            return $result;
        }
    

        if ($method == 'create' || $method == 'write') {
           
            $dataRPC = array();
            
            foreach ($data as $key => $value) {
                if($key == 'condition' || $key == 'condition1'){

                }
                elseif($resource == 'pos.order.line'){
                $dataRPC[$key] = new Value($value,'int');
                    
                    

                }
                elseif($resource == 'pos.order.web'){
                    if($key == 'order_id'|| $key == 'customer_id'){
                        $dataRPC[$key] = new Value($value,'int');
                    }else{
                        $dataRPC[$key] = new Value($value);
                    }
                }
                else{
                    $dataRPC[$key] = new Value($value);
                }
            }

            if($resource == 'pos.order.line'){

                $dataRPC['tax_ids'] = new Value(array(new Value( array(new Value(6,'int'),new Value('false','boolean'),new Value(array(new Value(1,'int')),'array')),'array')) ,'array');
                \Log::info(print_r($data,true));
            }

            $testdata[] = new Value($dataRPC, 'struct');
            \Log::info(print_r($testdata,true));

        




        }

        $idCreate = $models->send(new Request('execute_kw', array(new Value($db), new Value($uid, 'int'), new Value($password), new Value($resource), new Value($method), new Value($testdata, 'array'))));
        

        

        return $idCreate;
    }

    /**
     * @author LEE San Wei
     * 
     * Get id from odoo
     * 
     * 
     */

    public static function getIdFromOdoo($url, $db, $username, $password, $data,$resource)
    {

        $common = new Client("$url/xmlrpc/2/common");

        $uid = $common->send(new Request('authenticate', array(new Value($db), new Value($username), new Value($password), new Value(array(), 'array'))));

        $uid = $uid->val->me['int'];

        $models = new Client("$url/xmlrpc/2/object");

        $getId[] = new Value(array(new Value($data['condition']),new Value('='),new Value($data['condition1'])),'array');

            $testId[] = new Value($getId, 'array');

            $id = $models->send(new Request('execute_kw', array(new Value($db), new Value($uid, 'int'), new Value($password), new Value($resource), new Value('search'), new Value($testId, 'array'))));
           

            $id = $id->val->me['array'][0]->me['int'];
            
            return $id;

    }

    /**
     * @author FAIZA Mohamed Iheb
     *
     * Send http resquest to Prestashop.
     *
     * @param string $url Adress to send to
     * @param string $key API key
     * @param string $resource APIResource (customer, product, ...)
     * @param array $data Data array to send
     * @param string $method Http Method that will be used
     * @return xml
     */
    public static function sendToPS($url, $key, $resource, $data, $method)
    {
        try {
            $opt['resource'] = $resource . "s";
            $webService = new PrestaShopWebservice($url, $key, false);

            if ($method == "POST") {
                // Gets a blank xml schema from prestashop
                $xml = $webService->get(array('url' => $url . '/api/' . $resource . 's?schema=blank'));
            } else {
                // For PUT and DELETE methods we must always set up the ressource id
                if ($resource == "customer") {
                    $optUser = array(
                        'resource'       => 'customers',
                        'filter[email]'  => '['.$data['email'].']',
                        'display' => '[id]'
                    );
                    $resultUser = ($webService->get( $optUser ));
                    $userResult = json_encode($resultUser);
                    $json = json_decode($userResult, true);
                    if (isset($json['customers']['customer'])) {
                        if (isset($json['customers']['customer'][0])) {
                            $id = $json['customers']['customer'][0]['id'];
                        } else {
                            $id = $json['customers']['customer']['id'];
                        }
                    } else {
                        return null;  
                    }
                }
                $data['id'] = $id;
                $opt['id'] = (int) $id;
                if ($method == "PUT") {
                    // Get and xml of old ressource data
                    $xml = $webService->get($opt);
                }
            }

            // Fill the xml with new data from the array
            if ($method == "POST" || $method == "PUT") {
                $resources = $xml->children()->children();

                foreach ($resources as $nodeKey => $node) {
                    if (array_key_exists($nodeKey, $data)) {
                        $resources->$nodeKey = $data[$nodeKey];
                    } else {
                        $resources->$nodeKey = null;
                    }
                }
                \Log::info("DATA TO SEND TO PS :");
                \Log::info(print_r($resource, true));
            }

            switch ($method) {
                case "GET":
                    $result = $xml->asXML(); 
                    break;
                case "POST":
                    $opt['postXml'] = $xml->asXML();
                    $result = $webService->add($opt);
                    break;
                case "PUT":
                    $opt['putXml'] = $xml->asXML();
                    $result = $webService->edit($opt);
                    break;
                case "DELETE":
                    $result = $webService->delete($opt);
                    break;
                default:
                    break;
            }
            return $result;
        } catch (PrestaShopWebserviceException $ex) {
            echo 'Error';
        }
    }

    /**
     * @author FAIZA Mohamed Iheb
     *
     * Convert an array to an xml object.
     *
     * @param array $array
     * @param SimpleXML $xml
     */
    public static function toXml($array, &$xml)
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                if (!is_numeric($key)) {
                    $subnode = $xml->addChild("$key");
                    toXml($value, $subnode);
                } else {
                    $subnode = $xml->addChild("item$key");
                    toXml($value, $subnode);
                }
            } else {
                $xml->addChild("$key", htmlspecialchars("$value"));
            }
        }
    }
}
