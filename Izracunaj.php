<?php  
    require_once 'Utils.php';
    require_once 'db_engine.php';

    if(isset($_GET['id']) && isset($_GET['bet']) && isset($_GET['numbers']))
    {
        $id = $_GET['id'];
        $betAmount = $_GET['bet'];
        $combination = $_GET['numbers'];
                
        $db = new Baza();
        
        if($db->checkIfClientExist($id) == true)
        {
            if($db->checkIfHaveEnough($id, $betAmount))
            {
            }
            else
            {
                echo "*Nemate dovoljno sredstava";
                return;
            }
        }
        else 
        {
            echo "*Pogresan ID";
            return;
        }
          
        if(is_numeric($betAmount))
        {
            $bet = Utils::StringToArrayNumber($combination);

            if($bet != false)
            {
                echo "Successful!<br>";
                
                $date = date("Y-m-d h:i:s");
                //echo $date;
                //echo "<br>";
                $betID = $db->addBet($date, $id, $betAmount, implode(" ", $bet));
                $db->updateClient($id, -$betAmount);
                
                /*$draw = Utils::GetDraw();
                $drawID = $db->addDraw($draw[0], $draw[1], $draw[2], $draw[3], $draw[4], $draw[5], $draw[6]);
                
                $win = Utils::WinPrice($bet, $draw, $betAmount);
                
                $status = -1;
                if($win > 0)
                {
                    $status = 1;
                    $db->updateClient($id, $win);
                }
                
                $db->updateBet($betID, $status, $win);
                $db->addTransaction($betID, $drawID);
                
                echo "You won ".$win."<br>";
                echo "drawn numbers are ".$draw[0]." ".$draw[1]." ".$draw[2]." ".$draw[3]." ".$draw[4]." ".$draw[5]." ".$draw[6];
           */ }
            else
            {
                echo "*Pogresna kombinacija";
            }
        }
        else
        {
            echo "*Iznos mora biti broj";
        }
    }
    else
    {
        echo "*Morate uneti sve parametre";
    }    
?>