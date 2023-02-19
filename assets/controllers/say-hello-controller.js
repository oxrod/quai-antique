import {Controller} from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ['date', 'output'];

    connect() {
        let shouldPreventChange = false;
        let isBookingPossible = false;

        let submitBtn = document.getElementById('booking_form_submit');
        submitBtn.setAttribute('disabled', 'disabled');

        let form = document.getElementById('booking_form');
        form.addEventListener('submit', function (e) {
            if (!isBookingPossible) {
                e.preventDefault();
            }
        })

        let timesElementInDom = document.getElementById('booking_form_time');
        timesElementInDom.textContent = 'Sélectionnez une date pour afficher les horaires de réservation possibles';

        this.element.addEventListener('change', async (e) => {
            if (e.type === 'change' && shouldPreventChange) {
                shouldPreventChange = false;
                return;
            }

            let data;

            let jqueryDate = $('#booking_form_date').val()
            if (!jqueryDate) {
                return;
            }
            timesElementInDom.textContent = 'Chargement...';
            const times = await fetch(`/booking/time/${jqueryDate}`).then(function (data) {
                return data.json();
            })
            data = times.data;
            let lunchData = data[0];
            let dinerData = data[1];
            timesElementInDom.replaceChildren();

            // Section header text 'Lunch or Diner
            let lunchText = document.createElement('h3');
            lunchText.textContent = 'Midi';
            timesElementInDom.appendChild(lunchText);

            // Create the div that will contain the input + label
            let lunchContainer = document.createElement('div');
            lunchContainer.setAttribute('id', 'lunchContainer');
            timesElementInDom.appendChild(lunchContainer);


            // LUNCH REMAINING GUEST LOGIC
            const remainingGuestCapacity = await fetch(`/booking/time/${jqueryDate}/remaining-capacity`).then(function (data) {
                return data.json();
            })
            let lunchCapacity = remainingGuestCapacity.data[0];
            let dinerCapacity = remainingGuestCapacity.data[1];

            let isOutOfLunchCapacity = lunchCapacity === 0;
            let isOutOfDinerCapacity = dinerCapacity === 0;

            let noInfoForLunchDate = -1;
            let noInfoForDinerDate = -1;
            if (isOutOfLunchCapacity && isOutOfDinerCapacity) {
                submitBtn.setAttribute('disabled', 'disabled');
                let text = document.createElement('p');
                text.textContent = 'Aucun horaire disponible pour ce jour, le restaurant est complet pour cette date';
                timesElementInDom.replaceChildren(text);
                isBookingPossible = false;
                return;
            }
            let cutleryInput = document.getElementById('booking_form_cutleryNumber');

            // FILL INPUTS FOR LUNCH
            let firstInput = true;
            for (let i = 0; i < lunchData.length; i++) {
                if (typeof (lunchData) === "string") {
                    let text = document.createElement('p');
                    text.textContent = lunchData;
                    lunchContainer.replaceChildren(text);
                    isBookingPossible = false;
                } else {
                    let input = document.createElement('input');
                    if (firstInput) {
                        input.setAttribute('checked', 'checked');
                        cutleryInput.setAttribute('max', lunchCapacity);
                        firstInput = false;
                    }
                    if (isOutOfLunchCapacity) {
                        input.setAttribute('disabled', 'disabled');
                    }
                    input.setAttribute('type', 'radio');
                    input.setAttribute('class', 'time-btn');
                    input.setAttribute('required', 'required');
                    input.setAttribute('name', 'booking_form[time]');
                    input.setAttribute('value', lunchData[i]);
                    input.setAttribute('id', 'booking_form_time_' + i);
                    input.addEventListener('change', function () {
                        console.log('Lunch value selected');
                        cutleryInput.setAttribute('max', lunchCapacity);
                    });
                    let label = document.createElement('label');
                    label.setAttribute('for', 'booking_form_time_' + i);
                    label.textContent = lunchData[i];
                    label.addEventListener('mousedown', () => shouldPreventChange = true)
                    lunchContainer.appendChild(input);
                    lunchContainer.appendChild(label);
                    isBookingPossible = true;
                    submitBtn.removeAttribute('disabled');
                }
            }

            if (!noInfoForLunchDate) {
                let remainingBookingsLunchText = document.createElement('p');
                remainingBookingsLunchText.textContent = 'Places libres : ' + lunchCapacity;
                lunchContainer.appendChild(remainingBookingsLunchText);
            }

            // Section header text 'Lunch or Diner
            let dinerText = document.createElement('h3');
            dinerText.textContent = 'Soir';
            timesElementInDom.appendChild(dinerText);

            // Create the div that will contain the input + label
            let dinerContainer = document.createElement('div');
            timesElementInDom.appendChild(dinerContainer);

            // FILL INPUTS FOR DINER
            for (let i = 0; i < dinerData.length; i++) {
                if (typeof (dinerData) === "string") {
                    let text = document.createElement('p');
                    text.textContent = dinerData;
                    dinerContainer.replaceChildren(text);
                } else {
                    // Create the input and set attributes
                    let input = document.createElement('input');

                    // Make the first attribute checked by default to avoid form submission errors
                    if (firstInput) {
                        input.setAttribute('checked', 'checked');
                        firstInput = false;
                    }
                    if (isOutOfDinerCapacity) {
                        input.setAttribute('disabled', 'disabled');
                    }
                    input.setAttribute('type', 'radio');
                    input.setAttribute('class', 'time-btn');
                    input.setAttribute('required', 'required');
                    input.setAttribute('name', 'booking_form[time]');
                    input.setAttribute('value', dinerData[i]);
                    input.setAttribute('id', 'booking_form_time_2' + i);

                    input.addEventListener('change', function () {
                        cutleryInput.setAttribute('max', dinerCapacity);
                    });
                    // Create label and its attributes
                    let label = document.createElement('label');
                    label.setAttribute('for', 'booking_form_time_2' + i);
                    label.textContent = dinerData[i];
                    // Add event listener to avoid refreshing the inputs when selecting one
                    label.addEventListener('mousedown', () => shouldPreventChange = true)

                    // Connect everything together
                    dinerContainer.appendChild(input);
                    dinerContainer.appendChild(label);
                }
            }

            if (!noInfoForDinerDate) {
                let remainingBookingsDinerText = document.createElement('p');
                remainingBookingsDinerText.textContent = 'Places libres : ' + dinerCapacity;
                dinerContainer.appendChild(remainingBookingsDinerText);
            }
        })
    }
}