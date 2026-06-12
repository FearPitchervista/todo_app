let draggedCard = null;

/* =========================
   CARD DRAG START / END
========================= */
document.querySelectorAll('.card').forEach(card => {

    card.addEventListener('dragstart', function () {
        draggedCard = this;
        this.classList.add('dragging');
    });

    card.addEventListener('dragend', function () {
        draggedCard = null;
        this.classList.remove('dragging');
    });
});


/* =========================
   COLUMN DROP LOGIC
========================= */
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

        // 👉 juiste positie bepalen (tussen cards)
        let afterElement = getDragAfterElement(this, e.clientY);

        if (afterElement == null) {
            this.appendChild(draggedCard);
        } else {
            this.insertBefore(draggedCard, afterElement);
        }

        // status bepalen
        let newStatus = this.querySelector('h2').innerText.toLowerCase();
        let id = draggedCard.getAttribute('data-id');

        // database update
        fetch('update_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `id=${id}&status=${newStatus}`
        });
    });
});


/* =========================
   HELPER: POSITIONING
========================= */
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