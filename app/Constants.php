<?php

namespace App\Constants;

class Constants
{
    
    /*     * ********* Start: Protocols ********** */
    const PROTOCOL_PPTP = 'PPTP';
    const PROTOCOL_L2TP = 'L2TP';
    const PROTOCOL_SSTP = 'SSTP';
    const PROTOCOL_IKEV = 'IKEV';
    const PROTOCOL_TCP = 'TCP';
    const PROTOCOL_UDP = 'UDP';
    const PROTOCOL_SOFTETHER_SSTP = 'Softether_SSTP';
    const PROTOCOL_SOFTETHER_ETHER = 'StealthVPN';
    const PROTOCOL_IPSEC = 'IPSEC';

    const PROTOCOL_PPTP_NO = 1;
    const PROTOCOL_L2TP_NO = 2;
    const PROTOCOL_SSTP_NO = 79617;
    const PROTOCOL_IKEV_NO = 3;
    const PROTOCOL_TCP_NO =  8;
    const PROTOCOL_UDP_NO =  9;
    const PROTOCOL_SOFTETHER_SSTP_NO = 11;
    const PROTOCOL_SOFTETHER_ETHER_NO = 10;
    const PROTOCOL_IPSEC_NO = 12;

    const DEVICE_ANDROID = 'android';
    const DEVICE_IOS     = 'ios';
    const DEVICE_MAC     = 'mac';
    const DEVICE_WINDOWS = 'windows';
    const DEVICE_LINUX   = 'linux';
    const DEVICE_KODI    = 'kodi';
    const DEVICE_TOMATO  = 'tomato';
    const DEVICE_DDWRT   = 'ddwrt';


    const SERVICE_ID_PURE_VPN = 1;
    const SERVICE_ID_PURE_PROXY = 2;

    const SERVICE_ID_PURE_VPN_PASS = 1;
    

    /*Header codes*/
    const CODE_SUCCESS = 1;
    const SUCCESS = "Success";

    const CODE_NULLRESPONSE = 998;
    const CODE_VALIDATIONFAIL = -1;
    

    /*     * ********* Start: Portnumbers ********** */
    const TCP_PORT_NUMBER = 80;
    const UDP_PORT_NUMBER = 80;
    const RRAS_PORT_NUMBER = 1723;
    /*     * ********* End: Portnumbers  ********** */

    /*     * ********* Start: Ping Timeout ********** */
    const PING_ERROR_TIMEOUT = 1.5;
    /*     * ********* End: Ping Timeout  ********** */

    const ARRAY_DEVICE_TYPES       =  [ SELF::DEVICE_ANDROID,
                                        SELF::DEVICE_IOS,
                                        SELF::DEVICE_WINDOWS,
                                        SELF::DEVICE_MAC,
                                        SELF::DEVICE_LINUX,
                                        SELF::DEVICE_KODI,
                                        SELF::DEVICE_TOMATO,
                                        SELF::DEVICE_DDWRT
                                        ];
    const ARRAY_PROTOCOLS_WINDOWS  =  ['PPTP','TCP','UDP','L2TP','SSTP','IKEV','Softether_SSTP','StealthVPN','IPSEC'];
    const ARRAY_PROTOCOLS_ANDROID  =  ['TCP','UDP'];
    const ARRAY_PROTOCOLS_IOS      =  ['IKEV','IPSEC'];
    const ARRAY_PROTOCOLS_MAC      =  ['IKEV','IPSEC'];

    #Platform Constants start
    #const URL_PLATFORM_API  = 'http://dev.atom.speedtest.com/generateToken';
    const RESELLER_ID       = 1;
    const PUREVPN           = 1;
    const CALCULATION_METHOD_LAT_LONG       = 'LAT_LONG';
    const CALCULATION_METHOD_DATACENTER     = 'DATA_CENTERS';
    
    const SERVER_TYPE_WINDOWS  = 'windows';
    const SERVER_TYPE_LINUX    = 'linux';
    
    const SPEEDTEST_METHOD_DC  = 'DC';
    const SPEEDTEST_METHOD_LL  = 'LL';
    const SPEEDTEST_METHOD_FO  = 'FO';
    const SPEEDTEST_METHOD_AFO  = 'AFO';
    const SPEEDTEST_3  = 3;
    #Platform Constants end

    const REDIS_VALIDATE_USER_PREFERENCES = 'CA_USER_PREFERENCES';
    const REDIS_VALIDATE_USER_ABUSE = 'CA_USER_ABUSE';

    #error messages constants
    const ERROR = 'Error';
    const ERROR_GENERAL = 'Some error occured. Try Again';
    const ERROR_CURRENT_PASSWORD = 'Current Password did not match';
    const ERROR_NEW_PASSWORD = 'New Password did not match';
    const ERROR_KEY_EXPIRED = 'Password reset key expired';
    const ERROR_PASSWORD_LENGTH = 'Password must be atleast 8 characters long';
    const ERROR_NUMERICS_CHARACTERS = 'Only numeric characters are allowed';
    const ERROR_TOKEN_VERIFICATION = 'Token verification failed';
    const ERROR_TOKEN_ALREADY_VERIFIED = 'Token already verified. Try after 24 hrs';
    const ERROR_TOKEN_LIMIT = 'You have surpassed token generation limit. Try after 24 hrs';
    const ERROR_PASSWORD_CHANGE_LIMIT = 'You can only update password once in 24 hrs';
    const ERROR_EMAIL_NOT_EXIST = 'Email does not exist';
    const ERROR_NO_DATA = 'No Data Found';
    const ERROR_INVALID_PARAMS = 'Invalid Params !';

