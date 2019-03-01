<?php
class Baza 
{
    const user = "root";
    const pass = "";
    const host = "localhost";
    const ime_baze = "logilotto_game";
    
    public $dbh;
    
    public function __construct() 
    {
        try
        {
            $string = "mysql:host=".self::host.";dbname=".self::ime_baze;
            $this->dbh = new PDO($string, self::user, self::pass);
        }
        catch (PDOException $e)
        {
            echo "GRESKA";
        }
    }
    
    public function __destruct() 
    {
        $this->dbh=NULL;
    }
    
    public function getAllBets()
    {
        $sql = "SELECT * FROM bets";
        $upit=$this->dbh->query($sql);
        $bets = $upit->fetchAll(PDO::FETCH_ASSOC);
        
        return json_encode($bets);
    }

    public function BetsInLast3Minutes()
    {
        $datetime_now = new DateTime(date("Y-m-d h:i:s"));
        $interval3minuta = new DateInterval('PT3M');
        
        $sql = "SELECT * FROM bets";
        $upit=$this->dbh->query($sql);
        $bets = $upit->fetchAll(PDO::FETCH_ASSOC);
        
        $last = array();
        //print_r($bets);
        foreach ($bets as $bet) // ovo moze u rikverc pa kolko ih ima...bolje svakako
        {
            $date = new DateTime($bet['placedDate']);            
            $date->add($interval3minuta);
                        
            if($date > $datetime_now)
                array_push ($last, $bet);
        }
        
        return $last;
    }
    
    public function getAllTransaction()
    {
        $sql = "SELECT * FROM transaction";
        $upit=$this->dbh->query($sql);
        $transactions = $upit->fetchAll(PDO::FETCH_ASSOC);
        
        return json_encode($transactions);
    }
    
    public function getClientWithID($id)
    {
        $sql = "SELECT * FROM client WHERE clientID = $id";
        $upit=$this->dbh->query($sql);
        $client = $upit->fetch(PDO::FETCH_ASSOC);
        
        return json_encode($client);
    }

    public function checkIfHaveEnough($id,$betAmount)
    {
        $sql = "SELECT * FROM client WHERE clientID = $id";
        $upit=$this->dbh->query($sql);
        $client = $upit->fetch(PDO::FETCH_ASSOC);
        
        if($client == false)
        {    
            return false;
        }
        if($client['balance'] >= $betAmount)
        {
            return true;
        }
        
        return false;
    }

    public function checkIfClientExist($id)
    {
        $sql = "SELECT * FROM client WHERE clientID = $id";
        $upit=$this->dbh->query($sql);
        $client = $upit->fetch(PDO::FETCH_ASSOC);
        
        if($client == false)
        {    
            return false;
        }
        
        return true;
    }

    public function updateClient($id,$amountChange)
    {
        $client = $this->getClientWithID($id);
        /*echo $client;
        return;*/
        
        $c = json_decode($client);
        $newAmount = $c->balance + $amountChange;
        try 
        {
            $sql = "UPDATE client SET balance=:balance WHERE clientID=:id";

            $pdo_izraz = $this->dbh->prepare($sql);
            $pdo_izraz->bindParam(':balance', $newAmount);
            $pdo_izraz->bindParam(':id', $id);
            $pdo_izraz->execute();
            return true;
        } 
        catch (Exception $ex) 
        {
            echo "GRESKA: ";
            echo $ex->getMessage();
        }
    }
    
    public function updateBet($id,$status,$winAmount)
    {
        $sql = "UPDATE bets SET status = $status, winAmount = '$winAmount' WHERE betID=$id";
        $pdo_izraz=$this->dbh->exec($sql);
    }
    
    public function addBet($date,$clientID,$stakeAmount,$numbers)
    {        
        try 
        {
            $sql = "INSERT INTO bets(placedDate,clientID,stakeAmount,numbers)";
            $sql.= "VALUES('$date','$clientID','$stakeAmount','$numbers')";
            $pdo_izraz = $this->dbh->exec($sql);
           
            return $this->dbh->lastInsertId();
        } 
        catch (Exception $exc) 
        {
            echo "Greska: ";
            echo $exc->getMessage();
            return false;
        }
    }
    
    public function addTransaction($betID,$drawID)
    {        
        try 
        {
            $sql = "INSERT INTO transaction(betID,drawID)";
            $sql.= "VALUES('$betID','$drawID')";
            $pdo_izraz = $this->dbh->exec($sql);
            return true;
        } 
        catch (Exception $exc) 
        {
            echo "Greska: ";
            echo $exc->getMessage();
            return false;
        }
    }
    
    public function addDraw($br1,$br2,$br3,$br4,$br5,$br6,$br7)
    {        
        try 
        {
            $sql = "INSERT INTO draws(number_01,number_02,number_03,number_04,number_05,number_06,number_07)";
            $sql.= "VALUES('$br1','$br2','$br3','$br4','$br5','$br6','$br7')";
            $pdo_izraz = $this->dbh->exec($sql);
            return $this->dbh->lastInsertId();
        } 
        catch (Exception $exc) 
        {
            echo "Greska: ";
            echo $exc->getMessage();
            return false;
        }
    }
    
    public function printBets() 
    {
        try 
        {
            $sql = "SELECT * FROM bets";

            $pdo_izraz = $this->dbh->query($sql);
            $bets = $pdo_izraz->fetchAll(PDO::FETCH_ASSOC);
            echo "<table cellpadding=5 border=1>";
            echo "<tr><th>Bet ID</th><th>Date</th><th>Client ID</th><th>Status</th><th>Stake Amount</th><th>Win Amount</th><th>Choosen numbers</th></tr>";
            foreach ($bets as $bet) 
            {
                $status = $bet['status'];
                if($status == -1)
                {
                    $statusString = "Lose";
                    $win = "";
                }
                else if($status == 0)
                {
                    $statusString = "Waiting...";
                    $win = "";
                }
                else
                {
                    $statusString = "Win";
                    $win = $bet['winAmount'];
                }
                
                $date = date_create($bet['placedDate']);
                
                echo "<tr><td><b>" . $bet['betID'] . "</b></td>";
                echo "<td>" . date_format($date, 'Y-m-d H:i:s') . "</td>";
                echo "<td>" . $bet['clientID'] . "</td>";
                echo "<td>" . $statusString . "</td>";
                echo "<td>" . $bet['stakeAmount'] . "</td>";
                echo "<td>" . $win . "</td>";
                echo "<td>" . $bet['numbers'] . "</td>";
           }
            echo "</table>";
        } 
        catch (Exception $exc) 
        {
            echo "GRESKA:";
            echo $exc->getMessage();
        }
    }
    
}
?>