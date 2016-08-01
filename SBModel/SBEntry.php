<?php
namespace App\SBModel;
/**
 * Created by PhpStorm.
 * User: SEYDOU BERTHE
 * Date: 01/08/2016
 * Time: 10:26
 */

    class SBEntry {

        function getEntry(){
            return [
                'name' => 'required|regex:/^[\pL\s\-]+$/u|min:3|max:255',
                'email' => 'required|email|min:3|max:255',
                'password' => 'required|min:6',
                'other' => 'required',
            ];
        }

    }


