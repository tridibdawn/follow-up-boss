<?php

namespace Redbuyers\FollowUpBoss;

class FollowUpBoss
{
    /**
     * Send enquiry data
     * @param object $contact
     * @param string $apiKey
     * @return response
     */
    public static function sendEnquiry($contact) {
        // event data
        $data = array(
            "source" => "redbuyers.com",
            "type" => "General Inquiry",
            "message" => $contact->message,
            "person" => array(
                "firstName" => $contact->name,
                "lastName" => '',
                "emails" => array(array("value" => $contact->email)),
                "phones" => array(array("value" => $contact->phone)),
                "tags" => array("Contact Us"),
            ),
        );
        self::send($data);
    }
    // END OF FUNCTION

    /**
     * Send seller lead
     * @param object $lead
     * @param string $source
     * @param string $apiKey
     * @return response
     */
    public static function sendSellerLead($lead, $source = null) {
        $source = !empty($source) ? $source : 'redbuyers.com';
        $data = array(
            "source" => $source,
            "type" => "Seller Inquiry",
            "message" => " Relationship: " . $lead->relationship . ", Sqft: " . $lead->area_in_sqft . ", Bed: " . $lead->no_of_bedrooms . ", Bathroom: " . $lead->no_of_fullbathrooms . ", Built Year: " . $lead->built_year . ", Pool: " . $lead->swimming_pool . ", Building Type: " . $lead->building_type . ", Basement: " . $lead->basement . ", Unit Number: " . $lead->unitno . ", Extra Info: " . $lead->extra_info,
            "person" => array(
                "firstName" => $lead->contact_name,
                "lastName" => '',
                "emails" => array(array("value" => $lead->contact_email)),
                "phones" => array(array("value" => $lead->contact_phone)),
                "tags" => array("Seller Lead"),
            ),
            "property" => array(
                "street" => $lead->address,
                "type" => $lead->building_type,
                "bedrooms" => $lead->no_of_bedrooms,
                "bathrooms" => $lead->no_of_fullbathrooms,
                "area" => $lead->area_in_sqft,
            ),
        );
        self::send($data);
    }
    // END OF FUNCTION

    /**
     * Send landing lead
     * @param object $lead
     * @param string $source
     * @param string $apiKey
     * @return response
     */
    public static function sendLandingLead($lead, $source = 'redbuyers.com') {
        $data = array(
            "source" => $source,
            "type" => "Seller Inquiry",
            "person" => array(
                "firstName" => $lead->name,
                "lastName" => '',
                "emails" => array(array("value" => $lead->email)),
                "phones" => array(array("value" => $lead->phone)),
                "tags" => array("Seller Lead"),
            ),
        );
        self::send($data);
    }
    // END OF FUNCTION

    /**
     * Send buyer lead
     * @param object $lead
     * @param string $source
     * @param string $apiKey
     * @return response
     */
    public static function sendBuyerLead($lead, $source = 'redbuyers.com') {
        $data = array(
            "source" => $source,
            "type" => "Property Inquiry",
            "message" => "Price range: " . $lead->min_price . " - " . $lead->max_price . " Type: " . $lead->property_type,
            "person" => array(
                "firstName" => $lead->contact_name,
                "lastName" => '',
                "emails" => array(array("value" => $lead->contact_email)),
                "phones" => array(array("value" => $lead->contact_phone)),
                "tags" => array("Buyer Lead"),
            ),
            "property" => array(
                "type" => $lead->property_type,
            ),
        );
        self::send($data);
    }
    // END OF FUNCTION

    /**
     * Send Hot Buying Deals
     * @param object $lead
     * @param string $source
     * @param string $apiKey
     * @return response
     */
    public static function sendiBuyerLead($lead, $source = 'redbuyers.com') {
        $data = array(
            "source" => $source,
            "type" => "Hot iBuying Deals",
            "message" => "Hot iBuyer",
            "person" => array(
                "firstName" => $lead->contact_name,
                "lastName" => '',
                "emails" => array(array("value" => $lead->contact_email)),
                "phones" => array(array("value" => $lead->contact_phone)),
                "tags" => array("Buyer Lead"),
            ),
        );
        self::send($data);
    }
    // END OF FUNCTION

    /**
     * Property enquiry
     * @param object $lead
     * @param string $source
     * @param string $apiKey
     * @return response
     */
    public static function propertyEnquiry($lead, $source = 'redbuyers.com') {
        $data = array(
            "source" => $source,
            "type" => "Property Inquiry",
            "message" => $lead->messge,
            "person" => array(
                "firstName" => $lead->name,
                "lastName" => '',
                "emails" => array(array("value" => $lead->email)),
                "phones" => array(array("value" => $lead->phone)),
                "tags" => array("Buyer Lead"),
            ),
            "property" => array(
                "type" => $lead->property_type,
            ),
        );
        return self::send($data);
    }
    // END OF FUNCTION

    /**
     * Send api response
     * @param array $data
     * @param string $apiKey
     * @return response
     */
    private static function send($data) {
        // API key for demo account, replace with your own API key
        $apiKey = config('followupboss.followup_boss_api_key');
        // init cURL
        $ch = curl_init('https://api.followupboss.com/v1/events');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $apiKey . ':');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // make API call
        $response = curl_exec($ch);
        if ($response === false) {
            exit('cURL error: ' . curl_error($ch) . "\n");
        }
        return $response;
    }
    // END OF FUNCTION
}
