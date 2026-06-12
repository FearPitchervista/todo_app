// Functie om de modal (popup) te openen
// Zet de display van het element "taskModal" op "block" zodat het zichtbaar wordt

window.openModal = function() {
    document.getElementById("taskModal").style.display = "block";
}

// Functie om de modal (popup) te sluiten
// Zet de display van het element "taskModal" op "none" zodat het verborgen wordt
window.closeModal = function() {
    document.getElementById("taskModal").style.display = "none";
}

// Event dat checkt of er ergens op de pagina geklikt wordt
window.onclick = function (event) {
    let modal = document.getElementById("taskModal");

    // Als er op de achtergrond van de modal wordt geklikt
    // (dus niet op de inhoud zelf), sluit de modal
    if (event.target == modal) {
        modal.style.display = "none";
    }
};


// Variabele om bij te houden welke kaart momenteel wordt versleept

let draggedCard = null;

// Alle kaarten selecteren en drag-functionaliteit toevoegen
document.querySelectorAll('.card').forEach(card => {
 // Wanneer het slepen van een kaart start
    card.addEventListener('dragstart', function () {
        draggedCard = this;
        this.classList.add('dragging');
    });
// Wanneer het slepen stopt, de variabele resetten en de styling verwijderen
    card.addEventListener('dragend', function () {
        draggedCard = null;
        this.classList.remove('dragging');
    });
});


/* COLUMN DROP LOGIC (kolommen)
   Hier wordt geregeld wat er gebeurt als je een kaart in een kolom sleept*/
document.querySelectorAll('.column').forEach(column => {

    column.addEventListener('dragover', function (e) {
        e.preventDefault();
        this.classList.add('drag-over');
    });

    column.addEventListener('dragleave', function () {
        this.classList.remove('drag-over');
    });

    column.addEventListener('drop', function (e) {

        this.classList.remove('drag-over');

        if (!draggedCard) return;

        // juiste positie bepalen (tussen cards)
        let afterElement = getDragAfterElement(this, e.clientY);

        if (afterElement == null) {
            this.appendChild(draggedCard);
        } else {
            this.insertBefore(draggedCard, afterElement);
        }

        // status bepalen
        let newStatus = this.querySelector('h2').innerText.toLowerCase();
        let id = draggedCard.getAttribute('data-id');

        // database updaten via PHP
        fetch('update_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `id=${id}&status=${newStatus}`
        });
    });
});


/*
   HELPER: POSITIONING
   Bepaalt op welke plek een kaart moet worden ingevoegd tijdens het slepen
   (zodat cards netjes tussen andere cards geplaatst worden zoals in Trello)
*/

function getDragAfterElement(container, y) {
    const draggableElements = [...container.querySelectorAll('.card:not(.dragging)')];

    return draggableElements.reduce((closest, child) => {

        const box = child.getBoundingClientRect();
        const offset = y - box.top - box.height / 2;

        if (offset < 0 && offset > closest.offset) {
            return { offset: offset, element: child };
        } else {
            return closest;
        }

    }, { offset: Number.NEGATIVE_INFINITY }).element;
}