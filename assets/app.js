/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

import '@fortawesome/fontawesome-free/css/all.css';

import { Loader } from "@googlemaps/js-api-loader"

import { gsap } from 'gsap';

import Swal from 'sweetalert2';

import jquery from 'jquery';
const $ = require('jquery');
global.$ = global.jQuery = $;

 
import { Tooltip, Toast, Popover } from 'bootstrap';

// start the Stimulus application
import './bootstrap';


// Toggle
$(document).ready(function() {
  $('.navbar-toggler').click(function() {
    $('.navbar-collapse').collapse('toggle');
  });
});

// GOOGLE MAP
function initMap() {
  // Coordonnées du lieu
  var addressLatLng = {lat: 45.5664, lng: 5.9210}; // Coordonnées de l'adresse

  // Options de la carte
  var mapOptions = {
    zoom: 14,
    center: addressLatLng
  };

  // Création de la carte
  var map = new google.maps.Map(document.getElementById('map'), mapOptions);

  // Marqueur sur la carte

  var marker = new google.maps.Marker({
    position: addressLatLng,
    map: map,
    title: "2 Rue Favre, Chambéry"
  });
}


// Appel de la fonction initMap une fois la page chargée
window.onload = initMap;


// Animation Texte

const jumbotron = document.querySelector('.jumbotron');
const title = jumbotron.querySelector('h1');
const lead1 = jumbotron.querySelector('.lead:nth-child(2)');
const lead2 = jumbotron.querySelector('.lead:nth-child(3)');

gsap.fromTo(jumbotron, { opacity: 0, y: 50 }, { opacity: 1, y: 0, duration: 1, ease: 'power4.out' });
gsap.fromTo(title, { opacity: 0, y: -30 }, { opacity: 1, y: 0, duration: 1, delay: 0.3, ease: 'power4.out' });
gsap.fromTo(lead1, { opacity: 0, x: -50 }, { opacity: 1, x: 0, duration: 1, delay: 0.6, ease: 'power4.out' });
gsap.fromTo(lead2, { opacity: 0, x: 50 }, { opacity: 1, x: 0, duration: 1, delay: 0.9, ease: 'power4.out' });

// 
