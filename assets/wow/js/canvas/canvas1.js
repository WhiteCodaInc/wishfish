// Avoid `console` errors in browsers that lack a console.
(function() {
    var method;
    var noop = function () {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method = methods[length];

        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
}());

// Place any jQuery/helper plugins in here.




//this is for box canvas 1

// From Paul Irish' post: http://www.paulirish.com/2011/requestanimationframe-for-smart-animating/
// shim layer with setTimeout fallback
window.requestAnimFrame = (function(){
  return  window.requestAnimationFrame       ||
          window.webkitRequestAnimationFrame ||
          window.mozRequestAnimationFrame    ||
          function( callback ){
            window.setTimeout(callback, 1000 / 60);
          };
})();

// Vars
var canvas = document.getElementById('canvas'),
    ctx = canvas.getContext('2d'),    
    width = window.innerWidth,
    height = window.innerHeight,
    boxes = [],
    boxesIndex = 0,
    boxesNum = 1,
    centerY = height / 2,
    centerX = width / 2,
    timer = 0,
    TWO_PI = 2 * Math.PI,
    boxeSides = 120,
    row;

canvas.height = height;
canvas.width = width;
ctx.globalCompositeOperation = "multiply";

function Box(counter, rowTracker) {
    boxesIndex++;
    boxes[boxesIndex] = this;
    this.color = 'rgba(0, 0, 0, 0.1)';
    this.i = counter;
    this.size = boxeSides;
    this.halfSize = this.size/2;
    this.rowTracker = rowTracker;
}

Box.prototype.draw = function() {
    speed = (timer * .02);
    ctx.lineWidth = 2;
    ctx.fillStyle = this.color;
    ctx.save();
    ctx.translate((this.halfSize) + (this.i * this.size), (this.size * this.rowTracker) - (this.halfSize));
    ctx.rotate(speed);
    ctx.fillRect(-this.halfSize, -this.halfSize, this.size, this.size);
    ctx.restore();
}

function fillWin() {
    row = Math.floor(width/boxeSides) + 1;
    boxesNum = Math.floor(row * (height/boxeSides)) + row;
}

function createBox() {
    var rowTracker = 0,
        counter = 0;
    
    for(var i = 0; i < boxesNum; i++) {
        counter++;

        if(i%row === 0) {
            rowTracker++;
            counter = 0;
        }
        new Box(counter, rowTracker);
    }
}

// Keep track of time
function timeTrack() {
    timer++;
}

// rAF loop
function draw() {
    requestAnimFrame(draw);

    // Clear
    ctx.clearRect(0, 0, width, height);

    // Draw function
    for(var i in boxes) {        
        boxes[i].draw();
    }
    
    // Time tracker
    timeTrack();
};

// Init
fillWin();
createBox();
draw();


