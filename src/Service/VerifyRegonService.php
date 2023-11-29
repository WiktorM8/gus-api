<?php
declare(strict_types = 1);

namespace App\Service;

 // Check if provided regon is correct

 class VerifyRegonService
 {
    public function verifyRegon(string $regon) : bool
    {
        // Weights for each digit in regon number
        if(strlen($regon)==9){
            $weights = [8, 9, 2, 3, 4, 5, 6, 7, 'c'];
        }else if(strlen($regon)==14){
            $weights = [2, 4, 8, 5, 0, 9, 7, 3, 6, 1, 2, 4, 8, 'c'];
        }else{
            return false;
        }
   
        // Checking checksum
        $sum = 0;
        for($x=0; $x<strlen($regon); $x++){
            if($weights[$x]!='c'){
                $sum += intval($regon[$x])*$weights[$x];
            }else{
                if(($sum%11)%10!=intval($regon[$x])){
                    return false;
                }
            }
        }
        return True;
    }
 }
