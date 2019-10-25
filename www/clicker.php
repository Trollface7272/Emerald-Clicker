<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
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
        <div id='cookie'><img src="Source/cookie.png" onclick="cookieClick()"></div>
        <div id='cookieCount'></div>
        <div id="menu">
            <div class="menuButton" id="save">Save</div>
            <div class="menuButton" id="logout">Logout</div>
        </div>
        <div id='upgradeMenu'>
        <div id='upgradeBoosters'></div>
            <div id='boosters'>
                <div id='cursor' class='' onclick='add("cursor", "cursor")'></div>
                <div id='villagers'class='' onclick='add("villager", "villager")'></div>
                <div id='farms'class='' onclick='add("farm", "farm")'></div>
                <div id='mines'class='' onclick='add("mine", "mine")'></div>
                <div id='factories'class='' onclick='add("factory", "factory")'></div>
            </div>
        </div>
    </div>
    <div id='hackerman' onclick='emeraldsHack()'></div>

    <script>
        var cookie = document.getElementById('cookie')
        var cursors = document.getElementById('cursor')
        var villagers = document.getElementById('villagers')
        var farms = document.getElementById('farms')
        var mines = document.getElementById('mines')
        var factories = document.getElementById('factories')
        var cookieCount = document.getElementById('cookieCount')
        initialize()


        jQuery(function($){
            $('#save').click(function() {
                if($_SESSION['username'] == 'guest') return;
                $.redirect('./save.php', {emeralds: cookie.emeralds, 'upgrades[]': [cookie.cursors, cookie.villagers, cookie.farms, cookie.mines, cookie.factories]}, 'POST')
            })
            $('#logout').click(function() {
                $.redirect('./logout.php')
            })
        })
        
        function cookieClick() {
            cookie.emeralds = cookie.emeralds+1+cookie.cursors
            displayCurrentemeralds()
            checkForUpgrades()
        }

        function addUpgrade(costD, upgradeName, h, cost, ammount, description) {
            if(cookie.emeralds < costD) return
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
                case 'cursor':
                    buyUpgrade(cookie.cursorCost, 'cursor')
                    break
                
                case 'villager':
                    buyUpgrade(cookie.villagerCost, 'villager')
                    break

                case 'farm':
                    buyUpgrade(cookie.farmCost, 'farm')
                    break

                case 'mine': 
                    buyUpgrade(cookie.mineCost, 'mine')
                    break

                case 'factory':
                    buyUpgrade(cookie.factoryCost, 'factory')
                    break

                default:
                    break
            }
            switch (key) {
                case 'cursor':
                    addUpgrade(0, "Cursor", cursors, cookie.cursorCost, cookie.cursors, 'Adds 1 power to clicking')
                    break
                
                case 'villager':
                    addUpgrade(200, "Villager", villagers, cookie.villagerCost, cookie.villagers, 'Adds 10 auto production')
                    break

                case 'farm':
                    addUpgrade(1500, "Farm", farms, cookie.farmCost, cookie.farms, 'Adds 100 auto production')
                    break

                case 'mine': 
                    addUpgrade(15000, "Mine", mines, cookie.mineCost, cookie.mines, 'Adds 200 auto production')
                    break

                case 'factory':
                    addUpgrade(200000, "Factory", factories, cookie.factoryCost, cookie.factories, 'Adds 500 auto production')
                    break

                default:
                    break
            }
        }

        function addUpgrades(key) {
            switch (key) {
                case 'cursor':
                    cookie.cursors++
                    cookie.cursorCost = Math.round(100 * Math.pow(1.25, cookie.cursors))
                    break

                case 'villager':
                    cookie.villagers++
                    cookie.villagerCost = Math.round(500 * Math.pow(1.15, cookie.villagers))
                    break
            
                case 'farm':
                    cookie.farms++
                    cookie.farmCost = Math.round(1500 * Math.pow(1.15, cookie.farms))
                    break

                case 'mine':
                    cookie.mines++
                    cookie.mineCost = Math.round(15000 * Math.pow(1.15, cookie.mines))
                    break

                case 'factory': 
                    cookie.factories++
                    cookie.factoryCost = Math.floor(200000 * Math.pow(1.15, cookie.factories))
                    break

                default:
                    break
            }
        }

        function buyUpgrade(cost, upgrade) {
            if(cookie.emeralds < cost) return
            cookie.emeralds -= cost
            addUpgrades(upgrade, cookie)
            autoGain()
            displayCurrentemeralds()
        }

        function emeraldsHack() {
            cookie.emeralds = 9999999
        }

        function work() {
            cookie.emeralds += cookie.autoGain
            displayCurrentemeralds()
            checkForUpgrades()
        }

        function autoGain() {
            cookie.clickGain = 1 + cookie.cursors
            cookie.autoGain = 10*cookie.villagers
            cookie.autoGain += 100*cookie.farms
            cookie.autoGain += 200*cookie.mines
            cookie.autoGain += 500*cookie.factories
        }

        function displayCurrentemeralds() {
            cookieCount.innerHTML = `${cookie.emeralds} Emeralds. <br>
            ${cookie.autoGain} EPS`
        }

        function checkForUpgrades() {
            if(cookie.emeralds > 500) add("villager")
            if(cookie.emeralds > 1500) add("farm")
            if(cookie.emeralds > 15000) add("mine")
            if(cookie.emeralds > 200000) add("factory")
        }

        function initialize() {
            //emeralds
            cookie.emeralds = <?php echo $data['emeralds']?>;

            //Upgrades
            cookie.cursors = <?php echo $data['cursors']?>;
            cookie.villagers = <?php echo $data['villagers']?>;
            cookie.farms = <?php echo $data['farms']?>;
            cookie.mines = <?php echo $data['mines']?>;
            cookie.factories = <?php echo $data['factories']?>;

            //Click Gain
            cookie.clickGain = cookie.cursors + 1

            //Auto Gain
            autoGain();

            //Upgrade Costs
            cookie.cursorCost = Math.floor(100 * Math.pow(1.15, cookie.cursors))
            cookie.villagerCost = Math.floor(500 * Math.pow(1.15, cookie.villagers))
            cookie.farmCost = Math.floor(1500 * Math.pow(1.15, cookie.farms))
            cookie.mineCost = Math.floor(15000 * Math.pow(1.15, cookie.mines))
            cookie.factoryCost = Math.floor(200000 * Math.pow(1.15, cookie.factories))

            add("cursor")
            work()
            var interval = setInterval(work, 1000)
        }
    </script>
</body>
</html>