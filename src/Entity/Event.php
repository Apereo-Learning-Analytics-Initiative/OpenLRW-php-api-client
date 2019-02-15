<?php

/**
 *
 * Event class
 *
 * @copyright Apereo
 * @category OpenLRW
 * @package  Entity
 * @author   Xavier Chopin <bonjour@xavierchop.in>
 * @license  http://www.osedu.org/licenses/ECL-2.0 ECL-2.0 License
 */

 class Event
{

    public static function postCaliper($data)
    {
        $header =  [
            'X-Requested-With' => 'XMLHttpRequest',
            'Content-Type' => 'application/json',
            'Authorization' =>  ApiClient::getKey()
        ];

        return ApiClient::$http->post(self::PREFIX . "key/caliper", $header, $data);
    }


     /**
      * Create and send Caliper Event
      *
      * @param $userId
      * @param $action
      * @param string $applicationName
      * @param string $description
      * @param string $groupId
      * @return string
      */
     protected static function caliper($userId, $action, $applicationName = "php-api-client", $description = "", $groupId =  "null")
     {
         $date = date_format(new DateTime('NOW'), 'Y-m-d\TH:i:s.755\Z');
         $eventId = sha1($userId . $date);
         $json = '
        {
        	"data": [
        	 {
                "@context": "http://purl.imsglobal.org/ctx/caliper/v1p1",
                "@type": "Event",
                "action": "' . $action . '",
                "actor": {
                    "@id": "' . $userId . '",
                    "@type": "Person"
                },
                "eventTime": "' . $date . '",
                "object": {
                    "@id": "' . $eventId . '",
                    "@type": "SoftwareApplication",
                    "name": "' . $applicationName . '",
                 },
                "group": { 
                    "@id": "' . $groupId . '",
                    "@type": "Group"
                }
            }
        	],
        	 "sendTime": "' . $date . '",
             "sensor": "http://localhost/web/php-api-client"
        }';

         try {
             $status = self::postCaliper($json);
             return $status;
             return $status;
         } catch (\Exception $e) {
             return $e->getMessage();
         }
     }


 }