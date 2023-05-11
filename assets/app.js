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







const bookingForm = document.getElementById('booking-form');

// Ajout d'un listener sur l'événement "submit" du formulaire
bookingForm.addEventListener('submit', function(event) {
  event.preventDefault();

  const formData = new FormData(bookingForm);

  // Envoi d'une requête AJAX pour vérifier la disponibilité et soumettre la réservation
  Promise.all([
    fetch('/reservation/disponibilite', {
      method: 'POST',
      body: formData
    }),
    fetch('/reservation/submit', {
      method: 'POST',
      body: formData
    })
  ])
  .then(responses => Promise.all(responses.map(response => response.json())))
  .then(data => {
    const disponibiliteData = data[0];
    const reservationData = data[1];

    if (disponibiliteData.disponibilite) {
      alert('Des tables sont disponibles pour cette date et cette heure !');
    } else {
      alert('Désolé, il n\'y a plus de tables disponibles pour cette date et cette heure.');
    }

    if (reservationData.status === 'success') {
      alert('Votre réservation a été enregistrée.');
    } else {
      alert('Erreur lors de la réservation.');
    }
  })
  .catch(error => {
    console.error(error);
    alert('Une erreur est survenue lors de la réservation.');
  });
});


$(document).ready(function() {
  $('.navbar-toggler').click(function() {
    $('.navbar-collapse').collapse('toggle');
  });
});