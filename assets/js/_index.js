let gTick = 0;
let gGrid;

// General parameters.
const FPS = 12;
// Stop animation after 30 seconds.
const TICK_MAX = 30 * FPS;
const ROTATION_ANGLE = Math.PI / 128;
// Grid parameters.
let PIXEL_SIZE = 15;
// Boid parameters.
const MAX_N_OF_BOIDS = 15;
const MIN_N_OF_BOIDS = 8;
let N_OF_BOIDS = 10;
const PERCEPTION_RADIUS_SEPARATION = 50;
const PERCEPTION_RADIUS_COHESION = 30;
const PERCEPTION_RADIUS_ALIGNMENT = 20;
const MAX_SPEED = 5;
const MAX_FORCE = 1;
const N_NUDGE_DIVIDER = 100;
const MARGIN = 200;
const SEPARATION_MULTIPLIER = 2;
const COHESION_MULTIPLIER = 2;
const ALIGNMENT_MULTIPLIER = 2;
// Energy parameters.
const N_OF_PHASES = 16;
let ENERGY_RADIUS = 6;
let RADIUS = 120;
let SUB_RADIUS = 160;
let TOTAL_RADIUS_SQ = Math.pow(RADIUS + SUB_RADIUS, 2);
const RGB_COLORS = [
  [114, 150, 253], // Blue
  [207, 69, 112], // Red
  // [247, 138, 144], // Pink
];



const mapA =  wp_path + "/assets/images/top/animation/mapA.jpg";
const mapB =  wp_path + "/assets/images/top/animation/mapB.jpg";
const mapC =  wp_path + "/assets/images/top/animation/mapC.jpg";
const bg2 =  wp_path + "/assets/images/top/animation/background2.jpg";


// 公開時にはこちらのパスを適切に変更してください。
// 背景に使う地図画像ファイルへのパス。
const MAP_IMAGE_SRCS = [ mapA , mapB, mapC];
// ドットの色を表現した画像へのパス。
const BACKGROUND_IMAGE_SRC = bg2;
// アニメーションを描写したい<canvas>を挿入したいelementのid.
// E.g. <div id="heat-map"></div>
const CANVAS_ELEMENT_ID = "#heat-map";


/**
 * Generate params to setup the animation according to the canvas width and
 * height.
 * @param {number} width Canvas width.
 * @param {number} height Canvas height.
 * @returns {object} Generated parameters.
 */
function getParams(width, height) {
  const PIXEL_SIZE = 10;
  const ENERGY_RADIUS = PIXEL_SIZE / 2;

  return {
    PIXEL_SIZE,
    ENERGY_RADIUS,
  };
}

/**
 * Randomly selects an element from a.
 * @param {Array<type>} a
 * @returns One element from a.
 */
function randomSelector(a) {
  return a[Math.floor(Math.random() * a.length)];
}

// TODO: Remove after development.
function getEnergyToDotRatio(
  nW,
  nH,
  n_of_boids,
  radius,
  subRadius,
  pixelSize,
  margin
) {
  const marginInDots = margin / pixelSize;
  const nOfDots = (nW + marginInDots * 2) * (nH + marginInDots * 2);
  const activeRadius =
    radius * (1 / 2 + 1 / 4) + (subRadius * (1 / 2 + 1 / 4) * 1) / 2;
  const activeArea = activeRadius * activeRadius * Math.PI * n_of_boids;
  const activeAreaInPixel = activeArea / (pixelSize * pixelSize);
  const ratio = activeAreaInPixel / nOfDots;
  // console.log(`Active:All area ratio is ${ratio}`);
  // console.log(`Boid per dots: ${nOfDots / n_of_boids}`);
}

// TODO: Remove after development.
function RGBToColorString(rgb) {
  return `rgb(${rgb.join(",")})`;
}

/**
 * A simple vector implementation.
 */
class Vector {
  constructor(x, y) {
    this.x = x || 0;
    this.y = y || 0;
  }

  add(otherVec) {
    this.x += otherVec.x;
    this.y += otherVec.y;
  }

  sub(otherVec) {
    this.x -= otherVec.x;
    this.y -= otherVec.y;
  }

  div(scaler) {
    this.x /= scaler;
    this.y /= scaler;
  }

  mul(scaler) {
    this.x *= scaler;
    this.y *= scaler;
  }

  equal(otherVec) {
    return this.x == otherVec.x && this.y == otherVec.y;
  }

  mag() {
    return Math.sqrt(Math.pow(this.x, 2) + Math.pow(this.y, 2));
  }

  setMag(scaler) {
    this.unit();
    this.mul(scaler);
  }

  unit() {
    const mag = this.mag();
    this.div(mag);
  }

