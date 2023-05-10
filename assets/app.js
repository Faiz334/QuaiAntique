/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

import '@fortawesome/fontawesome-free/css/all.css';


import jquery from 'jquery';
const $ = require('jquery');
global.$ = global.jQuery = $;

 
import { Tooltip, Toast, Popover } from 'bootstrap';

// start the Stimulus application
import './bootstrap';







// Récupération de l'élément HTML du formulaire de réservation
const bookingForm = document.getElementById('booking-form');

// Ajout d'un listener sur l'événement "submit" du formulaire
bookingForm.addEventListener('submit', function(event) {
  // Empêcher le comportement par défaut de l'événement "submit"
  event.preventDefault();

  // Récupération des données du formulaire
  const formData = new FormData(bookingForm);

  // Envoi d'une requête AJAX au serveur
  fetch('/reservation/disponibilite', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    // Mise à jour de l'interface utilisateur en fonction de la réponse JSON
    if (data.disponible) {
      alert('Des tables sont disponibles pour cette date et cette heure !');
    } else {
      alert('Désolé, il n\'y a plus de tables disponibles pour cette date et cette heure.');
    }
  })
  .catch(error => console.error(error));
});


$(document).ready(function() {
  $('.navbar-toggler').click(function() {
    $('.navbar-collapse').collapse('toggle');
  });
});