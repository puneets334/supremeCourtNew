<?php
namespace App\ControllersCron;
use App\Controllers\BaseController; 
class ReplicationCheck extends BaseController {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
       $servers=array('10.249.44.169','10.249.44.170');
       foreach ($servers as $server_ip){
           echo $server_ip;
           $this->checkReplicationStatus($server_ip);
       }
    }
    private function checkReplicationStatus($serverIp='10.249.44.169'){
        $dbConfig = array(
            'hostname' => $serverIp,
            'port' => '5432',
            'username' => 'efiling_near',
            'password' => 'SkRhD@#2010',
            'database' => 'efiling_near',
            'dbdriver' => 'postgre',
            'db_debug' => FALSE,
            'cache_on' => FALSE,
            'cachedir' => '',
            'char_set' => 'utf8',
            'dbcollat' => 'utf8_general_ci',
        );

        // Load PostgreSQL database
        $this->load->database($dbConfig);

        // Maximum allowed replication delay in seconds
        $maxDelaySeconds = 900;
        echo "Started ".$serverIp;
        // Query replication delay
        $query = $this->db->query("SELECT EXTRACT(EPOCH FROM now() - pg_last_xact_replay_timestamp()) AS replication_delay");
        $result = $query->row();
        var_dump($query);
        $replicationDelay = $result->replication_delay;

        echo "Fetched data from:  ".$serverIp." and delay is:".$replicationDelay;

        // Close database connection
        $this->db->close();


        if ($replicationDelay > $maxDelaySeconds) {
            $emailSubject = "PostgreSQL Replication Delay Alert on Server ".$serverIp;
            $emailMessage = "Replication delay on Server ".$serverIp." exceeds threshold. Current delay: $replicationDelay seconds.";
        } else {
            $emailSubject = "PostgreSQL Replication Status";
            $emailMessage = "Replication delay on Server ".$serverIp." is within threshold. Current delay: $replicationDelay seconds.";
        }

        $to_email='sca.aktripathi@sci.nic.in';

        send_mail_msg($to_email, $emailSubject, $emailMessage);
    }
}