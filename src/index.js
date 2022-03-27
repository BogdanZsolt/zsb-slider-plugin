import {tns} from 'tiny-slider'
// import './index.scss'

const slider = tns({
  container: ".slides",
  mode: "gallery",
  items: 1,
  slideBy: "page",
  controls: false,
  nav: SLIDER_OPTIONS.controlNav,
  navPosition: "bottom",
  touch: true,
  speed: 400,
  autoplay: true,
  autoplayButtonOutput: false,
  autoplayPosition: "bottom",
  autoplayTimeout: 7000,
});