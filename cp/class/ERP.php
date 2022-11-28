<?php
class ERP {

    private $serverAddress = null;
    private $request_type=['POST'=>'POST','GET'=>'GET'];
    private $testPrice = null; 
    private $testSchedule = null; 

	public function __construct() {
        $this->serverAddress = 'http://http://10.31.8.24:5994/WebExportService/json/';

        $this->testPrice = ["DoctorId" => 37, "PriceOffline" => 500, "PriceOnline" => 250]; 
        $this->testSchedule = ["DoctorId" => 37,"Schedule" => [[
            "Online" => [["VisitDate" => "28.11.2022", "VisitTime" => "09.00", "Availability" => false],["VisitDate" => "28.11.2022", "VisitTime" => "10.00","Availability" => true], ["VisitDate" => "29.11.2022", "VisitTime" => "09.00", "Availability" => true], ["VisitDate" => "29.11.2022", "VisitTime" => "09.30", "Availability" => false], ["VisitDate" => "29.11.2022", "VisitTime" => "10.00", "Availability" => true], ["VisitDate" => "30.11.2022", "VisitTime" => "09.00", "Availability" => true], ["VisitDate" => "30.11.2022", "VisitTime" => "09.30", "Availability" => false], ["VisitDate" => "30.11.2022", "VisitTime" => "10.00", "Availability" => true], ["VisitDate" => "01.12.2022", "VisitTime" => "10.00", "Availability" => true], ["VisitDate" => "02.12.2022", "VisitTime" => "10.00", "Availability" => true],["VisitDate" => "02.12.2022", "VisitTime" => "10.30", "Availability" => false]], 
            "Offline" => [["VisitDate" => "28.11.2022", "VisitTime" => "09.00","Availability" => false],["VisitDate" => "28.11.2022", "VisitTime" => "10.00", "Availability" => true ], ["VisitDate" => "29.11.2022", "VisitTime" => "09.00","Availability" => false],["VisitDate" => "29.11.2022", "VisitTime" => "10.00", "Availability" => true ], ["VisitDate" => "29.11.2022", "VisitTime" => "11.30","Availability" => false],["VisitDate" => "29.11.2022", "VisitTime" => "12.00", "Availability" => true ], ["VisitDate" => "30.11.2022", "VisitTime" => "09.00","Availability" => false],["VisitDate" => "30.11.2022", "VisitTime" => "10.00", "Availability" => true ]]]]]; 
	}



    public function GetAdmissionSchedule($doctor_id){
        // $query = 'GetAdmissionSchedule?doctor_id='.$doctor_id;
        // $response = $this->doQuery($query,'',$this->request_type['GET']);
        // $param = $this->parseResponse($response);
        $param = $this->testSchedule;
        
        return $param['Schedule'];;
    }

    public function GetPrice($doctor_id){
        // $query = 'GetPrice?doctor_id='.$doctor_id;
        // $response = $this->doQuery($query,'',$this->request_type['GET']);
        // $param = $this->parseResponse($response);
        return $this->testPrice;
    }

    public function ReservationTime($doctor_id, $time_id){
        $query = 'ReservationTime?doctor_id='.$doctor_id.'&time_id='.$time_id;
        $response = $this->doQuery($query,'',$this->request_type['GET']);
        $param = $this->parseResponse($response);
        return $param;
    }

    public function SavePayment($data){
        $query = 'SavePayment';
        $response = $this->doQuery($query,json_encode($data),$this->request_type['POST']);
        $param = $this->parseResponse($response);
        return $param;
    }
	
    private function doQuery($address,$data,$query_type,$timeout=20)
    {
        if($query_type=='GET'){
            $addr = curl_init($this->serverAddress.$address.$data);
            curl_setopt($addr, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($addr,CURLOPT_HTTPHEADER, array('Accept:application/json'));
            curl_setopt($addr, CURLOPT_HEADER, 1);
            curl_setopt($addr, CURLOPT_TIMEOUT, $timeout);
        }else{
            if($query_type=='POST'){
                $addr = curl_init($this->serverAddress.$address);
                curl_setopt($addr, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($addr, CURLOPT_HTTPHEADER, array('Content-Type:application/json',));
                curl_setopt($addr, CURLOPT_HEADER, 1);
                curl_setopt($addr, CURLOPT_TIMEOUT, $timeout);
                curl_setopt($addr, CURLOPT_POST, TRUE);
                curl_setopt($addr, CURLOPT_POSTFIELDS, $data);
            }
        }
        $response = curl_exec($addr);
        curl_close($addr);
        $logs = fopen(DIR_LOGS.'/'."logs_erp.txt", "a") ;
        fwrite($logs, 'data-'.$data.'\n');
        fwrite($logs, 'response-'.$response.'\n');
        fwrite($logs, 'date-'.date('Y-m-d m:s:i').'\n');
        return $response;
    }
    private function parseResponse($details)
    {
        $result = json_decode(trim(strstr($details,'{')),true);
        return $result;
    }

    public function ticks_to_time($ticks) {
        return (($ticks - 621355968000000000) / 10000000);
    }
    public  function time_to_ticks($time) {
        return number_format(($time * 10000000) + 621355968000000000 , 0, '.', '');
    }
    public  function str_to_ticks($str) {
        return $this->time_to_ticks(strtotime($str));
    }

}