  limit(scaler) {
    const mag = this.mag();
    if (mag > scaler) {
      this.unit();
      this.mul(scaler);
    }
  }

  distTo(otherVec) {
    return Math.sqrt(
      Math.pow(this.x - otherVec.x, 2) + Math.pow(this.y - otherVec.y, 2)
    );
  }

  distToSq(otherVec) {
    return Math.pow(this.x - otherVec.x, 2) + Math.pow(this.y - otherVec.y, 2);
  }

  static sub(v1, v2) {
    return new Vector(v1.x - v2.x, v1.y - v2.y);
  }
}

class Boid {
  constructor(ctx) {
    this.ctx = ctx;
    this.position = new Vector(
      Math.random() * this.ctx.canvas.width,
      Math.random() * this.ctx.canvas.height
    );
    this.color = randomSelector(RGB_COLORS);
    this.velocity = new Vector(Math.random() - 0.5, Math.random() - 0.5);
    this.velocity.setMag(4);
    this.acceleration = new Vector();
    // TODO: `maxSpeed`, `nudge` can go into params.
    this.maxSpeed = MAX_SPEED;
    this.nudge = this.maxSpeed / N_NUDGE_DIVIDER;
    this.maxForce = MAX_FORCE;
    this.radius = Math.max(Math.random() + 0.2, 1) * RADIUS;
    this.subRadius = Math.max(Math.random() + 0.3, 1) * SUB_RADIUS;
    this.phaseOffset = Math.floor(Math.random() * N_OF_PHASES);
    this.multipier = 0;
    this.params = {};
  }

  align(boids) {
    let perceptionRadius = PERCEPTION_RADIUS_ALIGNMENT;
    let steering = new Vector();
    let total = 0;
    for (let other of boids) {
      // Only align to its "kind".
      if (other == this || this.color != other.color) continue;

      if (this.position.distTo(other.position) < perceptionRadius) {
        steering.add(other.velocity);
        total++;
      }
    }

    if (total > 0) {
      steering.div(total);
      steering.setMag(this.maxSpeed);
      steering.sub(this.velocity);
      steering.limit(this.maxForce);
    }
    return steering;
  }

  cohesion(boids) {
    let perceptionRadius = PERCEPTION_RADIUS_COHESION;
    let steering = new Vector();
    let total = 0;
    for (let other of boids) {
      // Only cohesion to its "kind".
      if (other == this || this.color != other.color) continue;

      if (
        this.position.distTo(other.position) < perceptionRadius &&
        this.color == other.color
      ) {
        steering.add(other.position);
        total++;
      }
    }

    if (total > 0) {
      steering.div(total);
      steering.sub(this.position);
      steering.setMag(this.maxSpeed);
      steering.sub(this.velocity);
      steering.limit(this.maxForce);
    }
    return steering;
  }

  separation(boids) {
    let perceptionRadius = PERCEPTION_RADIUS_SEPARATION;
    let steering = new Vector();
    let total = 0;
    for (let other of boids) {
      if (other == this) continue;

      let d = this.position.distTo(other.position);
      if (d < perceptionRadius) {
        let diff = Vector.sub(this.position, other.position);
        diff.div(d);
        steering.add(diff);
        total++;
      }
    }

    if (total > 0) {
      steering.div(total);
      steering.setMag(this.maxSpeed);
      steering.sub(this.velocity);
      steering.limit(this.maxForce);
    }
    return steering;
  }

  edge() {
    if (this.position.x < -MARGIN) {
      this.position.x = -MARGIN;
    }
    if (this.position.x > this.ctx.canvas.width + MARGIN) {
      this.position.x = this.ctx.canvas.width + MARGIN;
    }
    if (this.position.y < -MARGIN) {
      this.position.y = -MARGIN;
    }
    if (this.position.y > this.ctx.canvas.height + MARGIN) {
      this.position.y = this.ctx.canvas.height + MARGIN;
    }

    if (this.position.x < 0) {
      this.velocity.x += this.nudge;
    }
    if (this.position.x > this.ctx.canvas.width) {
      this.velocity.x -= this.nudge;
    }
    if (this.position.y < 0) {
      this.velocity.y += this.nudge;
    }
    if (this.position.y > this.ctx.canvas.height) {
      this.velocity.y -= this.nudge;
    }
  }

  flock(boids) {
    let alignment = this.align(boids);
    let cohesion = this.cohesion(boids);
    let separation = this.separation(boids);

    separation.mul(SEPARATION_MULTIPLIER);
    cohesion.mul(COHESION_MULTIPLIER);
    alignment.mul(ALIGNMENT_MULTIPLIER);

    this.acceleration.add(alignment);
    this.acceleration.add(cohesion);
    this.acceleration.add(separation);
  }

  updateMultiplier() {
    this.multipier = Math.sin(gTick / N_OF_PHASES + this.phaseOffset) / 2 + 0.5;
  }