    const SLACK_WEBHOOK_URL = 'https://hooks.slack.com/services/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';
    const SLACK_WEBHOOK_ERROR_STRING = 'Speedtest: ';
    
    #stored procedures
    const SP_GET_FAILOVER_SERVERS_BY_DNS_TYPE   = 'CALL pf_get_failovers_servers_by_dns_type(:p_reseller_id, :p_country_id, :p_city_id, :p_dns_type_id, :p_server_type, :p_speedtest_method, :p_protocol_nos)';
    const SP_GET_SERVERS_BY_LL                  = 'CALL pf_speedtest_get_servers_latt_long(:p_purpose_id, :p_country_id, :p_city_id, :p_lattitude, :p_longitude, :p_protocol_nos, :p_is_free, :p_reseller_id )';
    const SP_GET_AVF_SERVERS_BY_LL              = 'CALL pf_speedtest_get_servers_latt_long_features(:p_purpose_id, :p_country_id, :p_city_id, :p_lattitude, :p_longitude, :p_protocol_nos, :p_avf_ids, :p_avf_like_tags, :p_is_free, :p_reseller_id )';
    const SP_GET_AVF_SERVERS_BY_DC              = 'CALL pf_speedtest_get_servers_features(  :p_purpose_id, :p_country_id, :p_city_id, :p_datacenter_ids, :p_protocol_nos, :p_avf_ids, :p_avf_like_tags, :p_is_free, :p_reseller_id )';
    const SP_GET_SERVERS_BY_DC                  = 'CALL pf_speedtest_get_servers(:p_purpose_id, :p_country_id, :p_city_id, :p_datacenter_ids, :p_protocol_nos, :p_is_free, :p_reseller_id )';
    const SP_INSERT_SPEED_TEST_LOG              = 'CALL insert_speedtest_log(:username, :reseller_id, :country_id, :city_id, :purpose_id, :ip_address, :is_free, :multiport, :device_type, :datacenters, :protocol_no, :protocol_no_2, :protocol_no_3, :extras, :token, :response, :created_on)';
    const SP_GET_SPEEDTEST_BY_PSK               = 'CALL get_speedtest_by_psk(:sPsk)';
    const DNS_TYPE_ID_ACKNOWLEDGEMENT_SERVER    = 17;
    const DNS_TYPE_ID_AFO_COUNTRY               = 12;
    const DNS_TYPE_ID_AFO_CITY                  = 13;
    const DNS_TYPE_ID_FO_COUNTRY                = 15;
    const DNS_TYPE_ID_FO_CITY                   = 16;


    //clients greater than this get paid servers
    const USER_COUNTER = 4846006;


    const TOKEN_SALT = '^&%rfgh^&';
    const PSK_DELETE_INTERVAL = 4;   //minutes

    const CODE_1 = 1;
    const CODE_1_MESSAGE = "Success";
    
    const CODE_1010 = 1010;
    const CODE_1010_MESSAGE = 'Unable to generate Psk!';
    
    const CODE_1009 = 1009;
    const CODE_1009_MESSAGE = 'Session Limit for User Exceeded !';

    const CODE_1008 = 1008;
    const CODE_1008_MESSAGE = 'Login Limit for User Exceeded !';

    const CODE_1007 = 1007;
    const CODE_1007_MESSAGE = 'Failed to Validate Connection Request !';
    
    const CODE_1006 = 1006;
    const CODE_1006_MESSAGE = 'Advance Features Not Allowed !';
    
    
    const CODE_1005 = 1005;
    const CODE_1005_MESSAGE = 'Protocol Not Allowed !';
    
    const CODE_1004 = 1004;
    const CODE_1004_MESSAGE = 'City Not Allowed !';
    
    const CODE_1003 = 1003;
    const CODE_1003_MESSAGE = 'Country Not Allowed !';
    
    const CODE_1002 = 1002;
    const CODE_1002_MESSAGE = 'Reseller id provided is either Invalid or Expired !';

    const CODE_1011 = 1011;
    const CODE_1011_MESSAGE = 'Something went wrong, inserting data!';

    const CODE_1001 = 1001;
    const CODE_1001_MESSAGE = self::ERROR_INVALID_PARAMS;
    
    const CODE_1020 = 1020;
    const CODE_1020_MESSAGE = 'Nothing to Remove !';
    
    const CODE_1031 = 1031;
    const CODE_1031_MESSAGE = 'No Servers Found !';
    
    const CODE_1030 = 1030;
    const CODE_1030_MESSAGE = 'Invalid Psk !';
    
    const CODE_1040 = 1040;
    const CODE_1040_MESSAGE = 'Nothing to Remove !';
    
    const CODE_1051 = 1051;
    const CODE_1051_MESSAGE = 'Username Not found !';
    
    const CODE_1050 = 1050;
    const CODE_1050_MESSAGE = self::ERROR_INVALID_PARAMS;
    
    
    
}
