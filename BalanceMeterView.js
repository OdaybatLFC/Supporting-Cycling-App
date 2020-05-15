function BalanceMeterView() {

    var bar;
    var grad;

    this.startMeter = function () {
        bar = new  this.rectangle(177.5, 0, 180, 5, "black");
        grad = new this.canvasGradient(0, 0, 180, 360);
        Meter.init();
    };

    var Meter = {

        canvas : document.createElement("canvas"),
        init : function () {
            this.canvas.width = 360;
            this.canvas.height = 180 ;
            this.context = this.canvas.getContext("2d");
            document.body.insertBefore(this.canvas, document.body.childNodes[4]);
            this.interval = setInterval(updateMeter, 10);
            if (window.DeviceOrientationEvent){
                window.addEventListener("deviceorientation", moveBar);
            }
        },
        clear : function () {
            this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
        }
    };

    this.rectangle = function (x, y, height, width, color) {
        this.x = x;
        this.y = y;
        this.height = height;
        this.width = width;
        this.update = function () {
            var ctx = Meter.context;
            ctx.fillStyle = color;
            ctx.fillRect(this.x, this.y, this.width, this.height);
        };

        this.newPos = function () {
            this.x = bar.x;
        };
    };

    this.canvasGradient = function (x, y, height, width) {
        this.x = x;
        this.y = y;
        this.height = height;
        this.width = width;
        this.update = function () {
            var ctx = Meter.context;
            var grd = ctx.createLinearGradient(0, 0, 360, 0);
            grd.addColorStop(0, "red");
            grd.addColorStop(0.2, "orange");
            grd.addColorStop(0.4, "green");
            grd.addColorStop(0.6, "green");
            grd.addColorStop(0.8, "orange");
            grd.addColorStop(1, "red");
            ctx.fillStyle = grd;
            ctx.fillRect(this.x, this.y, this.width, this.height);
        };

    };


    function updateMeter() {

        Meter.clear();
        grad.update();
        bar.newPos();
        bar.update();

    }

    // function r0(x) {return Math.round(x);}

    function moveBar (event) {

        var g = event.gamma;
        // document.getElementById("orientData").innerHTML=" γ="+r0(g);

        if (g > 1 && g < 30) {
            bar.x = 177.5 + g*6;
        }
        else if (g < -1 && g > -30) {
            bar.x = 177.5 + g*6;
        }

    }
}