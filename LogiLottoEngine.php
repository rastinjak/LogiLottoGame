<?php
    require_once 'Utils.php';
    require_once 'db_engine.php';

    $db = new Baza();
    
    while(true)
    {
        $draw = Utils::GetDraw();
        $drawID = $db->addDraw($draw[0], $draw[1], $draw[2], $draw[3], $draw[4], $draw[5], $draw[6]);
        
        $bets_to_check  = $db->BetsInLast3Minutes();
                
        foreach($bets_to_check as $bet)
        {
            $numbers = $bet['numbers'];
            $numbers_array = Utils::StringToArrayNumber($numbers);
            $betAmount = $bet['stakeAmount'];
            $win = Utils::WinPrice($numbers_array, $draw, $betAmount);
            
            $status = -1;
            if($win > 0)
            {
                $status = 1;
                $id = $bet['clientID'];
                $db->updateClient($id, $win);
            }

            $betID = $bet['betID'];
            $db->updateBet($betID, $status, $win);
            $db->addTransaction($betID, $drawID); // moze da bude transakcija i ako samo isplacuje novac
        }
        
        sleep(60); 
    } // beskonacna petlja
    

?>
