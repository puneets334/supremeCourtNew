<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class App extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Base Site URL
     * --------------------------------------------------------------------------
     *
     * URL to your CodeIgniter root. Typically, this will be your base URL,
     * WITH a trailing slash:
     *
     * E.g., http://example.com/
     * */
    public string $baseURL = "http://10.25.80.170:82/";
    /**
     * Allowed Hostnames in the Site URL other than the hostname in the baseURL.
     * If you want to accept multiple Hostnames, set this.
     *
     * E.g.,
     * When your site URL ($baseURL) is 'http://example.com/', and your site
     * also accepts 'http://media.example.com/' and 'http://accounts.example.com/':
     *     ['media.example.com', 'accounts.example.com']
     *
     * @var list<string>
     */
    public array $allowedHostnames = [];

    /**
     * --------------------------------------------------------------------------
     * Index File
     * --------------------------------------------------------------------------
     *
     * Typically, this will be your `index.php` file, unless you've renamed it to
     * something else. If you have configured your web server to remove this file
     * from your site URIs, set this variable to an empty string.
     */
    public string $indexPage = '';

    /**
     * --------------------------------------------------------------------------
     * URI PROTOCOL
     * --------------------------------------------------------------------------
     *
     * This item determines which server global should be used to retrieve the
     * URI string. The default setting of 'REQUEST_URI' works for most servers.
     * If your links do not seem to work, try one of the other delicious flavors:
     *
     *  'REQUEST_URI': Uses $_SERVER['REQUEST_URI']
     * 'QUERY_STRING': Uses $_SERVER['QUERY_STRING']
     *    'PATH_INFO': Uses $_SERVER['PATH_INFO']
     *
     * WARNING: If you set this to 'PATH_INFO', URIs will always be URL-decoded!
     */
    public string $uriProtocol = 'REQUEST_URI';

    /*
    |--------------------------------------------------------------------------
    | Allowed URL Characters
    |--------------------------------------------------------------------------
    |
    | This lets you specify which characters are permitted within your URLs.
    | When someone tries to submit a URL with disallowed characters they will
    | get a warning message.
    |
    | As a security measure you are STRONGLY encouraged to restrict URLs to
    | as few characters as possible.
    |
    | By default, only these are allowed: `a-z 0-9~%.:_-`
    |
    | Set an empty string to allow all characters -- but only if you are insane.
    |
    | The configured value is actually a regular expression character group
    | and it will be used as: '/\A[<permittedURIChars>]+\z/iu'
    |
    | DO NOT CHANGE THIS UNLESS YOU FULLY UNDERSTAND THE REPERCUSSIONS!!
    |
    */
    public string $permittedURIChars = 'a-z 0-9~%.:_\-';

    /**
     * --------------------------------------------------------------------------
     * Default Locale
     * --------------------------------------------------------------------------
     *
     * The Locale roughly represents the language and location that your visitor
     * is viewing the site from. It affects the language strings and other
     * strings (like currency markers, numbers, etc), that your program
     * should run under for this request.
     */
    public string $defaultLocale = 'en';

    /**
     * --------------------------------------------------------------------------
     * Negotiate Locale
     * --------------------------------------------------------------------------
     *
     * If true, the current Request object will automatically determine the
     * language to use based on the value of the Accept-Language header.
     *
     * If false, no automatic detection will be performed.
     */
    public bool $negotiateLocale = false;

    /**
     * --------------------------------------------------------------------------
     * Supported Locales
     * --------------------------------------------------------------------------
     *
     * If $negotiateLocale is true, this array lists the locales supported
     * by the application in descending order of priority. If no match is
     * found, the first locale will be used.
     *
     * IncomingRequest::setLocale() also uses this list.
     *
     * @var list<string>
     */
    public array $supportedLocales = ['en'];

    /**
     * --------------------------------------------------------------------------
     * Application Timezone
     * --------------------------------------------------------------------------
     *
     * The default timezone that will be used in your application to display
     * dates with the date helper, and can be retrieved through app_timezone()
     *
     * @see https://www.php.net/manual/en/timezones.php for list of timezones
     *      supported by PHP.
     */
    public string $appTimezone = 'Asia/Kolkata';

    /**
     * --------------------------------------------------------------------------
     * Default Character Set
     * --------------------------------------------------------------------------
     *
     * This determines which character set is used by default in various methods
     * that require a character set to be provided.
     *
     * @see http://php.net/htmlspecialchars for a list of supported charsets.
     */
    public string $charset = 'UTF-8';

    /**
     * --------------------------------------------------------------------------
     * Force Global Secure Requests
     * --------------------------------------------------------------------------
     *
     * If true, this will force every request made to this application to be
     * made via a secure connection (HTTPS). If the incoming request is not
     * secure, the user will be redirected to a secure version of the page
     * and the HTTP Strict Transport Security (HSTS) header will be set.
     */
    public bool $forceGlobalSecureRequests = false;

    /**
     * --------------------------------------------------------------------------
     * Reverse Proxy IPs
     * --------------------------------------------------------------------------
     *
     * If your server is behind a reverse proxy, you must whitelist the proxy
     * IP addresses from which CodeIgniter should trust headers such as
     * X-Forwarded-For or Client-IP in order to properly identify
     * the visitor's IP address.
     *
     * You need to set a proxy IP address or IP address with subnets and
     * the HTTP header for the client IP address.
     *
     * Here are some examples:
     *     [
     *         '10.0.1.200'     => 'X-Forwarded-For',
     *         '192.168.5.0/24' => 'X-Real-IP',
     *     ]
     *
     * @var array<string, string>
     */
    public array $proxyIPs = [];

    /**
     * --------------------------------------------------------------------------
     * Content Security Policy
     * --------------------------------------------------------------------------
     *
     * Enables the Response's Content Secure Policy to restrict the sources that
     * can be used for images, scripts, CSS files, audio, video, etc. If enabled,
     * the Response object will populate default values for the policy from the
     * `ContentSecurityPolicy.php` file. Controllers can always add to those
     * restrictions at run time.
     *
     * For a better understanding of CSP, see these documents:
     *
     * @see http://www.html5rocks.com/en/tutorials/security/content-security-policy/
     * @see http://www.w3.org/TR/CSP/
     */
    public bool $CSPEnabled = false;

    public bool $csrf_protection = TRUE;
    public string $csrf_token_name = 'CSRF_TOKEN';
    public string $csrf_cookie_name = 'CSRFTOKENVALUE';
    public int $csrf_expire = 7200;
    public bool $csrf_regenerate = TRUE;

    public $cookieName = 'ci_session';
    public $cookiePath = '/';
    public $cookieDomain = ''; // Set if needed
    public $cookieSecure = false; // Set to true if using HTTPS
    public $cookieSameSite = ''; // Or 'Strict' if not using 'Secure'

    public array $csrf_exclude_uris = array('shcilPayment/paymentResponse','shcilPayment/paymentCheckStatus','newcase/Ajaxcalls/getAllFilingDetailsByRegistrationId','newcase/Ajaxcalls/updateDiaryDetails','newcase/Ajaxcalls/getAddressByPincode','newcase/Ajaxcalls/get_districts','newcase/Ajaxcalls/getSelectedDistricts','newcase/Ajaxcalls/getSelectedDistricts','newcase/Ajaxcalls_subordinate_court/[a-z_]+','affirmation/Esign_signature/advocate_esign_response','documentIndex/Ajaxcalls/get_index_type','documentIndex/Ajaxcalls/get_doc_type','documentIndex/Ajaxcalls/get_sub_doc_type_check', 'newcase/FeeVerifyLock_Controller/feeVeryLock','case_status/defaultController/showCaseStatus','documentIndex/Ajaxcalls/markCuredDefect','mycases/citation_notes/add_citation_mycases','mycases/citation_notes/get_citation_and_notes_list','mycases/citation_notes/delete_citation_n_notes','mycases/citation_notes/update_citation_mycases','mycases/citation_notes/add_notes_mycases','mycases/citation_notes/update_notes_mycases','mycases/citation_notes/get_contact_list','mycases/citation_notes/add_case_contact','mycases/citation_notes/delete_contacts','mycases/citation_notes/case_contact','mycases/citation_notes/update_case_contacts','mycases/citation_notes/send_sms_and_mail','newcase/Ajaxcalls/assignSrAdvocate','newcase/Ajaxcalls/deleteSrAdvocate','shareDoc/Ajaxcalls_doc_share/add_share_email','deficitCourtFee/DefaultController/record_data_deficit_insrt','deficitCourtFee/DefaultController/record_data_deficit_insrt_paid','register/AdvSignUp/add_advocate','shcilPayment/paymentCheckStatus','admin/EfilingAction/updateDocumentNumber','adminReport/DefaultController/getReportData','superAdmin/DefaultController/addSciUser','filingAdmin/DefaultController/fileTransferToAnOtherUser','register/AdvSignUp/upload_photo','admin/EfilingAction/updateRefiledCase','uploadDocuments/DefaultController/upload_pdf','uploadDocuments/DefaultController/deletePDF','newcase/AutoDiaryGeneration','newcase/AutoDiaryGeneration/updateOldEfilingRefiledCase','cron/bar','cron/scrutiny_status','cron/fee_lock');

    
}
