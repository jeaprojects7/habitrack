document.addEventListener("DOMContentLoaded", function () {

    console.log("Reservations JS loaded");

    // ===== OPTIONAL: Auto-refresh button
    const refreshBtn = document.getElementById("refresh-reservations");

    if (refreshBtn) {
        refreshBtn.addEventListener("click", function () {
            location.reload();
        });
    }

    // ===== CARD CLICK REDIRECT
    const cards = document.querySelectorAll(".reservation-card");

    cards.forEach(card => {
        card.style.cursor = "pointer";

        card.addEventListener("click", function () {
            const id = this.getAttribute("data-id");

            if (id) {
                window.location.href = `index.php?route=reservation-view&id=${id}`;
            }
        });
    });

    // ===== ELEMENTS
    const searchInput = document.getElementById("reservation-search");
    const reservationCards = document.querySelectorAll(".reservation-card");
    const emptyState = document.querySelector("#empty-reservations");

    // ===== EMPTY STATE HANDLING
    if (reservationCards.length === 0 && emptyState) {
        emptyState.style.display = "block";
    }

    // ===== SEARCH FILTER (FIXED + CLEAN)
    if (searchInput) {
        searchInput.addEventListener("input", function () {
            const keyword = this.value.toLowerCase().trim();

            reservationCards.forEach(card => {
                const text = card.innerText.toLowerCase();

                if (text.includes(keyword)) {
                    card.style.display = "";
                } else {
                    card.style.display = "none";
                }
            });
        });
    }

    // document.querySelectorAll(".reservation-card").forEach(card => {
    //     card.style.cursor = "pointer";

    //     card.addEventListener("click", function () {
    //         const id = this.getAttribute("data-id");

    //         const form = document.createElement("form");
    //         form.method = "POST";
    //         form.action = "reservation-view";

    //         const input = document.createElement("input");
    //         input.type = "hidden";
    //         input.name = "reservationID";
    //         input.value = id;

    //         form.appendChild(input);
    //         document.body.appendChild(form);
    //         form.submit();
    //     });
    // });

    document.querySelectorAll(".reservation-card").forEach(card => {

        card.style.cursor = "pointer";

        card.addEventListener("click", function () {

            const id = this.getAttribute("data-id");

            const form = document.createElement("form");

            form.method = "POST";
            form.action = "reservation-view";

            const input = document.createElement("input");

            input.type = "hidden";
            input.name = "reservationID";
            input.value = id;

            form.appendChild(input);

            document.body.appendChild(form);

            form.submit();

        });

    });

});