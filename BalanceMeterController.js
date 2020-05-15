"use strict";
/*globals BreakoutView, BreakoutModel*/

var balanceMeterView = new BalanceMeterView(),
    balanceMeterController = null;

function BalanceMeterController () {

    this.init = function() {
        balanceMeterView.startMeter();
    };

}

balanceMeterController = new BalanceMeterController();
window.addEventListener("load", balanceMeterController.init);