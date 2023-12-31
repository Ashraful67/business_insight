/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
import confetti from 'canvas-confetti'

const throwConfetti = function () {
  var confettiCanvas = document.createElement('canvas')

  confettiCanvas.classList.add(
    'absolute',
    'bottom-0',
    'w-full',
    'h-full',
    'confetti'
  )

  document.body.appendChild(confettiCanvas)

  var myConfetti = confetti.create(confettiCanvas, {
    resize: true,
  })

  myConfetti({
    particleCount: 300,
    spread: 300,
    ticks: 150,
    origin: {
      x: 1,
    },
  }).then(() => {
    const newCanvas = confettiCanvas.cloneNode(true)
    // Removed any event listeners
    confettiCanvas.replaceWith(newCanvas)
    confettiCanvas.remove()
    // Not sure if it's needed to remove?
    newCanvas.remove()
  })
}

export default throwConfetti