  update() {
    this.position.add(this.velocity);
    this.velocity.add(this.acceleration);
    this.acceleration.mul(0);
    this.edge();
    this.velocity.limit(this.maxSpeed);
    this.updateMultiplier();
  }

  show() {
    this.ctx.beginPath();
    this.ctx.fillStyle = RGBToColorString(this.color);
    this.ctx.rect(this.position.x, this.position.y, 10, 10);
    this.ctx.fill();
  }
}

class Flock {
  constructor(ctx) {
    this.boids = [];
    this.ctx = ctx;
    console.log(`Initializing animation with ${N_OF_BOIDS} points.`);
    for (let i = 0; i < N_OF_BOIDS; i++) this.addBoid();
  }

  addBoid() {
    this.boids.push(new Boid(this.ctx));
  }

  show() {
    for (let boid of this.boids) boid.show();
  }

  update() {
    // First update acceleration of each boid.
    for (let boid of this.boids) boid.flock(this.boids);
    // Then apply the acceleration to each boid. It is important to do this in
    // two separate loops to not have an update to one boid affect the behaviour
    // of other boids in the same time frame.
    for (let boid of this.boids) boid.update();
  }
}

class Grid {
  constructor(ctx, dotSize, img, maps) {
    this.ctx = ctx;
    this.dots = [];
    this.img = img;
    this.maps = maps;
    this.flock = new Flock(ctx);

    this.width = ctx.canvas.width;
    this.height = ctx.canvas.height;

    // Get multiplier for image rotation.
    const minRadius =
      this.width > this.height ? this.height / 2 : this.width / 2;
    const maxRadius = Math.sqrt(
      Math.pow(this.width / 2, 2) + Math.pow(this.height / 2, 2)
    );

    this.imgScaleRatio = maxRadius / minRadius;

    this.dotSize = dotSize;
    this.nW = Math.floor(this.width / dotSize) + 1;
    this.nH = Math.floor(this.height / dotSize) + 1;

    // TODO: change name to dotSize. then dotSize to pixelSize;
    let halfDotSize = this.dotSize / 2;
    for (let i = 0; i < this.nH; i++) {
      for (let j = 0; j < this.nW; j++) {
        const x = j * this.dotSize + halfDotSize;
        const y = i * this.dotSize + halfDotSize;
        this.dots.push(new Vector(x, y));
      }
    }
    // console.log(`nH: ${this.nH}, nW: ${this.nW}`);
    // console.log(`Width: ${this.width}, Height: ${this.height}`);
    console.log(`Initializing Grid with ${this.dots.length} dots.`);
    // console.log(`Number of boids ${N_OF_BOIDS}`);
    getEnergyToDotRatio(
      this.nW,
      this.nH,
      N_OF_BOIDS,
      RADIUS,
      SUB_RADIUS,
      PIXEL_SIZE,
      MARGIN
    );
  }

  draw() {
    this.ctx.clearRect(0, 0, this.ctx.canvas.width, this.ctx.canvas.height);
    drawMapImageBackground(this.ctx, this.maps);

    this.ctx.save();
    this.ctx.beginPath();
    this.dots.forEach((dot) => {
      const dotSize = this.getRadius(dot);
      this.ctx.moveTo(dot.x, dot.y);
      this.ctx.arc(dot.x, dot.y, dotSize, 0, 2 * Math.PI);
    });
    this.ctx.clip();
    this.ctx.save();
    this.ctx.translate(this.ctx.canvas.width / 2, this.ctx.canvas.height / 2);
    this.ctx.rotate(ROTATION_ANGLE * gTick);
    this.ctx.drawImage(
      this.img,
      (-this.width / 2) * this.imgScaleRatio,
      (-this.height / 2) * this.imgScaleRatio,
      this.width * this.imgScaleRatio,
      this.height * this.imgScaleRatio
    );
    this.ctx.restore();
    this.ctx.restore();
    this.flock.update();
    // this.flock.show(this.ctx);
  }

  getRadius(dot) {
    let energies = [];

    this.flock.boids.forEach((b) => {
      let dSq = b.position.distToSq(dot);
      // Skip calculation if energy is going to be 0.
      if (dSq > TOTAL_RADIUS_SQ) return;
      let d = Math.sqrt(dSq);
      let energy = ENERGY_RADIUS * b.multipier;

      if (d < b.radius) {
        energies.push(energy);
      } else if (d < b.radius + b.subRadius) {
        let ratio = (b.subRadius - d + b.radius) / b.subRadius;
        energies.push(energy * ratio);
      }
    });

    let radius = Math.min(
      energies.reduce((p, c) => p + c, 0),
      ENERGY_RADIUS
    );

    return radius;
  }
}

