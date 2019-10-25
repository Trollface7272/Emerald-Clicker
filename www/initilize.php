<?php
    class Initilize {
        function __construct($data) {
            $emeralds = $data['emeralds'] ;
            $cursors = $data['cursors'];
            $villagers = $data['villagers'];
            $farms = $data['farms'];
            $mines = $data['mines'];
            $factories = $data['factories'];
            $gain = $cursors+1;
            $autogain = $villagers * 10 +
                        $farms * 100 +
                        $mines * 200 +
                        $factories * 500;
            $cursorCost = round(100 * pow(1.15, $cursors));
            $villagerCost = round(500 * pow(1.15, $villagers));
            $farmCost = round(1500 * pow(1.15, $farms));
            $mineCost = round(15000 * pow(1.15, $mines));
            $factoryCost = round(200000 * pow(1.15, $factories));
            echo 
            `<script>
                function initialize() {
                    //emeralds
                    cookie.emeralds = $emeralds
        
                    //Upgrades
                    cookie.cursors = $cursors
                    cookie.villagers = $villagers
                    cookie.farms = $farms
                    cookie.mines = $mines
                    cookie.factories = $factories
        
                    //Click Gain
                    cookie.clickGain = $gain
        
                    //Auto Gain
                    cookie.autoGain = $autogain
        
                    //Upgrade Costs
                    cookie.cursorCost = $cursorCost
                    cookie.villagerCost = $villagerCost
                    cookie.farmCost = $farmCost
                    cookie.mineCost = $mineCost
                    cookie.factoryCost = $factoryCost
        
                    add("cursor")
                    work()
                    var interval = setInterval(work, 1000)
                }
            </script>`;
        }
    }
    