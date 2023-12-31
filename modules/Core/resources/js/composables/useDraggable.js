/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */
export function useDraggable() {
  const draggableOptions = {
    delay: 15,
    delayOnTouchOnly: true,
    animation: 0,
    disabled: false,
    ghostClass: 'drag-ghost',
  }

  const scrollableDraggableOptions = {
    scroll: true,
    scrollSpeed: 50,
    forceFallback: true,
    ...draggableOptions.value,
  }

  return { draggableOptions, scrollableDraggableOptions }
}
