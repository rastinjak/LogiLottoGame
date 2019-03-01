<html>
    <head>
        <title>LogiLotto Game</title>
    </head>
       
    <body>      
<!--        <form action="index.php " method="post">
            Client ID:          <input type="text" name="ime"><br>
            Bet:                <input type="flaot" name="bet"><br>
            Choose 7 numbers:   <input type="text" name="numbers"><br>
            <input type="submit" name="bet_data" value="Bet NOW!">
        </form>
 -->
        
            Client ID:          <input type="text" id="ime"><br>
            Bet:                <input type="flaot" id="bet"><br>
            Choose 7 numbers:   <input type="text" id="numbers"><br>
            <button onclick="submit()">Bet NOW!</button>

        <div id="rez"> </div>
        
        <a href="betsList.php">Look at the bets!</a>
        
    <script>
        function submit()
        {
            var xhttp = new XMLHttpRequest();
            
            xhttp.onreadystatechange = function()     
            {
                if (this.readyState == 4 && this.status == 200)     // sve je ok
                {
                    document.getElementById("rez").innerHTML = this.responseText;
                }
            };
            
            clientID =  document.getElementById("ime").value;
            bet =  document.getElementById("bet").value;
            numbers =  document.getElementById("numbers").value;
            
            xhttp.open("GET", "Izracunaj.php?id=" + clientID + "&bet=" + bet + "&numbers=" + numbers, true);
            xhttp.send();
            
            /*xhttp.open("POST", "Izracunaj.php", true);
            xhttp.setRequestHeader("Content-type", "application/xwww-form-urlencoded");
            xhttp.send("id=" + clientID + "&bet=" + bet + "&numbers=" + numbers);*/
                
        }
        
        
        
    </script>        
        <?php  
            /*require_once 'Utils.php';
    
            if(isset($_POST['ime']) && isset($_POST['bet']) && isset($_POST['numbers']))
            {
                $stake = $_POST['bet'];
                if(is_numeric($stake))
                {
                    $bet = Utils::StringToArrayNumber($_POST['numbers']);
                
                    if($bet != false)
                    {
                        $draw = Utils::GetDraw();
                        $win = Utils::WinPrice($bet, $draw, $stake);

                        echo "You won ".$win."<br>";
                        echo "drawn numbers are ".$draw[0]." ".$draw[1]." ".$draw[2]." ".$draw[3]." ".$draw[4]." ".$draw[5]." ".$draw[6];
                    }
                    else
                    {
                        echo "CP02";
                    }
                }
                else
                {
                    echo "CP03";
                }
            }
            else
            {
                echo "CP01";
            }    */
        ?>
        
    </body>
           
           
           
           
           
</html>
