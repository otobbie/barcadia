<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;

class barcadiaApi extends Controller
{
    //

    function dateToRoman(Request $request) {
        // Collect date input
        $inputDate = $request->input('date');
    
        if (empty($inputDate)) {
            return response()->json(['code' => 1, 'message' => 'Date empty']);
        }
    
        try {
            // Parse the input date with Carbon
            $date = Carbon::parse($inputDate);
    
            // Extract day, month, and year
            $day = $date->day;
            $month = $date->month;
            $year = $date->year;
    
            // Convert the date components to Roman numerals
            $converted_day = $this->convertNumberToRoman($day);
            $converted_month = $this->convertNumberToRoman($month);
            $converted_year = $this->convertNumberToRoman($year);
        } catch (Exception $e) {
            // Handle the error if the date could not be parsed
            return response()->json(['code' => 1, 'message' => 'Invalid date format']);
        }
    
        // Return response
        return response()->json([
            'code' => 0,
            'message' => 'Successful',
            'converted_day' => $converted_day,
            'converted_month' => $converted_month,
            'converted_year' => $converted_year
        ]);
    }
    

    function romanToDate(Request $request) {
        // Collect Roman string inputs and convert to uppercase
        $roman_day = strtoupper($request->input('roman_day'));
        $roman_month = strtoupper($request->input('roman_month'));
        $roman_year = strtoupper($request->input('roman_year'));
    
        // Check if any of the inputs are missing
        if (empty($roman_day) || empty($roman_month) || empty($roman_year)) {
            return response()->json(['code' => 1, 'message' => 'Please check all fields are filled']);
        }
    
        // Regular expression pattern for validating Roman numerals
        $pattern = '/^(?=[MDCLXVI])M*(C[MD]|D?C{0,3})(X[CL]|L?X{0,3})(I[XV]|V?I{0,3})$/i';
    
        // Validate each Roman numeral input
        if (!preg_match($pattern, $roman_day) || !preg_match($pattern, $roman_month) || !preg_match($pattern, $roman_year)) {
            return response()->json(['code' => 1, 'message' => 'Invalid Roman numeral']);
        }
    
        try {
            // Convert Roman numerals to numbers
            $number = [
                'day' => $this->convertRomanToNumber($roman_day),
                'month' => $this->convertRomanToNumber($roman_month),
                'year' => $this->convertRomanToNumber($roman_year)
            ];
        } catch (Exception $e) {
            return response()->json(['code' => 1, 'message' => $e->getMessage()]);
        }
    
        $return_date= $number['day'].'/'.$number['month'].'/'.$number['year'];
        $parsed_date = Carbon::parse($return_date);
        // Return response with converted numbers
        return response()->json(['code' => 0, 'message' => 'Successful', 'converted_numbers' => $number,'date'=>$parsed_date->format('d/m/Y')]);
    }
    

    function convertNumberToRoman($number){

        $roman_check = [
            1000 => 'M',
            900  => 'CM',
            500  => 'D',
            400  => 'CD',
            100  => 'C',
            90   => 'XC',
            50   => 'L',
            40   => 'XL',
            10   => 'X',
            9    => 'IX',
            5    => 'V',
            4    => 'IV',
            1    => 'I'
        ];

        $romanSymbol = '';

        // Iterate through the check
        foreach ($roman_check as $value => $symbol) {
            // Continue appending the Roman numeral symbol and subtracting the value from the number until the number is less than the value
            while ($number >= $value) {
                $romanSymbol .= $symbol; // Append the Roman numeral symbol to the result string
                $number -= $value; // Subtract the value from the number
            }
        }
    
        return $romanSymbol;
    }

    function convertRomanToNumber($roman){
        $roman_check = [
            'M'=>1000,
            'CM'=>900 ,
            'D'=>500 ,
            'CD'=>400 ,
            'C'=>100 ,
            'XC'=>90  ,
            'L'=>50  ,
            'XL'=>40  ,
            'X'=>10  ,
            'IX'=>9   ,
            'V'=>5   ,
            'IV'=>4   ,
            'I'=>1   
        ];
            
            $number = 0; // Initialize the result number to 0
            $i = 0; // Initialize an index to traverse the Roman numeral string

            // Traverse the Roman numeral string
            while ($i < strlen($roman)) {
                // echo $roman.'\n';
                // Check if the current and next character form a valid Roman numeral (like "CM")
                if ($i + 1 < strlen($roman) && isset($roman_check[substr($roman, $i, 2)])) {
                    $number += $roman_check[substr($roman, $i, 2)]; // Add the value to the result
                    $i += 2; // Move the index by 2 since we used two characters
                } else {
                    $number += $roman_check[$roman[$i]]; // Add the value of the single Roman numeral
                    $i++; // Move the index by 1
                }
            } 

        return $number; // Return the final array of number
    }
}
