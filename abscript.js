//team member slide show
const sha = document.getElementById('teammTrack');
let types = Array.from(document.querySelectorAll('.teamm'));
const totalTypes = types.length / 2; // original types count
let index = 0;

// Move one slide
function moveSlide() {
  index++;
  sha.style.transition = 'transform 0.5s ease-in-out';
  sha.style.transform = `translateX(-${index * (100 / totalTypes)}%)`;

  // Reset for seamless infinite loop
  if (index >= totalTypes) {
    setTimeout(() => {
      sha.style.transition = 'none';
      index = 0;
      sha.style.transform = `translateX(0)`;
      void sha.offsetWidth; // force reflow
      sha.style.transition = 'transform 5s ease-in-out';
    }, 500);
  }
}

// Move one slide every 4 seconds
setInterval(moveSlide, 4000);