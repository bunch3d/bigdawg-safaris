/* ==========================================================================
   CONTACT.JS
   contact.php has no server-side handler on purpose — booking stays a
   WhatsApp deep link. This script's only job is turning the form fields
   into a readable pre-filled WhatsApp message.
   ========================================================================== */

var WHATSAPP_NUMBER = '254797640039'; // no "+" or spaces, as wa.me expects

document.addEventListener('DOMContentLoaded', function () {
  var form = document.getElementById('bookingForm');
  if (!form) return;

  form.addEventListener('submit', function (e) {
    e.preventDefault(); // we're not posting anywhere — just redirecting to WhatsApp
    var message = buildWhatsAppMessage(form);
    var url = 'https://wa.me/' + WHATSAPP_NUMBER + '?text=' + encodeURIComponent(message);
    window.open(url, '_blank', 'noopener');
  });
});

/**
 * buildWhatsAppMessage(form)
 * Reads every field on the booking form and formats it into one
 * readable message, skipping fields the visitor left blank so the
 * message doesn't end up cluttered with empty lines.
 */
function buildWhatsAppMessage(form) {
  var data = new FormData(form);
  var lines = ['Hello Big Dawg Safaris! I would like to plan a Kenya safari.', ''];

  var fieldLabels = {
    fullName: 'Name',
    phone: 'WhatsApp/Phone',
    country: 'Country',
    travelDate: 'Travel date',
    travellers: 'Travellers',
    experience: 'Experience',
    language: 'Preferred language',
    journey: 'Journey',
    accommodation: 'Accommodation',
    notes: 'Special requests',
  };

  Object.keys(fieldLabels).forEach(function (fieldName) {
    var value = (data.get(fieldName) || '').toString().trim();
    if (value !== '') {
      lines.push(fieldLabels[fieldName] + ': ' + value);
    }
  });

  return lines.join('\n');
}
