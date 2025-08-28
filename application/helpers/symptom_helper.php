<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('describe_symptom')) {
    function describe_symptom($attribute, $value)
    {
        $descriptions = [
            'Sex' => [
                '1' => 'Male',
                '2' => 'Female'
            ],
            'Overweight_Obese_Family' => [
                '1' => 'Yes',
                '2' => 'No'
            ],
            'Consumption_of_Fast_Food' => [
                '1' => 'Yes',
                '2' => 'No'
            ],
            'Frequency_of_Consuming_Vegetables' => [
                '1' => 'Rarely',
                '2' => 'Sometimes',
                '3' => 'Always'
            ],
            'Number_of_Main_Meals_Daily' => [
                '1' => '1-2 meals',
                '2' => '3 meals',
                '3' => '3+ meals'
            ],
            'Food_Intake_Between_Meals' => [
                '1' => 'Rarely',
                '2' => 'Sometimes',
                '3' => 'Usually',
                '4' => 'Always'
            ],
            'Smoking' => [
                '1' => 'Yes',
                '2' => 'No'
            ],
            'Liquid_Intake_Daily' => [
                '1' => '<1 liter',
                '2' => '1-2 liters',
                '3' => '>2 liters'
            ],
            'Calculation_of_Calorie_Intake' => [
                '1' => 'Yes',
                '2' => 'No'
            ],
            'Physical_Excercise' => [
                '1' => 'No activity',
                '2' => '1-2 days',
                '3' => '3-4 days',
                '4' => '5-6 days',
                '5' => '6+ days'
            ],
            'Schedule_Dedicated_to_Technology' => [
                '1' => '0-2 hours',
                '2' => '3-5 hours',
                '3' => '>5 hours'
            ],
            'Type_of_Transportation_Used' => [
                '1' => 'Automobile',
                '2' => 'Motorbike',
                '3' => 'Bike',
                '4' => 'Public transportation',
                '5' => 'Walking'
            ],
            'Class' => [
                '1' => 'Underweight',
                '2' => 'Normal',
                '3' => 'Overweight',
                '4' => 'Obesity'
            ]
        ];

        // For numeric attributes that don't need conversion
        $numeric_attributes = ['Age', 'Height'];

        if (in_array($attribute, $numeric_attributes)) {
            return $value;
        }

        if (isset($descriptions[$attribute]) && isset($descriptions[$attribute][$value])) {
            return $descriptions[$attribute][$value];
        }

        // Return original value if no description found
        return $value;
    }
}