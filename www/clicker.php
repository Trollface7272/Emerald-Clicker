<!DOCTYPE html>
<html lang="en">
<head>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/countup.js/1.8.2/countUp.min.js'></script>
    <script src="scripts/jquery.redirect/jquery.redirect.js"></script>


    <?php
        session_start();
    ?>
    <meta charset="UTF-8">
    <title>Gamer</title>
    <link rel="stylesheet" type="text/css" href="ClickerStyle.css">
</head>
<body>
    <?php
        $mysqli = new mysqli(
            "remotemysql.com", "cldhl9QKa9", "xF2D0SXPJL", "cldhl9QKa9"
            //"localhost", "root", "", "clicker"
        );
        if(isset($_SESSION['username']) && isset($_SESSION['password'])) {
            $sql = "SELECT * FROM `users` WHERE `user` = '$_SESSION[username]' AND `password` = '$_SESSION[password]'";
            $data = $mysqli->query($sql);
            $data = $data->fetch_assoc();
        }else {
            $sql = "SELECT * FROM `users` WHERE `user` = 'guest'";
            $data = $mysqli->query($sql);
            $data = $data->fetch_assoc();
        }
    ?>
    <div id="header"></div>
    <div id="nop"></div>
    <div id='site'>
        <div id='cookie'><img src="Source/cookie.png" onclick="cookieClick()">
            <div id='cookieCount'>Emeralds: <span id="cookies">0</span><br>
            <span id="EPS">0</span> EPS</div>
        </div>
        
        <div id="menu">
            <div class="menuButton" id="save">Save</div>
            <div class="menuButton" id="logout">Logout</div>
        </div>
        <div id='upgradeMenu'>
        <div id='upgradeBoosters'></div>
            <div id='boosters'>
                <div id='pickaxe' class='' onclick='add("pickaxe", "pickaxe")'></div>
                <div id='villagers'class='' onclick='add("villager", "villager")'></div>
                <div id='farms'class='' onclick='add("farm", "farm")'></div>
                <div id='mines'class='' onclick='add("mine", "mine")'></div>
                <div id='factories'class='' onclick='add("factory", "factory")'></div>
            </div>
        </div>
    </div>
    <div id='hackerman' onclick='emeraldsHack()'></div>
    
    <script>
         var username = "<?php echo $data['user']?>";

         
        var cookie = document.getElementById('cookie')
        var pickaxes = document.getElementById('pickaxe')
        var villagers = document.getElementById('villagers')
        var farms = document.getElementById('farms')
        var mines = document.getElementById('mines')
        var factories = document.getElementById('factories')
        var cookieCount = document.getElementById('cookieCount')
        var Game = {}
        var countUpEmeralds
        var countUpEPS
        initialize()
        
        
        
       
        if(username == 'guest') document.getElementById('logout').innerHTML = 'Login'
        jQuery(function($){
            $('#save').click(function() {
                if(username == 'guest') return;
                $.redirect('./save.php', {emeralds: Game.emeralds, 'upgrades[]': [Game.pickaxes, Game.villagers, Game.farms, Game.mines, Game.factories]}, 'POST')
            })
            $('#logout').click(function() {
                $.redirect('./logout.php')
            })
        })
        
        function cookieClick() {
            Game.emeralds = Game.emeralds+1
            displayCurrentemeralds()
            checkForUpgrades()
        }

        function addUpgrade(costD, upgradeName, h, cost, ammount, description) {
            let icon = `${upgradeName}-icon`
            h.innerHTML = `
            <div class="worker">
                <div id = ${icon}> </div>
                <div class = workerTitle><b>${upgradeName}</b></div>
                <div class = workerDescription>
                    ${description} <br>
                    Current cost: ${cost} <br>
                    Current ammount: ${ammount}
                </div>
            </div>`
        }

        function add(key, key2) {
            switch (key2) {
                case 'pickaxe':
                    buyUpgrade(Game.pickaxeCost, 'pickaxe')
                    break
                
                case 'villager':
                    buyUpgrade(Game.villagerCost, 'villager')
                    break

                case 'farm':
                    buyUpgrade(Game.farmCost, 'farm')
                    break

                case 'mine': 
                    buyUpgrade(Game.mineCost, 'mine')
                    break

                case 'factory':
                    buyUpgrade(Game.factoryCost, 'factory')
                    break

                default:
                    break
            }
            switch (key) {
                case 'pickaxe':
                    addUpgrade(0, "Pickaxe", pickaxes, Game.pickaxeCost, Game.pickaxes, 'Adds 1 power to clicking')
                    break
                
                case 'villager':
                    addUpgrade(200, "Villager", villagers, Game.villagerCost, Game.villagers, 'Adds 10 auto production')
                    break

                case 'farm':
                    addUpgrade(1500, "Farm", farms, Game.farmCost, Game.farms, 'Adds 100 auto production')
                    break

                case 'mine': 
                    addUpgrade(15000, "Mine", mines, Game.mineCost, Game.mines, 'Adds 200 auto production')
                    break

                case 'factory':
                    addUpgrade(200000, "Factory", factories, Game.factoryCost, Game.factories, 'Adds 500 auto production')
                    break

                default:
                    break
            }
        }

        function addUpgrades(key) {
            if(key == 'pickaxe') Game.pickaxes++
            if(key == 'villager') Game.villagers++
            if(key == 'farm') Game.farms++
            if(key == 'mine') Game.mines++
            if(key == 'factory') Game.factories++
            getCost()
        }

        function buyUpgrade(cost, upgrade) {
            if(Game.emeralds < cost) return
            Game.emeralds -= cost
            addUpgrades(upgrade)
            autoGain()
            displayCurrentemeralds()
        }

        function getCost() {
            Game.pickaxeCost = Math.round(150 * Math.pow(1.15, Game.pickaxes))
            Game.villagerCost = Math.round(1000 * Math.pow(1.15, Game.villagers))
            Game.farmCost = Math.round(11000 * Math.pow(1.15, Game.farms))
            Game.mineCost = Math.round(120000 * Math.pow(1.15, Game.mines))
            Game.factoryCost = Math.floor(1300000 * Math.pow(1.15, Game.factories))
        }

        function emeraldsHack() {
            Game.emeralds = 9999999
        }

        function work() {
            Game.emeralds += Game.autoGain
            countUpEmeralds.update(Game.emeralds)
            checkForUpgrades()
        }

        function autoGain() {
            Game.autoGain = Game.pickaxes
            Game.autoGain += 10*Game.villagers
            Game.autoGain += 100*Game.farms
            Game.autoGain += 400*Game.mines
            Game.autoGain += 500*Game.factories
            countUpEPS.update(Game.autoGain)
        }

        function displayCurrentemeralds() {
        }

        function checkForUpgrades() {
            if(Game.emeralds > 500) add("villager")
            if(Game.emeralds > 1500) add("farm")
            if(Game.emeralds > 15000) add("mine")
            if(Game.emeralds > 200000) add("factory")
            if(Game.villagers > 0) add('villager')
            if(Game.farms > 0) add('farm')
            if(Game.mines > 0) add('mine')
            if(Game.factories > 0) add("factory")
        }

        function initialize() {
            //CountUps
            
            //emeralds
            Game.emeralds = <?php echo $data['emeralds']?>;

            //Upgrades
            Game.pickaxes = <?php echo $data['pickaxes']?>;
            Game.villagers = <?php echo $data['villagers']?>;
            Game.farms = <?php echo $data['farms']?>;
            Game.mines = <?php echo $data['mines']?>;
            Game.factories = <?php echo $data['factories']?>;

            //Click Gain
            Game.clickGain = 1

            //Auto Gain
            var options = {  
                useEasing: true,
                useGrouping: true,
                separator: ',',
                decimal: '.',
                prefix: '',
                suffix: '',
                duration: 1,
            };
            countUpEPS = new CountUp('EPS', 0, options)
            autoGain()
            countUpEPS.start()

            //Count Up
            countUpEmeralds = new CountUp('cookies', Game.emeralds+Game.autoGain, options)
            countUpEmeralds.start()
            
            //Upgrade Costs
            getCost()

            add("pickaxe") 
            work()
            var interval = setInterval(work, 1000)
        }

    </script>
</body>
</html>