function drawImageScaled(ctx, img) {
  var canvas = ctx.canvas;
  var hRatio = canvas.width / img.width;
  var vRatio = canvas.height / img.height;
  var ratio = Math.max(hRatio, vRatio);
  var centerShift_x = (canvas.width - img.width * ratio) / 2;
  var centerShift_y = (canvas.height - img.height * ratio) / 2;
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  ctx.drawImage(
    img,
    0,
    0,
    img.width,
    img.height,
    centerShift_x,
    centerShift_y,
    img.width * ratio,
    img.height * ratio
  );
}

function drawMapImageBackground(ctx, maps) {
  // Want fade cycle to happen every 6 seconds.
  ctx.save();
  // ctx.globalCompositeOperation = "multiply";
  const onePhaseInSec = 8;
  if (gTick % (onePhaseInSec * FPS) == 0) {
    maps.push(maps.shift());
  }
  let timeInSec = gTick / FPS;
  timeInSec = timeInSec % onePhaseInSec;
  let ratio = 1;
  if (timeInSec < 0.5) {
    // Fade in.
    ratio = timeInSec * 2;
  } else if (timeInSec > onePhaseInSec - 0.5) {
    // Fade out.
    ratio = (onePhaseInSec - timeInSec) * 2;
  }
  ctx.globalAlpha = ratio;
  drawImageScaled(ctx, maps[0]);
  ctx.restore();
}

function setNumberOfBoids(width, height, radius, subRadius, margin) {
  const wholeArea = (width + margin * 2) * (height + margin * 2);
  const activeRadius =
    radius * (1 / 2 + 1 / 4) + (subRadius * (1 / 2 + 1 / 4) * 1) / 2;
  const activeAreaTarget = wholeArea * 0.3; // Want 30% of area to be "active".
  let n_of_boids = activeAreaTarget / (activeRadius * activeRadius * Math.PI);
  n_of_boids = Math.min(Math.max(MIN_N_OF_BOIDS, n_of_boids), MAX_N_OF_BOIDS);
  N_OF_BOIDS = Math.floor(n_of_boids);
}

function setBoidRadius(width) {
  // Adjust RADIUS and SUB_RADIUS;
  if (width > 650) {
    RADIUS = 90;
    SUB_RADIUS = 100;
    TOTAL_RADIUS_SQ = Math.pow(RADIUS + SUB_RADIUS, 2);
  } else {
    RADIUS = 50;
    SUB_RADIUS = 100;
    TOTAL_RADIUS_SQ = Math.pow(RADIUS + SUB_RADIUS, 2);
  }
}

function setSizeOfPixel(width, height) {
  const area = width * height;
  if (width > 1600) {
    PIXEL_SIZE = 16;
    ENERGY_RADIUS = 7;
  } else if (width < 650) {
    PIXEL_SIZE = 12;
    ENERGY_RADIUS = 4;
  } else {
    PIXEL_SIZE = 14;
    ENERGY_RADIUS = 6;
  }
}

/* ---- script.js ---- */

document.addEventListener("DOMContentLoaded", initAnimation);
window.addEventListener("resize", initAnimation);

function initAnimation() {
  const targetEl = document.querySelector(CANVAS_ELEMENT_ID);
  const prevCanvasEl = document.querySelector("#animationCanvas");

  if (!targetEl) return null;

  if (prevCanvasEl) {
    gGrid = null;
    targetEl.removeChild(prevCanvasEl);
  }

  const img = new Image();
  img.src = BACKGROUND_IMAGE_SRC;

  const maps = MAP_IMAGE_SRCS.map((v) => {
    const img = new Image();
    img.src = v;
    return img;
  });

  const width = targetEl.clientWidth;
  const height = targetEl.clientHeight;
  const canvas = document.createElement("canvas");
  canvas.setAttribute("id", "animationCanvas");

  canvas.width = width;
  canvas.height = height;
  canvas.style.width = width + "px";
  canvas.style.height = height + "px";
  const ctx = canvas.getContext("2d");
  targetEl.appendChild(canvas);

  // Determine number of boids before initializing `Grid`.
  setNumberOfBoids(width, height, RADIUS, SUB_RADIUS, MARGIN);
  setBoidRadius(width);
  setSizeOfPixel(width, height);
  gGrid = new Grid(ctx, PIXEL_SIZE, img, maps);
  draw(gGrid);
}

function draw(grid) {
  if (grid != gGrid) return;

  gTick = gTick + 1;
  if (gTick > TICK_MAX) {
    console.log("Stopping animation.");
    return;
  }
  if (FPS != 0) {
    grid.draw();
  }

  setTimeout(() => {
    requestAnimationFrame(() => {
      draw(grid);
    });
  }, 1000 / FPS + 1);
}
