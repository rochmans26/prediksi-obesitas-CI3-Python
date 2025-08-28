<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Obesity_model extends CI_Model
{
    private $api_url = 'http://localhost:5000/api/';

    public function __construct()
    {
        parent::__construct();
    }

    public function predict($data)
    {
        $url = $this->api_url . 'predict';
        return $this->call_api('POST', $url, $data);
    }

    public function get_metrics()
    {
        $url = $this->api_url . 'metrics';
        return $this->call_api('GET', $url);
    }

    public function get_all_data()
    {
        $url = $this->api_url . 'data';
        return $this->call_api('GET', $url);
    }

    public function add_data($data)
    {
        $url = $this->api_url . 'data';
        return $this->call_api('POST', $url, $data);
    }

    public function update_data($index, $data)
    {
        $payload = $data;
        $payload['index'] = (int) $index;
        $url = $this->api_url . 'data';
        $data['index'] = $index;
        return $this->call_api('PUT', $url, $payload);
    }

    public function delete_data($index)
    {
        $url = $this->api_url . 'data';
        return $this->call_api('DELETE', $url, ['index' => $index]);
    }

    private function call_api($method, $url, $data = false)
    {
        $curl = curl_init();

        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                break;
            case "DELETE":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query([$data]));
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        $result = curl_exec($curl);
        if (!$result) {
            return ['error' => curl_error($curl)];
        }
        curl_close($curl);

        return json_decode($result, true);
    }
}