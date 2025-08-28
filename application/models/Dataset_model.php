<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dataset_model extends CI_Model
{
    public function get_all()
    {
        $csv_path = FCPATH . 'uploads/datasets.csv';

        if (!file_exists($csv_path)) {
            return array();
        }

        $file = fopen($csv_path, 'r');
        $datasets = array();
        $headers = fgetcsv($file);

        while (($row = fgetcsv($file)) !== FALSE) {
            $datasets[] = array_combine($headers, $row);
        }

        fclose($file);
        return $datasets;
    }

    public function save_data($data)
    {
        $csv_path = FCPATH . 'uploads/obesity_dataset.csv';

        // Jika file belum ada, buat baru dengan header
        if (!file_exists($csv_path)) {
            $file = fopen($csv_path, 'w');
            fputcsv($file, array_keys($data));
        } else {
            $file = fopen($csv_path, 'a');
        }

        fputcsv($file, $data);
        fclose($file);
        return true;
    }

    public function update_data($id, $data)
    {
        $csv_path = FCPATH . 'uploads/obesity_dataset.csv';
        $temp_path = FCPATH . 'uploads/temp_obesity_dataset.csv';

        $input = fopen($csv_path, 'r');
        $output = fopen($temp_path, 'w');

        $headers = fgetcsv($input);
        fputcsv($output, $headers);

        $current_id = 0;
        while (($row = fgetcsv($input)) !== FALSE) {
            $current_id++;
            if ($current_id == $id) {
                fputcsv($output, $data);
            } else {
                fputcsv($output, $row);
            }
        }

        fclose($input);
        fclose($output);

        unlink($csv_path);
        rename($temp_path, $csv_path);
        return true;
    }

    public function delete_data($id)
    {
        $csv_path = FCPATH . 'uploads/obesity_dataset.csv';
        $temp_path = FCPATH . 'uploads/temp_obesity_dataset.csv';

        $input = fopen($csv_path, 'r');
        $output = fopen($temp_path, 'w');

        $headers = fgetcsv($input);
        fputcsv($output, $headers);

        $current_id = 0;
        while (($row = fgetcsv($input)) !== FALSE) {
            $current_id++;
            if ($current_id != $id) {
                fputcsv($output, $row);
            }
        }

        fclose($input);
        fclose($output);

        unlink($csv_path);
        rename($temp_path, $csv_path);
        return true;
    }

    public function get_feature_names()
    {
        return [
            "Sex",
            "Age",
            "Height",
            "Overweight_Obese_Family",
            "Consumption_of_Fast_Food",
            "Frequency_of_Consuming_Vegetables",
            "Number_of_Main_Meals_Daily",
            "Food_Intake_Between_Meals",
            "Smoking",
            "Liquid_Intake_Daily",
            "Calculation_of_Calorie_Intake",
            "Physical_Excercise",
            "Schedule_Dedicated_to_Technology",
            "Type_of_Transportation_Used"
        ];
    }

    public function get_class_labels()
    {
        $csv_path = FCPATH . 'uploads/obesity_dataset.csv';
        $classes = array();

        if (file_exists($csv_path)) {
            $file = fopen($csv_path, 'r');
            $headers = fgetcsv($file);
            $class_index = array_search('Class', $headers);

            if ($class_index !== FALSE) {
                while (($row = fgetcsv($file)) !== FALSE) {
                    if (isset($row[$class_index])) {
                        $classes[$row[$class_index]] = true;
                    }
                }
            }
            fclose($file);
        }

        return array_keys($classes);
    }
    // public function get_allDataset()
    // {
    //     return $this->db->get('tb_dataset')->result();
    // }
    // public function get_paginated($limit, $start)
    // {
    //     return $this->db->limit($limit, $start)
    //         ->order_by('id', 'DESC')
    //         ->get('tb_dataset')
    //         ->result();
    // }
    // public function count_all()
    // {
    //     return $this->db->count_all('tb_dataset');
    // }
    // public function get_detailDataset($id)
    // {
    //     $this->db->where('id', $id);
    //     return $this->db->get('tb_dataset')->row();
    // }
    // public function addDataset($data)
    // {
    //     return $this->db->insert('tb_dataset', $data);
    // }
    // public function updateDataset($id, $data)
    // {
    //     $this->db->where('id', $id);
    //     return $this->db->update('tb_dataset', $data);
    // }
    // public function deleteDataset($id)
    // {
    //     $this->db->where('id', $id);
    //     return $this->db->delete('tb_dataset');
    // }
    // public function is_email_exist($email)
    // {
    //     $this->db->where('email', $email);
    //     $query = $this->db->get('tb_dataset');

    //     if ($query->num_rows() > 0) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }
}